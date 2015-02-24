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

class SmartorderModelSmartorder extends JModelLegacy
{
	function getCountOfCategory()
	{
		$db =& JFactory::getDBO();
	   $query = 'SELECT count(id) as CountOfCategory FROM #__smartorder_categories';
	   $db->setQuery( $query );
	   return $db->loadResult();
	}
	function getCountOfItem()
	{
		$db =& JFactory::getDBO();
	   $query = 'SELECT count(id) as CountOfItem FROM #__smartorder_items';
	   $db->setQuery( $query );
	   return $db->loadResult();
	}
	function getCountOfTopping()
	{
		$db =& JFactory::getDBO();
	   $query = 'SELECT count(id) as CountOfTopping FROM #__smartorder_toppings';
	   $db->setQuery( $query );
	   return $db->loadResult();
	}
	function getCountOfOrder($status = '0')
	{
		$db =& JFactory::getDBO();

	   $query = 'SELECT count(id) as CountOfOrder FROM #__smartorder_orders ';
	   if (!empty($status)) {
	       if (!is_array($status)) {
	           $status = array($status);
	       }
	       $status = array_map(array($db, 'quote'), $status);
	       $query .= " WHERE status IN(".implode(',', $status).")";
	   }
	   $db->setQuery( $query );
	   return $db->loadResult();

	}
	function getListOfOrder($status = '')
	{
		$db =& JFactory::getDBO();

		$query = "SELECT o.id, o.datetime, o.status, s.name as status_name,
						o.user_name, o.user_email, o.user_address, o.user_phone,
						sum(price * (1 + vat_percent/100.0) * count) as Total
					FROM #__smartorder_orders o
						LEFT JOIN #__smartorder_orders_details i ON o.id = i.order_id
						LEFT JOIN #__smartorder_orders_status s ON o.status = s.id";
	   if (!empty($status)) {
	       if (!is_array($status)) {
	           $status = array($status);
	       }
	       $status = array_map(array($db, 'quote'), $status);
	       $query .= " WHERE o.status IN(".implode(',', $status).")";
	   }
	   $query .= " GROUP BY o.id desc";
		$this->_data = $this->_getList($query);
		return $this->_data;

	}
	function getSettings()
	{
		$db =& JFactory::getDBO();
		$query = 'SELECT *
					FROM #__smartorder_settings
				  WHERE id = 1';
		return $this->_getList( $query );
	}
}