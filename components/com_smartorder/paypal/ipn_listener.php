<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

if (empty($_POST)) {
    exit;
}

define('_JEXEC', 1);
define('JPATH_BASE', dirname(dirname(dirname(dirname(__FILE__)))));

require_once JPATH_BASE.'/includes/defines.php';
require_once JPATH_BASE.'/includes/framework.php';

$app = JFactory::getApplication('site');
$app->initialise();

require_once JPATH_BASE.'/components/com_smartorder/paypal/PayPal.php';
require_once JPATH_BASE.'/components/com_smartorder/paypal/CartSubmitter.php';
require_once JPATH_BASE.'/components/com_smartorder/paypal/Order.php';
require_once JPATH_BASE.'/components/com_smartorder/paypal/OrderDetail.php';
require_once JPATH_BASE.'/components/com_smartorder/paypal/OrderStatus.php';
require_once JPATH_BASE.'/components/com_smartorder/paypal/PayPalSettings.php';
require_once JPATH_BASE.'/components/com_smartorder/paypal/InstantPaymentNotification.php';

function getMailerInstance($addCopy = false) {
    $config = JFactory::getConfig();
    $sender = array(
        $config->get('config.mailfrom'),
        $config->get('config.fromname')
    );
    $mailer = JFactory::getMailer();
    $mailer->setSender($sender);
    if ($addCopy) {
        $mailer->addRecipient($config->get('config.mailfrom'), $config->get('config.fromname'));
    }
    return $mailer;
}

try {
    JFactory::getLanguage()->load('com_smartorder', JPATH_BASE.'/components/com_smartorder');

    $libraryPath = realpath(dirname(__FILE__).'/libraries');
    set_include_path($libraryPath.PATH_SEPARATOR.get_include_path());
    require_once $libraryPath.'/Zend/Loader/Autoloader.php';
    Zend_Loader_Autoloader::getInstance();

    $settings = PayPalSettings::load();

    $notification = new InstantPaymentNotification();
    $notification->init();
    $notification->approve($settings);

    $order = $notification->getOrder();

    switch ($notification->getStatus()) {
        case InstantPaymentNotification::STATUS_PENDING:
        case InstantPaymentNotification::STATUS_VERIFIED:
            $order->updateStatus($settings->getOrderStatusPending());
            break;
        case InstantPaymentNotification::STATUS_INVALID:
        case InstantPaymentNotification::STATUS_FRAUD:
            $order->updateStatus($settings->getOrderStatusFailed());
            if ($settings->isMailToBuyer()) {
                $mailer = getMailerInstance();
                $mailer->addRecipient($order->getUserEmail());
                $mailer->setSubject(JText::sprintf('PAYMENT FAILED EMAIL USER SUBJECT', $order->getUserName(), $order->getId()));
                $mailer->setBody(JText::sprintf('PAYMENT FAILED EMAIL USER MESSAGE', $order->getUserName(), $order->getId()));
                $mailer->Send();
            }
            if ($settings->isMailToMerchant()) {
                $mailer = getMailerInstance(true);
                $mailer->setSubject(JText::sprintf('PAYMENT FAILED EMAIL ADMIN SUBJECT', $order->getUserName(), $order->getId()));
                $mailer->setBody(JText::sprintf('PAYMENT FAILED EMAIL ADMIN MESSAGE', $order->getUserName(), $order->getId()));
                $mailer->Send();
            }
            break;
        case InstantPaymentNotification::STATUS_CLOSED:
            $order->updateStatus($settings->getOrderStatusSuccessful());
            if ($settings->isMailToBuyer()) {
                $mailer = getMailerInstance();
                $mailer->addRecipient($order->getUserEmail(), $order->getUserName());
                $mailer->setSubject(JText::sprintf('PAYMENT SUCCESSFUL EMAIL USER SUBJECT', $order->getUserName(), $order->getId()));
                $mailer->setBody(JText::sprintf('PAYMENT SUCCESSFUL EMAIL USER MESSAGE', $order->getUserName(), $order->getId()));
                $mailer->Send();
            }
            if ($settings->isMailToMerchant()) {
                $mailer = getMailerInstance(true);
                $mailer->setSubject(JText::sprintf('PAYMENT SUCCESSFUL EMAIL ADMIN SUBJECT', $order->getUserName(), $order->getId()));
                $mailer->setBody(JText::sprintf('PAYMENT SUCCESSFUL EMAIL ADMIN MESSAGE', $order->getUserName(), $order->getId()));
                $mailer->Send();
            }
            break;
        case InstantPaymentNotification::STATUS_DUPLICATE:
        default:
            // ignore
    }
} catch (Exception $e) {
    jimport('joomla.error.log');
    $log = JLog::getInstance('com_smartorder.paypal.log.php');
    $log->addEntry(array(
        'comment' => $e->getFile().' ('.$e->getLine().') '.$e->getMessage()
    ));
    $log->addEntry(array(
        'comment' => $e->getTraceAsString()
    ));
}

$app->close();