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
	function getListOfCategory()
	{
		$db =& JFactory::getDBO();
		$query = 'SELECT * FROM #__smartorder_categories WHERE published = 1 ORDER BY ordering';
		return $this->_getList( $query );
	}

	function getListOfItem()
	{
		$db =& JFactory::getDBO();
		$query = 'SELECT * FROM #__smartorder_items WHERE published = 1 ORDER BY cat_id, ordering';
		return $this->_getList( $query );
	}

	function getListOfTopping()
	{
		$db =& JFactory::getDBO();
		$query = 'SELECT #__smartorder_toppings.*,  #__smartorder_categories.name as cat_name
					FROM #__smartorder_toppings
						JOIN #__smartorder_categories ON #__smartorder_toppings.cat_id = #__smartorder_categories.id
				  WHERE #__smartorder_toppings.published = 1
                  ORDER BY #__smartorder_toppings.cat_id, #__smartorder_toppings.ordering, #__smartorder_toppings.id';
		return $this->_getList( $query );
	}
	function getSettings()
	{
		$db =& JFactory::getDBO();
		$query = 'SELECT *
					FROM #__smartorder_settings
				  WHERE id = 1';
		return $this->_getList( $query );
	}
    function getOpenOrClosed()
    {
        $db = &JFactory::getDBO();
        $DayStr = date("D");
        $HMStr = date("H").':'.date("i");
        $query = "SELECT id
                    FROM `#__smartorder_settings`
                    WHERE CONCAT(LPAD(open_".$DayStr."_from_H,2,0), ':', LPAD(open_".$DayStr."_from_M,2,0)) <= '".$HMStr."'
                        AND CONCAT(LPAD(open_".$DayStr."_to_H,2,0), ':', LPAD(open_".$DayStr."_to_M,2,0)) >= '".$HMStr."' ";
        $db->setQuery( $query );
        $x = $db->loadResult();

        return ($x > '0') ? 'open' : 'closed' ;
    }

    function insertUser($userID, $phone, $address, $email)
    {
        $db =& JFactory::getDBO();

        if ($userID > 0) {

            $query = sprintf("INSERT INTO `#__smartorder_users`
                                (`id`, `address`, `phone`)
                        VALUES  (%d, %s, %s)", intval($userID), $db->quote($address), $db->quote($phone));
            $db->setQuery( $query );
            $db->query();

            // atkotjuk a korabbi ezen email cimmel erkezo rendeleseket
            // ha meg nincsenek masik usernel
            $query = sprintf("UPDATE `#__smartorder_orders`
                        SET `user_id` = %d
                        WHERE (coalesce(`user_id`,0) = 0) AND (user_email = %s)", intval($userID), $db->quote($email));
            $db->setQuery( $query );
            $db->query();


            $query = sprintf("INSERT INTO #__user_usergroup_map (user_id, group_id) VALUES (%d,2);", intval($userID));
            $db->setQuery( $query );
            $db->query();

        }
    }

    function getUserData($id)
    {
        $db =& JFactory::getDBO();
        $query = sprintf('SELECT u.id, u.name, sou.address, u.email, sou.phone
                    FROM #__users u
                        LEFT JOIN #__smartorder_users sou ON u.id = sou.id
                    WHERE u.id = %d', intval($id));

        $db->setQuery( $query );
        return $db->loadObject();
    }
}