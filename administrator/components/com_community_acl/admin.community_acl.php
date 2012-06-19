<?php
// no direct accessdefined ( '_JEXEC' ) or die ( 'Restricted access' );
if (! defined ( '_COMMUNITY_ACL_ADMIN_HOME' )) {
	define ( '_COMMUNITY_ACL_ADMIN_HOME', dirname ( __FILE__ ) );
}
define ( '_COMMUNITY_ACL_COMP_NAME', 'Community ACL ver 1.3.19' );
require_once (JApplicationHelper::getPath ( 'admin_html' ));
require_once (JApplicationHelper::getPath ( 'class' ));
require_once (JApplicationHelper::getPath ( 'admin_functions' ));
require_once (_COMMUNITY_ACL_ADMIN_HOME . DS . 'community_acl' . '.language.php');
$user = & JFactory::getUser ();
$cid = JRequest::getVar ( 'cid', array (0 ), '', 'array' );
$pid = JRequest::getVar ( 'pid', null );
JArrayHelper::toInteger ( $cid, array (0 ) );
$step = JRequest::getCmd ( 'step' );
$install_cb = JRequest::getCmd ( 'install_cb' );
$task = JRequest::getCmd ( 'task' );
$mode = JRequest::getCmd ( 'mode' );
$id = ( int ) JRequest::getCmd ( 'id' );
$install = JRequest::getVar ( 'install' );
if ($step || $install == 1)
	$task = 'install';
if ($mode == 'manage_users' && $task != 'help' && $task != 'assign_users' && $task != 'unassign_users')
	$task = $mode;
