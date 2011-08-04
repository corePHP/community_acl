<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

if (file_exists(JPATH_SITE.'/administrator/components/com_community_acl/community_acl.class.php') ) {

	$_PLUGINS->registerFunction( 'onAfterNewUser', 'cacl_plugin_new_user' );
	$_PLUGINS->registerFunction( 'onAfterUserRegistration', 'cacl_plugin_new_user' );
	
	$_PLUGINS->registerFunction( 'onAfterDeleteUser', 'cacl_plugin_user_delete' );
}

function cacl_plugin_new_user(&$user, &$cbUser) {
	
	require_once (JPATH_SITE.'/administrator/components/com_community_acl/community_acl.class.php'); 
	$db	=& JFactory::getDBO();
	
	#Get the cb_caclmembertype id from the Community ACL Membership type Table
	$query = "SELECT id FROM `#__community_acl_membership_types` WHERE `name` = '".$cbUser->_comprofilerUser->cb_caclmembertype."'";
	$db->setQuery( $query );
	$member_id = $db->loadResult();
	
	$cb_infos = NULL;
	
	$query = 'SELECT a.user_id AS id, a.id, a.group_id, a.role_id, a.function_id, a.redirect_FRONT, a.redirect_ADMIN, a.cb_member_type AS member_id, e.name AS g_name, f.name AS r_name, g.name AS f_name, h.name AS member_type, h.id AS member_id
	FROM `#__community_acl_users` AS a
	LEFT JOIN `#__community_acl_cb_groups` AS b ON a.group_id = b.id
	LEFT JOIN `#__community_acl_cb_roles` AS c ON a.role_id = c.id
	LEFT JOIN `#__community_acl_cb_functions` AS d ON a.role_id = d.id
	LEFT JOIN `#__community_acl_groups` AS e ON a.group_id = e.id
	LEFT JOIN `#__community_acl_roles` AS f ON a.role_id = f.id
	LEFT JOIN `#__community_acl_functions` AS g ON a.function_id = g.id
	LEFT JOIN `#__community_acl_membership_types` AS h ON a.cb_member_type = h.id
	WHERE a.user_id >0
	AND a.user_id <62
	AND a.group_id = e.id
	AND a.role_id = f.id
	AND a.cb_member_type = '.$member_id  
	.' ORDER BY h.id'	;	$db->setQuery( $query );
	$cb_infos = $db->loadObjectList();
	
	//lets copy the records over
	foreach($cb_infos as $cb_info){
		$query = "INSERT INTO `#__community_acl_users` 
					(`user_id`, `group_id`, `role_id`, `function_id`, `redirect_FRONT`, `redirect_ADMIN`) 
						VALUES ('" . $cbUser->_cmsUser->id . "', '{$cb_info->group_id}', '{$cb_info->role_id}', 
									'{$cb_info->function_id}', '{$cb_info->redirect_FRONT}', 
										'{$cb_info->redirect_ADMIN}')";
		$db->setQuery( $query );
		$db->query();	
	}
	
	return;
}

function cacl_plugin_user_delete(&$user) {
	require_once (JPATH_SITE.'/administrator/components/com_community_acl/community_acl.class.php'); 
	$db	=& JFactory::getDBO();
	
	// Lets delete the user from Community ACL
	$query = "DELETE FROM `#__community_acl_users` WHERE id = " . $user->id;
	$db->setQuery( $query );
	$db->query();	
	
	// Lets delete the user from Joomla!
	$query = "DELETE FROM `#__comprofiler` WHERE user_id = " . $user->id;
	$db->setQuery( $query );
	$db->query();
	
	return;
}

?>