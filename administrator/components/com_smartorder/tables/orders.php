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

class TableOrders extends JTable
{
	var $id					= null;
	var $datetime			= null;
	var $status				= null;
	var $user_id			= null;
	var $user_name			= null;
	var $user_email			= null;
	var $user_address		= null;
	var $user_phone			= null;
	var $user_note			= null;

	function __construct( &$db ) {
		parent::__construct( '#__smartorder_orders', 'id', $db );
	}
}