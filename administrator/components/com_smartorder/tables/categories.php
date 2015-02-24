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

class TableCategories extends JTable
{
	var $id					= null;
	var $name				= null;
	var $ordering			= null;
	var $published			= null;

	function __construct( &$db ) {
		parent::__construct( '#__smartorder_categories', 'id', $db );
	}
}