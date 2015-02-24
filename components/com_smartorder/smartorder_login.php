<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */


$user =& JFactory::getUser();
$_uid = $user->get('id');

if ($_uid > 0) {
    die(JText::_('You are logged in'));
}

$msg = '';

if (isset($_REQUEST["email"])) {

	$result = JFactory::getApplication()->login(array(
	        'username'=>JRequest::getVar('email'),
	        'password'=>JRequest::getVar('password')));

    if (!$result) {
        $msg = JText::_('LOGINERROR');
    }

    $user =& JFactory::getUser();
    $_uid = $user->get('id');
    if ($_uid > 0) {
        $db	= & JFactory::getDBO();
        $db->setQuery(sprintf('SELECT * FROM #__smartorder_users WHERE id = %d', intval($_uid)));
        $so_user_data = $db->loadObject();
        ?>
        <script>
        <?php
		//Actual URL FOR the actual page
		 $uri = & JFactory::getURI();
		 $pageURL = $uri->toString();
		?>
        if (parent.jQuery("#shipcost").length) {
            if (parent.jQuery(this).createOutput() > '') {
                // parent site is orderform -> not reload
                parent.jQuery("#so-contact-1").val('<?php echo $user->get('name') ?>');
                parent.jQuery("#so-contact-2").val('<?php echo empty($so_user_data->address) ? '' : $so_user_data->address ?>');
                parent.jQuery("#so-contact-3").val('<?php echo empty($so_user_data->phone) ? '' : $so_user_data->phone ?>');
                parent.jQuery("#so-contact-4").val('<?php echo $user->get('email') ?>');
                parent.jQuery(".so-thank-text-reginfo").html('');
                <?php
                $returnURL = base64_encode('/');
                jimport('joomla.version');
                $version = new JVersion();
                if (substr($version->getShortVersion(),0,3)=='1.5')
                    $logoutBtn = '<a href="index.php?option=com_user&task=logout&return='.$returnURL.'" class="sm-button sm-green sm-logout"><span>'.JText::_('SO LOGOUT BTN').'</span></a>';
                else {
                    $logoutBtn = '<a href="'.JRoute::_('index.php?option=com_users&task=user.logout&'.JSession::getFormToken().'=1&return='.$returnURL).'" class="sm-button sm-green sm-logout"><span>'.JText::_('SO LOGOUT BTN').'</span></a>';
                }
                ?>
                parent.jQuery("#sm-transparent-ear").html('<div class="sm-loggedin"><div class="sm-loggedin-indicator"></div><div class="sm-loggedin-text"><?php echo JText::_('LOGGED IN') ?>&nbsp;<?php echo $user->get('name'); ?></div></div><?php echo $logoutBtn ?>');
                parent.jQuery.fn.colorbox.close();
            }
            else {
                parent.jQuery.fn.colorbox.close();
				parent.location.reload();
                //parent.location.href = 'index.php';
            }
        } else {
            // parent site isn't orderform -> go to index.php
            parent.jQuery.fn.colorbox.close();
			parent.location.reload();
            //parent.location.href = 'index.php';
        }
        </script>
        <?php
        exit;
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?php echo JURI::base(true).'/templates/'.$mainframe->getTemplate().'/css/joomlabase.css'; ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo JURI::base(true).'/templates/'.$mainframe->getTemplate().'/css/template.css'; ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo JURI::base(true).'/modules/mod_smartlogin/mod_smartlogin.css'; ?>" type="text/css" />
<script>
    function lostPass(){parent.jQuery.fn.colorbox.close();parent.location.href = '<?php echo JURI::base(true); ?>/index.php?option=com_users&view=reset';}
    function registration(){parent.jQuery.fn.colorbox.close();parent.location.href = 'index.php?option=com_smartorder&task=registration';}
</script>
</head>
<body style="text-align:center">
    <div class="errLogin"><?php echo $msg ?></div>
    <form name="frmLogin" class="clrboxLogin" action="index.php">
    <input type="hidden" name="option" value="com_smartorder" />
    <input type="hidden" name="task" value="login" />
    <table class="clrboxLogin" align="center" border="0">
        <tr>
            <td><?php echo JText::_('email') ?></td>
            <td><input type="text" name="email" class="inputbox" value="<?php echo htmlspecialchars(JRequest::getVar('email')) ?>"/></td>
        </tr>
        <tr>
            <td><?php echo JText::_('password')?>:</td>
            <td><input type="password" name="password" class="inputbox"/></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><a href="javascript:;" onclick="document.frmLogin.submit();" class="sm-button sm-green" ><span><?php echo JText::_('SO LOGIN')?></span></a></td>
        </tr>
    </table>
    </form>
    <br />
    <a href="javascript:;" onclick="registration()"><?php echo JText::_('Registration')?></a> |
    <a href="javascript:;" onclick="lostPass()"><?php echo JText::_('Lost password')?></a>
</body>
</html>