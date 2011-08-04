<?php
// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.event.plugin' );
require_once(JPATH_SITE.'/administrator/components/com_community_acl/community_acl.functions.php');

class plgAuthenticationCommunity_ACL extends JPlugin {
	function plgAuthenticationCommunity_ACL(& $subject, $config) {
		parent::__construct ( $subject, $config );

		$db =& JFactory::getDBO();
		$config = new CACL_config($db);
		$config->load();
		$this->_caclConfig = $config;
	}
	function onAuthenticate($credentials, $referrer, $object) {

	    $app =& JFactory::getApplication();
	    //adding cACL Activate
	    if( FALSE === strpos($this->_caclConfig->activate, $app->getName())){
	        return;
	    }

		$id = $redirection = null;
		$db = JFactory::getDBO ();

		// Check if user is valid // Quick
		$query = "SELECT id,usertype FROM #__users WHERE username = '{$credentials['username']}' ";
		$db->setQuery ( $query );
		$result = $db->loadAssoc ();
		$id = $result ['id'];
		$usertype = strtolower ( $result ['usertype'] );

		$query = 'SELECT
			cfg1.value as group_id,
			cfg2.value as role_id
			FROM #__community_acl_config as cfg1
			join #__community_acl_config as cfg2
  				on cfg2.name=\'' . $usertype . '_role\'
			where cfg1.name = \'' . $usertype . '_group\'';

		$db->setQuery ( $query );
		$defaultUserType = $db->loadAssoc ();

		$query = "SELECT group_id, role_id FROM #__community_acl_users WHERE user_id = " . $id;
		$db->setQuery ( $query );
		//$redirect = $db->loadObjectList ();
		$redirect = $db->loadAssoc ();

		$redirect = array_merge ( ( array ) $defaultUserType, ( array ) $redirect );

		# -This person is a super administrator
		if (empty ( $redirect )) {
			return;
		}

		#Need to know if we are at the backend or the frontend
		$app = & JFactory::getApplication ();
		$back_end = false;
		if ($app->getName () != 'site') {
			$back_end = true;
		}
		$redirection = '';
		// Check to see if redirection exists for user
		if ($id) {
			# Check 1 - check if user has a redirect (if NOT move on)
			switch ($back_end) {
				case true : //Backend
					# Check 1 - User Redirect
					$query = "SELECT redirect_ADMIN FROM #__community_acl_users WHERE user_id = " . $id;
					$db->setQuery ( $query );
					$redirection = $db->loadResult ();
					if (! empty ( $redirection )) {
						break;
					}
					# Check 2 - Role redirect
					$query = "SELECT redirect_ADMIN FROM #__community_acl_roles WHERE id = " . $redirect ['role_id'];
					$db->setQuery ( $query );
					$redirection = $db->loadResult ();
					if (! empty ( $redirection )) {
						break;
					}
					# Check 3 - Group redirect
					$query = "SELECT redirect_URL_ADMIN FROM #__community_acl_groups WHERE id = " . $redirect ['group_id'];
					$db->setQuery ( $query );
					$redirection = $db->loadResult ();
					if (! empty ( $redirection )) {
						break;
					}
					$redirection = '';
					break;
				case false :
					#- Frontend User Redirect
					$query = "SELECT redirect_FRONT FROM #__community_acl_users WHERE user_id = " . $id;
					$db->setQuery ( $query );
					$redirection = $db->loadResult ();
					if (! empty ( $redirection )) {
						break;
					}
					# Check 2 - Role redirect
					$query = "SELECT redirect_FRONT FROM #__community_acl_roles WHERE id = " . $redirect ['role_id'];
					$db->setQuery ( $query );
					$redirection = $db->loadResult ();
					if (! empty ( $redirection )) {
						break;
					}
					# Check 3 - Group redirect
					$query = "SELECT redirect_URL_FRONT FROM #__community_acl_groups WHERE id = " . $redirect ['group_id'];
					$db->setQuery ( $query );
					$redirection = $db->loadResult ();
					if (! empty ( $redirection )) {
						break;
					}

					$redirection = '';
					break;

				default :
					# Else do Nothing, let Joomla! handle rest through mod_login
					$redirection = 'index.php';
					break;
			}
		}
		// Set SESSION var so that user can be redirected
		if ($redirection) {
			$session = & JFactory::getSession ();
			$session->set ( 'redirect', $redirection, 'cacl' );
		}
		return true;
	}
}