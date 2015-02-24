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

class SmartorderControllerCategories extends JControllerLegacy
{

	function __construct() {
		# ha nem jon view param, akkor erteket adunk
		# hogy a display jot jelenithessen meg !
		JRequest::setVar('view', 'categories', 'method', false);
		parent::__construct();
	}

	function add()
	{
		$view = & $this->getView('categories','html');
		$view->edit();
	}

	function edit()
	{
		$view = & $this->getView('categories','html');
		$view->edit();
	}

	function save()
	{
		$db =& JFactory::getDBO();
		$post	= JRequest::get( 'post' );

		JTable::addIncludePath(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_smartorder'.DIRECTORY_SEPARATOR.'tables');
		$row =& JTable::getInstance('categories', 'Table');

		if (!$row->bind( $post )) {
			return JError::raiseWarning( 500, $row->getError() );
		}

		if (!$row->store()) {
			return JError::raiseWarning( 500, $row->getError() );
		}

		if ($row->checkin()) {
			JFactory::getApplication()->enqueueMessage( JText::_( 'Item saved' )  );
		}

		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=categories&task=list');
	}

	function remove()
	{
		$model = $this->getModel('Categories');
		$cntOfDeletedCategory = $model->deleteCategory(JRequest::getVar('cid'));

		if( $cntOfDeletedCategory == (int) $cntOfDeletedCategory and ($cntOfDeletedCategory > 0) ) {
			JFactory::getApplication()->enqueueMessage( JText::sprintf( 'Items removed', count(JRequest::getVar('cid')) )  );
		} else {
			JError::raiseWarning( 100, 'A kategória nem törölhető, mivel tartalmaz elemeket!' );
		}
		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=categories&task=list');

	}


	function publish()
	{
		$model = $this->getModel('Categories');
		if( $model->changePublishCategory(JRequest::getVar('cid'), 1) ) {
			JFactory::getApplication()->enqueueMessage( JText::_( 'Category successfully published' )  );
		}
		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=categories&task=list');
	}

	function unpublish()
	{
		$model = $this->getModel('Categories');
		if( $model->changePublishCategory(JRequest::getVar('cid'), 0) ) {
			JFactory::getApplication()->enqueueMessage( JText::_( 'Category successfully unpublished' )  );
		}
		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=categories&task=list');
	}

	function orderup() {

		$model = $this->getModel( 'Categories' );

		$model->orderCategory(-1);

		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=categories&task=list');

	}

	function orderdown() {

		$model = $this->getModel( 'Categories' );

		$model->orderCategory(1);

		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=categories&task=list');

	}

	function saveOrder() {

		$cid    = JRequest::getVar( 'cid', array( 0 ), 'post', 'array' );
		$order  = JRequest::getVar( 'order', array( 0 ), 'post', 'array' );
		JArrayHelper::toInteger( $order, array( 0 ) );

		$model  = $this->getModel( 'Categories' );

		if( $model->saveOrderCategories( $cid, $order ) ) {
			JFactory::getApplication()->enqueueMessage( JText::_( 'New ordering saved' )  );
		}

		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=categories&task=list');

	}


	function display()
	{
		parent::display();
	}
}