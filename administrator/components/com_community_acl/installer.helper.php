<?php
// Deny direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.filesystem.folder' );
jimport( 'joomla.filesystem.file' );
jimport( 'joomla.filesystem.archive' );

/**
 * This is the helper file of the installer
 * during the installation process
 **/

class caclInstaller{

	var $backendPath;
	var $frontendPath;
	var $successMsg;
	var $failedMsg;
	var $front;

	function caclInstaller(){
		$this->backendPath   = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_community_acl' . DS;
		$this->frontendPath  = JPATH_ROOT . DS . 'components' . DS . 'com_community_acl' . DS;
		$this->front 		 = JPATH_ROOT . DS . 'components' . DS . 'com_community_acl' . DS;
	}

	function getAutoSubmitFunction()
	{
		ob_start();
		?><script type="text/javascript">
		var i=3;

		function countDown()
		{
			if(i >= 0)
			{
				document.getElementById("timer").innerHTML = i;
				i = i-1;
				var c = window.setTimeout("countDown()", 1000);
			}
			else
			{
				document.getElementById("installSuccesMsg").innerHTML = "Successfully Installed.";

			}
		}

		window.addEvent('domready', function() {
			countDown();
		});

		</script><?php
		$autoSubmit = ob_get_contents();
		@ob_end_clean();

		return $autoSubmit;
	}

	function checkRequirements(){
		$this->backendPath   = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_community_acl' . DS;
		$this->frontendPath  = JPATH_ROOT . DS . 'components' . DS . 'com_community_acl' . DS;

		$status	= true;

		$html = '';
		$message = '';
		$html .= '<h3>'.JText::_('CHECKING REQUIREMENTS'). '</h3><br/>';
		$html .= '<div style="width:100%; float:left;"><b>' . JText::_('Community ACL Processor Plugin') . '</b></div>';
		if(!file_exists($this->frontendPath.'cacl_preprocessor.zip'))
		{
			$html .= "<p style=\"color:red\" >Please re-install Commmunity ACL. The file cacl_preprocessor.zip was not uploaded properly!</p>";
			$status = false;
		}
		else
		{
			$html .= "<p style=\" color: green\"> cacl_preprocessor.zip file uploaded successfully</p>";
		}



		$html .= '<div style="width:100%; float:left;"><b>' . JText::_('Joomla Patch') . '</b></div>';
		if(!file_exists($this->frontendPath.'joomla_patch.zip'))
		{
			$html .= "<p style=\"color:red\" >Please re-install Commmunity ACL. The file joomla_patch.zip was not uploaded properly!</p>";
			$status = false;
		}
		else
		{
			$html .= "<p style=\" color: green\"> joomla_patch.zip file uploaded successfully</p>";
		}

		$html .= '<div style="width:100%; float:left;"><b>' . JText::_('Community ACL Plugin') . '</b></div>';
		if(!file_exists($this->frontendPath.'plg_community_acl.zip'))
		{
			$html .= "<p style=\"color:red\" >Please re-install Commmunity ACL. The file plg_community_acl.zip was not uploaded properly!</p>";
			$status = false;
		}
		else
		{
			$html .= "<p style=\" color: green\"> plg_community_acl.zip file uploaded successfully</p>";
		}

		$joomSocial = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_community' . DS . 'admin.community.php';
		if(file_exists($joomSocial)){//JoomSocial exists
			$html .= '<div style="width:100%; float:left;"><b>' . JText::_('Community ACL /JoomSocial Plugin') . '</b></div>';
			if(!file_exists($this->frontendPath.'cacl_joomsocial.zip'))
			{
				$html .= "<p style=\"color:red\" >Please re-install Commmunity ACL. The file cacl_joomsocial.zip was not uploaded properly!</p>";
				$status = false;
			}
			else
			{
				$html .= "<p style=\" color: green\"> plg_community_acl.zip file uploaded successfully</p>";
			}
		}
		$link = rtrim( JURI::root() , '/' ) . '/administrator/index.php?option=com_community_acl&task=install&step=2';
		$message .= $html;
		$message .= "<input type=\"button\" class=\"button-next\" onclick=\"window.location = '". $link ."'\" value=\"Next\"/>";

		return $message;
	}

