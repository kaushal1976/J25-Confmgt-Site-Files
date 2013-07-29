<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V2.5.6   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		0.3.1.2
* @package		Confmgt
* @subpackage	Main
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


$fieldSets = $this->form->getFieldsets();
?>
<?php $fieldSet = $this->form->getFieldset('paper.form');?>
<fieldset class="fieldsform form-horizontal">
	<legend><?php echo JText::_($fieldSets['paper.form']->label);?></legend>

	<?php
	// JForms dynamic initialization (Cook Self Service proposal)
	$fieldSet['jform_user']->jdomOptions = array(
			'list' => $this->lists['fk']['user']
		);
	$fieldSet['jform_theme']->jdomOptions = array(
			'ajaxVars' => array('values' => array(
				$this->item->theme,
				$this->item->_theme_track,
			))
		);

	// Iterate through the fields and display them.
	foreach($fieldSet as $field):

		//Check ACL
	    if ((method_exists($field, 'canView')) && !$field->canView())
	    	continue;

	    // If the field is hidden, only use the input.
	    if ($field->hidden):
	        echo $field->input;
	    else:
	    ?>
	    
	    <div class="control-group <?php echo($field->responsive)?>">
	    	<div class="control-label">
				<?php echo $field->label; ?>
			</div>
			
	        <div class="controls"<?php echo ($field->type == 'Editor' || $field->type == 'Textarea') ? ' style="clear: both; margin: 0;"' : ''?>>
				<?php echo $field->input ?>
			</div>
	    </div>
	    <?php endif; ?>
	    
	<?php endforeach;?>
</fieldset>