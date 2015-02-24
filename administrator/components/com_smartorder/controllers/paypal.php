<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

require_once JPATH_BASE.'/../components/com_smartorder/paypal/PayPalSettings.php';

class SmartorderControllerPayPal extends JControllerLegacy {

    public function __construct() {
        JRequest::setVar('view', 'paypal', 'method', false);
        parent::__construct();
    }

    public function edit() {
        $view = $this->getView('paypal', 'html');
        $view->edit();
    }

    public function apply() {
        $this->doSave();
        $mainframe = JFactory::getApplication();
        $mainframe->redirect('index.php?option=com_smartorder&controller=paypal&task=edit');
    }

    public function save() {
        $this->doSave();
        $mainframe = JFactory::getApplication();
        $mainframe->redirect('index.php?option=com_smartorder');
    }

    public function cancel() {
        $mainframe = JFactory::getApplication();
        $mainframe->redirect('index.php?option=com_smartorder');
    }

    public function display() {
        parent::display();
    }

    private function doSave() {
        $post = JRequest::get('post');
        $settings = PayPalSettings::load();
        $settings->setBusiness($post['business']);
        $settings->setSandboxMode($post['sandbox_mode'] === '1');
        $settings->setHeaderImageUrl($post['header_image_url']);
        $settings->setUseShippingInfo($post['use_shipping_info'] === '1');
        $settings->setOrderStatusSuccessful($post['order_status_successful']);
        $settings->setOrderStatusPending($post['order_status_pending']);
        $settings->setOrderStatusFailed($post['order_status_failed']);
        $settings->setReturnUrl($post['return_url']);
        $settings->setCancelUrl($post['cancel_url']);
        $settings->setCheckoutLanguage($post['checkout_language']);
        $settings->setSendGrossPrices($post['send_gross_prices']);
        $settings->setMailToBuyer($post['mail_to_buyer']);
        $settings->setMailToMerchant($post['mail_to_merchant']);
        $settings->save();
    }
}