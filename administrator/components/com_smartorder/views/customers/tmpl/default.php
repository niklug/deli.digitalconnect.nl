<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

//Ordering allowed ?
$ordering = ($this->lists['order'] == 'ordering');

JSubMenuHelper::addEntry(JText::_('MAINPAGE'), 'index.php?option=com_smartorder');
JSubMenuHelper::addEntry(JText::_('CATEGORIES'), 'index.php?option=com_smartorder&controller=categories&task=list');
JSubMenuHelper::addEntry(JText::_('ITEMS'), 'index.php?option=com_smartorder&controller=items&task=list');
JSubMenuHelper::addEntry(JText::_('TOPPINGS'), 'index.php?option=com_smartorder&controller=toppings&task=list');
JSubMenuHelper::addEntry(JText::_('ORDERS'), 'index.php?option=com_smartorder&controller=orders&task=list');
JSubMenuHelper::addEntry(JText::_('CUSTOMERS'), 'index.php?option=com_smartorder&controller=customers&task=list', true );
JHtml::_('behavior.framework');
?>

<form action="index.php" method="post" name="adminForm" id="adminForm">

	<table class="so-filterlist">
		<tr>
			<td class="so-align-left">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();" class="btn"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_catid').value='0';this.form.getElementById('filter_state').value='';this.form.submit();" class="btn"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
		</tr>
	</table>
    <table class="adminlist so-adminlist" >
    <thead>
        <tr>
            <th class="title">
				<?php echo JHTML::_('grid.sort',  JText::_('NAME'), 'name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th>
				<?php echo JHTML::_('grid.sort',  JText::_('ADDRESS'), 'address', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th>
				<?php echo JHTML::_('grid.sort',  JText::_('EMAIL'), 'email', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th>
				<?php echo JHTML::_('grid.sort',  JText::_('PHONE'), 'phone', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th>
				<?php echo JText::_( 'COUNT OF ORDERS' ); ?>
			</th>
        </tr>
    </thead>
    <tfoot>
		<tr>
			<td colspan="5">
				<?php echo $this->pageNav->getPagesLinks()  ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
    <?php
    $k = 0;

    for ($i=0, $n=count( $this->customers ); $i < $n; $i++)
    {
  		@$row = $this->customers[$i];

  		$link = JRoute::_( 'index.php?option=com_smartorder&controller=customers&task=edit&cid='. $row->id );

        if ($this->lists['search'] > '') {
            $row->name = str_ireplace($this->lists['search'],'<span style="background:yellow">'.$this->lists['search'].'</span>',$row->name);
            $row->email = str_ireplace($this->lists['search'],'<span style="background:yellow">'.$this->lists['search'].'</span>',$row->email);
            $row->address = str_ireplace($this->lists['search'],'<span style="background:yellow">'.$this->lists['search'].'</span>',$row->address);
            $row->phone = str_ireplace($this->lists['search'],'<span style="background:yellow">'.$this->lists['search'].'</span>',$row->phone);
        }
        ?>
        <tr class="<?php echo "row" . $k; ?>">
			<td>
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Edit customer' );?>">
					<a href="<?php echo $link; ?>">
					<?php echo $row->name; ?>
					</a>
				</span>
            </td>
            <td>
				<?php echo $row->address;?>
			</td>
            <td>
				<?php echo $row->email;?>
			</td>
            <td>
				<?php echo $row->phone;?>
			</td>
            <td>
				<?php echo $row->numOfOrders > '' ? $row->numOfOrders : '0' ;?>
			</td>
        </tr>
        <?php
        $k = 1 - $k;
    }
    ?>
    </tbody>
    </table>

<input type="hidden" name="option" value="com_smartorder" />
<input type="hidden" name="controller" value="customers" />
<input type="hidden" name="task" value="list" />
<input type="hidden" name="limitstart" value="0" />
<input type="hidden" name="filter_order" value="<?php echo @$this->lists['order'];?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo @$this->lists['order_Dir'];?>" />

<input type="hidden" name="boxchecked" value="0" />


</form>