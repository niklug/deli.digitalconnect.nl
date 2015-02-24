<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */


function validEmail($email,$extra=null)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
   }
   return $isValid;
}
function outMsg($msg,$type) {
    if ($type == 'error') {
        return '<div>
                	<div class="so-alert" style="margin-bottom:0;">
                		<span class="felkialto">!</span>
                		<span class="alerttext">'.$msg.'</span>
                	</div>
                	<br class="clr" />
                </div>';
    } else
    return '<div class="msg-'.$type.'">'.$msg.'</div>';
}

function getGrossPrice($obj, $settings) {
    if (is_array($obj)) {
        $obj = (object) $obj;
    }
    $price = $obj->price;
    if ($settings->vat_handling == '1') {
        $vat_percent = $obj->vat_percent === null ? $settings->vat_default_percent : $obj->vat_percent;
        $price += ($vat_percent / 100) * $price;
    }
    return $price;
}

function getFormattedPrice($price, $settings) {
	$s = number_format($price,$settings->currency_decimal,$settings->currency_decimal_symbol,$settings->currency_thousand_separator);
	$s = str_replace('_',' ',$s);
	switch ($settings->currency_display) {
		case '00_Symb'	: $s = $s.' '.$settings->currency_symbol; break;
		case '00Symb'	: $s = $s.$settings->currency_symbol; break;
		case 'Symb_00'	: $s = $settings->currency_symbol.' '.$s; break;
		case 'Symb00'	: $s = $settings->currency_symbol.$s; break;
		default : $s = $settings->currency_symbol.$s;
	}
	return $s;
}

function deep_ksort(&$arr) {
    ksort($arr);
    foreach ($arr as &$a) {
        if (is_array($a) && !empty($a)) {
            deep_ksort($a);
        }
    }
}