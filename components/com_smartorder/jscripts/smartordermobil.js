/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

// Visszaad egy setting alapján formázott currency stringet
// jQuery(this).getFormattedPrice(be)

(function( $ ){
  jQuery.fn.openOrClosed = function() {

	var closed = jQuery("#closed").val()
	if (closed == 1){
		jQuery(".so-block").remove()
		jQuery(".so-addto").remove()
		// .so-alertwrapper
		jQuery(".so-alertwrapper > .so-alert").clone(true,true).insertBefore(jQuery(".so-menublock"));
	}
	

	
  };
})( jQuery );



(function( $ ){
  jQuery.fn.getFormattedPrice = function(priceValue) {

	jQuery("#temp").val(priceValue)
	jQuery("#temp").formatCurrency({
			symbol: jQuery('#currency').val(),
			positiveFormat: jQuery('#positiveformat').val(),
			negativeFormat: jQuery('#negativeformat').val(),
			decimalSymbol: jQuery('#decimalsymbol').val(),
			digitGroupSymbol: jQuery('#digitgroupsymbol').val(),
			roundToDecimalPlace:jQuery('#roundtodecimalplace').val(),
			groupDigits: jQuery('#groupdigits').val()
		}
	)
	
	return jQuery("#temp").val();
  };
})( jQuery );



(function( $ ){
  jQuery.fn.createOutput = function() {
		var OutDelimited = ""
		jQuery(".so-itemselect, .so-toppingselect").each(function(){
			if (parseInt(jQuery(this).val())>0){
				// I, T, basketid, vagy a szülőé ...
				if (jQuery(this).hasClass("so-itemselect")) {
						OutDelimited += "I"
						OutDelimited += ","+jQuery(this).siblings('.basket-basketid').val()
						OutDelimited += ","+jQuery(this).siblings('.so-oneitem-controlblock').find(".so-pcs").first().val()
					} else {
						OutDelimited += "T"
						OutDelimited += ","+jQuery(this).parent().prevAll(".so-oneitem").find(".basket-basketid").first().val();
						OutDelimited += ","+jQuery(this).parent().prevAll(".so-oneitem").find(".so-pcs").first().val();
						//OutDelimited += ", basketOfItem"
					}
				OutDelimited += ","+jQuery(this).val()
				OutDelimited += ";"	
			}
		});
		return OutDelimited;
		//setTimeout(function(){alert(OutDelimited)}, 3000);

  };
})( jQuery );




// MEgelőzzük a duplikált topping kiválasztásokat a kosárban és villogtatással jelezzük a meglévőt
(function( $ ){
  jQuery.fn.checkDublicatedToppingSelect = function() {
  //console.log("checkDublicatedToppingSelect")
		var vanMarIlyenTopping = false
		var $actualSelectedToppingSelect = jQuery(this)
		var toppingIDSelected = parseInt(jQuery(this).val())
		var $toppingselectElotte = jQuery(this).parent().prevUntil(".so-oneitem").find(".so-toppingselect")
		var $toppingselectUtanna = jQuery(this).parent().nextUntil(".so-oneitem").find(".so-toppingselect")
		var $toppingSelectToCheck = $toppingselectElotte.add($toppingselectUtanna)
		
		$toppingSelectToCheck.each(function(index){
			if ( parseInt(jQuery(this).val()) == toppingIDSelected) {
				$duplicatedSelect = jQuery(this)
				vanMarIlyenTopping = true
			} 
		})
		
		if (vanMarIlyenTopping) {
//			console.log()
			// találtunk duplikáltat, ezért ez vissza defaultra, a duplikátum meg megvillogtat
				$duplicatedSelect.pulse({
					opacity: [1,0,1] // pulse between 1 and 0
				}, 200, 2, 'easeInSine');
				$actualSelectedToppingSelect.val(0);
				$actualSelectedToppingSelect.siblings(".so-price").val(0);
				vanMarIlyenTopping = true ;		
		}
		return vanMarIlyenTopping;
  };
})( jQuery );



// Topping és Item  select default disabled vezérlőkre, meg egy class hozzáad .defualt
(function( $ ){
  jQuery.fn.defaultSelectToDisabled = function(toDisabled) {
	if (toDisabled) {
		//jQuery(this).css("background-color","red")
		var $deleteButton = jQuery(this).find(".so-delete");
		$deleteButton.addClass("so-delete-disabled")
		$deleteButton.removeClass("so-delete")
		
		var $upButton = jQuery(this).find(".so-up");
		$upButton.addClass("so-up-disabled")
		$upButton.removeClass("so-up")
		
		var $downButton = jQuery(this).find(".so-down");
		$downButton.addClass("so-down-disabled")
		$downButton.removeClass("so-down")
		
		jQuery(this).addClass("default")
		
	} else {
		//jQuery(this).css("background-color","green")
		var $deleteButton = jQuery(this).find(".so-delete-disabled")
		$deleteButton.addClass("so-delete")
		$deleteButton.removeClass("so-delete-disabled")
		
		var $upButton = jQuery(this).find(".so-up-disabled")
		$upButton.addClass("so-up")
		$upButton.removeClass("so-up-disabled")
		
		var $downButton = jQuery(this).find(".so-down-disabled")
		$downButton.addClass("so-down")
		$downButton.removeClass("so-down-disabled")
		
		jQuery(this).removeClass("default")

	}
  };
})( jQuery );





// 
(function( $ ){
  jQuery.fn.calculatePriceforSelect = function() {
		var selectedValue = jQuery(this).find(":selected").val();
		if (jQuery(this).hasClass("so-itemselect")) {
			// Ha ez egy item, akkor a menüből vadásszuk ki a valós árat
			var price= parseFloat(jQuery(".so-menuitem-id[value='"+selectedValue+"']").siblings(".so-menuitem-price").val())		
		} else {
			// Ha ez egy topping, akkor a wrapper (vagy éppenhogy az adott select) hidden fieldjeiből
			var price = parseFloat(jQuery(this).siblings(".so-real-toppingprice[name='so-real-toppingprice-"+selectedValue+"']").val())
			//console.log(  jQuery(this).siblings(".so-real-toppingprice[name='so-real-toppingprice-"+selectedValue+"']").val()  )
		}
		jQuery(this).siblings(".so-price").val(price);
  };
})( jQuery );



// calculatePriceforSelect() Backup, törlendő Ez volt a régi splittelős megoldás
(function( $ ){
  jQuery.fn.bak_calculatePriceforSelect = function() {
		var pricestring = jQuery(this).find(":selected").text();
		var price= parseFloat(pricestring.split(' - ')[0].slice(1));
		jQuery(this).siblings(".so-price").val(price);
  };
})( jQuery );








// Topping szinkronizálása, az adott basket elemhez
(function( $ ){
  jQuery.fn.deleteBasketItem = function() {
		// Ha nem az utolsó elemről van szó, VAGY az elem topping mehet a törlés
		var $actualBasketItemToDelete = jQuery(this) ;
		var $itemForTopping = $actualBasketItemToDelete.prevAll(".so-oneitem").first()
		
		if ((jQuery('.so-cartblock-items-inner > .so-oneitem').length > 1) || ($actualBasketItemToDelete.hasClass("so-onetopping") ))
			{
			// MEGOLDANDÓ - HA ez egy item és van utána legalább egy topping, akkor meghívjuk a deleteToppings()-ot
			if (($actualBasketItemToDelete.hasClass("so-oneitem")) && ($actualBasketItemToDelete.next().hasClass("so-onetopping"))) {
				$actualBasketItemToDelete.deleteToppings();
			}

			$actualBasketItemToDelete.fadeOut('slow', function() {
				// Meghívom a menüből a törlést, ha az adott elemnek van basketid-je
				basketid = jQuery(this).find(".basket-basketid").val()
				if (basketid){
					jQuery(this).deleteMenuItem(basketid);					
				}
						
				jQuery(this).remove();
				
				// Ha toppingot törlünk, lefrissítjük a menu blokkját. VIGYÁZNI az aszinkronitásra !!!
				if ($itemForTopping){ $itemForTopping.B2MsyncTopping() }
				
				// - Ha a végére rakom, addigra nem fut le a fade és a tölés !!!FONTOS
				jQuery(this).calculateTotal();			


			});	
			

			
			}
		else
			{
				//alert("Első elem nem törölhető - majd Default értékek");
			}

  
		//return false;
  };
})( jQuery );





