<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
    <div class="col">
        <fieldset class="adminform">
            <legend><?php echo JText::_('PAYPAL ACCESS') ?></legend>
            <table class="admintable so-admintable">
                <tr>
                    <td class="key" style="width:200px">
                        <label for="business"><?php echo JText::_('BUSINESS') ?>:</label>
                    </td>
                    <td >
                        <input class="inputbox" type="text" name="business" id="business" size="40" value="<?php echo htmlspecialchars($this->settings->getBusiness()) ?>" />
                        <?php echo JHTML::tooltip(JText::_('BUSINESS TIP'), '', 'tooltip.png') ?>
                    </td>
                </tr>
                <tr>
                    <td class="key" style="width:200px">
                        <label for="sandbox_mode"><?php echo JText::_('SANDBOX MODE') ?>:</label>
                    </td>
                    <td >
                        <?php echo $this->lists['sandbox_mode'] ?>
                        <?php echo JHTML::tooltip(JText::_('SANDBOX MODE TIP'), '', 'tooltip.png') ?>
                    </td>
                </tr>
            </table>
        </fieldset>
        <fieldset class="adminform">
            <legend><?php echo JText::_('ORDER STATUS UPDATE') ?></legend>
            <table class="admintable so-admintable">
                <tr>
                    <td class="key" style="width:200px">
                        <label for="order_status_successful"><?php echo JText::_('PAYMENT SUCCESSFUL') ?>:</label>
                    </td>
                    <td ><?php echo $this->lists['order_status_successful'] ?></td>
                </tr>
                <tr>
                    <td class="key" style="width:200px">
                        <label for="order_status_pending"><?php echo JText::_('PAYMENT PENDING') ?>:</label>
                    </td>
                    <td ><?php echo $this->lists['order_status_pending'] ?></td>
                </tr>
                <tr>
                    <td class="key" style="width:200px">
                        <label for="order_status_failed"><?php echo JText::_('PAYMENT FAILED') ?>:</label>
                    </td>
                    <td ><?php echo $this->lists['order_status_failed'] ?></td>
                </tr>
            </table>
        </fieldset>
        <fieldset class="adminform">
            <legend><?php echo JText::_('CUSTOMIZATION') ?></legend>
            <table class="admintable so-admintable">
                <tr>
                    <td class="key" style="width:200px">
                        <label for="send_gross_prices"><?php echo JText::_('SEND GROSS PRICES') ?>:</label>
                    </td>
                    <td >
                        <?php echo $this->lists['send_gross_prices'] ?>
                        <?php echo JHTML::tooltip(JText::_('SEND GROSS PRICES TIP'), '', 'tooltip.png') ?>
                    </td>
                </tr>
                <tr>
                    <td class="key" style="width:200px">
                        <label for="checkout_language"><?php echo JText::_('CHECKOUT LANGUAGE') ?>:</label>
                    </td>
                    <td >
                        <?php echo $this->lists['checkout_language'] ?>
                    </td>
                </tr>
                <tr>
                    <td class="key" style="width:200px">
                        <label for="use_shipping_info"><?php echo JText::_('USE SHIPPING INFORMATION') ?>:</label>
                    </td>
                    <td >
                        <?php echo $this->lists['use_shipping_info'] ?>
                        <?php echo JHTML::tooltip(JText::_('USE SHIPPING INFO TIP'), '', 'tooltip.png') ?>
                    </td>
                </tr>
                <tr>
                    <td class="key" style="width:200px">
                        <label for="header_image_url"><?php echo JText::_('HEADER IMAGE URL') ?>:</label>
                    </td>
                    <td >
                        <input class="inputbox" type="text" name="header_image_url" id="header_image_url" size="80" value="<?php echo htmlspecialchars($this->settings->getHeaderImageUrl()) ?>" />
                        <?php echo JHTML::tooltip(JText::_('HEADER IMAGE URL TIP'), '', 'tooltip.png') ?>
                    </td>
                </tr>
                <tr>
                    <td class="key" style="width:200px">
                        <label for="return_url"><?php echo JText::_('RETURN URL') ?>:</label>
                    </td>
                    <td >
                        <input class="inputbox" type="text" name="return_url" id="return_url" size="80" value="<?php echo htmlspecialchars($this->settings->getReturnUrl()) ?>" />
                        <?php echo JHTML::tooltip(JText::_('RETURN URL TIP'), '', 'tooltip.png') ?>
                    </td>
                </tr>
                <tr>
                    <td class="key" style="width:200px">
                        <label for="cancel_url"><?php echo JText::_('CANCEL URL') ?>:</label>
                    </td>
                    <td >
                        <input class="inputbox" type="text" name="cancel_url" id="cancel_url" size="80" value="<?php echo htmlspecialchars($this->settings->getCancelUrl()) ?>" />
                        <?php echo JHTML::tooltip(JText::_('CANCEL URL TIP'), '', 'tooltip.png') ?>
                    </td>
                </tr>
                <tr>
                    <td class="key" style="width:200px">
                        <label for="mail_to_buyer"><?php echo JText::_('MAIL TO BUYER') ?>:</label>
                    </td>
                    <td >
                        <?php echo $this->lists['mail_to_buyer'] ?>
                        <?php echo JHTML::tooltip(JText::_('MAIL TO BUYER TIP'), '', 'tooltip.png') ?>
                    </td>
                </tr>
                <tr>
                    <td class="key" style="width:200px">
                        <label for="mail_to_merchant"><?php echo JText::_('MAIL TO MERCHANT') ?>:</label>
                    </td>
                    <td >
                        <?php echo $this->lists['mail_to_merchant'] ?>
                        <?php echo JHTML::tooltip(JText::_('MAIL TO MERCHANT TIP'), '', 'tooltip.png') ?>
                    </td>
                </tr>
            </table>
        </fieldset>
        <input type="hidden" name="controller" value="paypal" />
        <input type="hidden" name="option" value="com_smartorder" />
        <input type="hidden" name="task" value="edit" />
    </div>
</form>