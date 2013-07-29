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



/**
* Confmgt Item Model
*
* @package	Confmgt
* @subpackage	Classes
*/
class ConfmgtCkModelPaper extends ConfmgtClassModelItem
{
	/**
	* View list alias
	*
	* @var string
	*/
	protected $view_item = 'paper';

	/**
	* View list alias
	*
	* @var string
	*/
	protected $view_list = 'main';

	/**
	* Constructor
	*
	* @access	public
	* @param	array	$config	An optional associative array of configuration settings.
	* @return	void
	*/
	public function __construct($config = array())
	{
		parent::__construct();
	}

	/**
	* Method to delete item(s).
	*
	* @access	public
	* @param	array	&$pks	Ids of the items to delete.
	*
	* @return	boolean	True on success.
	*/
	public function delete(&$pks)
	{
		if (!count( $pks ))
			return true;


		if (!parent::delete($pks))
			return false;



		return true;
	}

	/**
	* Method to get the layout (including default).
	*
	* @access	public
	*
	* @return	string	The layout alias.
	*/
	public function getLayout()
	{
		$jinput = JFactory::getApplication()->input;
		return $jinput->get('layout', 'abstractreview', 'STRING');
	}

	/**
	* Returns a Table object, always creating it.
	*
	* @access	public
	* @param	string	$type	The table type to instantiate.
	* @param	string	$prefix	A prefix for the table class name. Optional.
	* @param	array	$config	Configuration array for model. Optional.
	*
	* @return	JTable	A database object
	*
	* @since	1.6
	*/
	public function getTable($type = 'paper', $prefix = 'ConfmgtTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	* Method to get the data that should be injected in the form.
	*
	* @access	protected
	*
	* @return	mixed	The data for the form.
	*/
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_confmgt.edit.paper.data', array());

		if (empty($data)) {
			//Default values shown in the form for new item creation
			$data = $this->getItem();

			// Prime some default values.
			if ($this->getState('paper.id') == 0)
			{
				$jinput = JFactory::getApplication()->input;

				$data->id = 0;
				$data->paper_id = null;
				$data->link_id = null;
				$data->user = $jinput->get('filter_user', $this->getState('filter.user'), 'INT');
				$data->title = null;
				$data->abstract = null;
				$data->theme = $jinput->get('filter_theme', $this->getState('filter.theme'), 'INT');
				$data->key_words = null;
				$data->student_paper = null;
				$data->creation_date = null;
				$data->modification_date = null;
				$data->publish = 1;
				$data->full_paper = $jinput->get('filter_full_paper', $this->getState('filter.full_paper'), 'INT');
				$data->camera_ready_paper = $jinput->get('filter_camera_ready_paper', $this->getState('filter.camera_ready_paper'), 'INT');
				$data->presentation = $jinput->get('filter_presentation', $this->getState('filter.presentation'), 'INT');

			}
		}
		return $data;
	}

	/**
	* Method to auto-populate the model state.
	* 
	* This method should only be called once per instantiation and is designed to
	* be called on the first call to the getState() method unless the model
	* configuration flag to ignore the request is set.
	* 
	* Note. Calling getState in this method will result in recursion.
	*
	* @access	public
	* @param	string	$ordering	
	* @param	string	$direction	
	* @return	void
	*
	* @since	11.1
	*/
	public function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();
		$session = JFactory::getSession();
		$acl = ConfmgtHelper::getActions();



		parent::populateState($ordering, $direction);