// Topping szinkronizálása, az adott basket elemhez
(function( $ ){
  jQuery.fn.B2MsyncTopping = function() {
		var basketIdofItem = parseInt(jQuery(this).find(".basket-basketid").val());
		var $menuItemToCheck = jQuery(".menu-basketid[value='"+basketIdofItem+"']").parent()
		var $allToppingSelects = jQuery(this).nextUntil(".so-oneitem").find(".so-toppingselect")
		
		// Kinullázzuk a toppingblokkot
		$menuItemToCheck.find(".so-menutopping-onetopping > input").attr('checked', false).siblings("span").removeClass("checkedbold");
		
		$allToppingSelects.each(function(index) {
			var whatSelected = jQuery(this).find("option:selected").val();
			var $whatToChange = $menuItemToCheck.find("#toppingcheckbox-"+whatSelected)
			$whatToChange.attr('checked', true)
			$whatToChange.siblings("span").addClass("checkedbold")
			
		});
		//return false;
  };
})( jQuery );







// Topping hozzáadása, az adott menü elemhez
(function( $ ){
  jQuery.fn.toppingChecked = function(basketID, toppingID) {
  
		jQuery(this).lockCartBock();

		jQuery(this).siblings("span").addClass("checkedbold")	
		
		
		// Adott topping hozzáadása az utolsó, üres topping selecthez
		var $basketItemToCheck = jQuery(".basket-basketid[value='"+basketID+"']").parent()
		var $lastDefaultTopping = $basketItemToCheck.nextUntil(".so-oneitem").last()
		$lastDefaultTopping.find(".so-toppingselect").val(toppingID)
		$lastDefaultTopping.defaultSelectToDisabled(false);

		
		// Ár hozzáadása egyelőre a régi függvénnyel
		$lastDefaultTopping.find(".so-toppingselect").calculatePriceforSelect()
		
		
		// Majd egy új üres topping select
		var toppingSelectCat = $lastDefaultTopping.find("input.so-topping-category").val();
		var $newToppingAdded = $lastDefaultTopping.akosAddNewTopping(toppingSelectCat);
		$newToppingAdded.next().defaultSelectToDisabled(true);


		
		jQuery(this).calculateTotal();				
  };
})( jQuery );



// Topping törlése, az adott menü elemből
(function( $ ){
  jQuery.fn.toppingUnChecked = function(basketID, toppingID) {
  
		jQuery(this).lockCartBock();

			jQuery(this).siblings("span").removeClass("checkedbold")	

		
		// Adott topping törlése
		var $basketItemToCheck = jQuery(".basket-basketid[value='"+basketID+"']").parent()
		var $toppingsOfItem = $basketItemToCheck.nextUntil(".so-oneitem")
		//.find(".so-itemselect").find("option:selected")
		var $toppingsToDelete = $toppingsOfItem.find(".so-toppingselect")
		//console.log($toppingsToDelete)
		$toppingsToDelete.each(function() {
			if (jQuery(this).val() == toppingID) { 
				
				jQuery(this).parent().fadeOut('slow', function(){
					jQuery(this).remove() 
					jQuery(this).calculateTotal();				
				})
			}
		})

  };
})( jQuery );







// Topping block létrehozása és beanimálása Menü itemhez
(function( $ ){
  jQuery.fn.addToppingBlockToMenuItem = function() {
		// Okosan elmentjük az adott gombot
		$addToppingButton = jQuery(this).find(".so-addtopping");
		// A kategória kikeresése	
		var toppingcategory = jQuery(this).prevAll("h2").first().find("span").html();
		// Az összes topping option egy elembe
		$allToppingOption = jQuery(".so-clonewrapper-topping >.so-onetopping input.so-topping-category[value='"+toppingcategory+"']").siblings(".so-toppingselect").find("option") 	
		// Készítünk egy üres .so-menutopping-block -ot az adott menüitembe és egyelőre rejtjük
		$newToppingBlock = jQuery('.so-clonewrapper-menutoppingblock > .so-menutopping-block').clone(true,true).insertAfter($addToppingButton.parent().parent());					
		$newToppingBlock.hide();
	
		// Végigfutunk rajta és feltöltjük az adott menü topping settet
		toppingNumber = $allToppingOption.size();
		$allToppingOption.each(function(index) {
				var toppingValue = jQuery(this).val();
				var toppingName = jQuery(this).text();
				// HA nem 0 az érték, azaz nem default select text, akkor ...
				if (!(toppingValue == 0)) {
					// Kibányásszuk az árat és a nevet
					var toppingPriceString = toppingName.split(' - ')[0];
					var toppingNameString = toppingName.split(' - ')[1];
					
					// Készítünk egy megfelelő .so-menutopping-onetopping elemet
					var toppingItemHtml = "<div class='so-menutopping-onetopping'><input type='checkbox' class='toppingcheckbox' name='toppingcheckbox-"+toppingValue+"' id='toppingcheckbox-"+toppingValue+"'> <label for='toppingcheckbox-"+toppingValue+"'> <span class='toppingprice'>"+toppingPriceString+"</span><span class='toppingname'> &nbsp;- "+toppingNameString+"</span></label></div>"
					// ... majd hozzáadjuk azt a blokk megfeleő oszlopába
					if (index < (toppingNumber/2)){
						$newToppingBlock.find(".so-menutopping-block-left").append(toppingItemHtml);
					} else {
						$newToppingBlock.find(".so-menutopping-block-right").append(toppingItemHtml);
					}
				}
		});
		
		// Beanimáljuk az új toppingBlockot
		$newToppingBlock.slideDown(function() {
				//Ha lenyílt, akkor ...
				// Kicseréljük a szokásos effektel a topping gombot add new gombra
				$addToppingButton.parent().hide("clip",function() {
						// Miután lefut
						// Hozzáadjuk a vezérlő wrappert
						$buttonblock = $addToppingButton.parent()
						jQuery(".so-clonewrapper-addnew > .so-addnew").clone(true,true).prependTo($buttonblock);
						$addToppingButton.remove();
						// Visszanyitjuk a blokkot
						$buttonblock.show("clip",function() {
							// .. ha lefut csinálhatunk valamit ... 
						})

				})			
		});			
		//return false;
  };
})( jQuery );





