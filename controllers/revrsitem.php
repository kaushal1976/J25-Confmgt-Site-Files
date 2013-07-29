<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V2.5.6   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		0.3.1.2
* @package		Confmgt
* @subpackage	Revrs
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
* Confmgt Revrsitem Controller
*
* @package	Confmgt
* @subpackage	Revrsitem
*/
class ConfmgtCkControllerRevrsitem extends ConfmgtClassControllerItem
{
	/**
	* The context for storing internal data, e.g. record.
	*
	* @var string
	*/
	protected $context = 'revrsitem';

	/**
	* The URL view item variable.
	*
	* @var string
	*/
	protected $view_item = 'revrsitem';

	/**
	* The URL view list variable.
	*
	* @var string
	*/
	protected $view_list = 'revrs';

	/**
	* Constructor
	*
	* @access	public
	* @param	array	$config	An optional associative array of configuration settings.
	* @return	void
	*/
	public function __construct($config = array())
	{
		parent::__construct($config);
		$app = JFactory::getApplication();
		$this->registerTask('toggle_accepted', 'toggle');


	}

	/**
	* Method to add an element.
	*
	* @access	public
	* @return	void
	*/
	public function add()
	{
		CkJSession::checkToken() or CkJSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
		$this->_result = $result = parent::add();
		$model = $this->getModel();

		//Define the redirections
		switch($this->getLayout() .'.'. $this->getTask())
		{
			case 'default.add':
				$this->applyRedirection($result, array(
					'stay',
					'com_confmgt.revrsitem.reviewer'
				), array(
			
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'com_confmgt.revrsitem.reviewerview'
				));
				break;
		}
	}

	/**
	* Method to cancel an element.
	*
	* @access	public
	* @return	void
	*/
	public function cancel()
	{
		$this->_result = $result = parent::cancel();
		$model = $this->getModel();

		//Define the redirections
		switch($this->getLayout() .'.'. $this->getTask())
		{
			case 'reviewer.cancel':
				$this->applyRedirection($result, array(
					'stay',
					'com_confmgt.revrs.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'reviewerview.cancel':
				$this->applyRedirection($result, array(
					'stay',
					'com_confmgt.revrs.default'
				), array(
					'cid[]' => null
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'com_confmgt.revrs.default'
				));
				break;
		}
	}

	/**
	* Method to delete an element.
	*
	* @access	public
	* @return	void
	*/
	public function delete()
	{
		CkJSession::checkToken() or CkJSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
		$this->_result = $result = parent::delete();
		$model = $this->getModel();

		//Define the redirections
		switch($this->getLayout() .'.'. $this->getTask())
		{
			case 'default.delete':
				$this->applyRedirection($result, array(
					'stay',
					'com_confmgt.revrs.default'
				), array(
					'cid[]' => null
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'com_confmgt.revrs.default'
				));
				break;
		}
	}

	/**
	* Method to edit an element.
	*
	* @access	public
	* @return	void
	*/
	public function edit()
	{
		CkJSession::checkToken() or CkJSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
		$this->_result = $result = parent::edit();
		$model = $this->getModel();

		//Define the redirections
		switch($this->getLayout() .'.'. $this->getTask())
		{
			case 'default.edit':
				$this->applyRedirection($result, array(
					'stay',
					'com_confmgt.revrsitem.reviewer'
				), array(
			
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'com_confmgt.revrsitem.reviewerview'
				));
				break;
		}
	}

	/**
	* Return the current layout.
	*
	* @access	protected
	* @param	bool	$default	If true, return the default layout.
	*
	* @return	string	Requested layout or default layout
	*/
	protected function getLayout($default = null)
	{
		if ($default === 'edit')
			return 'reviewer';

		if ($default)
			return 'reviewerview';

		$jinput = JFactory::getApplication()->input;
		return $jinput->get('layout', 'reviewerview', 'CMD');
	}

	/**
	* Method to save an element.
	*
	* @access	public
	* @return	void
	*/
	public function save()
	{
		CkJSession::checkToken() or CkJSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
		//Check the ACLs
		$model = $this->getModel();
		$item = $model->getItem();
		$result = false;
		if ($model->canEdit($item, true))
		{
			$result = parent::save();
			//Get the model through postSaveHook()
			if ($this->model)
			{
				$model = $this->model;
				$item = $model->getItem();	
			}
		}
		else
			JError::raiseWarning( 403, JText::sprintf('ACL_UNAUTORIZED_TASK', JText::_('CONFMGT_JTOOLBAR_SAVE')) );

		$this->_result = $result;

		//Define the redirections
		switch($this->getLayout() .'.'. $this->getTask())
		{
			case 'reviewer.save':
				$this->applyRedirection($result, array(
					'stay',
					'com_confmgt.revrs.default'
				), array(
					'cid[]' => null
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'com_confmgt.revrs.default'
				));
				break;
		}
	}

	/**
	* Method to toggle a field value.
	*
	* @access	public
	* @return	void
	*/
	public function toggle()
	{
		CkJSession::checkToken() or CkJSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
		$this->_result = $result = $this->_toggle(array(
			'toggle_accepted' => 'accepted'
		));
		$model = $this->getModel();

		//Define the redirections
		switch($this->getLayout() .'.'. $this->getTask())
		{
			case 'default.toggle':
				$this->applyRedirection($result, array(
					'stay',
					'com_confmgt.revrs.default'
				), array(
					'cid[]' => null
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'stay'
				));
				break;
		}
	}


}

// Search for a fork to be able to override this class
JLoader::register('ConfmgtControllerRevrsitem', JPATH_SITE_CONFMGT .DS. 'fork' .DS. 'controllers' .DS. 'revrsitem.php');
JLoader::load('ConfmgtControllerRevrsitem');
// Fallback if no fork has been found
if (!class_exists('ConfmgtControllerRevrsitem')){ class ConfmgtControllerRevrsitem extends ConfmgtCkControllerRevrsitem{} }

