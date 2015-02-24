<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */


class PayPalSettings {

    private $business;
    private $sandbox_mode;
    private $header_image_url;
    private $use_shipping_info;
    private $order_status_successful;
    private $order_status_pending;
    private $order_status_failed;
    private $return_url;
    private $cancel_url;
    private $currency;
    private $checkout_language;
    private $send_gross_prices;
    private $mail_to_buyer;
    private $mail_to_merchant;

    public function getBusiness() {
        return $this->business;
    }

    public function setBusiness($business) {
        $this->business = $business;
    }

    public function isSandboxMode() {
        return $this->sandbox_mode == 1;
    }

    public function setSandboxMode($sandboxMode) {
        $this->sandbox_mode = $sandboxMode ? 1 : 0;
    }

    public function getHeaderImageUrl() {
        return $this->header_image_url;
    }

    public function setHeaderImageUrl($headerImageUrl) {
        $this->header_image_url = $headerImageUrl;
    }

    public function isUseShippingInfo() {
        return $this->use_shipping_info == 1;
    }

    public function setUseShippingInfo($useShippingInfo) {
        $this->use_shipping_info = $useShippingInfo ? 1 : 0;
    }

    public function getOrderStatusSuccessful() {
        return $this->order_status_successful;
    }

    public function setOrderStatusSuccessful($orderStatusSuccessful) {
        $this->order_status_successful = $orderStatusSuccessful;
    }

    public function getOrderStatusPending() {
        return $this->order_status_pending;
    }

    public function setOrderStatusPending($orderStatusPending) {
        $this->order_status_pending = $orderStatusPending;
    }

    public function getOrderStatusFailed() {
        return $this->order_status_failed;
    }

    public function setOrderStatusFailed($orderStatusFailed) {
        $this->order_status_failed = $orderStatusFailed;
    }

    public function getReturnUrl() {
        return $this->return_url;
    }

    public function setReturnUrl($returnUrl) {
        $this->return_url = $returnUrl;
    }

    public function getCancelUrl() {
        return $this->cancel_url;
    }

    public function setCancelUrl($cancelUrl) {
        $this->cancel_url = $cancelUrl;
    }

    public function getCurrency() {
        return $this->currency;
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    public function getCheckoutLanguage() {
        return $this->checkout_language;
    }

    public function setCheckoutLanguage($checkout_language) {
        $this->checkout_language = $checkout_language;
    }

    public function isSendGrossPrices() {
        return $this->send_gross_prices == 1;
    }

    public function setSendGrossPrices($send_gross_prices) {
        $this->send_gross_prices = $send_gross_prices ? 1 : 0;
    }

    public function isMailToBuyer() {
        return $this->mail_to_buyer == 1;
    }

    public function setMailToBuyer($mail_to_buyer) {
        $this->mail_to_buyer = $mail_to_buyer ? 1 : 0;
    }

    public function isMailToMerchant() {
        return $this->mail_to_merchant == 1;
    }

    public function setMailToMerchant($mail_to_merchant) {
        $this->mail_to_merchant = $mail_to_merchant ? 1 : 0;
    }

    public function save() {
        $db = JFactory::getDBO();
        $updates = array();
        foreach (get_object_vars($this) as $column => $value) {
            $updates[] = sprintf('%s=%s', $column, $db->quote($value));
        }
        $db->setQuery(sprintf('UPDATE #__smartorder_paypal_settings SET %s', implode(',', $updates)));
        $db->query();
    }

    /**
     * @return PayPalSettings
     */
    public static function load() {
        $db = JFactory::getDBO();
        $settings = $db->setQuery('SELECT * FROM #__smartorder_paypal_settings')->loadObject('PayPalSettings');
        if (empty($settings)) {
            $settings = new PayPalSettings();
        }
        return $settings;
    }
}