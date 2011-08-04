<?php
defined('_JEXEC') or die('Restricted access');
	
$task = JRequest::getCmd('task');
if ($task == 'redirect') {
	global $mainframe;
	$cacl_redirect_url = $_SESSION['cacl_redirect_url'];
	unset($_SESSION['cacl_redirect_url']);
	
	if ($cacl_redirect_url != '') {
		$link = substr($cacl_redirect_url, strpos($cacl_redirect_url, '?') + 1);
		$link = str_replace('&amp;', '&', $link);
		$pairs = explode('&', $link);		
		if (count($pairs) > 0 ) {
			$request = array();
			foreach($pairs as $pair) {
				list($option, $value) = explode('=', $pair);
				$request[$option] = $value;
			}

			if ( (isset($request['option']) && $request['option'] == 'com_user') && (isset($request['view']) && $request['view'] == 'login') ) {
				if (isset($request['return'])) {
					$return = base64_decode($request['return']);
					$mainframe->redirect($return); die;
				}
				$mainframe->redirect('index.php'); die;
			}
		}
		$mainframe->redirect($cacl_redirect_url);
		die;
	}
	
	$db =& JFactory::getDBO();
	$query = "SELECT `params` FROM `#__modules` WHERE `module` = 'mod_cblogin' AND `params` LIKE '%login%logout%'";
	$db->setQuery($query);
	$params = $db->loadResult();	
	$params = new JParameter( $params );
	
	$cb_url = $params->get('login');
	
	if ($cb_url != '') {
		$mainframe->redirect($cb_url);
		die;
	}	
	
	$query = "SELECT `params` FROM `#__modules` WHERE `module` = 'mod_login' AND `params` LIKE '%login%logout%'";
	$db->setQuery($query);
	$params = $db->loadResult();	
	$params = new JParameter( $params );
	$user = & JFactory::getUser();
	$type = (!$user->get('guest')) ? 'logout' : 'login'; 
	if($itemid =  $params->get($type))
	{
		$menu =& JSite::getMenu();
		$item = $menu->getItem($itemid);
		$url = $item->link;
	}
	else
	{
		// Redirect to login
		$url = 'index.php?option=com_user&view=login';
		// Silly - this didnt work correctly - lets hope the above resolves things.
		/*$uri = JFactory::getURI();
		$url = $uri->toString();
		*/
	}
	$standart_url = $url;
	
	if ($standart_url != '') {
		$mainframe->redirect($standart_url);
		die;
	}
	
	$mainframe->redirect('index.php');die;
} 
echo "This component doesn't have Front End part.";
?>