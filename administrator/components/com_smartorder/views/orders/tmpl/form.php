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
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'Details' ); ?></legend>

			<table class="admintable so-admintable">
			<tbody>
				<tr>
					<td class="key">
						<?php echo JText::_( 'ORDER ID' ); ?>:
					</td>
					<td>
						<?php echo str_pad($this->orderData->id, 6, "0", STR_PAD_LEFT);?>
					</td>
				</tr>
				<tr>
					<td class="key">
							<?php echo JText::_( 'ORDER TIME' ); ?>:
					</td>
					<td>
						<?php
							echo substr($this->orderData->datetime,0,16);

                            $datetime = strtotime($this->orderData->datetime);
							if ($this->orderData->status == '0') echo '&nbsp;&nbsp;&nbsp;('.round(((time()-$datetime)/60)).' '.JText::_( 'MIN. AGO' ).')';
						?>

					</td>
				</tr>
				<tr>
					<td class="key">
							<?php echo JText::_( 'CURRENT STATUS' ); ?>:
					</td>
					<td >
						<?php echo $lists['status']; ?>
					</td>
				</tr>
				<tr>
					<td class="key">
							<?php echo JText::_( 'TOTAL PRICE' ); ?>:
					</td>
					<td style="font-size:140%">
						<strong><?php echo getFormattedPrice($this->orderData->total,$this->settings[0]) ?></strong>
					</td>
				</tr>
			</tbody>
			</table>
		</fieldset>


		<fieldset class="adminform">
			<legend><?php echo JText::_( 'CUSTOMER DATA IN ORDER' ); ?></legend>

			<table class="admintable so-admintable" >
			<tbody>
				<tr>
					<td class="key">
						<?php echo JText::_( 'NAME' ); ?>:
					</td>
					<td>
						<input class="inputbox" type="text" name="user_name" id="user_name" size="50" value="<?php echo $this->orderData->user_name;?>" />
					</td>
                    <td rowspan="5" class="so-align-top">
                        <table style="margin-left:10px;padding:2px;background:#efefef" >
                        <?php if (!empty($this->customer) && $this->customer->id > 0) { ?>
                            <tr>
            					<td><?php echo JText::_( 'REGISTERED CUSTOMER' ); ?>:</td>
                                <td><a href="index.php?option=com_smartorder&controller=customers&task=edit&cid=<?php echo $this->customer->id ?>"><?php echo $this->customer->name ?></a></td>
                            </tr>
                            <tr>
            					<td><?php echo JText::_( 'ADDRESS, PHONE' ); ?>:</td>
                                <td><?php echo $this->customer->address ?> (<?php echo $this->customer->phone ?>)</td>
                            </tr>
                            <tr>
            					<td><?php echo JText::_( 'NUMBER OF ORDERS' ); ?>:</td>
                                <td><?php echo $this->customer->countOfOrders; ?></td>
                            </tr>
                            <tr>
            					<td><?php echo JText::_( 'SUM OF ORDER' ); ?>:</td>
                                <td><?php echo getFormattedPrice($this->customer->total,$this->settings[0]); ?></td>
                            </tr>
                        <?php } else { ?>
                            <tr>
            					<td><?php echo JText::_( 'NOT REGISTERED CUSTOMER!' ) ?></td>
                            </tr>
                        <?php } ?>
                        </table>
					</td>
				</tr>
				<tr>
					<td class="key">
							<?php echo JText::_( 'ADDRESS' ); ?>:
					</td>
					<td>
						<input class="inputbox" type="text" name="user_address" id="user_address" size="50" value="<?php echo $this->orderData->user_address;?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
							<?php echo JText::_( 'EMAIL' ); ?>:
					</td>
					<td >
						<input class="inputbox" type="text" name="user_email" id="user_email" size="50" value="<?php echo $this->orderData->user_email;?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
							<?php echo JText::_( 'PHONE' ); ?>:
					</td>
					<td >
						<input class="inputbox" type="text" name="user_phone" id="user_phone" size="50" value="<?php echo $this->orderData->user_phone;?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
							<?php echo JText::_( 'NOTE OF CUSTOMER' ); ?>:
					</td>
					<td >
						<?php echo nl2br($this->orderData->user_note) ?>
					</td>
				</tr>
			</tbody>
			</table>
		</fieldset>


		<fieldset class="adminform">
			<legend><?php echo JText::_( 'ORDERED ITEMS' ); ?></legend>

			<table class="adminlist so-adminlist" >
		    <thead>
		        <tr>
		            <th class="so-align-center so-nowrap">
		                <?php echo JText::_( '#' ); ?>
		            </th>
		            <th class="so-nowrap">
						<?php echo JText::_( 'NAME' ); ?>
					</th>
					<th class="so-align-center so-nowrap">
						<?php echo JText::_( 'TYPE' ); ?>
					</th>
					<th class="so-align-right so-nowrap">
						<?php echo JText::_( 'COUNT' ); ?>
					</th>
					<th class="so-align-right so-nowrap">
						<?php echo JText::_( 'PRICE' ); ?>
					</th>
					<th class="so-align-right so-nowrap">
						<?php echo JText::_( 'TOTAL' ); ?>
					</th>
					<th>
						&nbsp;
					</th>
		        </tr>
		    </thead>

			<tbody>
		    <?php
		    $k = 0;

		    for ($i=0, $n=count( $this->orderItems ); $i < $n; $i++)
		    {
		  		@$orderItem = $this->orderItems[$i];

		        ?>
		        <tr class="<?php echo "row" . $k; ?>">
		            <td class="so-align-center so-nowrap">
							<?php echo ($i + 1) ?>
		            </td>
		            <td class="so-nowrap">
						<?php echo ((strtoupper($orderItem->type) == 'T') ? '&nbsp;&nbsp;&nbsp;&raquo;&nbsp;' : '') . $orderItem->name; ?> (<?php echo $orderItem->category_name; ?>)
					</td>
					<td class="so-align-center so-nowrap">
						<?php echo ((strtoupper($orderItem->type) == 'I') ? JText::_( 'Item' ) : JText::_( 'Topping' ) ); ?>
		            </td>
		            <td class="so-align-right so-nowrap">
						<?php echo $orderItem->count;?>
					</td>
					<td class="so-align-right so-nowrap">
						<?php echo getFormattedPrice(getGrossPrice($orderItem,$this->settings[0]),$this->settings[0]);?>
					</td>
					<td class="so-align-right so-nowrap">
						<?php echo getFormattedPrice($orderItem->total,$this->settings[0]);?>
					</td>
					<td >
						&nbsp;
					</td>
		        </tr>
		        <?php
		        $k = 1 - $k;
		    }
		    ?>
		    </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="text-align: right;"><?php echo JText::_( 'TOTAL PRICE' ); ?>:</td>
                    <td style="text-align: right;"><strong><?php echo getFormattedPrice($this->orderData->total,$this->settings[0]); ?></strong></td>
                </tr>
            </tfoot>
		    </table>


		</fieldset>
		<div class="clr"></div>

		<input type="hidden" name="controller" value="orders" />
		<input type="hidden" name="option" value="com_smartorder" />
		<input type="hidden" name="id" value="<?php echo $this->orderData->id; ?>" />
		<input type="hidden" name="task" value="" />

</form>