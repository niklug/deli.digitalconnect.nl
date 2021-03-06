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

class SmartorderModelItems extends JModelLegacy
{
	var $_data;


    function getListOfItem($where = '', $orderby = '', &$pageNav) {

        $query = 'SELECT i.*, c.name as cat_name, c.id as cat_id
					FROM #__smartorder_items i
						LEFT JOIN #__smartorder_categories c ON c.id = i.cat_id ' . $where
						.' '. $orderby ;
        $this->_data = $this->_getList( $query, $pageNav->limitstart, $pageNav->limit );
        return $this->_data;

    }

    function getCountOfItem($where = '') {
		$db =& JFactory::getDBO();
        $query = 'SELECT count(*) as CountOfItem FROM #__smartorder_items i ' . $where ;

        $db->setQuery( $query );
	    return $db->loadResult();
    }

    function getListOfCategoryForSelect() {

        $query = 'SELECT id, name FROM #__smartorder_categories ORDER BY name ' ;
        $this->_data = $this->_getList($query);
        return $this->_data;
    }

    function changePublishItem ($cid = array(), $publish = 1) {
		if (empty( $cid )) {
			JError::raiseWarning( 500, 'No items selected' );
		} elseif  (count( $cid )) {
			$cids = implode( ',', $cid );

			$db =& JFactory::getDBO();
			$query = "UPDATE #__smartorder_items
						 SET published = '".$publish."'
					  WHERE id IN ( ".$cids." )";
			$db->setQuery( $query );
			if (!$db->query()) {
				JError::raiseError(500, $db->getErrorMsg() );
				return false;
			}
		}

		return true;
	}

	function deleteItem ($cid = array()) {
		if (empty( $cid )) {
			JError::raiseWarning( 500, 'No items selected' );
		} else {

			if  (count( $cid )) {
				$cids = implode( ',', $cid );

				$db =& JFactory::getDBO();
				$query = "DELETE FROM #__smartorder_items
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

	function orderItem( $direction ) {

		JTable::addIncludePath(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_smartorder'.DIRECTORY_SEPARATOR.'tables');

		$db		=& JFactory::getDBO();
		$cid	= JRequest::getVar('cid', array(0), '', 'array');

		JArrayHelper::toInteger($cid, array(0));

		$limit 		= JRequest::getVar( 'limit', 0, '', 'int' );
		$limitstart = JRequest::getVar( 'limitstart', 0, '', 'int' );
		$catid 		= JRequest::getVar( 'catid', 0, '', 'int' );

		$row =& JTable::getInstance( 'items', 'Table' );

		$row->load( $cid[0] );
		$row->move( $direction );

	}

	function saveOrderItems( $cid = array(), $order ) {

		JTable::addIncludePath(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_smartorder'.DIRECTORY_SEPARATOR.'tables');

		$db			=& JFactory::getDBO();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		$total		= count( $cid );
		$order		= JRequest::getVar( 'order', array(0), 'post', 'array' );
		JArrayHelper::toInteger($order, array(0));

		$row =& JTable::getInstance( 'items', 'Table' );

		// update ordering values
		for( $i=0; $i < $total; $i++ ) {
			$row->load( (int) $cid[$i] );

			if ($row->ordering != $order[$i]) {
				$row->ordering = $order[$i];
				if (!$row->store()) {
					JError::raiseError(500, $db->getErrorMsg() );
					return false;
				}
			}
		}

		return true;

	}
}