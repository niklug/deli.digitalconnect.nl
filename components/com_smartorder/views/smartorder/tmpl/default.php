<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');
include_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'functions.php');
?>

<div class="container">

<form name="x" action="">
<input type="hidden" name="shipcost" id="shipcost" value="<?php echo $this->Settings->shipping_cost; ?>"/>
<input type="hidden" name="freeshiplimit" id="freeshiplimit" value="<?php echo $this->Settings->free_shipping_limit; ?>"/>
<input type="hidden" name="defaultitems" />
<input type="hidden" name="minrequiredsum" id="minrequiredsum" value="<?php echo $this->Settings->minimum_order_price; ?>"/>
<input type="hidden" name="totalitems" id="totalitems" />
<input type="hidden" name="basketid" id="basketid" value="0" />
<input type="hidden" name="temp" id="temp" value="0" />

<input type="hidden" name="closed" id="closed" value="<?=(($this->OpenOrClosed=='closed') ? '1' : '0')?>" />

<input type="hidden" name="txt_shipping_1" id="txt_shipping_1" value="<?php echo JText::sprintf('FREE SHIPPING LIMIT',getFormattedPrice($this->Settings->free_shipping_limit,$this->Settings)); ?>" />
<input type="hidden" name="txt_shipping_2" id="txt_shipping_2" value="<?php echo JText::sprintf('SHIPPING INCLUDED BELLOW',getFormattedPrice($this->Settings->shipping_cost,$this->Settings),getFormattedPrice($this->Settings->free_shipping_limit,$this->Settings));?>"/>
<input type="hidden" name="txt_shipping_3" id="txt_shipping_3" value="<?php echo JText::sprintf('SHIPPING COST INCLUDED',getFormattedPrice($this->Settings->shipping_cost,$this->Settings)); ?>"/>
<input type="hidden" name="txt_shipping_4" id="txt_shipping_4" value="<?php echo JText::_('WITH FREE SHIPPING'); ?>"/>

<input type="hidden" name="txt_warn_1" id="txt_warn_1" value="<?php echo JText::_('MINIMUM REQUIRED ORDER').' '.getFormattedPrice($this->Settings->minimum_order_price,$this->Settings); ?>"/>
<input type="hidden" name="txt_warn_2" id="txt_warn_2" value="<?php echo JText::_('YOUT CART IS CURRENTLY EMPTY'); ?>"/>
<input type="hidden" name="txt_warn_3" id="txt_warn_3" value="<?php echo JText::_('CLICK CHECKOUT TO CONTINUE');?>"/>
<input type="hidden" name="txt_warn_4" id="txt_warn_4" value="<?php echo JText::_('FILL OUT CONTACT FORM');?>"/>

<?php
	switch ($this->Settings->currency_display) {
		case '00_Symb' : $format = '%n %s'; break;
		case '00Symb' : $format = '%n%s'; break;
		case 'Symb_00' : $format = '%s %n'; break;
		case 'Symb00' : $format = '%s%n'; break;
		default : $format = '%s%n';
	}
?>
<input type="hidden" name="currency" id="currency" value="<?php echo $this->Settings->currency_symbol ?>"/>
<input type="hidden" name="positiveformat" id="positiveformat" value="<?php echo $format?>"/>
<input type="hidden" name="negativeformat" id="negativeformat" value="-%s%n"/>
<input type="hidden" name="decimalsymbol" id="decimalsymbol" value="<?php echo $this->Settings->currency_decimal_symbol ?>"/>
<input type="hidden" name="digitgroupsymbol" id="digitgroupsymbol" value="<?php echo str_replace('_',' ',$this->Settings->currency_thousand_separator) ?>"/>
<input type="hidden" name="roundtodecimalplace" id="roundtodecimalplace" value="<?php echo $this->Settings->currency_decimal ?>"/>
<input type="hidden" name="groupdigits" id="groupdigits" value="true"/>

</form>

