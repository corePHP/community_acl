<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once( JApplicationHelper::getPath( 'toolbar_html' ) );

$mode = JRequest::getCmd('mode');

if ($mode == 'manage_users' && $task != 'help' && $task != 'assign_users' && $task != 'unassign_users')  
	$task = $mode;
	
switch ($task)
{	
	case 'list_groups':
		TOOLBAR_cacl::_LIST_GROUPS();
		break;
	case 'group_add':
		TOOLBAR_cacl::_EDIT_GROUP(false);
		break;
	case 'group_edit':
		TOOLBAR_cacl::_EDIT_GROUP(true);
		break;
		
	case 'list_roles':
		TOOLBAR_cacl::_LIST_ROLES();
		break;
	case 'role_add':
		TOOLBAR_cacl::_EDIT_ROLE(false);
		break;
	case 'role_edit':
		TOOLBAR_cacl::_EDIT_ROLE(true);
		break;
		
	case 'list_functions':
		TOOLBAR_cacl::_LIST_FUNCTIONS();
		break;
	case 'function_add':
		TOOLBAR_cacl::_EDIT_FUNCTION(false);
		break;
	case 'function_edit':
		TOOLBAR_cacl::_EDIT_FUNCTION(true);
		break;
		
	case 'show_access':
		TOOLBAR_cacl::_SHOW_ACCESS();
		break;
	case 'delete_users_access':
		TOOLBAR_cacl::_SHOW_USER_ACCESSR();
		break;	
	case 'add_users_access':
		TOOLBAR_cacl::_SHOW_USER_ACCESSA();
		break;
		
	case 'set_functions':
		TOOLBAR_cacl::_SET_FUNCTIONS();
		break;
		
	case 'manage_users': break;
	
	case 'assign_users': 
		TOOLBAR_cacl::_ASSIGN_USERS();
		break;
		
	case 'unassign_users': 
		TOOLBAR_cacl::_UNASSIGN_USERS();
		break;
	
	case 'list_sites':
		TOOLBAR_cacl::_LIST_SITES();
		break;
	case 'site_edit': 	
		TOOLBAR_cacl::_EDIT_SITE(true);
		break;
	case 'site_add': 	
		TOOLBAR_cacl::_EDIT_SITE(false);
		break;	
	
	case 'config': 	
		TOOLBAR_cacl::_CONFIG();
		break;		
	
	case 'synchronize': 	
		TOOLBAR_cacl::_SYNCHRONIZE();
		break;	
		
	case 'edit_language':
	case 'language_files':
	case 'language':
		break;
	
	case 'about': 
		JToolBarHelper::title( 'About', 'systeminfo.png' );
		break;
	case 'help': 
		JToolBarHelper::title( 'Help', 'help_header.png' );
		break;
	case 'changelog': 
		JToolBarHelper::title( 'Version History', 'systeminfo.png' );
		break;
	case 'disclaimer': 
		JToolBarHelper::title( 'License', 'systeminfo.png' );
		break;	
	case 'install':
		JToolBarHelper::title( 'Installation', 'systeminfo.png' );
		break;
	case 'hacks' :
		JToolBarHelper::title( 'Patch' , 'systeminfo.png');
		break;
	default:
		JToolBarHelper::title( 'About', 'systeminfo.png' );
		break;
}