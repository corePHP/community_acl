<?php
defined('_JEXEC') or die('Restricted access');

// Cleaner wanted - we need to clean this piece of mess called coding. For further details Call 1-800-CLEAN-MY-CODE.

/*function com_uninstall() {
	$db	=& JFactory::getDBO();
	
	$result = @chmod (JPATH_SITE. "/modules/mod_mainmenu/legacy.php", 0666);
	if ($result)
		$result = @unlink(JPATH_SITE. "/modules/mod_mainmenu/legacy.php");
	if ($result)
		$result = @rename(JPATH_SITE ."/administrator/components/com_community_acl/backup/legacy.php", JPATH_SITE. "/modules/mod_mainmenu/legacy.php");
	if (!$result)
		echo '<font color="#FF0000">Error: Unable restore from backup FE menu module</font><br/>';
	
	$result = @chmod (JPATH_SITE. "/modules/mod_mainmenu/helper.php", 0666);
	if ($result)
		$result = @unlink(JPATH_SITE. "/modules/mod_mainmenu/helper.php");
	if ($result)
		$result = @rename(JPATH_SITE ."/administrator/components/com_community_acl/backup/mod_mainmenu_helper.php", JPATH_SITE. "/modules/mod_mainmenu/helper.php");
	if (!$result)
		echo '<font color="#FF0000">Error: Unable restore from backup FE menu module</font><br/>';
	
	$result = @chmod (JPATH_SITE. "/administrator/modules/mod_menu/helper.php", 0666);
	if ($result)
		$result = @unlink(JPATH_SITE. "/administrator/modules/mod_menu/helper.php");
	if ($result)
		$result = @rename(JPATH_SITE ."/administrator/components/com_community_acl/backup/mod_menu_helper.php", JPATH_SITE. "/administrator/modules/mod_menu/helper.php");
	if (!$result)
		echo '<font color="#FF0000">Error: Unable restore from backup BE menu module</font><br/>';
	
	$result = @chmod (JPATH_SITE. "/libraries/joomla/application/module/helper.php", 0666);
	if ($result)
		$result = @unlink(JPATH_SITE. "/libraries/joomla/application/module/helper.php");
	if ($result)
		$result = @rename(JPATH_SITE ."/administrator/components/com_community_acl/backup/module_helper.php", JPATH_SITE. "/libraries/joomla/application/module/helper.php");
	if (!$result)
		echo '<font color="#FF0000">Error: Unable restore from backup FE module handler</font><br/>';
		
	$result_cb = @unlink(JPATH_SITE . "/components/com_comprofiler/plugin/user/plug_caclplugin/cacl_usersync.php" );
	if (!$result_cb)
		echo '<font color="#FF0000">Error: Unable remove cACL plugin for Community Builder</font><br/>';
		
	$result = @unlink(JPATH_SITE . "/components/com_comprofiler/plugin/user/plug_caclplugin/cacl_usersync.xml" );
	if (!$result)
		echo '<font color="#FF0000">Error: Unable remove XML-file of cACL plugin for Community Builder </font><br/>';
		
	$result = @rmdir(JPATH_SITE . "/components/com_comprofiler/plugin/user/plug_caclplugin" );
	if (!$result)
		echo '<font color="#FF0000">Error: Unable remove dir of cACL plugin for Community Builder</font><br/>';
	
	$db->setQuery("DELETE FROM `#__comprofiler_plugin` WHERE `element` = 'cacl_usersync' AND `type` = 'user' AND `folder` = 'plug_caclplugin' ");
	if ($result_cb) {
		$db->query();
		if ($db->getErrorNum()) {
 			$msg .= '<font color="#FF0000">Error: Unable delete DB row:<br/>'. $db->stderr() .'</font><br/>';
		}
	}
	
	
	$result_pl = @unlink( JPATH_SITE . "/plugins/system/community_acl.php" );
	if (!$result_pl)
		echo '<font color="#FF0000">Error: Unable remove cACL system plugin</font><br/>';
		
   	$result = @unlink( JPATH_SITE . "/plugins/system/community_acl.xml" );
	if (!$result)
		echo '<font color="#FF0000">Error: Unable remove XML-file of cACL system plugin</font><br/>';
		
	$result = @unlink( JPATH_SITE . "/language/en-GB/en-GB.plg_system_community_acl.ini" );
	if (!$result)
		echo '<font color="#FF0000">Error: Unable remove language file of cACL system plugin</font><br/>';


	
	$result_pl = @unlink( JPATH_SITE . "/plugins/authentication/community_acl.php" );
	if (!$result_pl)
		echo '<font color="#FF0000">Error: Unable remove cACL system plugin</font><br/>';
		
   	$result = @unlink( JPATH_SITE . "/plugins/authentication/community_acl.xml" );
	if (!$result)
		echo '<font color="#FF0000">Error: Unable remove XML-file of cACL authentication plugin</font><br/>';

	
	
	$result_pl = @unlink( JPATH_SITE . "/plugins/content/cacl_content.php" );
	if (!$result_pl)
		echo '<font color="#FF0000">Error: Unable remove cACL content plugin</font><br/>';
		
   	$result = @unlink( JPATH_SITE . "/plugins/content/cacl_content.xml" );
	if (!$result)
		echo '<font color="#FF0000">Error: Unable remove XML-file of cACL system plugin</font><br/>';

	
	if ($result_pl) {
		$db->setQuery("DELETE FROM `#__plugins` WHERE `element` = 'community_acl' OR `element` = 'cacl_content'");
		$db->query(); 
		if ($db->getErrorNum()) {
			$msg .= '<font color="#FF0000">Error: Unable delete DB row:<br/>'. $db->stderr() .'</font><br/>';
		}	
	}
	
	$result_pl = @rmdir( JPATH_SITE . "/administrator/modules/mod_commacl_menu/" );
	if (!$result_pl)
		echo '<font color="#FF0000">Error: Unable remove Community ACL menu (administrator) - Please manually uninstall mod_commacl_menu and enable mod_menu</font><br/>';		
	else {
		$db->setQuery("DELETE FROM `#__modules` WHERE `module` = 'mod_commacl_menu'");
		$db->query(); 
		if ($db->getErrorNum()) {
			$msg .= '<font color="#FF0000">Error: Unable delete DB row:<br/>'. $db->stderr() .'</font><br/>';
		}	
	}
	
	$result_pl = @rmdir( JPATH_SITE . "/modules/mod_commacl_mainmenu/" );
	if (!$result_pl)
		echo '<font color="#FF0000">Error: Unable remove Community ACL mainmenu (site)- Please manually uninstall mod_commacl_mainmenu and enable mod_mainmenu </font><br/>';		
	else {
		$db->setQuery("DELETE FROM `#__modules` WHERE `module` = 'mod_commacl_mainmenu'");
		$db->query(); 
		if ($db->getErrorNum()) {
			$msg .= '<font color="#FF0000">Error: Unable delete DB row:<br/>'. $db->stderr() .'</font><br/>';
		}	
	}
		
	return true;

}*/		
?>