	function installJoomla_Plugin(){

		$db =& JFactory::getDBO();
		$this->frontendPath	   	= JPATH_ROOT . DS . 'components' . DS . 'com_community_acl' . DS;
		$this->backendPath   	= JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_community_acl' . DS;

		$html = '';
		$status = false;
		$html .= '<div id="timer" style="display:none"></div>';
		$html .= '<div id="installSuccesMsg" style="width:100%; float:left;">'.JText::_('Extracting Files...');
		$plg_cacl_zip			= $this->frontendPath . 'plg_community_acl.zip';

		$link = rtrim( JURI::root() , '/' ) . '/administrator/index.php?option=com_community_acl&task=install&step=3';
		$html .= "";
		$message = "";
		$message .= "<br/>";
		$autoSubmit = "";
		#Unzip and Install Joomla! Plugin - (Frontend)
		$plg_destination 		= JPATH_ROOT . DS ."plugins/system/";
		if( caclInstaller::extractArchive( $plg_cacl_zip , $plg_destination ) )
		{
			$autoSubmit .= caclInstaller::getAutoSubmitFunction();
			$message .= $autoSubmit.$html;

			//Inject the Insert query into DB
			$query = "SELECT element FROM #__plugins WHERE `element` = 'community_acl'";
			$db->setQuery( $query );
			$element = $db->loadResult();
			if($element){ //it exists
				#- Delete the record
				$query = "DELETE FROM #__plugins WHERE `element` = 'community_acl'";
				$db->setQuery( $query );
				$db->query();
			}
			#- Insert record into DB
			$query = "INSERT INTO `#__plugins`
						(`id`, `name`, `element`, `folder`, `access`, `ordering`, `published`,
							`iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`)
								VALUES
									('', 'System - Community ACL', 'community_acl', 'system', 0,
										 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '')";
			$db->setQuery( $query );
			$db->query();
			$status = true;

		}
		else
		{
			$html .= "<br/>";
			$errorMsg .= "<p style=\"color: red\">System - Community ACL Plugin installation Failed! Please use the supplied install files to manually install this Joomla! plugin. This is a plugin that is required by Community ACL.</p>";
			$message .= $html.$errorMsg;
		}

		$plg_destination 		= JPATH_ROOT . DS ."plugins/user/";
		$plg_cacl_zip			= $this->frontendPath . 'plug_user_community_acl.zip';

		if( caclInstaller::extractArchive( $plg_cacl_zip , $plg_destination ) )
		{
			$autoSubmit .= caclInstaller::getAutoSubmitFunction();

			#- Insert record into DB
			$query = "INSERT INTO `#__plugins`
						(`id`, `name`, `element`, `folder`, `access`, `ordering`, `published`,
							`iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`)
								VALUES
									('', 'User Registration Community ACL', 'community_acl', 'user',
										0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '')";
			$db->setQuery( $query );
			$db->query();
		}
		else
		{
			$html .= "<br/>";
			$errorMsg .= "<p style=\"color: red\">User Registration Plugin installation Failed! Please use the supplied install file (plug_user_community_acl.zip) to manually install this Joomla! plugin. This is a plugin that is required by Community ACL.</p>";
			$message .= $html.$errorMsg;
		}

		#Patch the Plugin Authentication File
		$plugin_name		= $this->frontendPath . 'plug_redirect_acl.zip';
		$destination 		= JPATH_ROOT . DS . 'plugins/authentication/';

		if(caclInstaller::extractArchive($plugin_name, $destination)){
			$autoSubmit .= caclInstaller::getAutoSubmitFunction();
			$message = $autoSubmit.$html;
			//Inject the Insert query into DB
			$query = "SELECT element FROM `#__plugin` WHERE `element` = 'community_acl' AND `folder` = 'authentication'";
			$db->setQuery( $query );
			$element = $db->loadResult();
			if($element){ //it exists
				#- Delete the record
				$query = "DELETE FROM `#__plugin` WHERE `element` = 'community_acl' AND `folder` = 'authentication'";
				$db->setQuery( $query );
				$db->query();
			}
			#- Insert record into DB
			$query = "INSERT INTO `#__plugins` (`id`, `name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`) VALUES
						('', 'User - Community ACL', 'community_acl', 'authentication', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '')";
			$db->setQuery( $query );
			$db->query();
		}else{
			$errorMsg .= "<p style='color:red'>Unable to extract plug_redirect_acl.zip</p>";
			$message .= $html.$errorMsg;
		}

		$inputbox = "</div><table width=\"100%\" border=\"0\"><tr><td><input type=\"button\" class=\"button-next\" onclick=\"window.location = '". $link ."'\" value=\"Next\"/>
						</td></tr></table>";

		$message .= $inputbox;

		return $message;
	}

