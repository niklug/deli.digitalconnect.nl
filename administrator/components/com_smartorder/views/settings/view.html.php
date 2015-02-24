<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once JPATH_BASE.'/../components/com_smartorder/paypal/PayPalSettings.php';

class SmartorderViewSettings extends JViewLegacy
{
	function display($tpl = null)
	{
		parent::display($tpl);
	}

	function edit() {

		$id = 1;

        JToolBarHelper::title( JText::_( 'SMARTORDER MANAGER') . ' &raquo ' . JText::_( 'SETTINGS' ), 'generic.png' );
        JToolBarHelper::apply();
		JToolBarHelper::save();
		JToolBarHelper::cancel();


		$db		=& JFactory::getDBO();
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_smartorder'.DIRECTORY_SEPARATOR.'tables');

		$id = 1;
		$row =& JTable::getInstance('settings', 'Table');
		$row->load( $id );

		// build list of $currency_display
		$currency_display[] = JHTML::_('select.option',  'Symb00', 'Symb00' );
   		$currency_display[] = JHTML::_('select.option',  'Symb_00', 'Symb 00' );
  		$currency_display[] = JHTML::_('select.option',  '00Symb', '00Symb' );
  		$currency_display[] = JHTML::_('select.option',  '00_Symb', '00 Symb' );
    	$lists['currency_display'] = JHTML::_('select.genericlist',   $currency_display, 'currency_display', 'class="inputbox"', 'value', 'text', $row->currency_display );

    	// build list of $vat_handling
		$vat_handling[] = JHTML::_('select.option',  '0', 'No' );
   		$vat_handling[] = JHTML::_('select.option',  '1', 'Yes' );
    	$lists['vat_handling'] = JHTML::_('select.genericlist',   $vat_handling, 'vat_handling', 'class="inputbox"', 'value', 'text', $row->vat_handling );

		// build list of Monday Open Time
		for($i=0;$i<24;$i++) $open_Mon_from_H[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Mon_from_H'] = JHTML::_('select.genericlist',   $open_Mon_from_H, 'open_Mon_from_H', 'class="inputbox"', 'value', 'text', $row->open_Mon_from_H );
		for($i=0;$i<60;$i++) $open_Mon_from_M[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Mon_from_M'] = JHTML::_('select.genericlist',   $open_Mon_from_M, 'open_Mon_from_M', 'class="inputbox"', 'value', 'text', $row->open_Mon_from_M );
		for($i=0;$i<24;$i++) $open_Mon_from_H[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Mon_to_H'] = JHTML::_('select.genericlist',   $open_Mon_from_H, 'open_Mon_to_H', 'class="inputbox"', 'value', 'text', $row->open_Mon_to_H );
		for($i=0;$i<60;$i++) $open_Mon_from_M[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Mon_to_M'] = JHTML::_('select.genericlist',   $open_Mon_from_M, 'open_Mon_to_M', 'class="inputbox"', 'value', 'text', $row->open_Mon_to_M );
		// build list of Tuesday Open Time
		for($i=0;$i<24;$i++) $open_Tue_from_H[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Tue_from_H'] = JHTML::_('select.genericlist',   $open_Tue_from_H, 'open_Tue_from_H', 'class="inputbox"', 'value', 'text', $row->open_Tue_from_H );
		for($i=0;$i<60;$i++) $open_Tue_from_M[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Tue_from_M'] = JHTML::_('select.genericlist',   $open_Tue_from_M, 'open_Tue_from_M', 'class="inputbox"', 'value', 'text', $row->open_Tue_from_M );
		for($i=0;$i<24;$i++) $open_Tue_from_H[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Tue_to_H'] = JHTML::_('select.genericlist',   $open_Tue_from_H, 'open_Tue_to_H', 'class="inputbox"', 'value', 'text', $row->open_Tue_to_H );
		for($i=0;$i<60;$i++) $open_Tue_from_M[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Tue_to_M'] = JHTML::_('select.genericlist',   $open_Tue_from_M, 'open_Tue_to_M', 'class="inputbox"', 'value', 'text', $row->open_Tue_to_M );
		// build list of Wednesday Open Time
		for($i=0;$i<24;$i++) $open_Wed_from_H[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Wed_from_H'] = JHTML::_('select.genericlist',   $open_Wed_from_H, 'open_Wed_from_H', 'class="inputbox"', 'value', 'text', $row->open_Wed_from_H );
		for($i=0;$i<60;$i++) $open_Wed_from_M[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Wed_from_M'] = JHTML::_('select.genericlist',   $open_Wed_from_M, 'open_Wed_from_M', 'class="inputbox"', 'value', 'text', $row->open_Wed_from_M );
		for($i=0;$i<24;$i++) $open_Wed_from_H[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Wed_to_H'] = JHTML::_('select.genericlist',   $open_Wed_from_H, 'open_Wed_to_H', 'class="inputbox"', 'value', 'text', $row->open_Wed_to_H );
		for($i=0;$i<60;$i++) $open_Wed_from_M[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Wed_to_M'] = JHTML::_('select.genericlist',   $open_Wed_from_M, 'open_Wed_to_M', 'class="inputbox"', 'value', 'text', $row->open_Wed_to_M );
		// build list of Thursday Open Time
		for($i=0;$i<24;$i++) $open_Thu_from_H[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Thu_from_H'] = JHTML::_('select.genericlist',   $open_Thu_from_H, 'open_Thu_from_H', 'class="inputbox"', 'value', 'text', $row->open_Thu_from_H );
		for($i=0;$i<60;$i++) $open_Thu_from_M[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Thu_from_M'] = JHTML::_('select.genericlist',   $open_Thu_from_M, 'open_Thu_from_M', 'class="inputbox"', 'value', 'text', $row->open_Thu_from_M );
		for($i=0;$i<24;$i++) $open_Thu_from_H[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Thu_to_H'] = JHTML::_('select.genericlist',   $open_Thu_from_H, 'open_Thu_to_H', 'class="inputbox"', 'value', 'text', $row->open_Thu_to_H );
		for($i=0;$i<60;$i++) $open_Thu_from_M[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Thu_to_M'] = JHTML::_('select.genericlist',   $open_Thu_from_M, 'open_Thu_to_M', 'class="inputbox"', 'value', 'text', $row->open_Thu_to_M );
		// build list of Friday Open Time
		for($i=0;$i<24;$i++) $open_Fri_from_H[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Fri_from_H'] = JHTML::_('select.genericlist',   $open_Fri_from_H, 'open_Fri_from_H', 'class="inputbox"', 'value', 'text', $row->open_Fri_from_H );
		for($i=0;$i<60;$i++) $open_Fri_from_M[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Fri_from_M'] = JHTML::_('select.genericlist',   $open_Fri_from_M, 'open_Fri_from_M', 'class="inputbox"', 'value', 'text', $row->open_Fri_from_M );
		for($i=0;$i<24;$i++) $open_Fri_from_H[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Fri_to_H'] = JHTML::_('select.genericlist',   $open_Fri_from_H, 'open_Fri_to_H', 'class="inputbox"', 'value', 'text', $row->open_Fri_to_H );
		for($i=0;$i<60;$i++) $open_Fri_from_M[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Fri_to_M'] = JHTML::_('select.genericlist',   $open_Fri_from_M, 'open_Fri_to_M', 'class="inputbox"', 'value', 'text', $row->open_Fri_to_M );
		// build list of Saturday Open Time
		for($i=0;$i<24;$i++) $open_Sat_from_H[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Sat_from_H'] = JHTML::_('select.genericlist',   $open_Sat_from_H, 'open_Sat_from_H', 'class="inputbox"', 'value', 'text', $row->open_Sat_from_H );
		for($i=0;$i<60;$i++) $open_Sat_from_M[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Sat_from_M'] = JHTML::_('select.genericlist',   $open_Sat_from_M, 'open_Sat_from_M', 'class="inputbox"', 'value', 'text', $row->open_Sat_from_M );
		for($i=0;$i<24;$i++) $open_Sat_from_H[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Sat_to_H'] = JHTML::_('select.genericlist',   $open_Sat_from_H, 'open_Sat_to_H', 'class="inputbox"', 'value', 'text', $row->open_Sat_to_H );
		for($i=0;$i<60;$i++) $open_Sat_from_M[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Sat_to_M'] = JHTML::_('select.genericlist',   $open_Sat_from_M, 'open_Sat_to_M', 'class="inputbox"', 'value', 'text', $row->open_Sat_to_M );
		// build list of Sunday Open Time
		for($i=0;$i<24;$i++) $open_Sun_from_H[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Sun_from_H'] = JHTML::_('select.genericlist',   $open_Sun_from_H, 'open_Sun_from_H', 'class="inputbox"', 'value', 'text', $row->open_Sun_from_H );
		for($i=0;$i<60;$i++) $open_Sun_from_M[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Sun_from_M'] = JHTML::_('select.genericlist',   $open_Sun_from_M, 'open_Sun_from_M', 'class="inputbox"', 'value', 'text', $row->open_Sun_from_M );
		for($i=0;$i<24;$i++) $open_Sun_from_H[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Sun_to_H'] = JHTML::_('select.genericlist',   $open_Sun_from_H, 'open_Sun_to_H', 'class="inputbox"', 'value', 'text', $row->open_Sun_to_H );
		for($i=0;$i<60;$i++) $open_Sun_from_M[] = JHTML::_('select.option',  $i, str_pad($i,2,0,STR_PAD_LEFT) );
    	$lists['open_Sun_to_M'] = JHTML::_('select.genericlist',   $open_Sun_from_M, 'open_Sun_to_M', 'class="inputbox"', 'value', 'text', $row->open_Sun_to_M );

        $db->setQuery('SELECT * FROM #__smartorder_currency ORDER BY code ASC');
        $currencies = $db->loadObjectList();
        $currencyOptions = array();
        foreach ($currencies as $currency) {
  		    $currencyOptions[] = JHTML::_('select.option', $currency->code, sprintf('%s - %s', $currency->code, $currency->name));
        }
        $pps = PayPalSettings::load();
        $lists['currency_code'] = JHTML::_('select.genericlist', $currencyOptions, 'currency_code', 'class="inputbox"', 'value', 'text', $pps->getCurrency());

        $paymentMethodOptions = array(
            'payondelivery' => JText::_('PAY ON DELIVERY'),
            'paypal' => JText::_('PAYPAL')
        );

		$this->assignRef( 'row', $row );
		$this->assignRef( 'lists', $lists );
		$this->assignRef( 'paymentMethodOptions', $paymentMethodOptions );

		require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'settings'.DIRECTORY_SEPARATOR.'tmpl'.DIRECTORY_SEPARATOR.'form.php');

	}
}