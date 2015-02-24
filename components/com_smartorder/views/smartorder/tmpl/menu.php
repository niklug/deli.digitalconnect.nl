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
			$s .=(( file_exists( JPATH_ROOT . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "com_smartorder" . DIRECTORY_SEPARATOR . $oneItem->id . "_thumb.jpg" ) )
                            ? '<div class="thumb_cont">
									<a rel="colorbox" title="'.$oneItem->name.'" href="'. JURI::root() . "images/com_smartorder/" . $oneItem->id . ".jpg" .'">
										<img class="thumb" src="'. JURI::root() . "images/com_smartorder/" . $oneItem->id . "_thumb.jpg" .'" />
									</a>
								</div>'
                            : '').'
			<div class="so-onemenuitem">
						<div class="so-onemenuitem-upper">
							<h3>'.htmlspecialchars($oneItem->name).'</h3>
							<div class="so-menuitemcontroller">
								<a class="so-menubutton so-addto" href="#"><span>'.JText::_('ADD TO BASKET').'</span></a>
								<span class="so-menuitemprice">'.getFormattedPrice(getGrossPrice($oneItem, $this->Settings), $this->Settings).'</span>
							</div>
						</div>
						<div class="so-menudesc">
							'.htmlspecialchars($oneItem->description).'
						</div>
						<input type="hidden" name="menu-basketid" value="0" class="menu-basketid"/>
						<input type="hidden" name="so-menuitem-id" value="'.$oneItem->id.'" class="so-menuitem-id"/>
						<input type="hidden" name="so-menuitem-price" value="'.getGrossPrice($oneItem, $this->Settings).'" class="so-menuitem-price"/>
					</div>';
		}
	}
	if ($s > '') {
		echo '<h2><span class="so-menu-cat-name">'.htmlspecialchars($oneCategory->name).'</span><span class="so-menu-cat-up"><a href="#">'.JText::_('JUMP TO CART').'</a></span></h2>';
		echo $s;
	}
}