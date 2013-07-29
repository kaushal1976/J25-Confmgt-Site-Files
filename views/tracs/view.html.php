<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V2.5.6   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		0.3.1.2
* @package		Confmgt
* @subpackage	Tracs
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



/**
* HTML View class for the Confmgt component
*
* @package	Confmgt
* @subpackage	Tracs
*/
class ConfmgtCkViewTracs extends ConfmgtClassView
{
	/**
	* Execute and display a template script.
	*
	* @access	public
	* @param	string	$tpl	The name of the template file to parse; automatically searches through the template paths.
	*
	* @return	mixed	A string if successful, otherwise a JError object.
	*
	* @since	11.1
	*/
	public function display($tpl = null)
	{
		$layout = $this->getLayout();
		if (in_array($layout, array('ajax')))
		{
			$fct = "display" . ucfirst($layout);

			$this->addForkTemplatePath();
			$this->$fct($tpl);			
		}
		$this->_parentDisplay($tpl);
	}

	/**
	* Execute and display ajax queries
	*
	* @access	protected
	* @param	string	$tpl	The name of the template file to parse; automatically searches through the template paths.
	*
	* @return	mixed	A string if successful, otherwise a JError object.
	*
	* @since	11.1
	*/
	protected function displayAjax($tpl = null)
	{
		$jinput = JFactory::getApplication()->input;
		$render = $jinput->get('render', null, 'CMD');
		$token = $jinput->get('token', null, 'BASE64');
		$values = $jinput->get('values', null, 'ARRAY');



		switch($render)
		{
			case 'groupby1':

				$model = $this->getModel();
				$items = $model->getItems();


				$selected = (is_array($values))?$values[count($values)-1]:$values;

				$ajaxNamespace = "confmgt.themes.ajax.groupby1";
				$wrapper = "_ajax_themes_$render";

				$event = 'jQuery("#__ajx_theme").val("");'
						.	'if(this.value != ""){'
						.		'jQuery("#' . $wrapper . '").jdomAjax({namespace:"' . $ajaxNamespace . '", vars:{"filter_track":this.value}})'
						.	'}else{'
						.		'jQuery("#' . $wrapper . '").innerHTML = "";'
						.	'}';

				echo '<div class="ajaxchain-filter ajaxchain-filter-hz">';
					echo JDom::_('html.form.input.select', array(
						'dataKey' => '_theme_track',
						'dataValue' => $selected,
						'labelKey' => 'track_name',
						'list' => $items,
						'listKey' => 'id',
						'nullLabel' => 'CONFMGT_FILTER_NULL_TRACK',
						'selectors' => array(
								'onchange' => $event
							)
						));
				echo '</div>';

				//Ajax chain on load -> Follows the values
				echo JDom::_('html.form.input.ajax.chain', array(
					'ajaxWrapper' => $wrapper,
					'ajaxContext' => $ajaxNamespace,
					'ajaxVars' => array(
									'filter_track' => $selected,
									'values' => $values),
					'ajaxToken' => $token,

				));


				//Wrapper Div
				echo("<div id='" . $wrapper ."' class='ajaxchain-wrapper ajaxchain-wrapper-hz'></div>");
				break;
		}

		exit();
	}

	/**
	* Returns an array of fields the table can be sorted by.
	*
	* @access	protected
	* @param	string	$layout	The name of the called layout. Not used yet
	*
	* @return	array	Array containing the field name to sort by as the key and display text as value.
	*
	* @since	3.0
	*/
	protected function getSortFields($layout = null)
	{
		return array();
	}


}

// Search for a fork to be able to override this class
JLoader::register('ConfmgtViewTracs', JPATH_SITE_CONFMGT .DS. 'fork' .DS. 'views' .DS. 'tracs' .DS. 'view.html.php');
JLoader::load('ConfmgtViewTracs');
// Fallback if no fork has been found
if (!class_exists('ConfmgtViewTracs')){ class ConfmgtViewTracs extends ConfmgtCkViewTracs{} }