	function installPatch_files()
	{

		$html = '';
		$autoSubmit = '';
		$message = '';
		$errorMsg = '';

		$this->frontendPath	   	= JPATH_ROOT . DS . 'components' . DS . 'com_community_acl' . DS;
		$this->backendPath   	= JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_community_acl' . DS;
		$html .= '<div id="timer" style="display:none"></div>';
		$html .= '<div id="installSuccesMsg"><div id="timer"></div><div style="width:100%; float:left;">'.JText::_('Extracting Files...').'</div><br/>';

		#Unzip and Patch Files - REPLACE the 2 FILES

		#Unzip Community ACL Frontend Patched Menus Files
		$plg_destination 		= JPATH_ROOT . "/plugins/system/";
		$joomla_patch_zip       = $this->frontendPath. "cacl_joomsocial.zip";
		$html .= '<div style="width:100%; float:left;">'.JText::_('Installing cacl_joomsocial...').'</div><br/>';

		$db =& JFactory::getDBO();
		//check if joomSocial is installed first of all...
		$joomSocial = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_community' . DS . 'admin.community.php';
		if(file_exists($joomSocial)){
			if( caclInstaller::extractArchive( $joomla_patch_zip , $plg_destination )){
				$query = "INSERT INTO `#__plugins` (`id`, `name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`) VALUES
							('', 'System - Community ACL JoomSocial', 'cacl_joomsocial', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '')";
				$db->setQuery( $query );
				$db->query();
				$autoSubmit .= caclInstaller::getAutoSubmitFunction();
				$message .= $autoSubmit.$html;

			}else{
				$errorMsg = "<p style='color:red'>Unable to install cacl_joomsocial  - Please manually install cacl_joomsocial.zip located in this site folder of your package. </p>";
				$message .= $html.$errorMsg;
			}
		}


		#Unzip Community ACL Backend Patched Menus Files
		$plg_destination 		= JPATH_ROOT . "/plugins/system/";
		$joomla_patch_zip       = $this->frontendPath. "cacl_preprocessor.zip";
		$html .= '<div style="width:100%; float:left;">'.JText::_('Installing cacl_preprocessor...').'</div><br/>';

		if( caclInstaller::extractArchive( $joomla_patch_zip , $plg_destination )){
			$query = "INSERT INTO `#__plugins` (`id`, `name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`) VALUES
						('', 'System - Community ACL Preprocessor', 'cacl_preprocessor', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '')";
			$db->setQuery( $query );
			$db->query();
			$autoSubmit .= caclInstaller::getAutoSubmitFunction();
			$message .= $autoSubmit.$html;
		}else{
			$errorMsg = "<p style='color:red'>Unable to install cacl_preprocessor - Please manually install cacl_preprocessor.zip located in this site folder of your package.</p>";
			$message .= $html.$errorMsg;
		}

		# - Updating the frontend
		/*$query = " SELECT * FROM `#__modules` " .
				 " WHERE `module` LIKE 'mod_mainmenu' " .
				 " AND `published` = 1"
				 ;
		$db->setQuery( $query );
		$fronted_menu_modules = $db->loadObjectList();

		foreach($fronted_menu_modules as $fronted_menu_module){
			$query = "INSERT INTO `#__modules` " .
					 "	SET title = '{$fronted_menu_module->title}', " .
					 "	`content` = '{$fronted_menu_module->content}', " .
					 "	`ordering` = {$fronted_menu_module->ordering}, " .
					 "	`position` = '{$db->getEscaped($fronted_menu_module->position)}', " .
					 "	`checked_out` = {$fronted_menu_module->checked_out}, " .
					 "	`checked_out_time` = '{$fronted_menu_module->checked_out_time}', " .
					 "	`published` = 1, " .
					 "	`module` = 'mod_commacl_mainmenu', " .
					 "	`numnews` = {$fronted_menu_module->numnews}, " .
					 "	`access` = {$fronted_menu_module->access}, " .
					 "	`showtitle` = {$fronted_menu_module->showtitle}, " .
					 "	`params` = '{$db->getEscaped($fronted_menu_module->params)}', " .
					 "	`iscore` = {$fronted_menu_module->iscore}, " .
					 "	`client_id` = {$fronted_menu_module->client_id}, " .
					 "	`control` = '{$fronted_menu_module->control}'"
					 ;
			$db->setQuery( $query );
			$db->query();
		}

		$query = "UPDATE `#__modules` SET published = '0' " .
					" WHERE `module` LIKE 'mod_mainmenu' AND `published` = 1 ";
		$db->setQuery( $query );
		$db->query();

		# - Updating the backend
		$query = " SELECT * FROM `#__modules` " .
				 " WHERE `module` LIKE 'mod_menu' " .
				 " AND `published` = 1"
				 ;
		$db->setQuery( $query );
		$backend_menu_modules = $db->loadObjectList();

		foreach($backend_menu_modules as $backend_menu_module){
			$query = "INSERT INTO `#__modules` " .
					 "	SET title = '{$backend_menu_module->title}', " .
					 "	content = '{$backend_menu_module->content}', " .
					 "	ordering = {$backend_menu_module->ordering}, " .
					 "	position = '{$backend_menu_module->position}', " .
					 "	checked_out = {$backend_menu_module->checked_out}, " .
					 "	checked_out_time = '{$backend_menu_module->checked_out_time}', " .
					 "	published = 1, " .
					 "	module = 'mod_commacl_menu', " .
					 "	numnews = {$backend_menu_module->numnews}, " .
					 "	access = {$backend_menu_module->access}, " .
					 "	showtitle = {$backend_menu_module->showtitle}, " .
					 "	params = '{$db->getEscaped($backend_menu_module->params)}', " .
					 "	iscore = {$backend_menu_module->iscore}, " .
					 "	client_id = {$backend_menu_module->client_id}, " .
					 "	control = '{$backend_menu_module->control}'"
					 ;
			$db->setQuery( $query );
			$db->query();
		}

		$query = "UPDATE `#__modules` SET published = '0' " .
					" WHERE `module` LIKE 'mod_menu' AND `published` = 1 ";
		$db->setQuery( $query );
		$db->query();


		$query = " SELECT id FROM `#__modules` " .
				 " WHERE `module` LIKE 'mod_mainmenu' "
				 ;
		$db->setQuery( $query );
		$jMainmenu_ids = $db->loadResultArray();

		$query = " SELECT id FROM `#__modules` " .
				 " WHERE `module` LIKE 'mod_commacl_mainmenu' "
				 ;
		$db->setQuery( $query );
		$caclMainmenu_ids = $db->loadResultArray();

		for($i=0; $i<count($jMainmenu_ids); $i++){
			$query = " SELECT menuid FROM `#__modules_menu` " .
				 " WHERE `moduleid` = {$jMainmenu_ids[$i]} "
				 ;
			$db->setQuery( $query );
			$menuid_results = $db->loadObjectList();

			if(count($menuid_results) > 0)
			foreach($menuid_results as $menuid){
				$query = "INSERT INTO `#__modules_menu` " .
					 "	SET `moduleid` = {$caclMainmenu_ids[$i]}, " .
					 "	`menuid` = {$menuid->menuid} "
					 ;
				$db->setQuery( $query );
				$db->query();
			}
		}*/


		/*$query = " SELECT id FROM `#__modules` " .
				 " WHERE `module` LIKE 'mod_commacl_mainmenu' "
				 ;
		$db->setQuery( $query );
		$backend_menu_module_ids = $db->loadObjectList();


		$query = "INSERT INTO `#__modules_menu` " .
					 "	SET `moduleid` = {$backend_menu_module_id}, " .
					 "	`menuid` = 0 "
					 ;
		$db->setQuery( $query );
		$db->query();*/



		#Unzip Joomla Patch for Administrator
		/*$plg_destination 		= JPATH_ROOT . "/administrator/modules/mod_menu/";
		$joomla_patch_zip       = $this->frontendPath. "joomla_patch_administrator.zip";
		$html .= '<div style="width:100%; float:left;">'.JText::_('Patching Mod_menu...').'</div><br/>';
		$autoSubmit = '';
		$message = '';
		$errorMsg = '';

		if( caclInstaller::extractArchive( $joomla_patch_zip , $plg_destination )){
			$autoSubmit .= caclInstaller::getAutoSubmitFunction();
			$message .= $autoSubmit.$html;

				#move the file over
				$plg_destination 		= JPATH_ROOT . "/administrator/modules/mod_menu/";
				$filename       		= JPATH_ROOT . "/administrator/modules/mod_menu/joomla_patch_administrator/helper.php";
				if(caclInstaller::moveFile($filename, $plg_destination)){
					$autoSubmit .= caclInstaller::getAutoSubmitFunction();
					$message = $autoSubmit.$html;
				}
				else{
					$errorMsg .= "<p style='color:red'>Unable to move Helper.php file over to mod_menu</p>";
					$message .= $html.$errorMsg;
				}
		}else{
			$errorMsg = "<p style='color:red'>Unable to patch Mod_menu - Please manually patch helper.php file located at this path:".$joomla_patch_zip." using the file located in the zip file: joomla_patch_administrator.zip </p>";
			$message = $html.$errorMsg;
		}


		#Unzip Joomla Patch for Modules
		#Check to make that Mod_mainmenu exists first of all.
		if(file_exists(JPATH_ROOT . "modules/mod_mainmenu/helper.php")){
			#Unzip and Patch the Libraries
			$plg_destination 		= JPATH_ROOT . "/libraries/joomla/application/module/";
			$joomla_patch_zip 		= $this->frontendPath."joomla_patch_libraries.zip";
			$html = '<div style="width:100%; float:left;">'.JText::_('Patching Library modules...').'</div><br/>';
			if( caclInstaller::extractArchive( $joomla_patch_zip , $plg_destination )){
				$autoSubmit .= caclInstaller::getAutoSubmitFunction();
				$message = $autoSubmit.$html;
				#move the file over
				$plg_destination 		= JPATH_ROOT . "/libraries/joomla/application/module/";
				$filename       		= JPATH_ROOT . "/libraries/joomla/application/module/joomla_patch_libraries/helper.php";
				if(caclInstaller::moveFile($filename, $plg_destination)){
					$autoSubmit .= caclInstaller::getAutoSubmitFunction();
					$message = $autoSubmit.$html;
				}
				else{
					$errorMsg .= "<p style='color:red'>Unable to move Helper.php file over to mod_mainmenu</p>";
					$message .= $html.$errorMsg;
				}
			}else{
				$errorMsg .= "<p style='color:red'>Unable to patch libraries</p>";
				$message .= $html.$errorMsg;
			}

			#Unzip and Patch the Modules
			$plg_destination 		= JPATH_ROOT . "/modules/mod_mainmenu/";
			$joomla_patch_zip = $this->frontendPath."joomla_patch_modules.zip";
			$html = '<div style="width:100%; float:left;">'.JText::_('Patching Main menu module...').'</div><br/>';
			if( caclInstaller::extractArchive( $joomla_patch_zip , $plg_destination )){
				$autoSubmit .= caclInstaller::getAutoSubmitFunction();
				$message = $autoSubmit.$html;
				#move the file over
				$plg_destination 		= JPATH_ROOT . "/modules/mod_mainmenu/";
				$filename       		= JPATH_ROOT . "/modules/mod_mainmenu/joomla_patch_libraries/helper.php";
				if(caclInstaller::moveFile($filename, $plg_destination)){
					$autoSubmit .= caclInstaller::getAutoSubmitFunction();
					$message = $autoSubmit.$html;
				}
				else{
					$errorMsg .= "<p style='color:red'>Unable to move Helper.php file over to mod_mainmenu</p>";
					$message .= $html.$errorMsg;
				}
				#-Legacy file
				$filename       		= JPATH_ROOT . "/modules/mod_mainmenu/joomla_patch_libraries/legacy.php";
				if(caclInstaller::moveFile($filename, $plg_destination)){
					$autoSubmit .= caclInstaller::getAutoSubmitFunction();
					$message = $autoSubmit.$html;
				}
				else{
					$errorMsg .= "<p style='color:red'>Unable to move Legacy.php file over to mod_mainmenu</p>";
					$message .= $html.$errorMsg;
				}

			}else{
				$errorMsg .= "<p style='color:red'>Unable to patch Mod_mainmenu</p>";
				$message .= $html.$errorMsg;
			}
			$message .= "</div>";
		}else{
			$errorMsg .= "</div><p style='color:blue'>Community ACL can not find the Joomla! mod_mainmenu module to patch. Will this cause issues for your installation? NO! -
			This just means that any menus you disallow will be visible to your users - they will however not have access to the what you have blocked the user from doing.</p><p style='color:green'>It is safe to continue forward.</p>";
			$message .= $errorMsg;

		}*/
		$frontendPath  = JPATH_ROOT . DS . 'components' .  DS;
		$comprofiler_filepath = $frontendPath."com_comprofiler/plugin/user/index.html";
		if(file_exists($comprofiler_filepath))
			$value = 'Next';
		else
			$value = 'Finish';

		$link = rtrim( JURI::root() , '/' ) . '/administrator/index.php?option=com_community_acl&task=install&step=4';
		$inputbox = "</div></div><div><table width=\"100%\" border=\"0\"><tr><td><input type=\"button\" class=\"button-next\" onclick=\"window.location = '". $link ."'\" value=\"{$value}\"/>
						</td></tr></table></div>";
		return $message.$inputbox;
	}

