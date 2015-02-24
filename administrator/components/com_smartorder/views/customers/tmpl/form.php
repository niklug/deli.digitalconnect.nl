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
<form action="index.php" method="post" name="adminForm" id="adminForm">

			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Details' ); ?></legend>

				<table class="admintable so-admintable">
				<tbody>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'NAME' ); ?>:
							</label>
						</td>
						<td>
							<input class="inputbox" type="text" name="name" id="name" size="50" value="<?php echo $this->customer->name;?>" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="address">
								<?php echo JText::_( 'ADDRESS' ); ?>:
							</label>
						</td>
						<td>
							<input class="inputbox" type="text" name="address" id="address" size="50" value="<?php echo $this->customer->address;?>" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="email">
								<?php echo JText::_( 'EMAIL' ); ?>:
							</label>
						</td>
						<td>
							<input class="inputbox" type="text" name="email" id="email" size="50" value="<?php echo $this->customer->email;?>" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="phone">
								<?php echo JText::_( 'PHONE' ); ?>:
							</label>
						</td>
						<td>
							<input class="inputbox" type="text" name="phone" id="phone" size="50" value="<?php echo $this->customer->phone;?>" />
						</td>
					</tr>
				</tbody>
				</table>


			</fieldset>
		<div class="clr"></div>

		<input type="hidden" name="controller" value="customers" />
		<input type="hidden" name="option" value="com_smartorder" />
		<input type="hidden" name="id" value="<?php echo $this->customer->id; ?>" />
		<input type="hidden" name="task" value="" />

</form>