// Töröl egy adott basketid-jú elemet a menüből
(function( $ ){
  jQuery.fn.deleteMenuItem = function(basketid) {
  
  
  
	// Törlés basketid, vagy objektum alapján
		if ((basketid)){
			$itemToDelete = jQuery('input.menu-basketid[value='+basketid+']').parent().first();
		} else {
			$itemToDelete = jQuery(this);
		}
		
		// Mennyi van ilyen itemidjű termékekből a menüben?
		currentItemId = $itemToDelete.find("input.so-menuitem-id").val()
		currentItemNumber = jQuery('input.so-menuitem-id[value='+currentItemId+']').size();
//		console.log(currentItemNumber)
		if (currentItemNumber > 1) {
			// HA több, letöröljük
			
			$itemToDelete.slideUp("clip",function() {
				$itemToDelete.remove()	
			})
		} else {
			// HA csak 1 van, akkor nemt töröljük, csak a gombjait letöröl. addto gomb bele, topping blokk le és a basketid-jét 0-ra
			$itemToDelete.find(".so-menuitemcontroller").hide("clip", function(){
				jQuery(this).siblings("h3").removeClass("menuitemhighlight")
				jQuery(this).find(".so-menubutton, .so-addmorebutton").remove();
				jQuery(this).parent().parent().find(".so-menutopping-block").slideUp("slow", function() { jQuery(this).remove() });
				jQuery(".so-clonewrapper-addtobasket > .so-addto").clone(true,true).prependTo(jQuery(this));
				jQuery(this).show("clip");
				
				// Mobile hack
				//console.log(jQuery(this).parents(".so-onemenuitem").find(".so-menudesc"))
				jQuery(this).parents(".so-onemenuitem").removeClass("so-selectedmenuitem");
				jQuery(this).parents(".so-onemenuitem").find(".so-menudesc").hide();

			})
			$itemToDelete.find("input.menu-basketid").val("0");
		}
		
		//return false;
  };
})( jQuery );








// Egy menüelemet leklónoz és egyet a kosárba rak
(function( $ ){
  jQuery.fn.cloneMenuItem = function(itemID, newbasketid, noslide) {
		// Leklónozzuk a teljes blokkot
		$actualMenuBlock = jQuery(this) ;
		$newMenuBlock = $actualMenuBlock.clone(true,true).insertAfter($actualMenuBlock).hide();
		// Leszedjük belőle a topping blokkot, Töröljük a nem releváns gombokat is
		$newMenuBlock.find(".so-menutopping-block").remove();
		$newMenuBlock.find(".so-menubutton, .so-addmorebutton").remove();
		// Belerakjuk a megfelelő gombokat - Hozzáadjuk az addmore gombot
		jQuery(".so-clonewrapper-addmore > .so-addmorebutton").clone(true,true).prependTo($newMenuBlock.find(".so-menuitemcontroller"));					
		// ADDTOPPING GOMB - megvizsgáljuk van-e topping ehhez az itemhez, illetve ennek kategóriájához
		var toppingcategory = $actualMenuBlock.prevAll("h2").first().find("span").html();
		var toppingvane = jQuery(".so-onetopping input.so-topping-category[value='"+toppingcategory+"']").val() ;
		if (toppingvane) {
			jQuery(".so-clonewrapper-addtopping > .so-addtopping").clone(true,true).prependTo($newMenuBlock.find(".so-menuitemcontroller"));							
		}	
		
		// FX - Színesre állítjuk a hátterét
		//$newMenuBlock.css("background-color","#ffe7d6")
		$newMenuBlock.show("clip",700,function() {
				// Mobile hack
				//$newMenuBlock.animate( { backgroundColor: 'white' }, 3500)
				//var blockSize = $actualMenuBlock.height()+36
				//var scrollAmountString = '+='+blockSize
				//if (!(noslide)) { $.scrollTo(scrollAmountString, 800)}
		})
		
		// Basketid értékadás
		$newMenuBlock.find(".menu-basketid").val(newbasketid)
		
		return $newMenuBlock;
  };
})( jQuery );





// Menühöz hozzáadunk egy adott ID-jű és kosárid-jű terméket
(function( $ ){
  jQuery.fn.B2MaddMenuItem = function(itemID, newbasketid) {
		// Hány ilyen ID-jű termék van, ami már a kosárban 
		var ItemsNumberInMenu = jQuery('input.so-menuitem-id[value='+itemID+']').parent().find(".menupcs").size();
		// HA van már ilyen cuc a menüben
		if (ItemsNumberInMenu >= 1) {
			// Klónozunk egyet (árra figyelni a topping miatt)
			jQuery('input.so-menuitem-id[value='+itemID+']').parent().first().cloneMenuItem(itemID, newbasketid, true);
		} else {
			// EGYÉBKÉNT Az 1-in basketet behozzuk hozzá, majd beállítjuk a basketid-t
			$theOneItemInMenu = jQuery('input.so-menuitem-id[value='+itemID+']').parent()
			$theOneItemInMenu.find('a.so-addto').ChangeButtonToAdded();
			$theOneItemInMenu.find('.menu-basketid').val(newbasketid)		
		}
		
		//return false;
  };
})( jQuery );







(function( $ ){
  jQuery.fn.isValidEmail = function($email) {
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email);
  };
})( jQuery );




(function( $ ){
  jQuery.fn.lockCartBock = function() {
		var cartBlockHeight = jQuery(".so-cartblock-body").height();
		jQuery(".so-cartblock-body").height(cartBlockHeight);  
		jQuery(".so-cartblock-body").addClass("locked");  
//		console.log("locked")
	return false;
  };
})( jQuery );


(function( $ ){
  jQuery.fn.unlockCartBlock = function() {
		// Ha nem egyenlő a két távolság			
		if (jQuery(".so-cartblock-body").hasClass("locked")) {
			var cartBlockItemHeight = jQuery(".so-cartblock-items").height();	
			var cartBlockDescHeight = jQuery(".so-cartblock-desc").height();	
			var innerHeight = Math.max(cartBlockItemHeight,cartBlockDescHeight);
			jQuery('.so-cartblock-body').animate({height:innerHeight+'px'}, 500, function() {
				jQuery(".so-cartblock-body").height("auto");
			})
			jQuery(".so-cartblock-body").removeClass("locked")
		}
//		console.log("unlocked")

		
	return false;
  };
})( jQuery );




// Kísérlet scroll lock, üzemen kívül
(function( $ ){
  jQuery.fn.scrollLock = function() {
  
      // lock scroll position, but retain settings for later
      var scrollPosition = [
        self.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft,
        self.pageYOffset || document.documentElement.scrollTop  || document.body.scrollTop
      ];
      var html = jQuery('html'); // it would make more sense to apply this to body, but IE7 won't have that
      html.data('scroll-position', scrollPosition);
      html.data('previous-overflow', html.css('overflow'));
      html.css('overflow', 'hidden');
      window.scrollTo(scrollPosition[0], scrollPosition[1]);


      // un-lock scroll position
      var html = jQuery('html');
      var scrollPosition = html.data('scroll-position');
      html.css('overflow', html.data('previous-overflow'));
      window.scrollTo(scrollPosition[0], scrollPosition[1])  
	return false;
  };
})( jQuery );







(function( $ ){
  jQuery.fn.ChangeButtonToAdded = function() {
	// Elfadeljük, rejtjük - majd lehet az egész wrappert
	
	// 	Zöldre a menü elemnevet
	jQuery(this).parent().siblings("h3").addClass("menuitemhighlight")
	
	$originalAddButton=jQuery(this);

	jQuery(this).parent().hide("clip",function() {
		// Miután lefut
		// Hozzáadjuk az addmore gombot
		jQuery(".so-clonewrapper-addmore > .so-addmorebutton").clone(true,true).prependTo(jQuery(this));	
		
		jQuery(this).parents(".so-onemenuitem").addClass("so-selectedmenuitem");
		jQuery(this).parents(".so-onemenuitem").find(".so-menudesc").show();
		
		
		
		// TOPPING - megvizsgáljuk van-e topping ehhez az itemhez, illetve ennek kategóriájához
		var toppingcategory = jQuery(this).parent().parent().prevAll("h2").first().find("span").html();
		var toppingvane = jQuery(".so-onetopping input.so-topping-category[value='"+toppingcategory+"']").val() ;
		if (toppingvane) {
			//console.log("van topping")
			// HA van, akkor befűzünk a megfelelő helyre egy add topping gombot is klónból
			jQuery(".so-clonewrapper-addtopping > .so-addtopping").clone(true,true).prependTo(jQuery(this));							
		}	

		
		// Töröljük az eredeti gombot
		$originalAddButton.hide();
		
		
		// Újra befadeljük a wrappert	
		jQuery(this).show("clip",500,function() {
			// Ez fut le miután visszajött
			$originalAddButton.remove();
		});
	
	});
	
	
  
	return false;
  };
})( jQuery );




