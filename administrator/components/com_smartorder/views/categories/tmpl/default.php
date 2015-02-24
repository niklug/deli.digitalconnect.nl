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
JSubMenuHelper::addEntry(JText::_('CATEGORIES'), 'index.php?option=com_smartorder&controller=categories&task=list', true );
JSubMenuHelper::addEntry(JText::_('ITEMS'), 'index.php?option=com_smartorder&controller=items&task=list');
JSubMenuHelper::addEntry(JText::_('TOPPINGS'), 'index.php?option=com_smartorder&controller=toppings&task=list');
JSubMenuHelper::addEntry(JText::_('ORDERS'), 'index.php?option=com_smartorder&controller=orders&task=list');
JSubMenuHelper::addEntry(JText::_('CUSTOMERS'), 'index.php?option=com_smartorder&controller=customers&task=list');
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
			<td class="so-align-right so-nowrap">
				<?php
				echo $this->lists['state'];
				?>
			</td>
		</tr>
	</table>
    <table class="adminlist so-adminlist" >
    <thead>
        <tr>
            <th class="so-align-center">
                <?php echo JText::_( 'ID' ); ?>
            </th>
            <th class="so-align-center">
				<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
			</th>
            <th class="title">
				<?php echo JHTML::_('grid.sort', JText::_('CATEGORY NAME'), 'name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th class="so-align-center">
				<?php echo JHTML::_('grid.sort',   'Published', 'published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th class="so-nowrap">
				<?php echo JHTML::_('grid.sort',   'Order', 'ordering', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				<?php if ($ordering) echo JHTML::_('grid.order',  @$this->categories ); ?>
			</th>
			<th class="so-align-center so-nowrap">
				<?php echo JText::_( 'NUM_OF_ITEMS_PUBLISHED' ); ?>
			</th>
        </tr>
    </thead>
    <tfoot>
		<tr>
			<td colspan="6">
				<?php echo $this->pageNav->getPagesLinks()  ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
    <?php
    $k = 0;

    for ($i=0, $n=count( $this->categories ); $i < $n; $i++)
    {
  		@$row = $this->categories[$i];

  		$link = JRoute::_( 'index.php?option=com_smartorder&controller=categories&task=edit&cid='. $row->id );

  		$checked 	= JHTML::_('grid.id', $i, $row->id );
		$published 	= JHTML::_('grid.published', $row, $i );

        ?>
        <tr class="<?php echo "row" . $k; ?>">
            <td class="so-align-center">
                <?php echo $row->id; ?>
            </td>
            <td class="so-align-center">
				<?php echo $checked; ?>
			</td>
			<td>
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Edit category' );?> :: <?php echo $row->name; ?>">
					<a href="<?php echo $link; ?>">
					<?php echo $row->name; ?>
					</a>
				</span>
            </td>
            <td class="so-align-center">
				<?php echo $published;?>
			</td>
			<td class="order">
				<span><?php echo $this->pageNav->orderUpIcon($i, true, 'orderup', 'Move Up', $ordering ); ?></span>
				<span><?php echo $this->pageNav->orderDownIcon($i, $n, true, 'orderdown', 'Move Down', $ordering ); ?></span>
				<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
				<input type="text" name="order[]" size="3" value="<?php echo $row->ordering;?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
			</td>
            <td class="so-align-center">
				<?php echo $row->numOfItems > '' ? $row->numOfItems : '0' ;?>
				&nbsp;(<?php echo $row->numOfPublishedItems > '' ? $row->numOfPublishedItems : '0' ?>)
			</td>
        </tr>
        <?php
        $k = 1 - $k;
    }
    ?>
    </tbody>
    </table>

<input type="hidden" name="option" value="com_smartorder" />
<input type="hidden" name="controller" value="categories" />
<input type="hidden" name="task" value="list" />
<input type="hidden" name="limitstart" value="0" />
<input type="hidden" name="filter_order" value="<?php echo @$this->lists['order'];?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo @$this->lists['order_Dir'];?>" />

<input type="hidden" name="boxchecked" value="0" />


</form>