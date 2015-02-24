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

$app = JFactory::getApplication();

if (strpos(strtolower($app->getTemplate()),'mobil')==true) {
    # mobil
    require_once( JPATH_COMPONENT.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.'smartordermobil.php' );
    $classname	= 'SmartorderControllerSmartordermobil';	
    
} else {
    # desktop
    require_once( JPATH_COMPONENT.DIRECTORY_SEPARATOR.'controller.php' );
    $classname	= 'SmartorderController';	
}

$controller	= new $classname();

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) ); # default task = 'display'

// Redirect if set by the controller
$controller->redirect();