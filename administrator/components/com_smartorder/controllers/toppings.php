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

class SmartorderControllerToppings extends JControllerLegacy
{

	function __construct() {
		# ha nem jon view param, akkor erteket adunk
		# hogy a display jot jelenithessen meg !
		JRequest::setVar('view', 'toppings', 'method', false);
		parent::__construct();
	}

	function add()
	{
		$model = $this->getModel('Toppings');
		$view = & $this->getView('Toppings','html');
		$view->edit($model);
	}

	function edit()
	{
		$model = $this->getModel('Toppings');
		$view = & $this->getView('Toppings','html');
		$view->edit($model);
	}

	function save()
	{
		$db =& JFactory::getDBO();
		$post	= JRequest::get( 'post' );

		JTable::addIncludePath(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_smartorder'.DIRECTORY_SEPARATOR.'tables');
		$row =& JTable::getInstance('Toppings', 'Table');

		// handle vat
		$settings = JTable::getInstance('settings', 'Table');
		$settings->load(1);
		if ($settings->vat_handling == '1') {
			unset($post['price_gross']);
			if (floatval($post['vat_percent']) == $settings->vat_default_percent) {
				$post['vat_percent'] = null;
			}
		}

		if (!$row->bind( $post )) {
			return JError::raiseWarning( 500, $row->getError() );
		}

		if (!$row->store(true)) {
			return JError::raiseWarning( 500, $row->getError() );
		}

		if ($row->checkin()) {
			JFactory::getApplication()->enqueueMessage( JText::_( 'Topping saved' )  );
		}

		//parent::display();
		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=toppings&task=list');
	}

	function remove()
	{
		$model = $this->getModel('Toppings');
		$cntOfDeletedCategory = $model->deleteTopping(JRequest::getVar('cid'));

		if( $cntOfDeletedCategory == (int) $cntOfDeletedCategory and ($cntOfDeletedCategory > 0) ) {
			JFactory::getApplication()->enqueueMessage( JText::sprintf( 'Topping removed', count(JRequest::getVar('cid')) )  );
		} else {
			JError::raiseWarning( 100, 'Topping nem törölhető' );
		}
		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=toppings&task=list');
		//parent::display();
	}


	function publish()
	{
		$model = $this->getModel('Toppings');
		if( $model->changePublishTopping(JRequest::getVar('cid'), 1) ) {
			JFactory::getApplication()->enqueueMessage( JText::_( 'Topping successfully published' )  );
		}
		//parent::display();
		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=toppings&task=list');
	}

	function unpublish()
	{
		$model = $this->getModel('Toppings');
		if( $model->changePublishTopping(JRequest::getVar('cid'), 0) ) {
			JFactory::getApplication()->enqueueMessage( JText::_( 'Topping successfully unpublished' )  );
		}
		//parent::display();
		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=toppings&task=list');
	}

	function orderup() {

		$model = $this->getModel( 'Toppings' );

		$model->orderTopping(-1);

		//parent::display();
		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=toppings&task=list');

	}

	function orderdown() {

		$model = $this->getModel( 'Toppings' );

		$model->orderTopping(1);

		//parent::display();
		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=toppings&task=list');

	}

	function saveOrder() {

		$cid    = JRequest::getVar( 'cid', array( 0 ), 'post', 'array' );
		$order  = JRequest::getVar( 'order', array( 0 ), 'post', 'array' );
		JArrayHelper::toInteger( $order, array( 0 ) );

		$model  = $this->getModel( 'Toppings' );

		if( $model->saveOrderToppings( $cid, $order ) ) {
			JFactory::getApplication()->enqueueMessage( JText::_( 'New ordering saved' )  );
		}

		//parent::display();
		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=toppings&task=list');

	}


	function display()
	{
		parent::display();
	}
}