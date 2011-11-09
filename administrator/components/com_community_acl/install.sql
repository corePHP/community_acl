

CREATE TABLE IF NOT EXISTS `#__community_acl_sync_table` (
  `id` int(10) NOT NULL auto_increment,  
  `table` varchar(255) NOT NULL default '',
  `fields` text NOT NULL,
  `enabled` tinyint(4) NOT NULL default '1', 
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__community_acl_sync` (
  `id` int(10) NOT NULL auto_increment,  
  `src_site_id` int(10) NOT NULL,
  `dst_site_id` int(10) NOT NULL,
  `tablename` varchar(255) NOT NULL default '',
  `fieldname` varchar(255) NOT NULL default '',
  `src_field_id` int(10) NOT NULL,
  `dst_field_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  INDEX (`src_site_id`),
  INDEX (`dst_site_id`)
);

CREATE TABLE IF NOT EXISTS `#__community_acl_config` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__community_acl_sites` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `db_host` varchar(255) NOT NULL default '',
  `db_name` varchar(255) NOT NULL default '',
  `db_user` varchar(255) NOT NULL default '',
  `db_password` varchar(255) NOT NULL default '',
  `db_prefix` varchar(255) NOT NULL default '',
  `description` text,
  `is_main` tinyint(4) NOT NULL default '0', 
  `enabled` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`)
);


CREATE TABLE IF NOT EXISTS `#__community_acl_groups` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` text,
  `enabled` tinyint(4) NOT NULL default '1',
  `dosync` TINYINT( 4 ) DEFAULT '1' NOT NULL,
  `redirect_URL_FRONT` TEXT,
  `redirect_URL_ADMIN` TEXT,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__community_acl_roles` (
  `id` int(10) NOT NULL auto_increment,
  `group_id` int(10) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `description` text,
  `ordering` int(10) NOT NULL default 0, 
  `enabled` tinyint(4) NOT NULL default '1', 
  `dosync` TINYINT( 4 ) DEFAULT '1' NOT NULL,
  `redirect_FRONT` TEXT,
  `redirect_ADMIN` TEXT,
  PRIMARY KEY  (`id`),
  INDEX (`group_id`)
);

CREATE TABLE IF NOT EXISTS `#__community_acl_functions` (
  `id` int(10) NOT NULL auto_increment,
  `group_id` int(10) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `description` text,
  `j_group_id` int(10) NOT NULL default '0',
  `ordering` int(10) NOT NULL default 0,
  `enabled` tinyint(4) NOT NULL default '1', 
  `dosync` TINYINT( 4 ) DEFAULT '1' NOT NULL,
  PRIMARY KEY  (`id`),
  INDEX (`group_id`)
);

CREATE TABLE IF NOT EXISTS `#__community_acl_function_access` (
  `id` int(10) NOT NULL auto_increment,
  `func_id` int(10) NOT NULL default '0',
  `grouping` int(10) NOT NULL default '0',
  `option` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  `isfrontend` tinyint(4) NOT NULL default '0', 
  `isbackend` tinyint(4) NOT NULL default '0',
  `enabled` tinyint(4) NOT NULL default '1', 
  `extra` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  INDEX (`func_id`)
);

CREATE TABLE IF NOT EXISTS `#__community_acl_access` (
  `id` int(10) NOT NULL auto_increment,
  `group_id` int(10) NOT NULL default '0',
  `role_id` int(10) NOT NULL default '0',
  `option` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  `isfrontend` tinyint(4) NOT NULL default '0', 
  `isbackend` tinyint(4) NOT NULL default '0', 
  `enabled` tinyint(4) NOT NULL default '1', 
  PRIMARY KEY  (`id`),
  INDEX (`group_id`),
  INDEX (`role_id`)
);CREATE TABLE IF NOT EXISTS `#__community_acl_article_submission` (`id` int(11) NOT NULL AUTO_INCREMENT,`choices` varchar(45) DEFAULT NULL,PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `#__community_acl_users` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `group_id` int(10) NOT NULL default '0',
  `role_id` int(10) NOT NULL default '0',
  `function_id` int(10) NOT NULL default '0',
  `redirect_FRONT` text NOT NULL default '',
  `redirect_ADMIN` text NOT NULL default '',
  PRIMARY KEY  (`id`),
  INDEX (`user_id`),  
  INDEX (`group_id`),
  INDEX (`role_id`),
  INDEX (`function_id`)
);

CREATE TABLE IF NOT EXISTS `#__community_acl_content_actions` (
  `id` int(10) NOT NULL auto_increment,
  `func_id` int(10) NOT NULL default '0',
  `item_type` varchar(255) NOT NULL default '', 
  `action` varchar(255) NOT NULL default '', 
  `item_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__community_acl_user_params` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  INDEX (`user_id`)
);

CREATE TABLE IF NOT EXISTS `#__community_acl_cb_groups` (
 `id` int(10) NOT NULL,
 `name` varchar(255) NOT NULL default '',
 `description` text NOT NULL default '',
 `enabled` tinyint(4) NOT NULL default '0',
 `dosync` tinyint(4) NOT NULL default '0',
 `redirect_front` text NOT NULL default '',
 `redirect_admin` text NOT NULL default ''
);

 CREATE TABLE IF NOT EXISTS `#__community_acl_cb_roles` (
 `id` int(10) NOT NULL,
 `group_id` int(10) NOT NULL,
 `name` varchar(255) NOT NULL default '',
 `description` text NOT NULL default '',
 `ordering` tinyint(4) NOT NULL default '0',
 `enabled` tinyint(4) NOT NULL default '0',
 `dosync` tinyint(4) NOT NULL default '0',
 `redirect_front` text NOT NULL default '',
 `redirect_admin` text NOT NULL default ''
);

 CREATE TABLE IF NOT EXISTS `#__community_acl_cb_functions` (
 `id` int(10) NOT NULL,
 `group_id` int(10) NOT NULL,
 `name` varchar(255) NOT NULL default '',
 `description` text NOT NULL default '',
 `j_group_id` int(10) NOT NULL default '0',
 `ordering` int(10) NOT NULL default '0',
 `enabled` tinyint(4) NOT NULL default '0',
 `dosync` tinyint(4) NOT NULL default '0'
); 

CREATE TABLE IF NOT EXISTS `#__community_acl_submit_form_group_level` (
  `id` int(11) NOT NULL,
  `group_id` int(30) NOT NULL,
  `desc` text NOT NULL,
  `choices` int(11) NOT NULL
);


CREATE TABLE IF NOT EXISTS `#__community_acl_submit_form_role_level` (
  `id` int(11) NOT NULL,
  `role_id` int(40) NOT NULL,
  `desc` text NOT NULL,
  `choices` int(11) NOT NULL
);

CREATE TABLE IF NOT EXISTS `#__community_acl_membership_types` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
);