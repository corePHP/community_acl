<?php
// ver 05-02-2009
// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.plugin.plugin' );
require_once (JPATH_SITE . '/administrator/components/com_community_acl/community_acl.functions.php');
$mainframe->registerEvent ( 'onPrepareContent', 'plgContentCACL' );
function plgContentCACL(&$row, &$params, $page = 0) {
	if (! file_exists ( JPATH_SITE . '/administrator/components/com_community_acl/community_acl.class.php' ))
		return;
	if (! isset ( $row->id ) || $row->id < 1)
		return;
	$user = & JFactory::getUser ();
	if ($user->get ( 'gid' ) == 25) {
		return;
	}
	$db = & JFactory::getDBO ();
	require_once (JPATH_SITE . '/administrator/components/com_community_acl/community_acl.class.php');
	require_once (JPATH_SITE . '/administrator/components/com_community_acl/community_acl.functions.php');
	$option = JRequest::getVar ( 'option' );
	$task = JRequest::getVar ( 'task' );
	$config = new CACL_config ( $db );
	$config->load ();

	$app = & JFactory::getApplication ();
	//adding cACL Activate
	if( FALSE === strpos($config->activate, $app->getName())){
		return;
	}

	$id = $row->id;
	$catid = $row->catid;
	$sectionid = $row->sectionid;
	$option = strtolower ( JRequest::getVar ( 'option', 'com_content', 'default', 'cmd' ) );
	if ($option != 'com_sections' && $option != 'com_categories' && $option != 'com_content')
		return;
	$user_access = cacl_get_user_access ( $config );
	$groups = $user_access ['groups'];
	$roles = $user_access ['roles'];
	$functions = $user_access ['functions'];
	/*echo '<pre>';
	 print_r($user_access);
	 echo '</pre>';*/
	//no groups/roles/functions for user
	if (! (count ( $groups ) > 1 && count ( $roles ) > 1))
		return;
	$app = & JFactory::getApplication ();
	$back_end = false;
	if ($app->getName () != 'site') {
		$back_end = true;
	}
	$query = "SELECT * FROM `#__community_acl_access` WHERE `option` IN ('menu', 'com_sections', 'com_categories', 'com_content' ) AND `name` <> '###' AND " . ($back_end ? ' `isbackend` = 1 ' : ' `isfrontend` = 1 ') . " AND ( `group_id` IN ( '" . implode ( "','", $groups ) . "') OR `role_id` IN ( '" . implode ( "','", $roles ) . "') )";
	$db->setQuery ( $query );
	$access = $db->loadObjectList ();
	$froles = array ();
	$fgroups = array ();
	$lang = & JFactory::getLanguage ();
	$lang->load ( 'plg_system_community_acl' );
	if (is_array ( $access ) && count ( $access ) > 0) {
		foreach ( $access as $item ) {
			//forbidden content, sections, categiries
			if (! $back_end) {
				if ($option == 'com_content' && @$view == 'section' && $item->option == 'com_sections' && $id == $item->value) {
					if ($item->role_id == '0')
						$fgroups [] = $item->group_id;
					else
						$froles [] = $item->role_id;
				}
				if ($option == 'com_content' && @$view == 'category' && $item->option == 'com_categories' && $id == $item->value) {
					if ($item->role_id == '0')
						$fgroups [] = $item->group_id;
					else
						$froles [] = $item->role_id;
				}
				if ($option == 'com_content' && (@$view != 'section' && @$view != 'category') && $item->option == 'com_content' && $id == $item->value) {
					if ($item->role_id == '0')
						$fgroups [] = $item->group_id;
					else
						$froles [] = $item->role_id;
				}
				if ($option == 'com_content' && @$view == 'category' && $item->option == 'com_sections' && $sectionid == $item->value) {
					if ($item->role_id == '0')
						$fgroups [] = $item->group_id;
					else
						$froles [] = $item->role_id;
				}
				if ($option == 'com_content' && (@$view != 'section' && @$view != 'category') && (($item->option == 'com_sections' && $sectionid == $item->value) || ($item->option == 'com_categories' && $catid == $item->value))) {
					if ($item->role_id == '0')
						$fgroups [] = $item->group_id;
					else
						$froles [] = $item->role_id;
				}
			}
		}
	}
	$rows = $groups;
	$rls = $roles;
	if ($config->default_action == 'allow') {
		if (is_array ( $rows ) && count ( $rows ) > 0)
			foreach ( $rows as $i => $group ) {
				$ind = array_search ( $group, $groups );
				if (in_array ( $group, $fgroups ) && $ind !== false) {
					unset ( $groups [$ind] );
					unset ( $roles [$ind] );
					unset ( $functions [$ind] );
				}
				$ind = array_search ( $rls [$i], $roles );
				if (in_array ( $rls [$i], $froles ) && $ind !== false) {
					unset ( $groups [$ind] );
					unset ( $roles [$ind] );
					unset ( $functions [$ind] );
				}
			}
		if (! (count ( $groups ) > 1 && count ( $roles ) > 1)) {
			if (isset ( $row->fulltext )) {
				if ($config->forbidden_content == '1')
					$row->fulltext = JText::_ ( 'ALERTNOACCESS' );
				else
					$row->text = '';
			}
			if (isset ( $row->text )) {
				if ($config->forbidden_content == '0')
					$row->text = '';
				elseif ($config->forbidden_content == '1')
					$row->text = JText::_ ( 'ALERTNOACCESS' );
				elseif (isset ( $row->introtext ) && $config->forbidden_content == '2')
					$row->text = $row->introtext;
				elseif (isset ( $row->introtext ) && $config->forbidden_content == '3')
					$row->text = $row->introtext . '<br />' . JText::_ ( 'ALERTNOACCESS' );
				else
					$row->text = '';
			}
			if (isset ( $row->introtext )) {
				if ($config->forbidden_content == '0')
					$row->introtext = '';
				elseif ($config->forbidden_content == '1')
					$row->introtext = JText::_ ( 'ALERTNOACCESS' );
				elseif ($config->forbidden_content == '2')
					$row->introtext = $row->introtext;
				elseif ($config->forbidden_content == '3')
					$row->introtext = $row->introtext . '<br />' . JText::_ ( 'ALERTNOACCESS' );
			}
			return;
		}
	} else {
		//print_r($rows);
		if (is_array ( $rows ) && count ( $rows ) > 0)
			foreach ( $rows as $i => $group ) {
				$ind = array_search ( $group, $groups );
				if (! in_array ( $group, $fgroups ) && $ind !== false) {
					$groups [$ind] = - 1;
					if (! in_array ( $roles [$ind], $froles )) {
						$roles [$ind] = - 1;
						$functions [$ind] = - 1;
					}
				}
				$ind = array_search ( $rls [$i], $roles );
				if (! in_array ( $rls [$i], $froles ) && $ind !== false) {
					$roles [$ind] = - 1;
					if (! in_array ( $groups [$ind], $fgroups )) {
						$groups [$ind] = - 1;
						$functions [$ind] = - 1;
					}
				}
			}

		//print_r($groups);
		$groups = array_unique ( $groups );
		$roles = array_unique ( $roles );
		$functions = array_unique ( $functions );
		if ((count ( $groups ) == 1 && count ( $roles ) == 1)) {
			if (isset ( $row->fulltext )) {
				if ($config->forbidden_content == '1')
					$row->fulltext = JText::_ ( 'ALERTNOACCESS' );
				else
					$row->text = '';
			}
			if (isset ( $row->text )) {
				if ($config->forbidden_content == '0')
					$row->text = '';
				elseif ($config->forbidden_content == '1')
					$row->text = JText::_ ( 'ALERTNOACCESS' );
				elseif (isset ( $row->introtext ) && $config->forbidden_content == '2')
					$row->text = $row->introtext;
				elseif (isset ( $row->introtext ) && $config->forbidden_content == '3')
					$row->text = $row->introtext . '<br />' . JText::_ ( 'ALERTNOACCESS' );
				else
					$row->text = '';
			}
			if (isset ( $row->introtext )) {
				if ($config->forbidden_content == '0')
					$row->introtext = '';
				elseif ($config->forbidden_content == '1')
					$row->introtext = JText::_ ( 'ALERTNOACCESS' );
				elseif ($config->forbidden_content == '2')
					$row->introtext = $row->introtext;
				elseif ($config->forbidden_content == '3')
					$row->introtext = $row->introtext . '<br />' . JText::_ ( 'ALERTNOACCESS' );
			}
			return;
		}
	}
}
class plgSystemCommunity_ACL extends JPlugin {
	function plgSystemCommunity_ACL(&$subject, $config) {
		parent::__construct ( $subject, $config );

		$db = & JFactory::getDBO ();
		$config = new CACL_config ( $db );
		$config->load ();
		$this->_caclConfig = $config;
	}
	/**
	 *
	 * id's==-1 relates to nothing selected from the select dropdowns
	 * id's==0 mean uncategorized. There is no id's==0 in sections or categories tables.
	 */
	function onAfterRender() {

		$app = & JFactory::getApplication ();
		//adding cACL Activate
		if( FALSE === strpos($this->_caclConfig->activate, $app->getName())){
			return;
		}

		global $mainframe;
		$session = & JFactory::getSession ();
		$loginredirect = $session->get ( 'redirect', '', 'cacl' );
		if ($loginredirect) {
			$session->clear ( 'redirect', 'cacl' );
			$mainframe->redirect ( $loginredirect );
		}
		if (! file_exists ( JPATH_SITE . '/administrator/components/com_community_acl/community_acl.class.php' ))
			return;
		$user = & JFactory::getUser ();
		if ($user->get ( 'gid' ) == 25) {
			return;
		}
		$option = strtolower ( JRequest::getVar ( 'option', 'com_content', 'default', 'cmd' ) );
		$task = strtolower ( JRequest::getVar ( 'task', 'register', 'default', 'cmd' ) );
		$db = & JFactory::getDBO ();
		require_once (JPATH_SITE . '/administrator/components/com_community_acl/community_acl.class.php');
		require_once (JPATH_SITE . '/administrator/components/com_community_acl/community_acl.functions.php');
		$config = new CACL_config ( $db );
		$config->load ();
		$user_access = cacl_get_user_access ( $config );
		$groups = $user_access ['groups'];
		$roles = $user_access ['roles'];
		$functions = $user_access ['functions'];
		$id = intval ( JRequest::getInt ( 'id' ) );
		if (! isset ( $_REQUEST ['id'] ))
			$id = - 1;
		$cid = JRequest::getVar ( 'cid', array (- 1 ), '', 'array' );
		JArrayHelper::toInteger ( $cid, array (- 1 ) );
		if ($id == - 1 && isset ( $cid [0] ))
			$id = $cid [0];
		$catid = - 1;
		$sectionid = - 1;
		if ($id > 0) {
			$query = "SELECT `catid`, `sectionid` FROM `#__content` WHERE `id` = '{$id}'";
			$db->setQuery ( $query );
			$content = $db->loadAssoc ();
			$catid = (is_array ( $content ) && isset ( $content ['catid'] ) ? $content ['catid'] : - 1);
			$sectionid = (is_array ( $content ) && isset ( $content ['sectionid'] ) ? $content ['sectionid'] : - 1);
		}
		//no groups/roles/functions for user
		if (! (count ( $groups ) > 1 && count ( $roles ) > 1)) {
			return;
		}
		//print_r(count($functions));
		if ($option == 'com_content' && count ( $functions ) > 1) {
			$lang = & JFactory::getLanguage ();
			$lang->load ( 'plg_system_community_acl' );
			$task = strtolower ( JRequest::getCmd ( 'task' ) );
			$view = strtolower ( JRequest::getCmd ( 'view' ) );
			$layout = strtolower ( JRequest::getCmd ( 'layout' ) );
			$sections = array ();

			if ($task == 'new' || $task == 'add' || ($view == 'article' && $layout == 'form')) {
				$query = "SELECT DISTINCT `item_id` FROM `#__community_acl_content_actions` WHERE `item_type` = 'section' AND `func_id` IN ('" . implode ( "','", $functions ) . "') AND `action` IN ('add') ORDER BY `item_id`";
				$db->setQuery ( @$query );
				$sections = $db->loadResultArray ();
			} elseif ($task == 'edit') {
				$query = "SELECT DISTINCT `item_id` FROM `#__community_acl_content_actions` WHERE `item_type` = 'section' AND `func_id` IN ('" . implode ( "','", $functions ) . "') AND `action` IN ('edit') ORDER BY `item_id`";
				$db->setQuery ( @$query );
				$sections = $db->loadResultArray ();
			}
			//print_r($query);
			/*SELECT DISTINCT `item_id` FROM `#__community_acl_content_actions` WHERE `item_type` = 'section' AND `func_id` IN ('-1','20') AND `action` IN ('add') ORDER BY `item_id`
			 */
			$categories = array ();
			if ($task == 'new' || $task == 'add' || ($view == 'article' && $layout == 'form')) {
				$query = "SELECT DISTINCT `item_id` FROM `#__community_acl_content_actions` WHERE `item_type` = 'category' AND `func_id` IN ('" . implode ( "','", $functions ) . "') AND `action` IN ('add') ORDER BY `item_id`";
				$db->setQuery ( @$query );
				$categories = $db->loadResultArray ();
			} elseif ($task == 'edit') {
				$query = "SELECT DISTINCT `item_id` FROM `#__community_acl_content_actions` WHERE `item_type` = 'category' AND `func_id` IN ('" . implode ( "','", $functions ) . "') AND `action` IN ('edit') ORDER BY `item_id`";
				$db->setQuery ( @$query );
				$categories = $db->loadResultArray ();
			}

			//print_r($query);
			$unsec = is_array ( $sections ) && in_array ( 0, $sections );
			$uncat = is_array ( $categories ) && in_array ( 0, $categories );
			if ($uncat) {
				$unsec = true;
			}

			if (is_array ( $sections ) || count ( $sections ) > 0) {
				if ($config->default_action == 'allow') {
					// get allowed sections
					$query = "SELECT `id` FROM #__sections WHERE `id` NOT IN ('" . implode ( "','", $sections ) . "') ";
					$db->setQuery ( $query );
					$sections = $db->loadResultArray ();
					// get allowed  categories
					$query = "SELECT DISTINCT `id`, `section`, `title` FROM `#__categories` WHERE `id` NOT IN ('" . implode ( "','", $categories ) . "') AND `section` IN ('" . implode ( "','", $sections ) . "')";
					$db->setQuery ( $query );
					$categories = $db->loadObjectList ();
				} else {
					$query = "SELECT DISTINCT `id` FROM `#__categories` WHERE `id` IN ('" . implode ( "','", $categories ) . "') OR `section` IN ('" . implode ( "','", $sections ) . "')";
					$db->setQuery ( $query );
					$categories = $db->loadResultArray ();
					$query = "SELECT `section` FROM `#__categories` WHERE `id` IN ('" . implode ( "','", $categories ) . "') OR `section` IN ('" . implode ( "','", $sections ) . "')";
					$db->setQuery ( $query );
					$tmp_sections = $db->loadResultArray ();
					// get allowed  categories
					$query = "SELECT DISTINCT `id`, `section`, `title` FROM `#__categories` WHERE `id` IN ('" . implode ( "','", $categories ) . "') OR `section` IN ('" . implode ( "','", $sections ) . "')";
					$db->setQuery ( $query );
					$categories = $db->loadObjectList ();
					// get allowed sections
					$query = "SELECT `id` FROM #__sections WHERE `id` IN ('" . implode ( "','", $tmp_sections ) . "') ";
					$db->setQuery ( $query );
					$sections = $db->loadResultArray ();
				}
			} elseif (is_array ( $categories ) || count ( $categories ) > 0) {
				if ($config->default_action == 'allow') {
					$query = "SELECT DISTINCT `section` FROM `#__categories` WHERE `id` NOT IN ('" . implode ( "','", $categories ) . "')";
					$db->setQuery ( $query );
					$sections = $db->loadResultArray ();
					// get allowed  categories
					$query = "SELECT DISTINCT `id`, `section`, `title` FROM `#__categories` WHERE `id` NOT IN ('" . implode ( "','", $categories ) . "')";
					$db->setQuery ( $query );
					$categories = $db->loadObjectList ();
				} else {
					$query = "SELECT DISTINCT `section` FROM `#__categories` WHERE `id` IN ('" . implode ( "','", $categories ) . "')";
					$db->setQuery ( $query );
					$sections = $db->loadResultArray ();
					// get allowed  categories
					$query = "SELECT DISTINCT `id`, `section`, `title` FROM `#__categories` WHERE `id` IN ('" . implode ( "','", $categories ) . "')";
					$db->setQuery ( $query );
					$categories = $db->loadObjectList ();
				}
			}

			if (is_array ( $sections ) && ! in_array ( 0, $sections ) && $unsec) {
				$sections [] = 0;
			}

			$groups = $user_access ['groups'];
			$roles = $user_access ['roles'];
			$submit_form_role_ids = implode ( ",", $roles );
			$submit_form_group_ids = implode ( ",", $groups );
			//print_r($submit_form_role_ids);
			$query = 'SELECT choices as choice ' . ' FROM `#__community_acl_submit_form_role_level`' . ' WHERE role_id IN ( ' . $submit_form_role_ids . ' ) ' . ' ORDER BY id ASC';
			$db->setQuery ( $query );
			$article_submission_r = $db->loadResultArray ();
			//if(!$submit_form_role_ids){ // if the setup for Roles is empty check the Groups
			$query = 'SELECT choices as choice ' . ' FROM `#__community_acl_submit_form_group_level`' . ' WHERE group_id IN ( ' . $submit_form_group_ids . ' ) ' . ' ORDER BY id ASC';
			$db->setQuery ( $query );
			$article_submission_gp = $db->loadResultArray ();
			//}
			//print_r($article_submission);die();


			//what is this for?
			// I still don't know —BUR 6/14/2011
			/**
			 * This does a return on /administrator/index.php?option=com_content
			 * while logged in as a manager with group/role/function attached and it shouldn't
			 * —BUR 8/4/2011
			 */
			if ( !$app->isAdmin() && 'com_content' != JRequest::getCmd('option')){
			if (! is_array ( $sections ) || count ( $sections ) < 1) {
				if ($view != 'article' && $layout != 'form')
					return;
			}

		//$_SESSION['cacl_redirect_url'] = $_SERVER['REQUEST_URI'];
			//$mainframe->redirect( $redirect_url, JText::_( 'ALERTNOTAUTH' ));
			}

			$functionIds = array_diff ( $functions, array ('-1', '0') );

			//BUR Limit section and category drop-downs - 10/5/2010
			if (count ( $functionIds ) < 1) {
				$query = "
				SELECT id
				FROM `#__sections`
				WHERE id
					" . ($config->default_action == 'allow' ? 'NOT IN' : 'IN') . " (
						SELECT value as id
						FROM `#__community_acl_access`
						WHERE
							(group_id IN (" . implode ( ',', $groups ) . ") || role_id IN (" . implode ( ',', $roles ) . ") ) &&
							`option`='com_sections' && `name`='cid'
						)
				";
				$db->setQuery ( $query );
				$newSections = $db->loadResultArray ();

				$query = "
				SELECT id,title,section
				FROM `#__categories`
				WHERE id
					" . ($config->default_action == 'allow' ? 'NOT IN' : 'IN') . " (
						SELECT value as id
						FROM `#__community_acl_access`
						WHERE
							(group_id IN (" . implode ( ',', $groups ) . ") || role_id IN (" . implode ( ',', $roles ) . ") ) &&
							`option`='com_categories' && `name`='cid'
						)
				";
				$db->setQuery ( $query );
				$newCategories = $db->loadObjectList ();

			} elseif ((empty($sections) || empty($categories)) && !empty($task) && is_int($id) ) {
				// —BUR 6/14/2011
				// articles need sections and categories
				// At this point we need to find where this article is located and populate the dropdowns.
				/*
				 *  SELECT `jos_community_acl_functions`.id,
					`jos_community_acl_content_actions`.item_type,
					GROUP_CONCAT( DISTINCT item_id) as item_ids
					FROM `jos_community_acl_functions`
					JOIN `jos_community_acl_content_actions`
					  ON `jos_community_acl_functions`.id=`jos_community_acl_content_actions`.func_id
					where `jos_community_acl_functions`.id IN (2) && item_type = 'content'
					GROUP BY item_type
				 */
				$query = "SELECT
					jos_categories.id as id,
					jos_categories.title as title,
					jos_sections.id as section
					FROM `jos_content`
					JOIN jos_categories
					 ON `jos_content`.catid=jos_categories.id
					JOIN jos_sections
					 ON jos_categories.section = jos_sections.id
					WHERE `jos_content`.id={$id}";
				$db->setQuery($query);

				$newCategories = $db->loadObjectList();
				$categories = $db->loadObjectList();
				$newSections = array($newCategories[0]->section);
				$sections = array($newCategories[0]->section);
			} else {
				$newSections = $sections;
				$newCategories = $categories;
			}
			//end BUR edit

			$sectioncategories = array ();
			foreach ( $newSections as $section ) {
				$sectioncategories [$section] = array ();
				$rows2 = array ();
				foreach ( $newCategories as $cat ) {
					if ($cat->section == $section) {
						$rows2 [] = $cat;
					}
				}
				foreach ( $rows2 as $row2 ) {
					$sectioncategories [$section] [] = JHTML::_ ( 'select.option', $row2->id, $row2->title, 'id', 'title' );
				}
			}
			$i = 1;
			$sc_html = "var sectioncategories = new Array;\nsectioncategories[-1] = new Array( '-1','-1','" . JText::_ ( '-Select Category-' ) . "' );\n\t\tsectioncategories[0] = new Array( '0','0','" . JText::_ ( 'Uncategorized' ) . "' );\n\t\t";
			foreach ( $sectioncategories as $k => $items ) {
				foreach ( $items as $v ) {
					$sc_html .= "sectioncategories[" . $i ++ . "] = new Array( '$k','" . addslashes ( $v->id ) . "','" . addslashes ( $v->title ) . "' );\n\t\t";
				}
			}
			//Kobby's edit - Article Submission Component START
			//Allowed Sections and Categories
			$query = "SELECT DISTINCT item_id FROM `#__community_acl_content_actions` WHERE `action` = 'publish'  AND `func_id` IN ( '" . implode ( "','", $functions ) . "') ";
			$db->setQuery ( $query );
			//$allowed_sections = $db->loadResultArray();
			$allowed_sections = $newSections; //Added correct sections -BUR 10/5/2010
			$total_sections = count ( $allowed_sections );
			$ids = implode ( ",", $allowed_sections );
			//check if the person has rights to edit/publish the article
			/*
			 * Check if the selected section_id EQUALS the allowed section_id
			 * 	then BINGO
			 * else
			 * Check if the selected category_id EQUALS the allowed category_id
			 * 	then BINGO
			 */
			/*$js = " var x;
			 var bingo = new Array();
			 bingo = [{$ids}];
			 document.adminForm.state1.checked = false;
			 document.adminForm.state0.checked = true;

			 for(x=0; x < {$total_sections}; x++){
			 if(document.adminForm.sectionid.options[document.adminForm.sectionid.selectedIndex].value == bingo[x] || document.adminForm.catid.options[document.adminForm.catid.selectedIndex].value == bingo[x]){
			 document.adminForm.state1.checked = true;
			 document.adminForm.state0.checked = false;
			 document.adminForm.state1.disabled = false;
			 document.adminForm.state0.disabled = false;
			 return;
			 }else{
			 document.adminForm.state1.checked = false;
			 document.adminForm.state0.checked = true;
			 document.adminForm.state1.disabled = true;
			 document.adminForm.state0.disabled = true;
			 }
			 }
			 ";*/
			$javascript = "onchange=\"changeDynaList( 'catid', sectioncategories, document.adminForm.sectionid.options[document.adminForm.sectionid.selectedIndex].value, 0, 0);\"";
			//Kobby's edit - Article Submission Component END
			//|| document.adminForm.catid.options[document.adminForm.catid.selectedIndex].value == bingo[x]
			// -BUR 10/5/2010
			if (! empty ( $newSections )) {
				$query = 'SELECT s.id, s.title FROM #__sections AS s WHERE s.id IN (' . implode ( ',', $newSections ) . ')' . ' ORDER BY s.ordering';
				$db->setQuery ( $query );
			}
			/*			if (!empty($sections)) {
			 $query = 'SELECT s.id, s.title'.' FROM #__sections AS s WHERE s.id IN ('.implode(',', $sections).')'.' ORDER BY s.ordering';
			 $db->setQuery($query);
			 }*/
			$uncat = false;
			if (in_array ( 0, $newSections )) {
				$uncat = true;
			}
			$sections = array ();
			$sections [] = JHTML::_ ( 'select.option', '-1', '- ' . JText::_ ( 'Select Section' ) . ' -', 'id', 'title' );
			if ($uncat) {
				$sections [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'Uncategorized' ), 'id', 'title' );
			}
			if ($db->loadObjectList ()) {
				$sections = array_merge ( $sections, $db->loadObjectList () );
			}
			$section_html = JHTML::_ ( 'select.genericlist', $sections, 'sectionid', 'class="inputbox" size="1" ' . $javascript, 'id', 'title', $sectionid );
			$cats = array ();
			$cats [] = JHTML::_ ( 'select.option', '-1', JText::_ ( 'Select Category' ), 'id', 'title' );

			//echo '<div><p>',__FILE__,': ',__LINE__,'</p><pre>',var_dump($sectionid),'</pre></div>';
			if ($sectionid > - 1) {
				$cats = array ();
				if (is_array ( $categories ) && count ( $categories ) > 0){
					foreach ( $categories as $cat ) {
						$cats [] = $cat->id;
					}
				}
				$query = 'SELECT id, title' . ' FROM #__categories WHERE `section` = \'' . $sectionid . '\' AND `id` IN (\'' . implode ( "','", $cats ) . '\')' . ' ORDER BY ordering';
				$db->setQuery ( $query );
				$cats = $db->loadObjectList ();
			} else {
				if (isset ( $_REQUEST ['filter_sectionid'] ) && $_REQUEST ['filter_sectionid'] > - 1) {
					$query = 'SELECT id, title FROM #__categories WHERE section=\'' . JRequest::getInt ( 'filter_sectionid' ) . '\'';
				} else {
					$query = 'SELECT id, title FROM #__categories';
				}
				$db->setQuery ( $query );
				$cats = $db->loadObjectList ();
				array_unshift ( $cats, JHTML::_ ( 'select.option', '-1', JText::_ ( '- Select Category -' ), 'id', 'title' ) );
			}
			$js = " var x;
					var bingo = new Array();
					bingo = [{$ids}];
					document.adminForm.state1.checked = false;
					document.adminForm.state0.checked = true;

					for(x=0; x < {$total_sections}; x++){
						if(document.adminForm.catid.options[document.adminForm.catid.selectedIndex].value == bingo[x]){
							document.adminForm.state1.checked = true;
							document.adminForm.state0.checked = false;
							document.adminForm.state1.disabled = false;
							document.adminForm.state0.disabled = false;
							return;
						}else{
							document.adminForm.state1.checked = false;
							document.adminForm.state0.checked = true;
							document.adminForm.state1.disabled = true;
							document.adminForm.state0.disabled = true;
						}
					}
				";
			//$javascript = "onchange=\"{$js}\"";
			//echo '<div><p>',__FILE__,': ',__LINE__,'</p><pre>',var_dump($cats),'</pre></div>';exit;
			$cat_html = JHTML::_ ( 'select.genericlist', $cats, 'catid', 'onchange="document.adminForm.submit( );" class="inputbox" size="1"', 'id', 'title', $catid );
			# - Kobby needs to work on this:..... for the articles that are under specified category.
			$html = JResponse::getBody ();
			//$html = preg_replace( '/sectioncategories\[.*\].*\([^\.)]*\)\;/i', '', $html );
			$html = preg_replace ( '/sectioncategories\[[^\]]*\].*?\);\s*/', '', $html ); //BUR 8/27/2010
			$html = str_replace ( 'var sectioncategories = new Array;', $sc_html, $html );
			$html = preg_replace ( '/<select[^>]*?name="sectionid"[^>]*?>.*?<\/select>/', $section_html, $html );
			//$html = preg_replace( '/\<select.*name\=\"sectionid\".*\<\/select\>/i', $section_html, $html );
			//$html = preg_replace('/\<select.*name\=\"catid\".*\<\/select\>/i', $cat_html, $html);

			if (in_array ( $task, array ('add', 'edit' ) ) || ($view == 'article' && $layout == 'form')) {
				//Add or Edit Article
				$cat_html = JHTML::_ ( 'select.genericlist', array (current ( $cats ) ), 'catid', 'class="inputbox" size="1"', 'id', 'title', $catid );
			} else {
				//Article Manager
				$cat_html = JHTML::_ ( 'select.genericlist', $cats, 'catid', 'onchange="document.adminForm.submit( );" class="inputbox" size="1"', 'id', 'title', $catid );
			}

			$html = preg_replace ( '/<select[^>]*?name="catid"[^>]*?>.*?<\/select>/', $cat_html, $html ); //BUR 10/6/2010
			//Kobby's bingo - START
			//$html = preg_replace('/\<input(.*?)name\=\"state\"(.*?)\/\>/i', '<input\1name="state"\2 disabled=true />', $html);
			//$html = ereg_replace('<input type="radio" disabled="true" value="0" id="state0" name="state"/>', '<input type="radio" disabled="true" value="0" id="state0" checked="checked" name="state"/>', $html);
			//$html = ereg_replace('<input type="radio" disabled="true" checked="checked" value="1" id="state1" name="state"/>', '<input type="radio" disabled="true" value="1" id="state1" name="state"/>', $html);
			$special_chars = '[\s\w\<\>\/\:\=\"\-\.\;\,]';
			/**
			 * Strip out html for Article Submission Group/Role restrictions
			 */
			$regex = array ();
			$replaceWith = array ();
			if (isset ( $article_submission_r [0] ) && $article_submission_r [0] == '0' || $article_submission_gp [0] == '0') { //Hide show on Front Page
				//$front_regex = '/\<tr\>\s+\<td.*\>\s+\<label for\=\"frontpage\"\>' . $special_chars . '*?\<\/tr\>/i';
				$regex [] = '/<tr[^>]*>\s*?<td[^>]*>\s*?<label for="frontpage">.*?<\/tr>/s';
				$replaceWith [] = '';
				$regex [] = '/<div[^>]*>\s*?<label[^>]*for="frontpage"[^>]*>.*?<\/div>/s';
				$replaceWith [] = '';

		//$html = preg_replace( $regex, '', $html );
			}
			if (isset ( $article_submission_r [1] ) && $article_submission_r [1] == '0' || $article_submission_gp [1] == '0') { // Hide Metadata Fields
				$regex [] = '/<fieldset>(?!.*?<fieldset>).*?for="metadesc".*?<\/fieldset>/s'; //BUR 9/1/2010
				$replaceWith [] = '';
				/*$regex [] = '/\<fieldset\>\s+\<legend\>Metadata\<\/legend\>' . $special_chars . '*?\<\/fieldset\>/i';
				 $replaceWith [] = '';
				 $regex [] = '/<fieldset[^>]*>\s+<legend>Metadata.*?<\/fieldset>/s';
				 $replaceWith [] = '';*/
			//$html = preg_replace( $meta_regex, '', $html );
			}
			if (isset ( $article_submission_r [2] ) && $article_submission_r [2] == '0' || $article_submission_gp [2] == '0') { //Hide Start Publishing
				//$start_regex =					'/\<tr\>\s+\<td.*\>\s+\<label for\=\"publish_up\"\>' . $special_chars . '*?\<\/tr\>/i';
				$regex [] = '/<tr[^>]*>\s*?<td[^>]*>\s*?<label for="publish_up">.*?<\/tr>/s';
				$replaceWith [] = '<input type="hidden" id="publish_up"/>';
				$regex [] = '/<div[^>]*>\s*?<label[^>]*for="publish_up"[^>]*>.*?<\/div>/s';
				$replaceWith [] = '<input type="hidden" id="publish_up"/>';

		//$html = preg_replace( $regex, '<input type="hidden" id="publish_up"/>', $html );
			}
			if (isset ( $article_submission_r [3] ) && $article_submission_r [3] == '0' || $article_submission_gp [3] == '0') { //Hide Finish Publishing
				//$finish_regex =					'/\<tr\>\s+\<td.*\>\s+\<label for\=\"publish_down\"\>' . $special_chars . '*?\<\/tr\>/i';
				$regex [] = '/<tr[^>]*>\s*?<td[^>]*>\s*?<label for="publish_down">.*?<\/tr>/s';
				$replaceWith [] = '<input type="hidden" id="publish_down"/>';
				$regex [] = '/<div[^>]*>\s*?<label[^>]*for="publish_down"[^>]*>.*?<\/div>/s';
				$replaceWith [] = '<input type="hidden" id="publish_down"/>';

		//$html = preg_replace( $regex, '<input type="hidden" id="publish_down"/>', $html );
			}
			if (isset ( $article_submission_r [4] ) && $article_submission_r [4] == '0' || $article_submission_gp [4] == '0') { //Hide Author Alias
				//$author_regex =					'/\<tr\>\s+\<td.*\>\s+\<label for\=\"created_by_alias\"\>' . $special_chars . '*?\<\/tr\>/i';
				$regex [] = '/<tr[^>]*>\s*?<td[^>]*>\s*?<label for="created_by_alias">.*?<\/tr>/s';
				$replaceWith [] = '';
				$regex [] = '/<div[^>]*>\s*?<label[^>]*for="created_by_alias"[^>]*>.*?<\/div>/s';
				$replaceWith [] = '';

		//$html = preg_replace( $regex, '', $html );
			}
			if (isset ( $article_submission_r [5] ) && $article_submission_r [5] == '0' || $article_submission_gp [5] == '0') { //Hide Access Level
				//$author_regex = 				'/\<tr\>\s+\<td.*\>\s+\<label for\=\"access\"\>' . $special_chars . '*?\<\/tr\>/i';
				$regex [] = '/<tr[^>]*>\s*?<td[^>]*>\s*?<label for="access">.*?<\/tr>/s';
				$replaceWith [] = '';
				$regex [] = '/<div[^>]*>\s*?<label[^>]*for="access"[^>]*>.*?<\/div>/s';
				$replaceWith [] = '';

		//$html = preg_replace( $regex, '', $html );
			}
			$html = preg_replace ( $regex, $replaceWith, $html );
			//bingo - END
			JResponse::setBody ( $html );
		} elseif ($option == 'com_categories') {
			$lang = & JFactory::getLanguage ();
			$lang->load ( 'plg_system_community_acl' );
			$task = strtolower ( JRequest::getCmd ( 'task' ) );
			if ($task == 'new' || $task == 'add')
				$query = "SELECT DISTINCT `item_id` FROM `#__community_acl_content_actions` WHERE `item_type` = 'section' AND `func_id` IN ('" . implode ( "','", $functions ) . "') AND `action` IN ('add') ORDER BY `item_id`";
			elseif ($task == 'edit')
				$query = "SELECT DISTINCT `item_id` FROM `#__community_acl_content_actions` WHERE `item_type` = 'section' AND `func_id` IN ('" . implode ( "','", $functions ) . "') AND `action` IN ('edit') ORDER BY `item_id`";
			$db->setQuery ( $query );
			$sections = $db->loadResultArray ();
			if (is_array ( $sections ) && count ( $sections ) > 0) {
				if ($config->default_action == 'allow') {
					// get allowed sections
					$query = "SELECT * FROM #__sections WHERE `id` NOT IN ('" . implode ( "','", $sections ) . "') ";
					$db->setQuery ( $query );
					$sections = $db->loadObjectList ();
				} else {
					// get allowed sections
					$query = "SELECT * FROM #__sections WHERE `id` IN ('" . implode ( "','", $sections ) . "') ";
					$db->setQuery ( $query );
					$sections = $db->loadObjectList ();
				}
			}
			if (! is_array ( $sections ) || count ( $sections ) < 1) {
				return;
			}
			$sectionid = null;
			if ($id > 0) {
				$query = "SELECT `section` FROM `#__categories` WHERE `id` = '{$id}'";
				$db->setQuery ( $query );
				$sectionid = ( int ) $db->loadResult ();
			}
			$section_html = JHTML::_ ( 'select.genericlist', $sections, 'section', 'class="inputbox" size="1" ', 'id', 'title', $sectionid );
			$html = JResponse::getBody ();
			$html = preg_replace ( '/\<select.*name\=\"section\".*\<\/select\>/i', $section_html, $html );
			JResponse::setBody ( $html );
		} elseif ($option == 'com_user' && $task == 'register') {
			$html = JResponse::getBody ();
			$html = preg_replace ( '/\<button.*tyoe\=\"submit\".*\/\>/i', '', $html );
			$html = JResponse::getBody ();
		}
	}
	function _syncCBContact() {
		require_once (JPATH_SITE . '/administrator/components/com_community_acl/community_acl.class.php');
		$db = & JFactory::getDBO ();
		$query = "SELECT `id` FROM  `#__community_acl_sites` WHERE `is_main` = '1'";
		$db->setQuery ( $query );
		$sid = ( int ) $db->loadResult ();
		$main = new CACL_site ( $db );
		$main->load ( $sid );
		$config = new CACL_config ( $main->_site_db );
		$config->load ();
		if (! $config->synchronize || ! $config->cb_contact)
			return;
		$sync = new CACL_syncronize ( $main );
		$sync->syncronize ( 0, 'cb_contact' );
	}
	function _emailPublisher($sectionid, $catid, $default_action) {
		$user = & JFactory::getUser ();
		$db = & JFactory::getDBO ();
		$query = "SELECT DISTINCT `a`.`id`, `a`.`name`, `a`.`email` FROM `#__users` AS `a`, `#__community_acl_user_params` AS `b` " . " WHERE `a`.`gid` > 20 AND `b`.`user_id` = `a`.`id` AND `b`.`name` = 'publisher_notification' AND `b`.`value` = '1' ";
		$db->setQuery ( $query );
		$users = $db->loadObjectList ();
		$message = '';
		$subject = '';
		if (is_array ( $users ) && count ( $users ) > 0)
			foreach ( $users as $usr ) {
				$user_id = $usr->id;
				$query = "SELECT `function_id` FROM `#__community_acl_users` WHERE `user_id` = '{$user_id}'";
				$db->setQuery ( $query );
				$functions = $db->loadResultArray ();
				$bingo = false;
				if (is_array ( $functions ) && count ( $functions ) > 0) {
					$query = "SELECT `item_type`, `item_id` FROM `#__community_acl_content_actions` WHERE `func_id` IN ('" . implode ( "','", $functions ) . "') AND `action` = 'publish'";
					$db->setQuery ( $query );
					$items = $db->loadObjectList ();
					if (is_array ( $items ) && count ( $items ) > 0) {
						foreach ( $items as $item ) {
							switch ($item->item_type) {
								case 'section' :
									if ($item->item_id == $sectionid)
										$bingo = true;
									break;
								case 'category' :
									if ($item->item_id == $catid)
										$bingo = true;
									break;
								case 'content' :
									if ($item->item_id == $id)
										$bingo = true;
									break;
							}
						}
					}
				}
				if (($default_action == 'allow' && ! $bingo) || ($default_action == 'deny' && $bingo)) {
					if ($message == '' && $subject == '') {
						$message = JText::_ ( 'MAILBODY' );
						$subject = JText::_ ( 'MAILSUBJECT' );
						$query = "SELECT `a`.`title` AS `section`, `b`.`title` AS `category` FROM `#__sections` AS `a`, `#__categories` AS `b` WHERE `a`.`id` = '{$sectionid}' AND `b`.`id` = '{$catid}'";
						$db->setQuery ( $query );
						$titles = null;
						$titles = $db->loadObject ();
						if (! (is_object ( $titles ) && $titles->section != '' && $titles->category != '')) {
							$titles = new StdClass ();
							$titles->section = JText::_ ( 'Uncategorized' );
							$titles->category = JText::_ ( 'Uncategorized' );
						}
						$article = JRequest::getVar ( 'title', '', 'default', 'string' );
						$message = sprintf ( $message, $user->get ( 'name' ) . ' (' . $user->get ( 'email' ) . ')', $article, $titles->section, $titles->category );
						$subject = sprintf ( $subject, $titles->section, $titles->category );
						$config = new JConfig ();
					}
					JUTility::sendMail ( $config->mailfrom, $config->fromname, $usr->email, $subject, $message, 0, NULL, NULL, NULL, NULL, NULL );
				}
			}
	}
	function onAfterRoute() {
		//adding cACL Activate
		$app = & JFactory::getApplication ();
		if( FALSE === strpos($this->_caclConfig->activate, $app->getName())){
			return;
		}

		global $mainframe;
		if (! file_exists ( JPATH_SITE . '/administrator/components/com_community_acl/community_acl.class.php' ))
			return;

		$back_end = false;
		if ($app->getName () != 'site') {
			$back_end = true;
		}
		/**
		 * This will return ajax calls from jomsocial popups.
		 */
		if ('community' == strtolower ( JRequest::getVar ( 'option' ) ) && 'azrul_ajax' == strtolower ( JRequest::getVar ( 'task' ) )) {
			return;
		}

		if ($back_end)
			$option = strtolower ( JRequest::getVar ( 'option', '', 'default', 'cmd' ) );
		else
			$option = strtolower ( JRequest::getVar ( 'option', 'com_content', 'default', 'cmd' ) );
		$task = strtolower ( JRequest::getCmd ( 'task' ) );
		$user = & JFactory::getUser ();
		if ($back_end && $option == 'com_cbcontact' && $task == '')
			$this->_syncCBContact ();
		if ($user->get ( 'gid' ) == 25) {
			return;
		}
		$db = & JFactory::getDBO ();
		require_once (JPATH_SITE . '/administrator/components/com_community_acl/community_acl.class.php');
		require_once (JPATH_SITE . '/administrator/components/com_community_acl/community_acl.functions.php');
		$config = new CACL_config ( $db );
		$config->load ();
		if ($back_end)
			$redirect_url = $config->admin_redirect_url;
		else
			$redirect_url = $config->redirect_url;

		//check to not go in redirect loop
		if ($_SERVER ['REQUEST_METHOD'] != 'POST') {
			if (! $back_end && $_SERVER ['REQUEST_URI'] == '/' || $_SERVER ['REQUEST_URI'] == '/index.php' || $_SERVER ['REQUEST_URI'] == '/' . $redirect_url || substr_replace ( JURI::root (), '', - 1, 1 ) . $_SERVER ['REQUEST_URI'] == $redirect_url)
				return;
			if ($back_end && $_SERVER ['REQUEST_URI'] == '/administrator/' || $_SERVER ['REQUEST_URI'] == '/administrator/index.php' || $_SERVER ['REQUEST_URI'] == $redirect_url || $_SERVER ['REQUEST_URI'] == '/administrator/' . $redirect_url || substr_replace ( JURI::root (), '', - 1, 1 ) . $_SERVER ['REQUEST_URI'] == $redirect_url)
				return;
		}
		$user_access = cacl_get_user_access ( $config );
		$groups = $user_access ['groups'];
		$roles = $user_access ['roles'];
		$functions = $user_access ['functions'];
		$id = intval ( JRequest::getInt ( 'id' ) );
		if (! isset ( $_REQUEST ['id'] ) || $_REQUEST ['id'] == '')
			$id = - 1;
		$cid = JRequest::getVar ( 'cid', array (- 1 ), '', 'array' );
		JArrayHelper::toInteger ( $cid, array (- 1 ) );
		if ($id == - 1 && isset ( $_REQUEST ['cid'] [0] ) && $_REQUEST ['cid'] [0] != '')
			$id = $cid [0];
		$view = strtolower ( JRequest::getCmd ( 'view' ) );
		$layout = strtolower ( JRequest::getCmd ( 'layout' ) );
		if ($back_end)
			$option = strtolower ( JRequest::getVar ( 'option', '', 'default', 'cmd' ) );
		else
			$option = strtolower ( JRequest::getVar ( 'option', 'com_content', 'default', 'cmd' ) );
		$task = strtolower ( JRequest::getCmd ( 'task' ) );
		$catid = - 1;
		$sectionid = - 1;
		if (($back_end && $option == 'com_content') || (! $back_end && $option == 'com_content' && $view == 'article' && $id > 0)) {
			if ($id > 0) {
				$cid [] = $id;
				$query = "SELECT `catid`, `sectionid` FROM `#__content` WHERE `id` IN ('" . implode ( "','", $cid ) . "')";
				$db->setQuery ( $query );
				$tmp = $db->loadAssoc ();
				$catid = $tmp ['catid'];
				$sectionid = $tmp ['sectionid'];
			}
		} elseif (($back_end && $option == 'com_categories') || (! $back_end && $option == 'com_content' && $view == 'category' && $id > 0)) {
			if ($id > 0) {
				$cid [] = $id;
				$query = "SELECT `section` FROM `#__categories` WHERE `id` IN ('" . implode ( "','", $cid ) . "')";
				$db->setQuery ( $query );
				$sectionid = $db->loadResult ();
				$catid = $id;
			}
		} elseif (! $back_end && $option == 'com_content' && $view == 'section' && $id > 0) {
			$sectionid = $id;
		}
		$catid_r = intval ( JRequest::getInt ( 'catid' ) );
		if (! isset ( $_REQUEST ['catid'] ))
			$catid_r = - 1;
		$sectionid_r = intval ( JRequest::getInt ( 'sectionid' ) );
		if (! isset ( $_REQUEST ['sectionid'] ))
			$sectionid_r = - 1;
		$lang = & JFactory::getLanguage ();
		$lang->load ( 'plg_system_community_acl' );
		if (! $back_end && ($task == 'save' || $task == 'apply') && ($option == 'com_content') && ($id == '0'))
			$this->_emailPublisher ( $sectionid_r, $catid_r, $config->default_action );

		//no groups/roles/functions for user
		if (! (count ( $groups ) > 1 && count ( $roles ) > 1)) {
			return;
		}
		if ($back_end && $option == 'com_login' && ($task == 'login' || $task == 'logout'))
			return;
		if ($option == 'com_sections' || $option == 'com_categories' || $option == 'com_content')
			$query = "SELECT * FROM `#__community_acl_access` WHERE `option` IN ('menu', 'com_sections', 'com_categories', 'com_content' ) AND " . ($back_end ? ' `isbackend` = 1 ' : ' `isfrontend` = 1 ') . " AND ( `group_id` IN ( '" . implode ( "','", $groups ) . "') OR `role_id` IN ( '" . implode ( "','", $roles ) . "') )";
		else
			$query = "SELECT * FROM `#__community_acl_access` WHERE `option` IN ( 'menu', '{$option}') AND " . ($back_end ? ' `isbackend` = 1 ' : ' `isfrontend` = 1 ') . " AND ( `group_id` IN ( '" . implode ( "','", $groups ) . "') OR `role_id` IN ( '" . implode ( "','", $roles ) . "') )";
		$db->setQuery ( $query );
		$access = $db->loadObjectList ();
		//What is a frole and fgroup???
		$froles = array ();
		$fgroups = array ();
		if (is_array ( $access ) && count ( $access ) > 0) {
			foreach ( $access as $item ) {
				//forbidden components
				//echo $item->name .', $option = '.$option. ' $item->role_id=' .$item->role_id; die();

				/**
				 * Functions are not singling out articles
				 * Attempting to trigger the logic to run checking functions for articles.
				 * —BUR 8/2/2011
				 */
				if ( '###' === $item->name && 'com_content' === $item->option && 'com_content' === $option && !empty($cid) && in_array($task, array('unarchive','archive','publish','unpublish','movesect','copy','remove','edit','add','apply','save','cancel')) ) {
					if ( $item->role_id == '0' ) {
						$fgroups [] = $item->group_id;
					} else {
						$froles [] = $item->role_id;
					}
				}
				/**
				 * end
				 */

				if ($item->name == '###' && $option == $item->option && ($option != 'com_content' && ! ($option == 'com_login' && $task == 'logout'))) {
					if ($item->role_id == '0'){
						$fgroups [] = $item->group_id;
					}else{
						$froles [] = $item->role_id;
					}
				} elseif ($item->name == '###' && $item->option == 'menu') {
					if (check_menu ( $item->value, $_REQUEST ['Itemid'] ))
						if ($config->default_action == 'allow') {
							$_SESSION ['cacl_redirect_url'] = $_SERVER ['REQUEST_URI'];
							$mainframe->redirect ( $redirect_url, JText::_ ( 'ALERTNOTAUTH' ) );
						}
				} elseif ($item->name != '###') {
					//forbidden content, sections, categiries
					if ($back_end) {
						if ($option == 'com_content' && ($id == $item->value || in_array ( $item->value, $cid ))) {
							if ($item->role_id == '0')
								$fgroups [] = $item->group_id;
							else
								$froles [] = $item->role_id;
						} elseif ($option == 'com_content' && (($item->option == 'com_sections' && $sectionid == $item->value) || ($item->option == 'com_categories' && $catid == $item->value))) {
							if ($item->role_id == '0')
								$fgroups [] = $item->group_id;
							else
								$froles [] = $item->role_id;
						} elseif ($option == 'com_sections' && ($id == $item->value || in_array ( $item->value, $cid ))) {
							if ($item->role_id == '0')
								$fgroups [] = $item->group_id;
							else
								$froles [] = $item->role_id;
						} elseif ($option == 'com_categories' && ($id == $item->value || in_array ( $item->value, $cid ))) {
							if ($item->role_id == '0')
								$fgroups [] = $item->group_id;
							else
								$froles [] = $item->role_id;
						}
						/*
						 * This doesn't seem to do what it intended. -BUR 10/5/2010
						 if ($option == 'com_content' && $id == - 1) {
						 if ($item->role_id == '0')
						 $fgroups [] = $item->group_id;
						 else
						 $froles [] = $item->role_id;
						 }
						 if ($option == 'com_categories' && $id == - 1) {
						 if ($item->role_id == '0')
						 $fgroups [] = $item->group_id;
						 else
						 $froles [] = $item->role_id;
						 }
						 if ($option == 'com_sections' && $id == - 1) {
						 if ($item->role_id == '0')
						 $fgroups [] = $item->group_id;
						 else
						 $froles [] = $item->role_id;
						 }
						 if ($option == 'com_menus' && $id == - 1) {
						 if ($item->role_id == '0')
						 $fgroups [] = $item->group_id;
						 else
						 $froles [] = $item->role_id;
						 }*/
					} else {
						if ($option == 'com_content' && $view == 'section' && $item->option == 'com_sections' && $id == $item->value) {
							if ($item->role_id == '0')
								$fgroups [] = $item->group_id;
							else
								$froles [] = $item->role_id;
						}
						if ($option == 'com_content' && $view == 'category' && $item->option == 'com_categories' && $id == $item->value) {
							if ($item->role_id == '0')
								$fgroups [] = $item->group_id;
							else
								$froles [] = $item->role_id;
						}
						if ($option == 'com_content' && $view == 'article' && $item->option == 'com_content' && $id == $item->value) {
							if ($item->role_id == '0')
								$fgroups [] = $item->group_id;
							else
								$froles [] = $item->role_id;
						}
						if ($option == 'com_content' && $view == 'category' && $item->option == 'com_sections' && $sectionid == $item->value) {
							if ($item->role_id == '0')
								$fgroups [] = $item->group_id;
							else
								$froles [] = $item->role_id;
						}
						if ($option == 'com_content' && $view == 'article' && (($item->option == 'com_sections' && $sectionid == $item->value) || ($item->option == 'com_categories' && $catid == $item->value))) {
							if ($item->role_id == '0')
								$fgroups [] = $item->group_id;
							else
								$froles [] = $item->role_id;
						}
						if ($option == 'com_content' && $task == 'edit' && ($id == $item->value || in_array ( $item->value, $cid ))) {
							if ($item->role_id == '0')
								$fgroups [] = $item->group_id;
							else
								$froles [] = $item->role_id;
						}
						if ($option == 'com_content' && $task == 'new' && ($item->option == 'com_sections' && $sectionid_r == $item->value)) {
							if ($item->role_id == '0')
								$fgroups [] = $item->group_id;
							else
								$froles [] = $item->role_id;
						}
						if ($option == 'com_content' && $task == 'save' && ($item->option == 'com_sections' && $sectionid_r == $item->value) || ($item->option == 'com_categories' && $catid_r == $item->value)) {
							if ($item->role_id == '0')
								$fgroups [] = $item->group_id;
							else
								$froles [] = $item->role_id;
						}
						if ($option == 'com_content' && $view == 'article' && $layout == 'form' && $id == - 1 && $config->default_action != 'allow') {
							if ($item->role_id == '0')
								$fgroups [] = $item->group_id;
							else
								$froles [] = $item->role_id;
						}
						if ($option == 'com_content' && $view == 'frontpage' && $id == - 1 && $config->default_action != 'allow') {
							if ($item->role_id == '0')
								$fgroups [] = $item->group_id;
							else
								$froles [] = $item->role_id;
						}
					}
				}
			}
		}

		$rows = $groups;
		$rls = $roles;
		if ($config->default_action == 'allow') {
			if (is_array ( $rows ) && count ( $rows ) > 0) {
				foreach ( $rows as $i => $group ) {
					$ind = array_search ( $group, $groups );
					if (in_array ( $group, $fgroups ) && $ind !== false) {
						unset ( $groups [$ind] );
						unset ( $roles [$ind] );
						unset ( $functions [$ind] );
					}
					$ind = array_search ( $rls [$i], $roles );
					if (in_array ( $rls [$i], $froles ) && $ind !== false) {
						unset ( $groups [$ind] );
						unset ( $roles [$ind] );
						unset ( $functions [$ind] );
					}
				}
			}
			if (! (count ( $groups ) > 1 && count ( $roles ) > 1)) {
				//Kobby corrected the redirect issue right here.
				$_SESSION ['cacl_redirect_url'] = $_SERVER ['REQUEST_URI'];
				$mainframe->redirect ( $redirect_url, JText::_ ( 'ALERTNOTAUTH' ) );
				/* * /
				 if(!isset($_REQUEST['load']))
				 $mainframe->redirect( $redirect_url.'?load=once', JText::_( 'ALERTNOTAUTH' ));
				 /* */
			}
		} else {
			// What is going on here? Seriously. —BUR 8/2/2011
			if (is_array ( $rows ) && count ( $rows ) > 0){
				foreach ( $rows as $i => $group ) {
					$ind = array_search ( $group, $groups );
					if (! in_array ( $group, $fgroups ) && $ind !== false) {
						$groups [$ind] = - 1;
						if (! in_array ( $roles [$ind], $froles )) {
							$roles [$ind] = - 1;
							$functions [$ind] = - 1;
						}
					}
					$ind = array_search ( $rls [$i], $roles );
					if (! in_array ( $rls [$i], $froles ) && $ind !== false) {
						$roles [$ind] = - 1;
						if (! in_array ( $groups [$ind], $fgroups )) {
							$groups [$ind] = - 1;
							$functions [$ind] = - 1;
						}
					}
				}
			}
			$groups = array_unique ( $groups );
			$roles = array_unique ( $roles );
			$functions = array_unique ( $functions );
			$restricted = true;
			if ((count ( $groups ) == 1 && count ( $roles ) == 1)) { //triggered bug BUT fixed now
				if ((JRequest::getVar ( 'option' ) != 'com_content') && ! ($back_end)) {
					$_SESSION ['cacl_redirect_url'] = $_SERVER ['REQUEST_URI'];
					$query = "SELECT * FROM `#__community_acl_function_access` WHERE `option` = '{$option}' AND " . ($back_end ? ' `isbackend` = 1 ' : ' `isfrontend` = 1 ') . " AND `name` <> 'option' ORDER BY `grouping`";
					$db->setQuery ( $query );
					$f_access = $db->loadObjectList ();
					$Itemid = JRequest::getInt ( 'Itemid' );
					$task = JRequest::getVar ( 'task', '' );
					$view = JRequest::getVar ( 'view', '' );
					foreach ( $f_access as $access ) {
						if ($access->value == $Itemid)
							$restricted = false;
						elseif ($access->value == $task)
							$restricted = false;
						elseif ($access->value == $view)
							$restricted = false;
					}
					if ($task == '' && $view == '')
						$restricted = true;

		//Do not restrict JomComment Component
					if ($option == 'jomcomment')
						$restricted = false;
					if ($restricted)
						$mainframe->redirect ( $redirect_url, JText::_ ( 'ALERTNOTAUTH' ) );
				}
			}
		}
		$query = "SELECT COUNT(*) FROM `#__community_acl_content_actions` WHERE `func_id` IN ( '" . implode ( "','", $functions ) . "') ";
		$db->setQuery ( $query );
		$count = ( int ) $db->loadResult ();
		$content_all = 0;
		if ($option == 'com_content') {
			$query = "SELECT COUNT(*) FROM `#__community_acl_function_access` WHERE `option` = 'com_content' AND `name` = '#any_key#' AND `value` = '#any_value#' AND " . ($back_end ? ' `isbackend` = 1 ' : ' `isfrontend` = 1 ') . " AND `func_id` IN ( '" . implode ( "','", $functions ) . "')";
			$db->setQuery ( $query );
			$content_all = ( int ) $db->loadResult ();
			$count = $count && ! $content_all;
		}
		if ($count && ($task == '' || $task == 'save' || $task == 'apply' || $task == 'new' || $task == 'add' || $task == 'remove' || $task == 'copyselect' || $task == 'moveselect' || $task == 'edit' || $task == 'publish' || $task == 'unpublish' || $task == 'copy' || $task == 'movesect' || $task == 'archive' || $task == 'unarchive')) {
			$acl = & JFactory::getACL ();
			$publish_array = array ('com_content', 'publish', 'users', strtolower ( $user->get ( 'usertype' ) ), 'content', 'all', NULL );
			$publish_index = array_search ( $publish_array, $acl->acl );
			$edit_array = array ('com_content', 'edit', 'users', strtolower ( $user->get ( 'usertype' ) ), 'content', 'all', NULL );
			$edit_index = array_search ( $edit_array, $acl->acl );
			/* * /
			echo '<div style="background-color:white">';
			echo 'FILE: '.__FILE__.' LINE: '.__LINE__;
			echo '<pre style="white-space:pre">',
			var_dump($publish_array),
			var_dump($publish_index),
			var_dump($edit_array),
			var_dump($edit_index),
			var_dump($option),
			var_dump(JRequest::getCMD('option')),
			'</pre></div>';
			exit;
			/* */
			if ($option == 'com_sections' && ($sectionid > - 1 || $sectionid_r > - 1)) {
				$query = "SELECT * FROM `#__community_acl_content_actions` WHERE `item_type` = 'section' AND `func_id` IN ( '" . implode ( "','", $functions ) . "') ";
				$db->setQuery ( $query );
				$function_access = $db->loadObjectList ();
				$bingo = false;
				$bingo_publish = false;
				if (is_array ( $function_access ) && count ( $function_access ) > 0)
					foreach ( $function_access as $item ) {
						if (($task == 'add' || $task == 'remove' || $task == 'copyselect') && $item->action == 'add' && ($id == $item->item_id || in_array ( $item->item_id, $cid )))
							$bingo = true;
						if (($task == 'new') && $item->action == 'add' && $sectionid_r == $item->item_id)
							$bingo = true;
						if (($task == 'edit') && $item->action == 'edit' && ($id == $item->item_id || in_array ( $item->item_id, $cid )))
							$bingo = true;
						if (($task == 'publish' || $task == 'unpublish') && $item->action == 'publish' && ($id == $item->item_id || in_array ( $item->item_id, $cid )))
							$bingo = true;
						if (($task == 'edit') && $item->action == 'publish' && ($id == $item->item_id || in_array ( $item->item_id, $cid )))
							$bingo_publish = true;
					}
				if ($bingo_publish) {
					if ($config->default_action == 'allow') {
						unset ( $acl->acl [$publish_index] );
						$acl->acl_count --;
					}
				} elseif ($config->default_action == 'deny') {
					unset ( $acl->acl [$publish_index] );
					$acl->acl_count --;
				}
				if ($bingo) {
					if ($config->default_action == 'allow') {
						$_SESSION ['cacl_redirect_url'] = $_SERVER ['REQUEST_URI'];
						$mainframe->redirect ( $redirect_url, JText::_ ( 'ALERTNOTAUTH' ) );
					}
				} elseif ($config->default_action == 'deny') {
					$_SESSION ['cacl_redirect_url'] = $_SERVER ['REQUEST_URI'];
					$mainframe->redirect ( $redirect_url, JText::_ ( 'ALERTNOTAUTH' ) );
				}
			}
			if ($option == 'com_categories' && ($catid > - 1 || $catid_r > - 1)) {
				$query = "SELECT * FROM `#__community_acl_content_actions` WHERE `item_type` IN ('section', 'category') AND `func_id` IN ( '" . implode ( "','", $functions ) . "') ";
				$db->setQuery ( $query );
				$function_access = $db->loadObjectList ();
				$bingo = false;
				$bingo_publish = false;
				//echo "$sectionid, $sectionid_r, $catid, $catid_r";die;
				if (is_array ( $function_access ) && count ( $function_access ) > 0)
					foreach ( $function_access as $item ) {
						if ($item->item_type == 'section') {
							if (($task == 'add' || $task == 'remove' || $task == 'copyselect' || $task == 'moveselect') && $item->action == 'add' && $sectionid == $item->item_id)
								$bingo = true;
							if (($task == 'new') && $item->action == 'add' && $sectionid_r == $item->item_id)
								$bingo = true;
							if (($task == 'edit') && $item->action == 'edit' && $sectionid == $item->item_id)
								$bingo = true;
							if (($task == 'publish' || $task == 'unpublish') && $item->action == 'publish' && $sectionid == $item->item_id)
								$bingo = true;
							if ($task == 'edit' && $item->action == 'publish' && $sectionid == $item->item_id) {
								$bingo_publish = true;
							}
						}
						if ($item->item_type == 'category') {
							if (($task == 'add' || $task == 'remove' || $task == 'copyselect' || $task == 'moveselect') && $item->action == 'add' && ($id == $item->item_id || in_array ( $item->item_id, $cid )))
								$bingo = true;
							if (($task == 'new') && $item->action == 'add' && $catid_r == $item->item_id)
								$bingo = true;
							if (($task == 'edit') && $item->action == 'edit' && ($id == $item->item_id || in_array ( $item->item_id, $cid )))
								$bingo = true;
							if (($task == 'publish' || $task == 'unpublish') && $item->action == 'publish' && ($id == $item->item_id || in_array ( $item->item_id, $cid )))
								$bingo = true;
							if ($task == 'edit' && $item->action == 'publish' && ($id == $item->item_id || in_array ( $item->item_id, $cid )))
								$bingo_publish = true;
						}
					}
				if ($bingo_publish) {
					if ($config->default_action == 'allow') {
						unset ( $acl->acl [$publish_index] );
						$acl->acl_count --;
					}
				} elseif ($config->default_action == 'deny') {
					unset ( $acl->acl [$publish_index] );
					$acl->acl_count --;
				}
				if ($bingo) {
					if ($config->default_action == 'allow') {
						$_SESSION ['cacl_redirect_url'] = $_SERVER ['REQUEST_URI'];
						$mainframe->redirect ( $redirect_url, JText::_ ( 'ALERTNOTAUTH' ) );
					}
				} elseif ($config->default_action == 'deny') {
					$_SESSION ['cacl_redirect_url'] = $_SERVER ['REQUEST_URI'];
					$mainframe->redirect ( $redirect_url, JText::_ ( 'ALERTNOTAUTH' ) );
				}
			}

			if ($option == 'com_content') {
				/* * /
				echo '<div style="background-color:white">';
				echo 'FILE: '.__FILE__.' LINE: '.__LINE__;
				echo '<pre style="white-space:pre">',
				var_dump($option),
				'</pre></div>';
				exit;
				/* */
				$query = "SELECT * FROM `#__community_acl_content_actions` WHERE `item_type` IN ('section', 'category', 'content') AND `func_id` IN ( '" . implode ( "','", $functions ) . "') ";
				$db->setQuery ( $query );
				$function_access = $db->loadObjectList ();
				/* * /
				echo '<div style="background-color:white">';
				echo 'FILE: '.__FILE__.' LINE: '.__LINE__;
				echo '<pre style="white-space:pre">',
				var_dump($function_access),
				var_dump($task),
				'</pre></div>';
				exit;
				/* */
				$bingo = false;
				$bingo_edit = false;
				$bingo_publish = false;
				if (is_array ( $function_access ) && count ( $function_access ) > 0){
					foreach ( $function_access as $item ) {
						if ($item->item_type == 'section') {
							if (($task == 'add' || $task == 'remove' || $task == 'copyselect' || $task == 'moveselect') && $item->action == 'add' && $sectionid == $item->item_id)
								$bingo = true;
							if (($task == 'new' || $task == 'add' || ($view == 'article' && $layout == 'form')) && $item->action == 'add' /*&& $sectionid_r == $item->item_id*/ ) {
								//only in deny mode
								if ($config->default_action == 'deny') {
									$bingo = true;
									$bingo_edit = true;
								}
							}
							if (($task == 'save' || $task == 'apply') && ($item->action == 'add' || $item->action == 'edit') && $sectionid_r == $item->item_id) {
								# - Kobby enhancement - Exception Catch : User is denied access to edit or publish but can add
								/*if($item_type != 'add'){
							 $bingo = false;
							 }else{
							 $bingo = true;
							 }*/
								$bingo = true;
								$bingo_edit = true;
								$bingo_publish = true;
							}
							if ($task == '' && $item->action == 'edit' && $sectionid == $item->item_id) {
								$bingo_edit = true;
							}
							if (($task == 'edit') && $item->action == 'edit' && $sectionid == $item->item_id) {
								$bingo_edit = true;
								$bingo = true;
							}
							if (($task == 'publish' || $task == 'unpublish') && $item->action == 'publish' && $sectionid == $item->item_id)
								$bingo = true;
							if (($task == 'edit' || $task == '') && $item->action == 'publish' && $sectionid == $item->item_id)
								$bingo_publish = true;
						} elseif ($item->item_type == 'category') {
							if (($task == 'new' || $task == 'add' || $task == 'remove' || $task == 'copyselect' || $task == 'moveselect') && $item->action == 'add' && $catid == $item->item_id)
								$bingo = true;
							if (($task == 'new' || $task == 'add' || ($view == 'article' && $layout == 'form')) && $item->action == 'add' /*&& $catid_r == $item->item_id */) {
								//only in deny mode
								if ($config->default_action == 'deny') {
									$bingo = true;
									$bingo_edit = true;
								}
							}
							if (($task == 'save' || $task == 'apply') && ($item->action == 'add' || $item->action == 'edit') && $catid_r == $item->item_id) {
								$bingo = true;
								$bingo_edit = true;
								$bingo_publish = true;
							}
							if ($task == '' && $item->action == 'edit' && $catid == $item->item_id)
								$bingo_edit = true;
							if (($task == 'edit') && $item->action == 'edit' && $catid == $item->item_id) {
								$bingo = true;
								$bingo_edit = true;
							}
							if (($task == 'publish' || $task == 'unpublish') && $item->action == 'publish' && $catid == $item->item_id)
								$bingo = true;
							if (($task == 'edit' || $task == '') && $item->action == 'publish' && $catid == $item->item_id)
								$bingo_publish = true;
						} elseif ($item->item_type == 'content') {
							if (($task == 'edit' || $task == 'archive' || $task == 'unarchive') && $item->action == 'edit' && ($id == $item->item_id || in_array ( $item->item_id, $cid )))
								$bingo = true;
							if (($task == 'publish' || $task == 'unpublish') && $item->action == 'publish' && ($id == $item->item_id || in_array ( $item->item_id, $cid )))
								$bingo = true;
							if ($task == 'edit' && $item->action == 'publish' && ($id == $item->item_id || in_array ( $item->item_id, $cid )))
								$bingo_publish = true;
						}
					}
			}
			/* * /
			echo '<div style="background-color:white">';
			echo 'FILE: '.__FILE__.' LINE: '.__LINE__;
			echo '<pre style="white-space:pre">',
			var_dump($bingo),
			var_dump($bingo_edit),
			var_dump($bingo_publish),
			var_dump($publish_index),
			var_dump($edit_index),
			var_dump($config->default_action),
			var_dump($acl->acl),
			'</pre></div>';
			//exit;
			/* */

		# - Kobby needs to fix this bug for the Edit/Pub
				if ($bingo_edit && $publish_index === 0) {
					if ($config->default_action == 'allow') {
						unset ( $acl->acl [$edit_index] );
						$acl->acl_count --;
					}
				} elseif ($config->default_action == 'deny' && $publish_index === 0) {
					unset ( $acl->acl [$edit_index] );
					$acl->acl_count --; //die('bingo_edit');
				}

				if ($bingo_publish) {
					if ($config->default_action == 'allow' && $publish_index === 0) {
						unset ( $acl->acl [$publish_index] );
						$acl->acl_count --;
					}
				} elseif ($config->default_action == 'deny' && $publish_index === 0) {
					unset ( $acl->acl [$publish_index] );
					$acl->acl_count --; //die('bingo_publish');
				}

				if ($bingo) {
					if ($config->default_action == 'allow') {
						$_SESSION ['cacl_redirect_url'] = $_SERVER ['REQUEST_URI'];
						$mainframe->redirect ( $redirect_url, JText::_ ( 'ALERTNOTAUTH' ) );
					}
				} elseif ($config->default_action == 'deny' && ($task != '' || ($view == 'article' && $layout == 'form'))) {
					$_SESSION ['cacl_redirect_url'] = $_SERVER ['REQUEST_URI'];
					if ($task != 'save')
						$mainframe->redirect ( $redirect_url, JText::_ ( 'ALERTNOTAUTH' ) );
				}
			}
		} elseif ($config->default_action == 'deny') {
			//This section modifies wether or not the edit article button is displayed on the front end. -BUR
			//This is running on the back-end too —BUR 8/3/2011
			if (! $content_all) {
				$acl = & JFactory::getACL ();
				$publish_array = array ('com_content', 'publish', 'users', strtolower ( $user->get ( 'usertype' ) ), 'content', 'all', NULL );
				$publish_index = array_search ( $publish_array, $acl->acl );
				$edit_array = array ('com_content', 'edit', 'users', strtolower ( $user->get ( 'usertype' ) ), 'content', 'all', NULL );
				$edit_index = array_search ( $edit_array, $acl->acl );
				unset ( $acl->acl [$publish_index] );
				$acl->acl_count --;
				unset ( $acl->acl [$edit_index] );
				$acl->acl_count --;
				if (($task == 'save' || $task == 'apply' || $task == 'new' || $task == 'add' || $task == 'remove' || $task == 'copyselect' || $task == 'moveselect' || $task == 'edit' || $task == 'publish' || $task == 'unpublish' || $task == 'copy' || $task == 'movesect' || $task == 'archive' || $task == 'unarchive') || ($view == 'article' && $layout == 'form')) {
					$_SESSION ['cacl_redirect_url'] = $_SERVER ['REQUEST_URI'];

		//$mainframe->redirect( $redirect_url,JText::_( 'ALERTNOTAUTH' ));
				}
			}
		}
		$query = "SELECT * FROM `#__community_acl_function_access` WHERE `option` = '{$option}' AND " . ($back_end ? ' `isbackend` = 1 ' : ' `isfrontend` = 1 ') . " AND `func_id` IN ( '" . implode ( "','", $functions ) . "') AND `name` <> 'option' ORDER BY `grouping`";
		$db->setQuery ( $query );
		$function_access = $db->loadObjectList ();
		// (isset($_REQUEST['searchword']) || isset($_REQUEST['action']) || isset($_REQUEST['view']) || isset($_REQUEST['task']) || isset($_REQUEST['id']) || isset($_REQUEST['cid']) || isset($_REQUEST['mode'])) &&
		if (is_array ( $function_access ) && count ( $function_access ) > 0) {
			$query = "SELECT `grouping` FROM `#__community_acl_function_access` WHERE `option` = '{$option}' AND " . ($back_end ? ' `isbackend` = 1 ' : ' `isfrontend` = 1 ') . " AND `func_id` IN ( '" . implode ( "','", $functions ) . "') AND `name` <> 'option' GROUP BY `grouping` ORDER BY `grouping`";
			$db->setQuery ( $query );
			$groupings = $db->loadObjectList ();
			$allow_pass = false;
			if (is_array ( $groupings ) && count ( $groupings ) > 0)
				foreach ( $groupings as $g ) {
					$allow_pass = false;
					if (is_array ( $function_access ) && count ( $function_access ) > 0)
						foreach ( $function_access as $item ) {
							if ($item->grouping != $g->grouping){
								continue;
							}

		//Kobby modification to fix the function issue
							if ($_REQUEST ['option'] == $item->option && ! isset ( $_REQUEST [$item->name] ) && $config->default_action == 'deny') {
								$allow_pass = true;
							}
							//End
							if ($item->name == '#any_key#') {
								$allow_pass = false;
								continue;
							}
							if (! isset ( $_REQUEST [$item->name] ) && $config->default_action == 'allow') {
								$allow_pass = true;
								continue;
							}
							if (! isset ( $_REQUEST [$item->name] ) && $config->default_action == 'deny') {
								continue;
							}
							if ($item->name == 'id') {
								if (((( int ) $_REQUEST [$item->name] != $item->value && $item->value && $item->extra != '1') || (( int ) $_REQUEST [$item->name] == $item->value && $item->extra == '1')) && $item->value != '#any_value#') {
									//echo 1;die;
									$allow_pass = true;
									continue;
								}
							} elseif (is_array ( $_REQUEST [$item->name] )) {
								if (((! in_array ( $item->value, $_REQUEST [$item->name] ) && $item->value && $item->extra != '1') || (in_array ( $item->value, $_REQUEST [$item->name] ) && $item->extra == '1')) && $item->value != '#any_value#') {
									//echo 2;die;
									$allow_pass = true;
									continue;
								}
							} else {
								if ((($_REQUEST [$item->name] != $item->value && $item->value && $item->extra != '1') || ($_REQUEST [$item->name] == $item->value && $item->extra == '1')) && $item->value != '#any_value#') {
									//echo 3;die;
									$allow_pass = true;
									continue;
								}
							}
						}
					if ($config->default_action == 'allow') {
						if (! $allow_pass) {
							$_SESSION ['cacl_redirect_url'] = $_SERVER ['REQUEST_URI'];
							$mainframe->redirect ( $redirect_url, JText::_ ( 'ALERTNOTAUTH' ) );
						}
					} else {
						if (! $allow_pass) {
							return;
						}
					}
				}
		} else {
			// Backend user has nothing defined in group/role/function and site set to deny all... why is it still allowed? —BUR 8/3/2011
			return;
		}
		if ($config->default_action == 'deny') {
			$_SESSION ['cacl_redirect_url'] = $_SERVER ['REQUEST_URI'];
			$mainframe->redirect ( $redirect_url, JText::_ ( 'ALERTNOTAUTH' ) );
		}
	}
}
