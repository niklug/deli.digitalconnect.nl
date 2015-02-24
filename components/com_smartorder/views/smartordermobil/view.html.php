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

class SmartorderViewSmartordermobil extends JViewLegacy
{
	function display($tpl = null) {

		$document = JFactory::getDocument();
         $document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js');
         $document->addScript('components/com_smartorder/jscripts/jquery.easing.min.js');
         $document->addScript('components/com_smartorder/jscripts/jquery.colorbox.js');
		$document->addScript('components/com_smartorder/jscripts/inview.js');
		$document->addScript('components/com_smartorder/jscripts/jquery.hoverIntent.minified.js');
		$document->addScript('components/com_smartorder/jscripts/jquery.scrollTo-1.4.2-min.js');
		$document->addScript('components/com_smartorder/jscripts/jquery-ui-1.8.16.custom.min.js');
		$document->addScript('components/com_smartorder/jscripts/pulse.js');
		$document->addScript('components/com_smartorder/jscripts/smartordermobil.js');
		$document->addScript('components/com_smartorder/jscripts/jquery.formatCurrency-1.4.0.min.js');
		$document->addScript('components/com_smartorder/jscripts/jquery.blockUI.js');

		$document->addStyleSheet('components/com_smartorder/css/reset.css');
		$document->addStyleSheet('components/com_smartorder/css/smartordermobil.css');

		$model =& $this->getModel();
		$this->assignRef( 'ListOfCategory',	$model->getListOfCategory() );
		$this->assignRef( 'ListOfItem',	$model->getListOfItem() );
		$this->assignRef( 'ListOfTopping',	$model->getListOfTopping() );
		$settings = $model->getSettings();
		$this->assignRef( 'Settings',	$settings[0] );
        $this->assignRef( 'OpenOrClosed',	$model->getOpenOrClosed() );

        $user =& JFactory::getUser();
        if (!$user->guest) {
            $customer = $model->getUserData($user->get('id'));
            $this->assignRef( 'user',	$customer );
        } else {
            $customer->name = isset($_COOKIE["so_order_name"]) ? $_COOKIE["so_order_name"] : '';
            $customer->address = isset($_COOKIE["so_order_address"]) ? $_COOKIE["so_order_address"] : '';
            $customer->phone = isset($_COOKIE["so_order_phone"]) ? $_COOKIE["so_order_phone"] : '';
            $customer->email = isset($_COOKIE["so_order_email"]) ? $_COOKIE["so_order_email"] : '';
            $this->assignRef( 'user',	$customer );
        }

		parent::display($tpl);
	}

    function regokay()
	{
		require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'smartorder'.DIRECTORY_SEPARATOR.'tmpl'.DIRECTORY_SEPARATOR.'regokay.php');
	}

	function regform($tpl = null)
	{

		$document = JFactory::getDocument();
		$document->addScript('components/com_smartorder/jscripts/jquery-ui-1.8.16.custom.min.js');

		$document->addStyleSheet('components/com_smartorder/css/reset.css');
		$document->addStyleSheet('components/com_smartorder/css/smartorder.css');

		require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'smartorder'.DIRECTORY_SEPARATOR.'tmpl'.DIRECTORY_SEPARATOR.'regform.php');
	}
}