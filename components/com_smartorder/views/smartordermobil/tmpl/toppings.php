<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

for ($i=0; $i < count( $this->ListOfCategory ); $i++) {
	$oneCategory = $this->ListOfCategory[$i];
	$s = '';
	$t = '';
	for ($j=0; $j < count( $this->ListOfTopping ); $j++) {
		$oneTopping = $this->ListOfTopping[$j];
		if ($oneTopping->cat_id == $oneCategory->id) {
			$s .= '<option value="'.$oneTopping->id.'">'.getFormattedPrice(getGrossPrice($oneTopping, $this->Settings), $this->Settings).' - '.htmlspecialchars($oneTopping->name).'</option>';
			$t .= '<input type="hidden" class="so-real-toppingprice" name="so-real-toppingprice-'.$oneTopping->id.'" value="'.getGrossPrice($oneTopping, $this->Settings).'" />' ;

		}
	}
	if ($s > '') { ?>

		<div class="so-onetopping">
			<div class="so-toppingarrow"></div>
			<select name="so-toppingselect-<?php echo $oneCategory->id ?>" id="so-toppingselect-<?php echo $oneCategory->id ?>" class="so-toppingselect">
				<option value="0" selected="selected"><?php echo JText::_('SELECT TOPPING IF YOU WANT SOME');?></option>
				<?php echo $s;?>
			</select>
			<div class="so-onetopping-controlblock">
				<a href="#" class="so-itembutton so-up-topping"></a>
				<a href="#" class="so-itembutton so-down-topping"></a>
				<a href="#" class="so-itembutton so-delete"></a>
			</div>
			<input type="hidden" name="so-price" class="so-price"/>
			<input type="hidden" name="so-topping-category" class="so-topping-category" value="<?php echo htmlspecialchars($oneCategory->name) ?>"/>
			<?php echo $t;?>
		</div>

	<?php
	}
}