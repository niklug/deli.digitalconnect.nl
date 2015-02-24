<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');
$session = JFactory::getSession();
?>

<div class="container">

<script language="javascript">function regSubmit() {
err = false;jQuery("#name").removeClass('error');jQuery("#address").removeClass('error');jQuery("#phone").removeClass('error');jQuery("#email").removeClass('error');jQuery("#password").removeClass('error');jQuery("#password2").removeClass('error');
if (jQuery("#name").val().length < 3) {jQuery("#name").addClass('error'); jQuery("#name").effect("pulsate", { times:3 }, 150); err = true;} 
if (jQuery("#address").val().length < 3) {jQuery("#address").addClass('error'); jQuery("#address").effect("pulsate", { times:3 }, 150); err = true;}
if (jQuery("#phone").val().length < 6) {jQuery("#phone").addClass('error'); jQuery("#phone").effect("pulsate", { times:3 }, 150); err = true;}
var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;if (!emailReg.test(jQuery("#email").val()) || jQuery("#email").val().length < 3) {jQuery("#email").addClass('error'); jQuery("#email").effect("pulsate", { times:3 }, 150); err = true;}
if (jQuery("#password").val().length < 1) {jQuery("#password").addClass('error'); jQuery("#password").effect("pulsate", { times:3 }, 150); err = true;}
if (jQuery("#password").val() != jQuery("#password2").val()) {jQuery("#password2").addClass('error'); jQuery("#password2").effect("pulsate", { times:3 }, 150); err = true;}
if (!err) jQuery("#josForm").submit();
}</script>
<h1 class="componentheading"><?php echo JText::_('Registration')?></h1>
<form action="<?php echo JRoute::_( 'index.php?option=com_smartorder&task=registration' ); ?>" method="post" id="josForm" name="josForm" > 

<div style="float: right;width:320px">
    <?php echo JText::_('REGFORM NOTES') ?>
</div>

<table cellpadding="0" cellspacing="0" border="0" class="smartlogin">
    <tr><td style="padding:0;font-size: 1px; line-height:10px" colspan="2">&nbsp;</td></tr>
    <tr>
        <td class="label" >
            <label id="emailmsg" for="name">
    			<?php echo JText::_( 'Name' ); ?>:
    		</label>
        </td>
        <td><input type="text" name="name" id="name" value="<?php echo htmlspecialchars((JRequest::getVar('name') > '') ? JRequest::getVar('name') : $session->get('ordName'))?>" class="inputbox" maxlength="50" /> * </td>
    </tr>
    <tr>
    	<td>
    		<label id="emailmsg" for="address">
    			<?php echo JText::_( 'Address' ); ?>:
    		</label>
    	</td>
    	<td>
    		<input type="text" id="address" name="address" value="<?php echo htmlspecialchars((JRequest::getVar('address') > '') ? JRequest::getVar('address') : $session->get('ordAddress'))?>" class="inputbox" maxlength="100" /> *
    	</td>
    </tr>
    <tr>
    	<td>
    		<label id="emailmsg" for="phone">
    			<?php echo JText::_( 'Phone' ); ?>:
    		</label>
    	</td>
    	<td>
    		<input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars((JRequest::getVar('phone') > '') ? JRequest::getVar('phone') : $session->get('ordPhone'))?>" class="inputbox" maxlength="100" /> *
    	</td>
    </tr>
    <tr>
    	<td>
    		<label id="emailmsg" for="email">
    			<?php echo JText::_( 'Email' ); ?>:
    		</label>
    	</td>
    	<td>
    		<input type="text" id="email" name="email" value="<?php echo htmlspecialchars((JRequest::getVar('email') > '') ? JRequest::getVar('email') : $session->get('ordEmail'))?>" class="inputbox" maxlength="100" /> *
    	</td>
    </tr>
    <tr>
    	<td>
    		<label id="pwmsg" for="password">
    			<?php echo JText::_( 'Password' ); ?>:
    		</label>
    	</td>
      	<td>
      		<input class="inputbox <?php echo (($session->get('ordName')>'') ? 'kiem' : '')?>" type="password" id="password" name="password" value="" /> *
      	</td>
    </tr>
    <tr>
    	<td>
    		<label id="pwmsg" for="password2">
    			<?php echo JText::_( 'Password2' ); ?>:
    		</label>
    	</td>
      	<td>
      		<input class="inputbox <?php echo (($session->get('ordName')>'') ? 'kiem' : '')?>" type="password" id="password2" name="password2" value="" /> *
      	</td>
    </tr>
    <tr>
    	<td>
    		&nbsp;
    	</td>
    	<td>
    		<input class="G" type="button" value="<?php echo JText::_( 'Registration' ); ?>" onclick="javascript:regSubmit();" /> 
    	</td>
    </tr>
    <tr><td style="padding:0;font-size: 1px; line-height:10px" colspan="2">&nbsp;</td></tr>
</table>
</form>
	
</div>