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
echo '<script type="text/javascript">
		$().ready(function() {
			window.print();
		});
		</script>';
?>
<p class="prn-back"><a href="?option=com_smartorder&controller=orders&task=list&status=0" >&laquo; Back to the order list</a></p>
<h1 class="printing"><?php echo JText::_( 'ORDER LIST PRINTED' ).': '.$this->getFormatedDateTime(time()); ?></h1>
<?php

for ($i=0; $i < count( $this->orderData ); $i++) {
	@$order = $this->orderData[$i];
	?>
	<fieldset class="adminform" style="margin:10px 0 15px 0">
		<legend><?php echo JText::_( 'ORDER ID' ); ?>: <?php echo str_pad($order->id, 6, "0", STR_PAD_LEFT);?></legend>
		<table class="admintable so-admintable">
			<tr>
				<td><?php echo JText::_( 'ORDER TIME' ); ?>:</td>
				<td><?php
                    echo substr($order->datetime,0,16);
				?></td>
				<td>&nbsp;</td>
				<td><?php echo JText::_( 'CUSTOMER NAME' ); ?>:</td>
				<td><b><?php echo $order->user_name; ?></b></td>
			</tr>
			<tr>
				<td><?php echo JText::_( 'STATUS' ); ?>:</td>
				<td ><?php echo $order->status_name; ?></td>
				<td>&nbsp;</td>
				<td><?php echo JText::_( 'ADDRESS' ); ?>:</td>
				<td ><b><?php echo $order->user_address; ?></b></td>
			</tr>
			<tr>
				<td><?php echo JText::_( 'TOTAL PRICE' ); ?>:</td>
				<td ><b><?php echo getFormattedPrice($order->total,$this->settings[0]) ?></b></td>
				<td>&nbsp;</td>
				<td><?php echo JText::_( 'PHONE' ); ?>:</td>
				<td ><?php echo $order->user_phone ?></td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
				<td><?php echo JText::_( 'EMAIL' ); ?>:</td>
				<td ><?php echo $order->user_email ?></td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
				<td><?php echo JText::_( 'NOTE OF CUSTOMER' ); ?>:</td>
				<td ><?php echo $order->user_note ?></td>
			</tr>
		</table>

		<table class="adminlist so-adminlist" >
	    <thead>
	        <tr>
	            <th class="so-align-center so-nowrap"><?php echo JText::_( '#' ); ?></th>
	            <th class="so-nowrap"><?php echo JText::_( 'NAME' ); ?></th>
				<th class="so-align-center so-nowrap"><?php echo JText::_( 'TYPE' ); ?></th>
				<th class="so-align-right so-nowrap"><?php echo JText::_( 'COUNT' ); ?></th>
				<th class="so-align-right so-nowrap"><?php echo JText::_( 'PRICE' ); ?></th>
				<th class="so-align-right so-nowrap"><?php echo JText::_( 'TOTAL' ); ?></th>
				<th>&nbsp;</th>
	        </tr>
	    </thead>
		<tbody>
	    <?php
	    for ($j=0; $j < count( $this->orderItems ); $j++)
	    {
	  		@$orderItem = $this->orderItems[$j];
			if ($orderItem->order_id == $order->id) {
				?>
		        <tr class="row0">
		            <td class="so-align-center so-nowrap"><?php echo $j+1 ?></td>
		            <td class="so-nowrap"><?php echo (($orderItem->type == 'i') ? '' : '&nbsp;&nbsp;&nbsp;&nbsp;&gt; ' ); ?><?php echo $orderItem->name; ?></td>
					<td class="so-align-center so-nowrap"><?php echo (($orderItem->type == 'i') ? JText::_( 'ITEM' ) : JText::_( 'TOPPING' ) ); ?></td>
		            <td class="so-align-right so-nowrap"><?php echo $orderItem->count;?></td>
					<td class="so-align-right so-nowrap"><?php echo getFormattedPrice($orderItem->price,$this->settings[0]);?></td>
					<td class="so-align-right so-nowrap"><?php echo getFormattedPrice($orderItem->total,$this->settings[0]);?></td>
					<td>&nbsp;</td>
		        </tr>
		        <?php
			}
	    }
	    ?>
	    </tbody>
	    </table>

	</fieldset>
<?php
}