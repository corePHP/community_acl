<?php
/**
 * Main Plugin File
 * Does all the magic!
 *
 * @package    cacl_joomsocial
 * @version    0.0.1
 *
 * @author     Adam Stephen Docherty <adam.docherty@gmail.com>
 * @link       http://www.corephp.com
 * @copyright  Copyright (C) 2009 www.corephp.com All Rights Reserved
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//Load Community ACL functions
if (file_exists(JPATH_SITE.'/administrator/components/com_community_acl/community_acl.functions.php')){
	require_once( JPATH_SITE.'/administrator/components/com_community_acl/community_acl.functions.php' );
} else {
	if (!function_exists('check_component')){
		function check_component($option) {
			return true;
		}
	}
	if (!function_exists('check_link')){
		function check_link($link, $mid=0) {
			return true;
		}
	}
}

// Import library dependencies
jimport( 'joomla.event.plugin' );

/**
* Plugin to preprocess content for community acl
*/
class plgSystemCacl_joomsocial extends JPlugin {

	function plgSystemCacl_joomsocial( &$subject )
	{
		parent::__construct($subject);
	}

	function onAfterRender()
	{
		if (!file_exists(JPATH_SITE.'/administrator/components/com_community_acl/community_acl.functions.php')){
			return false;
		}

		$user	=& JFactory::getUser();
		if ($user->get('gid') == 25) {
			return;
		}

		$_document	=& JFactory::getDocument();
		$_docType = $_document->getType();

		if ( $_docType == 'pdf' ) { return; }

		$app =& JFactory::getApplication();

		$back_end = false;
		if ( $app->getName() != 'site' ){
			$back_end = true;
			return;
		}

		if(!$back_end){
			$this->processJoomSocialAccess();
		}

	}

	function processJoomSocialAccess()
	{
	    global $mainframe;

		$db	=& JFactory::getDBO();

		$config = new CACL_config($db);
		$config->load();

		$defaultDeny = false;

		if($config->default_action == 'deny'){
			$defaultDeny = true;
		}

		$accessList = $this->getAccessList();
		$menuList = $this->getMenuListAccess();

		foreach($menuList as $k=>$group){

			$menuList[$k]['itemCount'] = count($group['items']);

			foreach($group['items'] as $id=>$item){

				if($defaultDeny){
					if( array_key_exists($id, $accessList) ){
						unset($menuList[$k]['items'][$id]);
					}
				} else {
					if( array_key_exists($id, $accessList) ){
						unset($menuList[$k]['items'][$id]);
					}
				}
			}

			if($menuList[$k]['itemCount'] == count($menuList[$k]['items'])){
				$menuList[$k]['deny'] = true;
			}
		}

		require_once (JPATH_SITE.'/administrator/components/com_community_acl/community_acl.class.php');
		require_once (JPATH_SITE.'/administrator/components/com_community_acl/community_acl.functions.php');


		$config = new CACL_config($db);
		$config->load();

	    $redirect_url = $config->redirect_url;

	    if(JRequest::getVar('option') == 'com_community') {
    		if(is_array($menuList)){
    			foreach($menuList as $view){
    				if(is_array($view['items'])){
    				    $style = '';
    					foreach($view['items'] as $task){

    						if(array_key_exists('task',$task)){
    							$pattern[] = '/(?>(<a.*?>))'.$task['name'].'<\/a>/s';
    							$pattern[] = '/(?>(<span.*?>))'.$task['name']."<\/span>/s";
    							if(array_key_exists('style', $task)){
    								$style .= 'ul.actions li.'.$task['style'].'{display:none !important}';
    							}

    							if(JRequest::getVar('view') == $view['view'] && JRequest::getVar('task') == $task['task']){
    								$mainframe->redirect( $redirect_url, JText::_( 'ALERTNOTAUTH' ));
    								return;
    								//JError::raiseError( 500, 'ACCESS DENIED');
    							}
    						} else {

    							//
    							$style .= '#'.$task['style'].'{display:none !important}';
    							if(JRequest::getVar('view') == $task['view']){
    							    $mainframe->redirect( $redirect_url, JText::_( 'ALERTNOTAUTH' ));
    							    return;
    								//JError::raiseError( 500, 'ACCESS DENIED');
    							}
    						}
    					}
    				}
    			}
    		}
		}

		$_html = JResponse::getBody();

		if(isset($style)){
			$_html = str_replace("<!-- Jom Social -->", "<!-- Jom Social --><style>$style</style>", $_html);
		}

		if(isset($pattern) && is_array($pattern)){
			$_html = preg_replace($pattern, '', $_html);
		}

		JResponse::setBody( $_html );
	}