// Shipping cost felirat kezelése és shipping cost hozzáadása a totalhoz
// RETURN a totalhoz hozzáadandó shipping cost
(function( $ ){
  jQuery.fn.shippingCost = function(total) {
	var shipcost = jQuery("#shipcost").val()
	var freeshiplimit = jQuery("#freeshiplimit").val()
  
	if (shipcost>0){
		//Van szállítási költség
			if (freeshiplimit>0){
				// Van ingyenes kiszállítási a limit felett
				if (total >= freeshiplimit){
					// Megvan a limit, ezért ingyenes a szállítás
					// jQuery("span.shippingmessage").html(txt_shipping_1);
					jQuery("span.shippingmessage").html(jQuery("#txt_shipping_1").val());
					return 0;		
					
				} else {
					// Nincs meg a limit, ezért a shipping costot felszámoljuk
					// jQuery("span.shippingmessage").html(txt_shipping_2);
					jQuery("span.shippingmessage").html(jQuery("#txt_shipping_2").val()); 
					return shipcost;		
				}
			
			} else {
				// Fix a kiszállítási költség
				// jQuery("span.shippingmessage").html(txt_shipping_3);
				jQuery("span.shippingmessage").html(jQuery("#txt_shipping_3").val());
				return shipcost;		
			}

	
	} else {
		// Ingyen van a shipping
		// jQuery("span.shippingmessage").html(txt_shipping_4);
		jQuery("span.shippingmessage").html(jQuery("#txt_shipping_4").val());
		return 0;		
	}
  
	return false;
  };
})( jQuery );







(function( $ ){
  jQuery.fn.ContactBasketWarning = function() {
			// Felcsukjuk a contactot ...
			jQuery('.so-contactblock').slideUp('slow', function() {
				// LEfut ha kész az anim
				// A gombot visszaírni CHECKOUTRA
				jQuery(".so-ordernow > span").html(txt_label_2);
				// A gombról levenni az .orderphase classot
				jQuery(".so-ordernow").removeClass("orderphase");			
			});		
  };
})( jQuery );




(function( $ ){
  jQuery.fn.validMessages = function() {
  
		var totalsumtext = jQuery(".so-total .so-price").html();
		//var totalsum= parseFloat((totalsumtext.replace("$"," ")));
		//csere erre:
        if (totalsumtext == null) totalsumtext = '0';
		totalsumtext = totalsumtext.replace(jQuery("#currency").val(),"");
		totalsumtext = totalsumtext.replace(jQuery("#digitgroupsymbol").val(),"");
		totalsumtext = totalsumtext.replace(jQuery("#decimalsymbol").val(),".");
		totalsumtext = totalsumtext.replace(" ","");
		var totalsum= parseFloat(totalsumtext);
		
		var minReqSum = jQuery("input#minrequiredsum").val();
		var isWarning = false;
//		console.log(totalsum);

		// HA Üres a kosár
		if ((totalsum == 0)||(totalsum < minReqSum)) {
			// HA van minimális rendelési összeg, akkor erre figyelmeztetünk
			if (minReqSum>0) {
				//console.log(minReqSum);
				//var validmessage = txt_warn_1 ;
				var validmessage = jQuery("#txt_warn_1").val();
				jQuery(".so-notification-text > span").html(validmessage);
				isWarning = true;
			} else {
				// HA nincs minReqSum, akkor az üres kosárra figyelmeztetünk
				//var validmessage = txt_warn_2  ;
				var validmessage = jQuery("#txt_warn_2").val();
				jQuery(".so-notification-text > span").html(validmessage);
				isWarning = true;
			}
		} else {
			//var validmessage = txt_warn_3 ;
			var validmessage = jQuery("#txt_warn_3").val();;
			jQuery(".so-notification-text > span").html(validmessage);
			isWarning = false;
		}
		
		// Warning jelzés ki bekapcsolása attól függően, hogy volt-e warning
		// Egyelőre kivettem, mert nem tetszik
		if (isWarning) {
			// jQuery(".so-notification-sign").show();
		} else {
			// jQuery(".so-notification-sign").hide();
		} 
	
		if ((isWarning) &&(jQuery(".so-contactblock").css("display") == "block")){
			// HA warning van és a contact már le van nyitva, akkor visszacsukjuk és visszaállítjuk a gombot
			jQuery(this).ContactBasketWarning();
		} 
	
		return isWarning;
  };
})( jQuery );






(function( $ ){
  jQuery.fn.validateContact = function() {
  
		var isWarning = false;
		
		jQuery('.so-onecontactrow > input').each(function(index) {
			// Ha üres az adott contact field
			if (!jQuery(this).val()) {
				jQuery(this).addClass("nonvalidfield");
				isWarning = true;
			} else {
				jQuery(this).removeClass("nonvalidfield");			
			}
		});
        
        // email
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if (!emailReg.test(jQuery("#so-contact-4").val()) || !jQuery("#so-contact-4").val()) {
            jQuery("#so-contact-4").addClass('nonvalidfield');
            isWarning = true;
        } else jQuery("#so-contact-4").removeClass("nonvalidfield");
        
		
		jQuery(".nonvalidfield").pulse({
			opacity: [1,0,1] // pulse between 1 and 0
		}, 200, 2, 'easeInSine');			
	
		return isWarning;
  };
})( jQuery );






// calculateTotal() - Végösszeg számolása hidden fieldekből -------------------------
jQuery.fn.calculateTotal = function()
{
    return this.each(function()
    {
		var totalsum = 0 ;	
		var itemsum = 0 ;
		itemvol = 0 ;		
		// Most a summa toppingok nélkül
		jQuery('.so-cartblock-items-inner .so-oneitem').each(function(index) {
            // if (parseInt(jQuery(this).children(".so-price").val())){
            if (parseFloat(jQuery(this).children(".so-price").val()) > 0){
				itemsum = parseFloat(jQuery(this).children(".so-price").val());
				itemvol = parseInt(jQuery(this).find(".so-pcs").val());
				totalsum = totalsum + itemsum*itemvol;				
			}
		});
		
		// FELADAT: Kiszámolni a toppingok összegét a szülő mennyiségének a szorzatával

		jQuery('.so-cartblock-items-inner .so-onetopping').each(function(index) {
			if (parseFloat(jQuery(this).children(".so-price").val())){
				// Az őt megelőző első .so-oneitem .so-pcs-ja kell az itemvolba
				itemsum = parseFloat(jQuery(this).children(".so-price").val());
				itemvol = parseInt(jQuery(this).prevAll(".so-oneitem").find(".so-pcs").first().val());
				totalsum = totalsum + itemsum*itemvol;				
			}
		});

		
		//var totalsumout = '$'+totalsum+'.00 ' ; 
		totalsum = totalsum+parseFloat(jQuery(this).shippingCost(totalsum));
		
		//var totalsumout = '$'+totalsum.toFixed(2) ; 
		var totalsumout = jQuery(this).getFormattedPrice(totalsum) ; 
		jQuery(".so-total .so-price").html(totalsumout);
		
		jQuery(this).validMessages();
    });
};




