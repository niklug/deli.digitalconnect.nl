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

class SmartorderViewToppings extends JViewLegacy
{
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'Smartorder Manager &raquo; Toppings' ), 'generic.png' );
		JToolBarHelper::addNew();
		JToolBarHelper::editList();
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::deleteList('Are you sure to delete the checked items?');

		//error_reporting(E_ALL);

        $model =& $this->getModel();

        $mainframe = JFactory::getApplication();

		$filter_order	= (isset($_REQUEST["filter_order"]) ? JRequest::getVar("filter_order") : 'ordering');
		$filter_order_Dir = (isset($_REQUEST["filter_order_Dir"]) ? JRequest::getVar("filter_order_Dir") : '');
		$filter_state	= (isset($_REQUEST["filter_state"]) ? JRequest::getVar("filter_state") : '');
		$filter_catid	= (isset($_REQUEST["filter_catid"]) ? JRequest::getVar("filter_catid") : '');
		$search			= (isset($_REQUEST["search"]) ? JRequest::getVar("search") : '');
		$search				= JString::strtolower( $search );

    	$limit = (isset($_REQUEST["limit"]) ? JRequest::getVar("limit"):$mainframe->getCfg('list_limit'));
		$limitstart = (isset($_REQUEST["limitstart"]) ? JRequest::getVar("limitstart") : 0 );

		$where = array();
		if ( $filter_catid ) {
			$where[] = 'cat_id = '.(int) $filter_catid;
		}
		if ($search) {
			$where[] = 'LOWER(t.name) LIKE '.JFactory::getDbo()->quote( '%'.$search.'%' );
		}
		if ( $filter_state ) {
			if ( $filter_state == 'P' ) {
				$where[] = "t.published = '1'";
			} else if ($filter_state == 'U' ) {
				$where[] = "t.published = '0'";
			}
		}

		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );

		if ($filter_order == 'ordering'){
			$orderby 	= ' ORDER BY ordering ' . $filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '. $filter_order .' '. $filter_order_Dir .', name ';
		}

		$total = $model->getCountOfTopping($where) ;
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );

		$toppings =& $model->getListOfTopping($where, $orderby, $pageNav) ;

		// build list of Category
		$catlist[]         = JHTML::_('select.option',  '0', JText::_( 'SELECT CATEGORY' ), 'id', 'name' );
		$catlist         = array_merge( $catlist, $model->getListOfCategoryForSelect() );
		$lists['catid']      = JHTML::_('select.genericlist', $catlist, 'filter_catid', 'class="inputbox" size="1" onchange="document.adminForm.submit();"','id', 'name', intval( $filter_catid ) );


		// state filter
		$lists['state']	= JHTML::_('grid.state',  $filter_state );

		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;

		// search filter
		$lists['search']= $search;

		$settings = JTable::getInstance('settings', 'Table');
		$settings->load(1);

		$this->assignRef( 'toppings', $toppings ); # data to default.php
        $this->assignRef( 'lists', $lists );
        $this->assignRef( 'pageNav', $pageNav );
		$this->assignRef( 'settings', $settings );

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

		JToolBarHelper::title(   JText::_( 'Smartorder Manager &raquo; Topping '.$subTitle ), 'generic.png' );
		JToolBarHelper::save();
		JToolBarHelper::cancel();

		$db		=& JFactory::getDBO();
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_smartorder'.DIRECTORY_SEPARATOR.'tables');

		$row =& JTable::getInstance('toppings', 'Table');

		$row->load( $id[0] );

		$lists = array();
		$lists['published'] = JHTML::_('select.booleanlist',  'published', '', (!isset($_REQUEST["cid"]) ? 1 : $row->published) );


		// build list of Category
		$catlist[]         = JHTML::_('select.option',  '0', JText::_( 'Select Category' ), 'id', 'name' );
		$catlist         = array_merge( $catlist, $model->getListOfCategoryForSelect() );
		$lists['cat_id']      = JHTML::_('select.genericlist', $catlist, 'cat_id', 'class="inputbox" size="1"','id', 'name', $row->cat_id );

		$settings = JTable::getInstance('settings', 'Table');
		$settings->load(1);


		$this->assignRef( 'lists', $lists );
		$this->assignRef( 'row', $row );
		$this->assignRef( 'settings', $settings );

		require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'toppings'.DIRECTORY_SEPARATOR.'tmpl'.DIRECTORY_SEPARATOR.'form.php');

	}
}