	function installCB_Plugin( ){
		$html = '';
		$message = '';
		$autoSubmit = '';
		$errorMsg = '';
		$db =& JFactory::getDBO();
		$this->frontendPath	   	= JPATH_ROOT . DS . 'components' . DS . 'com_community_acl' . DS;
		$this->backendPath   	= JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_community_acl' . DS;
		$html = '<div id="timer" style="display:none"></div>';
		$html .= '<div id="installSuccesMsg"><div id="timer"></div><div style="width:100%; float:left;">'.JText::_('Extracting Files...').'</div><br/>';

		$default_link = rtrim( JURI::root() , '/' ) . '/administrator/index.php?option=com_community_acl&task=install&step=5';
		$installCB_link = rtrim( JURI::root() , '/' ) . '/administrator/index.php?option=com_community_acl&task=install&step=4&installCB=yes';
		$installCB = JRequest::getVar('installCB');

		if($installCB != 'yes'){
			$autoSubmit .= caclInstaller::getAutoSubmitFunction();
			$html .= $autoSubmit;
		$html .="</div>
			<table><tr><td><h3>Would you like to install Community Builder Plugin?</h3></td></tr>
			<tr><td><input type=\"button\" id=\"btnYes\" name=\"btnYes\" value=\"Yes\" onclick=\"window.location='". $installCB_link ."'\" /></td>
			<td><input type=\"button\" id=\"btnNo\" name=\"btnNo\" value=\"No\" onclick=\"window.location='". $default_link ."'\" /></td></tr>
			</table>";
		}
		if($installCB == 'yes'){//Install CB Plugin


			#update comprofiler table
			caclInstaller::updateCB_db();
			$cb_plugin_zip		= $this->frontendPath . 'plug_cacl_userreg.zip';
			#unzip Joomla File
			$destination 			= JPATH_ROOT . DS . 'components' . DS .'com_comprofiler/plugin/user/plug_communityaclregistrationplugin/';
			$plg_destination 		= $destination;

			if( caclInstaller::extractArchive( $cb_plugin_zip , $plg_destination ) )
			{
				$autoSubmit .= caclInstaller::getAutoSubmitFunction();
				$message .= $autoSubmit.$html;

				//Inject the Insert query into DB
				$query = "SELECT element FROM #__comprofiler_plugin WHERE `element` = 'userreg'";
				$db->setQuery( $query );
				$element = $db->loadResult();
				if($element){ //it exists
					#- Delete the record
					$query = "DELETE FROM #__comprofiler_plugin WHERE `element` = 'userreg'";
					$db->setQuery( $query );
					$db->query();
				}
				#- Insert record into DB
				$query = "INSERT INTO `#__comprofiler_plugin`
							(`id`, `name`, `element`, `type`, `folder`, `backend_menu`, `access`, `ordering`, `published`, `iscore`,
								`client_id`, `checked_out`, `checked_out_time`, `params`)
									VALUES ('', 'Community ACL Registration Plugin', 'userreg',
										'user', 'plug_cacl_userreg', '', 0, 99, 1, 0, 0, 0, '0000-00-00 00:00:00', '')";
				$db->setQuery( $query );
				$db->query();
			}
			else
			{
				$errorMsg .= "<p style='color:red'>Unable to extract plug_cacl_userreg.zip</p>";
				$message .= $html.$errorMsg;
			}


		$link = rtrim( JURI::root() , '/' ) . '/administrator/index.php?option=com_community_acl&task=install&step=5';
		$inputbox = "</div></div><div ><table width=\"100%\" border=\"0\"><tr><td><input type=\"button\" class=\"button-next\" onclick=\"window.location = '". $link ."'\" value=\"Finish\"/>
						</td></tr></table></div>";

		$message .= $inputbox;
		}

		return $html.$message;
	}

