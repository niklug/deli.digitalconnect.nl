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

class SmartorderViewOrders extends JViewLegacy
{
	function display($tpl = null)
	{
        JToolBarHelper::title( JText::_( 'SMARTORDER MANAGER') . ' &raquo ' . JText::_( 'ORDERS' ), 'generic.png' );
		JToolBarHelper::custom('printOrders', 'print.png', 'print.png', JText::_( 'PRINT' ));
		JToolBarHelper::deleteList('Are you sure to delete the checked items?');

		// default.php-ben behuzva az ikon!!!

        $model =& $this->getModel();

        $mainframe = JFactory::getApplication();

		$filter_order	= (isset($_REQUEST["filter_order"]) ? JRequest::getVar("filter_order") : 'ordering');
		$filter_order_Dir = (isset($_REQUEST["filter_order_Dir"]) ? JRequest::getVar("filter_order_Dir") : 'desc');
		$filter_catid	= (isset($_REQUEST["filter_catid"]) ? JRequest::getVar("filter_catid") : '');
		$search			= (isset($_REQUEST["search"]) ? JRequest::getVar("search") : '');
		$search				= JString::strtolower( $search );

    	$limit = (isset($_REQUEST["limit"]) ? JRequest::getVar("limit"):$mainframe->getCfg('list_limit'));
		$limitstart = (isset($_REQUEST["limitstart"]) ? JRequest::getVar("limitstart") : 0 );

		$where = array();

		if (strlen($filter_catid)) $where[] = 'o.status = '.(int) $filter_catid;

		if ($search) {
			$where[] = 'LOWER(o.user_name) LIKE '.JFactory::getDbo()->quote( '%'.$search.'%' );
		}

		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );

		if ($filter_order == 'ordering'){
			$orderby 	= ' ORDER BY o.id ' . $filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
		}

		$total = $model->getCountOfOrders($where) ;
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );


		$orders =& $model->getListOfOrders($where, $orderby, $pageNav) ;
		$settings =& $model->getSettings();

		// build list of Category
		$catlist[]         = JHTML::_('select.option',  '', JText::_( '- Select Status -' ), 'id', 'name' );
		$catlist         = array_merge( $catlist, $model->getListOfStatusForSelect() );
		$lists['catid']      = JHTML::_('select.genericlist', $catlist, 'filter_catid', 'class="inputbox" size="1" onchange="document.adminForm.submit();"','id', 'name', $filter_catid );


		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;

		// search filter
		$lists['search']= $search;

		$this->assignRef( 'orders', $orders ); # data to default.php
        $this->assignRef( 'lists', $lists );
        $this->assignRef( 'pageNav', $pageNav );
        $this->assignRef( 'settings', $settings );

		parent::display($tpl);
	}

	function edit($model) {

		$id	= JRequest::getVar('cid', array(0), 'method', 'array');
		$id	= array((int) $id[0]);

		$document = JFactory::getDocument();
		$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js');

        JToolBarHelper::title( JText::_( 'SMARTORDER MANAGER') . ' &raquo ' . JText::_( 'ORDER DETAILS' ) , 'generic.png' );
		JToolBarHelper::save();
		JToolBarHelper::cancel();

		$orderData =& $model->getOrder($id[0]) ;
		$orderItems =& $model->getOrderItems($id[0]) ;
		$settings =& $model->getSettings();
        $customer =& $model->getCustomerData($orderData[0]->user_id);

		// build list of Order_status
		$statuslist[]         = JHTML::_('select.option',  '0', JText::_( 'CHANGE ORDER STATUS' ), 'id', 'name' );
		$statuslist         = array_merge( $statuslist, $model->getListOfStatusForSelect() );
		$lists['status']      = JHTML::_('select.genericlist', $statuslist, 'status', 'class="inputbox" size="1"','id', 'name', $orderData[0]->status, 'statusSelect' );


		$this->assignRef( 'lists', $lists );
		$this->assignRef( 'orderData', $orderData[0] );
		$this->assignRef( 'orderItems', $orderItems );
		$this->assignRef( 'settings', $settings );
        $this->assignRef( 'customer', $customer);


		require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'orders'.DIRECTORY_SEPARATOR.'tmpl'.DIRECTORY_SEPARATOR.'form.php');

	}

	function printOrders($model) {

		$id	= JRequest::getVar('cid', array(0), 'method', 'array');

		$document = JFactory::getDocument();
		$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js');

		$orderData =& $model->getOrders($id, 'o.id desc, i.basketgroup asc') ;
		$orderItems =& $model->getOrderItems($id) ;
		$settings =& $model->getSettings();

		$this->assignRef( 'orderData', $orderData );
		$this->assignRef( 'orderItems', $orderItems );
		$this->assignRef( 'settings', $settings );

		$document->addStyleSheet('components/com_smartorder/css/printing.css');
		require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'orders'.DIRECTORY_SEPARATOR.'tmpl'.DIRECTORY_SEPARATOR.'print.php');

	}

	function getFormatedDateTime($timestamp)
	{
		$date =& JFactory::getDate($timestamp);
		return $date->format('Y-m-d H:i:s');
	}
}