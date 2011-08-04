<?php
defined('_JEXEC') or die('Restricted access');

function com_uninstall() {
	$db	=& JFactory::getDBO();
	
	#- Delete System Community ACL Plugin
	if(file_exists(JPATH_SITE . "/plugins/system/community_acl.php")){
		if( is_file(JPATH_SITE . "/plugins/system/community_acl.php") )
			@unlink( JPATH_SITE . "/plugins/system/community_acl.php" );
		else
			echo '<font color="#FF0000">Error: Unable remove cACL system plugin</font><br/>';
		
		if( is_file(JPATH_SITE . "/plugins/system/community_acl.xml") ){
			@unlink( JPATH_SITE . "/plugins/system/community_acl.xml" );
	
			#- Remove the Sytem Community ACL Plugin from the plugins database 
			$db->setQuery("DELETE FROM `#__plugins` WHERE `element` LIKE 'community_acl' AND `folder` LIKE 'system'");
			$db->query(); 
		}else
			echo '<font color="#FF0000">Error: Unable remove XML-file of cACL system plugin</font><br/>';
	}	  	

	#- Delete Authentication Community ACL Plugin
	if(file_exists(JPATH_SITE . "/plugins/authentication/community_acl.php")){
		if( is_file(JPATH_SITE . "/plugins/authentication/community_acl.php") )
			@unlink( JPATH_SITE . "/plugins/authentication/community_acl.php" );
		else
			echo '<font color="#FF0000">Error: Unable remove cACL system plugin</font><br/>';
	
		
		if( is_file(JPATH_SITE . "/plugins/authentication/community_acl.xml") ){ 
		   	@unlink( JPATH_SITE . "/plugins/authentication/community_acl.xml" );
					
			#- Remove the Authentication Community ACL Plugin from the plugins database 
			$db->setQuery("DELETE FROM `#__plugins` WHERE `element` LIKE 'community_acl' AND `folder` LIKE 'authentication'");
			$db->query(); 				
		}else
			echo '<font color="#FF0000">Error: Unable remove XML-file of cACL authentication plugin</font><br/>';
	}

	#- Delete User Community ACL Plugin
	if(file_exists(JPATH_SITE . "/plugins/user/community_acl.php")){
		if( is_file(JPATH_SITE . "/plugins/user/community_acl.php") )
			@unlink( JPATH_SITE . "/plugins/user/community_acl.php" );
		else
			echo '<font color="#FF0000">Error: Unable remove cACL user plugin</font><br/>';
	
	    if( is_file(JPATH_SITE . "/plugins/user/community_acl.xml") ){
			@unlink( JPATH_SITE . "/plugins/user/community_acl.xml" );
			
			#- Remove the User Community ACL Plugin from the plugins database 
				$db->setQuery("DELETE FROM `#__plugins` WHERE `element` LIKE 'community_acl' AND `folder` LIKE 'user'");
				$db->query(); 
		}else
			echo '<font color="#FF0000">Error: Unable remove XML-file of cACL user plugin</font><br/>';
	}

	#- Delete Community ACL JoomSocial Plugin
	if(file_exists(JPATH_SITE . "/plugins/system/cacl_joomsocial.php")){
		if( is_file(JPATH_SITE . "/plugins/system/cacl_joomsocial.php") )
			@unlink( JPATH_SITE . "/plugins/system/cacl_joomsocial.php" );
		else
			echo '<font color="#FF0000">Error: Unable remove cACL joomsocial plugin</font><br/>';
	
	    if( is_file(JPATH_SITE . "/plugins/system/cacl_joomsocial.xml") ){
			@unlink( JPATH_SITE . "/plugins/system/cacl_joomsocial.xml" );
			
			#- Remove the User Community ACL Plugin from the plugins database 
				$db->setQuery("DELETE FROM `#__plugins` WHERE `element` LIKE 'cacl_joomsocial' AND `folder` LIKE 'system'");
				$db->query(); 
		}else
			echo '<font color="#FF0000">Error: Unable remove XML-file of cACL joomsocial plugin</font><br/>';
	}
	
	#- Delete Community ACL Preprocessor Plugin
	if(file_exists(JPATH_SITE . "/plugins/system/cacl_preprocessor.php")){
		if( is_file(JPATH_SITE . "/plugins/system/cacl_preprocessor.php") )
			@unlink( JPATH_SITE . "/plugins/system/cacl_preprocessor.php" );
		else
			echo '<font color="#FF0000">Error: Unable remove cACL preprocessor plugin</font><br/>';
	
	    if( is_file(JPATH_SITE . "/plugins/system/cacl_preprocessor.xml") ){
			@unlink( JPATH_SITE . "/plugins/system/cacl_preprocessor.xml" );
			
			#- Remove the User Community ACL Plugin from the plugins database 
				$db->setQuery("DELETE FROM `#__plugins` WHERE `element` LIKE 'cacl_preprocessor' AND `folder` LIKE 'system'");
				$db->query(); 
		}else
			echo '<font color="#FF0000">Error: Unable remove XML-file of cACL preprocessor plugin</font><br/>';
	}
	
	#- Disable the Community Builder Drop down list
		$query = "UPDATE `#__comprofiler_fields` SET published = '0' " .
					" WHERE `tablecolumns` = 'cb_caclmembertype' AND `table` = '#__comprofiler' ";
		$db->setQuery( $query );
		$db->query();

	return true;

}		
?>