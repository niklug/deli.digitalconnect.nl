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

class SmartorderControllerOrders extends JControllerLegacy
{

	function __construct() {
		# ha nem jon view param, akkor erteket adunk
		# hogy a display jot jelenithessen meg !
		JRequest::setVar('view', 'orders', 'method', false);
		parent::__construct();
	}


	function edit()
	{
		$model = $this->getModel('Orders');
		$view = & $this->getView('Orders','html');
		$view->edit($model);
	}

	function save()
	{
		$db =& JFactory::getDBO();
		$post	= JRequest::get( 'post' );

		JTable::addIncludePath(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_smartorder'.DIRECTORY_SEPARATOR.'tables');
		$row =& JTable::getInstance('Orders', 'Table');

		if (!$row->bind( $post )) {
			return JError::raiseWarning( 500, $row->getError() );
		}

		if (!$row->store()) {
			return JError::raiseWarning( 500, $row->getError() );
		}

		if ($row->checkin()) {
			JFactory::getApplication()->enqueueMessage( JText::_( 'Order saved' )  );
		}

//		parent::display();
		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=orders&task=list');
	}



	function remove()
	{
		$model = $this->getModel('Orders');
		$cntOfDeletedCategory = $model->deleteOrder(JRequest::getVar('cid'));

		if( $cntOfDeletedCategory == (int) $cntOfDeletedCategory and ($cntOfDeletedCategory > 0) ) {
			JFactory::getApplication()->enqueueMessage( JText::sprintf( 'Order removed', count(JRequest::getVar('cid')) )  );
		} else {
			JError::raiseWarning( 100, 'You cannot delete this order' );
		}
		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=orders&task=list');
		//parent::display();
	}


	function printOrders()
	{
		$model = $this->getModel('Orders');
		$view = & $this->getView('Orders','html');
		$view->printOrders($model);
	}


	function display()
	{

		parent::display();
	}
}