	function extractArchive( $source , $destination )
	{
		// Cleanup path
		$destination	= JPath::clean( $destination );
		$source			= JPath::clean( $source );

		return JArchive::extract( $source , $destination );
	}
    function moveFile ($source, $destination)
    {
        //Cleanup path        $destination = JPath::clean($destination);
        $source = JPath::clean($source);
        return JFile::move($source, $destination);
    }
    function updateCB_db ()
    {
        $db = & JFactory::getDBO();
        $cbVersion = caclInstaller::get_xml_tag_value('version',
        'com_comprofiler');
        if (version_compare($cbVersion, '1.2.2', '>=')) {
            $query = "ALTER TABLE `#__comprofiler` ADD `cb_caclmembertype` VARCHAR(255) NOT NULL DEFAULT ''";
        } else {
            $query = "ALTER TABLE `#__comprofiler` ADD `cb_caclmembertype` INT( 11 ) NOT NULL DEFAULT '0'";
        }
        $db->setQuery($query);
        $db->query();
        $cb_caclmemebertype_search = NULL;
        $query = "SELECT `fieldid` FROM `#__comprofiler_fields` WHERE `tablecolumns` = 'cb_caclmembertype' AND `table` = '#__comprofiler' ";
        $db->setQuery($query);
        $cb_caclmemebertype_search = $db->loadResult();
        if (is_null($cb_caclmemebertype_search)) {
            //Disable the Dropdown list
            $query = "INSERT INTO `#__comprofiler_fields` (`fieldid`, `name`, `tablecolumns`, `table`, `title`, `description`, `type`, `maxlength`, `size`, `required`, `tabid`, `ordering`, `cols`, `rows`, `value`, `default`, `published`, `registration`, `profile`, `displaytitle`, `readonly`, `searchable`, `calculated`, `sys`, `pluginid`, `params`) VALUES
						('', 'cb_caclmembertype', 'cb_caclmembertype', '#__comprofiler', 'Registration Membership Type', '', 'select', 0, 0, 0, 11, -27, 0, 0, NULL, '1', 1, 1, 1, 1, 0, 0, 0, 0, 1, '');
							";
            $db->setQuery($query);
            $db->query();
        } else {
            //Enable the Dropdown list
            $query = "UPDATE `#__comprofiler_fields` SET published = '1' " .
             " WHERE `tablecolumns` = 'cb_caclmembertype' AND `table` = '#__comprofiler' ";
            $db->setQuery($query);
            $db->query();
        }
    }

