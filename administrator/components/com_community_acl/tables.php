<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );



$jos_core_acl_groups_aro_map = array( 'key' => array('id'),
								 'unique' => array(),
								 'other' => array('section_value','name','hidden'),	 
								 'linked' => array('value'=>array('table'=>'#__users', 'key'=>'id', 'unique'=>array('username')))
								  );

$jos_core_acl_aro = array( 'key' => array('id'),
						 'unique' => array(),
						 'other' => array('section_value','name','hidden'),	 
						 'linked' => array('value'=>array('table'=>'#__users', 'key'=>'id', 'unique'=>array('username')))
						  );

$jos_users = array( 'key' => array('id'),
						 'unique' => array('username'),
						 'other' => array('name','email','password','usertype','block','sendEmail','gid','activation','params','registerDate'),	 
						 'linked' => array()
						  );
					  
$jos_categories = array( 'key' => array('id'),
						 'unique' => array(),
						 'other' => array('parent_id','title','name','alias','image','section','image_position','description','published','editor','access','count','params','ordering'),	 
						 'linked' => array()
						  );					  

$jos_contact_details = array( 'key' => array('id'),
						 'unique' => array(),
						 'other' => array('name','alias','con_position','address','suburb','state','country','postcode','telephone','fax','misc','image','imagepos','email_to','default_con','published','ordering','params','access','mobile','webpage'),	 
						 'linked' => array('user_id'=>array('table'=>'#__users', 'key'=>'id', 'unique'=>array('username')),
						 					'catid'=>array('table'=>'#__categories', 'key'=>'id', 'unique'=>array()))
						  );

$jos_comprofiler = array( 'key' => array('id'),
						 'unique' => array('user_id'),
						 'other' => array('firstname','middlename','lastname','approved','confirmed','banned','banneddate','acceptedterms','registeripaddr','cbactivation'),	 
						 'linked' => array('id'=>array('table'=>'#__users', 'key'=>'id', 'unique'=>array('username')),
						 					'user_id'=>array('table'=>'#__users', 'key'=>'id', 'unique'=>array('username')))
						  );
						  
						  
$jos_community_acl_groups = array( 'key' => array('id'),
						 'unique' => array('name'),
						 'other' => array('description','enabled','dosync'),	 
						 'linked' => array()
						  );

$jos_community_acl_roles = array( 'key' => array('id'),
						 'unique' => array('name'),
						 'other' => array('description','enabled', 'ordering','dosync'),	 
						 'linked' => array('group_id'=>array('table'=>'#__community_acl_groups', 'key'=>'id', 'unique'=>array('name')))
						  );						  						  
  
$jos_community_acl_functions = array( 'key' => array('id'),
						 'unique' => array('name'),
						 'other' => array('group_id','description','j_group_id','ordering','enabled','dosync'),	 
						 'linked' => array()
						  );

$jos_community_acl_users = array( 'key' => array('id'),
						 'unique' => array(),
						 'other' => array(),	 
						 'linked' => array('user_id'=>array('table'=>'#__users', 'key'=>'id', 'unique'=>array('username')),
						 					'group_id'=>array('table'=>'#__community_acl_groups', 'key'=>'id', 'unique'=>array('name')),
											'role_id'=>array('table'=>'#__community_acl_roles', 'key'=>'id', 'unique'=>array('name')),
											'function_id'=>array('table'=>'#__community_acl_functions', 'key'=>'id', 'unique'=>array('name'))						 	
						 					)
						  );						  


$jos_community_acl_access = array( 'key' => array('id'),
						 'unique' => array(),
						 'other' => array('option', 'name', 'isfrontend', 'isbackend', 'enabled'),	 
						 'linked' => array('group_id'=>array('table'=>'#__community_acl_groups', 'key'=>'id', 'unique'=>array('name')),
											'role_id'=>array('table'=>'#__community_acl_roles', 'key'=>'id', 'unique'=>array('name')),
											'value'=>array('table'=>'#', 'key'=>'', 'unique'=>array('')))
						  );

$jos_community_acl_function_access = array( 'key' => array('id'),
						 'unique' => array(),
						 'other' => array('grouping', 'option','name', 'value', 'isfrontend', 'isbackend', 'enabled', 'extra'),	 
						 'linked' => array('func_id'=>array('table'=>'#__community_acl_functions', 'key'=>'id', 'unique'=>array('name')))
						  );
						  
$jos_community_acl_config = array( 'key' => array('id'),
						 'unique' => array('name'),
						 'other' => array('value'),	 
						 'linked' => array()
						  );
						  
$jos_community_acl_user_params = array( 'key' => array('id'),
						 'unique' => array(),
						 'other' => array('name', 'value'),	 
						 'linked' => array('user_id'=>array('table'=>'#__users', 'key'=>'id', 'unique'=>array('username'))					 	
						 					)
						  );

$jos_community_acl_content_actions = array( 'key' => array('id'),
						 'unique' => array(),
						 'other' => array('item_type', 'action'),	 
						 'linked' => array('item_id'=>array('table'=>'#', 'key'=>'', 'unique'=>array('')),
								   'func_id'=>array('table'=>'#__community_acl_functions', 'key'=>'id', 'unique'=>array('name'))					 	
						 					)
						  );


?>