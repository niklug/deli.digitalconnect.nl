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
	for ($j=0; $j < count( $this->ListOfItem ); $j++) {
		$oneItem = $this->ListOfItem[$j];
		if ($oneItem->cat_id == $oneCategory->id) {
			$s .= '<div class="so-onemenuitem">
						<div class="so-onemenuitem-upper ">
							<h3>'.htmlspecialchars($oneItem->name).'</h3>
							<span class="so-menuitemprice">'.getFormattedPrice(getGrossPrice($oneItem, $this->Settings), $this->Settings).'</span>
						</div>
						<div class="so-menudesc">
							<div class="so-menuitemcontroller">
								<a class="so-menubutton so-addto" href="#"><span>'.JText::_('ADD TO BASKET').'</span></a>
							</div>
							<span class="so-mobi-desc">'.htmlspecialchars($oneItem->description).'</span>
						</div>
						<input type="hidden" name="menu-basketid" value="0" class="menu-basketid"/>
						<input type="hidden" name="so-menuitem-id" value="'.$oneItem->id.'" class="so-menuitem-id"/>
						<input type="hidden" name="so-menuitem-price" value="'.getGrossPrice($oneItem, $this->Settings).'" class="so-menuitem-price"/>
					</div>';
		}
	}
	if ($s > '') {
		echo '<div class="smartmob-menucatblock smartmobi-topcorner smartmobi-bottomcorner"><h2 class="smartmobi-topcorner"><span class="so-menu-cat-name">'.htmlspecialchars($oneCategory->name).'</span><span class="so-menu-cat-up"><a href="#">'.JText::_('JUMP TO CART MOBILE').'</a></span></h2>';
		echo $s;
		echo '</div>';
	}
}