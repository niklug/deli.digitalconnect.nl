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

class SmartorderControllerItems extends JControllerLegacy
{

	function __construct() {
		# ha nem jon view param, akkor erteket adunk
		# hogy a display jot jelenithessen meg !
		JRequest::setVar('view', 'items', 'method', false);
		parent::__construct();
	}

	function add()
	{
		$model = $this->getModel('items');
		$view = & $this->getView('items','html');
		$view->edit($model);
	}

	function edit()
	{
		$model = $this->getModel('items');
		$view = & $this->getView('items','html');
		$view->edit($model);
	}

	function save()
	{
		$db =& JFactory::getDBO();
		$post	= JRequest::get( 'post' );

		JTable::addIncludePath(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_smartorder'.DIRECTORY_SEPARATOR.'tables');
		$row =& JTable::getInstance('items', 'Table');

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
			JFactory::getApplication()->enqueueMessage( JText::_( 'Item saved' )  );
		}


        // Photo handling
        $image_folder = JPATH_SITE . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "com_smartorder" . DIRECTORY_SEPARATOR;
        if (!file_exists($image_folder)) mkdir($image_folder);

        $file = JRequest::getVar('file_upload', null, 'files', 'array');
        jimport('joomla.filesystem.file');
        include_once(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_smartorder'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'functions.php');
        jimport('joomla.filesystem.file');
        if ( strtolower(JFile::getExt($file['name']) ) == 'jpg') {
            $src = $file['tmp_name'];
            $img_tmp = $image_folder . $row->id . "_temp.jpg";
            $img_thumb = $image_folder . $row->id . "_thumb.jpg";
            $img_big = $image_folder . $row->id . ".jpg";
            JFile::upload($src, $img_tmp);
            createJPG($img_tmp,$img_thumb,60,60);
            createJPG($img_tmp,$img_big,800,600);
            unlink($img_tmp);
        }

        if (isset($_REQUEST["delPic"])) {
            unlink($image_folder . $row->id . "_thumb.jpg");
            unlink($image_folder . $row->id . ".jpg");
        }
        // End Of Photo handling

		parent::display();
	}

	function remove()
	{
		$model = $this->getModel('Items');
		$cntOfDeletedCategory = $model->deleteItem(JRequest::getVar('cid'));

		if( $cntOfDeletedCategory == (int) $cntOfDeletedCategory and ($cntOfDeletedCategory > 0) ) {
			JFactory::getApplication()->enqueueMessage( JText::sprintf( 'Items removed', count(JRequest::getVar('cid')) )  );
		} else {
			JError::raiseWarning( 100, 'Item nem törölhető' );
		}
		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=items&task=list');

	}


	function publish()
	{
		$model = $this->getModel('Items');
		if( $model->changePublishItem(JRequest::getVar('cid'), 1) ) {
			JFactory::getApplication()->enqueueMessage( JText::_( 'Item successfully published' )  );
		}
		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=items&task=list');
	}

	function unpublish()
	{
		$model = $this->getModel('Items');
		if( $model->changePublishItem(JRequest::getVar('cid'), 0) ) {
			JFactory::getApplication()->enqueueMessage( JText::_( 'Item successfully unpublished' )  );
		}
		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=items&task=list');
	}

	function orderup() {

		$model = $this->getModel( 'Items' );

		$model->orderItem(-1);

		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=items&task=list');

	}

	function orderdown() {

		$model = $this->getModel( 'Items' );

		$model->orderItem(1);

		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=items&task=list');

	}

	function saveOrder() {

		$cid    = JRequest::getVar( 'cid', array( 0 ), 'post', 'array' );
		$order  = JRequest::getVar( 'order', array( 0 ), 'post', 'array' );
		JArrayHelper::toInteger( $order, array( 0 ) );

		$model  = $this->getModel( 'Items' );

		if( $model->saveOrderItems( $cid, $order ) ) {
			JFactory::getApplication()->enqueueMessage( JText::_( 'New ordering saved' )  );
		}

		$mainframe = JFactory::getApplication();
		$mainframe->redirect( 'index.php?option=com_smartorder&controller=items&task=list');

	}


	function display()
	{

		parent::display();
	}
}