	function getAccessList()
	{

		$db	=& JFactory::getDBO();

		$config = new CACL_config($db);
		$config->load();

		$user_access = cacl_get_user_access($config);
		$groups = $user_access['groups'];
		$roles = $user_access['roles'];
		$menuList = $this->getMenuList();

		$query = "SELECT value FROM `#__community_acl_access` AS a

							WHERE a.option = 'jsmenu'

								AND ( a.group_id IN ( '". implode("','", $groups) ."')
									OR a.role_id IN ( '". implode("','", $roles) ."') )";
		$db->setQuery($query);
		$items = $db->loadAssocList();

		$itemsPrepped = array();
		foreach($items as $item){
			$itemsPrepped[$item['value']] = true;
		}

		return $itemsPrepped;
	}

	function saveAccess($db, $jsmenu_id, $group_id, $role_id)
	{
		if (is_array($jsmenu_id) && count($jsmenu_id)){
			foreach($jsmenu_id as $i=>$id) {
				if ($id > 0) {
					$query = "INSERT INTO `#__community_acl_access` (`group_id`, `role_id`, `option`, `name`, `value`, `isfrontend`, `isbackend`) VALUES('{$group_id}','{$role_id}','jsmenu','###','{$id}', '1', '0');";
					$db->setQuery($query);
					$db->Query();
					if ($db->getErrorNum()) {
						JError::raiseError( 500, $db->stderr() );
					}
				}
			}
		}

	}

	function getMenuListAccess()
	{

		$menuList = array(
			JText::_('Profile') => array(
				'view' => 'profile',
				'items' => array(
					1 => array(
						'name' => JText::_('Change profile picture'),
						'task' => 'uploadAvatar',
						'style' => 'avatar'
					),
					2 => array(
						'name' => JText::_('Edit profile'),
						'task' => 'edit',
						'style' => 'profile'
					),
					3 => array(
						'name' => JText::_('Edit details'),
						'task' => 'editDetails'
					),
					4 => array(
						'name' => JText::_('Privacy'),
						'task' => 'privacy',
						'style' => 'privacy'
					),
					5 => array(
						'name' => JText::_('Preferences'),
						'task' => 'preferences'
					)
				)
			),
			JText::_('Friends') => array(
				'view' => 'friends',
				'items' => array(
					6 => array(
						'name' => JText::_('Show all'),
						'task' => 'friends'
					),
					7 => array(
						'name' => JText::_('Search'),
						'task' => 'search'
					),
					8 => array(
						'name' => JText::_('Advanced Search'),
						'task' => 'advancesearch'
					),
					9 => array(
						'name' => JText::_('Invite Friends'),
						'task' => 'invite'
					),
					10 => array(
						'name' => JText::_('Request sent'),
						'task' => 'sent'
					),
					11 => array(
						'name' => JText::_('Pending my approval'),
						'task' => 'pending'
					)
				)
			),
			JText::_('Applications') => array(
				'view' => 'apps',
				'items' => array(
					12 => array(
						'name' => JText::_('My Applications'),
						'task' => 'apps'
					),
					13 => array(
						'name' => JText::_('Browse'),
						'task' => 'browse',
						'style' => 'apps'
					),
					14 => array(
						'name' => JText::_('Groups'),
						'task' => 'mygroups',
						'view' => 'groups'
					),
					15 => array(
						'name' => JText::_('Photos'),
						'task' => 'myphotos',
						'view' => 'photos',
						'style' => 'photo'
					),
					16 => array(
						'name' => JText::_('Videos'),
						'task' => 'myvideos',
						'view' => 'videos',
						'style' => 'video'
					)
				)
			),
			JText::_('Inbox') => array(
				'view' => 'inbox',
				'items' => array(
					17 => array(
						'name' => JText::_('Inbox'),
						'task' => 'apps',
						'style' => 'inbox'
					),
					18 => array(
						'name' => JText::_('Sent'),
						'task' => 'sent'
					),
					19 => array(
						'name' => JText::_('Write'),
						'task' => 'write',
						'style' => 'write'
					)
				)
			),
			JText::_('Tabs') => array(
				'view' => 'tabs',
				'items' => array(
					20 => array(
						'name' => JText::_('Profile'),
						'view' => 'profile',
						'style' => 'toolbar-item-profile'
					),
					21 => array(
						'name' => JText::_('Friends'),
						'view' => 'friends',
						'style' => 'toolbar-item-friends'
					),
					22 => array(
						'name' => JText::_('Applications'),
						'view' => 'apps',
						'style' => 'toolbar-item-apps'
					),
					23 => array(
						'name' => JText::_('Inbox'),
						'view' => 'inbox',
						'style' => 'toolbar-item-inbox'
					)
				)
			)
		);

		return $menuList;
	}

