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

class SmartorderViewCustomers extends JViewLegacy
{
	function display($tpl = null)
	{

		JToolBarHelper::title( JText::_( 'SMARTORDER MANAGER') . ' &raquo ' . JText::_( 'CUSTOMERS' ), 'generic.png' );

        $model =& $this->getModel();


        $mainframe = JFactory::getApplication();

		$filter_order	= (isset($_REQUEST["filter_order"]) ? JRequest::getVar("filter_order") : 'ordering');
		$filter_order_Dir = (isset($_REQUEST["filter_order_Dir"]) ? JRequest::getVar("filter_order_Dir") : '');
		$search			= (isset($_REQUEST["search"]) ? JRequest::getVar("search") : '');
		$search				= JString::strtolower( $search );

    	$limit = (isset($_REQUEST["limit"]) ? JRequest::getVar("limit"):$mainframe->getCfg('list_limit'));
		$limitstart = (isset($_REQUEST["limitstart"]) ? JRequest::getVar("limitstart") : 0 );

		$where = array();

		if ($search) {
		    $dbo = JFactory::getDbo();
			$where[] = 'LOWER(u.name) LIKE '.$dbo->quote( '%'.$search.'%' ).' OR '.
                        'LOWER(u.email) LIKE '.$dbo->quote( '%'.$search.'%' ).' OR '.
                        'LOWER(sou.address) LIKE '.$dbo->quote( '%'.$search.'%' ).' OR '.
                        'LOWER(sou.phone) LIKE '.$dbo->quote( '%'.$search.'%' );
		}

		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );

		if ($filter_order == 'ordering'){
			$orderby 	= ' ORDER BY u.name ' . $filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '. $filter_order .' '. $filter_order_Dir .', name ';
		}

		$total = $model->getCountOfCustomer($where) ;
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );


		$customers =& $model->getListOfCustomer($where, $orderby, $pageNav) ;

		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;

		// search filter
		$lists['search']= $search;

		$this->assignRef( 'customers', $customers ); # data to default.php
        $this->assignRef( 'lists', $lists );
        $this->assignRef( 'pageNav', $pageNav );

		parent::display($tpl);
	}

	function edit($model) {

		if (isset($_REQUEST["cid"])) {
			# edit
			$id	= JRequest::getVar('cid', array(0), 'method', 'array');
			$id	= array((int) $id[0]);
			$subTitle = '[ '. JText::_( 'Edit' ) .' ]';
		} else {
			# new
			$id	= array( 0 );
			$subTitle = '[ '. JText::_( 'New' ) .' ]';
		}

        JToolBarHelper::title( JText::_( 'SMARTORDER MANAGER') . ' &raquo ' . JText::_( 'CUSTOMER' ) .' '. $subTitle, 'generic.png' );
		JToolBarHelper::save();
		JToolBarHelper::cancel();

		$customer = $model->getCustomerData($id[0]);

		$this->assignRef( 'customer', $customer );

		require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'customers'.DIRECTORY_SEPARATOR.'tmpl'.DIRECTORY_SEPARATOR.'form.php');

	}
}