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

class SmartorderControllerCustomers extends JControllerLegacy
{

	function __construct() {
		# ha nem jon view param, akkor erteket adunk
		# hogy a display jot jelenithessen meg !
		JRequest::setVar('view', 'customers', 'method', false);
		parent::__construct();
	}

	function add()
	{
		$view = & $this->getView('customers','html');
		$view->edit();
	}

	function edit()
	{
        $model = $this->getModel('Customers');
		$view = & $this->getView('customers','html');
		$view->edit($model);
	}

	function save()
	{
		$db =& JFactory::getDBO();
		$post	= JRequest::get( 'post' );

        $model = $this->getModel('Customers');
        $model->updateUser(JRequest::getVar('id'), JRequest::getVar('name'), JRequest::getVar('email'), JRequest::getVar('address'), JRequest::getVar('phone'));

        JFactory::getApplication()->enqueueMessage( JText::_( 'Item saved' )  );

    	$mainframe = JFactory::getApplication();
    	$mainframe->redirect( 'index.php?option=com_smartorder&controller=customers&task=list');
	}


	function display()
	{
		parent::display();
	}
}