<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */


interface PayPal {

    const SCHEME = 'https';
    const HOST_PRODUCTION = 'www.paypal.com';
    const HOST_DEVELOPMENT = 'www.sandbox.paypal.com';
    const PORT = 443;
    const PATH = '/cgi-bin/webscr';
}