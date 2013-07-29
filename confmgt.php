<?php
/**     
* @version		0.3.1.2
* @package		Confmgt
* @subpackage	
* @copyright	Copyright 2013, All rights reserved
* @author		Dr Kaushal Keraminiyage - www.confmgt.com - admin@confmgt.com
* @license		GNU/GPL
*
*
*/


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
if(!defined('DS')) define('DS',DIRECTORY_SEPARATOR);

//Copy this line to be able to call the application from outside (Module, Plugin, Third component, ...)
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_confmgt'.DS.'helpers'.DS.'loader.php');

//Document title
$document	= JFactory::getDocument();
$document->titlePrefix = "Confmgt - ";
$document->titleSuffix = "";

if (defined('JDEBUG') && count($_POST))
	$_SESSION['Confmgt']['$_POST'] = $_POST;

$jinput = JFactory::getApplication()->input;
// When this component is called to return a file
// TODO : A better practice is to call it through the View Class
if ($jinput->get('task', null, 'CMD') == 'file')
	ConfmgtClassFile::returnFile();

$controller = CkJController::getInstance('Confmgt');
$controller->execute($jinput->get('task', null, 'CMD'));
$controller->redirect();