switch ($task) {
	##-- GROUPS -------------	case 'list_groups' :
		showGroups ( $option );
		break;
	case 'group_add' :
		editGroup ( false );
		break;
	case 'group_edit' :
		editGroup ( true );
		break;
	case 'group_save' :
	case 'group_apply' :
		saveGroup ();
		break;
	case 'group_publish' :
		publishItem ( '#__community_acl_groups', $cid, 1 );
		break;
	case 'group_unpublish' :
		publishItem ( '#__community_acl_groups', $cid, 0 );
		break;
	case 'group_delete' :
		deleteItem ( '#__community_acl_groups', $cid );
		break;
	case 'group_sync' :
		changeItem ( '#__community_acl_groups', $cid, 1 );
		break;
	case 'group_unsync' :
		changeItem ( '#__community_acl_groups', $cid, 0 );
		break;
	##-- ROLES --------------	case 'list_roles' :
		showRoles ( $option );
		break;
	case 'role_add' :
		editRole ( false );
		break;
	case 'role_edit' :
		editRole ( true );
		break;
	case 'role_save' :
	case 'role_apply' :
		saveRole ();
		break;
	case 'role_orderup' :
		orderItem ( '#__community_acl_roles', 'group_id', $cid [0], - 1 );
		break;
	case 'role_orderdown' :
		orderItem ( '#__community_acl_roles', 'group_id', $cid [0], 1 );
		break;
	case 'role_saveorder' :
		saveOrder ( $cid, '#__community_acl_roles', 'group_id' );
		break;
	case 'role_publish' :
		publishItem ( '#__community_acl_roles', $cid, 1 );
		break;
	case 'role_unpublish' :
		publishItem ( '#__community_acl_roles', $cid, 0 );
		break;
	case 'role_delete' :
		deleteItem ( '#__community_acl_roles', $cid );
		break;
	case 'role_sync' :
		changeItem ( '#__community_acl_roles', $cid, 1 );
		break;
	case 'role_unsync' :
		changeItem ( '#__community_acl_roles', $cid, 0 );
		break;
	##-- FUNCTIONS --------------	case 'list_functions' :
		showFunctions ( $option );
		break;
	case 'function_add' :
		editFunction ( false );
		break;
	case 'function_edit' :
		editFunction ( true );
		break;
	case 'function_save' :
	case 'function_apply' :
		saveFunction ();
		break;
	case 'function_orderup' :
		orderItem ( '#__community_acl_functions', 'group_id', $cid [0], - 1 );
		break;
	case 'function_orderdown' :
		orderItem ( '#__community_acl_functions', 'group_id', $cid [0], 1 );
		break;
	case 'function_saveorder' :
		saveOrder ( $cid, '#__community_acl_functions', 'group_id' );
		break;
	case 'function_publish' :
		publishItem ( '#__community_acl_functions', $cid, 1 );
		break;
	case 'function_unpublish' :
		publishItem ( '#__community_acl_functions', $cid, 0 );
		break;
	case 'function_delete' :
		deleteItem ( '#__community_acl_functions', $cid );
		break;
	case 'function_sync' :
		changeItem ( '#__community_acl_functions', $cid, 1 );
		break;
	case 'function_unsync' :
		changeItem ( '#__community_acl_functions', $cid, 0 );
		break;
	case 'set_functions' :
		setFunctions ( $cid [0] );
		break;
	case 'apply_functions' :
	case 'save_functions' :
		saveFunctions ();
		break;
	##-- ACCESS -----------------	case 'show_access' :
		if ($mode == 'role_id')
			showAccess ( 0, $cid [0] );
		else
			showAccess ( $cid [0], 0 );
		break;
	case 'apply_access' :
	case 'save_access' :
		saveAccess ();
		break;
	case 'delete_users_access' :
		if ($mode == 'role_id')
			showUserAccessR ( 0, isset($pid) ? $pid : $cid[0] );
		else
			showUserAccessR ( isset($pid) ? $pid : $cid[0], 0 );
		break;
	case 'delete_users_access_save' :
		saveUserAccessR ( $cid );
		break;
	case 'add_users_access' :
		if ($mode == 'role_id')
			showUserAccessA ( 0, $cid [0] );
		else
			showUserAccessA ( $cid [0], 0 );
		break;
	case 'add_users_access_save' :
		saveUserAccessA ( $cid );
		break;
	##-- USERS ------------------	case 'manage_users' :
		left_menu_header ();
		require_once (_COMMUNITY_ACL_ADMIN_HOME . '/users.php');
		left_menu_footer ();
		break;
	case 'assign_users' :
		showAssignUsers ( $option, $cid );
		break;
	case 'unassign_users' :
		showUnassignUsers ( $option, $cid );
		break;
	case 'save_assign' :
		saveAssignUsers ( $option, $cid );
		break;
	case 'unassign_save' :
		saveUnassignUsers ( $option, $cid );
		break;
	#-- SITES ------------------	case 'list_sites' :
		showSites ( $option );
		break;
	case 'site_edit' :
		editSites ( true );
		break;
	case 'site_add' :
		editSites ( false );
		break;
	case 'site_publish' :
		publishItem ( '#__community_acl_sites', $cid, 1 );
		break;
	case 'site_unpublish' :
		publishItem ( '#__community_acl_sites', $cid, 0 );
		break;
	case 'site_delete' :
		deleteItem ( '#__community_acl_sites', $cid );
		break;
	case 'apply_sites' :
	case 'save_sites' :
		saveSites ();
		break;
	case 'check_db' :
		cacl_check_db ();
		break;
	case 'set_main' :
		setMainSite ( $cid [0] );
		break;
	##-- CONFIG ----------------	case 'config' :
		showConfig ();
		break;
	case 'apply_config' :
	case 'save_config' :
		saveConfig ();
		break;
	case 'synchronize' :
		cacl_html::synchronize ();
		break;
	case 'do_synchronize' :
		doSynchronization ();
		break;
	##-- LANGUAGE --------------------	case 'language' :
	case 'language_files' :
	case 'edit_language' :
	case 'save_language' :
	case 'apply_language' :
	case 'cancel_language' :
	case 'checkin_language' :
	case 'checkout_language' :
	case 'language_publish' :
	case 'remove_language' :
	case 'language_unpublish' :
		left_menu_header ();
		switch ($task) {
			case 'language' :
				Language_manager::list_languages ();
				break;
			case 'language_files' :
				Language_manager::list_files ();
				break;
			case 'edit_language' :
				Language_manager::edit_language ();
				break;
			case 'save_language' :
				Language_manager::edit_language ();
				break;
			case 'apply_language' :
				Language_manager::edit_language ();
				break;
			case 'cancel_language' :
				Language_manager::multitask ( $task = 'cancel' );
				break;
			case 'checkin_language' :
				Language_manager::multitask ( $task = 'checkin' );
				break;
			case 'checkout_language' :
				Language_manager::multitask ( $task = 'checkout' );
				break;
			case 'language_publish' :
				Language_manager::multitask ( $task = 'publish' );
				break;
			case 'remove_language' :
				Language_manager::multitask ( $task = 'remove' );
				break;
			case 'language_unpublish' :
				Language_manager::multitask ( $task = 'unpublish' );
				break;
		}
		left_menu_footer ();
		break;
	##-- COMMON ----------------	case 'cancel' :
		cancel ();
		break;
	case 'fixit' :
		fixIt ();
		break;
	case 'about' :
		cacl_html::about ( _COMMUNITY_ACL_COMP_NAME );
		break;
	case 'help' :
		cacl_html::help ();
		break;
	case 'disclaimer' :
		cacl_html::disclaimer ();
		break;
	case 'changelog' :
		cacl_html::changelog ();
		break;
	#- Kobby Created the hacks	case 'hacks' :
		cacl_html::hacks ();
		break;
	##-- INSTALL -------------	case 'install' :
		require_once (_COMMUNITY_ACL_ADMIN_HOME . '/installer.helper.php');
		require_once (_COMMUNITY_ACL_ADMIN_HOME . '/install.community_acl.php');
		/* * /
		echo '<pre>';
		print_r($_REQUEST);
		echo '</pre>';
		/* */
		$frontendPath = JPATH_ROOT . DS . 'components' . DS;
		$comprofiler_filepath = $frontendPath . "com_comprofiler/plugin/user/index.html";
		switch ($step) {
			case 1 :
				print_r ( "<h1>Step 1: Requirements</h1>" );
				print_r ( caclInstaller::checkRequirements () );
				print_r ( caclInstaller::updateCACL_tables () );
				break;
			case 2 :
				print_r ( "<h1>Step 2: Install Joomla Plugin</h1>" );
				print_r ( caclInstaller::installJoomla_Plugin () );
				break;
			case 3 :
				print_r ( "<h1>Step 3: Install Patch files</h1>" );
				print_r ( caclInstaller::installPatch_files () );
				break;
			case 4 :
				if (file_exists ( $comprofiler_filepath )) {
					print_r ( "<h1>Step 4: Install Community Builder Plugin</h1>" );
					print_r ( caclInstaller::installCB_Plugin () );
					break;
				}
			case 5 :
				$mainframe->redirect ( 'index.php?option=com_community_acl&task=about', JText::_ ( 'Community ACL installed successfully.' ) );
				break;
			default :
				//To do				break;
		}
		break;
	default :
		cacl_html::about ( _COMMUNITY_ACL_COMP_NAME );
		break;
}
function fixIt() {
	global $mainframe;
	$mode = JRequest::getCmd ( 'mode' );
	$code = ( int ) JRequest::getCmd ( 'code' );
	$db = & JFactory::getDBO ();
	if ($mode == 'cb') {
		$code = check_cb_plugin ();
		if ($code == 0) { //not enabled			$query = "UPDATE `#__comprofiler_plugin` SET `published` = 1 WHERE `element` = 'cacl_usersync'";
			$db->setQuery ( $query );
			if ($db->query ()) {
				$mainframe->redirect ( 'index.php?option=com_community_acl&task=about', JText::_ ( 'Community ACL CB plugin enabled successfully.' ) );
				die ();
			} else {
				JError::raiseError ( 500, $row->getError () );
			}
		} elseif ($code == - 1) { //not installed			$path_src = JPATH_SITE . '/administrator/components/com_community_acl/plug_cbcacl_usersync';
			$path_dst = JPATH_SITE . '/components/com_comprofiler/plugin/user/plug_caclplugin';
			$msg = '';
			$result = @mkdir ( JPATH_SITE . "/components/com_comprofiler/plugin/user/plug_caclplugin" );
			if ($result)
				$result = @chmod ( JPATH_SITE . "/components/com_comprofiler/plugin/user/plug_caclplugin", 0777 );
			else
				$msg .= 'Error: Unable create dir `.../components/com_comprofiler/plugin/user/plug_caclplugin`<br/>';
			if ($result)
				$result = @copy ( $path_src . "/cacl_usersync.php", $path_dst . "/cacl_usersync.php" );
			else
				$msg .= 'Error: Unable chmod dir `.../components/com_comprofiler/plugin/user/plug_caclplugin`<br/>';
			if ($result)
				$result = @copy ( $path_src . "/cacl_usersync.xml", $path_dst . "/cacl_usersync.xml" );
			else
				$msg .= 'Error: Unable copy file `.../administrator/components/com_community_acl/plug_caclplugin/cacl_usersync.php`<br/>';
			if ($result)
				$result = @chmod ( JPATH_SITE . "/components/com_comprofiler/plugin/user/plug_caclplugin", 0775 );
			else
				$msg .= 'Error: Unable copy file `.../components/com_comprofiler/plugin/user/plug_caclplugin/cacl_usersync.xml`<br/>';
			if (! $result)
				$msg .= 'Error: Unable chmod dir `.../components/com_comprofiler/plugin/user/plug_caclplugin`><br/>';
			if ($result) {
				$db->setQuery ( "DELETE FROM `#__comprofiler_plugin` WHERE `element` = 'cacl_usersync';" );
				$db->query ();
				$db->setQuery ( "INSERT INTO `#__comprofiler_plugin` ( `id` , `name` , `element` , `type` , `folder` , `backend_menu` , `access` , `ordering` , `published` , `iscore` , `client_id` , `checked_out` , `checked_out_time` , `params` ) VALUES ('', 'cACL plugin', 'cacl_usersync', 'user', 'plug_caclplugin', '', '0', '0', '1', '0', '0', '0', '0000-00-00 00:00:00', '');" );
				$db->query ();
				if ($db->getErrorNum ()) {
					$msg .= 'Error: ' . $db->stderr () . '<br/>';
				}
			}
			if ($msg == '') {
				$mainframe->redirect ( 'index.php?option=com_community_acl&task=about', JText::_ ( 'Community ACL CB plugin installed successfully.' ) );
				die ();
			} else {
				$mainframe->redirect ( 'index.php?option=com_community_acl&task=about', $msg, 'error' );
			}
		}
	} elseif ($mode == 'joomla') {
		$code = check_plugin ();
		if ($code == 0) { //not enabled			$query = "UPDATE `#__plugins` SET `published` = 1 WHERE `element` = 'community_acl'";
			$db->setQuery ( $query );
			if ($db->query ()) {
				$mainframe->redirect ( 'index.php?option=com_community_acl&task=about', JText::_ ( 'Community ACL Joomla plugin enabled successfully.' ) );
				die ();
			} else {
				JError::raiseError ( 500, $row->getError () );
			}
		} elseif ($code == - 1) { //not installed			$msg = '';
			$result = @chmod ( JPATH_SITE . "/administrator/components/com_community_acl/joomla_plugin/community_acl.php", 0666 );
			/* * /
			if ($result)
				$result = @chmod (JPATH_SITE. "/administrator/components/com_community_acl/joomla_plugin/community_acl.xml", 0666);
			else
				$msg .= 'Error: Unable chmod file `.../administrator/components/com_community_acl/joomla_plugin/community_acl.php`<br/>';

			if ($result)
				$result = @copy( JPATH_SITE. "/administrator/components/com_community_acl/joomla_plugin/community_acl.php", JPATH_SITE."/plugins/system/community_acl.php");
			else
				$msg .= 'Error: Unable chmod file `.../administrator/components/com_community_acl/joomla_plugin/community_acl.xml`<br/>';

			if ($result)
				$result = @copy( JPATH_SITE. "/administrator/components/com_community_acl/joomla_plugin/community_acl.xml", JPATH_SITE."/plugins/system/community_acl.xml");
			else
				$msg .= 'Error: Unable copy file `.../administrator/components/com_community_acl/joomla_plugin/community_acl.php`<br/>';

			if ($result) {
				$result = @copy( JPATH_SITE. "/administrator/components/com_community_acl/joomla_plugin/en-GB.plg_system_community_acl.ini", JPATH_SITE."/administrator/language/en-GB/en-GB.plg_system_community_acl.ini");
				$result = @copy( JPATH_SITE. "/administrator/components/com_community_acl/joomla_plugin/en-GB.plg_system_community_acl.ini", JPATH_SITE."/language/en-GB/en-GB.plg_system_community_acl.ini");
			} else
				$msg .= 'Error: Unable copy file `.../administrator/components/com_community_acl/joomla_plugin/community_acl.xml`<br/>';

			if (!$result)
				$msg .= 'Error: Unable copy file `.../administrator/components/com_community_acl/joomla_plugin/en-GB.plg_system_community_acl.ini`<br/>';

			if ($result) {
				$db->setQuery("DELETE FROM `#__plugins` WHERE `element` = 'community_acl'");
				$db->query();

				$db->setQuery( "INSERT INTO `#__plugins` (`name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`) VALUES('System - Community ACL', 'community_acl', 'system', 0, 9, 1, 0, 0, 0, '0000-00-00 00:00:00', '')");
				$db->query();

				if ($db->getErrorNum()) {
					$msg .= 'Error: '. $db->stderr() .'<br/>';
				}
			}

			if ($msg == '') {
				$mainframe->redirect('index.php?option=com_community_acl&task=about', JText::_('Community ACL Joomla plugin installed successfully.'));
				die;
			} else {
				$mainframe->redirect('index.php?option=com_community_acl&task=about', $msg, 'error');
			}
			/* */
		}
	} elseif ($mode == 'hack') {
		switch ($code) {
			case 1 :
				$dst_file = JPATH_SITE . "/administrator/modules/mod_menu/helper.php";
				$src_file = JPATH_SITE . "/administrator/components/com_community_acl/patch/mod_menu_helper.php";
				$bk_file = JPATH_SITE . "/administrator/components/com_community_acl/backup/mod_menu_helper.php";
				$success_msg = 'File `' . $dst_file . '` successfully replaced by patched version.';
				break;
			case 2 :
				$dst_file = JPATH_SITE . "/modules/mod_mainmenu/helper.php";
				$src_file = JPATH_SITE . "/administrator/components/com_community_acl/patch/mod_mainmenu_helper.php";
				$bk_file = JPATH_SITE . "/administrator/components/com_community_acl/backup/mod_mainmenu_helper.php";
				$success_msg = 'File `' . $dst_file . '` successfully replaced by patched version.';
				break;
			case 3 :
				$dst_file = JPATH_SITE . "/modules/mod_mainmenu/legacy.php";
				$src_file = JPATH_SITE . "/administrator/components/com_community_acl/patch/legacy.php";
				$bk_file = JPATH_SITE . "/administrator/components/com_community_acl/backup/legacy.php";
				$success_msg = 'File `' . $dst_file . '` successfully replaced by patched version.';
				break;
			case 4 :
				$dst_file = JPATH_SITE . "/libraries/joomla/application/module/helper.php";
				$src_file = JPATH_SITE . "/administrator/components/com_community_acl/patch/module_helper.php";
				$bk_file = JPATH_SITE . "/administrator/components/com_community_acl/backup/module_helper.php";
				$success_msg = 'File `' . $dst_file . '` successfully replaced by patched version.';
				break;
		}
		$msg = '';
		$result = @chmod ( $dst_file, 0666 );
		/* * /
		if ($result) {
			@unlink($bk_file);
			$result = @rename($dst_file, $bk_file);
		} else
			$msg .= 'Error: Unable chmod file `'.$dst_file.'`<br/>';
		if ($result) {
			$result = @copy($src_file, $dst_file);
		} else
			$msg .= 'Error: Unable backup file `'.$dst_file.'`<br/>';
		if (!$result)
			$msg .= 'Error: Unable patch(replace) file `'.$dst_file.'`<br/>';
		/* */
		if ($msg == '') {
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=about', $success_msg );
			die ();
		}
		/* else {
			$mainframe->redirect('index.php?option=com_community_acl&task=about', $msg, 'error');
		}*/
	}
	$mainframe->redirect ( 'index.php?option=com_community_acl&task=about' );
}
function check_plugins_hacks($message = true) {
}
/*
return
	-3  CB not installed
	-2  incorrect vercsion of CB
	-1  plugin not installed
	 0  plugin not enabled
	 1  all OK
*/
function check_cb_plugin() {
	$db = & JFactory::getDBO ();
	if (file_exists ( JPATH_SITE . '/administrator/components/com_comprofiler/ue_config.php' )) {
		$ueConfig = array ();
		include (JPATH_SITE . '/administrator/components/com_comprofiler/ue_config.php');
		if (isset ( $ueConfig ['version'] ) && $ueConfig ['version'] >= '1.1') {
			$query = "SELECT `element`, `published` FROM `#__comprofiler_plugin` WHERE `element` = 'cacl_usersync'";
			$db->setQuery ( $query );
			$tmp = $db->loadObjectList ();
			$tmp = isset ( $tmp [0] ) ? $tmp [0] : null;
			if ($tmp === null) {
				return - 1;
			}
			if ($tmp !== null && $tmp->published != 1) {
				return 0;
			}
			return 1;
		}
		return - 2;
	}
	return - 3;
}
/*
return
	-1  plugin not installed
	 0  plugin not enabled
	 1  all OK
*/
function check_plugin() {
	$db = & JFactory::getDBO ();
	$query = "SELECT `element`, `published` FROM `#__plugins` WHERE `element` = 'community_acl'";
	$db->setQuery ( $query );
	$tmp = $db->loadObjectList ();
	$tmp = isset ( $tmp [0] ) ? $tmp [0] : null;
	if ($tmp === null) {
		return - 1;
	}
	if ($tmp !== null && $tmp->published != 1) {
		return 0;
	}
	return 1;
}
/*
return
	 0  no hacks
	 1  all OK
*/
function check_core_file($filename = '') {
	if ( is_file( $filename ) ) {
		$filename = file_get_contents($filename);
		if ( false === strpos($filename, 'community_acl')){
			//Not found.
			return -1;
		} else {
			//Found
			return 1;
		}
	}
	return 0;
	/*if ($filename) {
		$filecontent = file ( $filename );
		if (is_array ( $filecontent ) && count ( $filecontent ) > 0) {
			foreach ( $filecontent as $line ) {
				if (strpos ( $line, 'community_acl' ) !== false)
					return 1;
			}
		}
		if (is_writable ( $filename ))
			return 0;
		else
			return - 1;
	}
	return 0;*/
}
function doSynchronization() {
	@set_time_limit ( 3600 );
	global $mainframe;
	$db = & JFactory::getDBO ();
	$query = "SELECT `id` FROM  `#__community_acl_sites` WHERE `is_main` = '1'";
	$db->setQuery ( $query );
	$sid = ( int ) $db->loadResult ();
	if ($sid > 0) {
		$main = new CACL_site ( $db );
		$main->load ( $sid );
		$config = new CACL_config ( $main->_site_db );
		$config->load ();
		if (! $config->synchronize) {
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=synchronize', JText::_ ( 'Error! Please enable synchronization in configuration first.' ) );
			die ();
		}
		$sync = new CACL_syncronize ( $main );
		$msg = "<br/>";
		if ($config->cacl_grf) {
			$query = "SELECT `id` FROM `#__community_acl_groups`";
			$db->setQuery ( $query );
			$items = $db->loadResultArray ();
			if (is_array ( $items ) && count ( $items ) > 0)
				foreach ( $items as $id ) {
					$sync->syncronize ( $id, 'cacl_group' );
				}
			$query = "SELECT `id` FROM `#__community_acl_roles`";
			$db->setQuery ( $query );
			$items = $db->loadResultArray ();
			if (is_array ( $items ) && count ( $items ) > 0)
				foreach ( $items as $id ) {
					$sync->syncronize ( $id, 'cacl_role' );
				}
			$query = "SELECT `id` FROM `#__community_acl_functions`";
			$db->setQuery ( $query );
			$items = $db->loadResultArray ();
			if (is_array ( $items ) && count ( $items ) > 0)
				foreach ( $items as $id ) {
					$sync->syncronize ( $id, 'cacl_func' );
				}
			$msg .= "Groups / Roles / Functions successfully synchronized<br/>";
			$query = "SELECT DISTINCT `func_id` FROM `#__community_acl_function_access`";
			$db->setQuery ( $query );
			$items = $db->loadResultArray ();
			if (is_array ( $items ) && count ( $items ) > 0)
				foreach ( $items as $id ) {
					$sync->syncronize ( $id, 'access_func' );
				}
			$query = "SELECT DISTINCT `group_id`, `role_id` FROM `#__community_acl_access`";
			$db->setQuery ( $query );
			$items = $db->loadObjectList ();
			if (is_array ( $items ) && count ( $items ) > 0)
				foreach ( $items as $item ) {
					$tid = array ('group_id' => $item->group_id, 'role_id' => $item->role_id );
					$sync->syncronize ( $tid, 'access' );
				}
			$msg .= "Groups / Roles / Functions access restrictions successfully synchronized<br/>";
		}
		$sync->syncronize ( '0', 'config' );
		$msg .= "Configuration successfully synchronized<br/>";
		if ($config->cb_contact) {
			$sync->syncronize ( 0, 'cb_contact' );
			$msg .= "Contacts successfully synchronized<br/>";
		}
		if ($config->users_and_cb) {
			$query = "SELECT DISTINCT `id` FROM `#__users` WHERE `gid` < 25";
			$db->setQuery ( $query );
			$items = $db->loadResultArray ();
			if (is_array ( $items ) && count ( $items ) > 0)
				foreach ( $items as $id ) {
					$sync->syncronize ( $id, 'user' );
					$sync->syncronize ( $id, 'cb_user' );
				}
			$msg .= "Users successfully synchronized<br/>";
		}
		$mainframe->redirect ( 'index.php?option=com_community_acl&task=synchronize', '<div style="padding-left:50px;">' . $msg . '</div>' );
		die ();
	}
	$mainframe->redirect ( 'index.php?option=com_community_acl&task=synchronize', JText::_ ( 'Error! There is no main site!' ) );
}
function saveUserAccessA($cid) {
	global $mainframe;
	$db = & JFactory::getDBO ();
	$mode = JRequest::getCmd ( 'mode' );
	$pid = ( int ) JRequest::getCmd ( 'pid' );
	$rid = ( int ) JRequest::getCmd ( 'rid' );
	$cacl_fid = ( int ) JRequest::getCmd ( 'cacl_func_list' );
	if (is_array ( $cid ) && count ( $cid ) > 0 && $pid > 0) {
		$query = "SELECT `id` FROM  `#__community_acl_sites` WHERE `is_main` = '1'";
		$db->setQuery ( $query );
		$sid = ( int ) $db->loadResult ();
		if ($sid > 0) {
			$main = new CACL_site ( $db );
			$main->load ( $sid );
			$config = new CACL_config ( $main->_site_db );
			$config->load ();
		}
		if ($mode == 'role_id') {
			$query = "SELECT `group_id` FROM `#__community_acl_roles` WHERE id = '{$pid}'";
			$db->setQuery ( $query );
			$group_id = ( int ) $db->loadResult ();
		}
		foreach ( $cid as $user_id ) {
			if ($mode == 'role_id') {
				$query = "INSERT INTO `#__community_acl_users` SET `user_id` = '" . $user_id . "', `role_id` = '{$pid}', `group_id` = '{$group_id}', `function_id` = '{$cacl_fid}'";
			} else {
				$query = "INSERT INTO `#__community_acl_users` SET `user_id` = '" . $user_id . "', `group_id` = '{$pid}', `role_id` = '{$rid}', `function_id` = '{$cacl_fid}'";
			}
			$db->setQuery ( $query );
			$db->query ();
			if ($sid > 0) {
				if ($config->synchronize && $config->users_and_cb) {
					$sync = new CACL_syncronize ( $main );
					$sync->syncronize ( $user_id, 'user' );
					$sync->syncronize ( $user_id, 'cb_user' );
				}
			}
		}
		if ($mode == 'role_id') {
			$msg = JText::_ ( 'User(s) successfully added to role' );
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=list_roles', $msg );
		} else {
			$msg = JText::_ ( 'User(s) successfully added to group' );
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=list_groups', $msg );
		}
	}
}
function saveUserAccessR($cid) {
	global $mainframe;
	$db = & JFactory::getDBO ();
	$mode = JRequest::getCmd ( 'mode' );
	$pid = ( int ) JRequest::getCmd ( 'pid' );
	if (is_array ( $cid ) && count ( $cid ) > 0 && $pid > 0) {
		$query = "SELECT `id` FROM  `#__community_acl_sites` WHERE `is_main` = '1'";
		$db->setQuery ( $query );
		$sid = ( int ) $db->loadResult ();
		if ($sid > 0) {
			$main = new CACL_site ( $db );
			$main->load ( $sid );
			$config = new CACL_config ( $main->_site_db );
			$config->load ();
		}
		foreach ( $cid as $user_id ) {
			if ($mode == 'role_id') {
				$query = "DELETE FROM `#__community_acl_users` WHERE `user_id` = '" . $user_id . "' AND `role_id` = '{$pid}' ";
			} else {
				$query = "DELETE FROM `#__community_acl_users` WHERE `user_id` = '" . $user_id . "' AND `group_id` = '{$pid}' ";
			}
			$db->setQuery ( $query );
			$db->query ();
			if ($sid > 0) {
				if ($config->synchronize && $config->users_and_cb) {
					$sync = new CACL_syncronize ( $main );
					$sync->syncronize ( $user_id, 'user' );
					$sync->syncronize ( $user_id, 'cb_user' );
				}
			}
		}
		if ($mode == 'role_id') {
			$msg = JText::_ ( 'User(s) successfully removed from role' );
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=list_roles', $msg );
		} else {
			$msg = JText::_ ( 'User(s) successfully removed from group' );
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=list_groups', $msg );
		}
	}
}
function showUserAccessA($group_id = 0, $role_id = 0) {
	global $mainframe, $option;
	$limit = $mainframe->getUserStateFromRequest ( 'global.list.limit', 'limit', $mainframe->getCfg ( 'list_limit' ), 'int' );
	$limitstart = $mainframe->getUserStateFromRequest ( $option . '.limitstart', 'limitstart', 0, 'int' );
	$db = & JFactory::getDBO ();
	$mode = JRequest::getCmd ( 'mode' );
	$lists = array ();
	$query = 'SELECT id AS value, name AS text' . ' FROM `#__community_acl_functions`' . ' ORDER BY name';
	$db->setQuery ( $query );
	$functions [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'None' ), 'value', 'text' );
	$functions = @array_merge ( $functions, $db->loadObjectList () );
	//$functions = $db->loadObjectList();	$lists ['cacl_fid'] = JHTML::_ ( 'select.genericlist', $functions, 'cacl_func_list', ' class="inputbox" size="1" ', 'value', 'text', null );
	if (count ( $functions ) < 1)
		$lists ['cacl_fid'] = JText::_ ( 'There is no functions' );
	if ($group_id)
		$query = "SELECT `user_id` FROM `#__community_acl_users` AS a WHERE `group_id` = '{$group_id}' ";
	else
		$query = "SELECT `user_id` FROM `#__community_acl_users` AS a WHERE `role_id` = '{$role_id}' ";
	$db->setQuery ( $query );
	$users = $db->loadResultArray ();
	$users [] = - 1;
	$query = "SELECT COUNT(*) FROM `#__users` AS b WHERE b.id NOT IN ('" . implode ( "','", $users ) . "')";
	$db->setQuery ( $query );
	$total = ( int ) $db->loadResult ();
	jimport ( 'joomla.html.pagination' );
	$pagination = new JPagination ( $total, $limitstart, $limit );
	$query = "SELECT b.*, `c`.`name` AS `groupname` FROM `#__users` AS b LEFT JOIN `#__core_acl_aro_groups` AS c ON `b`.`gid` = c.id WHERE b.id NOT IN ('" . implode ( "','", $users ) . "') ORDER BY b.email ASC";
	$db->setQuery ( $query, $pagination->limitstart, $pagination->limit );
	$rows = $db->loadObjectList ();
	/* Kobby's modification:
	 * Users must select a Role before they can select a Group
	 */
	$role_selected = JRequest::getVar ( 'role_selected', false );
	if ($role_selected == false && $mode == 'group_id') {
		$cid = JRequest::getVar ( 'cid' );
		$cid = $cid [0];
		$tmp_arr = array ();
		$javascript = 'onchange="return continueLink();"';
		$roles [] = JHTML::_ ( 'select.option', '-1', '- ' . JText::_ ( 'Select Role' ) . ' -' );
		$query = 'SELECT id AS value, name AS text, group_id' . ' FROM `#__community_acl_roles`' . ' WHERE group_id = ' . $group_id . ' ORDER BY group_id, name';
		$db->setQuery ( $query );
		$roles = @array_merge ( $roles, $db->loadObjectList () );
		$lists ['cacl_rid_arr'] = $tmp_arr;
		$lists ['cacl_rid'] = JHTML::_ ( 'select.genericlist', $roles, 'cacl_role_list', ' class="inputbox" size="1" ' . $javascript, 'value', 'text', null );
		if (count ( $roles ) < 1)
			$lists ['cacl_rid'] = JText::_ ( 'There is no roles' );
		left_menu_header ();
		?><script type="text/javascript">
				function continueLink(){
					var gid = (document.getElementById('cacl_role_list').value);
					if (gid == -1) {
						alert('Please select a valid role');
						return;
					}
					var previousInnerHTML = new String();
					var cid = document.getElementById('cid').value;
					previousInnerHTML = document.getElementById('continue').innerHTML;
					previousInnerHTML = ("<a href=\"index.php?option=com_community_acl&task=add_users_access&mode=group_id&role_id="+ gid +"&role_selected=true&cid[]="+ cid + "\">Continue</a>");
					document.getElementById('continue').innerHTML = previousInnerHTML;
				}
			</script><?php
		echo '<b>Please select a Role</b><br/><br/>';
		$cid = JRequest::getVar ( 'cid' );
		$cid = $cid [0];
		echo $lists ['cacl_rid'];
		echo '<br /><br />';
		?><div id="continue" name="continue"></div><input id="cid" name="cid" type="hidden" value="<?php
		echo $cid;
		?>" /><?php
		left_menu_footer ();
	} else
		cacl_html::showUserAccessA ( $lists, $rows, $pagination, $mode, ($group_id > 0 ? $group_id : $role_id) );
}
function showUserAccessR($group_id = 0, $role_id = 0) {
	global $mainframe, $option;
	$limit = $mainframe->getUserStateFromRequest ( 'global.list.limit', 'limit', $mainframe->getCfg ( 'list_limit' ), 'int' );
	$limitstart = $mainframe->getUserStateFromRequest ( $option . '.limitstart', 'limitstart', 0, 'int' );
	$db = & JFactory::getDBO ();
	$mode = JRequest::getCmd ( 'mode' );
	if ($group_id)
		$query = "SELECT COUNT(*) FROM `#__community_acl_users` AS a, `#__users` AS b WHERE `group_id` = '{$group_id}' AND a.user_id = b.id ";
	else
		$query = "SELECT COUNT(*) FROM `#__community_acl_users` AS a, `#__users` AS b WHERE `role_id` = '{$role_id}' AND a.user_id = b.id ";
	$db->setQuery ( $query );
	$total = ( int ) $db->loadResult ();
	jimport ( 'joomla.html.pagination' );
	$pagination = new JPagination ( $total, $limitstart, $limit );
	if ($group_id)
		$query = "SELECT b.*, c.name AS groupname FROM `#__community_acl_users` AS a, `#__users` AS b, `#__community_acl_groups` AS c WHERE `group_id` = '{$group_id}' AND a.user_id = b.id AND a.group_id = c.id";
	else
		$query = "SELECT b.*, c.name AS groupname FROM `#__community_acl_users` AS a, `#__users` AS b, `#__community_acl_groups` AS c WHERE `role_id` = '{$role_id}' AND a.user_id = b.id AND a.group_id = c.id";
	$db->setQuery ( $query, $pagination->limitstart, $pagination->limit );
	$rows = $db->loadObjectList ();
	cacl_html::showUserAccessR ( $rows, $pagination, $mode, ($group_id > 0 ? $group_id : $role_id) );
}
function saveUnassignUsers($option, $cid) {
	global $mainframe;
	$db = & JFactory::getDBO ();
	$query = "SELECT `id` FROM  `#__community_acl_sites` WHERE `is_main` = '1'";
	$db->setQuery ( $query );
	$sid = ( int ) $db->loadResult ();
	if ($sid > 0) {
		$main = new CACL_site ( $db );
		$main->load ( $sid );
		$config = new CACL_config ( $main->_site_db );
		$config->load ();
	}
	$cacl_group_id = JRequest::getVar ( 'cacl_group_list', array (- 1 ), '', 'array' );
	JArrayHelper::toInteger ( $cacl_group_id, array () );
	$cacl_role_id = JRequest::getVar ( 'cacl_role_list', array (- 1 ), '', 'array' );
	JArrayHelper::toInteger ( $cacl_role_id, array () );
	if (is_array ( $cid ) && count ( $cid ) > 0)
		foreach ( $cid as $user_id ) {
			if (is_array ( $cacl_group_id ) && count ( $cacl_group_id ) > 0) {
				$query = "DELETE FROM `#__community_acl_users` WHERE `user_id` = '" . $user_id . "' AND `group_id` IN ('" . implode ( "','", $cacl_group_id ) . "') ";
				$db->setQuery ( $query );
				$db->query ();
			}
			if (is_array ( $cacl_role_id ) && count ( $cacl_role_id ) > 0) {
				$query = "DELETE FROM `#__community_acl_users` WHERE `user_id` = '" . $user_id . "' AND `role_id` IN ('" . implode ( "','", $cacl_role_id ) . "') ";
				$db->setQuery ( $query );
				$db->query ();
			}
			if ($sid > 0) {
				if ($config->synchronize && $config->users_and_cb) {
					$sync = new CACL_syncronize ( $main );
					$sync->syncronize ( $user_id, 'user' );
					$sync->syncronize ( $user_id, 'cb_user' );
				}
			}
		}
	$msg = JText::_ ( 'User(s) successfully unassigned from Groups/Roles' );
	$mainframe->redirect ( 'index.php?option=com_community_acl&mode=manage_users', $msg );
}
function saveAssignUsers($option, $cid) {
	global $mainframe;
	$db = & JFactory::getDBO ();
	$query = "SELECT `id` FROM  `#__community_acl_sites` WHERE `is_main` = '1'";
	$db->setQuery ( $query );
	$sid = ( int ) $db->loadResult ();
	if ($sid > 0) {
		$main = new CACL_site ( $db );
		$main->load ( $sid );
		$config = new CACL_config ( $main->_site_db );
		$config->load ();
	}
	$cacl_group_id = JRequest::getVar ( 'cacl_group_id', array (), '', 'array' );
	JArrayHelper::toInteger ( $cacl_group_id, array () );
	$cacl_role_id = JRequest::getVar ( 'cacl_role_id', array (), '', 'array' );
	JArrayHelper::toInteger ( $cacl_role_id, array () );
	$cacl_func_id = JRequest::getVar ( 'cacl_func_id', array (), '', 'array' );
	JArrayHelper::toInteger ( $cacl_func_id, array () );
	if (is_array ( $cid ) && count ( $cid ) > 0)
		foreach ( $cid as $user_id ) {
			$query = "DELETE FROM `#__community_acl_users` WHERE `user_id` = '" . $user_id . "'";
			$db->setQuery ( $query );
			$db->query ();
			if (is_array ( $cacl_group_id ) && count ( $cacl_group_id )) {
				foreach ( $cacl_group_id as $i => $v ) {
					$cacl_usr = new CACL_user ( $db );
					$cacl_usr->user_id = $user_id;
					$cacl_usr->group_id = (isset ( $cacl_group_id [$i] ) ? $cacl_group_id [$i] : 0);
					$cacl_usr->role_id = (isset ( $cacl_role_id [$i] ) ? $cacl_role_id [$i] : 0);
					$cacl_usr->function_id = (isset ( $cacl_func_id [$i] ) ? $cacl_func_id [$i] : 0);
					$cacl_usr->store ();
				}
			}
			if ($sid > 0) {
				if ($config->synchronize && $config->users_and_cb) {
					$sync = new CACL_syncronize ( $main );
					$sync->syncronize ( $user_id, 'user' );
					$sync->syncronize ( $user_id, 'cb_user' );
				}
			}
		}
	$msg = JText::_ ( 'User(s) successfully assigned to Groups/Roles' );
	$mainframe->redirect ( 'index.php?option=com_community_acl&mode=manage_users', $msg );
}
function showAssignUsers($option, $cid) {
	global $mainframe;
	$db = & JFactory::getDBO ();
	$query = 'SELECT id, CONCAT(name, \' (\', username, \')\') AS name ' . ' FROM `#__users`' . ' WHERE `id` IN (\'' . implode ( "','", $cid ) . '\')' . ' ORDER BY name';
	$db->setQuery ( $query );
	$lists ['user_list'] = $db->loadObjectList ();
	$query = 'SELECT id AS value, name AS text' . ' FROM `#__community_acl_groups`' . ' ORDER BY name';
	$db->setQuery ( $query );
	$groups = $db->loadObjectList ();
	$javascript = "onchange=\"changeDynaList( 'cacl_role_list', grouproles, document.adminForm.cacl_group_list.options[document.adminForm.cacl_group_list.selectedIndex].value, 0, 0);\"";
	$lists ['cacl_gid'] = JHTML::_ ( 'select.genericlist', $groups, 'cacl_group_list', ' class="inputbox" size="1" ' . $javascript, 'value', 'text', null );
	if (count ( $groups ) < 1)
		$lists ['cacl_gid'] = JText::_ ( 'There is no groups' );
	$query = 'SELECT id ' . ' FROM `#__community_acl_groups`' . ' ORDER BY name';
	$db->setQuery ( $query );
	$groups = $db->loadObjectList ();
	$query = 'SELECT id AS value, name AS text, group_id' . ' FROM `#__community_acl_roles`' . ' ORDER BY group_id, name';
	$db->setQuery ( $query );
	$roles = $db->loadObjectList ();
	$tmp_arr = array ();
	if (is_array ( $roles ) && count ( $roles )) {
		$tmp_arr = array ();
		foreach ( $groups as $group ) {
			$z = 0;
			foreach ( $roles as $i => $role ) {
				if ($role->group_id != $group->id)
					continue;
				$tmp_arr [] = array ('group' => $role->group_id, 'value' => $role->value, 'text' => $role->text );
				$z ++;
			}
			if ($z == 0)
				$tmp_arr [] = array ('group' => $group->id, 'value' => 0, 'text' => JText::_ ( 'None' ) );
		}
	}
	$lists ['cacl_rid_arr'] = $tmp_arr;
	$lists ['cacl_rid'] = JHTML::_ ( 'select.genericlist', $roles, 'cacl_role_list', ' class="inputbox" size="1" ', 'value', 'text', null );
	if (count ( $roles ) < 1)
		$lists ['cacl_rid'] = JText::_ ( 'There is no roles' );
	$query = 'SELECT id AS value, name AS text' . ' FROM `#__community_acl_functions`' . ' ORDER BY name';
	$db->setQuery ( $query );
	$functions [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'None' ), 'value', 'text' );
	$functions = @array_merge ( $functions, $db->loadObjectList () );
	//$functions = $db->loadObjectList();	$lists ['cacl_fid'] = JHTML::_ ( 'select.genericlist', $functions, 'cacl_func_list', ' class="inputbox" size="1" ', 'value', 'text', null );
	if (count ( $functions ) < 1)
		$lists ['cacl_fid'] = JText::_ ( 'There is no functions' );
	cacl_html::showAssignUsers ( $lists );
}
function showUnassignUsers($option, $cid) {
	global $mainframe;
	$db = & JFactory::getDBO ();
	$query = 'SELECT id, CONCAT(name, \' (\', username, \')\') AS name ' . ' FROM `#__users`' . ' WHERE `id` IN (\'' . implode ( "','", $cid ) . '\')' . ' ORDER BY name';
	$db->setQuery ( $query );
	$lists ['user_list'] = $db->loadObjectList ();
	$query = 'SELECT id AS value, name AS text' . ' FROM `#__community_acl_groups`' . ' ORDER BY name';
	$db->setQuery ( $query );
	$groups = $db->loadObjectList ();
	$lists ['cacl_gid'] = JHTML::_ ( 'select.genericlist', $groups, 'cacl_group_list', ' class="inputbox" size="7" style="max-width:100px;" multiple="multiple" ', 'value', 'text', null );
	if (count ( $groups ) < 1)
		$lists ['cacl_gid'] = JText::_ ( 'There is no groups' );
	$query = 'SELECT id ' . ' FROM `#__community_acl_groups`' . ' ORDER BY name';
	$db->setQuery ( $query );
	$groups = $db->loadObjectList ();
	$query = 'SELECT id AS value, name AS text, group_id' . ' FROM `#__community_acl_roles`' . ' ORDER BY group_id, name';
	$db->setQuery ( $query );
	$roles = $db->loadObjectList ();
	$tmp_arr = array ();
	if (is_array ( $roles ) && count ( $roles )) {
		$tmp_arr = array ();
		foreach ( $groups as $group ) {
			$z = 0;
			foreach ( $roles as $i => $role ) {
				if ($role->group_id != $group->id)
					continue;
				$tmp_arr [] = array ('group' => $role->group_id, 'value' => $role->value, 'text' => $role->text );
				$z ++;
			}
			if ($z == 0)
				$tmp_arr [] = array ('group' => $group->id, 'value' => 0, 'text' => JText::_ ( 'None' ) );
		}
	}
	$lists ['cacl_rid_arr'] = $tmp_arr;
	$lists ['cacl_rid'] = JHTML::_ ( 'select.genericlist', $roles, 'cacl_role_list', ' class="inputbox" size="7" style="max-width:100px;" multiple="multiple" ', 'value', 'text', null );
	if (count ( $roles ) < 1)
		$lists ['cacl_rid'] = JText::_ ( 'There is no roles' );
	cacl_html::showUnassignUsers ( $lists );
}
function saveConfig() {
	global $mainframe;
	// Check for request forgeries	//JRequest::checkToken() or die( 'Invalid Token' );	// Initialize variables	$db = & JFactory::getDBO ();
	$redirect = JRequest::getCmd ( 'redirect', '', 'post' );
	$post = JRequest::get ( 'post' );
	$config = new CACL_config ( $db );
	$config->load ();
	$config->bind ( $post );
	$config->store ();
	$user = & JFactory::getUser ();
	$cb_config = new CB_config ( $db );
	$cb_config->storeData ( $post );
	if ($config->synchronize) {
		$query = "SELECT `id` FROM  `#__community_acl_sites` WHERE `is_main` = '1'";
		$db->setQuery ( $query );
		$sid = ( int ) $db->loadResult ();
		$main = new CACL_site ( $db );
		$main->load ( $sid );
		$sync = new CACL_syncronize ( $main );
		$sync->syncronize ( '0', 'config' );
	}
	switch (JRequest::getCmd ( 'task' )) {
		case 'apply_config' :
			$msg = JText::_ ( 'Changes to Config saved' );
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=config', $msg );
			break;
		case 'save_config' :
		default :
			$msg = JText::_ ( 'Config saved' );
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=config', $msg );
			//$mainframe->redirect( 'index.php?option=com_community_acl&task='. $redirect, $msg );			break;
	}
}
function showConfig() {
	$db = & JFactory::getDBO ();
	$config = new CACL_config ( $db );
	$config->load ();
	$lists = array ();
	$query = 'SELECT id AS value, name AS text' . ' FROM `#__community_acl_groups`' . ' ORDER BY name';
	$db->setQuery ( $query );
	//$groups = $db->loadObjectList();	$groups [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'None' ), 'value', 'text' );
	$groups = @array_merge ( $groups, $db->loadObjectList () );
	$javascript = "onchange=\"changeDynaList( 'public_role', grouproles, document.adminForm.public_group.options[document.adminForm.public_group.selectedIndex].value, 0, 0);\"";
	$lists ['cacl_gid_pub'] = JHTML::_ ( 'select.genericlist', $groups, 'public_group', ' class="inputbox" size="1" ' . $javascript, 'value', 'text', $config->public_group );
	$javascript = "onchange=\"changeDynaList( 'registered_role', grouproles, document.adminForm.registered_group.options[document.adminForm.registered_group.selectedIndex].value, 0, 0); if (document.adminForm.registered_group.options[document.adminForm.registered_group.selectedIndex].value == 0){document.adminForm.registered_role.options[document.adminForm.registered_role.selectedIndex].text = 'None';}\"";
	$lists ['cacl_gid_reg'] = JHTML::_ ( 'select.genericlist', $groups, 'registered_group', ' class="inputbox" size="1" ' . $javascript, 'value', 'text', $config->registered_group );
	$javascript = "onchange=\"changeDynaList( 'author_role', grouproles, document.adminForm.author_group.options[document.adminForm.author_group.selectedIndex].value, 0, 0);\"";
	$lists ['cacl_gid_ath'] = JHTML::_ ( 'select.genericlist', $groups, 'author_group', ' class="inputbox" size="1" ' . $javascript, 'value', 'text', $config->author_group );
	$javascript = "onchange=\"changeDynaList( 'editor_role', grouproles, document.adminForm.editor_group.options[document.adminForm.editor_group.selectedIndex].value, 0, 0);\"";
	$lists ['cacl_gid_edt'] = JHTML::_ ( 'select.genericlist', $groups, 'editor_group', ' class="inputbox" size="1" ' . $javascript, 'value', 'text', $config->editor_group );
	$javascript = "onchange=\"changeDynaList( 'publisher_role', grouproles, document.adminForm.publisher_group.options[document.adminForm.publisher_group.selectedIndex].value, 0, 0);\"";
	$lists ['cacl_gid_pbl'] = JHTML::_ ( 'select.genericlist', $groups, 'publisher_group', ' class="inputbox" size="1" ' . $javascript, 'value', 'text', $config->publisher_group );
	$javascript = "onchange=\"changeDynaList( 'manager_role', grouproles, document.adminForm.manager_group.options[document.adminForm.manager_group.selectedIndex].value, 0, 0);\"";
	$lists ['cacl_gid_man'] = JHTML::_ ( 'select.genericlist', $groups, 'manager_group', ' class="inputbox" size="1" ' . $javascript, 'value', 'text', $config->manager_group );
	$javascript = "onchange=\"changeDynaList( 'administrator_role', grouproles, document.adminForm.administrator_group.options[document.adminForm.administrator_group.selectedIndex].value, 0, 0);\"";
	$lists ['cacl_gid_adm'] = JHTML::_ ( 'select.genericlist', $groups, 'administrator_group', ' class="inputbox" size="1" ' . $javascript, 'value', 'text', $config->administrator_group );
	$query = 'SELECT id AS value, name AS text, group_id' . ' FROM `#__community_acl_roles`' . ' ORDER BY group_id, name';
	$db->setQuery ( $query );
	$roles = $db->loadObjectList ();
	$tmp_arr = array ();
	if (is_array ( $roles ) && count ( $roles )) {
		$tmp_arr = array (array ('group' => '0', 'value' => '0', 'text' => JText::_ ( 'None' ) ) );
		foreach ( $roles as $i => $role ) {
			$tmp_arr [] = array ('group' => $role->group_id, 'value' => $role->value, 'text' => $role->text );
		}
	}
	$lists ['cacl_rid_arr'] = $tmp_arr;
	$tmp [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'None' ), 'value', 'text' );
	$roles = @array_merge ( $tmp, $roles );
	$lists ['cacl_rid_pub'] = JHTML::_ ( 'select.genericlist', $roles, 'public_role', ' class="inputbox" size="1" ', 'value', 'text', $config->public_role );
	$lists ['cacl_rid_reg'] = JHTML::_ ( 'select.genericlist', $roles, 'registered_role', ' class="inputbox" size="1" ', 'value', 'text', $config->registered_role );
	$lists ['cacl_rid_ath'] = JHTML::_ ( 'select.genericlist', $roles, 'author_role', ' class="inputbox" size="1" ', 'value', 'text', $config->author_role );
	$lists ['cacl_rid_edt'] = JHTML::_ ( 'select.genericlist', $roles, 'editor_role', ' class="inputbox" size="1" ', 'value', 'text', $config->editor_role );
	$lists ['cacl_rid_pbl'] = JHTML::_ ( 'select.genericlist', $roles, 'publisher_role', ' class="inputbox" size="1" ', 'value', 'text', $config->publisher_role );
	$lists ['cacl_rid_man'] = JHTML::_ ( 'select.genericlist', $roles, 'manager_role', ' class="inputbox" size="1" ', 'value', 'text', $config->manager_role );
	$lists ['cacl_rid_adm'] = JHTML::_ ( 'select.genericlist', $roles, 'administrator_role', ' class="inputbox" size="1" ', 'value', 'text', $config->administrator_role );
	$query = 'SELECT id AS value, name AS text' . ' FROM `#__community_acl_functions`' . ' ORDER BY name';
	$db->setQuery ( $query );
	//$functions = $db->loadObjectList();	$functions [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'None' ), 'value', 'text' );
	$functions = @array_merge ( $functions, $db->loadObjectList () );
	$lists ['cacl_fid_pub'] = JHTML::_ ( 'select.genericlist', $functions, 'public_function', ' class="inputbox" size="1" ', 'value', 'text', $config->public_function );
	$lists ['cacl_fid_reg'] = JHTML::_ ( 'select.genericlist', $functions, 'registered_function', ' class="inputbox" size="1" ', 'value', 'text', $config->registered_function );
	$lists ['cacl_fid_ath'] = JHTML::_ ( 'select.genericlist', $functions, 'author_function', ' class="inputbox" size="1" ', 'value', 'text', $config->author_function );
	$lists ['cacl_fid_edt'] = JHTML::_ ( 'select.genericlist', $functions, 'editor_function', ' class="inputbox" size="1" ', 'value', 'text', $config->editor_function );
	$lists ['cacl_fid_pbl'] = JHTML::_ ( 'select.genericlist', $functions, 'publisher_function', ' class="inputbox" size="1" ', 'value', 'text', $config->publisher_function );
	$lists ['cacl_fid_man'] = JHTML::_ ( 'select.genericlist', $functions, 'manager_function', ' class="inputbox" size="1" ', 'value', 'text', $config->manager_function );
	$lists ['cacl_fid_adm'] = JHTML::_ ( 'select.genericlist', $functions, 'administrator_function', ' class="inputbox" size="1" ', 'value', 'text', $config->administrator_function );
	$options = array ();
	$options [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'Show only title' ), 'value', 'text' );
	$options [] = JHTML::_ ( 'select.option', '1', JText::_ ( 'Show title with `no access` message' ), 'value', 'text' );
	$options [] = JHTML::_ ( 'select.option', '2', JText::_ ( 'Show title and introtext' ), 'value', 'text' );
	$options [] = JHTML::_ ( 'select.option', '3', JText::_ ( 'Show title and introtext with appended `no access` message' ), 'value', 'text' );
	$lists ['forbidden_content'] = JHTML::_ ( 'select.genericlist', $options, 'forbidden_content', ' class="inputbox" size="1" ', 'value', 'text', $config->forbidden_content );
	# - Modified by Kobby	$cb_acl_groups = $db->loadObjectList ();
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
	ORDER BY f.name ASC';
	$db->setQuery ( $query );
	$lists ['cacl_cb_users'] = $db->loadObjectList ();
	//print_r($query);	if (! $lists ['cacl_cb_users']) {
		$query = 'SELECT DISTINCT a.id, a.*, e.name AS g_name, f.name AS r_name, g.name AS f_name' . ' FROM `#__community_acl_users` AS a' . ' LEFT JOIN `#__community_acl_cb_groups` AS b ON a.group_id = b.id ' . ' LEFT JOIN `#__community_acl_cb_roles` AS c ON a.role_id = c.id ' . ' LEFT JOIN `#__community_acl_cb_functions` AS d ON a.role_id = d.id ' . ' LEFT JOIN `#__community_acl_groups` AS e ON a.group_id = e.id ' . ' LEFT JOIN `#__community_acl_roles` AS f ON a.role_id = f.id ' . ' LEFT JOIN `#__community_acl_functions` AS g ON a.function_id = g.id ' . " WHERE a.user_id = '1'" . ' AND a.group_id = e.id ' . ' AND a.role_id = f.id ' . ' ORDER BY a.id';
		$db->setQuery ( $query );
		$lists ['cacl_cb_users'] = $db->loadObjectList ();
	}
	$query = 'SELECT id AS value, name AS text' . ' FROM `#__community_acl_groups`' . ' ORDER BY name';
	$db->setQuery ( $query );
	$groups = $db->loadObjectList ();
	$javascript = "onchange=\"changeDynaList( 'cacl_role_list', grouproles, document.adminForm.cacl_group_list.options[document.adminForm.cacl_group_list.selectedIndex].value, 0, 0);\"";
	$lists ['cacl_gid'] = JHTML::_ ( 'select.genericlist', $groups, 'cacl_group_list', ' class="inputbox" size="1" ' . $javascript, 'value', 'text', null );
	if (count ( $groups ) < 1)
		$lists ['cacl_gid'] = JText::_ ( 'There is no groups' );
	$query = 'SELECT id ' . ' FROM `#__community_acl_groups`' . ' ORDER BY name';
	$db->setQuery ( $query );
	$groups = $db->loadObjectList ();
	$query = 'SELECT id AS value, name AS text, group_id' . ' FROM `#__community_acl_roles`' . ' ORDER BY group_id, name';
	$db->setQuery ( $query );
	$roles = $db->loadObjectList ();
	//Kobby customization	$query = 'SELECT id AS value, name AS text' . ' FROM `#__community_acl_membership_types`' . ' ORDER BY id';
	$db->setQuery ( $query );
	$cb_members = $db->loadObjectList ();
	$lists ['membership'] = $cb_members;
	if ($lists ['membership'])
		$lists ['member_list'] = JHTML::_ ( 'select.genericlist', $cb_members, 'member_list', ' class="inputbox" size="1" ', 'value', 'text', null );
	if (count ( $cb_members ) < 1)
		$lists ['member_list'] = JText::_ ( 'Belongs to no membership type' );
	$query = 'SELECT choices as choice ' . ' FROM `#__community_acl_article_submission`' . ' ORDER BY id';
	$db->setQuery ( $query );
	$article_submission = $db->loadResultArray ();
	$lists ['article_submissions'] = $article_submission;
	$tmp_arr = array ();
	if (is_array ( $roles ) && count ( $roles )) {
		$tmp_arr = array ();
		foreach ( $groups as $group ) {
			$z = 0;
			foreach ( $roles as $i => $role ) {
				if ($role->group_id != $group->id)
					continue;
				$tmp_arr [] = array ('group' => $role->group_id, 'value' => $role->value, 'text' => $role->text );
				$z ++;
			}
			if ($z == 0)
				$tmp_arr [] = array ('group' => $group->id, 'value' => 0, 'text' => JText::_ ( 'None' ) );
		}
	}
	$lists ['cacl_rid_arr'] = $tmp_arr;
	$lists ['cacl_rid'] = JHTML::_ ( 'select.genericlist', $roles, 'cacl_role_list', ' class="inputbox" size="1" ', 'value', 'text', null );
	if (count ( $roles ) < 1)
		$lists ['cacl_rid'] = JText::_ ( 'There is no roles' );
	$lists ['cacl_fid'] = JHTML::_ ( 'select.genericlist', $functions, 'cacl_func_list', ' class="inputbox" size="1" ', 'value', 'text', null );
	if (count ( $functions ) < 1)
		$lists ['cacl_fid'] = JText::_ ( 'There is no functions' );
	$query = "SELECT `template` FROM `#__templates_menu` LIMIT 1";
	$db->setQuery ( $query );
	$template_name = $db->loadResult ();
	$templateDir = JPATH_ROOT . DS . 'templates/' . $template_name . '/html/com_user/register/default.php';
	$show_membership_tab = 'false';
	if (file_exists ( $templateDir )) {
		$section_ex = file_get_contents ( $templateDir );
		preg_match ( '/(?P<name>\w+): (?P<digit>\d+)/', $section_ex, $matches );
		if (count ( $matches ) > 0)
			$show_membership_tab = 'true';
	}
	$lists ['show_membership_tab'] = $show_membership_tab;
	cacl_html::show_config ( $config, $lists );
}
function setMainSite($id = 0) {
	global $mainframe;
	$msg = '';
	if ($id > 0) {
		$db = & JFactory::getDBO ();
		$query = "UPDATE `#__community_acl_sites` SET `is_main` = '0'";
		$db->setQuery ( $query );
		$db->query ();
		$query = "UPDATE `#__community_acl_sites` SET `is_main` = '1' WHERE `id` = '{$id}'";
		$db->setQuery ( $query );
		$db->query ();
		$msg = JText::_ ( 'Main site is saved' );
	}
	$mainframe->redirect ( 'index.php?option=com_community_acl&task=list_sites', $msg );
}
function cacl_check_db() {
	$db = & JFactory::getDBO ();
	$site = new CACL_site ( $db );
	$site->db_host = JRequest::getCmd ( 'db_host' );
	$site->db_name = JRequest::getCmd ( 'db_name' );
	$site->db_user = JRequest::getCmd ( 'db_user' );
	$site->db_password = JRequest::getCmd ( 'db_password' );
	$site->db_prefix = JRequest::getCmd ( 'db_prefix' );
	if ($site->connect ()) {
		echo '<font color="#00EE00">' . JText::_ ( 'Connection successful ' ) . '</font><br/>';
		$query = "SELECT COUNT(*) FROM `#__components` ";
		$site->_site_db->setQuery ( $query );
		if (intval ( $site->_site_db->loadResult () ) > 0) {
			echo '<font color="#00EE00">' . JText::_ ( 'Table prefix is OK' ) . '</font>';
		} else
			echo '<font color="#FF0000">' . JText::_ ( 'Table prefix is INVALID' ) . '</font>';
	} else
		echo '<font color="#FF0000">' . $site->getError () . '</font>';
}
function editSites($edit) {
	global $mainframe;
	// Initialize variables	$db = & JFactory::getDBO ();
	$user = & JFactory::getUser ();
	$uid = $user->get ( 'id' );
	$cid = JRequest::getVar ( 'cid', array (0 ), '', 'array' );
	JArrayHelper::toInteger ( $cid, array (0 ) );
	$row = new CACL_site ( $db );
	if ($edit)
		$row->load ( $cid [0], true, true );
	$lists ['published'] = JHTML::_ ( 'select.genericlist', array (array ('id' => 0, 'title' => JText::_ ( 'No' ) ), array ('id' => 1, 'title' => JText::_ ( 'Yes' ) ) ), 'enabled', 'class="inputbox" size="1" ', 'id', 'title', 1 );
	cacl_html::edit_site ( $row, $lists );
}
function saveSites() {
	global $mainframe;
	// Check for request forgeries	//JRequest::checkToken() or die( 'Invalid Token' );	// Initialize variables	$db = & JFactory::getDBO ();
	$redirect = JRequest::getCmd ( 'redirect', '', 'post' );
	$post = JRequest::get ( 'post' );
	// fix up special html fields	$post ['description'] = JRequest::getVar ( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
	$row = new CACL_site ( $db );
	if (! $row->bind ( $post )) {
		JError::raiseError ( 500, $row->getError () );
	}
	if (! $row->check ()) {
		JError::raiseWarning ( 500, $row->getError () );
		$mainframe->redirect ( 'index.php?option=com_community_acl&task=' . ($row->id > 0 ? 'site_edit&cid[]=' . $row->id : 'site_add') );
		return;
	}
	if (! $row->store ()) {
		JError::raiseError ( 500, $row->getError () );
	}
	switch (JRequest::getCmd ( 'task' )) {
		case 'apply_sites' :
			$msg = JText::_ ( 'Changes to Site saved' );
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=site_edit&cid[]=' . $row->id, $msg );
			break;
		case 'save_sites' :
		default :
			$msg = JText::_ ( 'Site saved' );
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=' . $redirect, $msg );
			break;
	}
}
function showSites($option) {
	global $mainframe;
	$db = & JFactory::getDBO ();
	$query = "SELECT `id` FROM `#__community_acl_sites` ";
	$db->setQuery ( $query );
	$sites = $db->loadObjectList ();
	$rows = array ();
	foreach ( $sites as $site ) {
		$tmp = new CACL_site ( $db );
		$tmp->load ( $site->id, true, true );
		$rows [] = $tmp;
		$tmp = null;
	}
	cacl_html::show_sites ( $rows, $option );
}
function saveFunctions() {
	global $mainframe, $option;
	$db = & JFactory::getDBO ();
	$cid = ( int ) JRequest::getCmd ( 'id' );
	$task = JRequest::getCmd ( 'task' );
	$redirect = JRequest::getCmd ( 'redirect' );
	//$joomla_group_id = (int)JRequest::getCmd('joomla_group_id');	//$joomla_actions = JRequest::getVar( 'joomla_actions', array(), '', 'array' );	//JArrayHelper::toInteger($joomla_actions, array());	$component_id = JRequest::getVar ( 'component_id', array (), '', 'array' );
	//JArrayHelper::toInteger($component_id, array());	$grouping = JRequest::getVar ( 'grouping', array (), '', 'array' );
	JArrayHelper::toInteger ( $grouping, array () );
	$key_name = JRequest::getVar ( 'key_name', array (), '', 'array' );
	$value_name = JRequest::getVar ( 'value_name', array (), '', 'array' );
	$front_end_cb = JRequest::getVar ( 'front_end_cb', array (), '', 'array' );
	JArrayHelper::toInteger ( $front_end_cb, array () );
	$back_end_cb = JRequest::getVar ( 'back_end_cb', array (), '', 'array' );
	JArrayHelper::toInteger ( $back_end_cb, array () );
	$extra_opt = JRequest::getVar ( 'extra_opt', array (), '', 'array' );
	$query = "DELETE FROM `#__community_acl_function_access` WHERE `func_id` = '{$cid}';";
	$db->setQuery ( $query );
	$db->Query ();
	if ($db->getErrorNum ()) {
		JError::raiseError ( 500, $db->stderr () );
	}
	if (is_array ( @$joomla_actions ) && count ( @$joomla_actions )) {
		foreach ( $joomla_actions as $joomla_action => $value ) {
			$query = "INSERT INTO `#__community_acl_function_access` (`func_id`, `grouping`, `option`, `name`, `value`, `isfrontend`, `isbackend`) VALUES('{$cid}', '0', '###','" . $joomla_action . "', '" . $value . "', '0', '0');";
			$db->setQuery ( $query );
			$db->Query ();
		}
	}
	if (is_array ( $component_id ) && count ( $component_id )) {
		$gp = 1;
		foreach ( $component_id as $i => $id ) {
			if ($id > 0 || $id == 'com_sections' || $id == 'com_frontpage' || $id == 'com_categories' || $id == 'com_trash') {
				$query = "SELECT `option` FROM `#__components` WHERE `id` = '{$id}';";
				$db->setQuery ( $query );
				$com_option = $db->loadResult ();
				if ($id == 'com_sections' || $id == 'com_frontpage' || $id == 'com_categories' || $id == 'com_trash')
					$com_option = $id;
				if (isset ( $key_name [$grouping [$i]] ) && is_array ( $key_name [$grouping [$i]] ))
					foreach ( $key_name [$grouping [$i]] as $j => $tmp ) {
						$name = $tmp;
						$value = $value_name [$grouping [$i]] [$j];
						$extra = $extra_opt [$grouping [$i]] [$j];
						$query = "INSERT INTO `#__community_acl_function_access` (`func_id`, `grouping`, `option`, `name`, `value`, `isfrontend`, `isbackend`, `extra`) VALUES('{$cid}', '" . $gp . "', '{$com_option}','" . $name . "', '" . $value . "', '" . $front_end_cb [$i] . "', '" . $back_end_cb [$i] . "', '" . $extra . "');";
						$db->setQuery ( $query );
						$db->Query ();
						if ($db->getErrorNum ()) {
							JError::raiseError ( 500, $db->stderr () );
						}
					}
				$gp ++;
			}
		}
	}
	$query = "DELETE FROM `#__community_acl_content_actions` WHERE `func_id` = '{$cid}';";
	$db->setQuery ( $query );
	$db->Query ();
	if ($db->getErrorNum ()) {
		JError::raiseError ( 500, $db->stderr () );
	}
	$section_add_id = JRequest::getVar ( 'section_add_id', array (), '', 'array' );
	JArrayHelper::toInteger ( $section_add_id, array () );
	$section_edit_id = JRequest::getVar ( 'section_edit_id', array (), '', 'array' );
	JArrayHelper::toInteger ( $section_edit_id, array () );
	$section_publish_id = JRequest::getVar ( 'section_publish_id', array (), '', 'array' );
	JArrayHelper::toInteger ( $section_publish_id, array () );
	$category_add_id = JRequest::getVar ( 'category_add_id', array (), '', 'array' );
	JArrayHelper::toInteger ( $category_add_id, array () );
	$category_edit_id = JRequest::getVar ( 'category_edit_id', array (), '', 'array' );
	JArrayHelper::toInteger ( $category_edit_id, array () );
	$category_publish_id = JRequest::getVar ( 'category_publish_id', array (), '', 'array' );
	JArrayHelper::toInteger ( $category_publish_id, array () );
	$content_edit_id = JRequest::getVar ( 'content_edit_id', array (), '', 'array' );
	JArrayHelper::toInteger ( $content_edit_id, array () );
	$content_publish_id = JRequest::getVar ( 'content_publish_id', array (), '', 'array' );
	JArrayHelper::toInteger ( $content_publish_id, array () );
	if (is_array ( $section_add_id ) && count ( $section_add_id )) {
		foreach ( $section_add_id as $i => $id ) {
			if ($id > - 1) {
				$query = "INSERT INTO `#__community_acl_content_actions` (`func_id`, `item_type`, `action`, `item_id`) VALUES('{$cid}', 'section', 'add', '" . $id . "');";
				$db->setQuery ( $query );
				$db->Query ();
				if ($db->getErrorNum ()) {
					JError::raiseError ( 500, $db->stderr () );
				}
			}
		}
	}
	if (is_array ( $section_edit_id ) && count ( $section_edit_id )) {
		foreach ( $section_edit_id as $i => $id ) {
			if ($id > - 1) {
				$query = "INSERT INTO `#__community_acl_content_actions` (`func_id`, `item_type`, `action`, `item_id`) VALUES('{$cid}', 'section', 'edit', '" . $id . "');";
				$db->setQuery ( $query );
				$db->Query ();
				if ($db->getErrorNum ()) {
					JError::raiseError ( 500, $db->stderr () );
				}
			}
		}
	}
	if (is_array ( $section_publish_id ) && count ( $section_publish_id )) {
		foreach ( $section_publish_id as $i => $id ) {
			if ($id > - 1) {
				$query = "INSERT INTO `#__community_acl_content_actions` (`func_id`, `item_type`, `action`, `item_id`) VALUES('{$cid}', 'section', 'publish', '" . $id . "');";
				$db->setQuery ( $query );
				$db->Query ();
				if ($db->getErrorNum ()) {
					JError::raiseError ( 500, $db->stderr () );
				}
			}
		}
	}
	if (is_array ( $category_add_id ) && count ( $category_add_id )) {
		foreach ( $category_add_id as $i => $id ) {
			if ($id > - 1) {
				$query = "INSERT INTO `#__community_acl_content_actions` (`func_id`, `item_type`, `action`, `item_id`) VALUES('{$cid}', 'category', 'add', '" . $id . "');";
				$db->setQuery ( $query );
				$db->Query ();
				if ($db->getErrorNum ()) {
					JError::raiseError ( 500, $db->stderr () );
				}
			}
		}
	}
	if (is_array ( $category_edit_id ) && count ( $category_edit_id )) {
		foreach ( $category_edit_id as $i => $id ) {
			if ($id > - 1) {
				$query = "INSERT INTO `#__community_acl_content_actions` (`func_id`, `item_type`, `action`, `item_id`) VALUES('{$cid}', 'category', 'edit', '" . $id . "');";
				$db->setQuery ( $query );
				$db->Query ();
				if ($db->getErrorNum ()) {
					JError::raiseError ( 500, $db->stderr () );
				}
			}
		}
	}
	if (is_array ( $category_publish_id ) && count ( $category_publish_id )) {
		foreach ( $category_publish_id as $i => $id ) {
			if ($id > - 1) {
				$query = "INSERT INTO `#__community_acl_content_actions` (`func_id`, `item_type`, `action`, `item_id`) VALUES('{$cid}', 'category', 'publish', '" . $id . "');";
				$db->setQuery ( $query );
				$db->Query ();
				if ($db->getErrorNum ()) {
					JError::raiseError ( 500, $db->stderr () );
				}
			}
		}
	}
	if (is_array ( $content_edit_id ) && count ( $content_edit_id )) {
		foreach ( $content_edit_id as $i => $id ) {
			if ($id > - 1) {
				$query = "INSERT INTO `#__community_acl_content_actions` (`func_id`, `item_type`, `action`, `item_id`) VALUES('{$cid}', 'content', 'edit', '" . $id . "');";
				$db->setQuery ( $query );
				$db->Query ();
				if ($db->getErrorNum ()) {
					JError::raiseError ( 500, $db->stderr () );
				}
			}
		}
	}
	if (is_array ( $content_publish_id ) && count ( $content_publish_id )) {
		foreach ( $content_publish_id as $i => $id ) {
			if ($id > - 1) {
				$query = "INSERT INTO `#__community_acl_content_actions` (`func_id`, `item_type`, `action`, `item_id`) VALUES('{$cid}', 'content', 'publish', '" . $id . "');";
				$db->setQuery ( $query );
				$db->Query ();
				if ($db->getErrorNum ()) {
					JError::raiseError ( 500, $db->stderr () );
				}
			}
		}
	}
	$query = "SELECT `id` FROM  `#__community_acl_sites` WHERE `is_main` = '1'";
	$db->setQuery ( $query );
	$sid = ( int ) $db->loadResult ();
	if ($sid > 0) {
		$main = new CACL_site ( $db );
		$main->load ( $sid );
		$config = new CACL_config ( $main->_site_db );
		$config->load ();
		$tid = $cid;
		if ($config->synchronize && $config->cacl_grf) {
			$sync = new CACL_syncronize ( $main );
			$sync->syncronize ( $tid, 'access_func' );
		}
	}
	$msg = JText::_ ( 'Actions saved' );
	if ($task == 'apply_functions') {
		$mainframe->redirect ( 'index.php?option=com_community_acl&task=set_functions&cid[]=' . $cid, $msg );
	} else {
		$mainframe->redirect ( 'index.php?option=com_community_acl&task=' . $redirect, $msg );
	}
}
function setFunctions($id = 0) {
	global $mainframe, $option;
	if ($id == 0)
		return;
	$db = & JFactory::getDBO ();
	$lists = array ();
	$query = 'SELECT *' . ' FROM #__community_acl_functions' . ' WHERE id = ' . $id;
	$db->setQuery ( $query );
	$function = $db->loadObjectList ();
	$function = $function [0];
	$query = "SELECT `value` FROM `#__community_acl_config` WHERE `name` = 'default_action' ";
	$db->setQuery ( $query );
	$default_action = $db->loadResult ();
	if ($default_action == null)
		$default_action = 'deny';
	$query = 'SELECT `name`, `value`' . ' FROM `#__community_acl_function_access`' . ' WHERE `option` = \'###\' AND `func_id` = \'' . $id . '\'';
	$db->setQuery ( $query );
	$tmp = $db->loadObjectList ();
	$lists ['joomla_actions'] = array ();
	if (is_array ( $tmp ) && count ( $tmp ) > 0)
		foreach ( $tmp as $t ) {
			$lists ['joomla_actions'] [$t->name] = ( int ) $t->value;
		}
	$query = 'SELECT id, name AS title' . ' FROM #__components' . ' WHERE parent = 0' . ' ORDER BY iscore, name';
	$db->setQuery ( $query );
	$tmp = $db->loadObjectList ();
	$components = array ();
	foreach ( $tmp as $t ) {
		$components [] = array ('id' => $t->id, 'title' => $t->title );
	}
	$components [] = array ('id' => 'com_sections', 'title' => 'Section Manager' );
	$components [] = array ('id' => 'com_frontpage', 'title' => 'Front Page Manager' );
	$components [] = array ('id' => 'com_categories', 'title' => 'Category Manager' );
	$components [] = array ('id' => 'com_trash', 'title' => 'Trash Manager' );
	$lists ['componentid'] = JHTML::_ ( 'select.genericlist', $components, 'componentid', 'class="inputbox" size="1" ', 'id', 'title', 0 );
	$query = 'SELECT b.id AS c_id , b.name AS title, a.*' . ' FROM #__community_acl_function_access AS a' . ' LEFT JOIN #__components AS b ON b.option = a.option' . " WHERE a.func_id = '" . $id . "'  AND a.option <> '###' AND (b.parent = 0 OR a.option IN ('com_sections', 'com_frontpage', 'com_categories', 'com_trash'))" . ' ORDER BY a.id';
	$db->setQuery ( $query );
	$tmp = $db->loadObjectList ();
	for($i = 0, $n = count ( $tmp ); $i < $n; $i ++) {
		if ($tmp [$i]->option == 'com_sections') {
			$tmp [$i]->c_id = 'com_sections';
			$tmp [$i]->title = 'Section Manager';
		} elseif ($tmp [$i]->option == 'com_frontpage') {
			$tmp [$i]->c_id = 'com_frontpage';
			$tmp [$i]->title = 'Front Page Manager';
		} elseif ($tmp [$i]->option == 'com_categories') {
			$tmp [$i]->c_id = 'com_categories';
			$tmp [$i]->title = 'Category Manager';
		} elseif ($tmp [$i]->option == 'com_trash') {
			$tmp [$i]->c_id = 'com_trash';
			$tmp [$i]->title = 'Trash Manager';
		}
	}
	$query = 'SELECT grouping AS n' . ' FROM #__community_acl_function_access ' . ' WHERE func_id = \'' . $id . '\' AND `option` <> \'###\'  ' . ' GROUP BY grouping' . ' ORDER BY grouping';
	$db->setQuery ( $query );
	$grouping = $db->loadObjectList ();
	$lists ['functions'] = array ();
	if (is_array ( $grouping ) && count ( $grouping )) {
		foreach ( $grouping as $g ) {
			$name = array ();
			$value = array ();
			$extra = array ();
			$row = null;
			foreach ( $tmp as $t ) {
				if ($t->grouping == $g->n) {
					$name [] = $t->name;
					$value [] = $t->value;
					$extra [] = ($t->extra == '1' ? ' (' . ($default_action == 'deny' ? JText::_ ( 'Allow all values except this value' ) : JText::_ ( 'Only allow this value' )) . ')' : '');
					$row = $t;
				}
			}
			$row->name = $name;
			$row->value = $value;
			$row->extra = $extra;
			if ($row !== null)
				$lists ['functions'] [] = $row;
		}
	}
	$query = 'SELECT s.id, s.title' . ' FROM #__sections AS s' . ' ORDER BY s.ordering';
	$db->setQuery ( $query );
	$sections [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'Uncategorized' ), 'id', 'title' );
	$sections = @array_merge ( $sections, $db->loadObjectList () );
	$lists ['sectionid'] = JHTML::_ ( 'select.genericlist', $sections, 'sectionid', 'class="inputbox" size="10" multiple="multiple" style="min-width:100px;max-width:200px;" ', 'id', 'title', 0 );
	$section_list = array ();
	foreach ( $sections as $section ) {
		$section_list [] = ( int ) $section->id;
	}
	$section_list = implode ( '\', \'', $section_list );
	$query = 'SELECT a.id, a.title, a.section, b.title AS stitle' . ' FROM `#__categories` AS a LEFT JOIN `#__sections` AS b ON b.id = a.section ' . ' WHERE section IN ( \'' . $section_list . '\' )' . ' ORDER BY b.ordering, a.ordering';
	$db->setQuery ( $query );
	$cat_list_tmp = $db->loadObjectList ();
	$cat_list = array ();
	// Uncategorized category mapped to uncategorized section	$uncat = new stdClass ();
	$uncat->id = 0;
	$uncat->title = JText::_ ( 'Uncategorized' );
	$uncat->section = 0;
	$cat_list [] = $uncat;
	$first_sec = - 1;
	foreach ( $cat_list_tmp as $cl_tmp ) {
		if ($first_sec != $cl_tmp->section) {
			if ($first_sec != - 1) {
				$tmp = new stdClass ();
				$tmp->id = '</OPTGROUP>';
				$tmp->title = $cl_tmp->stitle;
				$tmp->section = - 1;
				$cat_list [] = $tmp;
			}
			$tmp = new stdClass ();
			$tmp->id = '<OPTGROUP>';
			$tmp->title = $cl_tmp->stitle;
			$tmp->section = - 1;
			$cat_list [] = $tmp;
			$first_sec = $cl_tmp->section;
		}
		$tmp = new stdClass ();
		$tmp->id = $cl_tmp->id;
		$tmp->title = $cl_tmp->title;
		$tmp->section = $cl_tmp->section;
		$cat_list [] = $tmp;
	}
	if ($first_sec != - 1) {
		$tmp = new stdClass ();
		$tmp->id = '</OPTGROUP>';
		$tmp->title = '';
		$tmp->section = - 1;
		$cat_list [] = $tmp;
	}
	$lists ['catid'] = JHTML::_ ( 'select.genericlist', $cat_list, 'catid', 'class="inputbox" size="10" multiple="multiple" style="min-width:100px;max-width:200px;" ', 'id', 'title', 0 );
	$query = 'SELECT a.id, a.title, a.sectionid, a.catid, b.title AS stitle, c.title AS ctitle ' . ' FROM `#__content` AS a LEFT JOIN `#__sections` AS b ON b.id = a.sectionid LEFT JOIN `#__categories` AS c ON c.id = a.catid ' . ' ORDER BY a.sectionid, a.catid, a.ordering, a.title ';
	$db->setQuery ( $query );
	$con_list_tmp = $db->loadObjectList ();
	$con_list = array ();
	$first_cat = - 1;
	foreach ( $con_list_tmp as $cl_tmp ) {
		if ($first_cat != $cl_tmp->catid) {
			if ($first_cat != - 1) {
				$tmp = new stdClass ();
				$tmp->id = '</OPTGROUP>';
				$tmp->title = $cl_tmp->stitle . ' / ' . $cl_tmp->ctitle;
				$tmp->sectionid = - 1;
				$tmp->catid = - 1;
				$con_list [] = $tmp;
			}
			$tmp = new stdClass ();
			$tmp->id = '<OPTGROUP>';
			if ($cl_tmp->catid == 0)
				$tmp->title = JText::_ ( 'Uncategorized' );
			else
				$tmp->title = $cl_tmp->stitle . ' / ' . $cl_tmp->ctitle;
			$tmp->sectionid = - 1;
			$tmp->catid = - 1;
			$con_list [] = $tmp;
			$first_cat = $cl_tmp->catid;
		}
		$tmp = new stdClass ();
		$tmp->id = $cl_tmp->id;
		$tmp->title = $cl_tmp->title;
		$tmp->sectionid = $cl_tmp->sectionid;
		$tmp->catid = $cl_tmp->catid;
		$con_list [] = $tmp;
	}
	if ($first_cat != - 1) {
		$tmp = new stdClass ();
		$tmp->id = '</OPTGROUP>';
		$tmp->title = '';
		$tmp->sectionid = - 1;
		$tmp->catid = - 1;
		$con_list [] = $tmp;
	}
	$lists ['contentid'] = JHTML::_ ( 'select.genericlist', $con_list, 'contentid', 'class="inputbox" size="10" multiple="multiple"  style="min-width:100px;max-width:200px;" ', 'id', 'title', 0 );
	$query = 'SELECT a.item_id AS value, b.title' . ' FROM #__community_acl_content_actions AS a' . ' LEFT JOIN #__sections AS b ON b.id = a.item_id' . ' WHERE a.item_type = \'section\' AND a.action = \'add\'' . ' AND a.func_id = ' . $id . ' ORDER BY a.id';
	$db->setQuery ( $query );
	$lists ['sections_add'] = $db->loadObjectList ();
	$query = 'SELECT a.item_id AS value, b.title' . ' FROM #__community_acl_content_actions AS a' . ' LEFT JOIN #__sections AS b ON b.id = a.item_id' . ' WHERE a.item_type = \'section\' AND a.action = \'edit\'' . ' AND a.func_id = ' . $id . ' ORDER BY a.id';
	$db->setQuery ( $query );
	$lists ['sections_edit'] = $db->loadObjectList ();
	$query = 'SELECT a.item_id AS value, b.title' . ' FROM #__community_acl_content_actions AS a' . ' LEFT JOIN #__sections AS b ON b.id = a.item_id' . ' WHERE a.item_type = \'section\' AND a.action = \'publish\'' . ' AND a.func_id = ' . $id . ' ORDER BY a.id';
	$db->setQuery ( $query );
	$lists ['sections_publish'] = $db->loadObjectList ();
	$query = 'SELECT a.item_id AS value, b.title' . ' FROM #__community_acl_content_actions AS a' . ' LEFT JOIN #__categories AS b ON b.id = a.item_id' . ' WHERE a.item_type = \'category\' AND a.action = \'add\'' . ' AND a.func_id = ' . $id . ' ORDER BY a.id';
	$db->setQuery ( $query );
	$lists ['categories_add'] = $db->loadObjectList ();
	$query = 'SELECT a.item_id AS value, b.title' . ' FROM #__community_acl_content_actions AS a' . ' LEFT JOIN #__categories AS b ON b.id = a.item_id' . ' WHERE a.item_type = \'category\' AND a.action = \'edit\'' . ' AND a.func_id = ' . $id . ' ORDER BY a.id';
	$db->setQuery ( $query );
	$lists ['categories_edit'] = $db->loadObjectList ();
	$query = 'SELECT a.item_id AS value, b.title' . ' FROM #__community_acl_content_actions AS a' . ' LEFT JOIN #__categories AS b ON b.id = a.item_id' . ' WHERE a.item_type = \'category\' AND a.action = \'publish\'' . ' AND a.func_id = ' . $id . ' ORDER BY a.id';
	$db->setQuery ( $query );
	$lists ['categories_publish'] = $db->loadObjectList ();
	$query = 'SELECT a.item_id AS value, b.title' . ' FROM #__community_acl_content_actions AS a' . ' LEFT JOIN #__content AS b ON b.id = a.item_id' . ' WHERE a.item_type = \'content\' AND a.action = \'add\'' . ' AND a.func_id = ' . $id . ' ORDER BY a.id';
	$db->setQuery ( $query );
	$lists ['contents_add'] = $db->loadObjectList ();
	$query = 'SELECT a.item_id AS value, b.title' . ' FROM #__community_acl_content_actions AS a' . ' LEFT JOIN #__content AS b ON b.id = a.item_id' . ' WHERE a.item_type = \'content\' AND a.action = \'edit\'' . ' AND a.func_id = ' . $id . ' ORDER BY a.id';
	$db->setQuery ( $query );
	$lists ['contents_edit'] = $db->loadObjectList ();
	$query = 'SELECT a.item_id AS value, b.title' . ' FROM #__community_acl_content_actions AS a' . ' LEFT JOIN #__content AS b ON b.id = a.item_id' . ' WHERE a.item_type = \'content\' AND a.action = \'publish\'' . ' AND a.func_id = ' . $id . ' ORDER BY a.id';
	$db->setQuery ( $query );
	$lists ['contents_publish'] = $db->loadObjectList ();
	cacl_html::set_functions ( $id, $lists, $option );
}
function saveAccess() {
	global $mainframe, $option;
	$db = & JFactory::getDBO ();
	$cid = ( int ) JRequest::getCmd ( 'id' );
	$task = JRequest::getCmd ( 'task' );
	$mode = JRequest::getCmd ( 'mode' );
	$redirect = JRequest::getCmd ( 'redirect' );
	$post = JRequest::get ( 'post' );

	$article_submission [1] = $post ['show_frontpage'];
	$article_submission [2] = $post ['show_metadata'];
	$article_submission [3] = $post ['show_start_publishing'];
	$article_submission [4] = $post ['show_finish_publishing'];
	$article_submission [5] = $post ['show_alias'];
	$article_submission [6] = $post ['show_access'];
	$redirect_front = JRequest::getVar ( 'frontend_redirect' );
	$redirect_admin = JRequest::getVar ( 'backend_redirect' );
	if ($mode == 'role_id') {
		$group_id = 0;
		$role_id = $cid;
	} else {
		$group_id = $cid;
		$role_id = 0;
	}
	if ($role_id != 0) {
		$query = "SELECT role_id FROM `#__community_acl_submit_form_role_level` WHERE role_id = '{$role_id}' ";
		$db->setQuery ( $query );
		//$submit_frm_restricted = $db->loadResult();		if ($db->loadResult ()) {
			#update Article Submission			for($i = 1; $i < 7; $i ++) {
				$query = "UPDATE `#__community_acl_submit_form_role_level` " . " SET `choices` = " . $article_submission [$i] . " WHERE `id` = " . $i . " AND `role_id` = " . $role_id;
				$db->setQuery ( $query );
				$db->query ();
			}
		} else {
			#insert new record			for($i = 1; $i < 7; $i ++) {
				$query = "INSERT `#__community_acl_submit_form_role_level` " . "	(`id`, `role_id`, `desc`, `choices` ) VALUES " . "  ( '{$i}', '{$role_id}', '', '{$article_submission[$i]}') ";
				$db->setQuery ( $query );
				$db->query ();
			}
		}
		$query = "UPDATE `#__community_acl_roles` SET redirect_FRONT = '{$redirect_front}', redirect_ADMIN = '{$redirect_admin}' WHERE id = '{$role_id}';";
		$db->setQuery ( $query );
		$db->Query ();
	} elseif ($group_id != 0) {
		$query = "SELECT group_id FROM `#__community_acl_submit_form_group_level` WHERE group_id = '{$group_id}' ";
		$db->setQuery ( $query );
		//$submit_frm_restricted = $db->loadResult();		if ($db->loadResult ()) {
			#update Article Submission			for($i = 1; $i < 7; $i ++) {
				$query = "UPDATE `#__community_acl_submit_form_group_level` " . " SET `choices` = " . $article_submission [$i] . " WHERE `id` = " . $i . " AND `group_id` = " . $group_id;
				$db->setQuery ( $query );
				$db->query ();
			}
		} else {
			#insert new record			for($i = 1; $i < 7; $i ++) {
				$query = "INSERT `#__community_acl_submit_form_group_level` " . "	(`id`, `group_id`, `desc`, `choices` ) VALUES " . "  ( '{$i}', '{$group_id}', '', '{$article_submission[$i]}') ";
				$db->setQuery ( $query );
				$db->query ();
			}
		}
		$query = "UPDATE `#__community_acl_groups` SET redirect_URL_FRONT = '{$redirect_front}', redirect_URL_ADMIN = '{$redirect_admin}' WHERE id = '{$group_id}';";
		$db->setQuery ( $query );
		$db->Query ();
	}
	$section_id = JRequest::getVar ( 'section_id', array (), '', 'array' );
	JArrayHelper::toInteger ( $section_id, array () );
	$cat_id = JRequest::getVar ( 'cat_id', array (), '', 'array' );
	JArrayHelper::toInteger ( $cat_id, array () );
	$content_id = JRequest::getVar ( 'content_id', array (), '', 'array' );
	JArrayHelper::toInteger ( $content_id, array () );
	$component_id = JRequest::getVar ( 'component_id', array (), '', 'array' );
	//JArrayHelper::toInteger($component_id, array());	$menu_id = JRequest::getVar ( 'menu_id', array (), '', 'array' );
	JArrayHelper::toInteger ( $menu_id, array () );
	$front_end_cb = JRequest::getVar ( 'front_end_cb', array (), '', 'array' );
	JArrayHelper::toInteger ( $front_end_cb, array () );
	$back_end_cb = JRequest::getVar ( 'back_end_cb', array (), '', 'array' );
	JArrayHelper::toInteger ( $back_end_cb, array () );
	$module_id = JRequest::getVar ( 'module_id', array (), '', 'array' );
	JArrayHelper::toInteger ( $module_id, array () );
	$query = "DELETE FROM `#__community_acl_access` WHERE `group_id` = '{$group_id}' AND `role_id` = '{$role_id}';";
	$db->setQuery ( $query );
	$db->Query ();
	if ($db->getErrorNum ()) {
		JError::raiseError ( 500, $db->stderr () );
	}
	if (is_array ( $section_id ) && count ( $section_id )) {
		foreach ( $section_id as $id ) {
			if ($id > - 1) {
				$query = "INSERT INTO `#__community_acl_access` (`group_id`, `role_id`, `option`, `name`, `value`, `isfrontend`, `isbackend`) VALUES('{$group_id}','{$role_id}','com_sections','cid','{$id}', 1, 1);";
				$db->setQuery ( $query );
				$db->Query ();
				if ($db->getErrorNum ()) {
					JError::raiseError ( 500, $db->stderr () );
				}
			}
		}
	}
	if (is_array ( $cat_id ) && count ( $cat_id )) {
		foreach ( $cat_id as $id ) {
			if ($id > - 1) {
				$query = "INSERT INTO `#__community_acl_access` (`group_id`, `role_id`, `option`, `name`, `value`, `isfrontend`, `isbackend`) VALUES('{$group_id}','{$role_id}','com_categories','cid','{$id}', 1, 1);";
				$db->setQuery ( $query );
				$db->Query ();
				if ($db->getErrorNum ()) {
					JError::raiseError ( 500, $db->stderr () );
				}
			}
		}
	}
	if (is_array ( $content_id ) && count ( $content_id )) {
		foreach ( $content_id as $id ) {
			if ($id > 0) {
				$query = "INSERT INTO `#__community_acl_access` (`group_id`, `role_id`, `option`, `name`, `value`, `isfrontend`, `isbackend`) VALUES('{$group_id}','{$role_id}','com_content','cid','{$id}', 1, 1);";
				$db->setQuery ( $query );
				$db->Query ();
				if ($db->getErrorNum ()) {
					JError::raiseError ( 500, $db->stderr () );
				}
			}
		}
	}
	if (is_array ( $component_id ) && count ( $component_id )) {
		foreach ( $component_id as $i => $id ) {
			if ($id > 0 || $id == 'com_sections' || $id == 'com_frontpage' || $id == 'com_categories' || $id == 'com_trash') {
				$query = "SELECT `option` FROM `#__components` WHERE `id` = '{$id}';";
				$db->setQuery ( $query );
				$com_option = $db->loadResult ();
				if ($id == 'com_sections' || $id == 'com_frontpage' || $id == 'com_categories' || $id == 'com_trash')
					$com_option = $id;
				$query = "INSERT INTO `#__community_acl_access` (`group_id`, `role_id`, `option`, `name`, `value`, `isfrontend`, `isbackend`) VALUES('{$group_id}','{$role_id}','{$com_option}','###','{$id}', '" . $front_end_cb [$i] . "', '" . $back_end_cb [$i] . "');";
				$db->setQuery ( $query );
				$db->Query ();
				if ($db->getErrorNum ()) {
					JError::raiseError ( 500, $db->stderr () );
				}
			}
		}
	}
	if (is_array ( $menu_id ) && count ( $menu_id )) {
		foreach ( $menu_id as $i => $id ) {
			if ($id > 0) {
				$query = "INSERT INTO `#__community_acl_access` (`group_id`, `role_id`, `option`, `name`, `value`, `isfrontend`, `isbackend`) VALUES('{$group_id}','{$role_id}','menu','###','{$id}', '1', '0');";
				$db->setQuery ( $query );
				$db->Query ();
				if ($db->getErrorNum ()) {
					JError::raiseError ( 500, $db->stderr () );
				}
			}
		}
	}
	if (is_array ( $module_id ) && count ( $module_id )) {
		foreach ( $module_id as $id ) {
			if ($id > 0) {
				$query = "INSERT INTO `#__community_acl_access` (`group_id`, `role_id`, `option`, `name`, `value`) VALUES('{$group_id}','{$role_id}','module','@@@','{$id}');";
				$db->setQuery ( $query );
				$db->Query ();
				if ($db->getErrorNum ()) {
					JError::raiseError ( 500, $db->stderr () );
				}
			}
		}
	}
	// added 3rd party plugin support -BUR 1/18/2011	if (JPluginHelper::isEnabled ( 'system', 'cacl_docman' )) {
		plgSystemCacl_docman::saveAccess ( $db, JRequest::getVar ( 'docmanId' ), $group_id, $role_id );
	}
	// added 3rd party plugin support	//adam added 3rd party plugin support	if (JPluginHelper::isEnabled ( 'system', 'cacl_joomsocial' )) {
		plgSystemCacl_joomsocial::saveAccess ( $db, JRequest::getVar ( 'jsmenu_id' ), $group_id, $role_id );
	}
	//end adam added 3rd party plugin support	$query = "SELECT `id` FROM  `#__community_acl_sites` WHERE `is_main` = '1'";
	$db->setQuery ( $query );
	$sid = ( int ) $db->loadResult ();
	if ($sid > 0) {
		$main = new CACL_site ( $db );
		$main->load ( $sid );
		$config = new CACL_config ( $main->_site_db );
		$config->load ();
		if ($config->synchronize && $config->cacl_grf) {
			$tid = array ('group_id' => $group_id, 'role_id' => $role_id );
			$sync = new CACL_syncronize ( $main );
			$sync->syncronize ( $tid, 'access' );
		}
	}
	$msg = JText::_ ( 'Access saved' );
	if ($task == 'apply_access') {
		$mainframe->redirect ( 'index.php?option=com_community_acl&mode=' . $mode . '&task=show_access&cid[]=' . $cid, $msg );
	} else {
		$mainframe->redirect ( 'index.php?option=com_community_acl&task=' . $redirect, $msg );
	}
}
function showAccess($group_id = 0, $role_id = 0) {
	global $mainframe, $option;
	$db = & JFactory::getDBO ();
	$lists = array ();
	$query = 'SELECT a.value, b.title, b.published' . ' FROM #__community_acl_access AS a' . ' LEFT JOIN #__sections AS b ON b.id = a.value' . ' WHERE a.option = \'com_sections\' AND a.name = \'cid\'' . ' AND a.group_id = ' . $group_id . ' AND a.role_id = ' . $role_id . ' ORDER BY a.id';
	$db->setQuery ( $query );
	$lists ['sections'] = $db->loadObjectList ();
	$query = 'SELECT b.id, b.title, b.published ' . ' FROM `#__sections` AS b ';
	$db->setQuery ( $query );
	$lists ['sections_arr'] = $db->loadObjectList ();
	$query = 'SELECT a.value, b.title, b.published, c.title AS section_name' . ' FROM #__community_acl_access AS a' . ' LEFT JOIN #__categories AS b ON b.id = a.value' . ' LEFT JOIN #__sections AS c ON b.section = c.id' . ' WHERE a.option = \'com_categories\' AND a.name = \'cid\'' . ' AND a.group_id = ' . $group_id . ' AND a.role_id = ' . $role_id . ' ORDER BY b.section, a.id';
	$db->setQuery ( $query );
	$lists ['categories'] = $db->loadObjectList ();
	$query = 'SELECT b.id, b.title, b.published, c.title AS section_name' . ' FROM #__categories AS b ' . ' LEFT JOIN #__sections AS c ON b.section = c.id';
	$db->setQuery ( $query );
	$lists ['categories_arr'] = $db->loadObjectList ();
	$query = 'SELECT a.value, b.title, b.state AS published, c.title AS section_name, d.title AS cat_name, e.name AS author_name' . ' FROM #__community_acl_access AS a' . ' LEFT JOIN #__content AS b ON b.id = a.value' . ' LEFT JOIN #__sections AS c ON b.sectionid = c.id' . ' LEFT JOIN #__categories AS d ON b.catid = d.id' . ' LEFT JOIN #__users AS e ON b.created_by = e.id' . ' WHERE a.option = \'com_content\' AND a.name = \'cid\'' . ' AND a.group_id = ' . $group_id . ' AND a.role_id = ' . $role_id . ' ORDER BY a.id';
	$db->setQuery ( $query );
	$lists ['contents'] = $db->loadObjectList ();
	$query = 'SELECT b.id, b.title, b.state AS published, c.title AS section_name, d.title AS cat_name, e.name AS author_name' . ' FROM #__content AS b ' . ' LEFT JOIN #__sections AS c ON b.sectionid = c.id' . ' LEFT JOIN #__categories AS d ON b.catid = d.id' . ' LEFT JOIN #__users AS e ON b.created_by = e.id';
	$db->setQuery ( $query );
	$lists ['contents_arr'] = $db->loadObjectList ();
	$query = 'SELECT b.id AS value , b.name AS title, a.isfrontend, a.isbackend, a.option' . ' FROM #__community_acl_access AS a' . ' LEFT JOIN #__components AS b ON b.id = a.value' . ' WHERE a.name = \'###\' AND a.option <> \'menu\' AND (b.parent = 0 OR a.option IN (\'com_sections\', \'com_frontpage\', \'com_categories\', \'com_trash\' )) ' . ' AND a.group_id = ' . $group_id . ' AND a.role_id = ' . $role_id . ' ORDER BY a.id';
	$db->setQuery ( $query );
	$lists ['components'] = $db->loadObjectList ();
	for($i = 0, $n = count ( $lists ['components'] ); $i < $n; $i ++) {
		if ($lists ['components'] [$i]->option == 'com_sections') {
			$lists ['components'] [$i]->value = 'com_sections';
			$lists ['components'] [$i]->title = 'Section Manager';
		} elseif ($lists ['components'] [$i]->option == 'com_frontpage') {
			$lists ['components'] [$i]->value = 'com_frontpage';
			$lists ['components'] [$i]->title = 'Front Page Manager';
		} elseif ($lists ['components'] [$i]->option == 'com_categories') {
			$lists ['components'] [$i]->value = 'com_categories';
			$lists ['components'] [$i]->title = 'Category Manager';
		} elseif ($lists ['components'] [$i]->option == 'com_trash') {
			$lists ['components'] [$i]->value = 'com_trash';
			$lists ['components'] [$i]->title = 'Trash Manager';
		}
	}
	$query = 'SELECT b.*, b.id AS value , b.name AS mtitle, a.isfrontend, a.isbackend, d.name AS parent_name, c.title AS menu_name' . ' FROM #__community_acl_access AS a' . ' LEFT JOIN #__menu AS b ON b.id = a.value' . ' LEFT JOIN #__menu_types AS c ON c.menutype = b.menutype' . ' LEFT JOIN #__menu AS d ON d.id = b.parent' . ' WHERE a.name = \'###\' AND a.option = \'menu\'' . ' AND a.group_id = ' . $group_id . ' AND a.role_id = ' . $role_id . ' ORDER BY c.menutype, b.parent, b.ordering';
	$db->setQuery ( $query );
	$lists ['menus'] = $db->loadObjectList ();
	# - Kobby Sam - Search for the Redirect link	# - Get the mode to verify if its a role/group	$mode = JRequest::getVar ( 'mode' );
	$id = JRequest::getVar ( 'cid' );
	$id = $id [0];
	if ($mode == 'role_id') {
		# - Get the front_redirect and backend redirect from DB		$query = 'SELECT  redirect_FRONT, redirect_ADMIN FROM #__community_acl_roles WHERE id = ' . $id;
		$db->setQuery ( $query );
		$result = $db->loadObjectList ();
		$query = 'SELECT choices as choice ' . ' FROM `#__community_acl_submit_form_role_level`' . ' WHERE role_id =  ' . $id . ' ORDER BY id ASC';
		$db->setQuery ( $query );
		$article_submission = $db->loadResultArray ();
	} elseif ($mode == 'group_id') {
		# - Get the front_redirect and backend redirect from DB		$query = 'SELECT redirect_URL_FRONT AS redirect_FRONT, redirect_URL_ADMIN  AS redirect_ADMIN FROM #__community_acl_groups WHERE id = ' . $id;
		$db->setQuery ( $query );
		$result = $db->loadObjectList ();
		$query = 'SELECT choices as choice ' . ' FROM `#__community_acl_submit_form_group_level`' . ' WHERE group_id =  ' . $id . ' ORDER BY id ASC';
		$db->setQuery ( $query );
		$article_submission = $db->loadResultArray ();
	}
	//print_R($result);	if ($result) {
		$lists ['frontend_redirect'] = $result [0]->redirect_FRONT;
		$lists ['backend_redirect'] = $result [0]->redirect_ADMIN;
	}
	//print_r($article_submission);	if ($article_submission)
		$lists ['article_submissions'] = $article_submission;
		/* * /
	Kobby Sam-This caused a bug.
	When a Main menu was taken off a Forbidden List,
	the Sub menu was taken off the Forbidden List too.

	$children = array();
	if ( $lists['menus'] )
	{
		// first pass - collect children
		foreach ( $lists['menus'] as $v )
		{
			$pt 	= $v->parent;
			$list 	= @$children[$pt] ? $children[$pt] : array();
			array_push( $list, $v );
			$children[$pt] = $list;
		}
	}
	$lists['menus'] = JHTML::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 1 );
	/* */
	$query = 'SELECT b.*, b.id AS value, b.name AS title, d.name AS parent_name, c.title AS menu_name ' . ' FROM `#__menu` AS b ' . ' LEFT JOIN `#__menu_types` AS c ON c.menutype = b.menutype ' . ' LEFT JOIN `#__menu` AS d ON d.id = b.parent ' . ' WHERE b.published <> -2 ' . ' ORDER BY c.menutype, b.parent, b.ordering';
	$db->setQuery ( $query );
	$lists ['menus_arr'] = $db->loadObjectList ();
	$children = array ();
	if ($lists ['menus_arr']) {
		// first pass - collect children		foreach ( $lists ['menus_arr'] as $v ) {
			$pt = $v->parent;
			$list = @$children [$pt] ? $children [$pt] : array ();
			array_push ( $list, $v );
			$children [$pt] = $list;
		}
	}
	$lists ['menus_arr'] = JHTML::_ ( 'menu.treerecurse', 0, '', array (), $children, 9999, 0, 1 );
	$query = 'SELECT b.id AS value , b.title, b.position, b.module, b.published' . ' FROM #__community_acl_access AS a' . ' LEFT JOIN #__modules AS b ON b.id = a.value' . ' WHERE a.name = \'@@@\' ' . ' AND a.group_id = ' . $group_id . ' AND a.role_id = ' . $role_id . ' ORDER BY a.id';
	$db->setQuery ( $query );
	$lists ['modules'] = $db->loadObjectList ();
	$query = 'SELECT `id`, `title`, `position`, `module`, `published`' . ' FROM `#__modules`' . ' WHERE `client_id` = 0' . ' ORDER BY `title`';
	$db->setQuery ( $query );
	$lists ['modules_arr'] = $db->loadObjectList ();
	$query = 'SELECT s.id, s.title' . ' FROM #__sections AS s' . ' ORDER BY s.ordering';
	$db->setQuery ( $query );
	$sections [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'Uncategorized' ), 'id', 'title' );
	$sections = @array_merge ( $sections, $db->loadObjectList () );
	$lists ['sectionid'] = JHTML::_ ( 'select.genericlist', $sections, 'sectionid', 'class="inputbox" size="10" multiple="multiple" style="min-width:100px;max-width:200px;" ', 'id', 'title', 0 );
	$section_list = array ();
	foreach ( $sections as $section ) {
		$section_list [] = ( int ) $section->id;
	}
	$section_list = implode ( '\', \'', $section_list );
	$query = 'SELECT a.id, a.title, a.section, b.title AS stitle' . ' FROM `#__categories` AS a LEFT JOIN `#__sections` AS b ON b.id = a.section ' . ' WHERE section IN ( \'' . $section_list . '\' )' . ' ORDER BY b.ordering, a.ordering';
	$db->setQuery ( $query );
	$cat_list_tmp = $db->loadObjectList ();
	$cat_list = array ();
	// Uncategorized category mapped to uncategorized section	$uncat = new stdClass ();
	$uncat->id = 0;
	$uncat->title = JText::_ ( 'Uncategorized' );
	$uncat->section = 0;
	$cat_list [] = $uncat;
	$first_sec = - 1;
	foreach ( $cat_list_tmp as $cl_tmp ) {
		if ($first_sec != $cl_tmp->section) {
			if ($first_sec != - 1) {
				$tmp = new stdClass ();
				$tmp->id = '</OPTGROUP>';
				$tmp->title = $cl_tmp->stitle;
				$tmp->section = - 1;
				$cat_list [] = $tmp;
			}
			$tmp = new stdClass ();
			$tmp->id = '<OPTGROUP>';
			$tmp->title = $cl_tmp->stitle;
			$tmp->section = - 1;
			$cat_list [] = $tmp;
			$first_sec = $cl_tmp->section;
		}
		$tmp = new stdClass ();
		$tmp->id = $cl_tmp->id;
		$tmp->title = $cl_tmp->title;
		$tmp->section = $cl_tmp->section;
		$cat_list [] = $tmp;
	}
	if ($first_sec != - 1) {
		$tmp = new stdClass ();
		$tmp->id = '</OPTGROUP>';
		$tmp->title = '';
		$tmp->section = - 1;
		$cat_list [] = $tmp;
	}
	$lists ['catid'] = JHTML::_ ( 'select.genericlist', $cat_list, 'catid', 'class="inputbox" size="10" multiple="multiple" style="min-width:100px;max-width:200px;" ', 'id', 'title', 0 );
	$query = 'SELECT a.id, a.title, a.sectionid, a.catid, b.title AS stitle, c.title AS ctitle ' . ' FROM `#__content` AS a LEFT JOIN `#__sections` AS b ON b.id = a.sectionid LEFT JOIN `#__categories` AS c ON c.id = a.catid ' . ' ORDER BY a.sectionid, a.catid, a.ordering, a.title ';
	$db->setQuery ( $query );
	$con_list_tmp = $db->loadObjectList ();
	$con_list = array ();
	$first_cat = - 1;
	foreach ( $con_list_tmp as $cl_tmp ) {
		if ($first_cat != $cl_tmp->catid) {
			if ($first_cat != - 1) {
				$tmp = new stdClass ();
				$tmp->id = '</OPTGROUP>';
				$tmp->title = $cl_tmp->stitle . ' / ' . $cl_tmp->ctitle;
				$tmp->sectionid = - 1;
				$tmp->catid = - 1;
				$con_list [] = $tmp;
			}
			$tmp = new stdClass ();
			$tmp->id = '<OPTGROUP>';
			if ($cl_tmp->catid == 0)
				$tmp->title = JText::_ ( 'Uncategorized' );
			else
				$tmp->title = $cl_tmp->stitle . ' / ' . $cl_tmp->ctitle;
			$tmp->sectionid = - 1;
			$tmp->catid = - 1;
			$con_list [] = $tmp;
			$first_cat = $cl_tmp->catid;
		}
		$tmp = new stdClass ();
		$tmp->id = $cl_tmp->id;
		$tmp->title = $cl_tmp->title;
		$tmp->sectionid = $cl_tmp->sectionid;
		$tmp->catid = $cl_tmp->catid;
		$con_list [] = $tmp;
	}
	if ($first_cat != - 1) {
		$tmp = new stdClass ();
		$tmp->id = '</OPTGROUP>';
		$tmp->title = '';
		$tmp->sectionid = - 1;
		$tmp->catid = - 1;
		$con_list [] = $tmp;
	}
	$lists ['contentid'] = JHTML::_ ( 'select.genericlist', $con_list, 'contentid', 'class="inputbox" size="10" multiple="multiple"  style="min-width:100px;max-width:200px;" ', 'id', 'title', 0 );
	// get a list of the menu items	// excluding the current menu item and its child elements	$query = 'SELECT m.*, m.name AS title, b.title AS mtitle' . ' FROM #__menu m LEFT JOIN `#__menu_types` AS b ON b.menutype = m.menutype ' . ' WHERE m.published != -2 ' . ' ORDER BY m.menutype, m.parent, m.ordering';
	$db->setQuery ( $query );
	$mitems = $db->loadObjectList ();
	//print_r($query);die();	// establish the hierarchy of the menu	$children = array ();
	if ($mitems) {
		// first pass - collect children		foreach ( $mitems as $v ) {
			$pt = $v->parent;
			$list = @$children [$pt] ? $children [$pt] : array ();
			array_push ( $list, $v );
			$children [$pt] = $list;
		}
	}
	// second pass - get an indent list of the items	$menu_list_tmp = JHTML::_ ( 'menu.treerecurse', 0, '', array (), $children, 9999, 0, 0 );
	$menu_list = array ();
	$first_menu = - 1;
	foreach ( $menu_list_tmp as $cl_tmp ) {
		if ($first_menu != $cl_tmp->mtitle) {
			if ($first_menu != - 1) {
				$tmp = new stdClass ();
				$tmp->id = '</OPTGROUP>';
				$tmp->title = $cl_tmp->mtitle;
				$menu_list [] = $tmp;
			}
			$tmp = new stdClass ();
			$tmp->id = '<OPTGROUP>';
			$tmp->title = $cl_tmp->mtitle;
			$menu_list [] = $tmp;
			$first_menu = $cl_tmp->mtitle;
		}
		$tmp = new stdClass ();
		$tmp->id = $cl_tmp->id;
		$tmp->title = $cl_tmp->treename/*title*/;
		$menu_list [] = $tmp;
	}
	if ($first_menu != - 1) {
		$tmp = new stdClass ();
		$tmp->id = '</OPTGROUP>';
		$tmp->title = '';
		$menu_list [] = $tmp;
	}
	$lists ['menuid'] = JHTML::_ ( 'select.genericlist', $menu_list, 'menuid', 'class="inputbox" size="10" multiple="multiple" style="min-width:100px;max-width:200px;" ', 'id', 'title', 0 );
	$query = 'SELECT id, name AS title' . ' FROM #__components' . ' WHERE parent = 0' . ' ORDER BY iscore, name';
	$db->setQuery ( $query );
	$tmp = $db->loadObjectList ();
	$components = array ();
	//$components[] = array('id'=>'0', 'title'=>'- '. JText::_( 'All Components' ) .' -');	foreach ( $tmp as $t ) {
		$components [] = array ('id' => $t->id, 'title' => $t->title );
	}
	$components [] = array ('id' => 'com_sections', 'title' => 'Section Manager' );
	$components [] = array ('id' => 'com_frontpage', 'title' => 'Front Page Manager' );
	$components [] = array ('id' => 'com_categories', 'title' => 'Category Manager' );
	$components [] = array ('id' => 'com_trash', 'title' => 'Trash Manager' );
	$lists ['componentid'] = JHTML::_ ( 'select.genericlist', $components, 'componentid', 'class="inputbox" size="5" multiple="multiple" ', 'id', 'title', 0 );
	$query = 'SELECT id, title' . ' FROM #__modules' . ' WHERE client_id = 0' . ' ORDER BY title';
	$db->setQuery ( $query );
	$tmp = $db->loadObjectList ();
	$modules = array ();
	//$components[] = array('id'=>'0', 'title'=>'- '. JText::_( 'All Components' ) .' -');	foreach ( $tmp as $t ) {
		$modules [] = array ('id' => $t->id, 'title' => $t->title );
	}
	$lists ['moduleid'] = JHTML::_ ( 'select.genericlist', $modules, 'moduleid', 'class="inputbox" size="5" multiple="multiple" ', 'id', 'title', 0 );
	if ($group_id == 0 && $role_id > 0) {
		$id = $role_id;
		$mode = 'role_id';
		$redirect = 'list_roles';
	} else {
		$id = $group_id;
		$mode = 'group_id';
		$redirect = 'list_groups';
	}
	cacl_html::group_access ( $id, $mode, $lists, $option, $redirect );
}
function showGroups($option) {
	global $mainframe;
	$limit = $mainframe->getUserStateFromRequest ( 'global.list.limit', 'limit', $mainframe->getCfg ( 'list_limit' ), 'int' );
	$limitstart = $mainframe->getUserStateFromRequest ( $option . '.limitstart', 'limitstart', 0, 'int' );
	$db = & JFactory::getDBO ();
	$query = "SELECT COUNT(*) FROM `#__community_acl_groups`";
	$db->setQuery ( $query );
	$total = $db->loadResult ();
	jimport ( 'joomla.html.pagination' );
	$pageNav = new JPagination ( $total, $limitstart, $limit );
	$query = "SELECT * FROM `#__community_acl_groups` ORDER BY name";
	$db->setQuery ( $query, $pageNav->limitstart, $pageNav->limit );
	$rows = $db->loadObjectList ();
	if ($db->getErrorNum ()) {
		echo $db->stderr ();
		return;
	}
	//This would be the last page showed	cacl_html::show_groups ( $rows, $pageNav );
}
function editGroup($edit) {
	global $mainframe;
	// Initialize variables	$db = & JFactory::getDBO ();
	$user = & JFactory::getUser ();
	$uid = $user->get ( 'id' );
	$cid = JRequest::getVar ( 'cid', array (0 ), '', 'array' );
	JArrayHelper::toInteger ( $cid, array (0 ) );
	$row = new CACL_group ( $db );
	if ($edit)
		$row->load ( $cid [0] );
	cacl_html::edit_group ( $row );
}
function saveGroup() {
	global $mainframe;
	// Check for request forgeries	JRequest::checkToken () or die ( 'Invalid Token' );
	// Initialize variables	$db = & JFactory::getDBO ();
	$redirect = JRequest::getCmd ( 'redirect', '', 'post' );
	$post = JRequest::get ( 'post' );
	// fix up special html fields	$post ['description'] = JRequest::getVar ( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
	$row = new CACL_group ( $db );
	if (! $row->bind ( $post )) {
		JError::raiseError ( 500, $row->getError () );
	}
	if (! $row->check ()) {
		JError::raiseWarning ( 500, $row->getError () );
		$mainframe->redirect ( 'index.php?option=com_community_acl&task=' . ($row->id > 0 ? 'group_edit&cid[]=' . $row->id : 'group_add') );
		return;
	}
	if (! $row->store ()) {
		JError::raiseError ( 500, $row->getError () );
	}
	$query = "SELECT `id` FROM  `#__community_acl_sites` WHERE `is_main` = '1'";
	$db->setQuery ( $query );
	$sid = ( int ) $db->loadResult ();
	if ($sid > 0) {
		$main = new CACL_site ( $db );
		$main->load ( $sid );
		$config = new CACL_config ( $main->_site_db );
		$config->load ();
		if ($config->synchronize && $config->cacl_grf) {
			$sync = new CACL_syncronize ( $main );
			$sync->syncronize ( $row->id, 'cacl_group' );
		}
	}
	switch (JRequest::getCmd ( 'task' )) {
		case 'group_apply' :
			$msg = JText::_ ( 'Changes to Group saved' );
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=group_edit&cid[]=' . $row->id, $msg );
			break;
		case 'group_save' :
		default :
			$msg = JText::_ ( 'Group saved' );
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=' . $redirect, $msg );
			break;
	}
}
function showRoles($option) {
	global $mainframe;
	$limit = $mainframe->getUserStateFromRequest ( 'global.list.limit', 'limit', $mainframe->getCfg ( 'list_limit' ), 'int' );
	$limitstart = $mainframe->getUserStateFromRequest ( $option . '.limitstart', 'limitstart', 0, 'int' );
	$group_id = $mainframe->getUserStateFromRequest ( $option . '.roles.group_id', 'group_id', 0, 'int' );
	$db = & JFactory::getDBO ();
	$query = "SELECT COUNT(*) FROM `#__community_acl_roles` " . ($group_id > 0 ? " WHERE `group_id` = '{$group_id}' " : '');
	$db->setQuery ( $query );
	$total = $db->loadResult ();
	jimport ( 'joomla.html.pagination' );
	$pageNav = new JPagination ( $total, $limitstart, $limit );
	$query = "SELECT a.*, b.name AS group_name FROM `#__community_acl_roles` AS a LEFT JOIN `#__community_acl_groups` AS b ON b.id = a.group_id " . ($group_id > 0 ? " WHERE a.group_id = '{$group_id}' " : '') . " ORDER BY b.name, a.name";
	$db->setQuery ( $query, $pageNav->limitstart, $pageNav->limit );
	$rows = $db->loadObjectList ();
	if ($db->getErrorNum ()) {
		echo $db->stderr ();
		return;
	}
	// get list of sections for dropdown filter	$javascript = 'onchange="document.adminForm.submit();"';
	$groups [] = JHTML::_ ( 'select.option', '-1', '- ' . JText::_ ( 'Select Group' ) . ' -' );
	$query = 'SELECT id AS value, name AS text' . ' FROM `#__community_acl_groups`' . ' ORDER BY name';
	$db->setQuery ( $query );
	$groups = @array_merge ( $groups, $db->loadObjectList () );
	$lists ['group_id'] = JHTML::_ ( 'select.genericlist', $groups, 'group_id', 'class="inputbox" size="1" ' . $javascript, 'value', 'text', $group_id );
	cacl_html::show_roles ( $rows, $pageNav, $lists, $group_id );
}
function editRole($edit) {
	global $mainframe, $option;
	$group_id = $mainframe->getUserStateFromRequest ( $option . '.roles.group_id', 'group_id', 0, 'int' );
	// Initialize variables	$db = & JFactory::getDBO ();
	$user = & JFactory::getUser ();
	$uid = $user->get ( 'id' );
	$cid = JRequest::getVar ( 'cid', array (0 ), '', 'array' );
	JArrayHelper::toInteger ( $cid, array (0 ) );
	$row = new CACL_role ( $db );
	if ($edit)
		$row->load ( $cid [0] );
	else
		$row->group_id = $group_id;
		// build the html select list for ordering	$query = 'SELECT ordering AS value, name AS text' . ' FROM #__community_acl_roles' . ($row->group_id > 0 ? ' WHERE group_id = ' . $db->Quote ( $row->group_id ) : '') . ' ORDER BY ordering';
	if ($edit) {
		$lists ['ordering'] = JHTML::_ ( 'list.specificordering', $row, $cid [0], $query );
	} else {
		$lists ['ordering'] = JHTML::_ ( 'list.specificordering', $row, '', $query );
	}
	$query = 'SELECT id AS value, name AS text' . ' FROM `#__community_acl_groups`' . ' ORDER BY name';
	$db->setQuery ( $query );
	$groups = $db->loadObjectList ();
	$lists ['group_id'] = JHTML::_ ( 'select.genericlist', $groups, 'group_id', 'class="inputbox" size="1" ', 'value', 'text', $row->group_id );
	cacl_html::edit_role ( $row, $lists );
}
function saveRole() {
	global $mainframe;
	// Check for request forgeries	JRequest::checkToken () or die ( 'Invalid Token' );
	// Initialize variables	$db = & JFactory::getDBO ();
	$redirect = JRequest::getCmd ( 'redirect', '', 'post' );
	$post = JRequest::get ( 'post' );
	// fix up special html fields	$post ['description'] = JRequest::getVar ( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
	$row = new CACL_role ( $db );
	if (! $row->bind ( $post )) {
		JError::raiseError ( 500, $row->getError () );
	}
	if (! $row->check ()) {
		JError::raiseWarning ( 500, $row->getError () );
		$mainframe->redirect ( 'index.php?option=com_community_acl&task=' . ($row->id > 0 ? 'role_edit&cid[]=' . $row->id : 'role_add') );
		return;
	}
	// if new item order last in appropriate group	if (! $row->id) {
		$where = " group_id = " . $db->Quote ( $row->group_id ) . " ";
		$row->ordering = $row->getNextOrder ( $where );
	}
	if (! $row->store ()) {
		JError::raiseError ( 500, $row->getError () );
	}
	$query = "SELECT `id` FROM  `#__community_acl_sites` WHERE `is_main` = '1'";
	$db->setQuery ( $query );
	$sid = ( int ) $db->loadResult ();
	if ($sid > 0) {
		$main = new CACL_site ( $db );
		$main->load ( $sid );
		$config = new CACL_config ( $main->_site_db );
		$config->load ();
		if ($config->synchronize && $config->cacl_grf) {
			$sync = new CACL_syncronize ( $main );
			$sync->syncronize ( $row->id, 'cacl_role' );
		}
	}
	switch (JRequest::getCmd ( 'task' )) {
		case 'role_apply' :
			$msg = JText::_ ( 'Changes to Role saved' );
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=role_edit&cid[]=' . $row->id, $msg );
			break;
		case 'role_save' :
		default :
			$msg = JText::_ ( 'Role saved' );
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=' . $redirect, $msg );
			break;
	}
}
function showFunctions($option) {
	global $mainframe;
	$limit = $mainframe->getUserStateFromRequest ( 'global.list.limit', 'limit', $mainframe->getCfg ( 'list_limit' ), 'int' );
	$limitstart = $mainframe->getUserStateFromRequest ( $option . '.limitstart', 'limitstart', 0, 'int' );
	$group_id = 0; //$mainframe->getUserStateFromRequest( $option.'.functions.group_id', 'group_id', 0, 'int' );	$db = & JFactory::getDBO ();
	$query = "SELECT COUNT(*) FROM `#__community_acl_functions` " . ($group_id > 0 ? " WHERE `group_id` = '{$group_id}' " : '');
	$db->setQuery ( $query );
	$total = $db->loadResult ();
	jimport ( 'joomla.html.pagination' );
	$pageNav = new JPagination ( $total, $limitstart, $limit );
	$query = "SELECT * FROM `#__community_acl_functions` " . ($group_id > 0 ? " WHERE `group_id` = '{$group_id}' " : '') . " ORDER BY name";
	$db->setQuery ( $query, $pageNav->limitstart, $pageNav->limit );
	$rows = $db->loadObjectList ();
	if ($db->getErrorNum ()) {
		echo $db->stderr ();
		return;
	}
	// get list of sections for dropdown filter	$javascript = 'onchange="document.adminForm.submit();"';
	$groups [] = JHTML::_ ( 'select.option', '-1', '- ' . JText::_ ( 'Select Group' ) . ' -' );
	$query = 'SELECT id AS value, name AS text' . ' FROM `#__community_acl_groups`' . ' ORDER BY name';
	$db->setQuery ( $query );
	$groups = @array_merge ( $groups, $db->loadObjectList () );
	$lists ['group_id'] = JHTML::_ ( 'select.genericlist', $groups, 'group_id', 'class="inputbox" size="1" ' . $javascript, 'value', 'text', $group_id );
	cacl_html::show_functions ( $rows, $pageNav, $lists, $group_id );
}
function editFunction($edit) {
	global $mainframe, $option;
	$group_id = 0; //$mainframe->getUserStateFromRequest( $option.'.functions.group_id', 'group_id', 0, 'int' );	// Initialize variables	$db = & JFactory::getDBO ();
	$user = & JFactory::getUser ();
	$uid = $user->get ( 'id' );
	$cid = JRequest::getVar ( 'cid', array (0 ), '', 'array' );
	JArrayHelper::toInteger ( $cid, array (0 ) );
	$row = new CACL_function ( $db );
	if ($edit)
		$row->load ( $cid [0] );
	else
		$row->group_id = $group_id;
		// build the html select list for ordering	$query = 'SELECT ordering AS value, name AS text' . ' FROM #__community_acl_functions' . ($row->group_id > 0 ? ' WHERE group_id = ' . $db->Quote ( $row->group_id ) : '') . ' ORDER BY ordering';
	/*
	if ($edit) {
		$lists['ordering'] = JHTML::_('list.specificordering',  $row, $cid[0], $query );
	}
	else {
		$lists['ordering'] = JHTML::_('list.specificordering',  $row, '', $query );
	}

	$query = 'SELECT id AS value, name AS text'
	. ' FROM `#__community_acl_groups`'
	. ' ORDER BY name'
	;
	$db->setQuery( $query );
	$groups = $db->loadObjectList();
	$lists['group_id'] = JHTML::_('select.genericlist',   $groups, 'group_id', 'class="inputbox" size="1" ', 'value', 'text', $row->group_id );
	*/
	cacl_html::edit_function ( $row, $lists );
}
function saveFunction() {
	global $mainframe;
	// Check for request forgeries	JRequest::checkToken () or die ( 'Invalid Token' );
	// Initialize variables	$db = & JFactory::getDBO ();
	$redirect = JRequest::getCmd ( 'redirect', '', 'post' );
	$post = JRequest::get ( 'post' );
	// fix up special html fields	$post ['description'] = JRequest::getVar ( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
	$row = new CACL_function ( $db );
	if (! $row->bind ( $post )) {
		JError::raiseError ( 500, $row->getError () );
	}
	if (! $row->check ()) {
		JError::raiseWarning ( 500, $row->getError () );
		$mainframe->redirect ( 'index.php?option=com_community_acl&task=' . ($row->id > 0 ? 'function_edit&cid[]=' . $row->id : 'role_add') );
		return;
	}
	// if new item order last in appropriate group	if (! $row->id) {
		$where = " group_id = " . $db->Quote ( $row->group_id ) . " ";
		$row->ordering = $row->getNextOrder ( $where );
	}
	if (! $row->store ()) {
		JError::raiseError ( 500, $row->getError () );
	}
	$query = "SELECT `id` FROM  `#__community_acl_sites` WHERE `is_main` = '1'";
	$db->setQuery ( $query );
	$sid = ( int ) $db->loadResult ();
	if ($sid > 0) {
		$main = new CACL_site ( $db );
		$main->load ( $sid );
		$config = new CACL_config ( $main->_site_db );
		$config->load ();
		if ($config->synchronize && $config->cacl_grf) {
			$sync = new CACL_syncronize ( $main );
			$sync->syncronize ( $row->id, 'cacl_func' );
		}
	}
	switch (JRequest::getCmd ( 'task' )) {
		case 'function_apply' :
			$msg = JText::_ ( 'Changes to Function saved' );
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=function_edit&cid[]=' . $row->id, $msg );
			break;
		case 'function_save' :
		default :
			$msg = JText::_ ( 'Function saved' );
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=' . $redirect, $msg );
			break;
	}
}
function changeItem($table, $cid = null, $state = 1) {
	global $mainframe;
	// Initialize variables	$db = & JFactory::getDBO ();
	$user = & JFactory::getUser ();
	$uid = $user->get ( 'id' );
	JArrayHelper::toInteger ( $cid );
	if (count ( $cid ) < 1) {
		JError::raiseError ( 500, JText::_ ( 'Select a item' ) );
	}
	$cids = implode ( ',', $cid );
	$query = 'UPDATE `' . $table . '`' . ' SET dosync = ' . ( int ) $state . ' WHERE id IN ( ' . $cids . ' )';
	$db->setQuery ( $query );
	if (! $db->query ()) {
		JError::raiseError ( 500, $db->getErrorMsg () );
	}
	$task = '';
	$query = "SELECT `id` FROM  `#__community_acl_sites` WHERE `is_main` = '1'";
	$db->setQuery ( $query );
	$sid = ( int ) $db->loadResult ();
	if ($sid > 0) {
		$main = new CACL_site ( $db );
		$main->load ( $sid );
		$config = new CACL_config ( $main->_site_db );
		$config->load ();
	}
	switch ($table) {
		case '#__community_acl_groups' :
			$task = 'list_groups';
			if ($sid > 0 && $config->synchronize && $config->cacl_grf) {
				$sync = new CACL_syncronize ( $main );
				foreach ( $cid as $tid ) {
					$sync->syncronize ( $tid, 'cacl_group' );
				}
			}
			break;
		case '#__community_acl_roles' :
			$task = 'list_roles';
			if ($sid > 0 && $config->synchronize && $config->cacl_grf) {
				$sync = new CACL_syncronize ( $main );
				foreach ( $cid as $tid ) {
					$sync->syncronize ( $tid, 'cacl_role' );
				}
			}
			break;
		case '#__community_acl_functions' :
			$task = 'list_functions';
			if ($sid > 0 && $config->synchronize && $config->cacl_grf) {
				$sync = new CACL_syncronize ( $main );
				foreach ( $cid as $tid ) {
					$sync->syncronize ( $tid, 'cacl_func' );
				}
			}
			break;
		case '#__community_acl_sites' :
			$task = 'list_sites';
			break;
	}
	$mainframe->redirect ( 'index.php?option=com_community_acl&task=' . $task );
}
function publishItem($table, $cid = null, $publish = 1) {
	global $mainframe;
	// Check for request forgeries	JRequest::checkToken () or die ( 'Invalid Token' );
	// Initialize variables	$db = & JFactory::getDBO ();
	$user = & JFactory::getUser ();
	$uid = $user->get ( 'id' );
	JArrayHelper::toInteger ( $cid );
	if (count ( $cid ) < 1) {
		$action = $publish ? 'publish' : 'unpublish';
		JError::raiseError ( 500, JText::_ ( 'Select a item to ' ) . ' ' . $action );
	}
	$cids = implode ( ',', $cid );
	$query = 'UPDATE `' . $table . '`' . ' SET enabled = ' . ( int ) $publish . ' WHERE id IN ( ' . $cids . ' )';
	$db->setQuery ( $query );
	if (! $db->query ()) {
		JError::raiseError ( 500, $db->getErrorMsg () );
	}
	$task = '';
	$query = "SELECT `id` FROM  `#__community_acl_sites` WHERE `is_main` = '1'";
	$db->setQuery ( $query );
	$sid = ( int ) $db->loadResult ();
	if ($sid > 0) {
		$main = new CACL_site ( $db );
		$main->load ( $sid );
		$config = new CACL_config ( $main->_site_db );
		$config->load ();
	}
	switch ($table) {
		case '#__community_acl_groups' :
			$task = 'list_groups';
			if ($sid > 0 && $config->synchronize && $config->cacl_grf) {
				$sync = new CACL_syncronize ( $main );
				foreach ( $cid as $tid ) {
					$sync->syncronize ( $tid, 'cacl_group' );
				}
			}
			break;
		case '#__community_acl_roles' :
			$task = 'list_roles';
			if ($sid > 0 && $config->synchronize && $config->cacl_grf) {
				$sync = new CACL_syncronize ( $main );
				foreach ( $cid as $tid ) {
					$sync->syncronize ( $tid, 'cacl_role' );
				}
			}
			break;
		case '#__community_acl_functions' :
			$task = 'list_functions';
			if ($sid > 0 && $config->synchronize && $config->cacl_grf) {
				$sync = new CACL_syncronize ( $main );
				foreach ( $cid as $tid ) {
					$sync->syncronize ( $tid, 'cacl_func' );
				}
			}
			break;
		case '#__community_acl_sites' :
			$task = 'list_sites';
			break;
	}
	$mainframe->redirect ( 'index.php?option=com_community_acl&task=' . $task );
}
function deleteItem($table, $cid) {
	global $mainframe;
	// Check for request forgeries	JRequest::checkToken () or die ( 'Invalid Token' );
	// Initialize variables	$db = & JFactory::getDBO ();
	JArrayHelper::toInteger ( $cid );
	if (count ( $cid ) < 1) {
		JError::raiseError ( 500, JText::_ ( 'Select a item to delete', true ) );
	}
	if (count ( $cid )) {
		$cids = implode ( ',', $cid );
		$query = 'DELETE FROM `' . $table . '`' . ' WHERE `id` IN ( ' . $cids . ' )';
		$db->setQuery ( $query );
		if (! $db->query ()) {
			JError::raiseError ( 500, $db->stderr () );
			return false;
		}
		switch ($table) {
			case '#__community_acl_groups' :
				$query = 'SELECT `id` FROM `#__community_acl_roles`' . ' WHERE `group_id` IN ( ' . $cids . ' )';
				$db->setQuery ( $query );
				$rid = $db->loadResultArray ();
				$query = 'DELETE FROM `#__community_acl_roles`' . ' WHERE `group_id` IN ( ' . $cids . ' )';
				$db->setQuery ( $query );
				if (! $db->query ()) {
					JError::raiseError ( 500, $db->stderr () );
					return false;
				}
				$query = 'DELETE FROM `#__community_acl_access`' . ' WHERE `group_id` IN ( ' . $cids . ' ) ' . (count ( $rid ) > 0 ? ' OR `role_id` IN ( ' . implode ( ',', $rid ) . ' )' : '');
				$db->setQuery ( $query );
				if (! $db->query ()) {
					JError::raiseError ( 500, $db->stderr () );
					return false;
				}
				$query = 'DELETE FROM `#__community_acl_users`' . ' WHERE `group_id` IN ( ' . $cids . ' ) ' . (count ( $rid ) > 0 ? ' OR `role_id` IN ( ' . implode ( ',', $rid ) . ' )' : '');
				$db->setQuery ( $query );
				if (! $db->query ()) {
					JError::raiseError ( 500, $db->stderr () );
					return false;
				}
				$query = "SELECT `id` FROM  `#__community_acl_sites` WHERE `is_main` = '1'";
				$db->setQuery ( $query );
				$sid = ( int ) $db->loadResult ();
				if ($sid > 0) {
					$main = new CACL_site ( $db );
					$main->load ( $sid );
					$config = new CACL_config ( $main->_site_db );
					$config->load ();
					if ($config->synchronize && $config->cacl_grf) {
						$sync = new CACL_syncronize ( $main );
						foreach ( $cid as $tid ) {
							$sync->syncronize ( $tid, 'cacl_group_delete' );
						}
					}
				}
				break;
			case '#__community_acl_roles' :
				$query = 'DELETE FROM `#__community_acl_access`' . ' WHERE `role_id` IN ( ' . $cids . ' ) ';
				$db->setQuery ( $query );
				if (! $db->query ()) {
					JError::raiseError ( 500, $db->stderr () );
					return false;
				}
				$query = 'DELETE FROM `#__community_acl_users`' . ' WHERE `role_id` IN ( ' . $cids . ' ) ';
				$db->setQuery ( $query );
				if (! $db->query ()) {
					JError::raiseError ( 500, $db->stderr () );
					return false;
				}
				$query = "SELECT `id` FROM  `#__community_acl_sites` WHERE `is_main` = '1'";
				$db->setQuery ( $query );
				$sid = ( int ) $db->loadResult ();
				if ($sid > 0) {
					$main = new CACL_site ( $db );
					$main->load ( $sid );
					$config = new CACL_config ( $main->_site_db );
					$config->load ();
					if ($config->synchronize && $config->cacl_grf) {
						$sync = new CACL_syncronize ( $main );
						foreach ( $cid as $tid ) {
							$sync->syncronize ( $tid, 'cacl_role_delete' );
						}
					}
				}
				break;
			case '#__community_acl_functions' :
				$query = 'DELETE FROM `#__community_acl_function_access`' . ' WHERE `func_id` IN ( ' . $cids . ' ) ';
				$db->setQuery ( $query );
				if (! $db->query ()) {
					JError::raiseError ( 500, $db->stderr () );
					return false;
				}
				$query = 'DELETE FROM `#__community_acl_users`' . ' WHERE `function_id` IN ( ' . $cids . ' ) ';
				$db->setQuery ( $query );
				if (! $db->query ()) {
					JError::raiseError ( 500, $db->stderr () );
					return false;
				}
				$query = "SELECT `id` FROM  `#__community_acl_sites` WHERE `is_main` = '1'";
				$db->setQuery ( $query );
				$sid = ( int ) $db->loadResult ();
				if ($sid > 0) {
					$main = new CACL_site ( $db );
					$main->load ( $sid );
					$config = new CACL_config ( $main->_site_db );
					$config->load ();
					if ($config->synchronize && $config->cacl_grf) {
						$sync = new CACL_syncronize ( $main );
						foreach ( $cid as $tid ) {
							$sync->syncronize ( $tid, 'cacl_func_delete' );
						}
					}
				}
				break;
			case '#__community_acl_sites' :
				$task = 'list_sites';
				break;
		}
	}
	$task = '';
	switch ($table) {
		case '#__community_acl_groups' :
			$task = 'list_groups';
			break;
		case '#__community_acl_roles' :
			$task = 'list_roles';
			break;
		case '#__community_acl_functions' :
			$task = 'list_functions';
			break;
		case '#__community_acl_sites' :
			$task = 'list_sites';
			break;
	}
	$mainframe->redirect ( 'index.php?option=com_community_acl&task=' . $task );
}
function orderItem($table, $key, $uid, $inc) {
	global $mainframe;
	// Check for request forgeries	JRequest::checkToken () or die ( 'Invalid Token' );
	// Initialize variables	$db = & JFactory::getDBO ();
	switch ($table) {
		case '#__community_acl_roles' :
			$row = new CACL_role ( $db );
			break;
		case '#__community_acl_functions' :
			$row = new CACL_function ( $db );
			break;
	}
	$row->load ( $uid );
	$row->move ( $inc, $key . ' = ' . $db->Quote ( $row->$key ) );
	$value = ( int ) JRequest::getCmd ( $key );
	if ($value > 0) {
		$key = '&' . $key . '=' . $value;
	}
	switch ($table) {
		case '#__community_acl_roles' :
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=list_roles' . $key );
			break;
		case '#__community_acl_functions' :
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=list_functions' . $key );
			break;
	}
}
function saveOrder(&$cid, $table, $key) {
	global $mainframe;
	// Check for request forgeries	JRequest::checkToken () or die ( 'Invalid Token' );
	// Initialize variables	$db = & JFactory::getDBO ();
	$total = count ( $cid );
	$order = JRequest::getVar ( 'order', array (0 ), 'post', 'array' );
	JArrayHelper::toInteger ( $order, array (0 ) );
	switch ($table) {
		case '#__community_acl_roles' :
			$row = new CACL_role ( $db );
			break;
		case '#__community_acl_functions' :
			$row = new CACL_function ( $db );
			break;
	}
	$groupings = array ();
	// update ordering values	for($i = 0; $i < $total; $i ++) {
		$row->load ( ( int ) $cid [$i] );
		// track sections		$groupings [] = $row->section;
		if ($row->ordering != $order [$i]) {
			$row->ordering = $order [$i];
			if (! $row->store ()) {
				//TODO - convert to JError				JError::raiseError ( 500, $db->getErrorMsg () );
			}
		}
	}
	// execute updateOrder for each parent group	$groupings = array_unique ( $groupings );
	foreach ( $groupings as $group ) {
		$row->reorder ( $key . ' = ' . $db->Quote ( $group ) );
	}
	$msg = JText::_ ( 'New ordering saved' );
	switch ($table) {
		case '#__community_acl_roles' :
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=list_roles&' . $key . '=' . $row->$key, $msg );
			break;
		case '#__community_acl_functions' :
			$mainframe->redirect ( 'index.php?option=com_community_acl&task=list_functions&' . $key . '=' . $row->$key, $msg );
			break;
	}
}
function cancel() {
	global $mainframe;
	$redirect = JRequest::getCmd ( 'redirect', '', 'post' );
	$mainframe->redirect ( 'index.php?option=com_community_acl&task=' . $redirect );
}
?>