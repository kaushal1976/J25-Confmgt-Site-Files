<?php
/**                     
* @package		Confmgt
* @subpackage	
* @copyright	Copyright 2013, All rights reserved
* @author		Dr Kaushal Keraminiyage - www.confmgt.com - admin@confmgt.com
* @license		GNU/GPL
*
*/

// no direct access
defined('_JEXEC') or die('Restricted access');



/**
* Confmgt Controller
*
* @package	Confmgt
* @subpackage	Classes
*/
class ConfmgtController extends ConfmgtCkController
{

	/**
	* The default view.
	*
	* @var string
	*/
	protected $default_view = 'cpanel';

	/**
	* Method to display a view.
	*
	* @access	public
	* @param	boolean	$cachable	If true, the view output will be cached.
	* @param	array	$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}..
	* @return	void
	*
	* @since	
	*/
	public function display($cachable = false, $urlparams = false)
	{
		//redirect the user if not logged in
		
		$jinput = JFactory::getApplication()->input;
		$layouttest = $jinput->get('layout', null, null);
		
		if (!$layouttest == 'authorlogin') {
		
			$user = JFactory::getUser();
			$msg = JText::_('CONFMGT_LAYOUT_AUTHLOGIN_MSG');
			if ($user->get('guest') == 1) {
				// Redirect to login page.
			$this->setRedirect(JRoute::_('index.php?option=com_confmgt&view=authorsitem&layout=authorlogin'),$msg,'message');
			return;
			}
		}
			
		$jinput = JFactory::getApplication()->input;

		$this->_parentDisplay();

		//If page is called through POST, reconstruct the url
		if ($jinput->getMethod(null, null) == 'POST')
		{
			//Kill the post and rebuild the url
			$this->setRedirect(ConfmgtHelper::urlRequest());
			return;
		}

		return $this;
	}


}



