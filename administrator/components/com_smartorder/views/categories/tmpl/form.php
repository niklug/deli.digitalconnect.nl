<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');
?>
<style>#published0-lbl, #published1-lbl {min-width:27px !important;clear: none;}</style>
<form action="index.php" method="post" name="adminForm" id="adminForm">

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
				</tbody>
				</table>


			</fieldset>
		<div class="clr"></div>

		<input type="hidden" name="controller" value="categories" />
		<input type="hidden" name="option" value="com_smartorder" />
		<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
		<input type="hidden" name="task" value="" />

</form>