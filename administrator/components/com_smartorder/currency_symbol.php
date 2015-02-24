<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

define('_JEXEC', 1);
define('JPATH_BASE', dirname(dirname(dirname(__FILE__))));

require_once JPATH_BASE.'/includes/defines.php';
require_once JPATH_BASE.'/includes/framework.php';

$app = JFactory::getApplication('site');
$app->initialise();

if (!empty($_GET['code'])) {
    $db = JFactory::getDBO();
    echo $db->setQuery(sprintf('SELECT * FROM #__smartorder_currency WHERE code LIKE %s', $db->quote($_GET['code'])))->loadObject()->symbol;
}

$app->close();