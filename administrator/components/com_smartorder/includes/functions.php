<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */


function getFormattedInputPrice($price, $settings) {
    return number_format($price, $settings->currency_decimal, '.', '');
}

function getFormattedPrice($price, $settings, $includeSymbol = true) {
	$s = number_format($price,$settings->currency_decimal,$settings->currency_decimal_symbol,$settings->currency_thousand_separator);
	$s = str_replace('_',' ',$s);
	if (!$includeSymbol) {
	    return $s;
	}
	switch ($settings->currency_display) {
		case '00_Symb'	: $s = $s.' '.$settings->currency_symbol; break;
		case '00Symb'	: $s = $s.$settings->currency_symbol; break;
		case 'Symb_00'	: $s = $settings->currency_symbol.' '.$s; break;
		case 'Symb00'	: $s = $settings->currency_symbol.$s; break;
		default : $s = $settings->currency_symbol.$s;
	}
	return $s;
}

function getGrossPrice($obj, $settings) {
    $price = $obj->price;
    $price += (getVatPercent($obj, $settings) / 100) * $price;
    return $price;
}

function getVatPercent($obj, $settings) {
    if ($settings->vat_handling == '1') {
        return $obj->vat_percent === null ? $settings->vat_default_percent : $obj->vat_percent;
    }
    return 0;
}

function createJPG($imagePathFrom, $imagePathTo, $tnsizex, $tnsizey)
{
    $tnsizex = (integer)$tnsizex;
    $tnsizey = (integer)$tnsizey;
    if (!$imageFrom = @ImageCreateFromJPEG($imagePathFrom)) {
        if (!$imageFrom = @ImageCreateFromGIF($imagePathFrom)) {
            if (!$imageFrom = @imagecreatefromwbmp($imagePathFrom)) {
                if (!$imageFrom = @ImageCreateFromPNG($imagePathFrom)) {
                    return false;
                }
            }
        }
    }
    $sz = GetImageSize($imagePathFrom);
    $x = $sz[0]; // big image width
    $y = $sz[1]; // big image height
	if ($x>$tnsizex or $y>$tnsizey) { # nagyobb az eredeti
		$aranyx = $x / $tnsizex;
  		$aranyy = $y / $tnsizey;
  		$aranyMin = min($aranyx, $aranyy);
		if ($tnsizex == $tnsizey) { # or $kenyszeritettmetszes - lehetne téglalap alakú fixre vágott thumb is
            $left = ($x - ($tnsizex * $aranyMin)) / 2;
        	$top = ($y - ($tnsizey * $aranyMin)) / 2;
			$tnimage = ImageCreateTrueColor($tnsizex, $tnsizey);
            ImageCopyResampled($tnimage, $imageFrom, 0, 0, $left,$top, $tnsizex, $tnsizey, $tnsizex * $aranyMin, $tnsizey * $aranyMin);
        } else {
            if ($aranyx > $aranyy) $tnsizey = $y / $aranyx;
			else $tnsizex = $x / $aranyy;
	    	$tnimage = ImageCreateTrueColor($tnsizex, $tnsizey);
	        ImageCopyResampled($tnimage, $imageFrom, 0, 0, 0, 0, $tnsizex, $tnsizey, $x, $y);
        }
	} else {
		$tnimage = ImageCreateTrueColor($x, $y);
        ImageCopyResampled($tnimage, $imageFrom, 0, 0, 0, 0, $x, $y, $x, $y);
	}
    ImageJPEG($tnimage, $imagePathTo);
    ImageDestroy($tnimage);
    ImageDestroy($imageFrom);
    return true;
}