<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once (JPATH_SITE . '/administrator/components/com_community_acl/community_acl.class.php');
if (! function_exists( 'check_link' )) {
	function check_link($link, $mid = 0) {
		$link_old = $link;
		$request = array ();
		$user = & JFactory::getUser();
		if ($user->get( 'gid' ) == 25)
			return true;
		if ($mid > 0) {
			$app = & JFactory::getApplication();
			$back_end = false;
			if ($app->getName() != 'site')
				$back_end = true;
			$db = & JFactory::getDBO();
			$config = new CACL_config( $db );
			$config->load();
			$user_access = cacl_get_user_access( $config );
			$groups = $user_access ['groups'];
			$roles = $user_access ['roles'];
			$functions = $user_access ['functions'];
			$query = "SELECT COUNT(*) FROM `#__community_acl_access` AS a LEFT JOIN `#__menu` AS b ON a.value = b.id WHERE a.value = '" . $mid . "' AND a.option IN ('menu') AND " . ($back_end ? ' a.isbackend = 1 ' : ' a.isfrontend = 1 ') . " AND ( a.group_id IN ( '" . implode( "','", $groups ) . "') OR a.role_id IN ( '" . implode( "','", $roles ) . "') )";
			$db->setQuery( $query );
			if (( int ) $db->loadResult() > 0)
				return ($config->default_action == 'deny' ? true : false);
			else
				return ($config->default_action == 'deny' ? false : true);
		}
		if (strpos( $link, '?' ) !== false) {
			$link = substr( $link, strpos( $link, '?' ) + 1 );
			$link = str_replace( '&amp;', '&', $link );
			$pairs = explode( '&', $link );
			if (count( $pairs ) > 0) {
				foreach ( $pairs as $pair ) {
					list ( $option, $value ) = explode( '=', $pair );
					$request [$option] = $value;
				}
			}
			return check_place( $request );
		}
		return check_place( $request );
	}
}
function check_place(&$request) {
	$option = isset( $request ['option'] ) ? $request ['option'] : '';
	$task = isset( $request ['task'] ) ? $request ['task'] : '';
	$view = isset( $request ['view'] ) ? $request ['view'] : '';
	$id = isset( $request ['id'] ) ? intval( $request ['id'] ) : 0;
	$cid = isset( $request ['cid'] ) && is_array( $request ['cid'] ) ? JArrayHelper::toInteger( $request ['cid'], array (
			0
	) ) : isset( $request ['cid'] ) ? array (
			intval( $request ['id'] )
	) : array (
			0
	);
	$catid_r = isset( $request ['catid'] ) ? intval( $request ['catid'] ) : - 1;
	intval( JRequest::getInt( 'catid' ) );
	$sectionid_r = isset( $request ['sectionid'] ) ? intval( $request ['sectionid'] ) : - 1;
	$app = & JFactory::getApplication();
	$db = & JFactory::getDBO();
	$user = & JFactory::getUser();
	require_once (JPATH_SITE . '/administrator/components/com_community_acl/community_acl.class.php');
	$config = new CACL_config( $db );
	$config->load();
	if ($user->get( 'gid' ) == 25)
		return true;
	$back_end = false;
	if ($app->getName() != 'site')
		$back_end = true;
	$groups = array (
			- 1
	);
	$roles = array (
			- 1
	);
	$functions = array (
			- 1
	);
	if ($user->get( 'id' ) > 0) {
		$query = "SELECT * FROM #__community_acl_users WHERE user_id = '" . $user->get( 'id' ) . "' ";
		$db->setQuery( $query );
		$grf = $db->loadObjectList();
		if (is_array( $grf ) && count( $grf ) > 0) {
			foreach ( $grf as $row ) {
				$groups [] = $row->group_id;
				$roles [] = $row->role_id;
				$functions [] = $row->function_id;
			}
		}
		if (! (count( $groups ) > 1 && count( $roles ) > 1)) {
			if ($config->get( strtolower( $user->get( 'usertype' ) ) . '_group' ) > 0) {
				$groups [] = $config->get( strtolower( $user->get( 'usertype' ) ) . '_group' );
				$roles [] = $config->get( strtolower( $user->get( 'usertype' ) ) . '_role' );
				$functions [] = $config->get( strtolower( $user->get( 'usertype' ) ) . '_function' );
			}
		}
	} else {
		if ($config->public_group > 0 && $config->public_function >= 0) {
			$groups [] = $config->public_group;
			$roles [] = $config->public_role;
			$functions [] = $config->public_function;
		}
	}
	//no groups/roles/functions for user
	if (! (count( $groups ) > 1 && count( $roles ) > 1))
		return true;
	$catid = - 1;
	$sectionid = - 1;
	if (($back_end && $option == 'com_content') || (! $back_end && $option == 'com_content' && $view == 'article' && $id > 0)) {
		if ($id > 0)
			$cid [] = $id;
		$query = "SELECT `catid`, `sectionid` FROM `#__content` WHERE `id` IN ('" . implode( "','", $cid ) . "')";
		$db->setQuery( $query );
		$tmp = $db->loadAssoc();
		$catid = $tmp ['catid'];
		$sectionid = $tmp ['sectionid'];
	} elseif (($back_end && $option == 'com_categories') || (! $back_end && $option == 'com_content' && $view == 'category' && $id > 0)) {
		if ($id > 0)
			$cid [] = $id;
		$query = "SELECT `section` FROM `#__categories` WHERE `id` IN ('" . implode( "','", $cid ) . "')";
		$db->setQuery( $query );
		$sectionid = $db->loadResult();
	}
	$query = "SELECT `value` FROM `#__community_acl_config` WHERE `name` = 'default_action' ";
	$db->setQuery( $query );
	$default_action = $db->loadResult();
	if ($default_action == null)
		$default_action = 'deny';
	$query = "SELECT a.*, b.link FROM `#__community_acl_access` AS a LEFT JOIN `#__menu` AS b ON a.value = b.id WHERE a.option IN ('menu') AND " . ($back_end ? ' a.isbackend = 1 ' : ' a.isfrontend = 1 ') . " AND ( a.group_id IN ( '" . implode( "','", $groups ) . "') OR a.role_id IN ( '" . implode( "','", $roles ) . "') )";
	$db->setQuery( $query );
	$menus = $db->loadObjectList();
	if ($back_end && $option == 'com_login' && ($task == 'login' || $task == 'logout'))
		return true;
	if ($option == 'com_sections' || $option == 'com_categories' || $option == 'com_content')
		$query = "SELECT * FROM `#__community_acl_access` WHERE `option` IN ('menu', 'com_sections', 'com_categories', 'com_content' ) AND " . ($back_end ? ' `isbackend` = 1 ' : ' `isfrontend` = 1 ') . " AND ( `group_id` IN ( '" . implode( "','", $groups ) . "') OR `role_id` IN ( '" . implode( "','", $roles ) . "') )";
	else
		$query = "SELECT * FROM `#__community_acl_access` WHERE `option` IN ( 'menu', '{$option}') AND " . ($back_end ? ' `isbackend` = 1 ' : ' `isfrontend` = 1 ') . " AND ( `group_id` IN ( '" . implode( "','", $groups ) . "') OR `role_id` IN ( '" . implode( "','", $roles ) . "') )";
	$db->setQuery( $query );
	$access = $db->loadObjectList();
	$froles = array ();
	$fgroups = array ();
	if (is_array( $access ) && count( $access ) > 0) {
		foreach ( $access as $item ) {
			//forbidden components
			if ($item->name == '###' && $option == $item->option && ($option != 'com_content' && ! ($option == 'com_login' && $task == 'logout'))) {
				if ($item->role_id == '0') {
					$fgroups [] = $item->group_id;
				} else
					$froles [] = $item->role_id;
			} elseif ($item->name == '###' && $item->option == 'menu') {
				if (check_menu( $item->value, $request ))
					if ($default_action == 'allow') {
						return false;
					}
			} elseif ($item->name != '###') {
				//forbidden content, sections, categiries
				if ($back_end) {
					if ($option == 'com_content' && ($id == $item->value || in_array( $item->value, $cid ))) {
						if ($item->role_id == '0')
							$fgroups [] = $item->group_id;
						else
							$froles [] = $item->role_id;
					} elseif ($option == 'com_content' && (($item->option == 'com_sections' && $sectionid == $item->value) || ($item->option == 'com_categories' && $catid == $item->value))) {
						if ($item->role_id == '0')
							$fgroups [] = $item->group_id;
						else
							$froles [] = $item->role_id;
					} elseif ($option == 'com_sections' && ($id == $item->value || in_array( $item->value, $cid ))) {
						if ($item->role_id == '0')
							$fgroups [] = $item->group_id;
						else
							$froles [] = $item->role_id;
					} elseif ($option == 'com_categories' && ($id == $item->value || in_array( $item->value, $cid ))) {
						if ($item->role_id == '0')
							$fgroups [] = $item->group_id;
						else
							$froles [] = $item->role_id;
					}
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
					if ($option == 'com_content' && $task == 'edit' && ($id == $item->value || in_array( $item->value, $cid ))) {
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
		if (is_array( $rows ) && count( $rows ) > 0)
			foreach ( $rows as $i => $group ) {
				$ind = array_search( $group, $groups );
				if (in_array( $group, $fgroups ) && $ind !== false) {
					unset( $groups [$ind] );
					unset( $roles [$ind] );
					unset( $functions [$ind] );
				}
				$ind = array_search( $rls [$i], $roles );
				if (in_array( $rls [$i], $froles ) && $ind !== false) {
					unset( $groups [$ind] );
					unset( $roles [$ind] );
					unset( $functions [$ind] );
				}
			}
		if (! (count( $groups ) > 1 && count( $roles ) > 1)) {
			return false;
		}
	} else {
		if (is_array( $rows ) && count( $rows ) > 0)
			foreach ( $rows as $i => $group ) {
				$ind = array_search( $group, $groups );
				if (! in_array( $group, $fgroups ) && $ind !== false) {
					$groups [$ind] = - 1;
					if (! in_array( $roles [$ind], $froles )) {
						$roles [$ind] = - 1;
						$functions [$ind] = - 1;
					}
				}
				$ind = array_search( $rls [$i], $roles );
				if (! in_array( $rls [$i], $froles ) && $ind !== false) {
					$roles [$ind] = - 1;
					if (! in_array( $groups [$ind], $fgroups )) {
						$groups [$ind] = - 1;
						$functions [$ind] = - 1;
					}
				}
			}
		$groups = array_unique( $groups );
		$roles = array_unique( $roles );
		$functions = array_unique( $functions );
		if ((count( $groups ) == 1 && count( $roles ) == 1)) {
			return false;
		}
	}
	$query = "SELECT COUNT(*) FROM `#__community_acl_content_actions` WHERE `func_id` IN ( '" . implode( "','", $functions ) . "') ";
	$db->setQuery( $query );
	$count = ( int ) $db->loadResult();
	if ($option == 'com_content') {
		$query = "SELECT COUNT(*) FROM `#__community_acl_function_access` WHERE `option` = 'com_content' AND `name` = '#any_key#' AND `value` = '#any_value#' AND " . ($back_end ? ' `isbackend` = 1 ' : ' `isfrontend` = 1 ') . " AND `func_id` IN ( '" . implode( "','", $functions ) . "')";
		$db->setQuery( $query );
		$count = $count && ! ( int ) $db->loadResult();
	}
	if ($count && ($task == '' || $task == 'save' || $task == 'apply' || $task == 'new' || $task == 'add' || $task == 'remove' || $task == 'copyselect' || $task == 'moveselect' || $task == 'edit' || $task == 'publish' || $task == 'unpublish' || $task == 'copy' || $task == 'movesect' || $task == 'archive' || $task == 'unarchive')) {
		$acl = & JFactory::getACL();
		$publish_array = array (
				'com_content',
				'publish',
				'users',
				strtolower( $user->get( 'usertype' ) ),
				'content',
				'all',
				NULL
		);
		$publish_index = array_search( $publish_array, $acl->acl );
		$edit_array = array (
				'com_content',
				'edit',
				'users',
				strtolower( $user->get( 'usertype' ) ),
				'content',
				'all',
				NULL
		);
		$edit_index = array_search( $edit_array, $acl->acl );
		if ($option == 'com_sections' && ($sectionid > - 1 || $sectionid_r > - 1)) {
			$query = "SELECT * FROM `#__community_acl_content_actions` WHERE `item_type` = 'section' AND `func_id` IN ( '" . implode( "','", $functions ) . "') ";
			$db->setQuery( $query );
			$function_access = $db->loadObjectList();
			$bingo = false;
			$bingo_publish = false;
			if (is_array( $function_access ) && count( $function_access ) > 0)
				foreach ( $function_access as $item ) {
					if (($task == 'add' || $task == 'remove' || $task == 'copyselect') && $item->action == 'add' && ($id == $item->item_id || in_array( $item->item_id, $cid )))
						$bingo = true;
					if (($task == 'new') && $item->action == 'add' && $sectionid_r == $item->item_id)
						$bingo = true;
					if (($task == 'edit') && $item->action == 'edit' && ($id == $item->item_id || in_array( $item->item_id, $cid )))
						$bingo = true;
					if (($task == 'publish' || $task == 'unpublish') && $item->action == 'publish' && ($id == $item->item_id || in_array( $item->item_id, $cid )))
						$bingo = true;
					if (($task == 'edit') && $item->action == 'publish' && ($id == $item->item_id || in_array( $item->item_id, $cid )))
						$bingo_publish = true;
				}
			if ($bingo_publish) {
				if ($config->default_action == 'allow') {
					//unset($acl->acl[$publish_index]);
				//$acl->acl_count--;
				}
			} elseif ($config->default_action == 'deny') {
				//unset($acl->acl[$publish_index]);
			//$acl->acl_count--;
			}
			if ($bingo) {
				if ($default_action == 'allow') {
					return false;
				}
			} elseif ($default_action == 'deny') {
				return false;
			}
		}
		if ($option == 'com_categories' && ($catid > - 1 || $catid_r > - 1)) {
			$query = "SELECT * FROM `#__community_acl_content_actions` WHERE `item_type` IN ('section', 'category') AND `func_id` IN ( '" . implode( "','", $functions ) . "') ";
			$db->setQuery( $query );
			$function_access = $db->loadObjectList();
			$bingo = false;
			$bingo_publish = false;
			//echo "$sectionid, $sectionid_r, $catid, $catid_r";die;
			if (is_array( $function_access ) && count( $function_access ) > 0)
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
						if (($task == 'add' || $task == 'remove' || $task == 'copyselect' || $task == 'moveselect') && $item->action == 'add' && ($id == $item->item_id || in_array( $item->item_id, $cid )))
							$bingo = true;
						if (($task == 'new') && $item->action == 'add' && $catid_r == $item->item_id)
							$bingo = true;
						if (($task == 'edit') && $item->action == 'edit' && ($id == $item->item_id || in_array( $item->item_id, $cid )))
							$bingo = true;
						if (($task == 'publish' || $task == 'unpublish') && $item->action == 'publish' && ($id == $item->item_id || in_array( $item->item_id, $cid )))
							$bingo = true;
						if ($task == 'edit' && $item->action == 'publish' && ($id == $item->item_id || in_array( $item->item_id, $cid )))
							$bingo_publish = true;
					}
				}
			if ($bingo_publish) {
				if ($config->default_action == 'allow') {
					//unset($acl->acl[$publish_index]);
				//$acl->acl_count--;
				}
			} elseif ($config->default_action == 'deny') {
				//unset($acl->acl[$publish_index]);
			//$acl->acl_count--;
			}
			if ($bingo) {
				if ($default_action == 'allow') {
					return false;
				}
			} elseif ($default_action == 'deny') {
				return false;
			}
		}
		if ($option == 'com_content') {
			$query = "SELECT * FROM `#__community_acl_content_actions` WHERE `item_type` IN ('section', 'category', 'content') AND `func_id` IN ( '" . implode( "','", $functions ) . "') ";
			$db->setQuery( $query );
			$function_access = $db->loadObjectList();
			$bingo = false;
			$bingo_edit = false;
			$bingo_publish = false;
			if (is_array( $function_access ) && count( $function_access ) > 0)
				foreach ( $function_access as $item ) {
					if ($item->item_type == 'section') {
						if (($task == 'add' || $task == 'remove' || $task == 'copyselect' || $task == 'moveselect') && $item->action == 'add' && $sectionid == $item->item_id)
							$bingo = true;
						if (($task == 'new' || $task == 'add' || ($view == 'article' && $layout == 'form')) && $item->action == 'add' /*&& $sectionid_r == $item->item_id*/ ) {
							$bingo = true;
							$bingo_edit = true;
						}
						if (($task == 'save' || $task == 'apply') && ($item->action == 'add' || $item->action == 'edit') && $sectionid_r == $item->item_id) {
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
							$bingo = true;
							$bingo_edit = true;
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
						if (($task == 'edit' || $task == 'archive' || $task == 'unarchive') && $item->action == 'edit' && ($id == $item->item_id || in_array( $item->item_id, $cid )))
							$bingo = true;
						if (($task == 'publish' || $task == 'unpublish') && $item->action == 'publish' && ($id == $item->item_id || in_array( $item->item_id, $cid )))
							$bingo = true;
						if ($task == 'edit' && $item->action == 'publish' && ($id == $item->item_id || in_array( $item->item_id, $cid )))
							$bingo_publish = true;
					}
				}
			if ($bingo_edit) {
				if ($config->default_action == 'allow') {
					//unset($acl->acl[$edit_index]);
				//$acl->acl_count--;
				}
			} elseif ($config->default_action == 'deny') {
				//unset($acl->acl[$edit_index]);
			//$acl->acl_count--;//die('bingo_edit');
			}
			if ($bingo_publish) {
				if ($config->default_action == 'allow') {
					//unset($acl->acl[$publish_index]);
				//$acl->acl_count--;
				}
			} elseif ($config->default_action == 'deny') {
				//unset($acl->acl[$publish_index]);
			//$acl->acl_count--;//die('bingo_publish');
			}
			if ($bingo) {
				if ($default_action == 'allow') {
					return false;
				}
			} elseif ($default_action == 'deny' && ($task != '' || ($view == 'article' && $layout == 'form'))) {
				return false;
			}
		}
	}
	$query = "SELECT * FROM `#__community_acl_function_access` WHERE `option` = '{$option}' AND " . ($back_end ? ' `isbackend` = 1 ' : ' `isfrontend` = 1 ') . " AND `func_id` IN ( '" . implode( "','", $functions ) . "') AND `name` <> 'option' ORDER BY `grouping`";
	$db->setQuery( $query );
	$function_access = $db->loadObjectList();
	// (isset($_REQUEST['searchword']) || isset($_REQUEST['action']) || isset($_REQUEST['view']) || isset($_REQUEST['task']) || isset($_REQUEST['id']) || isset($_REQUEST['cid']) || isset($_REQUEST['mode'])) &&
	if (is_array( $function_access ) && count( $function_access ) > 0) {
		$query = "SELECT `grouping` FROM `#__community_acl_function_access` WHERE `option` = '{$option}' AND " . ($back_end ? ' `isbackend` = 1 ' : ' `isfrontend` = 1 ') . " AND `func_id` IN ( '" . implode( "','", $functions ) . "') AND `name` <> 'option' GROUP BY `grouping` ORDER BY `grouping`";
		$db->setQuery( $query );
		$groupings = $db->loadObjectList();
		$allow_pass = false;
		if (is_array( $groupings ) && count( $groupings ) > 0)
			foreach ( $groupings as $g ) {
				$allow_pass = false;
				if (is_array( $function_access ) && count( $function_access ) > 0)
					foreach ( $function_access as $item ) {
						if ($item->grouping != $g->grouping)
							continue;
						if ($item->name == '#any_key#') {
							$allow_pass = false;
							continue;
						}
						if (! isset( $request [$item->name] ) && $config->default_action == 'allow') {
							$allow_pass = true;
							continue;
						}
						if (! isset( $request [$item->name] ) && $config->default_action == 'deny') {
							continue;
						}
						if ($item->name == 'id') {
							if (((( int ) $request [$item->name] != $item->value && $item->value && $item->extra != '1') || (( int ) $request [$item->name] == $item->value && $item->extra == '1')) && $item->value != '#any_value#') {
								//echo 1;die;
								$allow_pass = true;
								continue;
							}
						} elseif (is_array( $request [$item->name] )) {
							if (((! in_array( $item->value, $request [$item->name] ) && $item->value && $item->extra != '1') || (in_array( $item->value, $request [$item->name] ) && $item->extra == '1')) && $item->value != '#any_value#') {
								//echo 2;die;
								$allow_pass = true;
								continue;
							}
						} else {
							if ((($request [$item->name] != $item->value && $item->value && $item->extra != '1') || ($request [$item->name] == $item->value && $item->extra == '1')) && $item->value != '#any_value#') {
								//echo 3;die;
								$allow_pass = true;
								continue;
							}
						}
					}
				if (! $allow_pass) {
					return ($default_action == 'deny' ? true : false);
				}
			}
	} else {
		return true;
	}
	return ($default_action == 'deny' ? false : true);
}
if (! function_exists( 'check_component' )) {
	function check_component($option) {
		$user = & JFactory::getUser();
		if ($user->get( 'gid' ) == 25)
			return true;
		$db = & JFactory::getDBO();
		$config = new CACL_config( $db );
		$config->load();
		$user_access = cacl_get_user_access( $config );
		$groups = $user_access ['groups'];
		$roles = $user_access ['roles'];
		$functions = $user_access ['functions'];
		$query = "SELECT COUNT(*) FROM `#__components` WHERE `parent` = 0  AND `option` = '{$option}' ";
		$db->setQuery( $query );
		// Kobby updated to check for specific managers - Catgory, Section and Frontpage Managers
		if (($option == 'com_categories' || $option == 'com_sections' || $option == 'com_frontpage')) {
			//Continue...
		} else {
			if (( int ) $db->loadResult() < 1)
				return true;
		}
		$query = "SELECT * FROM `#__community_acl_access` WHERE `option` = '{$option}' AND `name` = '###' AND `isbackend` = 1 AND ( `group_id` IN ( '" . implode( "','", $groups ) . "') OR `role_id` IN ( '" . implode( "','", $roles ) . "') )";
		$db->setQuery( $query );
		$access = $db->loadObjectList();
		/*if($option == 'com_categories'){

		//echo $db->getQuery().'<br>';die();

	}*/
		$query = "SELECT `value` FROM `#__community_acl_config` WHERE `name` = 'default_action' ";
		$db->setQuery( $query );
		$default_action = $db->loadResult();
		if ($default_action == null)
			$default_action = 'deny';
		if (is_array( $access ) && count( $access ) > 0) {
			return ($default_action == 'deny' ? true : false);
		}
		return ($default_action == 'deny' ? false : true);
	}
}
if (! function_exists( 'check_modules' )) {
	function check_modules(&$modules) {
		$user = & JFactory::getUser();
		if ($user->get( 'gid' ) == 25)
			return true;
		if (is_array( $modules ) && count( $modules ) > 0) {
			$tmp = $modules;
			foreach ( $modules as $i => $m ) {
				if (! check_module( $m->id )) {
					unset( $tmp [$i] );
				}
			}
			$modules = array ();
			foreach ( $tmp as $m ) {
				$modules [] = $m;
			}
		}
	}
}
function check_module($id = 0) {
	$user = & JFactory::getUser();
	if ($user->get( 'gid' ) == 25)
		return true;
	$db = & JFactory::getDBO();
	require_once (JPATH_SITE . '/administrator/components/com_community_acl/community_acl.class.php');
	$config = new CACL_config( $db );
	$config->load();
	$user_access = cacl_get_user_access( $config );
	$groups = $user_access ['groups'];
	$roles = $user_access ['roles'];
	$functions = $user_access ['functions'];
	$default_action = $config->default_action;
	$query = "SELECT `client_id` FROM `#__modules` WHERE `id` = '{$id}'";
	$db->setQuery( $query );
	if (( int ) $db->loadResult() > 0)
		return true;
	$query = "SELECT COUNT(*) FROM `#__community_acl_access` WHERE ( group_id IN ( '" . implode( "','", $groups ) . "') OR role_id IN ( '" . implode( "','", $roles ) . "') ) AND `option` = 'module' AND `name` = '@@@' AND `value` = '{$id}'";
	$db->setQuery( $query );
	if (( int ) $db->loadResult() > 0)
		return ($default_action == 'deny' ? true : false);
	return ($default_action == 'deny' ? false : true);
}
# - Kobby Sam needs to check this side to see what's wrong with Menu display
function check_menu($menu_id = 0, $request) {
	$db = & JFactory::getDBO();
	$query = "SELECT `link` FROM `#__menu` WHERE id = '" . $menu_id . "' ";
	$db->setQuery( $query );
	$link = $db->loadResult();
	if (strpos( $link, '?' ) !== false) {
		$link = substr( $link, strpos( $link, '?' ) + 1 );
		$link = str_replace( '&amp;', '&', $link );
		$pairs = explode( '&', $link );
		//$request = array();
		if (count( $pairs ) > 0) {
			$matches = 0;
			foreach ( $pairs as $pair ) {
				list ( $option, $value ) = explode( '=', $pair );
				if (isset( $request [$option] ) && $request [$option] == $value)
					$matches ++;
			}
			if (count( $pairs ) == $matches)
				return true;
		}
	}
	return false;
}
if (! function_exists( 'caclStripslashes' )) {
	function caclStripslashes(&$value) {
		$ret = '';
		if (is_string( $value )) {
			$ret = stripslashes( $value );
		} else {
			if (is_array( $value )) {
				$ret = array ();
				foreach ( $value as $key => $val ) {
					$ret [$key] = caclStripslashes( $val );
				}
			} else {
				$ret = $value;
			}
		}
		return $ret;
	}
}
function cacl_get_user_access(&$config) {
	$user = & JFactory::getUser();
	$db = & JFactory::getDBO();
	$groups = array (
			- 1
	);
	$roles = array (
			- 1
	);
	$functions = array (
			- 1
	);
	if ($user->get( 'id' ) > 0) {
		$query = "SELECT * FROM `#__community_acl_users` WHERE `user_id` = '" . $user->get( 'id' ) . "' ";
		$db->setQuery( $query );
		$grf = $db->loadObjectList();
		foreach ( $grf as $r )
			$func [] = $r->function_id;
		if (count( @$func ) > 0) {
			$query = "SELECT func_id FROM `#__community_acl_content_actions` WHERE `func_id` IN ('" . implode( "','", @$func ) . "') ";
			$db->setQuery( $query );
			$arr_list = $db->loadResultArray();
		}
		//print_r($query);
		$task = JRequest::getVar( 'add' );
		//if(count($arr_list) > 0){
		if (is_array( $grf ) && count( $grf ) > 0) {
			foreach ( $grf as $row ) {
				$groups [] = $row->group_id;
				$roles [] = $row->role_id;
				//if(!(in_array($row->function_id, $arr_list)))
				//$functions[] = $row->function_id;//Kobby Edited this part
				//if($task == 'add' && $row->action == 'add')
				$functions [] = $row->function_id;
			}
		}
		//} //echo count($arr_list).'<br/>';
		//print_r($functions);
		if (! (count( $groups ) > 1 && count( $roles ) > 1)) {
			if ($config->get( strtolower( $user->get( 'usertype' ) ) . '_group' ) > 0) {
				$groups [] = $config->get( strtolower( $user->get( 'usertype' ) ) . '_group' );
				$roles [] = $config->get( strtolower( $user->get( 'usertype' ) ) . '_role' );
				$functions [] = $config->get( strtolower( $user->get( 'usertype' ) ) . '_function' );
			}
		}
	} else {
		if ($config->public_group > 0 && $config->public_function >= 0) {
			$groups [] = $config->public_group;
			$roles [] = $config->public_role;
			$functions [] = $config->public_function;
			;
		}
	}
	return array (
			'groups' => $groups,
			'roles' => $roles,
			'functions' => $functions
	);
}
?>