	function getMenuList()
	{

		$menuList = array(
			JText::_('Tabs') => array(
				20 => JText::_('Profile'),
				21 => JText::_('Friends'),
				22 => JText::_('Applications'),
				23 => JText::_('Inbox')
			),
			JText::_('Profile') => array(
				1 => JText::_('Change profile picture'),
				2 => JText::_('Edit profile'),
				3 => JText::_('Edit details'),
				4 => JText::_('Privacy'),
				5 => JText::_('Preferences')
			),
			JText::_('Friends') => array(
				6 => JText::_('Show all'),
				7 => JText::_('Search'),
				8 => JText::_('Advanced Search'),
				9 => JText::_('Invite Friends'),
				10 => JText::_('Request sent'),
				11 => JText::_('Pending my approval')
			),
			JText::_('Applications') => array(
				12 => JText::_('My Applications'),
				13 => JText::_('Browse'),
				14 => JText::_('Groups'),
				15 => JText::_('Photos'),
				16 => JText::_('Videos')
			),
			JText::_('Inbox') => array(
				17 => JText::_('Inbox'),
				18 => JText::_('Sent'),
				19 => JText::_('Write')
			)

		);

		return $menuList;
	}

	function getAccessItems(){

		$mode = JRequest::getVar('mode');
		$groupId = JRequest::getVar('cid');
		$groupId = $groupId[0];
		$db =& JFactory::getDBO();

		if($mode == 'role_id'){
			$query = "SELECT value
					FROM #__community_acl_access
						WHERE `option` = 'jsmenu'
							AND role_id='$groupId'
								ORDER BY value ASC";
		} else {
			$query = "SELECT value
					FROM #__community_acl_access
						WHERE `option` = 'jsmenu'
							AND group_id='$groupId'
								ORDER BY value ASC";
		}

		$db->setQuery( $query );
		$db->Query();
		$items = $db->loadObjectList();

		if ($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr() );
		}

		$menuList = plgSystemCacl_joomsocial::getMenuList();

		foreach($menuList as $k=>$group){
			foreach($group as $id=>$name){
				$menuListPrepped[$id]['name'] = $name;
				$menuListPrepped[$id]['group'] = $k;
			}
		}

		foreach($items as $k=>$item){
			$items[$k]->title = $menuListPrepped[$item->value]['name'];
			$items[$k]->group = $menuListPrepped[$item->value]['group'];
			$items[$k]->published = 1;
		}