	function updateCACL_tables(){	    /**	     * These alter tables need to be replaced with this	     *			delimiter $$            DROP PROCEDURE IF EXISTS addcol $$            CREATE PROCEDURE addcol()            BEGIN              IF NOT EXISTS(                SELECT * FROM information_schema.COLUMNS                WHERE COLUMN_NAME='redirect_FRONT' AND TABLE_NAME='jos_community_acl_users' AND TABLE_SCHEMA='Joomla_1.5.22_cACL_1.3'              )              THEN                ALTER TABLE `jos_community_acl_users` ADD `redirect_FRONT` TEXT NOT NULL, ADD `redirect_ADMIN` TEXT NOT NULL;              END IF;            END $$            CALL addcol()$$            DROP PROCEDURE IF EXISTS addcol $$            delimiter ;	     */

		# - UPDATES for Community ACL
		$db =& JFactory::getDBO();

		$db->setQuery( "ALTER TABLE `#__community_acl_users` ADD `redirect_FRONT` TEXT NOT NULL, ADD `redirect_ADMIN` TEXT NOT NULL" );
		$db->query();

		$query = "ALTER TABLE `#__community_acl_function_access` ADD `extra` tinyint(4) NOT NULL default '1'";
		$db->setQuery( $query );
		$db->query();

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

		// Makes changes in the groups table for former installs
		$db->setQuery("ALTER TABLE `#__community_acl_groups` CHANGE ` redirect_URL_FRONT` `redirect_URL_FRONT` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , CHANGE `redirect_URL_ADMIN` `redirect_URL_ADMIN` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL " );
		$db->query();

		// Updates the Community ACL Roles tables
		$db->setQuery("ALTER TABLE `#__community_acl_roles` ADD `redirect_FRONT` TEXT NOT NULL , ADD `redirect_ADMIN` TEXT NOT NULL");
		$db->query();

		// Updates the Community Groups tables
		$db->setQuery("ALTER TABLE `#__community_acl_groups` ADD `redirect_URL_FRONT` TEXT NOT NULL , ADD `redirect_URL_ADMIN` TEXT NOT NULL");
		$db->query();
		// Updates the Community ACL users tables

		$db->setQuery("ALTER TABLE `#__community_acl_users` ADD `cb_member_type` INT(11) NOT NULL");
		$db->query();


		// Updates the Community CB Roles tables
		$db->setQuery("ALTER TABLE `#__community_acl_cb_roles` DROP `cb_member_type`");
		$db->query();


		//ALTER TABLE `jos_community_acl_cb_roles` DROP `cb_member_type`
	}	function get_xml_tag_value($tag, $option = null) {		if (! $option) {			$option = JRequest::getVar ( 'option' );		}		$admin_dir = JPATH_ADMINISTRATOR . DS . 'components';		$site_dir = JPATH_SITE . DS . 'components';		/* Get the component folder and list of xml files in folder */		$folder = $admin_dir . DS . $option;		if (JFolder::exists ( $folder )) {			$xml_files_in_dir = JFolder::files ( $folder, '.xml$' );		} else {			$folder = $site_dir . DS . $option;			if (JFolder::exists ( $folder )) {				$xml_files_in_dir = JFolder::files ( $folder, '.xml$' );			} else {				$xml_files_in_dir = null;			}		}		$value = '';		if (count ( $xml_files_in_dir )) {			foreach ( $xml_files_in_dir as $xmlfile ) {				// Read the file to see if it's a valid component XML file				$xml = & JFactory::getXMLParser ( 'Simple' );				if (! $xml->loadFile ( $folder . DS . $xmlfile )) {					continue;				}				if (! is_object ( $xml->document ) || $xml->document->name () != 'install') {					continue;				}				$value = '';				$element = &$xml->document->{$tag} [0];				$value = $element ? $element->data () : '';				if ($value) {					break;				}			}		}		if (isset ( $value )) {			return $value;		} else {			return 0;		}	}

}