<script type="text/javascript">
	jQuery(document).ready(function() {

	txt_slider_topping_1 = "<?php echo JText::_('TXT_SLIDER_TOPPING_1');?>";
	txt_slider_topping_2 = "<?php echo JText::_('TXT_SLIDER_TOPPING_2');?>";
	txt_slider_item_1 = "<?php echo JText::_('TXT_SLIDER_ITEM_1');?>";

	formatted_freeshiplimit = jQuery(this).getFormattedPrice(jQuery("#freeshiplimit").val())
	formatted_shipcost = jQuery(this).getFormattedPrice(jQuery("#shipcost").val())
	formatted_minReqSum = jQuery(this).getFormattedPrice(jQuery("#minrequiredsum").val());

	txt_label_1 = {
    	"payondelivery": "<?php echo JText::_('ORDER NOW');?>",
    	"paypal": "<?php echo JText::_('ORDER PAYPAL');?>"
	};
	txt_label_2 = "<?php echo JText::_('CHECKOUT');?>";


    jQuery("a[rel='colorbox']").colorbox({slideshow:true});

	});
</script>

<div class="so-alertwrapper">
	<div class="so-alert">
		<span class="felkialto">!</span>
		<span class="alerttext"><?php echo JText::_('CLOSED TEXT').JText::_('CLOSED LINK');?> </span>
	</div>
	<br class="clr" />
</div>

<div class="so-clonewrapper">
	<?php include(dirname(__FILE__).DIRECTORY_SEPARATOR."oneitem.php");?>
</div>

<div class="so-clonewrapper-topping">
	<?php include(dirname(__FILE__).DIRECTORY_SEPARATOR."toppings.php");?>
</div>

<div class="so-clonewrapper-ok">
	<div class="so-contactblock-inner-ok">
		<div class="so-thank-head"><?php echo JText::_('THANKS FOR ORDER TITLE');?></div>
		<div class="so-thank-text">
			<?php echo JText::_('THANKS FOR ORDER DESC');?>
            <div class="so-thank-text-reginfo">
            <?php if (empty($this->user) || !($this->user->id > 0)) { ?>
                <br/><a href="index.php?option=com_smartorder&task=registration"><?php echo JText::_('REGISTER NOW');?> &raquo;</a> - <?php echo JText::_('REGISTER NOW WHY');?>
            <?php } ?>
            </div>
        </div>
	</div>
</div>

<div class="so-thank-text-reginfo-registeredNotlogged" >
    <br/><?php echo JText::_('ALREADY MEMBER');?> - <a href="index.php?option=com_users&view=reset"><?php echo JText::_('LOST PASSWORD');?> &raquo;</a>
</div>

<div class="so-clonewrapper-addmore">
	<div class="so-addmorebutton">
		<div class="so-addmorebutton-inner">
			<div class="so-addmore-text">
				<span class="menupcs">1</span>
				<?php echo JText::_('IN BASKET');?>
			</div>
			<div class="so-addmorebutton-controlblock">
				<a href="#" class="so-addmore-itembutton so-menu-up"></a>
				<a href="#" class="so-addmore-itembutton so-menu-down"></a>
				<a href="#" class="so-addmore-itembutton so-menu-delete"></a>
			</div>

		</div>
	</div>
</div>

<div class="so-clonewrapper-addtopping">
	<a class="so-menubutton so-addtopping" href="#"><span><?php echo JText::_('ADD TOPPING');?></span></a>
</div>

<div class="so-clonewrapper-addnew">
	<a class="so-menubutton so-addnew" href="#"><span><?php echo JText::_('ADD NEW EMPTY');?></span></a>
</div>

<div class="so-clonewrapper-addtobasket">
	<a class="so-menubutton so-addto" href="#"><span><?php echo JText::_('ADD TO BASKET');?></span></a>
</div>


<div class="so-clonewrapper-menutoppingblock">
	<div class="so-menutopping-block">
		<form action="#">
				<div class="so-menutopping-block-left">
				</div>
				<div class="so-menutopping-block-right">
				</div>
		</form>

	</div>
