<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

function sendResponse(array $data) {
    header('Content-type: text/json;charset=utf-8');
    echo json_encode($data);
    exit;
}

function sendMessage($message) {
    sendResponse(array('msg' => $message));
}

function sendEmail(JMail $mailer) {
    ob_start();
    $result = $mailer->Send();
    $msg = ob_get_contents();
    ob_end_clean();
    if (empty($msg)) {
        return $result;
    } else {
        if ($result instanceof JError) {
            return $result;
        } else {
            return JError::raiseNotice(500, trim($msg));
        }
    }
}

$mainframe = JFactory::getApplication();

$_o = JRequest::getString('o', '', 'post');
$_uname = JRequest::getString('uname', '', 'post');
$_uphone = JRequest::getString('uphone', '', 'post');
$_uemail = JRequest::getString('uemail', '', 'post');
$_uaddress = JRequest::getString('uaddress', '', 'post');
$_unote = JRequest::getString('unote', '', 'post');

if (!($_o > '')
	or !($_uname > '')
	or !($_uphone > '')
	) sendMessage(JText::sprintf('ERROR ON ORDER SENDING',100));


# --------------------------------
# START - ordered items processing

# format: I,1,2,1; : Item/Topping, (basketId)=csoportképzés, darab, T/I ID.
# 1. tombot csinalunk a param.str-bol
if (substr($_o,-1)==';') $_o = substr($_o,0,strlen($_o)-1);
$orderedItems = explode(';',$_o);
$tx = 0; // Topping jeloles melle kerulo Seged az indexeleshez
$errDb = false;
foreach ($orderedItems as $oneItem) {
	$oneItem = explode(',',$oneItem);
	$sortedArray[$oneItem[1]][$oneItem[0].$tx]["id"] = $oneItem[3];
	$sortedArray[$oneItem[1]][$oneItem[0].$tx]["db"] = $oneItem[2];
	if (!strcmp(($oneItem[2]*1), $oneItem[2]) == 0
		or ($oneItem[2]=='0')) $errDb = true;
	$tx++;
}
if ($errDb) sendMessage(JText::sprintf('ERROR ON ORDER SENDING - INVALID COUNT',100));

# 2. rendezzuk az osszeallitott tombot, igy mindegy lesz a kapott tetelek sorrendje
require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'functions.php');
deep_ksort($sortedArray);
# END - ordered items processing
# ------------------------------


$db		= & JFactory::getDBO();
$user =& JFactory::getUser(); # user_id nem kotelezo, de ha van, akkor eltaroljuk
$_uid = $user->get('id');

$xid = 0;

# ha nincs user_id, de email alapjan meghatarozhato, akkor ahhoz a userhez mentjuk
if (!($_uid > 0)) {
	$query = sprintf("SELECT id FROM #__users WHERE email = %s", $db->quote($_uemail));
	$db->setQuery( $query );
	$_uid = $db->loadResult();

	# ha email cim alapjan koraban regisztralt user -> viszakuldjuk az id-t mert azzal vezereljuk a regisztraciora valo felhivast
	$xid = $_uid;
}

# settings
require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'smartorder.php');
$model = new SmartorderModelSmartorder();
$settings = $model->getSettings();

$query	= sprintf(
    "INSERT INTO `#__smartorder_orders`
        (`datetime`, `user_id`, `user_name`, `user_email`, `user_address`, `user_phone`, `user_note`)
    VALUES
        (NOW(), %s, %s, %s, %s, %s, %s)",
    $_uid > 0 ? $_uid : 'null',
    $db->quote($_uname),
    $db->quote($_uemail),
    $db->quote($_uaddress),
    $db->quote($_uphone),
    $db->quote($_unote)
);