		//Only show the published items
		if (!$acl->get('core.admin') && !$acl->get('core.edit.state'))
			$this->setState('filter.publish', 1);
	}

	/**
	* Preparation of the query.
	*
	* @access	protected
	* @param	object	&$query	returns a filled query object.
	* @param	integer	$pk	The primary id key of the paper
	* @return	void
	*/
	protected function prepareQuery(&$query, $pk)
	{

		$acl = ConfmgtHelper::getActions();

		//FROM : Main table
		$query->from('#__confmgt_main AS a');



		//IMPORTANT REQUIRED FIELDS
		$this->addSelect(	'a.id,'
						.	'a.publish');

		switch($this->getState('context'))
		{
			case 'paper.paper':

				//BASE FIELDS
				$this->addSelect(	'a.abstract,'
								.	'a.key_words,'
								.	'a.link_id,'
								.	'a.paper_id,'
								.	'a.student_paper,'
								.	'a.theme,'
								.	'a.title,'
								.	'a.user');

				//SELECT
				$this->addSelect('_user_.name AS `_user_name`');
				$this->addSelect('_theme_.name AS `_theme_name`');
				$this->addSelect('_theme_.track AS `_theme_track`');
				$this->addSelect('_theme_track_.track_name AS `_theme_track_track_name`');

				//JOIN
				$this->addJoin('`#__users` AS _user_ ON _user_.id = a.user', 'LEFT');
				$this->addJoin('`#__confmgt_themes` AS _theme_ ON _theme_.id = a.theme', 'LEFT');
				$this->addJoin('`#__confmgt_tracs` AS _theme_track_ ON _theme_track_.id = _theme_.track', 'LEFT');

				break;

			case 'paper.abstractview':

				//BASE FIELDS
				$this->addSelect(	'a.abstract,'
								.	'a.camera_ready_paper,'
								.	'a.creation_date,'
								.	'a.full_paper,'
								.	'a.key_words,'
								.	'a.link_id,'
								.	'a.paper_id,'
								.	'a.presentation,'
								.	'a.student_paper,'
								.	'a.theme,'
								.	'a.title,'
								.	'a.user');

				//SELECT
				$this->addSelect('_user_.name AS `_user_name`');
				$this->addSelect('_theme_.name AS `_theme_name`');

				//JOIN
				$this->addJoin('`#__users` AS _user_ ON _user_.id = a.user', 'LEFT');
				$this->addJoin('`#__confmgt_themes` AS _theme_ ON _theme_.id = a.theme', 'LEFT');

				break;

			case 'paper.fullpaperreview':
				break;

			case 'paper.abstractreview':
				break;
			default:
				//SELECT : raw complete query without joins
				$query->select('a.*');
				break;
		}

		//SELECT : Instance Add-ons
		foreach($this->getState('query.select', array()) as $select)
			$query->select($select);

		//JOIN : Instance Add-ons
		foreach($this->getState('query.join.left', array()) as $join)
			$query->join('LEFT', $join);

		//WHERE : Item layout (based on $pk)
		$query->where('a.id = ' . (int) $pk);		//TABLE KEY

		// ACCESS : Publish state
		$wherePublished = '(a.publish = 1 OR a.publish IS NULL)'; //Published or undefined state
		//Allow some users to access (core.edit.state)
		if ($acl->get('core.edit.state'))
			$wherePublished = '1'; //Do not filter

		$query->where("$wherePublished");
	}

	/**
	* Prepare and sanitise the table prior to saving.
	*
	* @access	protected
	* @param	JTable	$table	A JTable object.
	*
	* @return	void	
	* @return	void
	*
	* @since	1.6
	*/
	protected function prepareTable($table)
	{
		$date = JFactory::getDate();


		if (empty($table->id))
		{
			//Creation date
			if (empty($table->creation_date))
				$table->creation_date = ConfmgtHelperDates::toSql($date);
		}
		else
		{
			//Modification date
			$table->modification_date = ConfmgtHelperDates::toSql($date);
		}

	}

	/**
	* Save an item.
	*
	* @access	public
	* @param	array	$data	The post values.
	*
	* @return	boolean	True on success.
	*/
	public function save($data)
	{

		//Some security checks
		$acl = ConfmgtHelper::getActions();

		//Secure the published tag if not allowed to change
		if (isset($data['publish']) && !$acl->get('core.edit.state'))
			unset($data['publish']);

		if (parent::save($data)) {
			return true;
		}
		return false;


	}


}

// Search for a fork to be able to override this class
JLoader::register('ConfmgtModelPaper', JPATH_SITE_CONFMGT .DS. 'fork' .DS. 'models' .DS. 'paper.php');
JLoader::load('ConfmgtModelPaper');
// Fallback if no fork has been found
if (!class_exists('ConfmgtModelPaper')){ class ConfmgtModelPaper extends ConfmgtCkModelPaper{} }

