<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V2.5.6   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		0.3.1.2
* @package		Confmgt
* @subpackage	Presentation
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
* Confmgt List Model
*
* @package	Confmgt
* @subpackage	Classes
*/
class ConfmgtCkModelPresentation extends ConfmgtClassModelList
{
	/**
	* The URL view item variable.
	*
	* @var string
	*/
	protected $view_item = 'presentationitem';

	/**
	* Constructor
	*
	* @access	public
	* @param	array	$config	An optional associative array of configuration settings.
	* @return	void
	*/
	public function __construct($config = array())
	{
		//Define the sortables fields (in lists)
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'paper_id', 'a.paper_id',
				'_paper_id_title', '_paper_id_.title',
				'_presenter_surname', '_presenter_.surname',

			);
		}

		//Define the filterable fields
		$this->set('filter_vars', array(
			'publish' => 'varchar',
			'sortTable' => 'cmd',
			'directionTable' => 'cmd',
			'limit' => 'cmd'
				));

		//Define the searchable fields
		$this->set('search_vars', array(
			'search' => 'string'
				));


		parent::__construct($config);
		
	}

	/**
	* Method to get a list of items.
	*
	* @access	public
	*
	* @return	mixed	An array of data items on success, false on failure.
	*
	* @since	11.1
	*/
	public function getItems()
	{

		$items	= parent::getItems();
		$app	= JFactory::getApplication();


		$this->populateParams($items);

		//Create linked objects
		$this->populateObjects($items);

		return $items;
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
		return $jinput->get('layout', 'default', 'STRING');
	}

	/**
	* Method to get a store id based on model configuration state.
	* 
	* This is necessary because the model is used by the component and different
	* modules that might need different sets of data or differen ordering
	* requirements.
	*
	* @access	protected
	* @param	string	$id	A prefix for the store id.
	* @return	void
	*
	* @since	1.6
	*/
	protected function getStoreId($id = '')
	{
		// Compile the store id.





		return parent::getStoreId($id);
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
		// Initialise variables.
		$app = JFactory::getApplication();
		$session = JFactory::getSession();
		$acl = ConfmgtHelper::getActions();

		parent::populateState('a.publish', 'asc');

		//Only show the published items
		if (!$acl->get('core.admin') && !$acl->get('core.edit.state'))
			$this->setState('filter.publish', 1);
	}

	/**
	* Preparation of the list query.
	*
	* @access	protected
	* @param	object	&$query	returns a filled query object.
	* @return	void
	*/
	protected function prepareQuery(&$query)
	{

		$acl = ConfmgtHelper::getActions();

		//FROM : Main table
		$query->from('#__confmgt_presentation AS a');



		//IMPORTANT REQUIRED FIELDS
		$this->addSelect(	'a.id,'
						.	'a.publish');

		switch($this->getState('context'))
		{
			case 'presentation.default':

				//BASE FIELDS
				$this->addSelect(	'a.creation_date,'
								.	'a.modification_date,'
								.	'a.paper_id,'
								.	'a.presentation,'
								.	'a.presenter');

				//SELECT
				$this->addSelect('_paper_id_.title AS `_paper_id_title`');
				$this->addSelect('_paper_id_.paper_id AS `_paper_id_paper_id`');
				$this->addSelect('_presenter_.surname AS `_presenter_surname`');

				//JOIN
				$this->addJoin('`#__confmgt_main` AS _paper_id_ ON _paper_id_.id = a.paper_id', 'LEFT');
				$this->addJoin('`#__confmgt_authors` AS _presenter_ ON _presenter_.id = a.presenter', 'LEFT');

				//GROUP BY (PRIMARY ORDER)
				$this->addGroupOrder('a.paper_id');

				break;
			default:
				//SELECT : raw complete query without joins
				$this->addSelect('a.*');

				// Disable the pagination
				$this->setState('list.limit', null);
				$this->setState('list.start', null);
				break;
		}

		// ACCESS - Publish state
		$wherePublished = '(a.publish = 1 OR a.publish IS NULL)'; //Published or undefined state
		//Allow some users to access (core.edit.state)
		if ($acl->get('core.edit.state'))
			$wherePublished = '1'; //Do not filter

		// FILTER - Published state
		$published = $this->getState('filter.published');
		if (is_numeric($published))
		{
			//Limit to publish state when filter is applied
			$wherePublished = 'a.publish = ' . (int)$published;
			//Does not apply the author condition when filter is defined
			$allowAuthor = '0';
		}

		$query->where("$wherePublished");

		//WHERE - SEARCH : search_search : search on Modification date + Creation date + Paper ID > Title + Paper ID > Key words + Presenter > First Name + Presenter > Surname + Presenter > Email + Presenter > Affiliation
		$search_search = $this->getState('search.search');
		$this->addSearch('search', 'a.modification_date', 'like');
		$this->addSearch('search', 'a.creation_date', 'like');
		$this->addSearch('search', '_paper_id_.title', 'like');
		$this->addSearch('search', '_paper_id_.key_words', 'like');
		$this->addSearch('search', '_presenter_.first_name', 'like');
		$this->addSearch('search', '_presenter_.surname', 'like');
		$this->addSearch('search', '_presenter_.email', 'like');
		$this->addSearch('search', '_presenter_.affiliation', 'like');
		if (($search_search != '') && ($search_search_val = $this->buildSearch('search', $search_search)))
			$this->addWhere($search_search_val);

		//Populate only uniques strings to the query
		//SELECT
		foreach($this->getState('query.select', array()) as $select)
			$query->select($select);

		//JOIN
		foreach($this->getState('query.join.left', array()) as $join)
			$query->join('LEFT', $join);

		//WHERE
		foreach($this->getState('query.where', array()) as $where)
			$query->where($where);

		//GROUP ORDER : Prioritary order for groups in lists
		foreach($this->getState('query.groupOrder', array()) as $groupOrder)
			$query->order($groupOrder);

		//ORDER
		foreach($this->getState('query.order', array()) as $order)
			$query->order($order);

		//ORDER
		$orderCol = $this->getState('list.ordering');
		$orderDir = $this->getState('list.direction', 'asc');

		if ($orderCol)
			$query->order($orderCol . ' ' . $orderDir);
	}


}

// Search for a fork to be able to override this class
JLoader::register('ConfmgtModelPresentation', JPATH_SITE_CONFMGT .DS. 'fork' .DS. 'models' .DS. 'presentation.php');
JLoader::load('ConfmgtModelPresentation');
// Fallback if no fork has been found
if (!class_exists('ConfmgtModelPresentation')){ class ConfmgtModelPresentation extends ConfmgtCkModelPresentation{} }

