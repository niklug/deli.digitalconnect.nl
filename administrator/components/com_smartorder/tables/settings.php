<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class TableSettings extends JTable
{
	var $id					= null;
	var $minimum_order_price	= null; 
	var $shipping_cost	= null; 
	var $free_shipping_limit	= null; 
	var $currency_symbol	= null; 
	var $currency_display	= null; 
	var $currency_decimal	= null; 
	var $currency_decimal_symbol	= null; 
	var $currency_thousand_separator	= null; 
	var $orderform_default_items	= null; 
	var $orderform_default_infotext	= null; 
	var $termsofservice_url	= null;
	var $vat_handling	= null;
	var $vat_default_percent	= null;
	var $open_Mon_from_H = null; 
	var $open_Mon_from_M = null; 
	var $open_Mon_to_H = null; 
	var $open_Mon_to_M = null; 
	var $open_Tue_from_H = null; 
	var $open_Tue_from_M = null; 
	var $open_Tue_to_H = null; 
	var $open_Tue_to_M = null; 
	var $open_Wed_from_H = null; 
	var $open_Wed_from_M = null; 
	var $open_Wed_to_H = null; 
	var $open_Wed_to_M = null; 
	var $open_Thu_from_H = null; 
	var $open_Thu_from_M = null; 
	var $open_Thu_to_H = null; 
	var $open_Thu_to_M = null; 
	var $open_Fri_from_H = null; 
	var $open_Fri_from_M = null; 
	var $open_Fri_to_H = null; 
	var $open_Fri_to_M = null; 
	var $open_Sat_from_H = null; 
	var $open_Sat_from_M = null; 
	var $open_Sat_to_H = null; 
	var $open_Sat_to_M = null; 
	var $open_Sun_from_H = null; 
	var $open_Sun_from_M = null; 
	var $open_Sun_to_H = null; 
	var $open_Sun_to_M = null; 

	function __construct( &$db ) {
		parent::__construct( '#__smartorder_settings', 'id', $db );
	}
}