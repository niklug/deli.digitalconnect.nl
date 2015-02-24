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
?>
<?php if ($this->settings->vat_handling == '1'): ?>
<script type="text/javascript" src="<?php echo JURI::base(true).'/components/com_smartorder/js/jquery-1.8.2.min.js' ?>"></script>
<script type="text/javascript">$.noConflict();</script>
<script type="text/javascript" src="<?php echo JURI::base(true).'/components/com_smartorder/js/vat_handling.js' ?>"></script>
<?php endif; ?>
<style>#published0-lbl, #published1-lbl {min-width:27px !important;clear: none;}</style>
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

		<fieldset class="adminform">
			<legend><?php echo JText::_( 'Details' ); ?></legend>

			<table class="admintable so-admintable">
			<tbody>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Name' ); ?>:
						</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="name" id="name" size="50" value="<?php echo $this->row->name;?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="cid">
							<?php echo JText::_( 'CATEGORY NAME' ); ?>:
						</label>
					</td>
					<td >
						<?php echo $lists['cat_id']; ?>
					</td>
				</tr>
				<tr>
					<td class="so-align-top" class="key">
						<label for="description">
							<?php echo JText::_( 'DESCRIPTION' ); ?>:
						</label>
					</td>
					<td>
						<textarea class="inputbox" cols="70" rows="3" name="description" id="description"><?php echo $row->description;?></textarea>
					</td>
				</tr>
<?php if ($this->settings->vat_handling == '1'): ?>
				<tr>
					<td class="key">
						<label for="price">
							<?php echo JText::_( 'NET_PRICE' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="price" id="price" size="20" value="<?php echo getFormattedInputPrice($row->price, $this->settings);?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="price">
							<?php echo JText::_( 'VAT' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="vat_percent" id="vat_percent" size="20" value="<?php echo getFormattedInputPrice(getVatPercent($row, $this->settings), $this->settings);?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="price">
							<?php echo JText::_( 'GROSS_PRICE' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="price_gross" id="price_gross" size="20" value="<?php echo getFormattedInputPrice(getGrossPrice($row, $this->settings), $this->settings);?>" />
					</td>
				</tr>
<?php else: ?>
				<tr>
					<td class="key">
						<label for="price">
							<?php echo JText::_( 'PRICE_GROSS' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="price" id="price" size="20" value="<?php echo getFormattedInputPrice($row->price, $this->settings);?>" />
					</td>
				</tr>
<?php endif; ?>
				<tr style="display:none;">
					<td class="key">
						<label for="discount_price">
							<?php echo JText::_( 'DISCOUNT_PRICE_GROSS' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="discount_price" id="discount_price" size="20" value="<?php echo $this->row->discount_price;?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php echo JText::_( 'Published' ); ?>:
					</td>
					<td>
						<?php echo $this->lists['published']; ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ordering">
							<?php echo JText::_( 'Ordering' ); ?>:
						</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="ordering" id="ordering" size="6" value="<?php echo $this->row->ordering;?>" />
					</td>
				</tr>
                <tr>
					<td class="key" class="so-align-top">
						<label for="ordering">
							<?php echo JText::_( 'Change photo' ); ?> (.jpg):
						</label>
					</td>
					<td>
						<input type="file" name="file_upload" name="file_upload" />
                        <?
                        $thumb = JPATH_ROOT . "/images/com_smartorder/" . $this->row->id . "_thumb.jpg";
                        if (file_exists($thumb)) {
                            echo '<p style="clear: both"><img class="thumb" src="'. JURI::root() . "images/com_smartorder/" . $this->row->id . "_thumb.jpg" .'" /></p>';
                            echo '<p style="clear: both"><input type="checkbox" name="delPic" id="delPic" value="1"/> '.JText::_( 'delete photo' ).'</p>';
                        }
                        ?>

					</td>
				</tr>
			</tbody>
			</table>


		</fieldset>
		<div class="clr"></div>

		<input type="hidden" name="controller" value="items" />
		<input type="hidden" name="option" value="com_smartorder" />
		<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
		<input type="hidden" name="task" value="" />

</form>