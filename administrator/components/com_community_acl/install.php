<?php
defined('_JEXEC') or die('Restricted access');

/* - These are old commands now - 
function com_install() {
	$db	=& JFactory::getDBO();
	$msg = '';
	$msg_s = '';
	$before = $msg;
	@mkdir(JPATH_SITE."/administrator/components/com_community_acl/key");
	@chmod (JPATH_SITE."/administrator/components/com_community_acl/key", 0776);

	$db =& JFactory::getDBO(); 
	
	# - Kobby Sam To Do:
	/* * /
	 * Check if the table exists first
	 * If it exists - create a field there
	 * Else create a new table
	/* * /
	
	$db->setQuery("ALTER TABLE `#__community_acl_config` CHANGE `value` `value` TEXT;"); 
	$db->query(); 
	
	$db->setQuery("ALTER TABLE `#__community_acl_function_access` ADD `extra` TINYINT( 4 ) DEFAULT '0' NOT NULL;"); 
	$db->query(); 
	
	$db->setQuery("ALTER TABLE `#__community_acl_groups` ADD `dosync` TINYINT( 4 ) DEFAULT '1' NOT NULL;"); 
	$db->query();
	
	$db->setQuery("ALTER TABLE `#__community_acl_roles` ADD `dosync` TINYINT( 4 ) DEFAULT '1' NOT NULL;"); 
	$db->query();
	
	$db->setQuery("ALTER TABLE `#__community_acl_functions` ADD `dosync` TINYINT( 4 ) DEFAULT '1' NOT NULL;"); 
	$db->query();

	$result = @chmod (JPATH_SITE. "/modules/mod_mainmenu/helper.php", 0666);
	if ($result) {
		@unlink(JPATH_SITE."/administrator/components/com_community_acl/backup/mod_mainmenu_helper.php");
		$result = @rename(JPATH_SITE. "/modules/mod_mainmenu/helper.php", JPATH_SITE."/administrator/components/com_community_acl/backup/mod_mainmenu_helper.php");
	} else 
		$msg .= '<font color="#FF0000">Error: Unable chmod file `.../modules/mod_mainmenu/helper.php`</font><br/>';
	if ($result)
		$result = @copy(JPATH_SITE."/administrator/components/com_community_acl/patch/mod_mainmenu_helper.php", JPATH_SITE. "/modules/mod_mainmenu/helper.php" );
	else 
		$msg .= '<font color="#FF0000">Error: Unable backup file `.../modules/mod_mainmenu/helper.php`</font><br/>';
	if (!$result)
		$msg .= '<font color="#FF0000">Error: Unable patch(replace) file `.../modules/mod_mainmenu/helper.php`</font><br/>';
	
	
	$result = @chmod (JPATH_SITE. "/modules/mod_mainmenu/legacy.php", 0666);
	if ($result) {
		@unlink(JPATH_SITE."/administrator/components/com_community_acl/backup/legacy.php");
		$result = @rename(JPATH_SITE. "/modules/mod_mainmenu/legacy.php", JPATH_SITE."/administrator/components/com_community_acl/backup/legacy.php");
	}else 
		$msg .= '<font color="#FF0000">Error: Unable chmod file `.../modules/mod_mainmenu/legacy.php`</font><br/>';
	if ($result)
		$result = @copy(JPATH_SITE."/administrator/components/com_community_acl/patch/legacy.php", JPATH_SITE. "/modules/mod_mainmenu/legacy.php" );
	else 
		$msg .= '<font color="#FF0000">Error: Unable backup file `.../modules/mod_mainmenu/legacy.php`</font><br/>';
	if (!$result)
		$msg .= '<font color="#FF0000">Error: Unable patch(replace) file `.../modules/mod_mainmenu/legacy.php`</font><br/>';
		
	
	if ($msg == $before) 
		$msg_s .= '<font color="#00FF00">Patch FE menu module... SUCCESS</font><br/>';
	
	$before = $msg;
	$result = @chmod (JPATH_SITE. "/administrator/modules/mod_menu/helper.php", 0666);
	if ($result) {
		@unlink(JPATH_SITE."/administrator/components/com_community_acl/backup/mod_menu_helper.php");
		$result = @rename(JPATH_SITE. "/administrator/modules/mod_menu/helper.php", JPATH_SITE."/administrator/components/com_community_acl/backup/mod_menu_helper.php");
	} else 
		$msg .= '<font color="#FF0000">Error: Unable chmod file `.../administrator/modules/mod_menu/helper.php`</font><br/>';
	if ($result)
		$result = @copy(JPATH_SITE."/administrator/components/com_community_acl/patch/mod_menu_helper.php", JPATH_SITE. "/administrator/modules/mod_menu/helper.php" );
	else 
		$msg .= '<font color="#FF0000">Error: Unable backup file `.../administrator/modules/mod_menu/helper.php`</font><br/>';
	if (!$result)
		$msg .= '<font color="#FF0000">Error: Unable patch(replace) file `.../administrator/modules/mod_menu/helper.php`</font><br/>';
	
	if ($msg == $before) 
		$msg_s .= '<font color="#00FF00">Patch BE menu module... SUCCESS</font><br/>';
	
	$before = $msg;
	$result = @chmod (JPATH_SITE. "/libraries/joomla/application/module/helper.php", 0666);
	if ($result) {
		@unlink(JPATH_SITE."/administrator/components/com_community_acl/backup/module_helper.php");
		$result = @rename(JPATH_SITE. "/libraries/joomla/application/module/helper.php", JPATH_SITE."/administrator/components/com_community_acl/backup/module_helper.php");
	} else 
		$msg .= '<font color="#FF0000">Error: Unable chmod file `.../libraries/joomla/application/module/helper.php`</font><br/>';
	if ($result)
		$result = @copy(JPATH_SITE."/administrator/components/com_community_acl/patch/module_helper.php", JPATH_SITE. "/libraries/joomla/application/module/helper.php" );
	else 
		$msg .= '<font color="#FF0000">Error: Unable backup file `.../libraries/joomla/application/module/helper.php`</font><br/>';
	if (!$result)
		$msg .= '<font color="#FF0000">Error: Unable patch(replace) file `.../libraries/joomla/application/module/helper.php`</font><br/>';
	
	if ($msg == $before) 
		$msg_s .= '<font color="#00FF00">Patch FE module handler... SUCCESS</font><br/>';
		
	// Add system plugin
	$before = $msg;	
    $result = @chmod (JPATH_SITE. "/administrator/components/com_community_acl/joomla_plugin/community_acl.php", 0666);
	if ($result)
		$result = @chmod (JPATH_SITE. "/administrator/components/com_community_acl/joomla_plugin/community_acl.xml", 0666);
	else 
		$msg .= '<font color="#FF0000">Error: Unable chmod file `.../administrator/components/com_community_acl/joomla_plugin/community_acl.php`</font><br/>';
	if ($result)	
		$result = @copy( JPATH_SITE. "/administrator/components/com_community_acl/joomla_plugin/community_acl.php", JPATH_SITE."/plugins/system/community_acl.php");
	else 
		$msg .= '<font color="#FF0000">Error: Unable chmod file `.../administrator/components/com_community_acl/joomla_plugin/community_acl.xml`</font><br/>';
	if ($result)
	    $result = @copy( JPATH_SITE. "/administrator/components/com_community_acl/joomla_plugin/community_acl.xml", JPATH_SITE."/plugins/system/community_acl.xml");
	else 
		$msg .= '<font color="#FF0000">Error: Unable copy file `.../administrator/components/com_community_acl/joomla_plugin/community_acl.php`</font><br/>';
		
	if ($result) {	    
		$result = @copy( JPATH_SITE. "/administrator/components/com_community_acl/joomla_plugin/en-GB.plg_system_community_acl.ini", JPATH_SITE."/administrator/language/en-GB/en-GB.plg_system_community_acl.ini");
		$result = @copy( JPATH_SITE. "/administrator/components/com_community_acl/joomla_plugin/en-GB.plg_system_community_acl.ini", JPATH_SITE."/language/en-GB/en-GB.plg_system_community_acl.ini");
	} else 
		$msg .= '<font color="#FF0000">Error: Unable copy file `.../administrator/components/com_community_acl/joomla_plugin/community_acl.xml`</font><br/>';
	if (!$result)
		$msg .= '<font color="#FF0000">Error: Unable copy file `.../administrator/components/com_community_acl/joomla_plugin/en-GB.plg_system_community_acl.ini`</font><br/>';

	if ($result) {
		$db->setQuery("DELETE FROM `#__plugins` WHERE `element` = 'community_acl'");
		$db->query(); 
		$db->setQuery( "INSERT INTO `#__plugins` (`name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`) VALUES('System - Community ACL', 'community_acl', 'system', 0, 9, 1, 0, 0, 0, '0000-00-00 00:00:00', '')");
		$db->query(); 
		if ($db->getErrorNum()) {
			$msg .= '<font color="#FF0000">Error: '. $db->stderr() .'</font><br/>';
		}
	}
	else 
		$msg .= '<font color="#FF0000">Error: cACL plugin is not installed. Please use the plugin supplied.`</font><br/>';
	
	if ($msg == $before) 
		$msg_s .= '<font color="#00FF00">Install system plugin... SUCCESS</font><br/>';
		
	// Add CB plugin
	$before = $msg;
	if (file_exists(  JPATH_SITE. '/administrator/components/com_comprofiler/ue_config.php')) {
		require_once( JPATH_SITE. '/administrator/components/com_comprofiler/ue_config.php');
		if (isset($ueConfig['version']) && $ueConfig['version'] >= '1.1') {
			$path_src = JPATH_SITE. '/administrator/components/com_community_acl/plug_cbcacl_usersync';
			$path_dst = JPATH_SITE. '/components/com_comprofiler/plugin/user/plug_caclplugin';
		
			$result = @mkdir(JPATH_SITE . "/components/com_comprofiler/plugin/user/plug_caclplugin");
			if ($result)
				$result = @chmod(JPATH_SITE . "/components/com_comprofiler/plugin/user/plug_caclplugin", 0777);
			else 
				$msg .= '<font color="#FF0000">Error: Unable create dir `.../components/com_comprofiler/plugin/user/plug_caclplugin`</font><br/>';
			if ($result)
				$result = @copy($path_src. "/cacl_usersync.php", $path_dst."/cacl_usersync.php");
			else 
				$msg .= '<font color="#FF0000">Error: Unable chmod dir `.../components/com_comprofiler/plugin/user/plug_caclplugin`</font><br/>';
			if ($result)
				$result = @copy($path_src. "/cacl_usersync.xml", $path_dst."/cacl_usersync.xml"); 
			else 
				$msg .= '<font color="#FF0000">Error: Unable copy file `.../administrator/components/com_community_acl/plug_caclplugin/cacl_usersync.php`</font><br/>';
			if ($result)
				$result = @chmod(JPATH_SITE . "/components/com_comprofiler/plugin/user/plug_caclplugin", 0775);
			else 
				$msg .= '<font color="#FF0000">Error: Unable copy file `.../components/com_comprofiler/plugin/user/plug_caclplugin/cacl_usersync.xml`</font><br/>';
			if (!$result)
				$msg .= '<font color="#FF0000">Error: Unable chmod dir `.../components/com_comprofiler/plugin/user/plug_caclplugin`</font><br/>';
			if ($result) {	
				$db->setQuery("INSERT INTO `#__comprofiler_plugin` ( `id` , `name` , `element` , `type` , `folder` , `backend_menu` , `access` , `ordering` , `published` , `iscore` , `client_id` , `checked_out` , `checked_out_time` , `params` ) VALUES ('', 'cACL plugin', 'cacl_usersync', 'user', 'plug_caclplugin', '', '0', '0', '1', '0', '0', '0', '0000-00-00 00:00:00', '');");
				$db->query();
				if ($db->getErrorNum()) {
					$msg .= '<font color="#FF0000">Error: '. $db->stderr() .'</font><br/>';
				}
			} else
				$msg .= '<font color="#FF0000">Error: cACL plugin for Community Builder is not installed.`</font><br/>';
			
		} else
			$msg .= '<font color="#FF0000">Incorrect version of Community Builder. Please install Community Builder ver 1.1 or above and then install cACL plugin for Community Builder.</font>';
	}else
		$msg .= '<font color="#FF0000">Community Builder is not detected. Please install Community Builder ver 1.1 or above and then install cACL plugin for Community Builder. Community Builder is not needed - we are just notifying you that we could not install the plugin for Community Builder</font>';
		
	if ($msg == $before) 
		$msg_s .= '<font color="#00FF00">Install Community Builder plugin... SUCCESS</font><br/>';


	if ($msg == '') {
		echo $msg_s;
		return true;
	} else {
		echo $msg.'<br/>'.$msg_s;
		return true;
	}
	
}	*/
?>