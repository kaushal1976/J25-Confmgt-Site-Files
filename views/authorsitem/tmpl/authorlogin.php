<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V2.5.6   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		0.3.1.2
* @package		Confmgt
* @subpackage	Authors
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


ConfmgtHelper::headerDeclarations();//Load the formvalidator scripts requirements.
JDom::_('html.toolbar');

$options = array(
    'onActive' => 'function(title, description){
        description.setStyle("display", "block");
        title.addClass("open").removeClass("closed");
    }',
    'onBackground' => 'function(title, description){
        description.setStyle("display", "none");
        title.addClass("closed").removeClass("open");
    }',
    'startOffset' => 0,  // 0 starts on the first tab, 1 starts the second, etc...
    'useCookie' => true, // this must not be a string. Don't use quotes.
);
 

?>
<script language="javascript" type="text/javascript">
	//Secure the user navigation on the page, in order preserve datas.
	var holdForm = true;
	window.onbeforeunload = function closeIt(){	if (holdForm) return false;};
</script>

<h2><?php echo $this->title;?></h2>

<?php 

echo JHtml::_('tabs.start', 'tab_group_id', $options);
echo JHtml::_('tabs.panel', JText::_('CONFMGT_LAYOUT_AUTHOR_LOGIN'), 'panel_1_id');
?>
<form action="<?php echo(JRoute::_("index.php")); ?>" method="post" name="adminForm" id="adminForm" class='form-validate'>
	<div>
		<div>

			<!-- BRICK : form_1 -->
			<?php echo $this->loadTemplate('form_1'); ?>
		</div>
		<div>

			<!-- BRICK : toolbar_sing -->
			<?php echo JDom::_('html.toolbar', array(
				"bar" => JToolBar::getInstance('toolbar')
			));?>
		</div>

	</div>


	<?php 
		$jinput = JFactory::getApplication()->input;
		echo JDom::_('html.form.footer', array(
		'dataObject' => $this->item,
		'values' => array(
					'id' => $this->state->get('authorsitem.id')
				)));
	?>
</form>
<?php 
echo JHtml::_('tabs.panel', JText::_('CONFMGT_JFORM_NEW_ACCOUNT'), 'panel_2_id');

?>

<form action="<?php echo(JRoute::_("index.php")); ?>" method="post" name="adminForm" id="adminForm" class='form-validate'>
	<div>
		<div>

		<div>

			<!-- BRICK : form_2 -->
			<?php echo $this->loadTemplate('form_2'); ?>
		</div>
	</div>


	<?php 
		$jinput = JFactory::getApplication()->input;
		echo JDom::_('html.form.footer', array(
		'dataObject' => $this->item,
		'values' => array(
					'id' => $this->state->get('authorsitem.id')
				)));
	?>
</form>
<?php 
echo JHtml::_('tabs.end');

?>
