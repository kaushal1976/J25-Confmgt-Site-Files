<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V2.5.6   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		0.3.1.2
* @package		Confmgt
* @subpackage	Revspapers
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
* Confmgt Revspapers Controller
*
* @package	Confmgt
* @subpackage	Revspapers
*/
class ConfmgtCkControllerRevspapers extends ConfmgtClassControllerList
{
	/**
	* The context for storing internal data, e.g. record.
	*
	* @var string
	*/
	protected $context = 'revspapers';

	/**
	* The URL view item variable.
	*
	* @var string
	*/
	protected $view_item = 'revspapersitem';

	/**
	* The URL view list variable.
	*
	* @var string
	*/
	protected $view_list = 'revspapers';

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
		if ($default)
			return 'default';

		$jinput = JFactory::getApplication()->input;
		return $jinput->get('layout', 'default', 'CMD');
	}


}

// Search for a fork to be able to override this class
JLoader::register('ConfmgtControllerRevspapers', JPATH_SITE_CONFMGT .DS. 'fork' .DS. 'controllers' .DS. 'revspapers.php');
JLoader::load('ConfmgtControllerRevspapers');
// Fallback if no fork has been found
if (!class_exists('ConfmgtControllerRevspapers')){ class ConfmgtControllerRevspapers extends ConfmgtCkControllerRevspapers{} }

