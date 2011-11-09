<?php
if (! function_exists ( 'caclStripslashes' )) {
	function caclStripslashes(&$value) {
		$ret = '';
		if (is_string ( $value )) {
			$ret = stripslashes ( $value );
		} else {
			if (is_array ( $value )) {
				$ret = array ();
				foreach ( $value as $key => $val ) {
					$ret [$key] = caclStripslashes ( $val );
				}
			} else {
				$ret = $value;
			}
		}
		return $ret;
	}
}
class CB_config extends JObject {
	var $_db = null;
	# - store the field values
	var $cacl_group_id = null;
	var $cacl_role_id = null;
	var $cacl_func_list = null;
	var $redirect_url = null;
	var $admin_redirect_url = null;
	var $member_list_id = null;
	function __construct(&$db) {
		//initialise
		$this->_db = $db;
		$this->cacl_group_id = '0';
		$this->cacl_role_id = '0';
		$this->cacl_func_list = '0';
		$this->redirect_url = '';
		$this->admin_redirect_url = '';
		$this->member_list_id = '0';
	}
	function storeData($cb_infos) {
		# - store the community_acl_groups/roles info into the db
		/* * /
		echo '<pre/>';

		print_r($cb_infos);

		echo '</pre>';
		die;
		/* */
		# - Clear the existing CB Details in ACL_users
		$query = "DELETE FROM `#__community_acl_users` " . " WHERE `user_id` < 62";
		$this->_db->setQuery ( $query );
		$this->_db->query ();
		$query = "DELETE FROM `#__community_acl_cb_groups`";
		$this->_db->setQuery ( $query );
		$this->_db->query ();
		$query = "DELETE FROM `#__community_acl_cb_roles`";
		$this->_db->setQuery ( $query );
		$this->_db->query ();
		$query = "DELETE FROM `#__community_acl_cb_functions`";
		$this->_db->setQuery ( $query );
		$this->_db->query ();
		# - 1. Store CB Details in ACl_users
		if (isset ( $cb_infos ['cacl_func_id'] )) :
			$count = count ( $cb_infos ['cacl_func_id'] );

		endif;
		$counter = 0;
		if (isset ( $count )) :
			for($i = 0; $i < $count; $i ++) {
				$k = $i + 1;
				/* Query sets user front and admin login redirect to failed login redirect that is set on config page. Removed. BUR 9/29/2010 */
				//$query = "INSERT INTO `#__community_acl_users` " . "  SET `user_id` = '" . $k . "'" . "	  , `group_id` = '" . $cb_infos ['cacl_group_id'] [$i] . "'" . "	  , `role_id` = '" . $cb_infos ['cacl_role_id'] [$i] . "'" . "	  , `function_id` = '" . $cb_infos ['cacl_func_id'] [$i] . "'" . "	  , `redirect_front` = '" . $cb_infos ['redirect_url'] . "'" . "	  , `redirect_admin` = '" . $cb_infos ['admin_redirect_url'] . "'" . "    , `cb_member_type` = '" . $cb_infos ['member_list_id'] [$i] . "' ";
				$query = "INSERT INTO `#__community_acl_users` " . "  SET `user_id` = '" . $k . "'" . "	  , `group_id` = '" . $cb_infos ['cacl_group_id'] [$i] . "'" . "	  , `role_id` = '" . $cb_infos ['cacl_role_id'] [$i] . "'" . "	  , `function_id` = '" . $cb_infos ['cacl_func_id'] [$i] . "'" . ", `cb_member_type` = '" . $cb_infos ['member_list_id'] [$i] . "' ";
				$this->_db->setQuery ( $query );
				$this->_db->query ();
			}

		endif;
		# - 2. Store in ACL_cb_groups
		if (isset ( $count )) :
			for($i = 0; $i < $count; $i ++) {
				$k = $i + 1;
				/* Query sets user front and admin login redirect to failed login redirect that is set on config page. Removed. BUR 9/29/2010 */
				//$query = "INSERT INTO `#__community_acl_cb_groups` " . "	  SET `id` = '" . $k . "'" . "	  , `name` = ''" . "	  , `description` = ''" . "	  , `enabled` = '1'" . "	  , `dosync` = ''" . "	  , `redirect_front` = '" . $cb_infos ['redirect_url'] . "'" . "	  , `redirect_admin` = '" . $cb_infos ['admin_redirect_url'] . "'";
				$query = "INSERT INTO `#__community_acl_cb_groups` " . "	  SET `id` = '" . $k . "'" . "	  , `name` = ''" . "	  , `description` = ''" . "	  , `enabled` = '1'" . "	  , `dosync` = ''";
				$this->_db->setQuery ( $query );
				$this->_db->query ();
			}

		endif;
		# - 3. Store in ACL_cb_roles
		if (isset ( $count )) :
			for($i = 0; $i < $count; $i ++) {
				$k = $i + 1;
				/* Query sets user front and admin login redirect to failed login redirect that is set on config page. Removed. BUR 9/29/2010 */
				//$query = "INSERT INTO `#__community_acl_cb_roles` " . "	  SET `id` = '" . $k . "'" . "	  , `group_id` = '" . $cb_infos ['cacl_group_id'] [$i] . "'" . "	  , `name` = ''" . "	  , `description` = ''" . "	  , `ordering` = ''" . "	  , `enabled` = '1'" . "	  , `dosync` = ''" . "	  , `redirect_front` = '" . $cb_infos ['redirect_url'] . "'" . "	  , `redirect_admin` = '" . $cb_infos ['admin_redirect_url'] . "'" . "    , `cb_member_type` = '" . $cb_infos ['member_list_id'] [$i] . "' ";
				$query = "INSERT INTO `#__community_acl_cb_roles` " . "	  SET `id` = '" . $k . "'" . "	  , `group_id` = '" . $cb_infos ['cacl_group_id'] [$i] . "'" . "	  , `name` = ''" . "	  , `description` = ''" . "	  , `ordering` = ''" . "	  , `enabled` = '1'" . "	  , `dosync` = ''" . ", `cb_member_type` = '" . $cb_infos ['member_list_id'] [$i] . "' ";
				$this->_db->setQuery ( $query );
				$this->_db->query ();
			}

		endif;
		# - 4. Store in ACL_cb_
		if (isset ( $count )) :
			for($i = 0; $i < $count; $i ++) {
				$k = $i + 1;
				$query = "INSERT INTO `#__community_acl_cb_functions` " . "	  SET `id` = '" . $k . "'" . "	  , `group_id` = '" . $cb_infos ['cacl_group_id'] [$i] . "'" . "	  , `name` = ''" . "	  , `description` = ''" . "	  , `j_group_id` =	'' " . "	  , `ordering` = ''" . "	  , `enabled` = '1'" . "	  , `dosync` = ''";
				$this->_db->setQuery ( $query );
				$this->_db->query ();
			}

		endif;
		# - 5. Clear the Membership Type table if table exists
		$query = "DELETE FROM `#__community_acl_membership_types`";
		$this->_db->setQuery ( $query );
		$this->_db->query ();
		if (isset ( $cb_infos ['member_desc'] ))
			$count = count ( $cb_infos ['member_desc'] );
		if (isset ( $count )) :
			for($i = 0; $i < $count; $i ++) {
				$k = $i + 1;
				$query = "INSERT INTO `#__community_acl_membership_types`" . "	  SET `id` = '" . $k . "'" . "	  , `name` = '" . $cb_infos ['member_desc'] [$i] . "'";
				$this->_db->setQuery ( $query );
				$this->_db->query ();
			}

		endif;
		# - 6. Insert into the Fields Management DB
		$query = "SELECT fieldid FROM `#__comprofiler_fields` WHERE `name` = 'cb_caclmembertype'";
		$this->_db->setQuery ( $query );
		$id = $this->_db->loadResult ();
		$query = "DELETE FROM `#__comprofiler_field_values` WHERE fieldid = '" . $id . "'";
		$this->_db->setQuery ( $query );
		$this->_db->query ();
		if (isset ( $count )) :
			$k = 0;
			for($i = 0; $i < $count; $i ++) {
				$k = $i + 1;
				$query = "INSERT INTO `#__comprofiler_field_values`" . "	  SET `fieldvalueid` = ''" . "	  , `fieldid` =	'" . $id . "'" . "	  , `fieldtitle` = '" . $cb_infos ['member_desc'] [$i] . "'" . "	  , `ordering` = 	'" . $k . "'" . "	  ,  `sys` = '0'";
				$this->_db->setQuery ( $query );
				$this->_db->query ();
			}

		endif;
		$select_list = NULL;
		$query = "SELECT COUNT(fieldid) FROM `#__comprofiler_field_values` WHERE fieldid =	'" . $id . "'";
		$this->_db->setQuery ( $query );
		$select_list = ( int ) $this->_db->loadResult ();
		if ($select_list == 0) {
			$query = "UPDATE `#__comprofiler_fields` SET published = '0' " . " WHERE `tablecolumns` = 'cb_caclmembertype' AND `table` = '#__comprofiler' ";
		} else {
			$query = "UPDATE `#__comprofiler_fields` SET published = '1' " . " WHERE `tablecolumns` = 'cb_caclmembertype' AND `table` = '#__comprofiler' ";
		}
		$this->_db->setQuery ( $query );
		$this->_db->query ();
		return true;
	}
}
class CACL_config extends JObject {
	var $_db = null;
	var $_error = null;
	var $public_group = null;
	var $public_role = null;
	var $public_function = null;
	var $registered_group = null;
	var $registered_role = null;
	var $registered_function = null;
	var $author_group = null;
	var $author_role = null;
	var $author_function = null;
	var $editor_group = null;
	var $editor_role = null;
	var $editor_function = null;
	var $publisher_group = null;
	var $publisher_role = null;
	var $publisher_function = null;
	var $manager_group = null;
	var $manager_role = null;
	var $manager_function = null;
	var $administrator_group = null;
	var $administrator_role = null;
	var $administrator_function = null;
	var $synchronize = null;
	var $users_and_cb = null;
	var $cb_contact = null;
	var $cacl_grf = null;
	var $default_action = 'deny';
	var $redirect_url = 'index.php';
	var $admin_redirect_url = 'index.php';
	var $forbidden_content = 1;
	var $useTidy = true;
	var $activate = 'site_administrator';
	function __construct(&$db) {
		//initialise
		$this->_db = & $db;
		$this->_error = '';
		$this->public_group = '0';
		$this->public_role = '0';
		$this->public_function = '0';
		$this->registered_group = '0';
		$this->registered_role = '0';
		$this->registered_function = '0';
		$this->author_group = '0';
		$this->author_role = '0';
		$this->author_function = '0';
		$this->editor_group = '0';
		$this->editor_role = '0';
		$this->editor_function = '0';
		$this->publisher_group = '0';
		$this->publisher_role = '0';
		$this->publisher_function = '0';
		$this->manager_group = '0';
		$this->manager_role = '0';
		$this->manager_function = '0';
		$this->administrator_group = '0';
		$this->administrator_role = '0';
		$this->administrator_function = '0';
		$this->synchronize = '0';
		$this->users_and_cb = '0';
		$this->cb_contact = '0';
		$this->cacl_grf = '0';
		$this->default_action = 'allow';
		$this->redirect_url = 'index.php';
		$this->admin_redirect_url = 'index.php';
		$this->forbidden_content = 1;
		$this->useTidy = true;
		$this->activate = 'site_administrator';
	}
	function get($name = null) {
		if ($name !== null && isset ( $this->$name ))
			return $this->$name;
		return null;
	}
	function load() {
		$query = "SELECT * FROM `#__community_acl_config`";
		if (is_object ( $this->_db )) {
			$this->_db->setQuery ( $query );
			$rows = $this->_db->LoadObjectList ();
			$tmp = array ();
			foreach ( $rows as $row ) {
				$tmp [$row->name] = $row->value;
			}
			$this->bind ( $tmp );
		}
	}
	function getPublicVars() {
		$public = array ();
		$vars = array_keys ( get_class_vars ( get_class ( $this ) ) );
		sort ( $vars );
		foreach ( $vars as $v ) {
			if ($v {0} != '_') {
				$public [] = $v;
			}
		}
		return $public;
	}
	function bind($array, $ignore = '') {
		if (! is_array ( $array )) {
			$this->_error = strtolower ( get_class ( $this ) ) . '::bind failed.';
			return false;
		} else {
			$prefix = NULL;
			$checkSlashes = true;
			if (! is_array ( $array ) || ! is_object ( $this )) {
				return (false);
			}
			foreach ( get_object_vars ( $this ) as $k => $v ) {
				if (substr ( $k, 0, 1 ) != '_') {
					// internal attributes of an object are ignored
					if (strpos ( $ignore, $k ) === false) {
						if ($prefix) {
							$ak = $prefix . $k;
						} else {
							$ak = $k;
						}
						if (isset ( $array [$ak] )) {
							$this->$k = ($checkSlashes && get_magic_quotes_gpc ()) ? caclStripslashes ( $array [$ak] ) : $array [$ak];
						}
					}
				}
			}
			return (true);
		}
	}
	function getError() {
		return $this->_error;
	}
	function store() {
		$query = "DELETE FROM `#__community_acl_config` WHERE name <> 'cacl_version' ";
		$this->_db->setQuery ( $query );
		$this->_db->query ();

		$vars = $this->getPublicVars ();
		$values = '';
		foreach ( $vars as $v ) {
			$values .= $i++ ? ',':'';
			$values .= '(\''.$v.'\',\''.$this->$v.'\')';
		}
		$query = 'INSERT INTO `#__community_acl_config` (name, value) VALUES '.$values;
		$this->_db->setQuery ( $query );
		$this->_db->query ();

		/*$query = "DELETE FROM `#__community_acl_config` WHERE name <> 'cacl_version' ";
		$this->_db->setQuery ( $query );
		$this->_db->query ();
		$vars = $this->getPublicVars ();

		foreach ( $vars as $v ) {
			$query = "INSERT INTO `#__community_acl_config` (name, value) " . "VALUES ('" . $v . "', '" . $this->$v . "')";
			$this->_db->setQuery ( $query );
			$this->_db->query ();
		}*/
		return true;
	}
}
class CACL_group extends JTable {
	var $id = null;
	var $name = null;
	var $description = null;
	var $enabled = null;
	var $dosync = null;
	function __construct(&$db) {
		parent::__construct ( '#__community_acl_groups', 'id', $db );
		//initialise
		$this->id = 0;
		$this->name = '';
		$this->description = '';
		$this->enabled = '1';
		$this->dosync = '1';
	}
	function check() {
		$db = & JFactory::getDBO ();
		// check for unique group name
		$query = 'SELECT name' . ' FROM #__community_acl_groups';
		if ($this->id) {
			$query .= ' WHERE id != ' . ( int ) $this->id;
		}
		$db->setQuery ( $query );
		$groups = $db->loadResultArray ();
		if (is_array ( $groups ) && count ( $groups )) {
			foreach ( $groups as $name ) {
				if ($name == $this->name) {
					$this->setError ( JText::_ ( 'Warning! Group with such name already exists' ) );
					return false;
				}
			}
		}
		return true;
	}
}
class CACL_role extends JTable {
	var $id = null;
	var $group_id = null;
	var $name = null;
	var $description = null;
	var $ordering = null;
	var $enabled = null;
	var $dosync = null;
	function __construct(&$db) {
		parent::__construct ( '#__community_acl_roles', 'id', $db );
		//initialise
		$this->id = 0;
		$this->group_id = 0;
		$this->name = '';
		$this->description = '';
		$this->ordering = 0;
		$this->enabled = '1';
		$this->dosync = '1';
	}
	function check() {
		$db = & JFactory::getDBO ();
		if ($this->group_id == 0)
			return true;
			// check for unique group name
		$query = 'SELECT name' . ' FROM `#__community_acl_roles`  WHERE `group_id` = \'' . ( int ) $this->group_id . '\' ';
		if ($this->id) {
			$query .= ' AND `id` != ' . ( int ) $this->id;
		}
		$db->setQuery ( $query );
		$roles = $db->loadResultArray ();
		if (is_array ( $roles ) && count ( $roles )) {
			foreach ( $roles as $name ) {
				if ($name == $this->name) {
					$this->setError ( JText::_ ( 'Warning! Role with such name already exists' ) );
					return false;
				}
			}
		}
		return true;
	}
}
class CACL_function extends JTable {
	var $id = null;
	var $group_id = null;
	var $name = null;
	var $description = null;
	var $ordering = null;
	var $enabled = null;
	var $dosync = null;
	function __construct(&$db) {
		parent::__construct ( '#__community_acl_functions', 'id', $db );
		//initialise
		$this->id = 0;
		$this->group_id = 0;
		$this->name = '';
		$this->description = '';
		$this->ordering = 0;
		$this->enabled = '1';
		$this->dosync = '1';
	}
	function check() {
		$db = & JFactory::getDBO ();
		// check for unique group name
		$query = 'SELECT name' . ' FROM #__community_acl_functions';
		if ($this->id) {
			$query .= ' WHERE id != ' . ( int ) $this->id;
		}
		$db->setQuery ( $query );
		$functions = $db->loadResultArray ();
		if (is_array ( $functions ) && count ( $functions )) {
			foreach ( $functions as $name ) {
				if ($name == $this->name) {
					$this->setError ( JText::_ ( 'Warning! Function with such name already exists' ) );
					return false;
				}
			}
		}
		return true;
	}
}
class CACL_site extends JTable {
	var $_site_db = null;
	var $_is_connected = false;
	var $id = null;
	var $name = null;
	var $db_host = null;
	var $db_name = null;
	var $db_user = null;
	var $db_password = null;
	var $db_prefix = null;
	var $description = null;
	var $enabled = null;
	var $is_main = null;
	function __construct(&$db) {
		parent::__construct ( '#__community_acl_sites', 'id', $db );
		//initialise
		$this->id = 0;
		$this->name = '';
		$this->db_host = '';
		$this->db_name = '';
		$this->db_user = '';
		$this->db_password = '';
		$this->db_prefix = '';
		$this->description = '';
		$this->enabled = '1';
		$this->is_main = '0';
		$this->_site_db = null;
		$this->_is_connected = false;
	}
	function check() {
		$db = & JFactory::getDBO ();
		// check for unique group name
		$query = 'SELECT name' . ' FROM #__community_acl_sites';
		if ($this->id) {
			$query .= ' WHERE id != ' . ( int ) $this->id;
		}
		$db->setQuery ( $query );
		$sites = $db->loadResultArray ();
		if (is_array ( $sites ) && count ( $sites )) {
			foreach ( $sites as $name ) {
				if ($name == $this->name) {
					$this->setError ( JText::_ ( 'Warning! Site with such name already exists' ) );
					return false;
				}
			}
		}
		return true;
	}
	function load($oid = null, $connect = true, $check_prefix = false) {
		$k = $this->_tbl_key;
		if ($oid !== null) {
			$this->$k = $oid;
		}
		$oid = $this->$k;
		if ($oid === null) {
			return false;
		}
		$this->reset ();
		$db = & $this->getDBO ();
		$query = 'SELECT *' . ' FROM ' . $this->_tbl . ' WHERE ' . $this->_tbl_key . ' = ' . $db->Quote ( $oid );
		$db->setQuery ( $query );
		if ($result = $db->loadAssoc ()) {
			if ($connect) {
				if (! $this->bind ( $result ))
					return false;
				$this->_site_db = & $this->getDBOS ();
				if ($this->_site_db === false) {
					$this->_site_db = null;
					$this->_is_connected = false;
					return false;
				}
				$this->_is_connected = true;
				if ($check_prefix) {
					$query = "SELECT COUNT(*) FROM `#__components` ";
					$this->_site_db->setQuery ( $query );
					if (intval ( $this->_site_db->loadResult () ) < 1) {
						$this->_is_connected = false;
						$this->setError ( 'Table prefix is INVALID ' );
						return false;
					}
				}
			}
			return $this->bind ( $result );
		} else { //print_r($result);die;
			$this->setError ( $db->getErrorMsg () );
			return false;
		}
	}
	function connect($check_prefix = false) {
		if ($this->_site_db === null) {
			$this->_site_db = & $this->getDBOS ();
			if ($this->_site_db === false) {
				$this->_is_connected = false;
				$this->_site_db = null;
				return false;
			}
			$this->_is_connected = true;
			if ($check_prefix) {
				$query = "SELECT COUNT(*) FROM `#__components` ";
				$this->_site_db->setQuery ( $query );
				if (intval ( $this->_site_db->loadResult () ) < 1) {
					$this->_is_connected = false;
					$this->setError ( 'Table prefix is INVALID' );
					return false;
				}
			}
		}
		return true;
	}
	function check_db() {
		return $this->_is_connected;
	}
	function &getDBOS() {
		static $instances;
		if (! isset ( $instances )) {
			$instances = array ();
		}
		$host = $this->db_host;
		$user = $this->db_user;
		$password = $this->db_password;
		$database = $this->db_name;
		$prefix = $this->db_prefix;
		$driver = 'mysql';
		$debug = 0;
		$options = array ('driver' => $driver, 'host' => $host, 'user' => $user, 'password' => $password, 'database' => $database, 'prefix' => $prefix );
		$signature = serialize ( $options );
		if (empty ( $instances [$signature] )) {
			$debug = 0;
			$instance = $this->_createDBO ();
			if ($instance === false)
				return false;
			$instance->debug ( $debug );
			$instances [$signature] = & $instance;
		}
		return $instances [$signature];
	}
	function &_createDBO() {
		jimport ( 'joomla.database.database' );
		jimport ( 'joomla.database.table' );
		$host = $this->db_host;
		$user = $this->db_user;
		$password = $this->db_password;
		$database = $this->db_name;
		$prefix = $this->db_prefix;
		$driver = 'mysql';
		$debug = 0;
		$options = array ('driver' => $driver, 'host' => $host, 'user' => $user, 'password' => $password, 'database' => $database, 'prefix' => $prefix );
		$db = & JDatabase::getInstance ( $options );
		if (JError::isError ( $db )) {
			$this->setError ( "Database Error: " . $db->toString () );
			return false;
		}
		if ($db->getErrorNum () > 0) {
			$this->setError ( 'JDatabase::getInstance: Could not connect to database <br/>' . 'joomla.library:' . $db->getErrorNum () . ' - ' . $db->getErrorMsg () );
			return false;
		}
		$db->debug ( $debug );
		return $db;
	}
}
class CACL_sync_table extends JTable {
	var $id = null;
	var $table = null;
	var $fields = null;
	var $enabled = null;
	function __construct(&$db) {
		parent::__construct ( '#__community_acl_sync_table', 'id', $db );
		//initialise
		$this->id = 0;
		$this->table = '';
		$this->fields = array ('key' => array (), 'unique' => array (), 'other' => array (), 'linked' => array () );
		$this->enabled = '1';
	}
	function check() {
		$db = & JFactory::getDBO ();
		// check for unique group name
		$query = 'SELECT table' . ' FROM #__community_sync_tables';
		if ($this->id) {
			$query .= ' WHERE id != ' . ( int ) $this->id;
		}
		$db->setQuery ( $query );
		$tables = $db->loadResultArray ();
		if (is_array ( $tables ) && count ( $tables )) {
			foreach ( $tables as $table ) {
				if ($table == $this->table) {
					$this->setError ( JText::_ ( 'Warning! Table with such name already exists' ) );
					return false;
				}
			}
		}
		return true;
	}
	function load($oid = null) {
		$k = $this->_tbl_key;
		if ($oid !== null) {
			$this->$k = $oid;
		}
		$oid = $this->$k;
		if ($oid === null) {
			return false;
		}
		$this->reset ();
		$db = & $this->getDBO ();
		$query = 'SELECT *' . ' FROM ' . $this->_tbl . ' WHERE ' . $this->_tbl_key . ' = ' . $db->Quote ( $oid );
		$db->setQuery ( $query );
		if ($result = $db->loadAssoc ()) {
			if ($this->bind ( $result )) {
				$this->fields = @unserialize ( $this->fields );
				return true;
			}
			return false;
		} else {
			$this->setError ( $db->getErrorMsg () );
			return false;
		}
	}
	function store($updateNulls = false) {
		$k = $this->_tbl_key;
		$this->fields = serialize ( $this->fields );
		if ($this->$k) {
			$ret = $this->_db->updateObject ( $this->_tbl, $this, $this->_tbl_key, $updateNulls );
		} else {
			$ret = $this->_db->insertObject ( $this->_tbl, $this, $this->_tbl_key );
		}
		if (! $ret) {
			$this->fields = @unserialize ( $this->fields );
			$this->setError ( get_class ( $this ) . '::store failed - ' . $this->_db->getErrorMsg () );
			return false;
		} else {
			$this->fields = @unserialize ( $this->fields );
			return true;
		}
	}
}
class CACL_user extends JTable {
	var $id = null;
	var $user_id = null;
	var $group_id = null;
	var $role_id = null;
	var $function_id = null;
	var $redirect_FRONT = null;
	var $redirect_ADMIN = null;
	function __construct(&$db) {
		parent::__construct ( '#__community_acl_users', 'id', $db );
		//initialise
		$this->id = 0;
		$this->user_id = '';
		$this->group_id = '';
		$this->role_id = '1';
		$this->function_id = '1';
		$this->redirect_FRONT = '';
		$this->redirect_ADMIN = '';
	}
	function check() {
		return true;
	}
}
class CACL_syncronize extends JObject {
	var $main_site = null;
	var $src_site = null;
	var $dst_site = null;
	var $sites = null;
	function __construct(&$main_site) {
		//initialise
		$this->main_site = $main_site;
		if (! is_object ( $this->main_site->_site_db ))
			return;
		$conf = & JFactory::getConfig ();
		$host = $conf->getValue ( 'config.host' );
		$user = $conf->getValue ( 'config.user' );
		$password = $conf->getValue ( 'config.password' );
		$database = $conf->getValue ( 'config.db' );
		$prefix = $conf->getValue ( 'config.dbprefix' );
		$query = "SELECT `id` FROM `#__community_acl_sites` WHERE `db_host`='{$host}' AND `db_name`='{$database}' AND `db_user`='{$user}' AND `db_password`='{$password}' AND `db_prefix`='{$prefix}' ";
		$this->main_site->_site_db->setQuery ( $query );
		$src_id = ( int ) $this->main_site->_site_db->loadResult ();
		$this->src_site = new CACL_site ( $this->main_site->_site_db );
		$this->src_site->load ( $src_id );
		$this->dst_site = new CACL_site ( $this->main_site->_site_db );
		$query = "SELECT `id` FROM `#__community_acl_sites` WHERE `id` <> '{$src_id}' AND `enabled` = '1' ";
		$this->main_site->_site_db->setQuery ( $query );
		$this->sites = $this->main_site->_site_db->loadObjectList ();
	}
	function syncronize($tid, $type = null) {
		if (! is_object ( $this->main_site->_site_db ))
			return;
		if ($type !== null) {
			foreach ( $this->sites as $site ) {
				$this->dst_site->load ( $site->id );
				switch ($type) {
					case 'user' :
						$this->sync_user ( $tid );
						break;
					case 'user_delete' :
						$this->sync_user_delete ( $tid );
						break;
					case 'cb_user' :
						$this->sync_cbuser ( $tid );
						break;
					case 'cb_user_delete' :
						$this->sync_cbuser_delete ( $tid );
						break;
					case 'cacl_group' :
						$this->sync_cacl_group ( $tid );
						break;
					case 'cacl_group_delete' :
						$this->sync_cacl_group_delete ( $tid );
						break;
					case 'cacl_role' :
						$this->sync_cacl_role ( $tid );
						break;
					case 'cacl_role_delete' :
						$this->sync_cacl_role_delete ( $tid );
						break;
					case 'cacl_func' :
						$this->sync_cacl_func ( $tid );
						break;
					case 'cacl_func_delete' :
						$this->sync_cacl_func_delete ( $tid );
						break;
					case 'access' :
						$this->sync_cacl_access ( $tid );
						break;
					case 'access_func' :
						$this->sync_cacl_access_func ( $tid );
						break;
					case 'cb_contact' :
						$this->sync_cacl_cb_contact ( $tid );
						break;
					case 'config' :
						$this->sync_cacl_config ( $tid );
						break;
				}
			}
		}
	}
	function sync_cacl_cb_contact($tid) {
		require (_COMMUNITY_ACL_ADMIN_HOME . '/tables.php');
		$table = new CACL_sync_table ( $this->src_site->_site_db );
		$t->table = "#__contact_details";
		$t->fields = $jos_contact_details;
		$query = "SELECT `id` FROM `#__contact_details` ";
		$this->src_site->_site_db->setQuery ( $query );
		$tids = $this->src_site->_site_db->loadObjectlist ();
		$query = 'DELETE FROM `#__contact_details`';
		$this->dst_site->_site_db->setQuery ( $query );
		$this->dst_site->_site_db->query ();
		foreach ( $tids as $tid ) {
			$this->sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid->id );
		}
	}
	function sync_cacl_config($tid) {
		require (_COMMUNITY_ACL_ADMIN_HOME . '/tables.php');
		$table = new CACL_sync_table ( $this->src_site->_site_db );
		$t->table = "#__community_acl_config";
		$t->fields = $jos_community_acl_config;
		$query = "SELECT `id`, `name`, `value` FROM `#__community_acl_config` ";
		$this->src_site->_site_db->setQuery ( $query );
		$tids = $this->src_site->_site_db->loadObjectlist ();
		$query = "DELETE FROM `#__community_acl_config` WHERE `name` NOT IN ('synchronize', 'users_and_cb', 'cb_contact', 'cacl_grf')";
		$this->dst_site->_site_db->setQuery ( $query );
		$this->dst_site->_site_db->query ();
		foreach ( $tids as $tid ) {
			if ($tid->name == 'synchronize' || $tid->name == 'users_and_cb' || $tid->name == 'cb_contact' || $tid->name == 'cacl_grf')
				continue;
			if ($tid->value > 0 && strpos ( $tid->name, 'function' ) !== false) {
				$t->fields ['other'] = array ();
				$t->fields ['linked'] ['value'] = array ('table' => '#__community_acl_functions', 'key' => 'id', 'unique' => array ('name' ) );
			} elseif ($tid->value > 0 && strpos ( $tid->name, 'role' ) !== false) {
				$t->fields ['other'] = array ();
				$t->fields ['linked'] ['value'] = array ('table' => '#__community_acl_roles', 'key' => 'id', 'unique' => array ('name' ) );
			} elseif ($tid->value > 0 && strpos ( $tid->name, 'group' ) !== false) {
				$t->fields ['other'] = array ();
				$t->fields ['linked'] ['value'] = array ('table' => '#__community_acl_groups', 'key' => 'id', 'unique' => array ('name' ) );
			} else {
				$t->fields ['other'] = array ('value' );
				$t->fields ['linked'] = array ();
			}
			$this->sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid->id );
		}
	}
	function sync_cacl_access_func($tid) {
		require (_COMMUNITY_ACL_ADMIN_HOME . '/tables.php');
		$table = new CACL_sync_table ( $this->src_site->_site_db );
		$query = "SELECT `dosync` FROM `#__community_acl_functions` WHERE `id` = '" . $tid . "' ";
		$this->src_site->_site_db->setQuery ( $query );
		if (( int ) $this->src_site->_site_db->loadResult () < 1)
			return;
		$t->table = "#__community_acl_functions";
		$t->fields = $jos_community_acl_functions;
		$func_id_d = $this->get_id ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid );
		$t->table = "#__community_acl_function_access";
		$t->fields = $jos_community_acl_function_access;
		$query = "SELECT `id` FROM `#__community_acl_function_access` WHERE `func_id` = '" . $tid . "' ";
		$this->src_site->_site_db->setQuery ( $query );
		$tids = $this->src_site->_site_db->loadObjectlist ();
		$query = 'DELETE FROM `#__community_acl_function_access`' . ' WHERE `func_id` = \'' . $func_id_d . '\'';
		$this->dst_site->_site_db->setQuery ( $query );
		$this->dst_site->_site_db->query ();
		foreach ( $tids as $td ) {
			$this->sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $td->id );
		}
		$t->table = "#__community_acl_content_actions";
		$t->fields = $jos_community_acl_content_actions;
		$query = "SELECT `id`, `item_type` FROM `#__community_acl_content_actions` WHERE `func_id` = '" . $tid . "' ";
		$this->src_site->_site_db->setQuery ( $query );
		$tids = $this->src_site->_site_db->loadObjectlist ();
		$query = 'DELETE FROM `#__community_acl_content_actions`' . ' WHERE `func_id` = \'' . $func_id_d . '\'';
		$this->dst_site->_site_db->setQuery ( $query );
		$this->dst_site->_site_db->query ();
		foreach ( $tids as $tid ) {
			if ($tid->item_type == 'content') {
				$t->fields ['linked'] ['item_id'] = array ('table' => '#__content', 'key' => 'id', 'unique' => array ('title' ) );
			} elseif ($tid->item_type == 'category') {
				$t->fields ['linked'] ['item_id'] = array ('table' => '#__categories', 'key' => 'id', 'unique' => array ('title' ) );
			} elseif ($tid->item_type == 'section') {
				$t->fields ['linked'] ['item_id'] = array ('table' => '#__sections', 'key' => 'id', 'unique' => array ('title' ) );
			} else
				continue;
			$this->sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid->id );
		}
	}
	function sync_cacl_access($tid) {
		require (_COMMUNITY_ACL_ADMIN_HOME . '/tables.php');
		$table = new CACL_sync_table ( $this->src_site->_site_db );
		if ($tid ['group_id'] > 0) {
			$query = "SELECT `dosync` FROM `#__community_acl_groups` WHERE `id` = '" . $tid ['group_id'] . "' ";
			$this->src_site->_site_db->setQuery ( $query );
			if (( int ) $this->src_site->_site_db->loadResult () < 1)
				return;
		}
		if ($tid ['role_id'] > 0) {
			$query = "SELECT `dosync` FROM `#__community_acl_roles` WHERE `id` = '" . $tid ['role_id'] . "' ";
			$this->src_site->_site_db->setQuery ( $query );
			if (( int ) $this->src_site->_site_db->loadResult () < 1)
				return;
		}
		$t->table = "#__community_acl_groups";
		$t->fields = $jos_community_acl_groups;
		$group_id_d = $this->get_id ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid ['group_id'] );
		$t->table = "#__community_acl_roles";
		$t->fields = $jos_community_acl_roles;
		$role_id_d = $this->get_id ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid ['role_id'] );
		$t->table = "#__community_acl_access";
		$t->fields = $jos_community_acl_access;
		$query = "SELECT `id`, `option`, `name` FROM `#__community_acl_access` WHERE `group_id` = '" . $tid ['group_id'] . "' AND `role_id` = '" . $tid ['role_id'] . "' ";
		$this->src_site->_site_db->setQuery ( $query );
		$tids = $this->src_site->_site_db->loadObjectlist ();
		$query = 'DELETE FROM `#__community_acl_access`' . ' WHERE `group_id` = \'' . $group_id_d . '\' AND `role_id` = \'' . $role_id_d . '\'';
		$this->dst_site->_site_db->setQuery ( $query );
		$this->dst_site->_site_db->query ();
		foreach ( $tids as $tid ) {
			if ($tid->option == 'com_content' && $tid->name == 'cid') {
				$t->fields ['linked'] ['value'] = array ('table' => '#__content', 'key' => 'id', 'unique' => array ('title' ) );
			} elseif ($tid->option == 'com_categories' && $tid->name == 'cid') {
				$t->fields ['linked'] ['value'] = array ('table' => '#__categories', 'key' => 'id', 'unique' => array ('title' ) );
			} elseif ($tid->option == 'com_sections' && $tid->name == 'cid') {
				$t->fields ['linked'] ['value'] = array ('table' => '#__sections', 'key' => 'id', 'unique' => array ('title' ) );
			} elseif ($tid->name == '###' && $tid->option == 'menu') {
				$t->fields ['linked'] ['value'] = array ('table' => '#__menu', 'key' => 'id', 'unique' => array ('menutype', 'name', 'type' ) );
			} elseif ($tid->name == '###') {
				$t->fields ['linked'] ['value'] = array ('table' => '#__components', 'key' => 'id', 'unique' => array ('option', 'parent' ) );
			} elseif ($tid->name == '@@@') {
				$t->fields ['linked'] ['value'] = array ('table' => '#__modules', 'key' => 'id', 'unique' => array ('module' ) );
			}
			$this->sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid->id );
		}
	}
	function sync_cacl_func_delete($tid) {
		require (_COMMUNITY_ACL_ADMIN_HOME . '/tables.php');
		$table = new CACL_sync_table ( $this->src_site->_site_db );
		$query = "SELECT `dosync` FROM `#__community_acl_functions` WHERE `id` = '" . $tid . "' ";
		$this->src_site->_site_db->setQuery ( $query );
		if (( int ) $this->src_site->_site_db->loadResult () < 1)
			return;
		$t->table = "#__community_acl_functions";
		$t->fields = $jos_community_acl_functions;
		$func_id = ( int ) $this->delete_sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid );
		$query = 'DELETE FROM `#__community_acl_function_access`' . ' WHERE `func_id` = \'' . $func_id . '\' ';
		$this->dst_site->_site_db->setQuery ( $query );
		$this->dst_site->_site_db->query ();
		$query = 'DELETE FROM `#__community_acl_users`' . ' WHERE `function_id` = \'' . $func_id . '\' ';
		$this->dst_site->_site_db->setQuery ( $query );
		$this->dst_site->_site_db->query ();
	}
	function sync_cacl_func($tid) {
		require (_COMMUNITY_ACL_ADMIN_HOME . '/tables.php');
		$table = new CACL_sync_table ( $this->src_site->_site_db );
		$t->table = "#__community_acl_functions";
		$t->fields = $jos_community_acl_functions;
		$query = "SELECT `dosync` FROM `#__community_acl_functions` WHERE `id` = '" . $tid . "' ";
		$this->src_site->_site_db->setQuery ( $query );
		if (( int ) $this->src_site->_site_db->loadResult () < 1) {
			$id_d = $this->get_id ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid );
			$query = 'UPDATE `#__community_acl_functions` SET `dosync` = 0 ' . ' WHERE `id` = \'' . $id_d . '\' ';
			$this->dst_site->_site_db->setQuery ( $query );
			$this->dst_site->_site_db->query ();
			return;
		}
		$id = ( int ) $this->sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid, true );
	}
	function sync_cacl_role_delete($tid) {
		require (_COMMUNITY_ACL_ADMIN_HOME . '/tables.php');
		$table = new CACL_sync_table ( $this->src_site->_site_db );
		$query = "SELECT `dosync` FROM `#__community_acl_roles` WHERE `id` = '" . $tid . "' ";
		$this->src_site->_site_db->setQuery ( $query );
		if (( int ) $this->src_site->_site_db->loadResult () < 1)
			return;
		$t->table = "#__community_acl_roles";
		$t->fields = $jos_community_acl_roles;
		$role_id = ( int ) $this->delete_sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid );
		$query = 'DELETE FROM `#__community_acl_access`' . ' WHERE `role_id` = \'' . $role_id . '\' ';
		$this->dst_site->_site_db->setQuery ( $query );
		$this->dst_site->_site_db->query ();
		$query = 'DELETE FROM `#__community_acl_users`' . ' WHERE `role_id` = \'' . $role_id . '\' ';
		$this->dst_site->_site_db->setQuery ( $query );
		$this->dst_site->_site_db->query ();
	}
	function sync_cacl_role($tid) {
		require (_COMMUNITY_ACL_ADMIN_HOME . '/tables.php');
		$table = new CACL_sync_table ( $this->src_site->_site_db );
		$t->table = "#__community_acl_roles";
		$t->fields = $jos_community_acl_roles;
		$query = "SELECT `dosync` FROM `#__community_acl_roles` WHERE `id` = '" . $tid . "' ";
		$this->src_site->_site_db->setQuery ( $query );
		if (( int ) $this->src_site->_site_db->loadResult () < 1) {
			$id_d = $this->get_id ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid );
			$query = 'UPDATE `#__community_acl_roles` SET `dosync` = 0 ' . ' WHERE `id` = \'' . $id_d . '\' ';
			$this->dst_site->_site_db->setQuery ( $query );
			$this->dst_site->_site_db->query ();
			return;
		}
		$id = ( int ) $this->sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid, true );
	}
	function sync_cacl_group_delete($tid) {
		require (_COMMUNITY_ACL_ADMIN_HOME . '/tables.php');
		$table = new CACL_sync_table ( $this->src_site->_site_db );
		$query = "SELECT `dosync` FROM `#__community_acl_groups` WHERE `id` = '" . $tid . "' ";
		$this->src_site->_site_db->setQuery ( $query );
		if (( int ) $this->src_site->_site_db->loadResult () < 1)
			return;
		$t->table = "#__community_acl_groups";
		$t->fields = $jos_community_acl_groups;
		$group_id = ( int ) $this->delete_sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid );
		$query = 'SELECT `id` FROM `#__community_acl_roles`' . ' WHERE `group_id` = \'' . $group_id . '\' ';
		$this->dst_site->_site_db->setQuery ( $query );
		$rid = $this->dst_site->_site_db->loadResultArray ();
		$query = 'DELETE FROM `#__community_acl_roles`' . ' WHERE `group_id` = \'' . $group_id . '\' ';
		$this->dst_site->_site_db->setQuery ( $query );
		$this->dst_site->_site_db->query ();
		$query = 'DELETE FROM `#__community_acl_access`' . ' WHERE `group_id` = \'' . $group_id . '\' ' . (count ( $rid ) > 0 ? ' OR `role_id` IN ( ' . implode ( ',', $rid ) . ' )' : '');
		$this->dst_site->_site_db->setQuery ( $query );
		$this->dst_site->_site_db->query ();
		$query = 'DELETE FROM `#__community_acl_users`' . ' WHERE `group_id` = \'' . $group_id . '\' ' . (count ( $rid ) > 0 ? ' OR `role_id` IN ( ' . implode ( ',', $rid ) . ' )' : '');
		$this->dst_site->_site_db->setQuery ( $query );
		$this->dst_site->_site_db->query ();
	}
	function sync_cacl_group($tid) {
		require (_COMMUNITY_ACL_ADMIN_HOME . '/tables.php');
		$table = new CACL_sync_table ( $this->src_site->_site_db );
		$t->table = "#__community_acl_groups";
		$t->fields = $jos_community_acl_groups;
		$query = "SELECT `dosync` FROM `#__community_acl_groups` WHERE `id` = '" . $tid . "' ";
		$this->src_site->_site_db->setQuery ( $query );
		if (( int ) $this->src_site->_site_db->loadResult () < 1) {
			$id_d = $this->get_id ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid );
			$query = 'UPDATE `#__community_acl_groups` SET `dosync` = 0 ' . ' WHERE `id` = \'' . $id_d . '\' ';
			$this->dst_site->_site_db->setQuery ( $query );
			$this->dst_site->_site_db->query ();
			return;
		}
		$id = ( int ) $this->sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid, true );
	}
	function sync_cbuser($tid) {
		require (_COMMUNITY_ACL_ADMIN_HOME . '/tables.php');
		$table = new CACL_sync_table ( $this->src_site->_site_db );
		$t->table = "#__comprofiler";
		$t->fields = $jos_comprofiler;
		$user_id = ( int ) $this->sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid, true );
	}
	function sync_cbuser_delete($tid) {
		require (_COMMUNITY_ACL_ADMIN_HOME . '/tables.php');
		$table = new CACL_sync_table ( $this->src_site->_site_db );
		$t->table = "#__comprofiler";
		$t->fields = $jos_comprofiler;
		$user_id = ( int ) $this->delete_sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid );
	}
	function sync_user($tid) {
		require (_COMMUNITY_ACL_ADMIN_HOME . '/tables.php');
		$table = new CACL_sync_table ( $this->src_site->_site_db );
		$t->table = "#__users";
		$t->fields = $jos_users;
		$user_id = ( int ) $this->sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid );
		//if ($user_id <1) {die('1');}
		//echo $user_id;die;
		$query = "SELECT `gid` FROM `#__users` WHERE `id` = '" . $tid . "'";
		$this->src_site->_site_db->setQuery ( $query );
		$gid = ( int ) $this->src_site->_site_db->loadResult ();
		//if ($gid <1) {die('2');}
		$query = "SELECT `id` FROM `#__core_acl_aro` WHERE `value` = '" . $tid . "'";
		$this->src_site->_site_db->setQuery ( $query );
		$aro_id_s = ( int ) $this->src_site->_site_db->loadResult ();
		//if ($aro_id_s <1) {die('3');}
		$t->table = "#__core_acl_aro";
		$t->fields = $jos_core_acl_aro;
		$aro_id = ( int ) $this->sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $aro_id_s );
		//if ($aro_id <1) {die('4');}
		//echo $aro_id.'*';
		$query = "INSERT INTO `#__core_acl_groups_aro_map` VALUES('" . $gid . "', '', '" . $aro_id . "')";
		$this->dst_site->_site_db->setQuery ( $query );
		$this->dst_site->_site_db->query ();
		//if ($this->dst_site->_site_db->getErrorNum()) {echo $this->dst_site->_site_db->stderr();die('5');}
		//echo $this->dst_site->_site_db->getQuery();
		$query = "DELETE FROM `#__community_acl_users` WHERE `user_id` = '" . $user_id . "'";
		$this->dst_site->_site_db->setQuery ( $query );
		$this->dst_site->_site_db->query ();
		//if ($this->dst_site->_site_db->getErrorNum()) {echo $this->dst_site->_site_db->stderr();die('6');}
		//echo $this->dst_site->_site_db->getQuery();
		$query = "SELECT `id` FROM #__community_acl_user_params WHERE `user_id` = '" . $tid . "' ";
		$this->src_site->_site_db->setQuery ( $query );
		$cacl_usr_params = $this->src_site->_site_db->loadObjectlist ();
		$t->table = "#__community_acl_user_params";
		$t->fields = $jos_community_acl_user_params;
		foreach ( $cacl_usr_params as $cacl_usr_param ) {
			$this->sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $cacl_usr_param->id );
		}
		$query = "SELECT `id` FROM #__community_acl_users WHERE `user_id` = '" . $tid . "' ";
		$this->src_site->_site_db->setQuery ( $query );
		$cacl_usrs = $this->src_site->_site_db->loadObjectlist ();
		$t->table = "#__community_acl_users";
		$t->fields = $jos_community_acl_users;
		foreach ( $cacl_usrs as $cacl_usr ) {
			$this->sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $cacl_usr->id );
		}
	}
	function sync_user_delete($tid) {
		require (_COMMUNITY_ACL_ADMIN_HOME . '/tables.php');
		$table = new CACL_sync_table ( $this->src_site->_site_db );
		$t->table = "#__users";
		$t->fields = $jos_users;
		$user_id = ( int ) $this->delete_sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $tid );
		$query = "SELECT `gid` FROM `#__users` WHERE `id` = '" . $tid . "'";
		$this->src_site->_site_db->setQuery ( $query );
		$gid = ( int ) $this->src_site->_site_db->loadResult ();
		$query = "SELECT `id` FROM `#__core_acl_aro` WHERE `value` = '" . $tid . "'";
		$this->src_site->_site_db->setQuery ( $query );
		$aro_id_s = ( int ) $this->src_site->_site_db->loadResult ();
		$t->table = "#__core_acl_aro";
		$t->fields = $jos_core_acl_aro;
		$aro_id = ( int ) $this->delete_sync_row ( $t, $this->main_site, $this->src_site, $this->dst_site, $aro_id_s );
		$query = "DELETE FROM `#__core_acl_groups_aro_map` WHERE `group_id` = '" . $gid . "' AND  `aro_id` = '" . $aro_id . "' ";
		$this->dst_site->_site_db->setQuery ( $query );
		$this->dst_site->_site_db->query ();
		$query = "DELETE FROM `#__community_acl_users` WHERE `user_id` = '" . $user_id . "'";
		$this->dst_site->_site_db->setQuery ( $query );
		$this->dst_site->_site_db->query ();
		$query = "DELETE FROM `#__community_acl_user_params` WHERE `user_id` = '" . $user_id . "'";
		$this->dst_site->_site_db->setQuery ( $query );
		$this->dst_site->_site_db->query ();
	}
	function sync_row(&$sync_tbl, &$main_site, &$src_site, &$dst_site, $src_id, $no_key = false, $const = array()) {
		$dst_id = 0;
		// try get id from sync table
		$query = "SELECT dst_field_id FROM `#__community_acl_sync` " . " WHERE `src_site_id` = '" . $src_site->id . "'" . "	AND `dst_site_id` = '" . $dst_site->id . "'" . "	AND `tablename` = '" . $sync_tbl->table . "'" . "	AND `fieldname` = '" . $sync_tbl->fields ['key'] [0] . "'" . "	AND `src_field_id` = '" . $src_id . "'";
		$main_site->_site_db->setQuery ( $query );
		$dst_id = ( int ) $main_site->_site_db->loadResult ();
		if ($main_site->_site_db->getErrorNum ()) {
			return $main_site->_site_db->stderr ();
		}
		$from_unique = false;
		// try get id from unique fields
		if (! $dst_id && count ( $sync_tbl->fields ['unique'] ) > 0) {
			$from_unique = true;
			$query = "SELECT `" . implode ( '`, `', $sync_tbl->fields ['unique'] ) . "` FROM `" . $sync_tbl->table . "` " . " WHERE  `" . $sync_tbl->fields ['key'] [0] . "` = " . $src_id;
			$src_site->_site_db->setQuery ( $query );
			$unique = $src_site->_site_db->loadAssoc ();
			if ($src_site->_site_db->getErrorNum ()) {
				return $src_site->_site_db->stderr ();
			}
			if (count ( $unique ) > 0) {
				$query = "SELECT `" . $sync_tbl->fields ['key'] [0] . "` FROM `" . $sync_tbl->table . "` WHERE ";
				foreach ( $unique as $k => $v ) {
					$query .= " `{$k}` = '{$v}' AND ";
				}
				$query .= ' 1=1 ';
				$dst_site->_site_db->setQuery ( $query );
				$dst_id = ( int ) $dst_site->_site_db->loadResult ();
				if ($dst_site->_site_db->getErrorNum ()) {
					return $dst_site->_site_db->stderr ();
				}
			}
		}
		//check is record exists
		if ($dst_id) {
			$query = "SELECT `" . $sync_tbl->fields ['key'] [0] . "` FROM `" . $sync_tbl->table . "` WHERE `" . $sync_tbl->fields ['key'] [0] . "` = '" . $dst_id . "'";
			$dst_site->_site_db->setQuery ( $query );
			$dst_id = ( int ) $dst_site->_site_db->loadResult ();
			if ($dst_site->_site_db->getErrorNum ()) {
				return $dst_site->_site_db->stderr ();
			}
		}
		$linked = array ();
		if (count ( $sync_tbl->fields ['linked'] ) > 0) {
			foreach ( $sync_tbl->fields ['linked'] as $name => $v ) {
				$linked [] = $name;
			}
		}
		$fields = @array_merge ( $sync_tbl->fields ['key'], $sync_tbl->fields ['unique'], $sync_tbl->fields ['other'], $linked );
		$fields = '`' . implode ( '`, `', $fields ) . '`';
		$query = "SELECT {$fields} FROM `" . $sync_tbl->table . "` " . " WHERE `" . $sync_tbl->fields ['key'] [0] . "` = " . $src_id;
		$src_site->_site_db->setQuery ( $query );
		$row = $src_site->_site_db->loadObjectlist ();
		if ($src_site->_site_db->getErrorNum ()) {
			return $src_site->_site_db->stderr ();
		}
		$row = isset ( $row [0] ) ? $row [0] : null;
		if (is_object ( $row )) {
			$key_name = (isset ( $sync_tbl->fields ['key'] [0] ) ? $sync_tbl->fields ['key'] [0] : null);
			$no_items = false;
			//prepare row to sync
			if (count ( $sync_tbl->fields ['linked'] ) > 0) {
				$dst_id_link = 0;
				foreach ( $sync_tbl->fields ['linked'] as $name => $details ) {
					$query = "SELECT dst_field_id FROM `#__community_acl_sync` " . " WHERE `src_site_id` = '" . $src_site->id . "'" . "	AND `dst_site_id` = '" . $dst_site->id . "'" . "	AND `tablename` = '" . $details ['table'] . "'" . "	AND `fieldname` = '" . $details ['key'] . "'" . "	AND `src_field_id` = '" . $row->$name . "'";
					$main_site->_site_db->setQuery ( $query );
					$dst_id_link = ( int ) $main_site->_site_db->loadResult ();
					if ($dst_id_link) {
						$query = "SELECT COUNT(*) FROM `" . $details ['table'] . "` " . " WHERE  `" . $details ['key'] . "` = " . $row->$name;
						$dst_site->_site_db->setQuery ( $query );
						if (( int ) $dst_site->_site_db->loadResult () == 0)
							$dst_id_link = 0;
					}
					if ($main_site->_site_db->getErrorNum ()) {
						return $main_site->_site_db->stderr ();
					}
					if (! $dst_id_link && count ( $details ['unique'] ) > 0) {
						$from_unique = true;
						$query = "SELECT `" . implode ( '`, `', $details ['unique'] ) . "` FROM `" . $details ['table'] . "` " . " WHERE  `" . $details ['key'] . "` = " . $row->$name;
						$src_site->_site_db->setQuery ( $query );
						$unique = $src_site->_site_db->loadAssoc ();
						if ($src_site->_site_db->getErrorNum ()) {
							return $src_site->_site_db->stderr ();
						}
						if (count ( $unique ) > 0) {
							$query = "SELECT `" . $details ['key'] . "` FROM `" . $details ['table'] . "` WHERE ";
							foreach ( $unique as $k => $v ) {
								$query .= " `{$k}` = '" . $dst_site->_site_db->getEscaped ( $v ) . "' AND ";
							}
							$query .= ' 1=1 ';
							$dst_site->_site_db->setQuery ( $query );
							$dst_id_link = ( int ) $dst_site->_site_db->loadResult ();
							if ($dst_site->_site_db->getErrorNum ()) {
								return $dst_site->_site_db->stderr ();
							}
						}
					}
					if ($row->$name > 0 && $dst_id_link == 0) {
						$no_items = true;
					}
					$row->$name = $dst_id_link;
				}
			}
			if ($dst_id) {
				$row->$key_name = $dst_id;
				$dst_site->_site_db->updateObject ( $sync_tbl->table, $row, $key_name );
				if ($dst_site->_site_db->getErrorNum ()) {
					return $dst_site->_site_db->stderr ();
				}
				if ($from_unique) {
					$query = "DELETE FROM `#__community_acl_sync` WHERE `src_site_id` = '" . $src_site->id . "' AND `dst_site_id` = '" . $dst_site->id . "' AND `tablename` = '" . $sync_tbl->table . "' AND `fieldname` = '" . $sync_tbl->fields ['key'] [0] . "' AND `src_field_id` = '" . $src_id . "'";
					$main_site->_site_db->setQuery ( $query );
					$main_site->_site_db->query ();
					if ($main_site->_site_db->getErrorNum ()) {
						return $main_site->_site_db->stderr ();
					}
					$query = "INSERT INTO `#__community_acl_sync` " . " SET `src_site_id` = '" . $src_site->id . "'" . "	, `dst_site_id` = '" . $dst_site->id . "'" . "	, `tablename` = '" . $sync_tbl->table . "'" . "	, `fieldname` = '" . $sync_tbl->fields ['key'] [0] . "'" . "	, `src_field_id` = '" . $src_id . "'" . "	, `dst_field_id` = '" . $dst_id . "'";
					$main_site->_site_db->setQuery ( $query );
					$main_site->_site_db->query ();
					if ($main_site->_site_db->getErrorNum ()) {
						return $main_site->_site_db->stderr ();
					}
				}
			} elseif (! $no_items) {
				if (! $no_key)
					$row->$key_name = '';
				if (count ( $const ) > 0)
					$row->$const ['key'] = $const ['value'];
				$dst_site->_site_db->insertObject ( $sync_tbl->table, $row, $key_name );
				if ($dst_site->_site_db->getErrorNum ()) {
					return $dst_site->_site_db->stderr ();
				}
				$dst_id = $row->$key_name;
				$query = "DELETE FROM `#__community_acl_sync` WHERE `src_site_id` = '" . $src_site->id . "' AND `dst_site_id` = '" . $dst_site->id . "' AND `tablename` = '" . $sync_tbl->table . "' AND `fieldname` = '" . $sync_tbl->fields ['key'] [0] . "' AND `src_field_id` = '" . $src_id . "'";
				$main_site->_site_db->setQuery ( $query );
				$main_site->_site_db->query ();
				if ($main_site->_site_db->getErrorNum ()) {
					return $main_site->_site_db->stderr ();
				}
				$query = "INSERT INTO `#__community_acl_sync` " . " SET `src_site_id` = '" . $src_site->id . "'" . "	, `dst_site_id` = '" . $dst_site->id . "'" . "	, `tablename` = '" . $sync_tbl->table . "'" . "	, `fieldname` = '" . $sync_tbl->fields ['key'] [0] . "'" . "	, `src_field_id` = '" . $src_id . "'" . "	, `dst_field_id` = '" . $dst_id . "'";
				$main_site->_site_db->setQuery ( $query );
				$main_site->_site_db->query ();
				if ($main_site->_site_db->getErrorNum ()) {
					return $main_site->_site_db->stderr ();
				}
			}
		} else
			return 'Error: Failed to load source record';
		return $row->$key_name;
	}
	function delete_sync_row(&$sync_tbl, &$main_site, &$src_site, &$dst_site, $src_id) {
		$dst_id = 0;
		// try get id from sync table
		$query = "SELECT dst_field_id FROM `#__community_acl_sync` " . " WHERE `src_site_id` = '" . $src_site->id . "'" . "	AND `dst_site_id` = '" . $dst_site->id . "'" . "	AND `tablename` = '" . $sync_tbl->table . "'" . "	AND `fieldname` = '" . $sync_tbl->fields ['key'] [0] . "'" . "	AND `src_field_id` = '" . $src_id . "'";
		$main_site->_site_db->setQuery ( $query );
		$dst_id = ( int ) $main_site->_site_db->loadResult ();
		if ($main_site->_site_db->getErrorNum ()) {
			return $main_site->_site_db->stderr ();
		}
		// try get id from unique fields
		if (! $dst_id && count ( $sync_tbl->fields ['unique'] ) > 0) {
			$query = "SELECT `" . implode ( '`, `', $sync_tbl->fields ['unique'] ) . "` FROM `" . $sync_tbl->table . "` " . " WHERE  `" . $sync_tbl->fields ['key'] [0] . "` = " . $src_id;
			$src_site->_site_db->setQuery ( $query );
			$unique = $src_site->_site_db->loadAssoc ();
			if ($src_site->_site_db->getErrorNum ()) {
				return $src_site->_site_db->stderr ();
			}
			if (count ( $unique ) > 0) {
				$query = "SELECT `" . $sync_tbl->fields ['key'] [0] . "` FROM `" . $sync_tbl->table . "` WHERE ";
				foreach ( $unique as $k => $v ) {
					$query .= " `{$k}` = '{$v}' AND ";
				}
				$query .= ' 1=1 ';
				$dst_site->_site_db->setQuery ( $query );
				$dst_id = ( int ) $dst_site->_site_db->loadResult ();
				if ($dst_site->_site_db->getErrorNum ()) {
					return $dst_site->_site_db->stderr ();
				}
			}
		}
		//check is record exists
		if ($dst_id) {
			$query = "SELECT `" . $sync_tbl->fields ['key'] [0] . "` FROM `" . $sync_tbl->table . "` WHERE `" . $sync_tbl->fields ['key'] [0] . "` = '" . $dst_id . "'";
			$dst_site->_site_db->setQuery ( $query );
			$dst_id = ( int ) $dst_site->_site_db->loadResult ();
		}
		$key_name = $sync_tbl->fields ['key'] [0];
		if ($dst_id) {
			$query = "DELETE FROM `" . $sync_tbl->table . "` WHERE `" . $key_name . "` = '" . $dst_id . "'";
			$dst_site->_site_db->setQuery ( $query );
			$dst_site->_site_db->query ();
			if ($dst_site->_site_db->getErrorNum ()) {
				return $dst_site->_site_db->stderr ();
			}
			$query = "DELETE FROM `#__community_acl_sync` WHERE `src_site_id` = '" . $src_site->id . "' AND `dst_site_id` = '" . $dst_site->id . "' AND `tablename` = '" . $sync_tbl->table . "' AND `fieldname` = '" . $sync_tbl->fields ['key'] [0] . "' AND `src_field_id` = '" . $src_id . "'";
			$main_site->_site_db->setQuery ( $query );
			$main_site->_site_db->query ();
			if ($main_site->_site_db->getErrorNum ()) {
				return $main_site->_site_db->stderr ();
			}
		}
		return $dst_id;
	}
	function get_id(&$sync_tbl, &$main_site, &$src_site, &$dst_site, $src_id) {
		$dst_id = 0;
		// try get id from sync table
		$query = "SELECT dst_field_id FROM `#__community_acl_sync` " . " WHERE `src_site_id` = '" . $src_site->id . "'" . "	AND `dst_site_id` = '" . $dst_site->id . "'" . "	AND `tablename` = '" . $sync_tbl->table . "'" . "	AND `fieldname` = '" . $sync_tbl->fields ['key'] [0] . "'" . "	AND `src_field_id` = '" . $src_id . "'";
		$main_site->_site_db->setQuery ( $query );
		$dst_id = ( int ) $main_site->_site_db->loadResult ();
		if ($main_site->_site_db->getErrorNum ()) {
			return $main_site->_site_db->stderr ();
		}
		// try get id from unique fields
		if (! $dst_id && count ( $sync_tbl->fields ['unique'] ) > 0) {
			$query = "SELECT `" . implode ( '`, `', $sync_tbl->fields ['unique'] ) . "` FROM `" . $sync_tbl->table . "` " . " WHERE  `" . $sync_tbl->fields ['key'] [0] . "` = " . $src_id;
			$src_site->_site_db->setQuery ( $query );
			$unique = $src_site->_site_db->loadAssoc ();
			if ($src_site->_site_db->getErrorNum ()) {
				return $src_site->_site_db->stderr ();
			}
			if (count ( $unique ) > 0) {
				$query = "SELECT `" . $sync_tbl->fields ['key'] [0] . "` FROM `" . $sync_tbl->table . "` WHERE ";
				foreach ( $unique as $k => $v ) {
					$query .= " `{$k}` = '{$v}' AND ";
				}
				$query .= ' 1=1 ';
				$dst_site->_site_db->setQuery ( $query );
				$dst_id = ( int ) $dst_site->_site_db->loadResult ();
				if ($dst_site->_site_db->getErrorNum ()) {
					return $dst_site->_site_db->stderr ();
				}
			}
		}
		return $dst_id;
	}
}
?>