<?php
/**
* @version		$Id: view.html.php 9764 2007-12-30 07:48:11Z ircmaxell $
* @package		Joomla
* @subpackage	Users
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Users component
 *
 * @static
 * @package		Joomla
 * @subpackage	Users
 * @since 1.0
 */
class UsersViewUser extends JView
{
	function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );
		$edit		= JRequest::getVar('edit',true);
		JArrayHelper::toInteger($cid, array(0));

		$db 		=& JFactory::getDBO();
		if($edit)
			$user 		=& JUser::getInstance( $cid[0] );
		else
			$user 		=& JUser::getInstance();

		$myuser		=& JFactory::getUser();
		$acl		=& JFactory::getACL();

		// Check for post data in the event that we are returning
		// from a unsuccessful attempt to save data
		$post = JRequest::get('post');
		if ( $post ) {
			$user->bind($post);
		}

		if ( $user->get('id'))
		{
			$query = 'SELECT *'
			. ' FROM #__contact_details'
			. ' WHERE user_id = '.(int) $cid[0]
			;
			$db->setQuery( $query );
			$contact = $db->loadObjectList();
		}
		else
		{
			$contact 	= NULL;
			// Get the default group id for a new user
			$config		= &JComponentHelper::getParams( 'com_users' );
			$newGrp		= $config->get( 'new_usertype' );
			$user->set( 'gid', $acl->get_group_id( $newGrp, null, 'ARO' ) );
		}

		$userObjectID 	= $acl->get_object_id( 'users', $user->get('id'), 'ARO' );
		$userGroups 	= $acl->get_object_groups( $userObjectID, 'ARO' );
		$userGroupName 	= strtolower( $acl->get_group_name( $userGroups[0], 'ARO' ) );

		$myObjectID 	= $acl->get_object_id( 'users', $myuser->get('id'), 'ARO' );
		$myGroups 		= $acl->get_object_groups( $myObjectID, 'ARO' );
		$myGroupName 	= strtolower( $acl->get_group_name( $myGroups[0], 'ARO' ) );;

		// ensure user can't add/edit group higher than themselves
		/* NOTE : This check doesn't work commented out for the time being
		if ( is_array( $myGroups ) && count( $myGroups ) > 0 )
		{
			$excludeGroups = (array) $acl->get_group_children( $myGroups[0], 'ARO', 'RECURSE' );
		}
		else
		{
			$excludeGroups = array();
		}

		if ( in_array( $userGroups[0], $excludeGroups ) )
		{
			echo 'not auth';
			$mainframe->redirect( 'index.php?option=com_community_acl&mode=manage_users', JText::_('NOT_AUTH') );
		}
		*/

		/*
		if ( $userGroupName == 'super administrator' )
		{
			// super administrators can't change
	 		$lists['gid'] = '<input type="hidden" name="gid" value="'. $currentUser->gid .'" /><strong>'. JText::_( 'Super Administrator' ) .'</strong>';
		}
		else if ( $userGroupName == $myGroupName && $myGroupName == 'administrator' ) {
		*/

		if ( $userGroupName == $myGroupName && $myGroupName == 'administrator' )
		{
			// administrators can't change each other
			$lists['gid'] = '<input type="hidden" name="gid" value="'. $user->get('gid') .'" /><strong>'. JText::_( 'Administrator' ) .'</strong>';
		}
		else
		{
			$gtree = $acl->get_group_children_tree( null, 'USERS', false );

			// remove users 'above' me
			//$i = 0;
			//while ($i < count( $gtree )) {
			//	if ( in_array( $gtree[$i]->value, (array)$excludeGroups ) ) {
			//		array_splice( $gtree, $i, 1 );
			//	} else {
			//		$i++;
			//	}
			//}

			$lists['gid'] 	= JHTML::_('select.genericlist',   $gtree, 'gid', 'size="10"', 'value', 'text', $user->get('gid') );
			
			$query = 'SELECT a.*, b.name AS g_name, c.name AS r_name, d.name AS f_name'
			. ' FROM `#__community_acl_users` AS a'
			. ' LEFT JOIN `#__community_acl_groups` AS b ON a.group_id = b.id '
			. ' LEFT JOIN `#__community_acl_roles` AS c ON a.role_id = c.id '
			. ' LEFT JOIN `#__community_acl_functions` AS d ON a.function_id = d.id '
			. ' WHERE a.user_id = \''.$user->get('id').'\''
			. ' ORDER BY a.id' 
			;
			$db->setQuery( $query );
			
			$lists['cacl_user'] = $db->loadObjectList();
			
			$query = 'SELECT id AS value, name AS text'
			. ' FROM `#__community_acl_groups`'
			. ' ORDER BY name' 
			;
			$db->setQuery( $query );
			$groups = $db->loadObjectList();
			$javascript = "onchange=\"changeDynaList( 'cacl_role_list', grouproles, document.adminForm.cacl_group_list.options[document.adminForm.cacl_group_list.selectedIndex].value, 0, 0);\"";
			$lists['cacl_gid'] = JHTML::_('select.genericlist',   $groups, 'cacl_group_list', ' class="inputbox" size="1" '.$javascript, 'value', 'text', null );
			if (count($groups) < 1)
				$lists['cacl_gid'] = JText::_( 'There is no groups' );
			
			$query = 'SELECT id '
			. ' FROM `#__community_acl_groups`'
			. ' ORDER BY name' 
			;
			$db->setQuery( $query );
			$groups = $db->loadObjectList();

			$query = 'SELECT id AS value, name AS text, group_id'
			. ' FROM `#__community_acl_roles`'
			. ' ORDER BY group_id, name' 
			;
			$db->setQuery( $query );
			$roles = $db->loadObjectList();
			
			$tmp_arr = array();				
			if (is_array($roles) && count($roles)) {
				$tmp_arr = array();	
				foreach($groups as $group) {	
						
					$z = 0;	
					foreach($roles as $i=>$role){					
						if ($role->group_id != $group->id)
							continue;							
						$tmp_arr[] = array('group'=>$role->group_id, 'value'=>$role->value, 'text'=>$role->text);	
								
						$z++;
					}	
					if ($z == 0)		
						$tmp_arr[] = array('group'=>$group->id, 'value'=>0, 'text'=>JText::_( 'None' ));
				}	
			}
			
			$lists['cacl_rid_arr'] = $tmp_arr;
			$lists['cacl_rid'] = JHTML::_('select.genericlist',   $roles, 'cacl_role_list', ' class="inputbox" size="1" ', 'value', 'text', null );
			
			if (count($roles) < 1)
				$lists['cacl_rid'] = JText::_( 'There is no roles' );
				
			$query = 'SELECT id AS value, name AS text'
			. ' FROM `#__community_acl_functions`'
			. ' ORDER BY name' 
			;
			$db->setQuery( $query );
			$functions[] = JHTML::_('select.option', '0', JText::_('None'), 'value', 'text');
			$functions = @array_merge($functions, $db->loadObjectList());
			//$functions = $db->loadObjectList();
			$lists['cacl_fid'] = JHTML::_('select.genericlist',   $functions, 'cacl_func_list', ' class="inputbox" size="1" ', 'value', 'text', null );	
			if (count($functions) < 1)
				$lists['cacl_fid'] = JText::_( 'There is no functions' );
		}
		
		$query = 'SELECT `value` FROM `#__community_acl_user_params` '
				. ' WHERE `user_id` = \''.$user->get('id').'\' AND `name`=\'publisher_notification\''
				;
		$db->setQuery( $query );
		$publisher_notification = (int)$db->loadResult();
		
		$lists['publisher_notification'] 	= JHTML::_('select.booleanlist',  'publisher_notification', 'class="inputbox" size="1"', $publisher_notification );
		
		// build the html select list
		$lists['block'] 	= JHTML::_('select.booleanlist',  'block', 'class="inputbox" size="1"', $user->get('block') );

		// build the html select list
		$lists['sendEmail'] = JHTML::_('select.booleanlist',  'sendEmail', 'class="inputbox" size="1"', $user->get('sendEmail') );

		$this->assignRef('lists',	$lists);
		$this->assignRef('user',	$user);
		$this->assignRef('contact',	$contact);

		parent::display($tpl);
	}
}