<?php
/**
 * @version $Id: cacl_preprocessor.php 1 2010-08-02 21:00:00Z 'corePHP' $
 * @package Community ACL
 * @author 'corePHP' LLC.
 * @copyright (C) 2009- 'corePHP' LLC.
 * @license GNU/GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Support: http://support.corephp.com/
 */
defined('_JEXEC') or die('Restricted access');
//Load Community ACL functions
if (file_exists(JPATH_SITE.'/administrator/components/com_community_acl/community_acl.functions.php')) {
	require_once(JPATH_SITE.'/administrator/components/com_community_acl/community_acl.functions.php');
} else {
	if (!function_exists('check_component')) {
		function check_component ($option) {
			return true;
		}
	}
	if (!function_exists('check_link')) {
		function check_link ($link, $mid = 0) {
			return true;
		}
	}
}
// Import library dependencies
jimport('joomla.event.plugin');
/**
 * Plugin to preprocess content for community acl
 */
class plgSystemCacl_preprocessor extends JPlugin {
	private $_toRemove = '';
	private $_app = '';
	private $_caclConfig = '';

	function plgSystemCacl_preprocessor (&$subject) {

		parent::__construct($subject);

		$db =& JFactory::getDBO();
		$config = new CACL_config($db);
		$config->load();
		$this->_caclConfig = $config;

	}
	function onAfterRender () {
		$app =& JFactory::getApplication();

		//adding cACL Activate
		if( FALSE === strpos($this->_caclConfig->activate, $app->getName())){
			return;
		}

		if (!file_exists(JPATH_SITE.'/administrator/components/com_community_acl/community_acl.functions.php')) {
			return false;
		}
		//Kobby Start
		$user =& JFactory::getUser();
		if ($user->get('gid') == 25) {
			return;
		}
		//Kobby End
		$_document =& JFactory::getDocument();
		$_docType = $_document->getType();
		if ($_docType == 'pdf') {
			return;
		}
		$componentname = JRequest::getVar('option');
		$componentname = array_pop(explode("_", $componentname));
		$viewName = JRequest::getVar('view');
		if ($componentname === 'gcalendar' && $viewName === 'jsonfeed') {
			return;
		}

		$back_end = false;
		if ($app->getName() != 'site') {
			$back_end = true;
		}
		if (!$back_end) {
			$this->frontendMenuAccess();
		} else {
			$this->backendMenuAccess();
		}
	}
	function frontendMenuAccess () {
		$this->_app = JFactory::getApplication();
		$denyList = array();
		$db =& JFactory::getDBO();
		$config = new CACL_config($db);
		$config->load();
		$user_access = cacl_get_user_access($config);
		$groups = $user_access['groups'];
		$roles = $user_access['roles'];
		$functions = $user_access['functions'];
		$denyOrAllow = $config->default_action == 'deny' ? 'NOT IN' : 'IN';
		$queryGroups = implode("','", $groups);
		$queryRoles = implode("','", $roles);
		$query = "SELECT id,name,parent
				FROM #__menu
				WHERE id {$denyOrAllow}
				(SELECT `value` FROM `#__community_acl_access`
				WHERE `option` = 'menu'
				AND `isfrontend` = 1
				AND ( `group_id` IN ('{$queryGroups}') OR `role_id` IN ('{$queryRoles}') ))";
		$db->setQuery($query);
		$denyList = $db->loadAssocList();
		$deniedParents = $db->loadResultArray();
		//remove denied children if parent is denied
		foreach ($denyList as $k => $denyItem) {
			if (in_array($denyItem['parent'], $deniedParents)) {
				unset($denyList[$k]);
			}
		}
		//Remove menu items that are forbidden
		$_html = JResponse::getBody();
		if (isset($denyList) && is_array($denyList) && count($denyList) > 0) {

			$doTidy =
			version_compare(phpversion(), '5', '>=') &&
			extension_loaded('tidy') &&
			version_compare(phpversion('tidy'), '2', '>=') &&
			$config->useTidy == 'true';

			if ($doTidy) {
				$config_options = array(
				    'preserve-entities' => true,
					'output-xhtml'    => true,
					'newline'         => false,
					'wrap'            => false,
					'output-encoding'   => 'utf8',
					'input-encoding'   => 'utf8',
					'char-encoding'   => 'utf8'
				);
			}

			foreach ($denyList as $denyItem) {
				if ($doTidy) {
					$this->_toRemove = array();
					$_html = @tidy_parse_string($_html, $config_options);
					$this->findElement($_html->body(), $denyItem['id'], $denyItem['name']);
					$_html = str_replace($this->_toRemove, '', $_html);
				} else {
					$denyItem = preg_quote($denyItem['name'], '/');
					$id = preg_quote($denyItem['id'], '/');
					$pattern = array();
					if (false !== stripos($this->_app->getTemplate(), 'yoo_studio_5.5.3')) {
						$pattern = '/<li[^>]*?item'.$id.'[^>]*?>\s*<[span|a][^>]*>\s*<span[^>]*>\s*'.$denyItem.'\s*<\/span>\s*<\/[span|a]+>\s*<\/li>\s*/';
						$_html = preg_replace($pattern, '', $_html);
					} elseif (false !== stripos($this->_app->getTemplate(), 'yoo_studio')) {
						$pattern[] = '/<li[^>]*>\s*(<a[^>]*>)*(<span[^>]*>\s*){1,2}'.$denyItem.'.*?(?:<\/div><\/li>)/';
						$pattern[] = '/<li[^>]*>\s*(<a[^>]*>)*(<span[^>]*>\s*){1,2}'.$denyItem.'.*?(?:<\/li>)/';
						$pattern[] = '/<li[^>]*>\s*(<span[^>]*>\s*){2}'.$denyItem.'.*?<\/li>/';
						$pattern[] = '/<div[^>]*>\s*<a[^>]*>\s*<span[^>]*>'.$denyItem.'.*?<\/div>/';
						$pattern[] = '/<li[^>]*>\s*<span[^>]*>\s*<span[^>]*>'.$denyItem.'.*?<\/li>/';
					} elseif (false !== stripos($this->_app->getTemplate(), 'yoo_enterprise')) {
						$pattern[]='/<li[^>]*>(<div[^>]*>)+(<a[^>]*>)*<span[^>]*>\s*'.$denyItem.'.*?(?:<\/span><\/a>(<\/div>)+<\/li>)/';
					} else {
						$pattern[] = '/(?:<li[^>]*>[\s]*(?:(?:<(?:span|a)[^>]*>)[\s]*'.'(?:<(?:span|a)[^>]*>)|[\s]*(?:<(?:a|span)[^>]*>)))'.$denyItem.'(?:(?:(?:[\s]*<\/(?:span|a)>)|(?:[\s]*<\/(?:a|span)>)'.'[\s]*(?:<\/(?:a|span)>))[\s]*<\/li[^>]*>)/';
						//empty ul's
						$pattern[] = '/<ul[^>]*>\s*<\/ul>/';
						//empty li's
						$pattern[] = '/<li[^>]*>\s*<\/li>/';
						//empty menu's
						$pattern[] = '/<div class="module_menu">\s*<div>\s*<div>\s*<div>\s*<h3>.*<\/h3>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>/';
						//swMenu MyGosu
						$pattern[] = '/<td[^>]*>\s*<a[^>]*>'.$denyItem.'<\/a>.*?<\/td>/s';
						$pattern[] = '/<a[^>]*>'.$denyItem.'<\/a>/';
						//swMenu TransMenu
						$pattern[] = '/menu.*\("'.str_replace('\'', '\\\\\'', $denyItem).'".*Itemid='.$id.'.*/';
					}

					if (!empty($pattern)) {

						$tmpHtml = @preg_replace($pattern, '', $_html);

						if ( preg_last_error() !== PREG_NO_ERROR || $tmpHtml == NULL ){
							JError::raiseError('100', JText::_('There was a problem with the cACL regular expressions. cacl_preprocessor.php: '.__LINE__));
						} else {
							$_html = $tmpHtml;
							unset($tmpHtml);
						}
					}
				}
			}
		}

		JResponse::setBody($_html);
	}
	function findElement (&$element, $itemId, $value) {
		switch ($this->_app->getTemplate()) {
			case 'rt_panacea_j15':
				if ($element->name == 'li' && false !== strpos($element->attribute ['class'], 'item'.$itemId) && 1 === preg_match('/.*?'.preg_quote($value, '/').'.*?/', $element->value)) {
					$this->_toRemove[] = $element->value;
				}
				break;
			case 'yoo_symphony5.5':
				if ($element->name == 'a' && false !== strpos($element->attribute ['href'], 'Itemid='.$itemId) && 1 === preg_match('/.*?<span[^>]*>'.preg_quote($value, '/').'<\/span>.*?/', $element->value)) {
					$this->_toRemove[] = $element->getParent()->value;
				}
				break;
			case 'yoo_enterprise':
				if ($element->name == 'span' &&  1 === preg_match('/.*?'.preg_quote($value, '/').'.*?/', $element->value)) {
					$this->_toRemove[] = $element->value;
				}
				break;
			case 'yoo_studio':
				break;
			case 'rt_missioncontrol_j15':
				if ($element->name == 'li' && false === strpos($element->attribute['class'], 'root') && 1 === preg_match('/^<li[^>]*?><a[^>]*?href="[^"]*?option='.preg_quote($value, '/').'("|&){1}/', $element->value)) {
					$this->_toRemove[] = $element->value;
				}
				break;
			default:
				if ($element->name == 'li' && false !== strpos($element->attribute ['class'], 'item'.$itemId) && 1 === preg_match('/.*?<span[^>]*>'.preg_quote($value, '/').'<\/span>.*?/', $element->value)) {
				$this->_toRemove[] = $element->value;
				return;
			}
		}
		if ($element->hasChildren()) {
			foreach ($element->child as & $child) {
				$this->findElement($child, $itemId, $value);
			}
		}
	}
	function getThemeRegex ($theme) {
		return $pattern;
	}
	function doTidy(){
		$db =& JFactory::getDBO();
		$config = new CACL_config($db);
		$config->load();
		return version_compare(phpversion(), '5', '>=') && extension_loaded('tidy') && version_compare(phpversion('tidy'), '2', '>=') && $config->useTidy == 'true';
	}
	function backendMenuAccess () {

		$config = new CACL_config($db);
		$config->load();

		$this->_app = JFactory::getApplication();
		$user_access = cacl_get_user_access($config);
		$db =& JFactory::getDBO();

		if ( $this->doTidy() && $this->_app->getTemplate() == 'rt_missioncontrol_j15' ) {

			$config_options = array(
			    'preserve-entities' => true,
				'output-xhtml'    => true,
				'newline'         => false,
				'wrap'            => false,
				'output-encoding'   => 'utf8',
				'input-encoding'   => 'utf8',
				'char-encoding'   => 'utf8'
			);

			$denyOrAllow = $config->default_action == 'deny' ? 'NOT IN' : 'IN';

			$db->Execute('DROP TABLE IF EXISTS temp');
			$db->Execute('CREATE TEMPORARY TABLE temp ( `option` VARCHAR(255) NOT NULL )');
			$db->Execute("INSERT INTO temp (`option`) VALUES ('com_categories'),('com_sections'),('com_frontpage'),('com_content'),('com_media')");
			$db->Execute("INSERT INTO temp (`option`) (SELECT DISTINCT `option` FROM #__components)");

			// `name`='###' means it's a component
			$query = "
				SELECT DISTINCT `option` FROM temp
				WHERE `option` {$denyOrAllow} (
					SELECT DISTINCT `option` FROM #__community_acl_access
					WHERE
					(`group_id` IN (".implode(',',array_filter($user_access['groups'])).") && `isbackend`=1 && `name`='###')
					||
					(`role_id` IN (".implode(',',array_filter($user_access['roles'])).") && `isbackend`=1 && `name`='###')
				)
				&& `option` != ''";
			$db->setQuery($query);
			$componentList = $db->loadResultArray();
			$db->Execute('DROP TABLE IF EXISTS temp');

			$_html = JResponse::getBody();

			foreach ($componentList as $componentName){
				$_html = @tidy_parse_string($_html, $config_options);
				$this->findElement($_html->body(), 0, $componentName);
				$_html = str_replace($this->_toRemove, '', $_html);
			}

			JResponse::setBody($_html);
			return;
		}


		$lang =& JFactory::getLanguage();
		$user =& JFactory::getUser();
		$db =& JFactory::getDBO();
		$usertype = $user->get('usertype');
		$check_component_com_checkin = $this->check_component('com_checkin');
		$check_component_com_config = $this->check_component('com_config');
		$check_component_com_templates = $this->check_component('com_templates');
		$check_component_com_trash = $this->check_component('com_trash');
		$check_component_com_menus = $this->check_component('com_menus');
		$check_component_com_languages = $this->check_component('com_languages');
		$check_component_com_modules = $this->check_component('com_modules');
		$check_component_com_installer = $this->check_component('com_installer');
		$check_component_com_plugins = $this->check_component('com_plugins');
		$check_component_com_massmail = $this->check_component('com_massmail');
		$check_component_com_users = $this->check_component('com_users');
		$check_component_com_media = $this->check_component('com_media');
		$check_component_com_login = $this->check_component('com_login');
		$check_component_com_frontpage = $this->check_component('com_frontpage');
		$check_component_com_content = $this->check_component('com_content');
		$check_component_com_sections = $this->check_component('com_sections');
		$check_component_com_categories = $this->check_component('com_categories');
		$check_component_com_messages = $this->check_component('com_messages');
		$check_component_com_cache = $this->check_component('com_cache');
		$check_component_com_admin = $this->check_component('com_admin');
		// cache some acl checks
		$canCheckin = $user->authorize('com_checkin', 'manage') && $check_component_com_checkin;
		$canConfig = $user->authorize('com_config', 'manage') && $check_component_com_config;
		$manageTemplates = $user->authorize('com_templates', 'manage') && $check_component_com_templates;
		$manageTrash = $user->authorize('com_trash', 'manage') && $check_component_com_trash;
		$manageMenuMan = $user->authorize('com_menus', 'manage') && $check_component_com_menus;
		$manageLanguages = $user->authorize('com_languages', 'manage') && $check_component_com_languages;
		$installModules = $user->authorize('com_installer', 'module'); //&& $check_component_com_installer;
		$editAllModules = $user->authorize('com_modules', 'manage') && $check_component_com_modules;
		$installPlugins = $user->authorize('com_installer', 'plugin') && $check_component_com_installer;
		$editAllPlugins = $user->authorize('com_plugins', 'manage') && $check_component_com_plugins;
		$installComponents = $user->authorize('com_installer', 'component') && $check_component_com_installer;
		$editAllComponents = $user->authorize('com_components', 'manage');
		$canMassMail = $user->authorize('com_massmail', 'manage') && $check_component_com_massmail;
		$canManageUsers = $user->authorize('com_users', 'manage') && $check_component_com_users;
		//build regex array based on access
		$preRegex = '/(?>(<li.*?>))(?>(<a.*?>))';
		$postRegex = '<\/a><\/li>/s';
		/*
		 * Site SubMenu
		*/
		if (!$canManageUsers) {
			$pattern[] = $preRegex.JText::_('User Manager').$postRegex;
		}
		if (!$check_component_com_media) {
			$pattern[] = $preRegex.JText::_('Media Manager').$postRegex;
		}
		if (!$canConfig) {
			$pattern[] = $preRegex.JText::_('Configuration').$postRegex;
		}
		if (!$check_component_com_login) {
			$pattern[] = $preRegex.JText::_('Logout').$postRegex;
		}
		/*
		 * Menus SubMenu
		*/
		if (!$manageMenuMan && !$manageTrash) {
			$pattern[] = $preRegex.JText::_('Menus').$postRegex;
		}
		if (!$manageMenuMan) {
			$pattern[] = $preRegex.JText::_('Menu Manager').$postRegex;
		}
		if (!$manageTrash) {
			$pattern[] = $preRegex.JText::_('Menu Trash').$postRegex;
		}
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_menus'.DS.'helpers'.DS.'helper.php');
		$menuTypes = MenusHelper::getMenuTypelist();
		if (count($menuTypes) && !$check_component_com_menus) {
			foreach ($menuTypes as $menuType) {
				$pattern[] = $preRegex.preg_quote($menuType->title, '/').($menuType->home ? ' \*' : '').$postRegex;
			}
		}
		/*
		 * Content SubMenu
		*/
		if (!$check_component_com_content && !$manageTrash && !$check_component_com_sections && !$check_component_com_categories && !$check_component_com_frontpage) {
			$pattern[] = $preRegex.JText::_('Content').$postRegex;
		}
		if (!$check_component_com_content) {
			$pattern[] = $preRegex.JText::_('Article Manager').$postRegex;
		}
		if (!$manageTrash) {
			$pattern[] = $preRegex.JText::_('Article Trash').$postRegex;
		}
		if (!$check_component_com_sections) {
			$pattern[] = $preRegex.JText::_('Section Manager').$postRegex;
		}
		if (!$check_component_com_categories) {
			$pattern[] = $preRegex.JText::_('Category Manager').$postRegex;
		}
		if (!$check_component_com_frontpage) {
			$pattern[] = $preRegex.JText::_('Frontpage Manager').$postRegex;
		}
		/*
		 * Components SubMenu
		*/
		$query = 'SELECT *'.' FROM #__components'.' WHERE '.$db->NameQuote('option').' <> "com_frontpage"'.' AND '.$db->NameQuote('option').' <> "com_media"'.' AND enabled = 1'.' ORDER BY ordering, name';
		$db->setQuery($query);
		$comps = $db->loadObjectList(); // component list
		$subs = array(); // sub menus
		$langs = array(); // additional language files to load
		if (!$editAllComponents) {
			$pattern[] = $preRegex.JText::_('Components').$postRegex;
			foreach ($comps as $row) {
				if ($row->parent == 0 && (trim($row->admin_menu_link ) || array_key_exists($row->id, $subs))) {
					$text = $lang->hasKey($row->option ) ? JText::_($row->option ) : $row->name;
					$text = preg_quote($text, '/');
					if (array_key_exists($row->id, $subs)) {
						$pattern[] = $preRegex.$text.$postRegex;
						$no_submenu = false;
						foreach ($subs[$row->id] as $sub) {
							$key = $row->option.'.'.$sub->name;
							$text = $lang->hasKey($key) ? JText::_($key) : $sub->name;
							$text = preg_quote($text, '/');
							$pattern[] = $preRegex.$text.$postRegex;
						}
					} else {
						$pattern[] = $preRegex.$text.$postRegex;
					}
				}
			}
		} else {
			// first pass to collect sub-menu items
			foreach ($comps as $row) {
				if ($row->parent) {
					if (!array_key_exists($row->parent, $subs)) {
						$subs[$row->parent] = array();
					}
					$subs[$row->parent][] = $row;
					$langs[$row->option.'.menu'] = true;
				} elseif (trim($row->admin_menu_link )) {
					$langs[$row->option.'.menu'] = true;
				}
			}
			foreach ($comps as $row) {
				if (!$this->check_component($row->option )) {
					if ($row->parent == 0 && (trim($row->admin_menu_link ) || array_key_exists($row->id, $subs))) {
						$ptext = $lang->hasKey($row->option ) ? JText::_($row->option ) : $row->name;
						$ptext = preg_quote($ptext, '/');
						if (array_key_exists($row->id, $subs)) {
							$no_submenu = false;
							foreach ($subs[$row->id] as $sub) {
								$key = $row->option.'.'.$sub->name;
								$text = $lang->hasKey($key) ? JText::_($key) : $sub->name;
								$text = preg_quote($text, '/');
								$pattern[] = $preRegex.$text.$postRegex;
							}
							$pattern[] = '/(?>(<a.*?>))'.$ptext.'<\/a>/s';
						} else {
							$pattern[] = $preRegex.$ptext.$postRegex;
						}
					}
				}
			}
		}
		//print_r($pattern);die();
		/*
		* Extensions SubMenu
		*/
		if (!$check_component_com_installer && !$editAllModules && !$editAllPlugins && !$manageTemplates && !$manageLanguages) {
			$pattern[] = $preRegex.JText::_('Extensions').$postRegex;
		}
		if (!$check_component_com_installer) {
			$pattern[] = $preRegex.JText::_('Install\/Uninstall').$postRegex;
		}
		if (!$editAllModules) {
			$pattern[] = $preRegex.JText::_('Module Manager').$postRegex;
		}
		if (!$editAllPlugins) {
			$pattern[] = $preRegex.JText::_('Plugin Manager').$postRegex;
		}
		if (!$manageTemplates) {
			$pattern[] = $preRegex.JText::_('Template Manager').$postRegex;
		}
		if (!$manageLanguages) {
			$pattern[] = $preRegex.JText::_('Language Manager').$postRegex;
		}
		/*
		 * System SubMenu
		*/
		if (!$canConfig && !$canCheckin && !$canMassMail && !$check_component_com_cache) {
			$pattern[] = $preRegex.JText::_('Tools').$postRegex;
		}
		if (!$check_component_com_cache) {
			$pattern[] = $preRegex.JText::_('Purge Expired Cache').$postRegex;
		}
		if (!$canConfig && !$check_component_com_messages) {
			$pattern[] = $preRegex.JText::_('Read Messages').$postRegex;
			$pattern[] = $preRegex.JText::_('Write Message').$postRegex;
		}
		if (!$canMassMail && !$check_component_com_massmail) {
			$pattern[] = $preRegex.JText::_('Mass Mail').$postRegex;
		}
		if (!$canCheckin && !$check_component_com_checkin) {
			$pattern[] = $preRegex.JText::_('Global Checkin').$postRegex;
		}
		if (!$check_component_com_cache) {
			$pattern[] = $preRegex.JText::_('Clean Cache').$postRegex;
		}
		/*
		 * Help SubMenu
		*/
		if (!$check_component_com_admin) {
			$pattern[] = $preRegex.JText::_('Help').$postRegex;
			$pattern[] = $preRegex.JText::_('Joomla\! Help').$postRegex;
			$pattern[] = $preRegex.JText::_('System Info').$postRegex;
		}
		//print_r($pattern);die();
		if (is_array($pattern)) {
			$_html = JResponse::getBody();
			//Bernard start
			$_html = @preg_replace($pattern, '', $_html);
			if ($_html === null) {
				JError::raiseError('We apologize');
			}
			//Bernard end
			$_html = preg_replace($pattern, '', $_html);
			JResponse::setBody($_html);
		}
	}
	function check_component ($option) {
		$user =& JFactory::getUser();
		if ($user->get('gid') == 25) return true;
		$db =& JFactory::getDBO();
		$config = new CACL_config($db);
		$config->load();
		$user_access = cacl_get_user_access($config);
		$groups = $user_access['groups'];
		$roles = $user_access['roles'];
		$functions = $user_access['functions'];
		$query = "SELECT COUNT(*) FROM `#__components` WHERE `parent` = 0  AND `option` = '{$option}' ";
		$db->setQuery($query);
		/*
		 // Kobby updated to check for specific managers - Catgory, Section and Frontpage Managers
		if(( $option == 'com_categories' || $option == 'com_sections' || $option == 'com_frontpage' )){
		//Continue...
		}else{
		if ((int)$db->loadResult() < 1 )
		return true;
		}
		*/
		$query = "SELECT * FROM `#__community_acl_access` WHERE `option` = '{$option}' AND `name` = '###' AND `isbackend` = 1 AND ( `group_id` IN ( '".implode("','", $groups)."') OR `role_id` IN ( '".implode("','", $roles)."') )";
		$db->setQuery($query);
		$access = $db->loadObjectList();
		/*if($option == 'com_categories'){
		 //echo $db->getQuery().'<br>';die();
		}*/
		$query = "SELECT `value` FROM `#__community_acl_config` WHERE `name` = 'default_action' ";
		$db->setQuery($query);
		$default_action = $db->loadResult();
		if ($default_action == null) $default_action = 'deny';
		if (is_array($access) && count($access) > 0) {
			return ($default_action == 'deny' ? true : false);
		}
		return ($default_action == 'deny' ? false : true);
	}

}