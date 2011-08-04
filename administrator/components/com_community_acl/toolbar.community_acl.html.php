<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TOOLBAR_cacl
{
	function _LIST_GROUPS() {
		JToolBarHelper::title( JText::_( 'List of Groups' ), 'sections.png' );
		JToolBarHelper::custom( 'show_access', 'config.png', 'config.png', $alt = 'Set access', true);
		JToolBarHelper::publishList('group_publish');
		JToolBarHelper::unpublishList('group_unpublish');
		JToolBarHelper::deleteList( JText::_( 'Are you sure?' ), 'group_delete');
		JToolBarHelper::editListX('group_edit');
		JToolBarHelper::addNewX('group_add');
		JToolBarHelper::custom( 'help', 'help.png', 'help.png', $alt = 'Help', false);
	}
	
	function _EDIT_GROUP($edit) {
		$text = JText::_( 'New Group' );
		if ($edit) {
			$db =& JFactory::getDBO();
			$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
			JArrayHelper::toInteger($cid, array(0));
			$query = "SELECT `name` FROM `#__community_acl_groups` WHERE `id` = '".$cid[0]."'";
			$db->setQuery( $query );
			$title = $db->loadResult();
			$text =  JText::_( 'Edit Group' ) .' ['.$title.']';
		}
		
		JToolBarHelper::title( $text, 'sections.png' );
		JToolBarHelper::save('group_save');
		JToolBarHelper::apply('group_apply');
		if ( $edit ) {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		} else {
			JToolBarHelper::cancel();
		} 
		JToolBarHelper::custom( 'help', 'help.png', 'help.png', $alt = 'Help', false);
	}
	
	function _LIST_ROLES() {
		JToolBarHelper::title( JText::_( 'List of Roles' ), 'categories.png' );		
		JToolBarHelper::custom( 'show_access', 'config.png', 'config.png', $alt = 'Set access', true);
		JToolBarHelper::publishList('role_publish');
		JToolBarHelper::unpublishList('role_unpublish');
		JToolBarHelper::deleteList( JText::_( 'Are you sure?' ), 'role_delete');
		JToolBarHelper::editListX('role_edit');
		JToolBarHelper::addNewX('role_add');
		JToolBarHelper::custom( 'help', 'help.png', 'help.png', $alt = 'Help', false);
	}
	
	function _EDIT_ROLE($edit) {		
		$text = JText::_( 'New Role' );
		if ($edit) {
			$db =& JFactory::getDBO();
			$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
			JArrayHelper::toInteger($cid, array(0));
			$query = "SELECT `name` FROM `#__community_acl_roles` WHERE `id` = '".$cid[0]."'";
			$db->setQuery( $query );
			$title = $db->loadResult();
			$text =  JText::_( 'Edit Role' ) .' ['.$title.']';
		}
		JToolBarHelper::title( $text, 'categories.png' );
		JToolBarHelper::save('role_save');
		JToolBarHelper::apply('role_apply');
		if ( $edit ) {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		} else {
			JToolBarHelper::cancel();
		} 
		JToolBarHelper::custom( 'help', 'help.png', 'help.png', $alt = 'Help', false);
	}
	
	function _LIST_FUNCTIONS() {
		JToolBarHelper::title( JText::_( 'List of Functions' ), 'addedit.png' );		
		JToolBarHelper::custom( 'set_functions', 'config.png', 'config.png', $alt = 'Set actions', true);
		JToolBarHelper::publishList('function_publish');
		JToolBarHelper::unpublishList('function_unpublish');
		JToolBarHelper::deleteList( JText::_( 'Are you sure?' ), 'function_delete');
		JToolBarHelper::editListX('function_edit');
		JToolBarHelper::addNewX('function_add');
		JToolBarHelper::custom( 'help', 'help.png', 'help.png', $alt = 'Help', false);
	}
	
	function _EDIT_FUNCTION($edit) {		
		
		$text = JText::_( 'New Function' );
		if ($edit) {
			$db =& JFactory::getDBO();
			$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
			JArrayHelper::toInteger($cid, array(0));
			$query = "SELECT `name` FROM `#__community_acl_functions` WHERE `id` = '".$cid[0]."'";
			$db->setQuery( $query );
			$title = $db->loadResult();
			$text =  JText::_( 'Edit Function' ) .' ['.$title.']';
		}
		JToolBarHelper::title( $text, 'addedit.png' );
		JToolBarHelper::save('function_save');
		JToolBarHelper::apply('function_apply');
		if ( $edit ) {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		} else {
			JToolBarHelper::cancel();
		} 
		JToolBarHelper::custom( 'help', 'help.png', 'help.png', $alt = 'Help', false);
	}
	
	function _SHOW_ACCESS() {	
		$mode = JRequest::getCmd('mode');
		
		$db =& JFactory::getDBO();
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		$query = "SELECT `name` FROM `#__community_acl_". ( $mode == 'role_id' ? 'roles': 'groups' )."` WHERE `id` = '".$cid[0]."'";
		$db->setQuery( $query );
		$title = $db->loadResult();
		$text =  ( $mode == 'role_id' ? JText::_( 'Role Access' ) : JText::_( 'Group Access' ) ).' ['.$title.']';
		
		JToolBarHelper::title( $text, 'config.png' );
		JToolBarHelper::save('save_access');
		JToolBarHelper::apply('apply_access');
		JToolBarHelper::cancel();
		JToolBarHelper::custom( 'help', 'help.png', 'help.png', $alt = 'Help', false);
	}
	
	function _SET_FUNCTIONS() {	
		$db =& JFactory::getDBO();
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		$query = "SELECT `name` FROM `#__community_acl_functions` WHERE `id` = '".$cid[0]."'";
		$db->setQuery( $query );
		$title = $db->loadResult();
		$text =  JText::_( 'Set actions' ) .' ['.$title.']';
	
		JToolBarHelper::title( $text, 'config.png' );
		JToolBarHelper::save('save_functions');
		JToolBarHelper::apply('apply_functions');
		JToolBarHelper::cancel();
		JToolBarHelper::custom( 'help', 'help.png', 'help.png', $alt = 'Help', false);
	}
	
	function _LIST_SITES() {
		JToolBarHelper::title( JText::_( 'List of Sites' ), 'browser.png' );		
		JToolBarHelper::publishList('site_publish');
		JToolBarHelper::unpublishList('site_unpublish');
		JToolBarHelper::deleteList( JText::_( 'Are you sure?' ), 'site_delete');
		JToolBarHelper::editListX('site_edit');
		JToolBarHelper::addNewX('site_add');
		JToolBarHelper::custom( 'help', 'help.png', 'help.png', $alt = 'Help', false);
	}
	
	function _EDIT_SITE($edit) {		
		$text = ( $edit ? JText::_( 'Edit Site' ) : JText::_( 'New Site' ) );
		JToolBarHelper::title( $text, 'browser.png' );
		JToolBarHelper::save('save_sites');
		JToolBarHelper::apply('apply_sites');
		if ( $edit ) {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		} else {
			JToolBarHelper::cancel();
		} 
		JToolBarHelper::custom( 'help', 'help.png', 'help.png', $alt = 'Help', false);
	}
	
	function _CONFIG() {				
		JToolBarHelper::title( JText::_( 'Configuration' ), 'config.png' );
		JToolBarHelper::save('save_config');
		JToolBarHelper::apply('apply_config');
		JToolBarHelper::cancel( 'cancel', 'Close' );
		JToolBarHelper::custom( 'help', 'help.png', 'help.png', $alt = 'Help', false);
	}	
	
	function _ASSIGN_USERS() {				
		JToolBarHelper::title( JText::_( 'Assign to Group/Role' ), 'config.png' );
		JToolBarHelper::save('save_assign', 'Assign');
		JToolBarHelper::cancel( 'cancel', 'Close' );
		JToolBarHelper::custom( 'help', 'help.png', 'help.png', $alt = 'Help', false);
	}
	
	function _UNASSIGN_USERS() {				
		JToolBarHelper::title( JText::_( 'Unassign from Group/Role' ), 'config.png' );
		JToolBarHelper::deleteList( JText::_( 'Are you sure?' ), 'unassign_save', 'Unassign');
		JToolBarHelper::cancel( 'cancel', 'Close' );
		JToolBarHelper::custom( 'help', 'help.png', 'help.png', $alt = 'Help', false);
	}
	
	function _SHOW_USER_ACCESSR() {	
		$mode = JRequest::getCmd('mode');
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0)); 
		
		$db =& JFactory::getDBO();
		if ($mode == 'role_id') {
			$text = JText::_( 'Role Members' );	
			$query = "SELECT `name` FROM `#__community_acl_roles` WHERE id = ".$cid[0];
		}
		else {
			$text = JText::_( 'Group Members' );
			$query = "SELECT `name` FROM `#__community_acl_groups` WHERE id = ".$cid[0];
		}
		$db->setQuery($query);
		$text = $text.' <small>['.$db->loadResult().']</small>';
	
		JToolBarHelper::title( $text, 'config.png' );
		JToolBarHelper::deleteList( JText::_( 'Are you sure?' ), 'delete_users_access_save', 'Remove');
		JToolBarHelper::custom( 'help', 'help.png', 'help.png', $alt = 'Help', false);
		JToolBarHelper::back();
	}
	
	function _SHOW_USER_ACCESSA() {	
		$mode = JRequest::getCmd('mode');
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0)); 
		
		$db =& JFactory::getDBO();
		if ($mode == 'role_id') {
			$text = JText::_( 'Add to Role' );	
			$query = "SELECT `name` FROM `#__community_acl_roles` WHERE id = ".$cid[0];
		}
		else {
			$text = JText::_( 'Add to Group' );
			$query = "SELECT `name` FROM `#__community_acl_groups` WHERE id = ".$cid[0];
		}
		$db->setQuery($query);
		$text = $text.' <small>['.$db->loadResult().']</small>';
	
		JToolBarHelper::title( $text, 'config.png' );
		JToolBarHelper::custom( 'add_users_access_save', 'new.png', 'new.png', $alt = 'Add', true);
		JToolBarHelper::custom( 'help', 'help.png', 'help.png', $alt = 'Help', false);
		JToolBarHelper::back();
	}
	
	function _SYNCHRONIZE() {
		JToolBarHelper::title( JText::_( 'Synchronize' ), 'cpanel.png' );
		JToolBarHelper::custom( 'do_synchronize', 'refresh.png', 'refresh.png', $alt = 'Synchronize', false);
	}
	
}