// (akosUpdateNewItem) Custom Function új item adatainak frissítésére ------------------------------------------------------
// HASZNÁLATA: jQuery(this).akosUpdateNewItem();
jQuery.fn.akosUpdateNewItem = function()
{
    return this.each(function()
    {
		// CSAK akkor töltjük ki, ha nem egy üres elem
		var itemid= jQuery(this).parent().parent().siblings(".so-menuitem-id").val();
		$newitem.children(".so-itemselect").val(itemid);			
		// ár hiddenből
		var itemprice= jQuery(this).parent().parent().siblings(".so-menuitem-price").val();
		$newitem.children(".so-price").val(itemprice);
//		console.log($newitem)
//		$newitem.defaultSelectToDisabled(false);


		// Basketid inkrementál és beír
		var newbasketid = parseInt(jQuery("#basketid").val())+1;
		$newitem.find(".basket-basketid").val(newbasketid);
		jQuery("#basketid").val(newbasketid);
		// BasketID Menübe is
		jQuery(this).parent().parent().siblings(".menu-basketid").val(newbasketid);		

		
    });
};







// (akosAddNewItem) Custom Function új item felvételére ------------------------------------------------------
// HASZNÁLATA: jQuery(this).akosAddNewItem();
jQuery.fn.akosAddNewItem = function()
{
    return this.each(function()
    {
		// Új cart elem, Ha van placeholder, vagy ha nincs
	
		if (jQuery('.so-item-placeholder').length == 0)
			{
				$newitem=jQuery('.so-clonewrapper .so-oneitem:first').clone(true, true).insertAfter(jQuery(".so-cartblock-items-inner").children().last()).hide();
			}
		else
			{
				$newitem=jQuery('.so-clonewrapper .so-oneitem:first').clone(true,true).insertBefore('.so-item-placeholder:first').hide();
				jQuery('.so-item-placeholder:first').remove();
			}			

		// A törlést kivesszük, illetve vezérlőket disabledre.
		//$newitem.addClass("disabled-default");
		$newitem.defaultSelectToDisabled(true);

			
		$newitem.slideDown(500, function() {

					// Keressük az adott elem kategóriáját

					var toppingcategory = $newitem.prev().find(".so-itemselect").find("option:selected").parents("OPTGROUP").attr("label");
//					console.log(toppingcategory);

					// Az adott kategóriával rendelkezik-e hidden field a topping block közül
					var toppingvane = jQuery(".so-onetopping input.so-topping-category[value='"+toppingcategory+"']").val() ;

					if (toppingvane){
							var $newToppingAdded = $newitem.prev().akosAddNewTopping(toppingcategory);
							$newToppingAdded.next().defaultSelectToDisabled(true);

					}
							// Effekt az új elemek megjelenésére		

							
							// Az új elem attribútumait (id, name, stb át kellene állítani) - nem biztos hogy kell
							$newitem.attr('id', function() {
								jQuery('#totalitems').val(parseInt(jQuery('#totalitems').val())+1);
								return ("so-cartitem" + jQuery('#totalitems').val());
							});		
		
		
		} );	
			

    });
};






// (akosAddNewTopping) Custom Function új Topping felvételére ------------------------------------------------------
// HASZNÁLATA: jQuery(this).akosAddNewTopping();
jQuery.fn.akosAddNewTopping = function(toppingcat)
{
    return this.each(function()
    {
		// Új cart elem, Ha van placeholder, vagy ha nincs
		if (jQuery('.so-item-placeholder').length == 0)
			{
				// Megkeressük a kategóriához tartozó toppin clonózható elemet
				var $newitem=jQuery(".so-onetopping input.so-topping-category[value='"+toppingcat+"']").parent().first().clone(true, true).insertAfter(jQuery(this));
			}
		else
			{
				var $newitem=jQuery(".so-onetopping input.so-topping-category[value='"+toppingcat+"']").parent().first().clone(true, true).insertAfter(jQuery(this));
				jQuery('.so-item-placeholder:first').remove();
			}

		// Topping select bug megoldás	
		
		// Mobile hack - removing
		//var topSelectWidth = $newitem.find(".so-toppingselect").width();
		//$newitem.find(".so-toppingselect").css('width', function(index) {return topSelectWidth;	});	
		
		// Effekt az új elemek megjelenésére		
		$newitem.hide();					
		$newitem.slideDown('slow', function() {
			// Ez fut le a FadeIn után
			//alert("slide")
		});
		
		// Az új elem attribútumait (id, name, stb át kellene állítani) - nem biztos hogy kell
		$newitem.attr('id', function() {
			//jQuery('#totalitems').val(parseInt(jQuery('#totalitems').val())+1);
			//return ("so-cartitem" + jQuery('#totalitems').val());
		});	
		var $newItemForTest = $newitem;
		//$newItemForTest.addClass("disabled-default");

		return $newItemForTest;
		
    });
};





// (deleteToppings()) Custom Function Adott Item toppingjainak törlésére ------------------------------------------------------
jQuery.fn.deleteToppings = function()
{
    return this.each(function()
    {
		// Megnézzük a következő szomszéd topping-e, ha igen töröljük, ha nem befejeztük
		var vanMegTopping = true;
		while (vanMegTopping) {
			if (jQuery(this).next().hasClass("so-onetopping")){
				jQuery(this).next().remove();
			}
			else {
				vanMegTopping = false;
			}
		}		
    });
};






// (akosUpdateModifyEmptyItem) Custom Function - amikor a meglévő select tartalmát írjuk át------------------------------------------------------
// HASZNÁLATA: jQuery(this).akosModifyEmptyNewItem();
jQuery.fn.akosModifyEmptyItem = function()
{
    return this.each(function()
    {
		var $menuItemBlock = jQuery(this)
		// Név, azaz itemID beállítása hiddenből, ár spanból
		var itemid= $menuItemBlock.find(".so-menuitem-id").val();
		jQuery(".so-itemselect:last").val(itemid);		
		// ár hiddenből
		var itemprice= $menuItemBlock.find(".so-menuitem-price").val();
		jQuery(".so-itemselect:last").siblings(".so-price").val(itemprice);	
		// Basketid inkrementál és beír
		var newbasketid = parseInt(jQuery("#basketid").val())+1;
		jQuery(".so-itemselect:last").siblings(".basket-basketid").val(newbasketid);
		
		jQuery(".so-itemselect:last").parent().defaultSelectToDisabled(false);
		
		
		jQuery("#basketid").val(newbasketid);
		// BasketID Menübe is
		$menuItemBlock.find(".menu-basketid").val(newbasketid);		
		
    });
};






// slideThisText() - Egy adott szöveget beúsztat a kosár sliderébe
(function( $ ){
  jQuery.fn.slideThisText = function(texttoslide) {
  
  
		// Elmentjük a .so-cartblock-desc-belso valós magasságát
		var descHeight = jQuery(".so-cartblock-desc-belso").height();
		var descWidth = jQuery(".so-cartblock-desc-belso").width();
		var descPadding = jQuery(".so-cartblock-desc-belso").css("padding-left");
		//alert (descHeight);
		
		//Kifédeljük
		jQuery(".so-cartblock-desc-belso >span").fadeOut('fast', function() {

			// Beállítjuk hogy latható maradjon
			jQuery(".so-cartblock-desc-belso > span").show();


			// Betöltjük a tartalmát, klónozzunk egy textet
			//var newtext = jQuery(".so-menudesc").html();
			jQuery(".so-cartblock-desc-belso > span").html(texttoslide);

			// Felvegye a slidehoz szokseges css-eket a .so-cartblock-desc-belso kontener
			jQuery(".so-cartblock-desc-belso").height(descHeight);
			
			// Slide span CSS beállít
			var cssObj = {
			  'display' : 'block',
			  'width' : descWidth,
			  'position' : 'absolute'
			}
			jQuery(".so-cartblock-desc-belso > span").css(cssObj);	
			
			// Kitoljuk Jobbra a megfelelő távolságra Width+x
			jQuery(".so-cartblock-desc-belso > span").css("left",descWidth+30);
			
			// VisszaAnimáljuk
			  jQuery('.so-cartblock-desc-belso > span').animate({
				left: descPadding
			  }, 200, function() {
				// Animation complete.
				//clearTimeout();
			  });			
		});	

  };
})( jQuery );






