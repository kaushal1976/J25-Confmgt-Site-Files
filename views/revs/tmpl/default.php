<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V2.5.6   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		0.3.1.2
* @package		Confmgt
* @subpackage	Revs
* @copyright	Copyright 2013, All rights reserved
* @author		Dr Kaushal Keraminiyage - www.confmgt.com - admin@confmgt.com
* @license		GNU/GPL
*
* /!\  Joomla! is free software.
* This version may have been modified pursuant to the GNU General Public License,
* and as distributed it includes or is derivative of works licensed under the
* GNU General Public License or other free or open source software licenses.
*
*             .oooO  Oooo.     See COPYRIGHT.php for copyright notices and details.
*             (   )  (   )
* -------------\ (----) /----------------------------------------------------------- +
*               \_)  (_/
*/

// no direct access
defined('_JEXEC') or die('Restricted access');


ConfmgtHelper::headerDeclarations();
?>
<h2><?php echo $this->title;?></h2>
<form action="<?php echo(JRoute::_("index.php")); ?>" method="post" name="adminForm" id="adminForm">
	<div>
		<div>

			<!-- BRICK : toolbar_plur -->
			<?php echo JDom::_('html.toolbar', array(
				"bar" => JToolBar::getInstance('toolbar')
			));?>
		</div>
		<div>

			<!-- BRICK : filters -->
			<div class="pull-right">
				<?php echo $this->filters['limit']->input;?>
			</div>
			<div class="pull-right">
				<?php echo $this->filters['directionTable']->input;?>
			</div>
			<div class="pull-right">
				<?php echo $this->filters['sortTable']->input;?>
			</div>
			<div class="clearfix"></div>
			<div class="pull-right">
				<?php echo $this->filters['search_search']->input;?>
			</div>

		</div>
		<div>

			<!-- BRICK : grid -->
			<?php echo $this->loadTemplate('grid'); ?>
		</div>
		<div>

			<!-- BRICK : pagination -->
			<?php echo $this->pagination->getListFooter(); ?>
		</div>
	</div>


	<?php 
		$jinput = JFactory::getApplication()->input;
		echo JDom::_('html.form.footer', array(
		'values' => array(
					'view' => $jinput->get('view', 'revs'),
					'layout' => $jinput->get('layout', 'default'),
					'boxchecked' => '0',
					'filter_order' => $this->escape($this->state->get('list.ordering')),
					'filter_order_Dir' => $this->escape($this->state->get('list.direction'))
				)));
	?>
</form>
