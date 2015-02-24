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
require_once JPATH_BASE.'/../components/com_smartorder/paypal/OrderStatus.php';

class SmartorderViewPayPal extends JViewLegacy {

    function display($tpl = null) {
        parent::display($tpl);
    }

    function edit() {
        JToolBarHelper::title(JText::_('SMARTORDER MANAGER').' &raquo '.JText::_('PAYPAL SETTINGS'), 'generic.png');
        JToolBarHelper::apply();
        JToolBarHelper::save();
        JToolBarHelper::cancel();

        $settings = PayPalSettings::load();

        $db = JFactory::getDBO();
        $statusList = $db->setQuery('SELECT * FROM #__smartorder_orders_status ORDER BY name ASC')->loadObjectList('', 'OrderStatus');
        $statusItems = array();
        foreach ($statusList as $status) {
            $statusItems[] = JHTML::_('select.option', $status->getName(), $status->getName());
        }

        $yesNoItems = array(
            JHTML::_('select.option', '1', 'Yes'),
            JHTML::_('select.option', '0', 'No')
        );

        $lists = array();

        $lists['sandbox_mode'] = JHTML::_('select.genericlist', $yesNoItems, 'sandbox_mode', 'class="inputbox"', 'value', 'text', $settings->isSandboxMode() ? '1' : '0');
        $lists['use_shipping_info'] = JHTML::_('select.genericlist', $yesNoItems, 'use_shipping_info', 'class="inputbox"', 'value', 'text', $settings->isUseShippingInfo() ? '1' : '0');
        $lists['send_gross_prices'] = JHTML::_('select.genericlist', $yesNoItems, 'send_gross_prices', 'class="inputbox"', 'value', 'text', $settings->isSendGrossPrices() ? '1' : '0');
        $lists['mail_to_buyer'] = JHTML::_('select.genericlist', $yesNoItems, 'mail_to_buyer', 'class="inputbox"', 'value', 'text', $settings->isMailToBuyer() ? '1' : '0');
        $lists['mail_to_merchant'] = JHTML::_('select.genericlist', $yesNoItems, 'mail_to_merchant', 'class="inputbox"', 'value', 'text', $settings->isMailToMerchant() ? '1' : '0');
        $lists['order_status_successful'] = JHTML::_('select.genericlist', $statusItems, 'order_status_successful', 'class="inputbox"', 'value', 'text', $settings->getOrderStatusSuccessful());
        $lists['order_status_pending'] = JHTML::_('select.genericlist', $statusItems, 'order_status_pending', 'class="inputbox"', 'value', 'text', $settings->getOrderStatusPending());
        $lists['order_status_failed'] = JHTML::_('select.genericlist', $statusItems, 'order_status_failed', 'class="inputbox"', 'value', 'text', $settings->getOrderStatusFailed());

        $languageItems = array();
        foreach (array(
            'AU' => 'AU – Australia',
            'AT' => 'AT – Austria',
            'BE' => 'BE – Belgium',
            'BR' => 'BR – Brazil',
            'CA' => 'CA – Canada',
            'CH' => 'CH – Switzerland',
            'CN' => 'CN – China',
            'DE' => 'DE – Germany',
            'ES' => 'ES – Spain',
            'GB' => 'GB – United Kingdom',
            'FR' => 'FR – France',
            'IT' => 'IT – Italy',
            'NL' => 'NL – Netherlands',
            'PL' => 'PL – Poland',
            'PT' => 'PT – Portugal',
            'RU' => 'RU – Russia',
            'US' => 'US – United States',
            'da_DK' => 'da_DK – Danish (for Denmark only)',
            'he_IL' => 'he_IL – Hebrew (all)',
            'id_ID' => 'id_ID – Indonesian (for Indonesia only)',
            'jp_JP' => 'jp_JP – Japanese (for Japan only)',
            'no_NO' => 'no_NO – Norwegian (for Norway only)',
            'pt_BR' => 'pt_BR – Brazilian Portuguese (for Portugal and Brazil only)',
            'ru_RU' => 'ru_RU – Russian (for Lithuania, Latvia, and Ukraine only)',
            'sv_SE' => 'sv_SE – Swedish (for Sweden only)',
            'th_TH' => 'th_TH – Thai (for Thailand only)',
            'tr_TR' => 'tr_TR – Turkish (for Turkey only)',
            'zh_CN' => 'zh_CN – Simplified Chinese (for China only)',
            'zh_HK' => 'zh_HK – Traditional Chinese (for Hong Kong only)',
            'zh_TW' => 'zh_TW – Traditional Chinese (for Taiwan only)'
            ) as $key => $value) {
            $languageItems[] = JHTML::_('select.option', $key, $value);
        }
        $lists['checkout_language'] = JHTML::_('select.genericlist', $languageItems, 'checkout_language', 'class="inputbox"', 'value', 'text', $settings->getCheckoutLanguage());

        $this->assignRef('settings', $settings);
        $this->assignRef('lists', $lists);

        require_once JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'paypal'.DIRECTORY_SEPARATOR.'tmpl'.DIRECTORY_SEPARATOR.'form.php';
    }
}