// getDescription - Adott select-ben kiválasztott elemhez visszadja a description szövegét.
(function( $ ){
  jQuery.fn.getDescription = function() {
		var itemId =jQuery(this).val();
		var desc = jQuery("input.so-menuitem-id[value="+itemId+"]").first().siblings(".so-menudesc").html();
		return desc;
  };
})( jQuery );




// descSlider() - Kiválasztja, melyik selecthez milyen szöveget toljunk, majd meghívja a slideThisText()-et
(function( $ ){
  jQuery.fn.descSlider = function() {
	// Ide egy olyat, hogy megnézzük a régi textet ??? nem biztos
  
	if (jQuery(this).hasClass("so-itemselect")) {
		// Ha itemselect
		if (jQuery(this).val()>0) {
			// HA van valami kiválasztva
			var newtext = jQuery(this).getDescription();
		} else {
			// HA default itemselect, vagy nincs description az ételhez
			var newtext = txt_slider_item_1;
		}
	} else {
		// HA topping select
		if (jQuery(this).val()>0) {
			// HA van valami kiválasztva toppingnak
			var newtext = txt_slider_topping_1;
		} else {
			// HA ez e gy default topping select
			var newtext = txt_slider_topping_2;
		}
	}

	jQuery(this).slideThisText(newtext) ;
  
  };
})( jQuery );




