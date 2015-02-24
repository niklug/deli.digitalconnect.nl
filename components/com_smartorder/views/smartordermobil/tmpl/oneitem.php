<div class="so-oneitem">
	<select name="so-itemselect-1" id="so-itemselect-1" class="so-itemselect">
		<option value="0" selected="selected"><?php echo JText::_('SELECT ITEM OR USE THE MENU BELLOW');?></option>
		<?php
		for ($i=0; $i < count( $this->ListOfCategory ); $i++) {
			$oneCategory = $this->ListOfCategory[$i];
			$s = '';
			for ($j=0; $j < count( $this->ListOfItem ); $j++) {
				$oneItem = $this->ListOfItem[$j];
				if ($oneItem->cat_id == $oneCategory->id) {
					$s .= '<option value="'.$oneItem->id.'">'.getFormattedPrice(getGrossPrice($oneItem, $this->Settings), $this->Settings).' - '.htmlspecialchars($oneItem->name).'</option>';
				}
			}
			if ($s > '') {
				echo '<optgroup label="'.htmlspecialchars($oneCategory->name).'">';
				echo $s;
				echo '</optgroup>';
			}
		}
		?>
	</select>
	<div class="so-oneitem-controlblock">
		<input type="text" name="so-pcs" class="so-pcs" value="1" />
		<a href="#" class="so-itembutton so-up"></a>
		<a href="#" class="so-itembutton so-down"></a>
		<a href="#" class="so-itembutton so-delete"></a>
	</div>
	<input type="hidden" name="so-price" class="so-price"/>
	<input type="hidden" name="basket-basketid" class="basket-basketid" value="0"/>
</div>