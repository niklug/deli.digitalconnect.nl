<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

class CartSubmitter {

    /**
     * @var PayPalSettings
     */
    private $settings;

    /**
     * @var Order
     */
    private $order;

    private $ipnUrl;

    public function __construct(PayPalSettings $settings, Order $order) {
        $this->settings = $settings;
        $this->order = $order;
    }

    /**
     * @return PayPalSettings
     */
    public function getSettings() {
        return $this->settings;
    }

    /**
     * @return Order
     */
    public function getOrder() {
        return $this->order;
    }

    public function getIpnUrl() {
        return $this->ipnUrl;
    }

    public function setIpnUrl($ipnUrl) {
        $this->ipnUrl = $ipnUrl;
    }

    public function getForm($id, $includeSubmit = false, $includePort = false) {
        $params = $this->getStaticParams();
        $params['notify_url'] = $this->ipnUrl;
        $params['business'] = $this->settings->getBusiness();
        $params['currency_code'] = $this->settings->getCurrency();
        $params['return'] = $this->settings->getReturnUrl();
        $params['cancel_return'] = $this->settings->getCancelUrl();
        $params['cpp_header_image'] = $this->settings->getHeaderImageUrl();
        $params['lc'] = $this->settings->getCheckoutLanguage();
        $params['custom'] = $this->order->getId();
        if ($this->settings->isUseShippingInfo()) {
            $name = explode(' ', $this->order->getUserName());
            $lastName = array_pop($name);
            $firstName = implode(' ', $name);
            $params['address_override'] = 1;
            $params['first_name'] = $firstName;
            $params['last_name'] = $lastName;
            $params['email'] = $this->order->getUserEmail();
            $params['address1'] = $this->order->getUserAddress();
            $params['night_phone_b'] = $this->order->getUserPhone();
        }
        $index = 1;
        foreach ($this->order->getBasketGroups() as $groupNr => $group) {
            foreach ($group as $detail) {
                if ($detail instanceof OrderDetail) {
                    $params['item_number_'.$index] = $detail->getId();
                    $params['item_name_'.$index] = $detail->isItem()
                        ? $detail->getName()
                        : ' • '.$detail->getName();
                    $params['quantity_'.$index] = $detail->getCount();
                    if ($this->settings->isSendGrossPrices()) {
                        $params['amount_'.$index] = self::formatMonetary($detail->getPrice() + $detail->getVat());
                    } else {
                        $params['amount_'.$index] = self::formatMonetary($detail->getPrice());
                        if ($detail->hasVat()) {
                            $params['tax_'.$index] = self::formatMonetary($detail->getVat());
                            $params['tax_rate_'.$index] = self::formatMonetary($detail->getVatPercent());
                        }
                    }
                }
                $index++;
            }
        }
        $shippingCosts = $this->order->getShippingCosts();
        if ($shippingCosts > 0) {
            $params['handling_cart'] = self::formatMonetary($shippingCosts);
        }
        $fields = array();
        foreach ($params as $key => $value) {
            $attribs = array(
                'type' => 'hidden',
                'name' => $key,
                'value' => $value
            );
            $fields[] = $this->getHtmlElement('input', $attribs);
        }
        $attribs = array(
            'type' => 'submit',
            'name' => 'submit',
            'value' => 'Submit'
        );
        if ($includeSubmit) {
            $fields[] = $this->getHtmlElement('input', $attribs);
        }
        $attribs = array(
            'method' => 'post',
            'action' => $this->getPayPalUrl($includePort),
            'id' => htmlspecialchars($id)
        );
        return $this->getHtmlElement('form', $attribs, implode('', $fields));
    }

    public function getPayPalUrl($includePort = false) {
        $host = $this->settings->isSandboxMode()
            ? PayPal::HOST_DEVELOPMENT
            : PayPal::HOST_PRODUCTION;
        return $includePort
            ? sprintf('%s://%s:%d%s', PayPal::SCHEME, $host, PayPal::PORT, PayPal::PATH)
            : sprintf('%s://%s%s', PayPal::SCHEME, $host, PayPal::PATH);
    }

    public function getStaticParams() {
        return array(
            'cmd' => '_cart',
            'upload' => '1',
            'no_shipping' => '1',
            'charset' => 'utf-8'
        );
    }

    private function getHtmlElement($name, array $attributes = null, $content = null) {
        $attributeStrings = array();
        foreach ($attributes as $key => $value) {
            $attributeStrings[] = sprintf('%s="%s"', $key, htmlspecialchars($value));
        }
        $parts = array();
        $parts[] = sprintf('<%s', $name);
        if (!empty($attributeStrings)) {
            $parts[] = ' ';
            $parts[] = implode(' ', $attributeStrings);
        }
        if ($content === null) {
            $parts[] = ' />';
        } else {
            $parts[] = '>';
            $parts[] = $content;
            $parts[] = sprintf('</%s>', $name);
        }
        return implode('', $parts);
    }

    public static function formatMonetary($value) {
        return number_format($value, 2, '.', '');
    }
}