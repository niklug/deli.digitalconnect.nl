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

class TableToppings extends JTable
{
	var $id					= null;
	var $cat_id				= null;
	var $name				= null;
	var $description		= null;
	var $price				= null;
	var $discount_price		= null;
	var $published			= null;
	var $ordering			= null;
	var $vat_percent		= null;

	function __construct( &$db ) {
		parent::__construct( '#__smartorder_toppings', 'id', $db );
	}
}