</div>


	<div class="so-block">
		<div class="so-block-belso so-all-rounded">
			<div class="so-cartblock">
				<div class="so-cartblock-head so-top-rounded">
					<div class="so-cartblock-head-inner">
						<div class="so-cartblock-head-item"><span><?php echo JText::_('ITEMS IN THE BASKET');?></span></div>
						<div class="so-cartblock-head-item" id="so-volumehead"><span><?php echo JText::_('VOLUME');?></span></div>
					</div>
				</div>
				<div class="so-cartblock-body">
					<div class="so-cartblock-items">
						<div class="so-cartblock-items-inner">
							<?php include(dirname(__FILE__).DIRECTORY_SEPARATOR."oneitem.php");?>
							<div class="so-item-placeholder"><span></span></div>
							<div class="so-item-placeholder"><span></span></div>
						</div>
					</div>
					<div class="so-cartblock-desc">
						<div class="so-cartblock-desc-belso" >
							<span id="slide-1"><?php echo $this->Settings->orderform_default_infotext;?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="so-totalblock">
				<div class="so-total">
					<span><?php echo JText::_('TOTAL');?>&nbsp;<span class="so-price">0</span> <span class="shippingmessage"></span></span>
				</div>
				<div class="so-notification">
					<div class="so-notification-sign"><span>!</span></div>
					<span class="so-notification-text"><span><?php echo JText::_('MINIMUM REQUIRED ORDER');?>0 </span></span>
				</div>
			</div>
			<div class="so-contactblock">
				<form action="#">

					<div class="so-contactblock-inner">
						<div class="so-contactblock-fieldblock">
									<div class="so-onecontactrow">
										<label for="so-contact-1"><?php echo JText::_('NAME');?></label>
										<input type="text" name="so-contact-1" id="so-contact-1" value="<?php echo isset($this->user) ? htmlspecialchars($this->user->name) : '' ?>" />
									</div>
									<div class="so-onecontactrow">
										<label for="so-contact-2"><?php echo JText::_('ADDRESS');?></label>
										<input type="text" name="so-contact-2" id="so-contact-2" value="<?php echo isset($this->user) ? htmlspecialchars($this->user->address) : '' ?>" />
									</div>
									<div class="so-onecontactrow">
										<label for="so-contact-3"><?php echo JText::_('PHONE');?></label>
										<input type="text" name="so-contact-3" id="so-contact-3" value="<?php echo isset($this->user) ? htmlspecialchars($this->user->phone) : '' ?>" />
									</div>
									<div class="so-onecontactrow">
										<label for="so-contact-4"><?php echo JText::_('EMAIL');?></label>
										<input type="text" name="so-contact-4" id="so-contact-4" value="<?php echo isset($this->user) ? htmlspecialchars($this->user->email) : '' ?>" />
									</div>
<?php
$paymentMethodOptions = array(
	'payondelivery' => JText::_('PAY ON DELIVERY'),
	'paypal' => JText::_('PAYPAL')
);
$paymenMethods = explode(',', $this->Settings->payment_methods);
if (count($paymenMethods) > 1):
?>
									<div class="so-onecontactrow">
										<label for="so-contact-6"><?php echo JText::_('PAYMENT METHOD');?></label>
										<select name="so-contact-6" id="so-contact-6">
<?php
	foreach ($paymentMethodOptions as $key => $value):
		if (in_array($key, $paymenMethods)):
?>
											<option value="<?php echo htmlspecialchars($key) ?>"><?php echo htmlspecialchars($value) ?></option>
<?php
		endif;
	endforeach;
?>
										</select>
									</div>
<?php
else:
?>
									<input type="hidden" name="so-contact-6" id="so-contact-6" value="<?php echo htmlspecialchars($paymenMethods[0]) ?>" />
<?php
endif;
?>
						</div>
						<div class="so-contactblock-noteblock">
							<div class="so-contactblock-noteblock-wrapper">
								<input type="hidden" name="def_notes_text" id="def_notes_text" value="<?php echo JText::_('NOTES');?>"/>
								<textarea id="so-contact-5" name="so-contact-5" ><?php echo JText::_('NOTES');?></textarea>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="so-bottomblock so-bottom-rounded">
				<div class="so-bottomblock-inner">
					<a href="#" class="so-ordernow"><span><?php echo JText::_('CHECKOUT');?></span></a>
					<?php
					echo (($this->Settings->termsofservice_url > '')
					? '<a class="so-agreeterms" href="'.$this->Settings->termsofservice_url.'" target="_blank">'.JText::_('I AGREE THE TERMS OF SERVICE').'</a>'
					: '')
					?>
				</div>
			</div>


		</div>
	</div>

	<p id="msgAjax"></p>


	<div class="so-menublock">
		<?php include(dirname(__FILE__).DIRECTORY_SEPARATOR."menu.php");?>
	</div>

    <div style="display:none" id="blockuicontent"><img src="<?php echo JURI::base() ?>components/com_smartorder/images/loading.gif" /></div>
</div>