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

require_once JPATH_BASE.'/../components/com_smartorder/paypal/PayPalSettings.php';

class SmartorderControllerSettings extends JControllerLegacy
{

	function __construct() {
		# ha nem jon view param, akkor erteket adunk
		# hogy a display jot jelenithessen meg !
		JRequest::setVar('view', 'settings', 'method', false);
		parent::__construct();
	}


	function edit()
	{
		$view = & $this->getView('settings','html');
		$view->edit();
	}

	function apply() {
        $this->doSave();
		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=settings&task=edit');
	}

	function save()
	{
        $this->doSave();
		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder');
	}

	function cancel()
	{
		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder');
	}


	function display()
	{
		parent::display();
	}


    private function doSave() {
        $db = JFactory::getDBO();
        $post = JRequest::get( 'post' );

        $pps = PayPalSettings::load();
        $pps->setCurrency($post['currency_code']);
        $pps->save();

        JTable::addIncludePath(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_smartorder'.DIRECTORY_SEPARATOR.'tables');
        $row =& JTable::getInstance('settings', 'Table');

        $post['payment_methods'] = array_key_exists('payment_methods', $post) ? implode(',', $post['payment_methods']) : '';

        if (!$row->bind( $post )) {
            return JError::raiseWarning( 500, $row->getError() );
        }

        if (!$row->store()) {
            return JError::raiseWarning( 500, $row->getError() );
        }

        if ($row->checkin()) {
            JFactory::getApplication()->enqueueMessage( JText::_( 'Settings saved' )  );
        }
    }
}