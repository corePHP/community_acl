<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.event.plugin' );

class plgUserCommunity_ACL extends JPlugin
{
	function plgUserCommunity_ACL(& $subject, $config) {
		parent::__construct($subject, $config);
	}

	function onAfterStoreUser($user, $isnew, $success, $msg)
	{
		global $mainframe;

		$frontendPath  = JPATH_ROOT . DS . 'components' .  DS;
		$comprofiler_filepath = $frontendPath."com_comprofiler/plugin/user/index.html";

		if(!array_key_exists('membership_type_id',$user)){
			$user['membership_type_id'] = array();
		}

		if($user['membership_type_id'] && !file_exists($comprofiler_filepath)){
			$member_type = implode(",", $user['membership_type_id']);
			$db =& JFactory::getDBO();

			/*$query = "SELECT DISTINCT a.id as role_id, a.group_id, a.redirect_front, a.redirect_admin, b.function_id
			 FROM `#__community_acl_cb_roles` AS a
			LEFT JOIN `#__community_acl_users` AS b ON b.user_id = a.cb_member_type
			WHERE `cb_member_type` IN ( ".$member_type." ) ";*/
			$query = "
					SELECT role_id, group_id, function_id
					FROM `#__community_acl_users`
					WHERE `cb_member_type`
					IN ( ".$member_type." ) ";

			$db->setQuery($query);
			$user_info = $db->loadObjectList();

			//$user_info = array_unique($user_info);

			if(count($user_info) > 0 ){
				for($i=0; $i<count($user_info); $i++){
					$query = "INSERT INTO `#__community_acl_users` " .
						 "  SET `user_id` = '" . $user['id'] . "'" .
						 "	  , `group_id` = '". $user_info[$i]->group_id  . "'" .
						 "	  , `role_id` = '" . $user_info[$i]->role_id  . "'" .
						 "	  , `function_id` = '" . $user_info[$i]->function_id  . "'" .
						 "	  , `redirect_front` = ''" .
						 "	  , `redirect_admin` = ''"
						 		;
						 		$db->setQuery($query);
						 		$db->query();
				}
			}
		}
	}

	function onBeforeDeleteUser($user)
	{
		$db = JFactory::getDBO();
		$db->setQuery( "DELETE FROM `#__community_acl_users` WHERE user_id='{$user['id']}'" );
		$db->query();
	}
}