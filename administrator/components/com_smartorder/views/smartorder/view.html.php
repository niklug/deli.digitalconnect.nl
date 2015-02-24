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

class SmartorderViewSmartorder extends JViewLegacy
{
	function display($tpl = null)
	{

		JToolBarHelper::title(   JText::_( 'Smartorder Manager' ), 'generic.png' );

		$model =& $this->getModel();

		$this->assignRef( 'CountOfNewOrder',	$model->getCountOfOrder(array('0','10','12')) );
		$orders =& $model->getListOfOrder(array('0','10','12')) ;
		$this->assignRef( 'orders', $orders );
		$settings =& $model->getSettings();
		$this->assignRef( 'settings', $settings );

		parent::display($tpl);
	}
}