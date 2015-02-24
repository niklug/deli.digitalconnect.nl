<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');
require_once JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_smartorder'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'functions.php';
JHTML::_('behavior.tooltip');
?>
<script type="text/javascript" src="<?php echo JURI::base(true).'/components/com_smartorder/js/jquery-1.8.2.min.js' ?>"></script>
<script type="text/javascript">$.noConflict();</script>
<script type="text/javascript" src="<?php echo JURI::base(true).'/components/com_smartorder/js/currency_symbol.js' ?>"></script>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'PAYMENT METHODS' ); ?></legend>
			<table class="admintable so-admintable">
			<tbody>
				<tr>
					<td class="key" style="width:170px">
						<label for="payment_methods">
							<?php echo JText::_( 'AVAILABLE PAYMENT METHODS' ); ?>:
						</label>
					</td>
					<td >
					    <fieldset class="radio">
<?php
$pm = explode(',', $this->row->payment_methods);
foreach ($this->paymentMethodOptions as $key => $value):
?>
                            <input type="checkbox" id="payment_methods_<?php echo htmlspecialchars($key) ?>" name="payment_methods[]" value="<?php echo htmlspecialchars($key) ?>"<?php echo in_array($key, $pm) ? ' checked="checked"' : '' ?> />
                            <label for="payment_methods_<?php echo htmlspecialchars($key) ?>"><?php echo htmlspecialchars($value) ?></label><br />
