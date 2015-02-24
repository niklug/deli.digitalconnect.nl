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

class SmartorderModelOrders extends JModelLegacy
{
	var $_data;

	function deleteOrder ($cid = array()) {
		if (empty( $cid )) {
			JError::raiseWarning( 500, 'No order selected' );
		} else {

			if  (count( $cid )) {
				$cids = implode( ',', $cid );

				$db =& JFactory::getDBO();
				$query = "DELETE FROM #__smartorder_orders
						  WHERE id IN ( ".$cids." ) ";
				$db->setQuery( $query );
				if (!$db->query()) {
					JError::raiseError(500, $db->getErrorMsg() );
					return 'ERR';
				}
				return $db->getAffectedRows();
			}
		}

		return 0;
	}


    function getListOfOrders($where = '', $orderby = '', &$pageNav) {

		$query = 'SELECT o.id, o.datetime, o.status, s.name as status_name, s.fontcolor as status_fontcolor,
						o.user_name, o.user_email, o.user_address, o.user_phone,
						sum(price * (1 + vat_percent/100.0) * count) as Total,
						GROUP_CONCAT(i.name," (",i.count,")" ORDER BY i.basketgroup, i.type SEPARATOR ", ") AS order_detail_name_list
					FROM #__smartorder_orders o
						LEFT JOIN #__smartorder_orders_details i ON o.id = i.order_id
						LEFT JOIN #__smartorder_orders_status s ON o.status = s.id '
						. $where .'
					GROUP BY o.id, o.datetime, o.status, o.user_name, o.user_email, o.user_address, o.user_phone '
						. $orderby ;
        $this->_data = $this->_getList( $query, $pageNav->limitstart, $pageNav->limit );
        return $this->_data;

    }

	function getOrder($id = 0) {
		$db =& JFactory::getDBO();
        $query = "SELECT o.id, o.datetime, o.status, o.user_id, o.user_name, o.user_email, o.user_address, o.user_phone, o.user_note,
					sum(price * (1 + vat_percent/100.0) * count) as total
					FROM #__smartorder_orders o
					LEFT JOIN #__smartorder_orders_details i ON o.id = i.order_id
					WHERE o.id = '".$id."'
					GROUP BY o.id, o.datetime, o.status, o.user_id, o.user_name, o.user_email, o.user_address, o.user_phone, o.user_note" ;
        $this->_data = $this->_getList( $query);
		return $this->_data;
    }
    function getOrders($id, $orderby = 'o.id desc') { # $id is an array
    	if  (count( $id )) {
    		$ids = implode( ',', $id );
   		} else $ids = '0';
		$db =& JFactory::getDBO();
        $query = "SELECT o.id, o.datetime, o.status, s.name as status_name, o.user_id, o.user_name, o.user_email, o.user_address, o.user_phone, o.user_note,
					sum(price * (1 + vat_percent/100.0) * count) as total
					FROM #__smartorder_orders o
					LEFT JOIN #__smartorder_orders_details i ON o.id = i.order_id
					LEFT JOIN #__smartorder_orders_status s ON o.status = s.id
					WHERE o.id IN (".$ids.")
					GROUP BY o.id, o.datetime, o.status, o.user_id, o.user_name, o.user_email, o.user_address, o.user_phone, o.user_note
					ORDER BY ".$orderby ;
        $this->_data = $this->_getList( $query);
		return $this->_data;
    }
    function getOrderItems($id) { # id is an array
    	if  (count( $id )) {
    		if (is_array($id)) $ids = implode( ',', $id );
    		else $ids = $id;
   		} else $ids = '0';
		$db =& JFactory::getDBO();
        $query = "SELECT *, (price * (1 + vat_percent/100.0) * count) as total
					FROM #__smartorder_orders_details WHERE order_id IN (".$ids.")
					ORDER BY order_id, basketgroup " ;
        $this->_data = $this->_getList( $query);
		return $this->_data;
    }

    function getCountOfOrders($where = '') {
		$db =& JFactory::getDBO();
        $query = 'SELECT count(*) as CountOfTopping FROM #__smartorder_orders o ' . $where ;

        $db->setQuery( $query );
	    return $db->loadResult();
    }

    function getListOfStatusForSelect() {

        $query = 'SELECT id, name FROM #__smartorder_orders_status ORDER BY ordering ' ;
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
    function getCustomerData($id)
	{
	    if (empty($id)) {
	        return null;
	    }
		$db =& JFactory::getDBO();
        $query = 'SELECT u.id, u.name, sou.address, u.email, sou.phone, count(distinct o.id) as countOfOrders, sum(price * (1 + vat_percent/100.0) * count) as total
                    FROM #__users u
                        INNER JOIN #__smartorder_users sou ON u.id = sou.id
                        JOIN #__smartorder_orders o ON o.user_id = u.id
                        LEFT JOIN #__smartorder_orders_details i ON o.id = i.order_id
                    WHERE u.id = '.$id.'
                    GROUP BY u.id, u.name, sou.address, u.email, sou.phone';

        $db->setQuery( $query );
        return $db->loadObject();
	}
}