		return $items;
	}

	function getAdminUi($pane, $lists, $default_action)
	{
		$accessItems = plgSystemCacl_joomsocial::getAccessItems();
		$menuList = plgSystemCacl_joomsocial::getMenuList();
		plgSystemCacl_joomsocial::getMenuJs();

		echo $pane->startPanel( JText::_( 'JoomSocial' ), 'JoomSocial' );

		?>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Add New Item' ); ?></legend>
			<table class="adminform">
				<tr>
					<td  valign="top" width="10%">
						<select name="joomSocialMenu" id="joomSocialMenu" class="inputbox" size="10" multiple="multiple" style="min-width:100px;max-width:200px;" >
						<?php
							if(is_array($menuList)){
								foreach($menuList as $label=>$optGroup){

									?>
									<optgroup label="<?php echo $label; ?>">
									<?php

									if(is_array($optGroup)){
										foreach($optGroup as $id=>$option){

											?>
											<option value="<?php echo $id; ?>" ><?php echo $option; ?></option>
											<?php

										}
									}

									?>
									</optgroup>
									<?php
								}
							}

						 ?>
						</select>
					</td>
					<td valign="top"  align="left" width="auto">
						<input type="button" name="select_all" class="button" value="Select All" onclick="javascript: Select_all('joomSocialMenu');"  /><br/><br/>
						<input type="button" name="add" class="button" value="Add" onclick="javascript: joomSocialMenu_addRow('list_body_joomSocial');"  />
					</td>
				</tr>
			</table>
		</fieldset>

		<fieldset class="adminform">
		<legend><?php echo ($default_action == 'deny'?JText::_( 'Lists of Allowed Items' ): JText::_( 'Lists of Forbidden Items' )); ?></legend>
			<table class="adminlist" cellpadding="1">
			<thead>
				<tr>
					<th width="2%" class="title">
						<?php echo JText::_( 'NUM' ); ?>
					</th>
					<th class="title" width="25%">
						<?php echo JText::_( 'Menu Item' ); ?>
					</th>
					<th class="title" width="10%">
						<?php echo JText::_( 'Menu' ); ?>
					</th>
					<th class="title" width="5%">
						<?php echo JText::_( 'ID' ); ?>
					</th>
					<th class="title" width="10%">
						<?php echo JText::_( 'Delete' ); ?>&nbsp;&nbsp;
						<input type="button" name="clear_all" class="button" value="<?php echo JText::_( 'Clear All' ); ?>" onclick="javascript: clearTable('list_body_joomSocial');"  />
					</th>
					<th class="title" width="auto">&nbsp;
					</th>
				</tr>
			</thead>
			<tbody id="list_body_joomSocial">
			<?php
			$k = 0;
			$i = 1;
			if (is_array($accessItems) && count($accessItems))
				foreach($accessItems as $row) {
					$img = $row->published ? 'tick.png' : 'publish_x.png';
					$alt 	= $row->published ? JText::_( 'Published' ) : JText::_( 'Unpublished' );
					$published 	= '<img src="images/'. $img .'" border="0" alt="'. $alt .'" />';
			?>
				<tr  class="row<?php echo $k; ?>">
					<td width="2%">
						<?php echo $i++; ?>
					</td>
					<td>
						<?php echo ($row->value > 0? $row->title: JText::_('Uncategorized')); ?>
						<input type="hidden" name="jsmenu_id[]" value="<?php echo $row->value; ?>"  />
					</td>
					<td  align="center">
						<?php echo $row->group; ?>
					</td>
					<td  align="center">
						<?php echo $row->value; ?>
					</td>
					<td align="center">
						<a href="javascript: void(0);" onclick="javascript:delete_row(this, 'list_body_joomSocial'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete" /></a>
					</td>
					<td>&nbsp;</td>
				</tr>
			<?php
					$k = 1 - $k;
				}?>
			</tbody>
			</table>
		</fieldset>

		<?php
		echo $pane->endPanel();
	}

	function getMenuJs()
	{
		?>
		<script>
		/* <![CDATA[ */
			function joomSocialMenu_addRow(tbl) {

				var listitem = jQuery('select#joomSocialMenu').get(0);
				var menuName = jQuery('select#joomSocialMenu').find("option:selected").parent().attr("label");
				var hidden_name = 'jsmenu_id[]';
				var carray = new Array;

			var tbody = jQuery('tbody#'+tbl).get(0);

			for (jj = 0; jj < listitem.options.length; jj++) {
				if (listitem.options[jj].selected == true && check_id_in_table(listitem.options[jj].value, tbl)) {
					var row = document.createElement("TR");



					jQuery('#joomSocialMenu :selected').each(function(i, selected){
						if(jQuery(selected).text() == listitem.options[jj].text){
							menuName = jQuery(selected).parent().attr("label");
						}
					});

					var cell0 = document.createElement("TD");
					cell0.innerHTML = '0';

					var cell1 = document.createElement("TD");
					cell1.innerHTML = listitem.options[jj].text;
					var input_hidden = document.createElement("input");
					input_hidden.type = 'hidden';
					input_hidden.name = hidden_name;
					input_hidden.value = listitem.options[jj].value;
					cell1.appendChild(input_hidden);

					var cell_pub = document.createElement("TD");

					cell_pub.innerHTML = menuName;
					cell_pub.align = "center";

					var cell_id = document.createElement("TD");
					cell_id.innerHTML = listitem.options[jj].value;
					cell_id.align = "center";

					var cell_last = document.createElement("TD");
					cell_last.innerHTML = '<a href="javascript: void(0);" onclick="javascript:delete_row(this,\''+tbl+'\'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"></a>';
					cell_last.align = "center";

					row.appendChild(cell0);
					row.appendChild(cell1);
					row.appendChild(cell_pub);


					row.appendChild(cell_id);
					row.appendChild(cell_last);

					tbody.appendChild(row);
				}
			}
			renum_table_rows(tbody);
		}
		/* ]]> */
		</script>
		<?php
	}
}