$db->setQuery($query);
if (!$db->query()) {
	sendMessage(JText::sprintf('ERROR ON ORDER SENDING', 200));
} else {

	if ($settings[0]->vat_handling == '1') {
		$vatExpr = sprintf("IF(vat_percent IS NULL,%s,vat_percent)", $db->quote($settings[0]->vat_default_percent));
	} else {
		$vatExpr = "'0'";
	}

	if ($db->getAffectedRows()) {
		$ORDER_ID = $db->insertid();
		if ($ORDER_ID > 0) {

			# 3. osszeallitjuk az insert stringet
			foreach ($sortedArray as $oneBasketId => $oneBasketContent) {
				foreach ($oneBasketContent as $oneItemType => $oneItem) {
					$oneItemType = strtolower(substr($oneItemType, 0, 1));
					if ($oneItemType != 'i' && $oneItemType != 't') {
	                    sendMessage(JText::sprintf('ERROR ON ORDER SENDING', 200));
					}
					$query = sprintf(
					        "INSERT INTO #__smartorder_orders_details
								(`order_id`, `basketgroup`, `type`, `count`, `name`, `price`, `discount_price`, `category_name`, `vat_percent`)
							SELECT %d, %d, %s, %d, x.name, price, discount_price, cat.name, %s
							FROM #__smartorder_%s x
							JOIN #__smartorder_categories cat ON cat_id = cat.id
							WHERE x.id = %d",
					        $ORDER_ID,
					        intval($oneBasketId),
					        $db->quote($oneItemType),
					        intval($oneItem["db"]),
					        $vatExpr,
					        $oneItemType == 'i' ? 'items' : 'toppings',
					        intval($oneItem["id"]));
					$db->setQuery($query);
					$db->query();
				}
			}

			# adatok SESSION-be a regisztracios urlap miatt
			if (!($_uid > 0)) {
				# ha nincs belepve
				$session = JFactory::getSession();
				$session->set('ordName', $_uname);
				$session->set('ordAddress', $_uaddress);
				$session->set('ordEmail', $_uemail);
				$session->set('ordPhone', $_uphone);
			}

			$app =& JFactory::getApplication();
			$template = $app->getTemplate();
			if ($template=='smartordermobil') {
				setcookie("so_order_name", $_uname, time()+60*60*24*30 );
				setcookie("so_order_address", $_uaddress, time()+60*60*24*30 );
				setcookie("so_order_email", $_uemail, time()+60*60*24*30 );
				setcookie("so_order_phone", $_uphone, time()+60*60*24*30 );
			}

			# #############################################
			# mail sending                              ###
			$config =& JFactory::getConfig();
			$sender = array(
				$config->get( 'mailfrom' ),
				$config->get( 'fromname' ));
			#
			# lista összeállítása
			$query = sprintf("SELECT * FROM #__smartorder_orders_details
						WHERE order_id = %d
						ORDER BY basketgroup, id ", $ORDER_ID);
			$db->setQuery($query);
			$rows = $db->loadAssocList();
			#
			$lista = '';
			$totalInEmail=0;

			foreach ( $rows as $row ) {

				// Ha topping, akkor adunk elé egy kis indentáló space-t és kacsacsőrt
				$price = getGrossPrice($row,$settings[0]);
				if ($row["type"] == 't') {
					$lista .= '   > '.$row["count"].JText::_('PCS').' '.$row["name"].' ('.JText::_('TOPPING').'): '.$row["count"].' x '.getFormattedPrice($price,$settings[0])."\n";
				} else {
					$lista .= $row["count"].JText::_('PCS').' '.$row["name"].' ('.$row["category_name"].'): '.$row["count"].' x '.getFormattedPrice($price,$settings[0])."\n";
				}
				$totalInEmail += $price*$row["count"];
			}

			$warningUser = '';
			$warningAdmin = '';
			if (isset($_POST['paymentmethod']) && $_POST['paymentmethod'] != 'payondelivery') {
				$warningUser = "\n\n".JText::_('PAYMENT WARNING USER')."\n\n";
				$warningAdmin = "\n\n".JText::_('PAYMENT WARNING ADMIN')."\n\n";
			}

			if (isset($_POST['paymentmethod'])) {
				switch ($_POST['paymentmethod']) {
					case 'paypal':
						$paymentTypeStr = JText::_('PAYMENT TYPE PAYPAL');
						break;
					case 'payondelivery':
					default:
						$paymentTypeStr = JText::_('PAYMENT TYPE PAY ON DELIVERY');
				}
			} else {
				$paymentTypeStr = JText::_('PAYMENT TYPE PAY ON DELIVERY');
			}

			// Get and calculate the shipping cost and make a etxt from it
			$shipCost = $settings[0]->shipping_cost;
			$freeShipLimit = $settings[0]->free_shipping_limit;
			$totalTotal=$totalInEmail+$shipCost;
			if (($freeShipLimit>$totalInEmail)or(($freeShipLimit==0) and( $shipCost>0 ))) {
				$db->setQuery(sprintf('UPDATE #__smartorder_orders SET shipping_costs = %s WHERE id = %d', $db->quote($shipCost), $ORDER_ID));
				$db->query();
				// Has shipping cost
				$totalTextInEmail=JText::_('TOTAL').getFormattedPrice($totalInEmail,$settings[0]).' +'.getFormattedPrice($shipCost,$settings[0]).' '.JText::_('SHIPPING FEE').' = '.getFormattedPrice($totalTotal,$settings[0]);
			}else{
				// No shipping cost
				$totalTextInEmail=JText::_('TOTAL').getFormattedPrice($totalInEmail,$settings[0]);
			}


			#
			# to user: $_uemail
			$mailer = JFactory::getMailer();
			$mailer->setSender($sender);
			$mailer->addRecipient($_uemail);
			$mailer->setSubject(JText::_('ORDER EMAIL USER SUBJECT'));
			$mailer->setBody(JText::sprintf('ORDER EMAIL USER MESSAGE',$_uname,$paymentTypeStr,$lista.$warningUser,$totalTextInEmail,$_uname,$_uaddress,$_uphone,$_uemail,$_unote));
			$result = sendEmail($mailer);
			if ($result instanceof Exception) {
	            sendMessage($result->getMessage());
			}

			#
			# to provider
			$mailer = JFactory::getMailer();
			$mailer->setSender($sender);
			$mailer->addRecipient($sender[0], $sender[1]);
			$mailer->setSubject(JText::_('ORDER EMAIL ADMIN SUBJECT'));
			$mailer->setBody(JText::sprintf('ORDER EMAIL ADMIN MESSAGE',$_uname,$paymentTypeStr,$lista.$warningAdmin,$totalTextInEmail,$_uname,$_uaddress,$_uphone,$_uemail,$_unote));
			$result = sendEmail($mailer);
			if ($result instanceof Exception) {
	            sendMessage($result->getMessage());
			}

			#
			# end of mail sending                       ###
			# #############################################

			$response = array(
					'msg' => '#OK#_'.(($xid > 0) ? $xid : '0')
			);

			if (isset($_POST['paymentmethod'])) {
				switch ($_POST['paymentmethod']) {
					case 'paypal':
						require_once JPATH_BASE.'/components/com_smartorder/paypal/PayPal.php';
						require_once JPATH_BASE.'/components/com_smartorder/paypal/CartSubmitter.php';
						require_once JPATH_BASE.'/components/com_smartorder/paypal/Order.php';
						require_once JPATH_BASE.'/components/com_smartorder/paypal/OrderDetail.php';
						require_once JPATH_BASE.'/components/com_smartorder/paypal/OrderStatus.php';
						require_once JPATH_BASE.'/components/com_smartorder/paypal/PayPalSettings.php';
						$settings = PayPalSettings::load();
						$order = Order::load($ORDER_ID);
						$order->updateStatus($settings->getOrderStatusPending());
						$cartSubmitter = new CartSubmitter($settings, $order);
						$cartSubmitter->setIpnUrl(JURI::base().'components/com_smartorder/paypal/ipn_listener.php');
						$cart = addcslashes($cartSubmitter->getForm('PayPalForm'), "'");
						$response['showFeedback'] = false;
						$response['eval'] = "jQuery('#PayPalForm').remove();jQuery('body').append('".$cart."');jQuery('#PayPalForm').submit();";
						break;
					case 'payondelivery':
					default:
						$response['showFeedback'] = true;
				}
			}

			sendResponse($response);
		} else {
			sendMessage(JText::sprintf('ERROR ON ORDER SENDING', 300));
		}
	} else {
		sendMessage(JText::sprintf('ERROR ON ORDER SENDING', 400));
	}
}

$mainframe->close();