<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');
include_once(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_smartorder'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'functions.php');

//Ordering allowed ?
$ordering = ($this->lists['order'] == 'ordering');

JSubMenuHelper::addEntry(JText::_('MAINPAGE'), 'index.php?option=com_smartorder');
JSubMenuHelper::addEntry(JText::_('CATEGORIES'), 'index.php?option=com_smartorder&controller=categories&task=list');
JSubMenuHelper::addEntry(JText::_('ITEMS'), 'index.php?option=com_smartorder&controller=items&task=list');
JSubMenuHelper::addEntry(JText::_('TOPPINGS'), 'index.php?option=com_smartorder&controller=toppings&task=list');
JSubMenuHelper::addEntry(JText::_('ORDERS'), 'index.php?option=com_smartorder&controller=orders&task=list', true );
JSubMenuHelper::addEntry(JText::_('CUSTOMERS'), 'index.php?option=com_smartorder&controller=customers&task=list');
?>

<style> .icon-32-print	{ background-image: url('<?php echo JURI::root().'administrator/components/com_smartorder/images/icon-32-print.png';?>'); } </style>

<form action="index.php" method="post" name="adminForm" id="adminForm">

	<table class="so-filterlist">
		<tr>
			<td class="so-align-left">
				<?php echo JText::_( 'FILTER IN CUSTOMER NAME' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();" class="btn"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_catid').value='';this.form.getElementById('filter_state').value='';this.form.submit();" class="btn"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<td class="so-align-right so-nowrap">
				<?php
				echo $this->lists['catid'];
				?>
			</td>
		</tr>
	</table>
    <table class="adminlist so-adminlist" >
    <thead>
        <tr>
            <th class="so-align-center so-nowrap">
                <?php echo JHTML::_('grid.sort', JText::_( 'ORDER ID' )  , 'id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
            </th>
            <th class="so-align-center">
				<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
			</th>
            <th class="so-nowrap">
				<?php echo JHTML::_('grid.sort', JText::_( 'ORDER DATE' )  , 'datetime', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th class="so-align-center so-nowrap">
				<?php echo JHTML::_('grid.sort', JText::_( 'ORDER STATUS' )  , 'status_name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th class="so-nowrap">
				<?php echo JHTML::_('grid.sort',  JText::_( 'CUSTOMER NAME' ) , 'user_name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th class="so-nowrap">
				<?php echo JHTML::_('grid.sort', JText::_( 'ADDRESS' ) , 'user_address', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th class="so-nowrap">
				<?php echo JHTML::_('grid.sort', JText::_( 'PHONE' ) , 'user_phone', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th class="so-align-right so-nowrap">
				<?php echo JHTML::_('grid.sort', JText::_( 'TOTAL PRICE' ) , 'Total', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th>
				<?php echo JText::_('CONTENT')?>
			</th>
			<th>
				&nbsp;
			</th>
        </tr>
    </thead>
    <tfoot>
		<tr>
			<td colspan="10">
				<?php echo $this->pageNav->getPagesLinks()  ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
    <?php
    $k = 0;

    for ($i=0, $n=count( $this->orders ); $i < $n; $i++)
    {
  		@$row = $this->orders[$i];

  		$link = JRoute::_( 'index.php?option=com_smartorder&controller=orders&task=edit&cid='. $row->id );
  		$link_print = JRoute::_( 'index.php?option=com_smartorder&controller=orders&task=printOrders&cid[]='. $row->id );

  		$checked 	= JHTML::_('grid.id', $i, $row->id );

        ?>
        <tr class="<?php echo "row" . $k; ?>" style="color:<?php echo $row->status_fontcolor;?>">
            <td class="so-align-center so-nowrap">
					<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'ORDER DETAILS' );?>">
					<?php echo str_pad($row->id, 6, "0", STR_PAD_LEFT); ?>
					</a>
            </td>
            <td class="so-align-center">
				<?php echo $checked; ?>
			</td>
            <td class="so-nowrap" >
				<?php echo $row->datetime; ?>
			</td>
			<td class="so-align-center so-nowrap">
				<?php echo $row->status_name; ?>
            </td>
            <td class="so-nowrap">
				<?php echo $row->user_name;?>
			</td>
			<td class="so-nowrap">
				<?php echo $row->user_address;?>
			</td>
			<td class="so-nowrap">
				<?php echo $row->user_phone;?>
			</td>
			<td class="so-align-right so-nowrap">
				<?php echo getFormattedPrice($row->Total,$this->settings[0]);?>
			</td>
			<td class="so-nowrap">
				<?php echo $row->order_detail_name_list;?>
			</td>
			<td>
				<a href="<?php echo $link_print; ?>" title="<?php echo JText::_( 'PRINT ORDER' );?>">
					 <img src="<?php echo JURI::root().'administrator/components/com_smartorder/images/printButton.png';?>"/>
				</a>
			</td>
        </tr>
        <?php
        $k = 1 - $k;
    }
    ?>
    </tbody>
    </table>

<input type="hidden" name="option" value="com_smartorder" />
<input type="hidden" name="controller" value="orders" />
<input type="hidden" name="task" value="list" />
<input type="hidden" name="limitstart" value="0" />
<input type="hidden" name="filter_order" value="<?php echo @$this->lists['order'];?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo @$this->lists['order_Dir'];?>" />

<input type="hidden" name="boxchecked" value="0" />


</form>