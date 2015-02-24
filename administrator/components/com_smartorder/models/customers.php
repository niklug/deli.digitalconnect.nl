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

class SmartorderModelCustomers extends JModelLegacy
{
	var $_data;


    function getListOfCustomer($where = '', $orderby = '', &$pageNav) {

        $query = 'SELECT u.id, u.name, sou.address, u.email, sou.phone, count(o.id) as numOfOrders
						FROM #__users u
                            JOIN #__smartorder_users sou ON u.id = sou.id
                            LEFT JOIN #__smartorder_orders o ON sou.id = o.user_id '
                        . $where
						.' GROUP BY u.id, u.name, sou.address, u.email, sou.phone '
                        . $orderby ;

        $this->_data = $this->_getList( $query, $pageNav->limitstart, $pageNav->limit );
        return $this->_data;
    }

    function getCountOfCustomer($where = '') {
		$db =& JFactory::getDBO();
        $query = 'SELECT count(*) as CountOfCustomers
                    FROM #__users u JOIN #__smartorder_users sou ON u.id = sou.id  ' . $where ;

        $db->setQuery( $query );
	    return $db->loadResult();
    }

    function getCustomerData($id) {
        $db =& JFactory::getDBO();
        $query = 'SELECT u.id, u.name, sou.address, u.email, sou.phone, count(o.id) as numOfOrders
                    FROM #__users u
                        JOIN #__smartorder_users sou ON u.id = sou.id
                        LEFT JOIN #__smartorder_orders o ON sou.id = o.user_id
                    WHERE u.id = '.$id.'
                    GROUP BY u.id, u.name, sou.address, u.email, sou.phone';

        $db->setQuery( $query );
        return $db->loadObject();

    }

    function updateUser($id, $name, $email, $address, $phone) {
        $db =& JFactory::getDBO();
        $name = $db->quote($name);
        $email = $db->quote($email);
        $address = $db->quote($address);
        $phone = $db->quote($phone);

        $query = sprintf("UPDATE `#__users`
                        SET `name` = %s, `email` = %s, `username` = %s
                        WHERE email = username AND id = %d", $name, $email, $email, (int) $id);
        $db->setQuery( $query );
        $db->query();

        if ($db->getAffectedRows() == 0) {
            $query = sprintf("UPDATE `#__users`
                            SET `name` = %s, `email` = %s
                            WHERE id = %d", $name, $email, (int) $id);
            $db->setQuery( $query );
            $db->query();
        }

        $query = sprintf("UPDATE `#__smartorder_users`
                        SET `address` = %s, `phone` = %s
                        WHERE id = %d", $address, $phone, (int) $id);
        $db->setQuery( $query );
        $db->query();
    }
}