jQuery(document).ready(function() {

    var notesWrapper = jQuery('.so-contactblock-noteblock-wrapper');
    var notesElem = jQuery("#so-contact-5");
    var diff1 = notesWrapper.outerHeight(true) - notesWrapper.height();
    var diff2 = notesElem.outerHeight(true) - notesElem.height();
    var notesHeight = notesElem.closest('.so-contactblock-inner').height() - parseInt(jQuery('.so-onecontactrow').eq(0).css('margin-bottom')) - diff1 - diff2;
    notesWrapper.css('height', 'auto');
    notesElem.height(notesHeight);

	// CSAK TESZTELÉSRE
	jQuery(".so-cartblock-head-item").click(function() {
		//var be=3423123.237343
		//jQuery(this).getFormattedPrice(be)
		//alert(jQuery(this).createOutput())
		//return false;
	});

	jQuery(".so-menu-cat-up > a").click(function() {
		//jQuery(window)._scrollable();
		//$.scrollTo(".so-block",1200, {offset:-24,easing:'easeOutExpo'});
		return true;
	});

	
	jQuery(this).openOrClosed()

	// Cart elem számláló alapértékre
	jQuery('#totalitems').val(1);

	// Timer global változó
	var showTimer = null;


	// Zárju be a kontakt részt
	jQuery(".so-contactblock").hide();

	// Indítunk egy összegzéssel
	jQuery(this).calculateTotal();


	// Indítunk egy összegzéssel
	jQuery(".so-oneitem").defaultSelectToDisabled(true);



	// Ha a kosár alja látszik, akkor unlockol
    jQuery(window).scroll(function () { 
		var scrollPosition = jQuery(window).scrollTop()
		var lastItemPos = jQuery(".so-totalblock").last().offset().top
		if (scrollPosition < lastItemPos) {
			jQuery(this).unlockCartBlock();
		}
    });	
	
	
	
	
	

	// unlock, inview plugin használatával
	jQuery('.so-cartblock-headxxx').bind('inview', function (event, visible) {
	  if (visible == true) {
		// element is now visible in the viewport
	//	console.log("visible head")
	  } else {
		// element has gone out of viewport
	  }
	});
	
		
	// Topping Checkbox állítás
	jQuery(".toppingcheckbox").live('change', function() {
		var basketIDofItem = parseInt(jQuery(this).parent().parent().parent().parent().parent().find(".menu-basketid").val())
		var toppingID = jQuery(this).attr('id');
		var toppingIDnumber = parseInt(toppingID.split("-")[1])
		if (jQuery(this).is(':checked')) {
			// check
			//console.log("checked")

			jQuery(this).toppingChecked(basketIDofItem,toppingIDnumber)		
		} else {
			// unChecked
			jQuery(this).toppingUnChecked(basketIDofItem,toppingIDnumber)		
		}
		//return false;
	});
	


	

	
	
		
	// Volume növelése
	jQuery(".so-block").mouseover(function() {
		jQuery(this).unlockCartBlock();
		return false;
	});
	

	
	
	// Elem törlése menüből
	jQuery(".so-menu-delete").click(function() {
		// Adott elem törlése a basketből
		var basketidToDelete = jQuery(this).parent().parent().parent().parent().parent().parent().find(".menu-basketid").val()
		jQuery(".basket-basketid[value='"+basketidToDelete+"']").parent().deleteBasketItem()
		jQuery(this).parent().parent().parent().parent().parent().parent().deleteMenuItem();
		return false;
	});
	

	
	
	// Elem növelése menüből
	jQuery(".so-menu-up").click(function() {
		// Menü darabelem növelése
		var toNumber = parseInt(jQuery(this).parent().parent().find(".menupcs").html())+1
		jQuery(this).parent().parent().find(".menupcs").html(toNumber)
		// Kosár adott basketid-jű elem darabának elemlése
		var basketid = jQuery(this).parent().parent().parent().parent().parent().parent().find(".menu-basketid").val()
		jQuery(".basket-basketid[value='"+basketid+"']").parent().find(".so-pcs").val(toNumber);
		jQuery(this).calculateTotal();
		return false;
	});
	

	
	// Elem csökkentése menüből
	jQuery(".so-menu-down").click(function() {
		// Menü darabelem csökkentés, ha nem egy a darabszám
		var toNumber = parseInt(jQuery(this).parent().parent().find(".menupcs").html())-1
		if (toNumber < 1) {toNumber = 1}
		jQuery(this).parent().parent().find(".menupcs").html(toNumber)
		// Kosár adott basketid-jű elem darabának elemlése
		var basketid = jQuery(this).parent().parent().parent().parent().parent().parent().find(".menu-basketid").val()
		jQuery(".basket-basketid[value='"+basketid+"']").parent().find(".so-pcs").val(toNumber);
		jQuery(this).calculateTotal();
		return false;
	});
	

	
	
	
	
	// ADD TOPPING Gomb Klikkje menutopping blokk összeállítása és lenyitása
	jQuery(".so-addtopping").click(function() {
		 jQuery(this).parent().parent().parent().addToppingBlockToMenuItem();
	return false;
	});
	


// A menü "add new empty" klikkje	
	jQuery(".so-addnew").click(function() {
		var $recentAddedNewItemInMenu = jQuery(this).parent().parent().parent().cloneMenuItem();	
		//Meglévő kosárelem feltöltése
		$recentAddedNewItemInMenu.akosModifyEmptyItem();
//		jQuery(this).lockCartBock();
		jQuery(this).akosAddNewItem();
		jQuery(this).calculateTotal();
		
	return false;
	})
	
	
	
	
	

	// Default text for notes
	jQuery(".so-contactblock-noteblock-wrapper > textarea").focus(function(srcc) {
		if (jQuery(this).val() == jQuery(this)[0].title)
			{
//				console.log("üresre")
				jQuery(this).val("");
			}	
	
	});
	

	jQuery(".so-contactblock-noteblock-wrapper > textarea").blur(function(srcc) {
		 if (jQuery(this).val() == "")
			{
				//jQuery(this).removeClass("defaultTextActive");
				jQuery(this).val(jQuery(this)[0].title);

			}	
	
	});
	

//	jQuery(".so-contactblock-noteblock-wrapper > textarea").blur();
	
	// Elem törlés
	// Ha AZ ELSŐ ÉS EGYETLEN ELEM, AKKOR CSAK AZ ÉRTÉKEIT DEFAULTRA
	// Valami effekt először
	jQuery(".so-delete").live('click', function() {
		 jQuery(this).parent().parent().deleteBasketItem()
		return false;			
	});
	

	
	
	
	// Volume növelése
	jQuery(".so-up").live("click", function() {
		var actualvolume = parseInt(jQuery(this).siblings(".so-pcs").val());
		var newvolume = actualvolume+1
		jQuery(this).siblings(".so-pcs").val(newvolume);
		
		// Menüelem mennyiség update
		var currentBasketId = parseInt(jQuery(this).parent().siblings(".basket-basketid").val())
		var $menuItemToUpdate = jQuery('input.menu-basketid[value='+currentBasketId+']').parent()
		$menuItemToUpdate.find(".menupcs").html(newvolume)

		jQuery(this).calculateTotal();
		return false;
	});
	

	
	
	
	// Volume csökkentése
	jQuery(".so-down").live('click',function() {
		var actualvolume = parseInt(jQuery(this).siblings(".so-pcs").val());
		if (actualvolume > 1)
			{
				var newvolume = actualvolume-1
				jQuery(this).siblings(".so-pcs").val(newvolume);		
			}
		else
			{
			// Nem csökkenthető 0-ra, esetleg törlésre buzdítva a törlést villogtatni :)
			var newvolume = actualvolume
			}		

		// Menu update
		var currentBasketId = parseInt(jQuery(this).parent().siblings(".basket-basketid").val())
		var $menuItemToUpdate = jQuery('input.menu-basketid[value='+currentBasketId+']').parent()
		$menuItemToUpdate.find(".menupcs").html(newvolume)
	
			
		jQuery(this).calculateTotal();	
		return false;
	});
	

	
	
	
	// Menu - AddtoCart gomb
	jQuery(".so-addto").click(function() {


		jQuery(this).lockCartBock();
	
		// Kosár elem frissítése
		if (parseInt(jQuery('.so-itemselect:last').val()) == 0 )
			{
				//Meglévő kosárelem feltöltése
				jQuery(this).parent().parent().parent().akosModifyEmptyItem();
				jQuery(this).akosAddNewItem();					
			}
		else
			{
				jQuery(this).akosAddNewItem();	
				jQuery(this).akosUpdateNewItem();				
			}

		// A menü gombok cseréje
		jQuery(this).ChangeButtonToAdded();
		
		jQuery(this).calculateTotal();
		

		return false;
	});
	
	
	
	
	jQuery(".so-itemselect").change(function() {	
		// Ide  ár kalkuláció, ami a select elejéből vágja ki az árat.

		jQuery(this).calculatePriceforSelect();
		
		if (jQuery(".so-itemselect:last").val() != "0"){
			// MEGOLDANDÓ Ha Az utolsó itemselect elem lett megváltoztatva, az adott itemből, azaz nem 0, csak akkor fűzünk hozzá
			jQuery(this).parent().defaultSelectToDisabled(false);
			jQuery(this).akosAddNewItem();
		}
		else {
			// HA nem az utolsó és ...
			// HA vannak alatta toppingok
			if (jQuery(this).parent().next().hasClass("so-onetopping")){
				// AKKOR letöröljük őket
				jQuery(this).parent().deleteToppings();
			} 
			// Majd adunk neki új topping selectet, a kategória megjelölésével
			var toppingcategory = jQuery(this).find("option:selected").parents("OPTGROUP").attr("label");
			var $newToppingAdded = jQuery(this).parent().akosAddNewTopping(toppingcategory);
//			$newToppingAdded.addClass("disabled-default");
			$newToppingAdded.next().defaultSelectToDisabled(true);

			// Basketid
		}
		

		
		// Basketid növelés, ha nem default select
		var oldBasketId = parseInt(jQuery(this).parent().find(".basket-basketid").val())
		
		if (jQuery(this).val() != "0"){
			var newbasketid = parseInt(jQuery("#basketid").val())+1;
			jQuery("#basketid").val(newbasketid);
			jQuery(this).siblings(".basket-basketid").val(newbasketid);
			var itemID = parseInt(jQuery(this).val())
			jQuery(this).B2MaddMenuItem(itemID,newbasketid);
			// Deault itemselect disabled legyen
			jQuery(this).parent().removeClass("disabled-default");

		}

		// Ha előtte volt a selectben valami, akkor azt a kosáridjűt letöröljük	
		if (oldBasketId) { jQuery(this).deleteMenuItem(oldBasketId); }
		
		// Kaja választásakor is bedobjuk a descriptionját
		var newtext = jQuery(this).getDescription();
		jQuery(this).slideThisText(newtext) ;

		// Mennyiség 1-re
		jQuery(this).parent().find(".so-pcs").val("1");
		
		//Kiszámoljuk az új végösszeget
		jQuery(this).calculateTotal();
		

		
		return false;
	});
	
	
	
	
// Topping select change event
	jQuery(".so-toppingselect").change(function() {	
	
		jQuery(this).unlockCartBlock();

		// JAVÍTANDÓ árkalkuláció
		jQuery(this).calculatePriceforSelect();

		var $prevItem = jQuery(this).parent().prevAll(".so-oneitem").first();
		
		// Ha lett valami kiválasztva
		if (jQuery(this).val() != "0") {
			// Duplikátum kizárása
			var vanDuplikatum = jQuery(this).checkDublicatedToppingSelect();
			if (!vanDuplikatum) {		
	
	
				// HA a következő elem nem topping, tehát bővítjük a topping listát
				if (!(jQuery(this).parent().next().hasClass("so-onetopping"))) {
					// Mi az adott topping selector kategóriája 
					var toppingSelectCat = jQuery(this).parent().find("input.so-topping-category").val();
					// Ha megvan, akkor egy ugyanolyan kategóriájú topping selectort adunk hozzá
					var $newToppingAdded = jQuery(this).parent().akosAddNewTopping(toppingSelectCat);
					jQuery(this).parent().defaultSelectToDisabled(false);
					$newToppingAdded.next().defaultSelectToDisabled(true);
				}
				// Ha nincs nyitva a topping Menü blok, akkor kinyitjuk
				var basketId = $prevItem.find(".basket-basketid").val()
				var $menuItemToUpdate = jQuery(".menu-basketid[value='"+basketId+"']").parent()
				if ($menuItemToUpdate.find(".so-menutopping-block")) {
					$menuItemToUpdate.addToppingBlockToMenuItem()
					// Mobile Hack
					// Színezzük az adott menü elemet és nyitjuk
					$menuItemToUpdate.find(".so-menudesc").show();
					$menuItemToUpdate.addClass("so-selectedmenuitem");
					
				}
			}
		}
		
		$prevItem.B2MsyncTopping()
		jQuery(this).calculateTotal();				
		return false;
	});
	



	
	// Slide teszt
	jQuery("a#runslide").click(function() {		
		jQuery(this).descSlider();
		return false;
	});



// Az Order Now fázisban lévő gomb akció 	
(function( $ ){
  jQuery.fn.ordernowClick = function() {
		if (jQuery(this).validateContact()) {
			// MEgvillogtatjuk a warning mezőt
				jQuery(".so-notification").pulse({
					opacity: [1,0,1] // pulse between 1 and 0
				}, 200, 2, 'easeInSine');					
			
		} else {
			// HA nincs warning, felcsukjuk a contact formot és elküldjük AJAX-al a rendelést
				
				// összeállítjuk az order stringet
				var orderstring = "";
				orderstring = jQuery(this).createOutput();	
				
				if ( jQuery("#so-contact-5").val() == jQuery("#def_notes_text").val() ) jQuery("#so-contact-5").val('');
				
				// ajax hivas
                jQuery.blockUI({
                    message: jQuery('#blockuicontent').html(),
                    css: { 
                        padding: 0, 
                        margin: 0,
                        width: 128,
                        left: $(document).width() / 2 - 64,
                        top: $(window).height() / 2 - 64,
                        border: 0,
                        backgroundColor: 'transparent',
                        cursor: 'wait'
                    }
                });
				$.ajax({
					type: "POST",
					url: "index.php",
					data: 'option=com_smartorder&task=orderSaveAjax&o='+orderstring+'&uname='+jQuery("#so-contact-1").val()+'&uphone='+jQuery("#so-contact-3").val()+'&uemail='+jQuery("#so-contact-4").val()+'&unote='+jQuery("#so-contact-5").val()+'&uaddress='+jQuery("#so-contact-2").val()+'&paymentmethod='+jQuery("#so-contact-6").val(),
					dataType: 'json',
					success: function(response){
                        // alert(msg); 
                        // msg = #OK#_uid formatum
                        // msg ertelmezese
					    var msg = response.msg;
                        var arr_msg = msg.split('_');
						if (arr_msg[0]=='#OK#') { 
							
							jQuery('#msgAjax').html('');
							jQuery('.so-agreeterms').html('');
							
                            //ha Ajax visszakuld olyan user id-t, mely email alapjan regisztralt, akkor nyugtazo uzenet csere
                            //v1.0-ban nem
                            //if (arr_msg[1] > 0) {
                            //    jQuery('.so-thank-text-reginfo').html( jQuery('.so-thank-text-reginfo-registeredNotlogged').html() );
                            //}
							
							// ha ajax OK, akkor animacio
                            if (typeof response.showFeedback != 'undefined' && response.showFeedback) {
                                jQuery.unblockUI();
                            }
							jQuery('.so-contactblock').slideUp('slow', function() {
								// MAJD - Ajax adminnal
								// Új html betölt
                                if (typeof response.showFeedback == 'undefined' || !response.showFeedback) {
                                    return;
                                }
								jQuery(".so-contactblock > form").remove();
								jQuery('.so-clonewrapper-ok > .so-contactblock-inner-ok').clone(true,true).appendTo('.so-contactblock');					
								
								// MAJD visszanyit
								jQuery('.so-contactblock').slideDown('slow',"easeInOutCubic", function() {
									//Ha lefutott, akkor
									
										// A gomb elrejt
										jQuery(".so-ordernow").hide('blind');
										
										// MAJD warning elrejt
										jQuery(".so-notification").hide('drop');
										
										// default selectek törlése
										jQuery(".so-itemselect, .so-toppingselect").find(":selected").filter("[value='0']").parent().parent().slideUp("slow", function(){
											jQuery(this).remove();
										});
										
										// Fieldek disabled
										jQuery(".so-cartblock-items-inner select, .so-cartblock-items-inner input").attr("disabled","disabled");
										
										// Törlés és up, down nyilak unbind ??? mi legyen a slideal
										jQuery(".so-delete").unbind();
										jQuery(".so-delete").die();
										jQuery(".so-up").unbind();
										jQuery(".so-up").die();
										jQuery(".so-down").unbind();
										jQuery(".so-down").die();
			
										// Minden gomb elhalványít
										jQuery("a.so-up").addClass("so-up-disabled")
										jQuery("a.so-up").removeClass("so-up")
										jQuery("a.so-down").addClass("so-down-disabled")
										jQuery("a.so-down").removeClass("so-down")
										jQuery("a.so-delete").addClass("so-delete-disabled")
										jQuery("a.so-delete").removeClass("so-delete")
										
										// Menü gombjait is letöröl
										jQuery(".so-menubutton, .so-addmorebutton").hide('clip', function(){ jQuery(this).remove()})
										
										// Topping dobozok felzár, töröl
										jQuery(".so-menutopping-block").slideUp();
										
											
								});	
							});					
						} else {
							jQuery('#msgAjax').html(msg);
							jQuery("#msgAjax").pulse({opacity: [1,0,1]}, 200, 2, 'easeInSine');		
						}

                        if (typeof response['eval'] == 'string') {
                            eval(response['eval']);
                        }
					}
				});	
				
				
		}
  };
})( jQuery );



// Az Checkout fázisban lévő gomb akció 	
	
(function( $ ){
  jQuery.fn.checkoutClick = function() {
		// HA van warning
		if (jQuery(this).validMessages()) {
			// MEgvillogtatjuk a warning mezőt
				jQuery(".so-notification").pulse({
					opacity: [1,0,1] // pulse between 1 and 0
				}, 200, 2, 'easeInSine');			
			
		} else {
			// HA nincs warning, le kell nyitni a kontakt formot
				jQuery('.so-contactblock').slideDown('slow',"easeInOutCubic", function() {
					// LEfut ha kész az anim
					// IDE Átírni a warning részt (majd effekt és padding javítás CSS-el)
					//var validmessage = txt_warn_4 ;
					var validmessage = jQuery("#txt_warn_4").val();
					jQuery(".so-notification-text > span").html(validmessage);
					// A gombot átírni Order Now-ra (esetleg majd effektel, színváltással)
                    jQuery(".so-ordernow > span").html(txt_label_1[jQuery("#so-contact-6").val()]);
					// A gombhoz hozzáadni egy plussz classt a .orderphase -t
					jQuery(".so-ordernow").addClass("orderphase");
					
					// KISÉRLET EFFEKT
					//jQuery(".so-cartblock").animate({ backgroundColor: "#bbb" }, 2000);
					
					// MAJD minden disabledre
					// MAJD megmaradt nullás selecteket kitöröl

				});		
		}  
  };
})( jQuery );

	
	
	
	
// Checkout-Ordernow gombkezelés
jQuery("a.so-ordernow").click(function() {
	if (jQuery("a.so-ordernow").hasClass("orderphase")){
			// HA az ORDER NOW gomb fázisban vagyunk
			jQuery(this).ordernowClick();
	} else {
			// HA a CHECKOUT gomb fázisban vagyunk
			jQuery(this).checkoutClick();
	}
	return false;		
});

jQuery("#so-contact-6").change(function () {
    jQuery(".so-ordernow > span").html(txt_label_1[jQuery("#so-contact-6").val()]);
});
	




jQuery('#so-contact-5').each(function() {
    var default_value = this.value;
    jQuery(this).focus(function() {if(this.value == default_value) {this.value = ''; }});
    jQuery(this).blur(function() {if(this.value == '') {this.value = default_value; }});
});	


// Mobile Smartorder  ------------------------------------
// Mobile Smartorder  ------------------------------------
// Mobile Smartorder  ------------------------------------
// Mobile Smartorder  ------------------------------------
// Mobile Smartorder  ------------------------------------


jQuery(".so-onemenuitem-upper").click(function() {

// Ha van benne elem, tehát a .so-addmorebutton visible
//console.log (jQuery(this).parent().find(".so-addmorebutton").length)
	if (!(jQuery(this).parent().find(".so-addmorebutton").length==1))
	{
		jQuery(this).siblings(".so-menudesc").toggle();
		jQuery(this).parent().toggleClass("so-selectedmenuitem");
	}
	//return false;		
});
	













	
});