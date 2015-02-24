<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');
include_once(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_smartorder'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'functions.php');
echo '<meta http-equiv="refresh" content="30"/>';
?>

<div id="dashb_left">
	<a class="dashb_icon" href="?option=com_smartorder&controller=categories&task=list">
        <img src="<?php echo JURI::root().'administrator/components/com_smartorder/images/btnCategories.png';?>"/>
        <?php echo JText::_('CATEGORIES'); ?>
    </a>
	<a class="dashb_icon" href="?option=com_smartorder&controller=items&task=list">
        <img src="<?php echo JURI::root().'administrator/components/com_smartorder/images/btnItems.png';?>"/>
        <?php echo JText::_('ITEMS'); ?>
    </a>
	<a class="dashb_icon" href="?option=com_smartorder&controller=toppings&task=list">
        <img src="<?php echo JURI::root().'administrator/components/com_smartorder/images/btnToppings.png';?>"/>
        <?php echo JText::_('TOPPINGS'); ?>
    </a>
	<a class="dashb_icon" href="?option=com_smartorder&controller=orders&task=list">
        <img src="<?php echo JURI::root().'administrator/components/com_smartorder/images/btnOrders.png';?>"/>
        <?php echo JText::_('ORDERS'); ?>
    </a>
    <a class="dashb_icon" href="?option=com_smartorder&controller=customers&task=list">
        <img src="<?php echo JURI::root().'administrator/components/com_smartorder/images/btnCustomers.png';?>"/>
        <?php echo JText::_('CUSTOMERS'); ?>
    </a>
    <a class="dashb_icon" href="?option=com_smartorder&controller=settings&task=edit">
        <img src="<?php echo JURI::root().'administrator/components/com_smartorder/images/btnSettings.png';?>"/>
        <?php echo JText::_('SETTINGS'); ?>
    </a>
    <a class="dashb_icon" href="?option=com_smartorder&controller=paypal&task=edit">
        <img src="<?php echo JURI::root().'administrator/components/com_smartorder/images/btnPayPal.png';?>"/>
        <?php echo JText::_('PAYPAL SETTINGS'); ?>
    </a>

</div>

<div id="dashb_right">
    <?php if ($this->CountOfNewOrder > 0) { ?>
	   <p class="title">
            <a href="?option=com_smartorder&controller=orders&task=list&status=0"><?php echo JText::_('DETAILED ORDER LIST');?> &raquo;</a>
            <img src="<?php echo JURI::root().'administrator/components/com_smartorder/images/redWarning.png';?>"/>
            &nbsp;<?=$this->CountOfNewOrder?> <?php echo JText::_('NEW ORDERS');?>
        </p>
    <?php } ?>
	<table class="adminlist so-adminlist neworders" >
	<thead>
        <tr>
            <th  class="so-align-center so-nowrap">
                <?php echo JText::_( 'ID' ); ?>
            </th>
            <th  class="so-nowrap">
            	<?php echo JText::_( 'ORDER DATE' ); ?>
			</th>
			<th class="so-nowrap">
				<?php echo JText::_( 'CUSTOMER NAME' ); ?>
			</th>
			<th  class="so-nowrap">
				<?php echo JText::_( 'ADDRESS' ); ?>
			</th>
			<th  class="so-align-right so-nowrap">
				<?php echo JText::_( 'TOTAL PRICE' ); ?>
			</th>
        </tr>
    </thead>
    <tbody>
	<?php
	$k = 0;

	if ($this->CountOfNewOrder == 0) { ?>

		<tr>
	            <td class="so-align-center" colspan="7">No new order</td>
  		</tr>

	<?php } else {

	    for ($i=0, $n=count( $this->orders ); $i < $n; $i++) {
	  		@$row = $this->orders[$i];

	  		$link = JRoute::_( 'index.php?option=com_smartorder&controller=orders&task=edit&cid='. $row->id );
	  		$link_print = JRoute::_( 'index.php?option=com_smartorder&controller=orders&task=printOrders&cid[]='. $row->id );

	        ?>
	        <tr class="<?php echo "row" . $k; ?>">
	            <td class="so-align-center so-nowrap">
					<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Order details' );?>">
					<?php echo str_pad($row->id, 6, "0", STR_PAD_LEFT); ?>
					</a>
	            </td>
	            <td class="so-nowrap">
					<?php echo substr($row->datetime, 0, 16); ?>
				</td>
	            <td class="so-nowrap">
					<?php echo $row->user_name;?>
				</td>
				<td class="so-nowrap">
					<?php echo $row->user_address;?>
				</td>
				<td class="so-align-right so-nowrap">
					<?php echo getFormattedPrice($row->Total,$this->settings[0]);?>
				</td>
	        </tr>
	        <?php
	        $k = 1 - $k;
	    }
    }
    ?>
    </tbody>
    </table>
    <br/>
    <p><?php echo JText::_( 'LAST DOWNLOAD' ); ?>: <?php echo date("H:i:d"); ?></p>
</div>