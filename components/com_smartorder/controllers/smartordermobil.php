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

class SmartorderControllerSmartordermobil extends JControllerLegacy
{

    function __construct() {
		JRequest::setVar('view', 'smartordermobil', 'method', true);
        parent::__construct();
	}

	function display()
	{

		parent::display();
	}

    function registration()
	{
        $user =& JFactory::getUser();
        if (!$user->guest) {
            $returnURL = base64_encode(JFactory::getURI()->toString());
            jimport('joomla.version');
            $version = new JVersion();
            if (substr($version->getShortVersion(), 0, 3) == '1.5') {
                $logoutUrl = 'index.php?option=com_user&task=logout&return='.$returnURL;
            } else {
                $logoutUrl = JRoute::_('index.php?option=com_users&task=user.logout&'.JSession::getFormToken().'=1&return='.$returnURL);
            }
            echo JText::_('You are logged in') . ' ' . JText::sprintf('LOGOUT TO REGISTER', '<a href="'.$logoutUrl.'">' . JText::_('SO LOGOUT') . '</a>');
            return false;
        }

        if (isset($_REQUEST["name"])) {

            include_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'functions.php');
            if (JRequest::getVar('name')=='' or JRequest::getVar('email')=='' or JRequest::getVar('address')==''
                or JRequest::getVar('phone')=='' or JRequest::getVar('password')=='') echo outMsg(JText::_('All data is required!'), 'error');
            elseif (!validEmail(JRequest::getVar('email'))) echo outMsg(JText::_('E-mail is incorrect!'), 'error');
            elseif (JRequest::getVar('password') <> JRequest::getVar('password2') ) echo outMsg(JText::_('Password error!'), 'error');
            else {

                $name = trim(JRequest::getVar('name'));
                $address = trim(JRequest::getVar('address'));
                $phone = trim(JRequest::getVar('phone'));
                $email = trim(JRequest::getVar('email'));
                $password = trim(JRequest::getVar('password'));

                $acl =& JFactory::getACL();

                jimport('joomla.application.component.helper'); // include libraries/application/component/helper.php
                $usersParams = &JComponentHelper::getParams( 'com_users' ); // load the Params

                // "generate" a new JUser Object
                $user = JFactory::getUser(0); // it's important to set the "0" otherwise your admin user information will be loaded

                $data = array(); // array for all user settings
                $usertype = 'Registered';
                $data['name'] = $name; // add first- and lastname
                $data['username'] = $email; // add username
                $data['email'] = $email; // add email
                $data['gid'] = $acl->get_group_id( '', $usertype, 'ARO' );  // generate the gid from the usertype
                /* no need to add the usertype, it will be generated automaticaly from the gid */
                $data['password'] = $password; // set the password
                $data['password2'] = $password; // confirm the password
                $data['sendEmail'] = 0; // should the user receive system mails?
                $data['block'] = 0; // don't block the user

                if (!$user->bind($data)) { // now bind the data to the JUser Object, if it not works....
                    echo outMsg(JText::_( $user->getError()),'error'); // ...raise an Warning
                } else {
                    if (!$user->save()) { // if the user is NOT saved...
                        echo outMsg(JText::_( $user->getError()),'error'); // ...raise an Warning
                    } else {
                        # insert DB smartorder user data
                        $model = $this->getModel('Smartorder');
                        $model->insertUser($user->get('id'), $phone, $address, $email);

                        # login
                        $usersipass['username'] = $email;
                        $usersipass['password'] = $password;
                        $mainframe = & JFactory::getApplication();
                        $error = $mainframe->login($usersipass);

                        $session = JFactory::getSession();
                        $session->clear('ordName');
                        $session->clear('ordAddress');
                        $session->clear('ordPhone');
                        $session->clear('ordEmail');

                        global $mainframe;
                		$mainframe->redirect( 'index.php?option=com_smartorder&task=regokay');

                    }
                }
    		}
        }
        $view = & $this->getView('Smartordermobil','html');
        $view->regform();
    }

    function regokay() {
        $view = & $this->getView('Smartordermobil','html');
        $view->regokay();
    }

    function orderSaveAjax() {
		include(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'orderSaveAjax.php');
    }
}