<?php
endforeach;
?>
					    </fieldset>
				    </td>
				</tr>
			</tbody>
			</table>
		</fieldset>
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'PRICE AND LIMITS' ); ?></legend>
			<table class="admintable so-admintable">
			<tbody>
				<tr>
					<td class="key" style="width:170px">
						<label for="minimum_order_price">
							<?php echo JText::_( 'ORDER TOTAL PRICE MINIMUM' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="minimum_order_price" id="minimum_order_price" size="20" value="<?php echo getFormattedInputPrice($this->row->minimum_order_price, $this->row);?>" />
						<?php echo JHTML::tooltip(JText::_('ORDER TOTAL PRICE MINIMUM INFO'), '', 'tooltip.png'); ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="shipping_cost">
							<?php echo JText::_( 'PRICE OF DELIVERY' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="shipping_cost" id="shipping_cost" size="20" value="<?php echo getFormattedInputPrice($this->row->shipping_cost, $this->row);?>" />
						<?php echo JHTML::tooltip(JText::_('PRICE OF DELIVERY INFO'), '', 'tooltip.png'); ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="free_shipping_limit">
							<?php echo JText::_( 'FREE SHIPPING LIMIT' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="free_shipping_limit" id="free_shipping_limit" size="20" value="<?php echo getFormattedInputPrice($this->row->free_shipping_limit, $this->row);?>" />
						<?php echo JHTML::tooltip(JText::_('FREE SHIPPING LIMIT INFO'), '', 'tooltip.png'); ?>
					</td>
				</tr>
			</tbody>
			</table>
		</fieldset>


		<fieldset class="adminform">
			<legend><?php echo JText::_( 'OPEN_TIME_ORDER_RECEIVE_PERIOD' ); ?></legend>
			<table class="admintable so-admintable">
			<tbody>
				<script>
                function nonstop(){
                    document.getElementById('open_Mon_from_H').selectedIndex=0;document.getElementById('open_Mon_from_M').selectedIndex=0;
                    document.getElementById('open_Tue_from_H').selectedIndex=0;document.getElementById('open_Tue_from_M').selectedIndex=0;
                    document.getElementById('open_Wed_from_H').selectedIndex=0;document.getElementById('open_Wed_from_M').selectedIndex=0;
                    document.getElementById('open_Thu_from_H').selectedIndex=0;document.getElementById('open_Thu_from_M').selectedIndex=0;
                    document.getElementById('open_Fri_from_H').selectedIndex=0;document.getElementById('open_Fri_from_M').selectedIndex=0;
                    document.getElementById('open_Sat_from_H').selectedIndex=0;document.getElementById('open_Sat_from_M').selectedIndex=0;
                    document.getElementById('open_Sun_from_H').selectedIndex=0;document.getElementById('open_Sun_from_M').selectedIndex=0;

                    document.getElementById('open_Mon_to_H').selectedIndex=23;document.getElementById('open_Mon_to_M').selectedIndex=59;
                    document.getElementById('open_Tue_to_H').selectedIndex=23;document.getElementById('open_Tue_to_M').selectedIndex=59;
                    document.getElementById('open_Wed_to_H').selectedIndex=23;document.getElementById('open_Wed_to_M').selectedIndex=59;
                    document.getElementById('open_Thu_to_H').selectedIndex=23;document.getElementById('open_Thu_to_M').selectedIndex=59;
                    document.getElementById('open_Fri_to_H').selectedIndex=23;document.getElementById('open_Fri_to_M').selectedIndex=59;
                    document.getElementById('open_Sat_to_H').selectedIndex=23;document.getElementById('open_Sat_to_M').selectedIndex=59;
                    document.getElementById('open_Sun_to_H').selectedIndex=23;document.getElementById('open_Sun_to_M').selectedIndex=59;
                }
                </script>
				<tr>
					<td class="key" style="width:170px">
						<?php echo JText::_( 'Monday' ); ?>:
					</td>
					<td >
						<?php echo $this->lists['open_Mon_from_H'] . JText::_( 'hour' ).' : ' . $this->lists['open_Mon_from_M'] . JText::_( 'minute' )?>&nbsp;-&nbsp;
						<?php echo $this->lists['open_Mon_to_H'] . JText::_( 'hour' ).' : ' . $this->lists['open_Mon_to_M'] . JText::_( 'minute' )?>
					</td>
				</tr>
				<tr>
					<td class="key" style="width:170px">
						<?php echo JText::_( 'Tuesday' ); ?>:
					</td>
					<td >
						<?php echo $this->lists['open_Tue_from_H'] . JText::_( 'hour' ).' : ' . $this->lists['open_Tue_from_M'] . JText::_( 'minute' )?>&nbsp;-&nbsp;
						<?php echo $this->lists['open_Tue_to_H'] . JText::_( 'hour' ).' : ' . $this->lists['open_Tue_to_M'] . JText::_( 'minute' )?>
					</td>
				</tr>
				<tr>
					<td class="key" style="width:170px">
						<?php echo JText::_( 'Wednesday' ); ?>:
					</td>
					<td >
						<?php echo $this->lists['open_Wed_from_H'] . JText::_( 'hour' ).' : ' . $this->lists['open_Wed_from_M'] . JText::_( 'minute' )?>&nbsp;-&nbsp;
						<?php echo $this->lists['open_Wed_to_H'] . JText::_( 'hour' ).' : ' . $this->lists['open_Wed_to_M'] . JText::_( 'minute' )?>
					</td>
				</tr>
				<tr>
					<td class="key" style="width:170px">
						<?php echo JText::_( 'Thursday' ); ?>:
					</td>
					<td >
						<?php echo $this->lists['open_Thu_from_H'] . JText::_( 'hour' ).' : ' . $this->lists['open_Thu_from_M'] . JText::_( 'minute' )?>&nbsp;-&nbsp;
						<?php echo $this->lists['open_Thu_to_H'] . JText::_( 'hour' ).' : ' . $this->lists['open_Thu_to_M'] . JText::_( 'minute' )?>
					</td>
				</tr>
				<tr>
					<td class="key" style="width:170px">
						<?php echo JText::_( 'Friday' ); ?>:
					</td>
					<td >
						<?php echo $this->lists['open_Fri_from_H'] . JText::_( 'hour' ).' : ' . $this->lists['open_Fri_from_M'] . JText::_( 'minute' )?>&nbsp;-&nbsp;
						<?php echo $this->lists['open_Fri_to_H'] . JText::_( 'hour' ).' : ' . $this->lists['open_Fri_to_M'] . JText::_( 'minute' )?>
					</td>
				</tr>
				<tr>
					<td class="key" style="width:170px">
						<?php echo JText::_( 'Saturday' ); ?>:
					</td>
					<td >
						<?php echo $this->lists['open_Sat_from_H'] . JText::_( 'hour' ).' : ' . $this->lists['open_Sat_from_M'] . JText::_( 'minute' )?>&nbsp;-&nbsp;
						<?php echo $this->lists['open_Sat_to_H'] . JText::_( 'hour' ).' : ' . $this->lists['open_Sat_to_M'] . JText::_( 'minute' )?>
					</td>
				</tr>
				<tr>
					<td class="key" style="width:170px">
						<?php echo JText::_( 'Sunday' ); ?>:
					</td>
					<td >
						<?php echo $this->lists['open_Sun_from_H'] . JText::_( 'hour' ).' : ' . $this->lists['open_Sun_from_M'] . JText::_( 'minute' )?>&nbsp;-&nbsp;
						<?php echo $this->lists['open_Sun_to_H'] . JText::_( 'hour' ).' : ' . $this->lists['open_Sun_to_M'] . JText::_( 'minute' )?>
					</td>
				</tr>
                <tr>
					<td>
						&nbsp;
					</td>
					<td >
						<a href="javascript:;" onclick="nonstop();">NON-STOP</a>
					</td>
				</tr>

			</tbody>
			</table>
		</fieldset>


		<fieldset class="adminform">
			<legend><?php echo JText::_( 'CURRENCY SETTINGS' ); ?></legend>
			<table class="admintable so-admintable">
			<tbody>
				<tr>
					<td class="key" style="width:170px">
						<label for="currency_code">
							<?php echo JText::_( 'CURRENCY' ); ?>:
						</label>
					</td>
					<td >
						<?php echo $this->lists['currency_code']; ?>
						<?php echo JHTML::tooltip(JText::_('CURRENCY INFO'), '', 'tooltip.png') ?>
					</td>
				</tr>
				<tr>
					<td class="key" style="width:170px">
						<label for="currency_symbol">
							<?php echo JText::_( 'CURRENCY SYMBOL' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="currency_symbol" id="currency_symbol" size="5" value="<?php echo $this->row->currency_symbol;?>" />
						<?php // echo JHTML::tooltip('This is the tooltip text', '', 'tooltip.png'); ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="currency_display">
							<?php echo JText::_( 'CURRENCY DISPLAY STYLE' ); ?>:
						</label>
					</td>
					<td >
						<?php echo $this->lists['currency_display']; ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="currency_decimal">
							<?php echo JText::_( 'DECIMALS' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="currency_decimal" id="currency_decimal" size="5" value="<?php echo $this->row->currency_decimal;?>" />
						<?php //echo JHTML::tooltip('This is the tooltip text', '', 'tooltip.png'); ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="currency_decimal_symbol">
							<?php echo JText::_( 'DECIMAL SYMBOL' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="currency_decimal_symbol" id="currency_decimal_symbol" size="5" value="<?php echo $this->row->currency_decimal_symbol;?>" />
						<?php //echo JHTML::tooltip('This is the tooltip text', '', 'tooltip.png'); ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="currency_thousand_separator">
							<?php echo JText::_( 'THOUSANDS SEPARATOR' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="currency_thousand_separator" id="currency_thousand_separator" size="5" value="<?php echo $this->row->currency_thousand_separator;?>" />
						<?php //echo JHTML::tooltip('This is the tooltip text', '', 'tooltip.png'); ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="vat_handling">
							<?php echo JText::_( 'VAT HANDLING' ); ?>:
						</label>
					</td>
					<td >
						<?php echo $this->lists['vat_handling']; ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="vat_default_percent">
							<?php echo JText::_( 'DEFAULT VAT PERCENT' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="vat_default_percent" id="vat_default_percent" size="5" value="<?php echo getFormattedInputPrice($this->row->vat_default_percent, $this->row);?>" />%
						<?php //echo JHTML::tooltip('This is the tooltip text', '', 'tooltip.png'); ?>
					</td>
				</tr>
			</tbody>
			</table>
		</fieldset>

		<fieldset class="adminform">
			<legend><?php echo JText::_( 'ORDERFORM SETTINGS' ); ?></legend>
			<table class="admintable so-admintable">
			<tbody>
				<tr>
					<td class="key" style="width:170px">
						<label for="orderform_default_items">
							<?php echo JText::_( 'ITEMS TO DISPLAY' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="orderform_default_items" id="orderform_default_items" size="5" value="<?php echo $this->row->orderform_default_items;?>" />
						<?php //echo JHTML::tooltip('This is the tooltip text', '', 'tooltip.png'); ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="orderform_default_infotext">
							<?php echo JText::_( 'DEFAULT ORDER FORM INFO TEXT' ); ?>:
						</label>
					</td>
					<td >
						<textarea class="inputbox" cols="40" rows="5" name="orderform_default_infotext" id="orderform_default_infotext"><?php echo $row->orderform_default_infotext;?></textarea>
					</td>
				</tr>
			</tbody>
			</table>
		</fieldset>


		<fieldset class="adminform">
			<legend><?php echo JText::_( 'TERM OF SERVICE' ); ?></legend>
			<table class="admintable so-admintable">
			<tbody>
				<tr>
					<td class="key" style="width:170px">
						<label for="orderform_default_items">
							<?php echo JText::_( 'URL' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="termsofservice_url" id="termsofservice_url" size="100" value="<?php echo $row->termsofservice_url;?>" />
					</td>
				</tr>
			</tbody>
			</table>

			<?php
				// parameters : areaname, content, width, height, cols, rows, show xtd buttons
				// $editor =& JFactory::getEditor();
				// echo $editor->display( 'termsofservice',  htmlspecialchars($row->termsofservice, ENT_QUOTES), '800', '300', '60', '20', array('pagebreak', 'readmore') ) ;
			?>
		</fieldset>

<input type="hidden" name="controller" value="settings" />
<input type="hidden" name="option" value="com_smartorder" />
<input type="hidden" name="task" value="edit" />
<input type="hidden" name="id" value="1" />
</div>
</form>