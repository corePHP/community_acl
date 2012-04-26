<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class cacl_html {

	function help(  ) {
		left_menu_header();
		?>
		<div style="text-align:left; padding:5px; font-family: verdana, arial, sans-serif; font-size: 9pt;">
		<p style="width:100%; text-align:right;">
		<a href="https://support.corephp.com/" target="_blank">`<?php echo "Support";?>`</a> &nbsp;||&nbsp;
		<a href="index2.php?option=com_community_acl&amp;task=changelog">`<?php echo _COMMUNITY_ACL_COMP_NAME . "` version history";?></a></p>

<p>On all pages to save changes click on buttons "Save" or "Apply".</p>
<h3><u>Configuration.</u></h3>
<p>This menu item serves to manage the component's settings. To go to it follow <strong>Components&gt;Community ACL&gt;Configuration</strong>.</p>
<p>The "Default Access" Tab allows you to define what group/role/function must be applied to a user depending on the user type if he/she doesn't have any.</p>
<p>The "Synchronization" Tab allows you to switch on/off synchronization and specify the elements to be synchronized. Do not switch on synchronization till all the sites to be synchronized are entered and the "Main site" is not chosen. The "Main site" must be entered and specified for all the sites..</p>

<h3><u>Users management.</u></h3>
<p>In this menu item you can see all the registered users of your site as well as their names, groups, log status and you can filter users too. The functional of this item is usual for any Joomla-based site.</p>
<p>When adding a new user or editing an already existing one you can define the group, the function and the role for this user in the "Community ACL Details" section plus standard parameters. </p>

<h3><u>Sites management.</u></h3>
<p>This menu item is designed to enter the sites which already have the embedded component and with which you want to synchronize users/roles/functions and access to the elements. </p>
<p>When entering new sites or editing the already existing sites, make sure you have entered the correct parameters. It can be done by means of the "Check DB details" button.</p>
<p>One of the listed sites must be marked as "Main Site". On the rest sites this site marked as "Main Site" must be marked as "Main Site" too. On the "Main Site" you must enter all the sites which are to be synchronized. All the information required for the elements synchronization will be saved on the "Main Site".</p>

<h3><u>Groups.</u></h3>
<p>This menu item serves to manage groups. Here you can add/edit/delete a group and set access for a group too. To set access for a group check the box near the corresponding group and click on "Set Access", then mark the elements the access to which you want to forbid. If you forbid access to a section then you forbid access to all its categories and articles too; the same is about categories. </p>
<p>If you want to grant access for a group then define a common access for all the roles which form this group, i.e. if all the roles of a certain group should not have access to an element you should forbid access to this element on a group level. </p>

<h3><u>Roles.</u></h3>
<p>This menu item is to manage roles. You can add/edit/delete role and define its access level. To specify access check the box near the corresponding role and click on "Set Access", then mark the elements for which you want to forbid access. If you forbid access to a section then you forbid access to all its categories and articles too; the same is about categories. </p>
<p>If you want to forbid access to a certain element for a certain role then forbid access to it on the role level. </p>

<h3><u>Functions.</u></h3>
<p>This menu item serves to manage functions. Here you can add/edit/delete function's actions and assign operations for a function.
To specify a necessary operation for a function click on "Set Access", then choose the component for which you want to restrict operations. Then choose one of the following variants:</p>
<p>To forbid any operations with the component or to forbid access to it check the box near the corresponding title, click on "Set Actions" and choose "All actions";</p>
<p>To specify the values for which it is required to forbid access check the box near the corresponding title, click on "Set Actions" and choose "Custom Actions". To specify the value enter the title - 'Key', for example, "task" and its value, for example, "edit".</p>
<p>It's possible to enter several pairs 'key-value'. The entered Action for component will work only if all the pairs 'key-value' coincide in the request.</p>


<h3><u>ACL Community - Instruction for standart components</u></h3>

<h3>Banners</h3>

<p>to specify a certain element (banner, client or category) cid=&lt;item id&gt;
where &lt;item id&gt; - a unique element number (a figure)</p>

&nbsp;&nbsp;&nbsp;&bull;&nbsp;Creation of a new one: task = add<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Editing: task = edit<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Saving: task = apply, task = save<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Deleting: task = remove<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Publication: task = publish, task = unpublish<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Copying: task = copy<br/>

<p>Parameters (to be specified for the Configuration manager component)</p>
option=com_config<br/>
controller=component<br/>
component=com_banners<br/>

<p>Banners' category (to be specified for the Categories component) </p>
option=com_categories<br/>
section=com_banner<br/>

Clients
c = client

<h3>Contacts</h3>

<p>to specify a certain element (banner, client or category) cid=&lt;item id&gt;
where &lt;item id&gt; - a unique element number (a figure)</p>

&nbsp;&nbsp;&nbsp;&bull;&nbsp;Creation of a new one: task = add<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Editing: task = edit<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Saving: task = apply, task = save, task = save2new, task =  save2copy<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Deleting: task = remove<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Publication: task = publish, task = unpublish<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Sorting: task = orderup, task = orderdown, task = saveorder<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Access: task = accesspublic, task = accessregistered, task = accessspecial<br/>

<p>Parameters (to be specified for the Configuration manager component)</p>
option=com_config<br/>
controller=component<br/>
component=com_contact<br/>

<p>Contacts category (to be specified for the Categories component)</p>
option=com_categories<br/>
section=com_contact_details<br/>


<h3>Newsfeeds</h3>

<p>to specify a certain element (banner, client or category) cid=&lt;item id&gt;
where &lt;item id&gt; - a unique element number (a figure)</p>

&nbsp;&nbsp;&nbsp;&bull;&nbsp;Creation of a new one: task = add<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Editing: task = edit<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Saving: task = apply, task = save<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Deleting: task = remove<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Sorting: task = orderup, task = orderdown, task = saveorder<br/>

<p>Parameters (to be specified for the Configuration manager component)</p>
option=com_config<br/>
controller=component<br/>
component=com_newsfeeds<br/>

<p>Newsfeeds category (to be specified for the Categories component)</p>
option=com_categories<br/>
section=com_newsfeeds<br/>

<h3>Search</h3>

<p>Reset task = reset</p>

<p>Show Search Results  search_results = 1</p>

<p>Parameters (to be specified for the Configuration manager component)</p>
option=com_config<br/>
controller=component<br/>
component=com_search<br/>

<h3>WebLinks</h3>

<p>to specify a certain element (banner, client or category) cid=&lt;item id&gt;
where &lt;item id&gt; - a unique element number (a figure)</p>

&nbsp;&nbsp;&nbsp;&bull;&nbsp;Creation of a new one: task = add<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Editing: task = edit<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Saving: task = apply, task = save<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Deleting: task = remove<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Sorting: task = orderup, task = orderdown, task = saveorder<br/>

<p>Parameters (to be specified for the Configuration manager component)</p>
option=com_config<br/>
controller=component<br/>
component=com_weblinks<br/>

<p>Newsfeeds category (to be specified for the Categories component)</p>
option=com_categories<br/>
section=com_weblinks<br/>

<h3>Section Manager</h3>

<p>to specify a certain element (banner, client or category) cid=&lt;item id&gt;
where &lt;item id&gt; - a unique element number (a figure)</p>

&nbsp;&nbsp;&nbsp;&bull;&nbsp;Creation of a new one: task = add<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Editing: task = edit<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Saving: task = apply, task = save, task = go2menu, task = go2menuitem<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Deleting: task = remove<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Sorting: task = orderup, task = orderdown, task = saveorder<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Copying: task = copy<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Copying saving: task = copysave <br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Publication: task = publish, task = unpublish<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Access: task = accesspublic, task = accessregistered, task = accessspecial<br/>

<h3>Category Manager</h3>

<p>to specify a certain element (banner, client or category) cid=&lt;item id&gt;
where &lt;item id&gt; - a unique element number (a figure)</p>

&nbsp;&nbsp;&nbsp;&bull;&nbsp;Creation of a new one: task = add<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Editing: task = edit<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Saving: task = apply, task = save, task = go2menu, task = go2menuitem<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Deleting: task = remove<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Sorting: task = orderup, task = orderdown, task = saveorder<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Copying: task = copy<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Copying saving: task = copysave <br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Moving: task = movesect<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Moving saving: task = movesectsave<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Publication: task = publish, task = unpublish<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Access: task = accesspublic, task = accessregistered, task = accessspecial<br/>

<h3>Article Manager</h3>

<p>to specify a certain element (banner, client or category) cid=&lt;item id&gt;
where &lt;item id&gt; - a unique element number (a figure)</p>

&nbsp;&nbsp;&nbsp;&bull;&nbsp;Archiving: task = archive, task = unarchive<br/>

&nbsp;&nbsp;&nbsp;&bull;&nbsp;Frontpage: task = toggle_frontpage<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Creation of a new one: task = add, task = new<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Editing: task = edit<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Saving: task = apply, task = save, task = go2menu, task = go2menuitem<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Deleting: task = remove<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Sorting: task = orderup, task = orderdown, task = saveorder<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Copying: task = copy<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Copying saving: task = copysave<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Moving: task = movesect<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Moving saving: task = movesectsave<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Publication: task = publish, task = unpublish<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Access: task: = accesspublic, task = accessregistered, task = accessspecial<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Viewing: task = preview<br/>

<p>Parameters (to be specified for the Configuration manager component)</p>
option=com_config<br/>
controller=component<br/>
component=com_content<br/>

<h3>Front Page Manager</h3>

<p>to specify a certain element (banner, client or category) cid=&lt;item id&gt;
where &lt;item id&gt; - a unique element number (a figure)</p>

&nbsp;&nbsp;&nbsp;&bull;&nbsp;Archiving: task = archive<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Deleting: (Trash) task = remove<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Sorting: task = orderup, task = orderdown, task = saveorder<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Publication: task = publish, task = unpublish<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Access: task = accesspublic, task = accessregistered, task = accessspecial<br/>

<h3>User Manager</h3>

<p>to specify a certain element (banner, client or category) cid=&lt;item id&gt;
where &lt;item id&gt; - a unique element number (a figure)</p>

&nbsp;&nbsp;&nbsp;&bull;&nbsp;Creation of a new one: task = add<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Editing: task = edit<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Deleting: task = remove<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Saving: task = apply, task = save<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Locking: task = block, task = unblock<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Logout: task = logout<br/>

<h3>Module Manager</h3>
<p>to specify an the Administrator's group of modules add `client_id=0`</p>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Creating a new one: task = add<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Editing: task = edit<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Deleting: task = remove<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Saving: task = apply, task = save<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Copying: task = copy<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Sorting: task = orderup, task = orderdown, task = saveorder<br/>
&nbsp;&nbsp;&nbsp;&bull;&nbsp;Publishing: task = publish, task = unpublish<br/>
<br />
<u>Example:</u><br />
We need to allow managing module `Banners` only, so we should specify the following key/value pairs:<br />
&nbsp;&nbsp;to allow entering on Edit page:<br />
&nbsp;&nbsp;&nbsp;&bull;&nbsp;task=edit<br />
&nbsp;&nbsp;&nbsp;&bull;&nbsp;cid=30<br />
&nbsp;&nbsp;&nbsp;&bull;&nbsp;id=30<br /><br />
&nbsp;&nbsp;to allow applying changes:<br />
&nbsp;&nbsp;&nbsp;&bull;&nbsp;task=apply<br />
&nbsp;&nbsp;&nbsp;&bull;&nbsp;id=30<br /><br />
&nbsp;&nbsp;to allow saving<br />
&nbsp;&nbsp;&nbsp;&bull;&nbsp;task=save<br />
&nbsp;&nbsp;&nbsp;&bull;&nbsp;id=30<br /><br />
&nbsp;&nbsp;to allow cancel editing<br />
&nbsp;&nbsp;&nbsp;&bull;&nbsp;task=cancel<br />
&nbsp;&nbsp;&nbsp;&bull;&nbsp;id=30<br />

		</div>
		<?php
		left_menu_footer();
	}


	function about( $version ) {
		global $option;
		left_menu_header();
		$not_writable = '';

		?>
		<table width="100%" border="0">
				<tr>
					<td valign="top">
					<table border="1" width="100%" style="background-color: #F7F8F9; border: solid 1px #d5d5d5; width: 100%; padding: 10px; border-collapse: collapse;">
						<tr>
							<td style="text-align:left; font-size:14px; font-weight:400; line-height:18px " colspan="2"><strong>Community ACL</strong> component for Joomla! 1.5.x. Developed by &lsquo;corePHP&rsquo;.</td>
						</tr>
						<tr>
							<td width="200px" bgcolor="#FFFFFF" align="left">Installed version:</td>
							<td bgcolor="#FFFFFF" align="left"> &nbsp;<b><?php echo $version;?></b></td>
						</tr>
						<tr>
							<td valign="top" bgcolor="#FFFFFF" align="left">About:</td>
							<td bgcolor="#FFFFFF" align="left">
							Community ACL allows finer control over which users can access items on your site.
							</td>
						</tr>

					</table>
					</td>
				</tr>
			</table>
		<br />

			<?php
			global $mainframe;
			$task = JRequest::getCmd('task');

			$msg = '';
			# - Kobby Sam: Eliminate the check for Community Builder
			/*switch (check_cb_plugin()) {
				case -3:
					$msg .= 'Community Builder is not detected. Please install Community Builder ver 1.1 or above and then install cACL plugin for Community Builder.<br/>';
				break;
				case -2:
					$msg .= 'Incorrect version of Community Builder. Please install Community Builder ver 1.1 or above and then install cACL plugin for Community Builder.<br/>';
				break;
				case -1:
					$msg .= 'Community ACL plugin for Community Builder is not installed.<br/>';
				break;
				case 0:
					$msg .= 'Community ACL plugin for Community Builder is installed, but not enabled.<br/>';
				break;
			}*/
			$message = true;
			switch (check_plugin()) {
				case -1:
					$msg .= 'Community ACL plugin for Joomla! is not installed.<br/>';
				break;
				case 0:
					$msg .= 'Community ACL plugin for Joomla! is installed, but not enabled.<br/>';
				break;
			}

			//if (check_core_file(JPATH_SITE.DS.'administrator'.DS.'modules'.DS.'mod_commacl_menu'.DS.'helper.php') < 1)
				// $msg .= 'Please install mod_commacl_menu.zip - located in the site folder of Community ACL package.<br/>';

			/*if (check_core_file(JPATH_SITE.DS.'modules'.DS.'mod_commacl_mainmenu'.DS.'helper.php') < 1)
				 $msg .= 'Please install mod_commacl_mainmenu.zip - located in the site folder of Community ACL package.<br/>';

			if (check_core_file(JPATH_SITE.DS.'modules'.DS.'mod_commacl_mainmenu'.DS.'legacy.php') < 1)
				 $msg .= 'Please install mod_commacl_mainmenu.zip - located in the site folder of Community ACL package.<br/>';
				*/
			$helperFile = JPATH_SITE.DS.'libraries'.DS.'joomla'.DS.'application'.DS.'module'.DS.'helper.php';
			$helperFileInstall = check_core_file($helperFile);
			if ( $helperFileInstall === -1):
			?>
				 <p style="color: red">Community ACL core patch in the `<?php echo $helperFile; ?>` is not detected.</p>
				 <p>If you want control over the modules the patch needs installed.</p>
				 <p>You will need to manually replace the helper.php file with the one included in the CACL zip file. The web server doesn't have write access (rightfully so) to helper.php and it cannot overwrite the old.<br/>
					Copy this file:<br/>
					Community ACL.zip/site/joomla_patch.zip/libraries/joomla/application/module/helper.php<br/>
					To:<br/>
					{your Joomla! site}/libraries/joomla/application/module/helper.php
				</p>
			<?php
			endif;

			if ($message) {
				if ($msg != '') {
					//$msg = 'Some elements of Community ACL are not installed or enabled. Please go to the <a href="index.php?option=com_community_acl&amp;task=hacks">Patch Page</a> to fix it.<br/> '.$msg;
				}
			}
			print_r('<p style="color: red">'.$msg.'</p>');
		left_menu_footer();
	}
	#- Move this to the About Page
	function hacks(){
		left_menu_header();
		$not_writable = '';
		?>
		<table border="1" width="100%" style="background-color: #F7F8F9; border: solid 1px #d5d5d5; width: 100%; padding: 10px; border-collapse: collapse;">
		<?php
		$msg = '';
		# - Kobby Sam: Eliminate the check for Community Builder
		$cb_code = check_cb_plugin();
		switch ($cb_code) {
			case -3:
				$msg .= 'Community Builder is not detected. Please install Community Builder ver 1.1 or above and then install cACL plugin for Community Builder.';
			break;
			case -2:
				$msg .= 'Incorrect version of Community Builder. Please install Community Builder ver 1.1 or above and then install cACL plugin for Community Builder.';
			break;
			case -1:
				$msg .= 'Community ACL plugin for Community Builder is not installed.';
			break;
			case 0:
				$msg .= 'Community ACL plugin for Community Builder is installed, but not enabled.';
			break;
		}
		if ($cb_code < 1 ) {
		?>
		<!--// <tr>
			<td align="center" width="85"><?php if ($cb_code > -2) {?><input type="button" name="install" value="Fix it" onclick="javascript: window.location.href = 'index.php?option=com_community_acl&amp;task=fixit&mode=cb&code=<?php echo $cb_code;?>'" /><?php } ?></td><td style="width:auto;"><?php echo $msg;?></td>
		</tr> //-->
		<?php  }

		$msg = '';
		$j_code = check_plugin();
		switch ($j_code) {
			case -1:
			$msg .= 'Community ACL plugin for Joomla! is not installed.<br/>';
			break;
			case 0:
				$msg .= 'Community ACL plugin for Joomla! is installed, but not enabled.<br/>';
			break;
		}
		if ($j_code < 1 ) {
		?>
		<tr>
			<td align="center" width="85"><input type="button" name="install" value="Fix it" onclick="javascript: window.location.href = 'index.php?option=com_community_acl&amp;task=fixit&amp;mode=joomla&amp;code=<?php echo $j_code;?>'" /></td><td style="width:auto;"><?php echo $msg;?></td>
		</tr>
		<?php }

		$module_helper = check_core_file(JPATH_SITE.DS.'libraries'.DS.'joomla'.DS.'application'.DS.'module'.DS.'helper.php');
		$not_writable = '';
		if ($module_helper < 1) {
		?>
		<tr>
			<td align="center" width="85">
			<?php if ($module_helper == 0) { ?>
				<input type="button" name="install" value="Fix it" onclick="javascript: window.location.href = 'index.php?option=com_community_acl&amp;task=fixit&amp;mode=hack&amp;code=4'" />
			<?php } else {
				$not_writable = '<br/>The `'.JPATH_SITE.DS.'libraries'.DS.'joomla'.DS.'application'.DS.'module'.DS.'helper.php'.'` file is <font color="#FF0000">not writable</font>. Please make it writable or manually replace the `'.JPATH_SITE.DS.'libraries'.DS.'joomla'.DS.'application'.DS.'module'.DS.'helper.php'.'` file with `com_community_acl/site/joomla_patch/libraries/joomla/application/module/helper.php`.';
			?>
				<font color="#FF0000" style="font-weight:bold;">NOT WRITABLE!</font>
			<?php }?>
			</td><td style="width:auto;"><?php echo 'Community ACL core hack in the `'.JPATH_SITE.DS.'libraries'.DS.'joomla'.DS.'application'.DS.'module'.DS.'helper.php'.'` file is not detected.'.$not_writable;?></td>
		</tr>
		<?php } ?>
		</table><br />

		<?php
		left_menu_footer();
	}

	function show_config( &$config, &$lists ) {
		left_menu_header();
		jimport('joomla.html.pane');
		JHTML::_('behavior.tooltip');
		$pane		=& JPane::getInstance('Tabs');
		?>
		<form action="index.php?option=com_community_acl&amp;task=config" method="post" name="adminForm">
		<?php
			echo $pane->startPane("content-pane");
			echo $pane->startPanel( JText::_( 'Default Access' ), 'Content' );
		?>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Access type' ); ?></legend>
		<table class="adminform">
			<tr>
				<td valign="top">
					<input type="hidden" name="default_action" value="<?php echo $config->default_action;?>" />
					<label><input type="radio"  name="tmp2a" value="1" <?php echo ($config->default_action == 'deny'? ' checked="checked" ': '');?> onchange="javascript: if (this.checked) document.adminForm.default_action.value = 'deny'; else document.adminForm.default_action.value = 'allow';" />Deny all by default</label><br />
					<label><input type="radio"  name="tmp2a" value="2" <?php echo ($config->default_action == 'allow'? ' checked="checked" ': '');?> onchange="javascript: if (this.checked) document.adminForm.default_action.value = 'allow'; else document.adminForm.default_action.value = 'deny';" />Allow all by default</label>
				</td>
			</tr>
		</table>
		</fieldset>

		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Custom Access for Joomla! groups' ); ?></legend>
		<script language="javascript" type="text/javascript">
			/* <![CDATA[ */
			var grouproles = new Array;
			<?php
			$i = 0;
			foreach ($lists['cacl_rid_arr'] as $k=>$v) {
				echo "grouproles[".$k++."] = new Array( '".addslashes( $v['group'] )."','".addslashes( $v['value'] )."','".addslashes( $v['text'] )."' );\n\t\t";
			}
			?>
			/* ]]> */
		</script>
		<?php echo JText::_( 'This rules will work only if user does not belong any CACL group or role.' ); ?>
		<table class="adminform">
			<tr>
				<td valign="middle" width="15%">
					<strong><?php echo JText::_( 'Public (not logged)' ); ?>:</strong>
				</td>
				<td valign="top">
					<table>
					<tr>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Group' ); ?>:&nbsp;<?php echo $lists['cacl_gid_pub']; ?>
						</td>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Role' ); ?>:&nbsp;<?php echo $lists['cacl_rid_pub']; ?>
						</td>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Function' ); ?>:&nbsp;<?php echo $lists['cacl_fid_pub']; ?>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td valign="middle">
					<strong><?php echo JText::_( 'Registered' ); ?>:</strong>
				</td>
				<td valign="top">
					<table>
					<tr>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Group' ); ?>:&nbsp;<?php echo $lists['cacl_gid_reg']; ?>
						</td>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Role' ); ?>:&nbsp;<?php echo $lists['cacl_rid_reg']; ?>
						</td>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Function' ); ?>:&nbsp;<?php echo $lists['cacl_fid_reg']; ?>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td valign="middle">
					<strong><?php echo JText::_( 'Author' ); ?>:</strong>
				</td>
				<td valign="top">
					<table>
					<tr>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Group' ); ?>:&nbsp;<?php echo $lists['cacl_gid_ath']; ?>
						</td>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Role' ); ?>:&nbsp;<?php echo $lists['cacl_rid_ath']; ?>
						</td>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Function' ); ?>:&nbsp;<?php echo $lists['cacl_fid_ath']; ?>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td valign="middle">
					<strong><?php echo JText::_( 'Editor' ); ?>:</strong>
				</td>
				<td valign="top">
					<table>
					<tr>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Group' ); ?>:&nbsp;<?php echo $lists['cacl_gid_edt']; ?>
						</td>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Role' ); ?>:&nbsp;<?php echo $lists['cacl_rid_edt']; ?>
						</td>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Function' ); ?>:&nbsp;<?php echo $lists['cacl_fid_edt']; ?>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td valign="middle">
					<strong><?php echo JText::_( 'Publisher' ); ?>:</strong>
				</td>
				<td valign="top">
					<table>
					<tr>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Group' ); ?>:&nbsp;<?php echo $lists['cacl_gid_pbl']; ?>
						</td>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Role' ); ?>:&nbsp;<?php echo $lists['cacl_rid_pbl']; ?>
						</td>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Function' ); ?>:&nbsp;<?php echo $lists['cacl_fid_pbl']; ?>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td valign="middle">
					<strong><?php echo JText::_( 'Manager' ); ?>:</strong>
				</td>
				<td valign="top">
					<table>
					<tr>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Group' ); ?>:&nbsp;<?php echo $lists['cacl_gid_man']; ?>
						</td>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Role' ); ?>:&nbsp;<?php echo $lists['cacl_rid_man']; ?>
						</td>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Function' ); ?>:&nbsp;<?php echo $lists['cacl_fid_man']; ?>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td valign="middle">
					<strong><?php echo JText::_( 'Administrator' ); ?>:</strong>
				</td>
				<td valign="top">
					<table>
					<tr>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Group' ); ?>:&nbsp;<?php echo $lists['cacl_gid_adm']; ?>
						</td>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Role' ); ?>:&nbsp;<?php echo $lists['cacl_rid_adm']; ?>
						</td>
						<td valign="top" class="key" width="30%">
							<?php echo JText::_( 'Function' ); ?>:&nbsp;<?php echo $lists['cacl_fid_adm']; ?>
						</td>
					</tr>
					</table>
				</td>
			</tr>
		</table>
		<script language="javascript" type="text/javascript">
		/* <![CDATA[ */
			function select_role(name, value) {
				var role = jQuery('select#'+name).get(0);
				var n = role.options.length;
				for(var i = 0; i < n; i++) {
					if (role.options[i].value == value) {
						role.selectedIndex = i;
						return;
					}
				}
			}

			changeDynaList( 'public_role', grouproles, document.adminForm.public_group.options[document.adminForm.public_group.selectedIndex].value, 0, 0);
			changeDynaList( 'registered_role', grouproles, document.adminForm.registered_group.options[document.adminForm.registered_group.selectedIndex].value, 0, 0);
			changeDynaList( 'author_role', grouproles, document.adminForm.author_group.options[document.adminForm.author_group.selectedIndex].value, 0, 0);
			changeDynaList( 'editor_role', grouproles, document.adminForm.editor_group.options[document.adminForm.editor_group.selectedIndex].value, 0, 0);
			changeDynaList( 'publisher_role', grouproles, document.adminForm.publisher_group.options[document.adminForm.publisher_group.selectedIndex].value, 0, 0);
			changeDynaList( 'manager_role', grouproles, document.adminForm.manager_group.options[document.adminForm.manager_group.selectedIndex].value, 0, 0);
			changeDynaList( 'administrator_role', grouproles, document.adminForm.administrator_group.options[document.adminForm.administrator_group.selectedIndex].value, 0, 0);

			try {select_role('public_role', <?php echo $config->public_role;?>)} catch(e){}
			try {select_role('registered_role', <?php echo $config->registered_role;?>)} catch(e){}
			try {select_role('author_role', <?php echo $config->author_role;?>)} catch(e){}
			try {select_role('editor_role', <?php echo $config->editor_role;?>)} catch(e){}
			try {select_role('publisher_role', <?php echo $config->publisher_role;?>)} catch(e){}
			try {select_role('manager_role', <?php echo $config->manager_role;?>)} catch(e){}
			try {select_role('administrator_role', <?php echo $config->administrator_role;?>)} catch(e){}
		/* ]]> */
		</script>
		</fieldset>
		<fieldset class="adminform">
		<legend>libTidy</legend>
		<table class="adminform">
                    <tr>
                        <td>This option enables use of the libtidy library which is enabled by default on most PHP installations.
                            It will clean up the XHTML output so that the DOM tree can be navigated more easily for menus.
                            Caveat is that if you are relying on incorrect XHTML it will correct it which will change the look of your site.
                            Because of differences of encodings, &amp;nbsp;'s maybe displayed as question marks.
                        </td>
                    </tr>
			<tr>
				<td valign="top">
					<input type="hidden" name="useTidy" value="<?php echo $config->useTidy;?>" />
					<label><input type="radio"  name="tmpLibTidy" value="true" <?php echo ($config->useTidy == 'true'? ' checked="checked" ': '');?> onchange="javascript: if (this.checked) document.adminForm.useTidy.value = 'true'; else document.adminForm.useTidy.value = 'false';" />Turn on libTidy (default if libTidy is enabled)</label><br />
					<label><input type="radio"  name="tmpLibTidy" value="false" <?php echo ($config->useTidy == 'false'? ' checked="checked" ': '');?> onchange="javascript: if (this.checked) document.adminForm.useTidy.value = 'false'; else document.adminForm.useTidy.value = 'true';" />Turn off libTidy</label>
				</td>
			</tr>
		</table>
		</fieldset>
		<fieldset class="adminform">
		<legend>DOM</legend>
		<table class="adminform">
                    <tr>
                        <td>Enables the use of the DOM for menu parsing. If libTidy is on, it is chosen first. If your HTML is not well formed, this may not work.</td>
                    </tr>
			<tr>
				<td valign="top">
					<input type="hidden" name="useDom" value="<?php echo $config->useDom;?>" />
					<label><input type="radio"  name="tmpDom" value="true" <?php echo ($config->useDom == 'true'? ' checked="checked" ': '');?> onchange="javascript: if (this.checked) document.adminForm.useDom.value = 'true'; else document.adminForm.useDom.value = 'false';" />Turn on DOM</label><br />
					<label><input type="radio"  name="tmpDom" value="false" <?php echo ($config->useDom == 'false'? ' checked="checked" ': '');?> onchange="javascript: if (this.checked) document.adminForm.useDom.value = 'false'; else document.adminForm.useDom.value = 'true';" />Turn off DOM</label>
				</td>
			</tr>
		</table>
		</fieldset>
		<fieldset class="adminform">
		<legend>Activate</legend>
		<table class="adminform">
                    <tr>
                        <td>These options give you the ablility to choose to run cACL on your front-end and back-end.</td>
                    </tr>
			<tr>
				<td valign="top">
					<input type="hidden" name="activate" value="<?php echo $config->activate;?>" />
					<label><input type="radio"  name="tmpActivate" value="site" <?php echo ($config->activate == 'site'? ' checked="checked" ': '');?> onchange="javascript: if (this.checked) document.adminForm.activate.value = 'site';" />Turn on Front-end cACL only.</label><br />
					<label><input type="radio"  name="tmpActivate" value="administrator" <?php echo ($config->activate == 'administrator'? ' checked="checked" ': '');?> onchange="javascript: if (this.checked) document.adminForm.activate.value = 'administrator';" />Turn on Back-end cACL only.</label><br />
					<label><input type="radio"  name="tmpActivate" value="site_administrator" <?php echo ($config->activate == 'site_administrator'? ' checked="checked" ': '');?> onchange="javascript: if (this.checked) document.adminForm.activate.value = 'site_administrator';" />Turn on both Front-end and Back-end cACL. (default)</label>
				</td>
			</tr>
		</table>
		</fieldset>

		<?php
		echo $pane->endPanel();
		echo $pane->startPanel( JText::_( 'Synchronization' ), 'Content' );

		?>
		<script language="javascript" type="text/javascript">
		/* <![CDATA[ */
			function displaySyncOptions(it){
				if(it == 0)
					jQuery('.syncOptions').css("display", "none");
				else
					jQuery('.syncOptions').css("display", "block");
			}
		/* ]]> */
		</script>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Synchronization' ); ?></legend>
			<table class="adminform">
			<tr>
				<td valign="top">
					<label><input type="checkbox"  name="tmp1" onclick="displaySyncOptions(document.adminForm.synchronize.value)" value="1" <?php echo ($config->synchronize? ' checked="checked" ': '');?> onchange="javascript: if (this.checked) document.adminForm.synchronize.value = '1'; else document.adminForm.synchronize.value = '0';" />Synchronization enabled.</label>
					<input type="hidden" name="synchronize" value="<?php echo $config->synchronize;?>" />
				</td>
			</tr>
			</table>
		</fieldset>
		<?php //if ($config->synchronize){ ?>
		<fieldset class="syncOptions"  <?php if ($config->synchronize) echo 'style="display:block;"'; else  echo 'style="display:none;"'; ?> >
		<legend><?php echo JText::_( 'Items to synchronize' ); ?></legend>
			<table class="adminform">
			<tr>
				<td valign="top">
					<label><input type="checkbox" name="tmp2" value="1" <?php echo ($config->users_and_cb? ' checked="checked" ': '');?> onchange="javascript: if (this.checked) document.adminForm.users_and_cb.value = '1'; else document.adminForm.users_and_cb.value = '0';" />Joomla! users and CB users fields.</label><br />
					<input type="hidden" name="users_and_cb" value="<?php echo $config->users_and_cb;?>" />
					<label><input type="checkbox"  name="tmp3" value="1" <?php echo ($config->cb_contact? ' checked="checked" ': '');?> onchange="javascript: if (this.checked) document.adminForm.cb_contact.value = '1'; else document.adminForm.cb_contact.value = '0';" />CB Contact component.</label><br />
					<input type="hidden" name="cb_contact" value="<?php echo $config->cb_contact;?>" />
					<label><input type="checkbox"  name="tmp4" value="1" <?php echo ($config->cacl_grf? ' checked="checked" ': '');?> onchange="javascript: if (this.checked) document.adminForm.cacl_grf.value = '1'; else document.adminForm.cacl_grf.value = '0';" />Community ACL Groups, Roles, Functions and access restrictions.</label><br />
					<input type="hidden" name="cacl_grf" value="<?php echo $config->cacl_grf;?>" />
				</td>
			</tr>
			</table>
		</fieldset>
		<?php //} ?>

		<?php
		echo $pane->endPanel();
		echo $pane->startPanel( JText::_( 'Invalid Access' ), 'Content' );
		?>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Invalid Access' ); ?></legend>
			<table class="admintable">
			<tr>
				<td  class="key"  valign="top" align="right"><?php echo JText::_( 'Redirect URL' ); ?>
				</td>
				<td valign="top" align="left"><input type="text" size="100" name="redirect_url" value="<?php echo $config->redirect_url; ?>"  />
				</td>
			</tr>
			<tr>
				<td  class="key"  valign="top" align="right"><?php echo JText::_( 'Redirect URL (Administration)' ); ?>
				</td>
				<td valign="top" align="left"><input type="text" size="100" name="admin_redirect_url" value="<?php echo $config->admin_redirect_url; ?>"  />
				</td>
			</tr>

			<tr>
				<td  class="key"  valign="top" align="right"><?php echo JText::_( 'Forbidden content' ); ?>
				</td>
				<td valign="top" align="left"><?php echo $lists['forbidden_content']; ?>
				</td>
			</tr>

			<!-- // No Access Message  // -->
			<!-- <tr>
				<td  class="key"  valign="top" align="right"><?php echo JText::_( 'No Access Message' ); ?>
				</td>
				<td valign="top" align="left"><input type="text" size="100" name="no_access_msg" value="<?php echo @$no_access_msg; ?>"  />
				</td>
			</tr>
			-->
			</table>
		</fieldset>
		<?php
		echo $pane->endPanel();

		$user =& JFactory::getUser();
		$cb_id = $user->gid;
		$frontendPath  = JPATH_ROOT . DS . 'components' .  DS;
		$comprofiler_filepath = $frontendPath."com_comprofiler/plugin/user/index.html";

		if($cb_id == 25){
			if($lists['show_membership_tab'] == 'true' || file_exists($comprofiler_filepath)){
			echo $pane->startPanel( JText::_( 'Registration Membership Types' ), 'Content' );
				?>
					<table class="adminlist" cellpadding="1">
						<thead>
						<script language="javascript" type="text/javascript">
							/* <![CDATA[ */
							function renum_table_rows(tbl_elem) {
									if (tbl_elem.rows[0]) {
										var count = 1;
										var row_k = 1 - 1%2;
										for (var i=0; i<tbl_elem.rows.length; i++) {
											tbl_elem.rows[i].cells[0].innerHTML = count;
											tbl_elem.rows[i].className = 'row'+row_k;
											count++;
											row_k = 1 - row_k;
										}
									}
								}
								function delete_row(element) {
									var del_index = element.parentNode.parentNode.sectionRowIndex;
									element.parentNode.parentNode.parentNode.deleteRow(del_index);
									var tbody = jQuery('tbody2#list_body2').get(0);
									renum_table_rows(tbody);
								}
								function addMemberRow() {
									var member_list = jQuery('text#new_member').text();

									var tbody = jQuery('tbody#list_body2').get(0);

									var row = document.createElement("TR");

									var cell0 = document.createElement("TD");
									cell0.innerHTML = '0';

									var cell1 = document.createElement("TD");
									cell1.innerHTML = document.getElementById('new_member').value;
									var input_hidden = document.createElement("input");
									input_hidden.type = 'hidden';
									input_hidden.name = 'member_desc[]';
									input_hidden.value = document.getElementById('new_member').value;
									cell1.appendChild(input_hidden);

									var cell2 = document.createElement("TD");
									cell2.innerHTML = '<a href="javascript: void(0);" onClick="javascript:delete_row(this); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete" /></a>';
									cell2.align = "center";


									row.appendChild(cell0);
									row.appendChild(cell1);
									row.appendChild(cell2);
									tbody.appendChild(row);
									renum_table_rows(tbody);

									document.getElementById('new_member').value = "";
								}
							/* ]]> */
							</script>

							<tr>
								<th width="2%" class="title">
									<?php echo JText::_( 'NUM' ); ?>
								</th>
								<th class="title" width="auto">
									<?php echo JText::_( 'Membership Type' ); ?>
								</th>
								<th class="title" width="auto">
									<?php echo JText::_( 'Add' ); ?>
								</th>
							</tr>
					</thead>
					<tbody id="list_body2">
						<?php
						$k = 1;

						foreach($lists['membership'] as $users) {?>
						<tr class="row<?php echo $k; ?>">
							<td >
								<?php echo $k; ?>
							</td>
							<td>
								<?php echo $users->text; ?>
								<input type="hidden" name="member_desc[]" value="<?php echo $users->text; ?>" />
							</td>
							<td >
								<a href="javascript: void(0);" onClick="javascript:delete_row(this); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>
							</td>
						</tr>
					<?php
							$k = 1 + $k;
					}?>
					</tbody>
					</table>
					<table class="adminform" cellspacing="1">
						<tr>
							<td><b>Enter new membership type below:</b></td>
						</tr>
						<tr>
							<td width="2%" valign="top" class="key">&nbsp;
								<input type="text" name="new_member" id="new_member" size="77" />
							</td>
							<td valign="top" class="key" width="25%">
								<input type="button" name="select_all" class="button" value="Add" onclick="javascript: if(document.getElementById('new_member').value != '') {addMemberRow(); } else alert('NO MEMBER=Can not add an empty field. Please enter a Membership Type.'); " />
							</td>
						</tr>

					</table>

				<?php
				echo $pane->endPanel();
			}

			# - Kobby's customization for the Bulk Add for CB/Joomla
			if(file_exists( $comprofiler_filepath ) || ($lists['show_membership_tab'] == 'true')){
			echo $pane->startPanel( JText::_( 'Registration' ), 'Content' );
			/* * /
			echo '<pre>';
			print_r($GLOBALS);
			echo '</pre>';
			/* */

			//print_r($lists);
				//$regis_pane =& JPane::getInstance('Tabs');
				/* * /
				echo $regis_pane->startPane("reg-pane");
					echo $regis_pane->startPanel( JText::_( 'Community Builder' ), 'la' );
					echo $regis_pane->endPanel();
					echo $regis_pane->startPanel( JText::_( 'JomSocial' ), 'la' );
					echo $regis_pane->endPanel();
				echo $regis_pane->endPane();
			    /* */
		?>
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Setup Details' ); ?></legend>
					<table class="adminlist" cellpadding="1">
						<script language="javascript" type="text/javascript">
							/* <![CDATA[ */
							var grouproles = new Array;
							<?php
							$i = 0;
							foreach ($lists['cacl_rid_arr'] as $k=>$v) {
								echo "grouproles[".$k++."] = new Array( '".addslashes( $v['group'] )."','".addslashes( $v['value'] )."','".addslashes( $v['text'] )."' );\n\t\t";
							}
							?>


							function renum_table_rows(tbl_elem) {
									if (tbl_elem.rows[0]) {
										var count = 1;
										var row_k = 1 - 1%2;
										for (var i=0; i<tbl_elem.rows.length; i++) {
											tbl_elem.rows[i].cells[0].innerHTML = count;
											tbl_elem.rows[i].className = 'row'+row_k;
											count++;
											row_k = 1 - row_k;
										}
									}
								}
								function delete_row(element) {
									var del_index = element.parentNode.parentNode.sectionRowIndex;
									element.parentNode.parentNode.parentNode.deleteRow(del_index);
									//var tbody = element.parentNode.parentNode;
									var tbody = jQuery('tbody#list_body').get(0);
									renum_table_rows(tbody);
								}
								function addRow() {

									var cacl_group_list = jQuery('select#cacl_group_list').get(0);
									var cacl_role_list = jQuery('select#cacl_role_list').get(0);
									var cacl_func_list = jQuery('select#cacl_func_list').get(0);
									if(jQuery('select#member_list').get(0) != undefined){
										var member_list = jQuery('select#member_list').get(0);
									}


									var tbody = jQuery('tbody#list_body').get(0);

									var row = document.createElement("TR");

									var cell0 = document.createElement("TD");
									cell0.innerHTML = '0';

									var cell1 = document.createElement("TD");
									cell1.innerHTML = cacl_group_list.options[cacl_group_list.selectedIndex].text;
									var input_hidden = document.createElement("input");
									input_hidden.type = 'hidden';
									input_hidden.name = 'cacl_group_id[]';
									input_hidden.value = cacl_group_list.options[cacl_group_list.selectedIndex].value;
									cell1.appendChild(input_hidden);

									var cell2 = document.createElement("TD");
									cell2.innerHTML = cacl_role_list.options[cacl_role_list.selectedIndex].text;
									var input_hidden = document.createElement("input");
									input_hidden.type = 'hidden';
									input_hidden.name = 'cacl_role_id[]';
									input_hidden.value = cacl_role_list.options[cacl_role_list.selectedIndex].value;
									cell2.appendChild(input_hidden);

									var cell3 = document.createElement("TD");
									cell3.innerHTML = cacl_func_list.options[cacl_func_list.selectedIndex].text;
									var input_hidden = document.createElement("input");
									input_hidden.type = 'hidden';
									input_hidden.name = 'cacl_func_id[]';
									input_hidden.value = cacl_func_list.options[cacl_func_list.selectedIndex].value;
									cell3.appendChild(input_hidden);

									if(jQuery('select#member_list').get(0) != undefined){
										var cell4 = document.createElement("TD");
										cell4.innerHTML = member_list.options[member_list.selectedIndex].text;
										var input_hidden = document.createElement("input");
										input_hidden.type = 'hidden';
										input_hidden.name = 'member_list_id[]';
										input_hidden.value = member_list.options[member_list.selectedIndex].value;
										cell4.appendChild(input_hidden);
									}

									var cell5 = document.createElement("TD");
										cell5.innerHTML = '<a href="javascript: void(0);" onClick="javascript:delete_row(this); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>';
										cell5.align = "center";


									row.appendChild(cell0);
									row.appendChild(cell1);
									row.appendChild(cell2);
									row.appendChild(cell3);
									if(jQuery('select#member_list').get(0) != undefined){
										row.appendChild(cell4);
									}
									row.appendChild(cell5);
									tbody.appendChild(row);
									renum_table_rows(tbody);
								}
							/* ]]> */
							</script>
						<thead>
							<tr>
								<th width="2%" class="title">
									<?php echo JText::_( 'NUM' ); ?>
								</th>
								<th class="title" width="26%">
									<?php echo JText::_( 'Group' ); ?>
								</th>
								<th class="title" width="22%">
									<?php echo JText::_( 'Role' ); ?>
								</th>
								<th class="title" width="22%">
									<?php echo JText::_( 'Function' ); ?>
								</th>
								<?php if($lists['member_list'] != JText::_( 'Belongs to no membership type' )) { ?>
								<th class="title" width="22%">
									<?php echo JText::_( 'Memebership Type' ); ?>
								</th>
								<?php } ?>
								<th class="title" width="auto">
									<?php echo JText::_( 'Delete' ); ?>
								</th>
							</tr>
						</thead>
					<tbody id="list_body">
					<?php
					$i = 1;
					$k = 0;



					if (is_array($lists['cacl_cb_users']) && count($lists['cacl_cb_users']))
						foreach($lists['cacl_cb_users'] as $users) {?>
						<tr class="row<?php echo $k; ?>">
							<td >
								<?php echo $i++; ?>
							</td>
							<td >
								<?php echo $users->g_name; ?>
								<input type="hidden" name="cacl_group_id[]" value="<?php echo $users->group_id; ?>" />
							</td>
							<td >
								<?php echo $users->r_name; ?>
								<input type="hidden" name="cacl_role_id[]" value="<?php echo $users->role_id; ?>" />
							</td>
							<td >
								<?php echo (@$users->function_id > 0  ? $users->f_name: JText::_( 'None' )); ?>
								<input type="hidden" name="cacl_func_id[]" value="<?php echo $users->function_id; ?>" />
							</td>
							<?php if($lists['member_list'] != JText::_( 'Belongs to no membership type' )) { ?>
							<td>
								<?php if($users->member_type != '') {echo $users->member_type;} else {echo JText::_( 'Belongs to no membership type' );}  ?>
								<input type="hidden" name="member_list_id[]" value="<?php echo $users->member_id; ?>" />
							</td>
							<?php } ?>
							<td >
								<a href="javascript: void(0);" onClick="javascript:delete_row(this); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>
							</td>
						</tr>
					<?php
							$k = 1 - $k;
						}?>
					</tbody>
					</table>
						<table class="adminform" cellspacing="1">
						<tr>
							<td width="2%" valign="top" class="key">&nbsp;

							</td>
							<td valign="top" class="key" width="26%">
								<?php echo $lists['cacl_gid']; ?>
							</td>
							<td valign="top" class="key" width="22%">
								 <?php echo $lists['cacl_rid']; ?>
							</td>
							<td valign="top" class="key" width="22%">
								<?php echo $lists['cacl_fid']; ?>
							</td>
							<?php if($lists['member_list'] != JText::_( 'Belongs to no membership type' )) { ?>
							<td valign="top" class="key" width="22%">
								<?php echo  $lists['member_list']; ?>
							</td>
							<?php } ?>
							<td valign="top" class="key" width="auto">
								<input <?php if ($lists['cacl_gid'] == JText::_( 'There is no groups' ) || $lists['cacl_rid'] == JText::_( 'There is no roles' ) || $lists['cacl_fid'] == JText::_( 'There is no functions' ) || $lists['cacl_rid'] == JText::_( 'None' ) || $lists['cacl_rid'] == JText::_( 'hjkhk' )) echo ' disabled="disabled" ';?>type="button" name="select_all" class="button" value="Add"
									onclick="javascript:  s = document.getElementById('cacl_group_list');  if(s.options[s.options.selectedIndex].text != 'None') {addRow(); } else alert('NO ROLE=Can not add Groups with no roles. Please add a role to this group before attempting to add'); " />
							</td>
						</tr>
				</table>
			</fieldset>
			<!--  <fieldset class="adminform">
				<legend><?php echo JText::_( 'JomSocial' ); ?></legend>
					<table class="admintable">
						<tr>
							<td  class="key"  valign="top" align="right"><?php echo JText::_( 'Redirect URL' ); ?>
							</td>
							<td valign="top" align="left"><input type="text" size="100" name="redirect_url" value="<?php echo $config->redirect_url; ?>"  />
							</td>
						</tr>
					</table>
				</fieldset> -->
		<?php
			echo $pane->endPanel();
		}
		}
		echo $pane->endPane();
			?>
			<input type="hidden" name="option" value="com_community_acl" />
			<input type="hidden" name="task" value="config" />
			<input type="hidden" name="redirect" value="about" />
			<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
		left_menu_footer();
	}

	function show_sites( &$rows, $option ){

		JHTML::_('behavior.tooltip');
		left_menu_header();
		?>
		<form action="index.php?option=com_community_acl&amp;task=list_sites" method="post" name="adminForm">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="10" align="left">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th width="20">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
				</th>
				<th class="title" width="15%">
					<?php echo JText::_( 'Name' ); ?>
				</th>
				<th width="5%">
					<?php echo JText::_( 'Main Site' ); ?>
				</th>
				<th width="5%">
					<?php echo JText::_( 'Published' ); ?>
				</th>
				<th class="title" width="15%">
					<?php echo JText::_( 'DB host' ); ?>
				</th>
				<th class="title" width="15%">
					<?php echo JText::_( 'DB name' ); ?>
				</th>
				<th class="title" width="15%">
					<?php echo JText::_( 'DB user' ); ?>
				</th>
				<th class="title" width="15%">
					<?php echo JText::_( 'Table prefix' ); ?>
				</th>
				<th class="title" width="8%">
					<?php echo JText::_( 'DB Status' ); ?>
				</th>
				<th width="auto">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$k = 0;
		if( count( $rows ) ) {
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	= &$rows[$i];
			$link = 'index.php?option=com_community_acl&amp;task=site_edit&amp;cid[]='. $row->id ;
			$row -> checked_out = 1;
			$row -> published = $row -> enabled;
			$checked 	= JHTML::_('grid.checkedout' ,   $row, $i );
			$status 	= ($row->_is_connected? 'tick.png': 'publish_x.png');
			$status_alt	= ($row->_is_connected? 'Yes': 'No');
			$published 	= JHTML::_('grid.published', $row, $i, $imgY = 'tick.png', $imgX = 'publish_x.png', $prefix='site_' );
			//JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES );
		?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1; ?>
				</td>
				<td>
					<?php echo $checked; ?>
				</td>
				<td>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'Description' );?>::<?php echo $row->description; ?>">
					<a href="<?php echo JRoute::_( $link ); ?>">
							<?php echo $row->name; ?></a>
					</span>
				</td>
				<td align="center">
					<?php if ($row->is_main > 0) {?>
						<img border="0" alt="Published" src="images/tick.png" />
					<?php } else {?>
						<a title="<?php echo JText::_( 'Set as main' );?>" href="index.php?option=com_community_acl&amp;task=set_main&amp;cid[]=<?php echo $row->id;?>">
							<img border="0" alt="Published" src="images/publish_x.png" />
						</a>
					<?php }?>
				</td>
				<td align="center">
					<?php echo $published;?>
				</td>
				<td>
					<?php echo $row->db_host;?>
				</td>
				<td>
					<?php echo $row->db_name;?>
				</td>
				<td>
					<?php echo $row->db_user;?>
				</td>
				<td>
					<?php echo $row->db_prefix;?>
				</td>
				<td align="center">
					<?php if ($row->check_db()) {?>
						<img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/administrator/images/<?php echo $status;?>" alt="<?php echo $status_alt;?>" border="0" title=""  />
					<?php } else {?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'DB Message' );?>::<?php echo $row->getError(); ?>">
					<a href="#"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/administrator/images/<?php echo $status;?>" alt="<?php echo $status_alt;?>" border="0" title=""  />
							</a>
					</span>
					<?php } ?>
				</td>
				<td width="auto">&nbsp;</td>
			</tr>
		<?php }
		} else {
				?>
				<tr><td colspan="11"><?php echo JText::_('There are no Sites'); ?></td></tr>
				<?php
		}
		?>
		</tbody>
		</table>

		<input type="hidden" name="option" value="com_community_acl" />
		<input type="hidden" name="task" value="list_sites" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
		left_menu_footer();
	}

	function requirements(){
		left_menu_header();//header
		$link = rtrim( JURI::root() , '/' ) . '/administrator/index.php?option=com_community_acl&amp;task=install&amp;step=2';
		?>
			<table width="100%" border="0">
				<tr>
					<td>
						<b>Requirements</b>
							<ul>
								<li>PHP 5.X.X</li>
								<li>Joomla 1.5.X</li>
								<li>Computer</li>
							</ul>
					</td>
				</tr>
				<tr>
					<td>
						<input type="button" class="button-next" onclick="window.location = '<?php echo $link; ?>'" value="<?php echo JText::_('Next');?>"/>
					</td>
				</tr>
			</table>
		<?php
		left_menu_footer();//footer
	}

	function installJoomla_Plugin(){
		left_menu_header();//header
		$link = rtrim( JURI::root() , '/' ) . '/administrator/index.php?option=com_community_acl&amp;task=install&amp;step=3';
		?>
			<table width="100%" border="0">
				<tr>
					<td>
						Install Joomla! Plugin.
					</td>
				</tr>
				<tr>
					<td>
						<input type="button" class="button-next" onclick="window.location = '<?php echo $link; ?>'" value="<?php echo JText::_('Next');?>"/>
					</td>
				</tr>
			</table>
		<?php
		left_menu_footer();//footer
	}

	function installCommunity_Builder(){
		left_menu_header();//header

		$yes_link = rtrim( JURI::root() , '/' ) . '/administrator/index.php?option=com_community_acl&amp;task=install&amp;step=3&amp;install_cb=Yes';
		$no_link = rtrim( JURI::root() , '/' ) . '/administrator/index.php?option=com_community_acl&amp;task=install&amp;step=4';
		?>
			<table width="100%" border="0">
				<tr>
					<td>
						Install Community Builder Plugin
					</td>
				</tr>
				<tr>
					<td>
						<input type="button" class="button-yes" onclick="window.location = '<?php echo $no_link; ?>'" value="<?php echo JText::_('Yes');?>"/>
					</td>
					<td>
						<input type="button" class="button-no" onclick="window.location = '<?php echo $no_link; ?>'" value="<?php echo JText::_('No');?>"/>
					</td>
				</tr>
			</table>
		<?php
		left_menu_footer();//footer
	}

	function installPatch_Files(){
		left_menu_header();//header
		$link = rtrim( JURI::root() , '/' ) . '/administrator/index.php?option=com_community_acl&amp;task=install&amp;step=5';
		?>
			<table width="100%" border="0">
				<tr>
					<td>
						Install Patch Files.
					</td>
				</tr>
				<tr>
					<td>
						<input type="button" class="button-next" onclick="window.location = '<?php echo $link; ?>'" value="<?php echo JText::_('Next');?>"/>
					</td>
				</tr>
			</table>
		<?php
		left_menu_footer();//footer
	}

	function finish_installation(){
		left_menu_header();//header
		$link = rtrim( JURI::root() , '/' ) . '/administrator/index.php?option=com_community_acl';
		?>
			<table width="100%" border="0">
				<tr>
					<td>
						Finish.
					</td>
				</tr>
				<tr>
					<td>
						<input type="button" class="button-finish" onclick="window.location = '<?php echo $link; ?>'" value="<?php echo JText::_('Finish');?>"/>
					</td>
				</tr>
			</table>
		<?php
		left_menu_footer();//footer
	}

	function edit_site(&$row, &$lists) {
		left_menu_header();
		?>
		<script language="javascript" type="text/javascript">
		/* <![CDATA[ */
			function check_db() {
				jQuery('div#db_status').get(0).innerHTML = '<?php echo JText::_( 'Wait... Checking...' ); ?>';
				var db_host = jQuery('input#db_host').get(0).value;
				var db_name = jQuery('input#db_name').get(0).value;
				var db_user = jQuery('input#db_user').get(0).value;
				var db_password = jQuery('input#db_password').get(0).value;
				var db_prefix = jQuery('input#db_prefix').get(0).value;
				jQuery('div#db_status').load('<?php echo substr_replace(JURI::root(), '', -1, 1);?>/administrator/index3.php?no_html=1&option=com_community_acl&amp;task=check_db&amp;db_host='+db_host+'&amp;db_name='+db_name+'&amp;db_user='+db_user+'&amp;db_password='+db_password+'&amp;db_prefix='+db_prefix);
			}
		/* ]]> */
		</script>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Site Details' ); ?></legend>
		<form action="index.php?option=com_community_acl&amp;task=site_edit" method="post" name="adminForm">
		<table width="100%" class="adminform">
		<tr>
			<td align="right" width="10%"><?php echo JText::_('Name'); ?>:</td>
			<td width="10%" colspan="2"><input class="inputbox" type="text" name="name" size="50" value="<?php echo $row->name; ?>" />&nbsp;<small><?php echo JText::_('Name is URL of your site.'); ?></small></td>
			<td width="15%" valign="top" rowspan="3">
				<input type="button" name="check" value="<?php echo JText::_('Check DB Details'); ?>" onclick="javascript: check_db();" />
				<div id="db_status">
				</div>
			</td>
		</tr>
		<tr>
				<td align="right" width="10%"><?php echo JText::_('Published'); ?>: </td>
				<td colspan="2"><?php echo $lists['published'];?> </td>
		</tr>
		<tr>
			<td align="right" width="10%" valign="top"><?php echo JText::_('Description'); ?>:</td>
			<td width="10%"><textarea name="description" cols="60" rows="10" ><?php echo $row->description; ?></textarea></td>
			<td valign="middle" style="vertical-align:top;"  align="left"><small><?php echo JText::_('Description of your site.'); ?></small></td>
		</tr>
		</table>

		<table width="100%" class="adminform">
		<tr>
			<th colspan="3"><?php echo JText::_( 'MySQL DB details' ); ?></th>
		</tr>
		<tr>
			<td align="right" width="12%"><?php echo JText::_( 'Database host' ); ?>:</td>
			<td width="12%" ><input class="inputbox" type="text" name="db_host" id="db_host" size="50" value="<?php echo $row->db_host; ?>" /></td>
			<td valign="middle" style="vertical-align:middle;"><small><?php echo JText::_('A database host of your site. If a database is located on the same hosting as your main site - try to fill <b>localhost</b> here. Contact your ISP for details.'); ?></small></td>
		</tr>
		<tr>
			<td align="right"><?php echo JText::_( 'Database name' ); ?>:</td>
			<td><input class="inputbox" type="text" name="db_name" id="db_name" size="50" value="<?php echo $row->db_name;?>" /></td>
			<td valign="middle" style="vertical-align:middle;"><small><?php echo JText::_( 'Name of the database your site is using.' ); ?></small></td>
		</tr>
		<tr>
			<td align="right"><?php echo JText::_( 'Database user' ); ?>:</td>
			<td><input class="inputbox" type="text" name="db_user" id="db_user" size="50" value="<?php echo $row->db_user;?>" /></td>
			<td valign="middle" style="vertical-align:middle;"><small><?php echo JText::_( 'Database user name, which have rights to connect to database. Contact your ISP for details' ); ?></small></td>
		</tr>
		<tr>
			<td align="right"><?php echo JText::_( 'Database password' ); ?>:</td>
			<td><input class="inputbox" type="text" name="db_password" id="db_password" size="50" value="<?php echo $row->db_password;?>" /></td>
			<td valign="middle" style="vertical-align:middle;"><small><?php echo JText::_( 'A database password. Contact your ISP for details.' ); ?></small></td>
		</tr>
		<tr>
			<td align="right"><?php echo JText::_( 'Tables prefix' ); ?>:</td>
			<td><input class="inputbox" type="text" name="db_prefix" id="db_prefix" size="5" value="<?php echo $row->db_prefix;?>" /></td>
			<td valign="middle" style="vertical-align:middle;"><small><?php echo JText::_( 'Select a tables prefix for this site. Usually it is `jos_`.' ); ?></small></td>
		</tr>
		</table>

		<br />
		<input type="hidden" name="option" value="com_community_acl" />
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="redirect" value="list_sites" />
		</form>
		</fieldset>
		<?php
		left_menu_footer();
	}

	function show_groups( &$rows, &$page ){
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');

		JHTML::_('behavior.tooltip');
		left_menu_header();
		$db =& JFactory::getDBO();
		$config = new CACL_config($db);
		$config->load();

		?>
		<form action="index.php?option=com_community_acl&amp;task=list_groups" method="post" name="adminForm">
		<table class="adminlist">
		<thead>
			<tr>
				<th  align="center" width="2%">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th align="center" width="5%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
				</th>
				<th align="left" width="15%" >
					<?php echo JText::_( 'Name' ); ?>
				</th>
				<th width="5%">
					<?php echo JText::_( 'Published' ); ?>
				</th>
				<?php if ($config->synchronize) { ?>
				<th width="5%">
					<?php echo JText::_( 'Synchronize' ); ?>
				</th>
				<?php } ?>
				<th width="25%" align="left">
					<?php echo JText::_( 'Tools' ); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
		<tr>
			<td colspan="7">
				<?php echo $page->getListFooter(); ?>
			</td>
		</tr>
		</tfoot>
		<tbody>
		<?php
		$k = 0;
		if( count( $rows ) ) {
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	= &$rows[$i];
			$link = 'index.php?option=com_community_acl&amp;task=list_roles&amp;group_id='. $row->id ;
			$row -> checked_out = 1;
			$row -> published = $row -> enabled;
			$checked 	= JHTML::_('grid.checkedout',   $row, $i );
			$published 	= JHTML::_('grid.published', $row, $i, $imgY = 'tick.png', $imgX = 'publish_x.png', $prefix='group_' );


			$img 	= $row->dosync ? $imgY : $imgX;
			$listItemTask 	= $row->dosync ? 'group_unsync' : 'group_sync';
			$alt 	= $row->dosync ? JText::_( 'Synchronized' ) : JText::_( 'Not Synchronized' );

			$dosync = '
			<a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $listItemTask .'\')" title="">
			<img src="images/'. $img .'" border="0" alt="'. $alt .'" /></a>'
			;


			JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES );

		?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="center" width="2%">
					<?php echo $page->getRowOffset( $i ); ?>
				</td>
				<td align="center" width="5%">
					<?php echo $checked; ?>
				</td>
				<td>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'Description' );?>::<?php echo $row->description; ?>">
					<a href="<?php echo JRoute::_( $link ); ?>">
							<?php echo $row->name; ?></a>
					</span>
				</td>
				<td align="center">
					<?php echo $published;?>
				</td>
				<?php if ($config->synchronize) { ?>
				<td align="center">
					<?php echo $dosync;?>
				</td>
				<?php } ?>
				<td style="padding-left:10px; text-align:left;">
				<a href="index.php?option=com_community_acl&amp;task=group_edit&amp;cid[]=<?php echo $row->id;?>">[<?php echo JText::_( 'Edit' );?>]</a>&nbsp;&nbsp;
				<a href="index.php?option=com_community_acl&amp;task=show_access&amp;mode=group_id&amp;cid[]=<?php echo $row->id;?>">[<?php echo JText::_( 'Set access' );?>]</a>&nbsp;&nbsp;
				<a href="index.php?option=com_community_acl&amp;task=add_users_access&amp;mode=group_id&amp;cid[]=<?php echo $row->id;?>">[<?php echo JText::_( 'Add users' );?>]</a>&nbsp;&nbsp;
				<a href="index.php?option=com_community_acl&amp;task=delete_users_access&amp;mode=group_id&amp;cid[]=<?php echo $row->id;?>">[<?php echo JText::_( 'Remove users' );?>]</a>
				</td>

			</tr>
		<?php }
		} else {
				?>
				<tr><td colspan="7"><?php echo JText::_('There are no Groups'); ?></td></tr>
				<?php
		}
		?>
		</tbody>
		</table>

		<input type="hidden" name="option" value="com_community_acl" />
		<input type="hidden" name="task" value="list_groups" />
		<input type="hidden" name="mode" value="group_id" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
		left_menu_footer();
	}

	function edit_group( &$row ) {
		JRequest::setVar( 'hidemainmenu', 1 );
		JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES, 'description' );
		left_menu_header();
		?>
		<script language="javascript" type="text/javascript">
		/* <![CDATA[ */
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			if ( form.name.value == "" ) {
				alert("<?php echo JText::_( 'Group must have a name'); ?>");
			} else {
				submitform(pressbutton);
			}
		}
		/* ]]> */
		</script>

		<form action="index.php" method="post" name="adminForm">
		<div class="col width-60">
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Details' ); ?></legend>

					<table class="admintable">
					<tr>
						<td class="key">
							<label for="title" width="100">
								<?php echo JText::_( 'Name' ); ?>:
							</label>
						</td>
						<td colspan="2">
							<input class="text_area" type="text" name="name" id="name" value="<?php echo $row->name; ?>" size="50" maxlength="50" title="<?php echo JText::_( 'A name of group' ); ?>" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="title" width="100">
								<?php echo JText::_( 'Synchronize' ); ?>:
							</label>
						</td>
						<td colspan="2">
							<?php echo JHTML::_('select.booleanlist',  'dosync', 'class="inputbox"', $row->dosync );?>
						</td>
					</tr>
					<tr>
						<td class="key" style="vertical-align:top;">
							<label for="alias">
								<?php echo JText::_( 'Description' ); ?>:
							</label>
						</td>
						<td colspan="2">
							<textarea name="description" cols="60" rows="10" ><?php echo $row->description; ?></textarea>
						</td>
					</tr>
					</table>
			</fieldset>
		</div>
		<input type="hidden" name="option" value="com_community_acl" />
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="redirect" value="list_groups" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
		left_menu_footer();
	}

	function show_roles( &$rows, &$page, &$lists, $group_id ){
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');
		$db		 =& JFactory::getDBO();
		$config = new CACL_config($db);
		$config->load();
		JHTML::_('behavior.tooltip');
		left_menu_header();
		$ordering = ($group_id > 0);
		?>
		<form action="index.php?option=com_community_acl&amp;task=list_roles" method="post" name="adminForm">
		<table>
			<tr>
				<td align="left" width="100%">&nbsp;

				</td>
				<td nowrap="nowrap">
					<?php
						echo $lists['group_id'];
					?>
				</td>
			</tr>
		</table>

		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="center">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th width="5%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
				</th>
				<th width="15%" align="left">
					<?php echo JText::_( 'Name' ); ?>
				</th>
				<th width="5%">
					<?php echo JText::_( 'Published' ); ?>
				</th>
				<?php if ($config->synchronize) { ?>
				<th width="5%">
					<?php echo JText::_( 'Synchronize' ); ?>
				</th>
				<?php } ?>
				<!--  th width="12%" nowrap="nowrap">
					<?php //echo JText::_( 'Ordering' ); ?>
					<?php //echo JHTML::_('grid.order',  $rows , $image='filesave.png', $task="role_saveorder"); ?>
				</th -->
				<th align="left" width="15%" style="padding-left:5px;">
					<?php echo JText::_( 'Group' ); ?>
				</th>
				<th width="35%" align="left">
					<?php echo JText::_( 'Tools' ); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
		<tr>
			<td colspan="9">
				<?php echo $page->getListFooter(); ?>
			</td>
		</tr>
		</tfoot>
		<tbody>
		<?php
		$k = 0;
		if( count( $rows ) ) {
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	= &$rows[$i];
			$link = 'index.php?option=com_community_acl&amp;task=role_edit&amp;cid[]='. $row->id ;
			$row -> checked_out = 1;
			$row -> published = $row -> enabled;
			$checked 	= JHTML::_('grid.checkedout',   $row, $i );
			$published 	= JHTML::_('grid.published', $row, $i, $imgY = 'tick.png', $imgX = 'publish_x.png', $prefix='role_' );

			$img 	= $row->dosync ? $imgY : $imgX;
			$listItemTask 	= $row->dosync ? 'role_unsync' : 'role_sync';
			$alt 	= $row->dosync ? JText::_( 'Synchronized' ) : JText::_( 'Not Synchronized' );

			$dosync = '
			<a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $listItemTask .'\')" title="">
			<img src="images/'. $img .'" border="0" alt="'. $alt .'" /></a>'
			;

			JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES );

		?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="center">
					<?php echo $page->getRowOffset( $i ); ?>
				</td>
				<td align="center">
					<?php echo $checked; ?>
				</td>
				<td>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'Description' );?>::<?php echo $row->description; ?>">
					<a href="<?php echo JRoute::_( $link ); ?>">
							<?php echo $row->name; ?></a>
					</span>
				</td>
				<td align="center">
					<?php echo $published;?>
				</td>
				<?php if ($config->synchronize) { ?>
				<td align="center">
					<?php echo $dosync;?>
				</td>
				<?php } ?>
				<!-- td class="order">
					<span><?php echo $page->orderUpIcon( $i, ($row->group_id == @$rows[$i-1]->group_id), 'role_orderup', 'Move Up', $ordering ); ?></span>
					<span><?php echo $page->orderDownIcon( $i, $n, ($row->group_id == @$rows[$i+1]->group_id), 'role_orderdown', 'Move Down', $ordering ); ?></span>
					<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
					<input type="text" name="order[]" size="4" value="<?php echo $row->ordering; ?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
				</td -->
				<td>
					<?php echo $row->group_name;?>
				</td>
				<td style="padding-left:10px; text-align:left;">
					<a href="index.php?option=com_community_acl&amp;task=role_edit&amp;cid[]=<?php echo $row->id;?>">[<?php echo JText::_( 'Edit' );?>]</a>&nbsp;&nbsp;
					<a href="index.php?option=com_community_acl&amp;task=show_access&amp;mode=role_id&amp;cid[]=<?php echo $row->id;?>">[<?php echo JText::_( 'Set access' );?>]</a>&nbsp;&nbsp;
					<a href="index.php?option=com_community_acl&amp;task=add_users_access&amp;mode=role_id&amp;cid[]=<?php echo $row->id;?>">[<?php echo JText::_( 'Add users' );?>]</a>&nbsp;&nbsp;
					<a href="index.php?option=com_community_acl&amp;task=delete_users_access&amp;mode=role_id&amp;cid[]=<?php echo $row->id;?>">[<?php echo JText::_( 'Remove users' );?>]</a>
				</td>
			</tr>
		<?php }
		} else {
				?>
				<tr><td colspan="9"><?php echo JText::_('There are no Roles'); ?></td></tr>
				<?php
		}
		?>
		</tbody>
		</table>

		<input type="hidden" name="option" value="com_community_acl" />
		<input type="hidden" name="task" value="list_roles" />
		<input type="hidden" name="mode" value="role_id" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
		left_menu_footer();
	}

	function edit_role( &$row, &$lists ) {
		JRequest::setVar( 'hidemainmenu', 1 );
		JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES, 'description' );
		left_menu_header();
		?>
		<script language="javascript" type="text/javascript">
		/* <![CDATA[ */
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			if ( form.name.value == "" ) {
				alert("<?php echo JText::_( 'Role must have a name'); ?>");
			} else {
				submitform(pressbutton);
			}
		}
		/* ]]> */
		</script>

		<form action="index.php" method="post" name="adminForm">
		<div class="col width-60">
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Details' ); ?></legend>

					<table class="admintable">
					<tr>
						<td class="key">
							<label for="title" width="100">
								<?php echo JText::_( 'Name' ); ?>:
							</label>
						</td>
						<td colspan="2">
							<input class="text_area" type="text" name="name" id="name" value="<?php echo $row->name; ?>" size="50" maxlength="50" title="<?php echo JText::_( 'A name of role' ); ?>" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="title" width="100">
								<?php echo JText::_( 'Group' ); ?>:
							</label>
						</td>
						<td colspan="2">
							<?php echo $lists['group_id'];?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="title" width="100">
								<?php echo JText::_( 'Synchronize' ); ?>:
							</label>
						</td>
						<td colspan="2">
							<?php echo JHTML::_('select.booleanlist',  'dosync', 'class="inputbox"', $row->dosync );?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="title" width="100">
								<?php echo JText::_( 'Ordering' ); ?>:
							</label>
						</td>
						<td colspan="2">
							<?php echo $lists['ordering'];?>
						</td>
					</tr>
					<tr>
						<td class="key" style="vertical-align:top;">
							<label for="alias">
								<?php echo JText::_( 'Description' ); ?>:
							</label>
						</td>
						<td colspan="2">
							<textarea name="description" cols="60" rows="10" ><?php echo $row->description; ?></textarea>
						</td>
					</tr>
					</table>
			</fieldset>
		</div>
		<input type="hidden" name="option" value="com_community_acl" />
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="redirect" value="list_roles" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
		left_menu_footer();
	}

	function show_functions( &$rows, &$page, &$lists, $group_id ){
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');
		$db			=& JFactory::getDBO();
		$config 	= new CACL_config($db);
		$config->load();
		JHTML::_('behavior.tooltip');
		left_menu_header();

		?>
		<form action="index.php?option=com_community_acl&amp;task=list_functions" method="post" name="adminForm">
		<!--
		<table>
			<tr>
				<td align="left" width="100%">&nbsp;

				</td>
				<td nowrap="nowrap">
					<?php
						echo $lists['group_id'];
					?>
				</td>
			</tr>
		</table>
		-->
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th width="5%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
				</th>
				<th align="left" width="15%">
					<?php echo JText::_( 'Name' ); ?>
				</th>
				<th width="5%">
					<?php echo JText::_( 'Published' ); ?>
				</th>
				<?php if ($config->synchronize){?>
				<th width="5%">
					<?php echo JText::_( 'Synchronize' ); ?>
				</th>
				<?php } ?>
				<!--
				<th width="8%" nowrap="nowrap">
					<?php echo JText::_( 'Ordering' ); ?>
					<?php echo JHTML::_('grid.order',  $rows , $image='filesave.png', $task="function_saveorder"); ?>
				</th>
				-->
				<th width="35%" align="left">
					<?php echo JText::_( 'Tools' ); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
		<tr>
			<td colspan="7">
				<?php echo $page->getListFooter(); ?>
			</td>
		</tr>
		</tfoot>
		<tbody>
		<?php
		$k = 0;
		if( count( $rows ) ) {
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	= &$rows[$i];
			$link = 'index.php?option=com_community_acl&amp;task=function_edit&amp;cid[]='. $row->id ;
			$row -> checked_out = 1;
			$row -> published = $row -> enabled;
			$checked 	= JHTML::_('grid.checkedout',   $row, $i );
			$published 	= JHTML::_('grid.published', $row, $i, $imgY = 'tick.png', $imgX = 'publish_x.png', $prefix='function_' );

			$img 	= $row->dosync ? $imgY : $imgX;
			$listItemTask 	= $row->dosync ? 'function_unsync' : 'function_sync';
			$alt 	= $row->dosync ? JText::_( 'Synchronized' ) : JText::_( 'Not Synchronized' );

			$dosync = '
			<a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $listItemTask .'\')" title="">
			<img src="images/'. $img .'" border="0" alt="'. $alt .'" /></a>'
			;

			JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES );

		?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $page->getRowOffset( $i ); ?>
				</td>
				<td align="center">
					<?php echo $checked; ?>
				</td>
				<td>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'Description' );?>::<?php echo $row->description; ?>">
					<a href="<?php echo JRoute::_( $link ); ?>">
							<?php echo $row->name; ?></a>
					</span>
				</td>
				<td align="center">
					<?php echo $published;?>
				</td>
				<?php if ($config->synchronize){?>
				<td align="center">
					<?php echo $dosync;?>
				</td>
				<?php } ?>
				<!--
				<td class="order">
					<span><?php echo $page->orderUpIcon( $i, ($row->group_id == @$rows[$i-1]->group_id), 'function_orderup', 'Move Up',@ $ordering ); ?></span>
					<span><?php echo $page->orderDownIcon( $i, $n, ($row->group_id == @$rows[$i+1]->group_id), 'function_orderdown', 'Move Down', @$ordering ); ?></span>
					<?php $disabled = @$ordering ?  '' : 'disabled="disabled"'; ?>
					<input type="text" name="order[]" size="4" value="<?php echo $row->ordering; ?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
				</td>
				-->
				<td style="padding-left:10px; text-align:left;">
					<a href="index.php?option=com_community_acl&amp;task=function_edit&amp;cid[]=<?php echo $row->id;?>">[<?php echo JText::_( 'Edit' );?>]</a>&nbsp;&nbsp;
					<a href="index.php?option=com_community_acl&amp;task=set_functions&amp;cid[]=<?php echo $row->id;?>">[<?php echo JText::_( 'Set actions' );?>]</a>
				</td>
			</tr>
		<?php }
		} else {
				?>
				<tr><td colspan="7"><?php echo JText::_('There are no Functions'); ?></td></tr>
				<?php
		}
		?>
		</tbody>
		</table>

		<input type="hidden" name="option" value="com_community_acl" />
		<input type="hidden" name="task" value="list_functions" />
		<input type="hidden" name="group_id" value="0" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
		left_menu_footer();
	}

	function edit_function( &$row, &$lists ) {
		JRequest::setVar( 'hidemainmenu', 1 );
		JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES, 'description' );
		left_menu_header();
		?>
		<script language="javascript" type="text/javascript">
		/* <![CDATA[ */
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			if ( form.name.value == "" ) {
				alert("<?php echo JText::_( 'Function must have a name'); ?>");
			} else {
				submitform(pressbutton);
			}
		}
		/* ]]> */
		</script>

		<form action="index.php" method="post" name="adminForm">
		<div class="col width-60">
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Details' ); ?></legend>

					<table class="admintable">
					<tr>
						<td class="key">
							<label for="title" width="100">
								<?php echo JText::_( 'Name' ); ?>:
							</label>
						</td>
						<td colspan="2">
							<input class="text_area" type="text" name="name" id="name" value="<?php echo $row->name; ?>" size="50" maxlength="50" title="<?php echo JText::_( 'A name of function' ); ?>" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="title" width="100">
								<?php echo JText::_( 'Synchronize' ); ?>:
							</label>
						</td>
						<td colspan="2">
							<?php echo JHTML::_('select.booleanlist',  'dosync', 'class="inputbox"', $row->dosync );?>
						</td>
					</tr>
					<!--
					<tr>
						<td class="key">
							<label for="title" width="100">
								<?php //echo JText::_( 'Group' ); ?>:
							</label>
						</td>
						<td colspan="2">
							<?php //echo $lists['group_id'];?>
						</td>
					</tr>

					<tr>
						<td class="key">
							<label for="title" width="100">
								<?php //echo JText::_( 'Ordering' ); ?>:
							</label>
						</td>
						<td colspan="2">
							<?php //echo $lists['ordering'];?>
						</td>
					</tr>
					-->
					<tr>
						<td class="key" style="vertical-align:top;">
							<label for="alias">
								<?php echo JText::_( 'Description' ); ?>:
							</label>
						</td>
						<td colspan="2">
							<textarea name="description" cols="60" rows="10" ><?php echo $row->description; ?></textarea>
						</td>
					</tr>
					</table>
			</fieldset>
		</div>
		<input type="hidden" name="option" value="com_community_acl" />
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="group_id" value="0" />
		<input type="hidden" name="ordering" value="1" />
		<input type="hidden" name="redirect" value="list_functions" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
		left_menu_footer();
	}

	function set_functions( $id, &$lists, $option ) {
		JRequest::setVar( 'hidemainmenu', 1 );

		$db	=& JFactory::getDBO();

		$query = "SELECT `value` FROM `#__community_acl_config` WHERE `name` = 'default_action' ";
		$db->setQuery($query);
		$default_action = $db->loadResult();

		if ($default_action == null)
			$default_action = 'deny';

		jimport('joomla.html.pane');
		JHTML::_('behavior.tooltip');
		$pane		=& JPane::getInstance('Tabs');

		left_menu_header();
		?>

		<script type="text/javascript">
		/* <![CDATA[ */
			var number = 9999;

			function check_id_in_table(id, tbody_id) {
				var tbody = jQuery('tbody#'+tbody_id).get(0);
				if (tbody.rows[0]) {
					for (var i = 0; i < tbody.rows.length; i++) {
						var children = tbody.rows[i].cells[1].childNodes;
						for (var j = 0; j < children.length; j++) {
							if (children[j].nodeName.toLowerCase() == 'input' && children[j].value == id) {
								return false;
							}
						}
					}
				}
				return true;
			}

			function renum_table_rows(tbl_elem) {
				if (tbl_elem.rows[0]) {
					var count = 1;
					var row_k = 1 - 1%2;
					for (var i=0; i<tbl_elem.rows.length; i++) {
						tbl_elem.rows[i].cells[0].innerHTML = count;
						tbl_elem.rows[i].className = 'row'+row_k;
						count++;
						row_k = 1 - row_k;
					}
				}
			}

			function delete_row(element, tbl) {
				var del_index = element.parentNode.parentNode.sectionRowIndex;
				element.parentNode.parentNode.parentNode.deleteRow(del_index);
				var tbody = jQuery('tbody#'+tbl).get(0);
				renum_table_rows(tbody);
			}

			function delete_row_t(element, tbl) {
				var del_index = element.parentNode.parentNode.sectionRowIndex;
				element.parentNode.parentNode.parentNode.deleteRow(del_index);
				var tbody = jQuery('tbody#'+tbl).get(0);
				renum_table_rows(tbody);
			}


			function delete_row_kv(element) {
				var del_index = element.parentNode.parentNode.sectionRowIndex;
				element.parentNode.parentNode.parentNode.deleteRow(del_index);
			}

			function addRow(tbl) {

				var listitem = jQuery('select#componentid').get(0);
				var hidden_name = 'component_id[]';

				var inputs = jQuery('tbody#key_value').find('input.inputbox');
				var boxes = jQuery('tbody#key_value').find('input.checkbox');
				var key = null;
				var value = null;
				var all_act = jQuery('input#all_act').get(0).checked;

				var front_end = jQuery('input#front_end').get(0).checked;
				var back_end = jQuery('input#back_end').get(0).checked;
				var tbody = jQuery('tbody#'+tbl).get(0);

				var grouping = 	++number;
				if (!all_act) {
					for (jj = 0; jj < inputs.length; jj++) {
						if (inputs[jj].value == '' ){
							alert('<?php echo JText::_( 'Enter both `key` and `value`.' ); ?>');
							return;
						}
					}

					var key_html = '';
					var value_html = '';

					for(var ii = 0; ii < inputs.length; ii=ii+2) {
						key = inputs[ii];
						value = inputs[ii+1];
						idd = key.id.substr(7);

						key_html = key_html + key.value + '<input type="hidden" name="key_name['+grouping+'][]" value="'+key.value+'" /><br/>';
						if (jQuery('input#any_value_'+idd).get(0).checked){
							value_html = value_html + value.value +' (<?php echo ($default_action == 'deny'? JText::_( 'Allow all values except this value' ):JText::_( 'Only allow this value' )); ?>)' + '<input type="hidden" name="value_name['+grouping+'][]" value="'+value.value+'" /><input type="hidden" name="extra_opt['+grouping+'][]" value="1" /><br/>';
						}
						else
							value_html = value_html + value.value + '<input type="hidden" name="value_name['+grouping+'][]" value="'+value.value+'" /><input type="hidden" name="extra_opt['+grouping+'][]" value="0" /><br/>';
						 key.value = '';
						 value.value = '';
					}
					for (jj = 0; jj < listitem.options.length; jj++) {
						if (listitem.options[jj].selected == true) {
							var row = document.createElement("TR");

							var cell0 = document.createElement("TD");
							cell0.innerHTML = '0';

							var cell1 = document.createElement("TD");
							cell1.innerHTML = listitem.options[jj].text+'<input type="hidden" name="grouping[]" value="'+grouping+'" />';
							var input_hidden = document.createElement("input");
							input_hidden.type = 'hidden';
							input_hidden.name = hidden_name;
							input_hidden.value = listitem.options[jj].value;
							cell1.appendChild(input_hidden);

							var cell2 = document.createElement("TD");
							cell2.innerHTML = key_html;
							cell2.appendChild(input_hidden);

							var cell3 = document.createElement("TD");
							cell3.innerHTML = value_html;

							cell3.appendChild(input_hidden);

							var cell4 = document.createElement("TD");
							if (front_end)
								cell4.innerHTML =  '<a href="javascript: void(0);" onclick="javascript: changeState('+(number)+');"><img id="img_'+(number)+'" src="images/tick.png" border="0" alt="<?php echo JText::_( 'Yes' ); ?>" title="<?php echo JText::_( 'Yes' ); ?>"  /><input type="hidden" id="cbx_'+(number++)+'" name="front_end_cb[]" value="1"  /></a>';
							else
								cell4.innerHTML =  '<a href="javascript: void(0);" onclick="javascript: changeState('+(number)+');"><img id="img_'+(number)+'" src="images/publish_x.png" border="0" alt="<?php echo JText::_( 'No' ); ?>" title="<?php echo JText::_( 'No' ); ?>"  /><input type="hidden" id="cbx_'+(number++)+'" name="front_end_cb[]" value="0"  /></a>';
							cell4.align = "center";

							var cell5 = document.createElement("TD");
							if (back_end)
								cell5.innerHTML =  '<a href="javascript: void(0);" onclick="javascript: changeState('+(number)+');"><img id="img_'+(number)+'" src="images/tick.png" border="0" alt="<?php echo JText::_( 'Yes' ); ?>" title="<?php echo JText::_( 'Yes' ); ?>"  /><input type="hidden" id="cbx_'+(number++)+'" name="back_end_cb[]" value="1"  /></a>';
							else
								cell5.innerHTML =  '<a href="javascript: void(0);" onclick="javascript: changeState('+(number)+');"><img id="img_'+(number)+'" src="images/publish_x.png" border="0" alt="<?php echo JText::_( 'No' ); ?>" title="<?php echo JText::_( 'No' ); ?>"  /><input type="hidden" id="cbx_'+(number++)+'" name="back_end_cb[]" value="0"  /></a>';
							cell5.align = "center";


							var cell6 = document.createElement("TD");
							cell6.innerHTML = '<a href="javascript: void(0);" onclick="javascript:delete_row(this,\''+tbl+'\'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>';
							cell6.align = "center";

							var cell7 = document.createElement("TD");
							cell7.innerHTML = '&nbsp;';

							row.appendChild(cell0);
							row.appendChild(cell1);
							row.appendChild(cell2);
							row.appendChild(cell3);
							row.appendChild(cell4);
							row.appendChild(cell5);
							row.appendChild(cell6);
							row.appendChild(cell7);

							tbody.appendChild(row);
						}
					}

					var tbody_kv = jQuery('tbody#key_value').get(0);
					var count = jQuery('tbody#key_value tr').size();
					for( ii = count; ii != 1; ii--) {
						tbody_kv.deleteRow(ii-1);
					}
					jQuery('input#value_id_07').get(0).value = '';
					jQuery('input#value_id_07').get(0).disabled='';
					jQuery('input#any_value_07').get(0).checked=false;
				}
				else {
					for (jj = 0; jj < listitem.options.length; jj++) {
						if (listitem.options[jj].selected == true) {
							var row = document.createElement("TR");

							var cell0 = document.createElement("TD");
							cell0.innerHTML = '0';

							var cell1 = document.createElement("TD");
							cell1.innerHTML = listitem.options[jj].text+'<input type="hidden" name="grouping[]" value="'+grouping+'" />';
							var input_hidden = document.createElement("input");
							input_hidden.type = 'hidden';
							input_hidden.name = hidden_name;
							input_hidden.value = listitem.options[jj].value;
							cell1.appendChild(input_hidden);

							var cell2 = document.createElement("TD");
							cell2.innerHTML = '<?php echo JText::_( 'Any key' ); ?>';
							var input_hidden = document.createElement("input");
							input_hidden.type = 'hidden';
							input_hidden.name = 'key_name['+grouping+'][]';
							input_hidden.value = '#any_key#';
							cell2.appendChild(input_hidden);

							var cell3 = document.createElement("TD");
							cell3.innerHTML = '<?php echo JText::_( 'Any value' ); ?>'+ '<input type="hidden" name="extra_opt['+grouping+'][]" value="0" />';
							var input_hidden = document.createElement("input");
							input_hidden.type = 'hidden';
							input_hidden.name = 'value_name['+grouping+'][]';
							input_hidden.value = '#any_value#';
							cell3.appendChild(input_hidden);

							var cell4 = document.createElement("TD");
							if (front_end)
								cell4.innerHTML =  '<a href="javascript: void(0);" onclick="javascript: changeState('+(number)+');"><img id="img_'+(number)+'" src="images/tick.png" border="0" alt="<?php echo JText::_( 'Yes' ); ?>" title="<?php echo JText::_( 'Yes' ); ?>"  /><input type="hidden" id="cbx_'+(number++)+'" name="front_end_cb[]" value="1"  /></a>';
							else
								cell4.innerHTML =  '<a href="javascript: void(0);" onclick="javascript: changeState('+(number)+');"><img id="img_'+(number)+'" src="images/publish_x.png" border="0" alt="<?php echo JText::_( 'No' ); ?>" title="<?php echo JText::_( 'No' ); ?>"  /><input type="hidden" id="cbx_'+(number++)+'" name="front_end_cb[]" value="0"  /></a>';
							cell4.align = "center";

							var cell5 = document.createElement("TD");
							if (back_end)
								cell5.innerHTML =  '<a href="javascript: void(0);" onclick="javascript: changeState('+(number)+');"><img id="img_'+(number)+'" src="images/tick.png" border="0" alt="<?php echo JText::_( 'Yes' ); ?>" title="<?php echo JText::_( 'Yes' ); ?>"  /><input type="hidden" id="cbx_'+(number++)+'" name="back_end_cb[]" value="1"  /></a>';
							else
								cell5.innerHTML =  '<a href="javascript: void(0);" onclick="javascript: changeState('+(number)+');"><img id="img_'+(number)+'" src="images/publish_x.png" border="0" alt="<?php echo JText::_( 'No' ); ?>" title="<?php echo JText::_( 'No' ); ?>"  /><input type="hidden" id="cbx_'+(number++)+'" name="back_end_cb[]" value="0"  /></a>';
							cell5.align = "center";


							var cell6 = document.createElement("TD");
							cell6.innerHTML = '<a href="javascript: void(0);" onclick="javascript:delete_row(this,\''+tbl+'\'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>';
							cell6.align = "center";

							var cell7 = document.createElement("TD");
							cell7.innerHTML = '&nbsp;';

							row.appendChild(cell0);
							row.appendChild(cell1);
							row.appendChild(cell2);
							row.appendChild(cell3);
							row.appendChild(cell4);
							row.appendChild(cell5);
							row.appendChild(cell6);
							row.appendChild(cell7);

							tbody.appendChild(row);
						}
					}
				}

				renum_table_rows(tbody);
			}

			function addRowKV(tbl) {
				number++;
				var tbody = jQuery('tbody#'+tbl).get(0);
				var row = document.createElement("TR");

				var cell0 = document.createElement("TD");
				cell0.width = '140px';
				cell0.innerHTML = '<?php echo JText::_( 'Key' ); ?>:&nbsp; <input class="inputbox" type="text" name="key" value="" id="key_id_'+number+'"  />';
				var cell1 = document.createElement("TD");
				cell1.innerHTML = '<?php echo JText::_( 'Value' ); ?>:&nbsp; <input class="inputbox" type="text" name="value" value="" id="value_id_'+number+'"  />&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript: void(0);" onclick="javascript:delete_row_kv(this); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a><br /><label><input type="checkbox" name="any_value2" id="any_value_'+number+'" value="2" onchange="javascript: jQuery(\'input#any_value2_'+number+'\').get(0).checked=false;if (jQuery(\'input#value_id_'+number+'\').get(0).value == \'#any_value#\') jQuery(\'input#value_id_'+number+'\').get(0).value = \'\';jQuery(\'input#value_id_'+number+'\').get(0).disabled=\'\';" />&nbsp;<?php echo ($default_action == 'deny'? JText::_( 'Allow all values except this value' ):JText::_( 'Only allow this value' )); ?></label><br/><label><input type="checkbox" name="any_value" id="any_value2_'+number+'" value="1" onchange="javascript: jQuery(\'input#any_value_'+number+'\').get(0).checked=false; if (this.checked) { jQuery(\'input#value_id_'+number+'\').get(0).value = \'#any_value#\'; jQuery(\'input#value_id_'+number+'\').get(0).disabled=\'disabled\'; }else { jQuery(\'input#value_id_'+number+'\').get(0).value = \'\';jQuery(\'input#value_id_'+number+'\').get(0).disabled=\'\';}" />&nbsp;<?php echo JText::_( 'Any value' ); ?></label>';

				row.appendChild(cell0);
				row.appendChild(cell1);
				tbody.appendChild(row);
			}

			function changeState(elem_no) {
				var cbx = jQuery('input#cbx_'+elem_no).get(0);
				var img = jQuery('img#img_'+elem_no).get(0);
				if ( cbx.value == 1 ) {
					cbx.value = 0;
					img.src = 'images/publish_x.png';
					img.alt = '<?php echo JText::_( 'No' ); ?>';
					img.title = '<?php echo JText::_( 'No' ); ?>';
				}
				else {
					cbx.value = 1;
					img.src = 'images/tick.png';
					img.alt = '<?php echo JText::_( 'Yes' ); ?>';
					img.title = '<?php echo JText::_( 'Yes' ); ?>';
				}
			}

			function addRowC(tbl, litem, type, action) {
				var listitem = jQuery(litem).get(0);
				var tbody = jQuery('tbody#'+tbl).get(0);
				var hidden_name = type + '_' + action + '_id[]';
				for (jj = 0; jj < listitem.options.length; jj++) {
					if (listitem.options[jj].selected == true && check_id_in_table(listitem.options[jj].value, tbl)) {
						var row = document.createElement("TR");

						var cell0 = document.createElement("TD");
						cell0.innerHTML = '0';
						cell0.width = '20px';
						var cell1 = document.createElement("TD");
						cell1.innerHTML = listitem.options[jj].text;
						var input_hidden = document.createElement("input");
						input_hidden.type = 'hidden';
						input_hidden.name = hidden_name;
						input_hidden.value = listitem.options[jj].value;
						cell1.appendChild(input_hidden);
						cell1.width = '50px';
						var cell2 = document.createElement("TD");
						cell2.innerHTML = '<a href="javascript: void(0);" onclick="javascript:delete_row_t(this,\''+tbl+'\'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>';
						cell2.align = "center";
						cell2.width = '50px';
						row.appendChild(cell0);
						row.appendChild(cell1);
						row.appendChild(cell2);

						tbody.appendChild(row);
					}
				}
				renum_table_rows(tbody);
			}

			function Select_all(elem_id) {
				elem = jQuery('select#'+elem_id).get(0);

				for (var i=0; i<elem.options.length; i++) {
					elem.options[i].selected = true;
				}
				return true;
			}

			function clearTable(table) {
				var tbody = jQuery('tbody#'+table).get(0);
				while ( tbody.childNodes.length >= 1 ){
        			tbody.removeChild( tbody.firstChild );
    			}
				//tbody.innerHTML = '';
			}

		/* ]]> */
		</script>
		<form action="index.php" method="post" name="adminForm">
		<?php
		echo $pane->startPane("content-pane");
		echo $pane->startPanel( JText::_('Actions for Components'), 'Component' );
		?>
		<fieldset class="adminform">
		<legend><?php echo ($default_action == 'deny'? JText::_( 'Allowed Actions for components' ):JText::_( 'Forbidden Actions for components' )); ?></legend>
		<table class="adminform">
			<tr>
				<td  valign="top" width="30%">
					<strong><?php echo JText::_( 'Component' ); ?>:</strong>&nbsp;<?php echo $lists['componentid']; ?>&nbsp;&nbsp;
				</td>
				<td align="left">
					<label><input type="radio" name="action" id="all_act" value="1" />&nbsp;<?php echo JText::_( 'All actions' ); ?></label><label><input type="radio" name="action" id="custom_act" value="0" checked="checked" />&nbsp;<?php echo JText::_( 'Custom actions' ); ?></label>
				</td>
				<td align="left">
					&nbsp;&nbsp;
					<input type="button" name="add" class="button" value="Add" onclick="javascript: addRow('list_body_com');"  />
				</td>
			</tr>
			<tr>
				<td colspan="3" valign="top">
				<hr width="100%" />
				<strong><?php echo JText::_( 'Custom action:' ); ?></strong>
				</td>
			</tr>
			<tr>
				<td colspan="3" valign="top">
				<table width="100%">
				<tbody id="key_value">
				<tr>
					<td valign="top" align="left" width="140px">
					<?php echo JText::_( 'Key' ); ?>:&nbsp; <input class="inputbox" type="text" name="key" value="" id="key_id_07"  />&nbsp;&nbsp;
					</td>
					<td valign="top" align="left">
					<?php echo JText::_( 'Value' ); ?>:&nbsp; <input class="inputbox" type="text" name="value" value="" id="value_id_07"  />&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="button" name="add" class="button"  value="<?php echo JText::_( 'Add another key-value pair' ); ?>" onclick="javascript: addRowKV('key_value');"  />	<br />
					<label><input type="checkbox" name="any_value2" id="any_value_07" value="2" onchange="javascript: jQuery('input#any_value2_07').get(0).checked=false;if (jQuery('input#value_id_07').get(0).value == '#any_value#') jQuery('input#value_id_07').get(0).value = '';jQuery('input#value_id_07').get(0).disabled='';" />&nbsp;<?php echo ($default_action == 'deny'? JText::_( 'Allow all values except this value' ):JText::_( 'Only allow this value' )); ?></label><br />
					<label><input type="checkbox" name="any_value" id="any_value2_07" value="1" onchange="javascript: jQuery('input#any_value_07').get(0).checked=false; if (this.checked) { jQuery('input#value_id_07').get(0).value = '#any_value#'; jQuery('input#value_id_07').get(0).disabled='disabled'; }else { jQuery('input#value_id_07').get(0).value = '';jQuery('input#value_id_07').get(0).disabled='';}" />&nbsp;<?php echo JText::_( 'Any value' ); ?></label>

					</td>
				</tr>
				</tbody>
				</table>
				</tr>
				</td>
			</tr>
			<tr>
				<td valign="top" align="left" colspan="3">
					<label><input type="checkbox" name="front_end" id="front_end" value="1" checked="checked" />&nbsp;<?php echo JText::_( 'Front End' ); ?></label><br />
					<label><input type="checkbox" name="back_end" id="back_end" value="1" checked="checked" />&nbsp;<?php echo JText::_( 'Back End' ); ?></label>
				</td>
			</tr>
		</table>
		<table class="adminlist" cellpadding="1" summary="">
			<thead>
				<tr>
					<th width="2%" class="title">
						<?php echo JText::_( 'NUM' ); ?>
					</th>
					<th class="title">
						<?php echo JText::_( 'Component' ); ?>
					</th>
					<th class="title">
						<?php echo JText::_( 'Key' ); ?>
					</th>
					<th class="title">
						<?php echo JText::_( 'Value' ); ?>
					</th>
					<th class="title" width="10%">
						<?php echo JText::_( 'Front End' ); ?>
					</th>
					<th class="title" width="10%">
						<?php echo JText::_( 'Back End' ); ?>
					</th>
					<th class="title" width="15%">
						<?php echo JText::_( 'Delete' ); ?>&nbsp;&nbsp;
						<input type="button" name="clear_all" class="button" value="<?php echo JText::_( 'Clear All' ); ?>" onclick="javascript: clearTable('list_body_com');"  />
					</th>
					<th class="title" width="auto">&nbsp;
					</th>
				</tr>
			</thead>
			<tbody id="list_body_com">
			<!-- Forbidden Actions for components -->
			<?php
				$k = 0;
				$i = 1;
				$j = 1;
				if (is_array($lists['functions']) && count($lists['functions']))
					foreach($lists['functions'] as $row) {
				?>
					<tr  class="row<?php echo $k; ?>">
						<td width="2%">
							<?php echo $i++; ?>
						</td>
						<td>
							<?php echo $row->title; ?>
							<input type="hidden" name="component_id[]" value="<?php echo $row->c_id; ?>"  />
							<input type="hidden" name="grouping[]" value="<?php echo $row->grouping; ?>"  />
						</td>
						<td>
						<?php
							foreach($row->name as $name) {
								echo ($name!='#any_key#'? $name: JText::_( 'Any key' )); ?>
							<input type="hidden" name="key_name[<?php echo $row->grouping; ?>][]" value="<?php echo $name; ?>"  /><br />
						<?php }?>
						</td>
						<td>
						<?php
							foreach($row->value as $l=>$value) {
							echo ($value!='#any_value#'? $value: JText::_( 'Any value' ));
							echo $row->extra[$l];
							if ($row->extra[$l] != '') {
							?>
							<input type="hidden" name="extra_opt[<?php echo $row->grouping; ?>][]" value="1"  />
							<?php } else { ?>
								<input type="hidden" name="extra_opt[<?php echo $row->grouping; ?>][]" value="0"  />
							<?php }?>
							<input type="hidden" name="value_name[<?php echo $row->grouping; ?>][]" value="<?php echo $value; ?>"  />
						<?php }?>
						</td>
						<td align="center">
							<?php if ($row->isfrontend == 1) { ?>
							<a href="javascript: void(0);" onclick="javascript: changeState(<?php echo $j;?>);"><img id="img_<?php echo $j;?>" src="images/tick.png" border="0" alt="<?php echo JText::_( 'Yes' ); ?>" title="<?php echo JText::_( 'Yes' ); ?>"  />
							<input type="hidden" id="cbx_<?php echo $j++;?>" name="front_end_cb[]" value="1"  /></a>
							<?php } else {?>
							<a href="javascript: void(0);" onclick="javascript: changeState(<?php echo $j;?>);"><img id="img_<?php echo $j;?>" src="images/publish_x.png" border="0" alt="<?php echo JText::_( 'No' ); ?>" title="<?php echo JText::_( 'No' ); ?>"  />
							<input type="hidden" id="cbx_<?php echo $j++;?>" name="front_end_cb[]" value="0"  /></a>
							<?php }?>
						</td>
						<td  align="center">
							<?php if ($row->isbackend == 1) { ?>
							<a href="javascript: void(0);" onclick="javascript: changeState(<?php echo $j;?>);"><img id="img_<?php echo $j;?>" src="images/tick.png" border="0" alt="<?php echo JText::_( 'Yes' ); ?>" title="<?php echo JText::_( 'Yes' ); ?>"  />
							<input type="hidden" id="cbx_<?php echo $j++;?>" name="back_end_cb[]" value="1"  /></a>
							<?php } else {?>
							<a href="javascript: void(0);" onclick="javascript: changeState(<?php echo $j;?>);"><img id="img_<?php echo $j;?>" src="images/publish_x.png" border="0" alt="<?php echo JText::_( 'No' ); ?>" title="<?php echo JText::_( 'No' ); ?>"  />
							<input type="hidden" id="cbx_<?php echo $j++;?>" name="back_end_cb[]" value="0"  /></a>
							<?php }?>
						</td>
						<td  align="center">
							<a href="javascript: void(0);" onclick="javascript:delete_row(this, 'list_body'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>
						</td>
						<td width="auto">&nbsp;

						</td>
					</tr>
				<?php
						$k = 1 - $k;
					}?>
			</tbody>
		</table>
		</fieldset>
		<?php
		echo $pane->endPanel();
		echo $pane->startPanel( JText::_('Actions for Content Items'), 'Component' );
		?>
		<fieldset class="adminform">
		<legend><?php echo ($default_action == 'deny'? JText::_( 'Allowed Actions for Content Items' ):JText::_( 'Forbidden Actions for Content Items' )); ?></legend>
		<table width="100%" >
		<tr>
			<td width="33%" valign="top">
				<table class="adminform">
					<tr>
						<td  valign="top" width="5%">
							<strong><?php echo JText::_( 'Sections' ); ?>:</strong><br />
							<?php echo $lists['sectionid']; ?>
						</td>
						<td valign="top"  align="left" width="auto">
							<input type="button" name="select_all" class="button" value="Select All" onclick="javascript: Select_all('sectionid');"  /><br/><br/><br/>
							<input style="margin-bottom: 3px;" type="button" name="add" class="button" value="<?php echo ($default_action == 'deny'? JText::_( 'Allow Add' ):JText::_( 'Forbid Add' )); ?>" onclick="javascript: addRowC('list_body_sadd', 'select#sectionid', 'section', 'add');"  /><br/>
							<input style="margin-bottom: 3px;" type="button" name="add" class="button" value="<?php echo ($default_action == 'deny'? JText::_( 'Allow Edit' ):JText::_( 'Forbid Edit' )); ?>" onclick="javascript: addRowC('list_body_sedit', 'select#sectionid', 'section', 'edit');"  /><br/>
							<input style="margin-bottom: 3px;" type="button" name="add" class="button" value="<?php echo ($default_action == 'deny'? JText::_( 'Allow Publish' ):JText::_( 'Forbid Publish' )); ?>" onclick="javascript: addRowC('list_body_spublish', 'select#sectionid', 'section', 'publish');"  /><br/>
						</td>
					</tr>
				</table>
			</td>
			<td width="33%" valign="top">
				<table class="adminform">
					<tr>
						<td  valign="top" width="5%">
							<strong><?php echo JText::_( 'Categories' ); ?>:</strong><br />
							<?php echo $lists['catid']; ?>
						</td>
						<td valign="top" align="left" width="auto">
							<input type="button" name="select_all" class="button" value="Select All" onclick="javascript: Select_all('catid');"  /><br/><br/><br/>
							<input style="margin-bottom: 3px;" type="button" name="add" class="button" value="<?php echo ($default_action == 'deny'? JText::_( 'Allow Add' ):JText::_( 'Forbid Add' )); ?>" onclick="javascript: addRowC('list_body_cadd', 'select#catid', 'category', 'add');"  /><br/>
							<input style="margin-bottom: 3px;" type="button" name="add" class="button" value="<?php echo ($default_action == 'deny'? JText::_( 'Allow Edit' ):JText::_( 'Forbid Edit' )); ?>" onclick="javascript: addRowC('list_body_cedit', 'select#catid', 'category', 'edit');"  /><br/>
							<input style="margin-bottom: 3px;" type="button" name="add" class="button" value="<?php echo ($default_action == 'deny'? JText::_( 'Allow Publish' ):JText::_( 'Forbid Publish' )); ?>" onclick="javascript: addRowC('list_body_cpublish', 'select#catid', 'category', 'publish');"  /><br/>
						</td>
					</tr>
				</table>
			</td>
			<td width="33%" valign="top">
				<table class="adminform">
					<tr>
						<td  valign="top" width="5%">
							<strong><?php echo JText::_( 'Articles' ); ?>:</strong><br />
							<?php echo $lists['contentid']; ?>
						</td>
						<td  valign="top"  align="left" width="auto">
							<input type="button" name="select_all" class="button" value="Select All" onclick="javascript: Select_all('contentid');"  /><br/><br/><br/>
							<input style="margin-bottom:3px;" type="button" name="add" class="button" value="<?php echo ($default_action == 'deny'? JText::_( 'Allow Edit' ):JText::_( 'Forbid Edit' )); ?>" onclick="javascript: addRowC('list_body_aedit', 'select#contentid', 'content', 'edit');"  /><br/>
							<input style="margin-bottom:3px;" type="button" name="add" class="button" value="<?php echo ($default_action == 'deny'? JText::_( 'Allow Publish' ):JText::_( 'Forbid Publish' )); ?>" onclick="javascript: addRowC('list_body_apublish', 'select#contentid', 'content', 'publish');"  /><br/>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		</table>

		<table width="100%" >
		<tr>
			<td width="33%" valign="top">
				<strong><?php echo ($default_action == 'deny'? JText::_( 'ADD New Items Allowed in' ):JText::_( 'ADD New Items Forbidden in' )); ?>:</strong>
				<table class="adminlist" cellpadding="1">
				<thead>
					<tr>
						<th width="20px" class="title">
							<?php echo JText::_( 'NUM' ); ?>
						</th>
						<th class="title"  width="55%">
							<?php echo JText::_( 'Title' ); ?>
						</th>
						<th class="title">
							<?php echo JText::_( 'Delete' ); ?>&nbsp;&nbsp;
							<input type="button" name="clear_all" class="button" value="<?php echo JText::_( 'Clear All' ); ?>" onclick="javascript: clearTable('list_body_sadd');clearTable('list_body_cadd');"  />
						</th>
					</tr>
				</thead>
				<tbody id="list_items_add_id">
					<?php
					$k = 0;
					$i = 1;
					?>
					<tr>
						<td colspan="3" align="left">
							<strong><?php echo JText::_( 'Sections' ); ?></strong><br />
							<table width="100%"	>
								<tbody id="list_body_sadd">
									<?php
									$k = 1 - $k;
									if (is_array($lists['sections_add']) && count($lists['sections_add']))
										foreach($lists['sections_add'] as $row) {
									?>
									<tr  class="row<?php echo $k; ?>">
										<td width="2%">
											<?php echo $i++; ?>
										</td>
										<td>
											<?php echo ($row->value > 0 ? $row->title: JText::_('Uncategorized')); ?>
											<input type="hidden" name="section_add_id[]" value="<?php echo $row->value; ?>"  />
										</td>
										<td align="center">
											<a href="javascript: void(0);" onclick="javascript:delete_row_t(this, 'list_body_sadd'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>
										</td>
									</tr>
									<?php
										$k = 1 - $k;
									}?>
								</tbody>
							</table>
						</td>
					</tr>

					<tr>
						<td colspan="3" align="left">
							<strong><?php echo JText::_( 'Categories' ); ?>	</strong>
							<table width="100%"	>
								<tbody id="list_body_cadd">
									<?php
									$k = 1 - $k;
									if (is_array($lists['categories_add']) && count($lists['categories_add']))
										foreach($lists['categories_add'] as $row) {
									?>
									<tr  class="row<?php echo $k; ?>">
										<td width="2%">
											<?php echo $i++; ?>
										</td>
										<td>
											<?php echo ($row->value > 0 ? $row->title: JText::_('Uncategorized')); ?>
											<input type="hidden" name="category_add_id[]" value="<?php echo $row->value; ?>"  />
										</td>
										<td align="center">
											<a href="javascript: void(0);" onclick="javascript:delete_row_t(this, 'list_body_cadd'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>
										</td>
									</tr>
									<?php
										$k = 1 - $k;
									}?>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
				</table>
			</td>
			<td width="33%" valign="top">
				<strong><?php echo ($default_action == 'deny'? JText::_( 'EDIT Items Allowed in' ):JText::_( 'EDIT Items Forbidden in' )); ?>:</strong>
				<table class="adminlist" cellpadding="1">
				<thead>
					<tr>
						<th width="2%" class="title">
							<?php echo JText::_( 'NUM' ); ?>
						</th>
						<th class="title"  width="55%">
							<?php echo JText::_( 'Title' ); ?>
						</th>
						<th class="title" >
							<?php echo JText::_( 'Delete' ); ?>&nbsp;&nbsp;
							<input type="button" name="clear_all" class="button" value="<?php echo JText::_( 'Clear All' ); ?>" onclick="javascript: clearTable('list_body_sedit');clearTable('list_body_cedit');clearTable('list_body_aedit');"  />
						</th>
					</tr>
				</thead>
				<tbody id="list_items_edit_id">
					<?php
					$k = 0;
					$i = 1;
					?>
					<tr>
						<td colspan="3" align="left">
							<strong><?php echo JText::_( 'Sections' ); ?></strong><br />
							<table width="100%"	>
								<tbody id="list_body_sedit">
									<?php
									$k = 1 - $k;
									if (is_array($lists['sections_edit']) && count($lists['sections_edit']))
										foreach($lists['sections_edit'] as $row) {
									?>
									<tr  class="row<?php echo $k; ?>">
										<td width="2%">
											<?php echo $i++; ?>
										</td>
										<td>
											<?php echo ($row->value > 0 ? $row->title: JText::_('Uncategorized')); ?>
											<input type="hidden" name="section_edit_id[]" value="<?php echo $row->value; ?>"  />
										</td>
										<td align="center">
											<a href="javascript: void(0);" onclick="javascript:delete_row_t(this, 'list_body_sedit'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>
										</td>
									</tr>
									<?php
										$k = 1 - $k;
									}?>
								</tbody>
							</table>
						</td>
					</tr>

					<tr>
						<td colspan="3" align="left">
							<strong><?php echo JText::_( 'Categories' ); ?>	</strong>
							<table width="100%"	>
								<tbody id="list_body_cedit">
									<?php
									if (is_array($lists['categories_edit']) && count($lists['categories_edit']))
										foreach($lists['categories_edit'] as $row) {
									?>
									<tr  class="row<?php echo $k; ?>">
										<td width="2%">
											<?php echo $i++; ?>
										</td>
										<td>
											<?php echo ($row->value > 0 ? $row->title: JText::_('Uncategorized')); ?>
											<input type="hidden" name="category_edit_id[]" value="<?php echo $row->value; ?>"  />
										</td>
										<td align="center">
											<a href="javascript: void(0);" onclick="javascript:delete_row_t(this, 'list_body_cedit'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>
										</td>
									</tr>
									<?php
										$k = 1 - $k;
									}?>
								</tbody>
							</table>
						</td>
					</tr>
					<?php
					$k = 1 - $k;
					?>
					<tr>
						<td colspan="3" align="left">
							<strong><?php echo JText::_( 'Articles' ); ?></strong>
							<table width="100%"	>
								<tbody id="list_body_aedit">
									<?php
									if (is_array($lists['contents_edit']) && count($lists['contents_edit']))
										foreach($lists['contents_edit'] as $row) {
									?>
									<tr  class="row<?php echo $k; ?>">
										<td width="2%">
											<?php echo $i++; ?>
										</td>
										<td>
											<?php echo $row->title; ?>
											<input type="hidden" name="content_edit_id[]" value="<?php echo $row->value; ?>"  />
										</td>
										<td align="center">
											<a href="javascript: void(0);" onclick="javascript:delete_row_t(this, 'list_body_aedit'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>
										</td>
									</tr>
									<?php
										$k = 1 - $k;
									}?>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
				</table>
			</td>
			<td width="33%" valign="top">
				<strong><?php echo ($default_action == 'deny'? JText::_( 'PUBLISH Items Allowed in' ):JText::_( 'PUBLISH Items Forbidden in' )); ?>:</strong>
				<table class="adminlist" cellpadding="1">
				<thead>
					<tr>
						<th width="2%" class="title">
							<?php echo JText::_( 'NUM' ); ?>
						</th>
						<th class="title" width="55%">
							<?php echo JText::_( 'Title' ); ?>
						</th>
						<th class="title">
							<?php echo JText::_( 'Delete' ); ?>&nbsp;&nbsp;
							<input type="button" name="clear_all" class="button" value="<?php echo JText::_( 'Clear All' ); ?>" onclick="javascript: clearTable('list_body_spublish');clearTable('list_body_cpublish');clearTable('list_body_apublish');"  />
						</th>
					</tr>
				</thead>
				<tbody id="list_items_publish_id">
					<?php
					$k = 0;
					$i = 1;
					?>
					<tr>
						<td colspan="3" align="left">
							<strong><?php echo JText::_( 'Sections' ); ?></strong><br />
							<table width="100%"	>
								<tbody id="list_body_spublish">
									<?php
									$k = 1 - $k;
									if (is_array($lists['sections_publish']) && count($lists['sections_publish']))
										foreach($lists['sections_publish'] as $row) {
									?>
									<tr  class="row<?php echo $k; ?>">
										<td width="2%">
											<?php echo $i++; ?>
										</td>
										<td>
											<?php echo ($row->value > 0 ? $row->title: JText::_('Uncategorized')); ?>
											<input type="hidden" name="section_publish_id[]" value="<?php echo $row->value; ?>"  />
										</td>
										<td align="center">
											<a href="javascript: void(0);" onclick="javascript:delete_row_t(this, 'list_body_spublish'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>
										</td>
									</tr>
									<?php
										$k = 1 - $k;
									}?>
								</tbody>
							</table>
						</td>
					</tr>

					<tr>
						<td colspan="3" align="left">
							<strong><?php echo JText::_( 'Categories' ); ?>	</strong>
							<table width="100%"	>
								<tbody id="list_body_cpublish">
									<?php
									if (is_array($lists['categories_publish']) && count($lists['categories_publish']))
										foreach($lists['categories_publish'] as $row) {
									?>
									<tr  class="row<?php echo $k; ?>">
										<td width="2%">
											<?php echo $i++; ?>
										</td>
										<td>
											<?php echo ($row->value > 0 ? $row->title: JText::_('Uncategorized')); ?>
											<input type="hidden" name="category_publish_id[]" value="<?php echo $row->value; ?>"  />
										</td>
										<td align="center">
											<a href="javascript: void(0);" onclick="javascript:delete_row_t(this, 'list_body_cpublish'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>
										</td>
									</tr>
									<?php
										$k = 1 - $k;
									}?>
								</tbody>
							</table>
						</td>
					</tr>
					<?php
					$k = 1 - $k;
					?>
					<tr>
						<td colspan="3" align="left">
							<strong><?php echo JText::_( 'Articles' ); ?></strong>
							<table width="100%"	>
								<tbody id="list_body_apublish">
									<?php
									if (is_array($lists['contents_publish']) && count($lists['contents_publish']))
										foreach($lists['contents_publish'] as $row) {
									?>
									<tr  class="row<?php echo $k; ?>">
										<td width="2%">
											<?php echo $i++; ?>
										</td>
										<td>
											<?php echo $row->title; ?>
											<input type="hidden" name="content_publish_id[]" value="<?php echo $row->value; ?>"  />
										</td>
										<td align="center">
											<a href="javascript: void(0);" onclick="javascript:delete_row_t(this, 'list_body_apublish'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>
										</td>
									</tr>
									<?php
										$k = 1 - $k;
									}?>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
				</table>
			</td>
		</tr>
		</table>
		</fieldset>
		<?php
		echo $pane->endPanel();
		echo $pane->endPane();
		?>

		<input type="hidden" name="option" value="com_community_acl" />
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="redirect" value="list_functions" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
		left_menu_footer();
	}

	function group_access( $id, $mode, &$lists, $option, $redirect ) {
		JRequest::setVar( 'hidemainmenu', 1 );

		$db	=& JFactory::getDBO();

		$query = "SELECT `value` FROM `#__community_acl_config` WHERE `name` = 'default_action' ";
		$db->setQuery($query);
		$default_action = $db->loadResult();

		if ($default_action == null)
			$default_action = 'deny';

		jimport('joomla.html.pane');
		JHTML::_('behavior.tooltip');

		$pane		=& JPane::getInstance('Tabs');
		left_menu_header();
		?>
		<script language="javascript" type="text/javascript">
		/* <![CDATA[ */

		var menus = new Array;
		var modules = new Array;

		var sections = new Array;
		var categories = new Array;
		var articles = new Array;


		<?php

		$i = 0;
		foreach ($lists['menus_arr'] as $k=>$v) {

			echo "menus[".$i."] = new Array( '".addslashes( $v->value )."', '".addslashes( $v->treename )."', '".addslashes( $v->parent_name )."', '".addslashes( $v->menu_name )."' );\n\t\t";
			$i++;
		}

		$i = 0;
		foreach ($lists['modules_arr'] as $k=>$v) {
			$v->title = str_replace( array("\n","\r"), '<br/>', $v->title);
			echo "modules[".$v->id."] = new Array( '".addslashes( $v->id )."', '".addslashes( $v->title )."', '".addslashes( $v->position )."', '".addslashes( $v->module )."', '".addslashes( $v->published )."' );\n\t\t";
		}


		$i = 0;
		foreach ($lists['sections_arr'] as $k=>$v) {
			$v->title = str_replace( array("\n","\r"), '<br/>', $v->title);
			echo "sections[".$v->id."] = new Array( '".addslashes( $v->id )."', '".addslashes( $v->title )."', '".addslashes( $v->published )."' );\n\t\t";
		}
		echo "sections[0] = new Array( '0', '".JText::_('Uncategorized')."', '1' );\n\t\t";


		$i = 0;
		foreach ($lists['categories_arr'] as $k=>$v) {
			$v->title = str_replace( array("\n","\r"), '<br/>', $v->title);
			echo "categories[".$v->id."] = new Array( '".addslashes( $v->id )."', '".addslashes( $v->title )."', '".addslashes( $v->published )."', '".addslashes( $v->section_name )."' );\n\t\t";
		}
		echo "categories[0] = new Array( '0', '".JText::_('Uncategorized')."', '1', '".JText::_('Uncategorized')."' );\n\t\t";

		$i = 0;
		foreach ($lists['contents_arr'] as $k=>$v) {
			$v->title = str_replace( array("\n","\r"), '<br/>', $v->title);
			$v->author_name = str_replace( array("\n","\r"), '<br/>', $v->author_name);
			echo "articles[".$v->id."] = new Array( '".addslashes( $v->id )."', '".addslashes( $v->title )."', '".addslashes( $v->published )."', '".addslashes( ($v->section_name==''?JText::_('Uncategorized'):$v->section_name) )."', '".addslashes( ($v->cat_name==''?JText::_('Uncategorized'):$v->cat_name) )."', '".addslashes( $v->author_name )."' );\n\t\t";
		}
		?>

		function check(xx, k) {

			for (ii in sectioncategories) {
					if (sectioncategories[ii][0] == k) {
						if (categoriescontent[xx][0] == sectioncategories[ii][1]) {
							return true;
						}
					}
			}
			return false;
		}

		function check_id_in_table(id, tbody_id) {
			var tbody = jQuery('tbody#'+tbody_id).get(0);
			if (tbody.rows[0]) {
				for (var i = 0; i < tbody.rows.length; i++) {
					var children = tbody.rows[i].cells[1].childNodes;
					for (var j = 0; j < children.length; j++) {
						if (children[j].nodeName.toLowerCase() == 'input' && children[j].value == id) {
							return false;
						}
					}
				}
			}
			return true;
		}

		function changeDynaList( listname, source, key, orig_key, orig_val ) {
			var list = eval( 'document.adminForm.' + listname );
			// empty the list
			for (i in list.options.length) {
				list.options[i] = null;
			}
			i = 0;
			for (x in source) {
				//alert(source[x][0]);
				if (source[x][0] == key || (key < 0 && check(x, -1*key)) ) {

					opt = new Option();
					opt.value = source[x][1];
					opt.text = source[x][2];

					if ((orig_key == key && orig_val == opt.value) || i == 0) {
						opt.selected = true;
					}
					list.options[i++] = opt;
				}
			}

			list.length = i;
		}

		function Select_all(elem_id) {
			elem = jQuery('select#'+elem_id).get(0);

			for (var i=0; i<elem.options.length; i++) {
				elem.options[i].selected = true;
			}
			return true;
		}

		var number = 9999;


		function renum_table_rows(tbl_elem) {
			if (tbl_elem.rows[0]) {
				var count = 1;
				var row_k = 1 - 1%2;
				for (var i=0; i<tbl_elem.rows.length; i++) {
					tbl_elem.rows[i].cells[0].innerHTML = count;
					tbl_elem.rows[i].className = 'row'+row_k;
					count++;
					row_k = 1 - row_k;
				}
			}
		}

		function renum_table_rows_menu(tbl_elem) {
			if (tbl_elem.rows[0]) {
				var menu_ids = new Array;
				var count = 1;
				var row_k = 1 - 1%2;
				for (var i=0; i<tbl_elem.rows.length; i++) {
					menu_ids[i] = parseInt(tbl_elem.rows[i].cells[4].innerHTML);
					tbl_elem.deleteRow(i);
				}

				for (var i=0; i<menus.length; i++) {
					if (menus[i] != null) {
						for (var j=0; j<menu_ids.length; j++) {
							if (menu_ids[j] == i) {

								var row = document.createElement("TR");


							}
						}
					}
				}

			}
		}

		function delete_row(element, tbl) {
			var del_index = element.parentNode.parentNode.sectionRowIndex;
			element.parentNode.parentNode.parentNode.deleteRow(del_index);
			var tbody = jQuery('tbody#'+tbl).get(0);
			renum_table_rows(tbody);
		}

		function delete_row_c(element) {
			var del_index = element.parentNode.parentNode.sectionRowIndex;
			element.parentNode.parentNode.parentNode.deleteRow(del_index);
			var tbody = jQuery('tbody#list_body_c').get(0);
			renum_table_rows(tbody);
		}

		function delete_row_m(element) {
			var del_index = element.parentNode.parentNode.sectionRowIndex;
			element.parentNode.parentNode.parentNode.deleteRow(del_index);
			var tbody = jQuery('tbody#list_body_m').get(0);
			renum_table_rows(tbody);
		}

		function addRow(tbl) {
			if (tbl == 'list_body_se') {
				var type = 'section';
				var listitem = jQuery('select#sectionid').get(0);
				var hidden_name = 'section_id[]';
				var carray = sections;
			} else if (tbl == 'list_body_ca') {
				var type = 'category';
				var listitem = jQuery('select#catid').get(0);
				var hidden_name = 'cat_id[]';
				var carray = categories;
			} else if (tbl == 'list_body_ar') {
				var type = 'article';
				var listitem = jQuery('select#contentid').get(0);
				var hidden_name = 'content_id[]';
				var carray = articles;
			}

			var tbody = jQuery('tbody#'+tbl).get(0);

			for (jj = 0; jj < listitem.options.length; jj++) {
				if (listitem.options[jj].selected == true && check_id_in_table(listitem.options[jj].value, tbl)) {
					var row = document.createElement("TR");

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
					if (parseInt(carray[listitem.options[jj].value][2]) > 0) {
						var img = 'tick.png';
						var alt = '<?php echo JText::_( 'Published' )?>';
					} else {
						var img = 'publish_x.png';
						var alt 	= '<?php echo JText::_( 'Unpublished' ); ?>';
					}
					cell_pub.innerHTML = '<img src="images/' + img + '" border="0" alt="' + alt + '" />';
					cell_pub.align = "center";


					if (type == 'category') {
						var cell_1 = document.createElement("TD");
						cell_1.innerHTML = carray[listitem.options[jj].value][3];
					}
					else if (type == 'article') {
						var cell_1 = document.createElement("TD");
						cell_1.innerHTML = carray[listitem.options[jj].value][3];
						var cell_2 = document.createElement("TD");
						cell_2.innerHTML = carray[listitem.options[jj].value][4];
						var cell_3 = document.createElement("TD");
						cell_3.innerHTML = carray[listitem.options[jj].value][5];
					}

					var cell_id = document.createElement("TD");
					cell_id.innerHTML = listitem.options[jj].value;
					cell_id.align = "center";

					var cell_last = document.createElement("TD");
					cell_last.innerHTML = '<a href="javascript: void(0);" onclick="javascript:delete_row(this,\''+tbl+'\'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>';
					cell_last.align = "center";

					row.appendChild(cell0);
					row.appendChild(cell1);
					row.appendChild(cell_pub);

					if (type == 'category') {
						row.appendChild(cell_1);
					}
					else if (type == 'article') {
						row.appendChild(cell_1);
						row.appendChild(cell_2);
						row.appendChild(cell_3);
					}
					row.appendChild(cell_id);
					row.appendChild(cell_last);
					if (type != 'article') {
						var cell_null = document.createElement("TD");
						cell_null.innerHTML = '&nbsp;';
						row.appendChild(cell_null);
					}
					tbody.appendChild(row);
				}
			}
			renum_table_rows(tbody);
		}

		function addRowC() {
			var componentid = jQuery('select#componentid').get(0);
			var front_end = jQuery('input#front_end').get(0).checked;
			var back_end = jQuery('input#back_end').get(0).checked;
			/*
			if (!front_end && !back_end) {
				alert('<?php echo JText::_( 'Select Back-End or Front-End access' ); ?>');
				return;
			}
			*/
			var tbody = jQuery('tbody#list_body_c').get(0);

			for (jj = 0; jj < componentid.options.length; jj++) {
				if (componentid.options[jj].selected == true && check_id_in_table(componentid.options[jj].value, 'list_body_c')) {

					var row = document.createElement("TR");

					var cell0 = document.createElement("TD");
					cell0.innerHTML = '0';

					var cell1 = document.createElement("TD");
					cell1.innerHTML = componentid.options[jj].text;
					var input_hidden = document.createElement("input");
					input_hidden.type = 'hidden';
					input_hidden.name = 'component_id[]';
					input_hidden.value = componentid.options[jj].value;
					cell1.appendChild(input_hidden);

					var cell2 = document.createElement("TD");
					if (front_end)
						cell2.innerHTML =  '<a href="javascript: void(0);" onclick="javascript: changeState('+(number)+');"><img id="img_'+(number)+'" src="images/tick.png" border="0" alt="<?php echo JText::_( 'Yes' ); ?>" title="<?php echo JText::_( 'Yes' ); ?>"  /><input type="hidden" id="cbx_'+(number++)+'" name="front_end_cb[]" value="1"  /></a>';
					else
						cell2.innerHTML =  '<a href="javascript: void(0);" onclick="javascript: changeState('+(number)+');"><img id="img_'+(number)+'" src="images/publish_x.png" border="0" alt="<?php echo JText::_( 'No' ); ?>" title="<?php echo JText::_( 'No' ); ?>"  /><input type="hidden" id="cbx_'+(number++)+'" name="front_end_cb[]" value="0"  /></a>';
					cell2.align = "center";

					var cell3 = document.createElement("TD");
					if (back_end)
						cell3.innerHTML =  '<a href="javascript: void(0);" onclick="javascript: changeState('+(number)+');"><img id="img_'+(number)+'" src="images/tick.png" border="0" alt="<?php echo JText::_( 'Yes' ); ?>" title="<?php echo JText::_( 'Yes' ); ?>"  /><input type="hidden" id="cbx_'+(number++)+'" name="back_end_cb[]" value="1"  /></a>';
					else
						cell3.innerHTML =  '<a href="javascript: void(0);" onclick="javascript: changeState('+(number)+');"><img id="img_'+(number)+'" src="images/publish_x.png" border="0" alt="<?php echo JText::_( 'No' ); ?>" title="<?php echo JText::_( 'No' ); ?>"  /><input type="hidden" id="cbx_'+(number++)+'" name="back_end_cb[]" value="0"  /></a>';
					cell3.align = "center";

					var cell4 = document.createElement("TD");
					cell4.innerHTML = '<a href="javascript: void(0);" onclick="javascript:delete_row_c(this); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>';
					cell4.align = "center";

					var cell5 = document.createElement("TD");
					cell5.innerHTML = '&nbsp;';

					row.appendChild(cell0);
					row.appendChild(cell1);
					row.appendChild(cell2);
					row.appendChild(cell3);
					row.appendChild(cell4);
					row.appendChild(cell5);

					tbody.appendChild(row);
				}
			}
			renum_table_rows(tbody);

		}

		function addRowMenu() {
			var menuid = jQuery('select#menuid').get(0);

			var tbody = jQuery('tbody#list_body_menu').get(0);

			var menu_ids = new Array;

			for (var jj = 0; jj < menuid.options.length; jj++) {
				if (menuid.options[jj].selected == true ) {//&& check_id_in_table(menuid.options[jj].value, 'list_body_menu')
					menu_ids[jj] = menuid.options[jj].value;
				}
			}
			var n = tbody.rows.length

			for (var i=0; i<n; i++) {
				menu_ids[jj] = parseInt(tbody.rows[0].cells[4].innerHTML);
				tbody.deleteRow(0);
				jj++;
			}

			for (var i=0; i < menus.length; i++) {
				if (menus[i] != null) {
					for (var j=0; j<menu_ids.length; j++) {
						if (menu_ids[j] == menus[i][0]) {
							j = menu_ids.length;
							var jj = i;

							var row = document.createElement("TR");

							var cell0 = document.createElement("TD");
							cell0.innerHTML = '0';

							var cell1 = document.createElement("TD");
							cell1.innerHTML = menus[jj][1];//menuid.options[jj].text;menuid.options[jj].value
							var input_hidden = document.createElement("input");
							input_hidden.type = 'hidden';
							input_hidden.name = 'menu_id[]';
							input_hidden.value = menus[jj][0];
							cell1.appendChild(input_hidden);

							var cell2 = document.createElement("TD");
							cell2.innerHTML = menus[jj][3];

							var cell3 = document.createElement("TD");
							cell3.innerHTML = menus[jj][2];

							var cell4 = document.createElement("TD");
							cell4.align = "center";
							cell4.innerHTML = menus[jj][0];

							var cell5 = document.createElement("TD");
							cell5.innerHTML = '<a href="javascript: void(0);" onclick="javascript:delete_row(this, \'list_body_menu\'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>';
							cell5.align = "center";

							var cell6 = document.createElement("TD");
							cell6.innerHTML = '&nbsp;';

							row.appendChild(cell0);
							row.appendChild(cell1);
							row.appendChild(cell2);
							row.appendChild(cell3);
							row.appendChild(cell4);
							row.appendChild(cell5);
							row.appendChild(cell6);

							tbody.appendChild(row);
						}
					}
				}
			}

			renum_table_rows(tbody);
		}

		function addRowM() {
			var moduleid = jQuery('select#moduleid').get(0);

			var tbody = jQuery('tbody#list_body_m').get(0);

			for (jj = 0; jj < moduleid.options.length; jj++) {
				if (moduleid.options[jj].selected == true && check_id_in_table(moduleid.options[jj].value, 'list_body_m')) {

					var row = document.createElement("TR");

					var cell0 = document.createElement("TD");
					cell0.innerHTML = '0';

					var cell1 = document.createElement("TD");
					cell1.innerHTML = moduleid.options[jj].text;
					var input_hidden = document.createElement("input");
					input_hidden.type = 'hidden';
					input_hidden.name = 'module_id[]';
					input_hidden.value = moduleid.options[jj].value;
					cell1.appendChild(input_hidden);

					var cell2 = document.createElement("TD");
					cell2.innerHTML = '<a href="javascript: void(0);" onclick="javascript:delete_row_m(this); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>';
					cell2.align = "center";

					var cell3 = document.createElement("TD");
					cell3.innerHTML = modules[moduleid.options[jj].value][0];
					cell3.align = "center";

					var cell4 = document.createElement("TD");
					cell4.innerHTML = modules[moduleid.options[jj].value][2];

					var cell5 = document.createElement("TD");
					cell5.innerHTML = modules[moduleid.options[jj].value][3];

					var cell_pub = document.createElement("TD");
					if (parseInt(modules[moduleid.options[jj].value][4]) > 0) {
						var img = 'tick.png';
						var alt = '<?php echo JText::_( 'Published' )?>';
					} else {
						var img = 'publish_x.png';
						var alt 	= '<?php echo JText::_( 'Unpublished' ); ?>';
					}
					cell_pub.innerHTML = '<img src="images/' + img + '" border="0" alt="' + alt + '" />';
					cell_pub.align = "center";


					var cell6 = document.createElement("TD");
					cell6.innerHTML = '&nbsp;';

					row.appendChild(cell0);
					row.appendChild(cell1);
					row.appendChild(cell2);
					row.appendChild(cell3);
					row.appendChild(cell4);
					row.appendChild(cell5);
					row.appendChild(cell_pub);
					row.appendChild(cell6);

					tbody.appendChild(row);
				}
			}
			renum_table_rows(tbody);
		}

		function changeState(elem_no) {
			var cbx = jQuery('input#cbx_'+elem_no).get(0);
			var img = jQuery('img#img_'+elem_no).get(0);
			if ( cbx.value == 1 ) {
				cbx.value = 0;
				img.src = 'images/publish_x.png';
				img.alt = '<?php echo JText::_( 'No' ); ?>';
				img.title = '<?php echo JText::_( 'No' ); ?>';
			}
			else {
				cbx.value = 1;
				img.src = 'images/tick.png';
				img.alt = '<?php echo JText::_( 'Yes' ); ?>';
				img.title = '<?php echo JText::_( 'Yes' ); ?>';
			}
		}
		function clearTable(table) {
				var tbody = jQuery('tbody#'+table).get(0);
				while ( tbody.childNodes.length >= 1 ){
        			tbody.removeChild( tbody.firstChild );
    			}
				//tbody.innerHTML = '';
			}
		/* ]]> */
		</script>

		<form action="index.php" method="post" name="adminForm">
		<?php
			echo $pane->startPane("content-pane");
			echo $pane->startPanel( 'Sections', 'Sections' );
		?>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Add New Item' ); ?></legend>
			<table class="adminform">
				<tr>
					<td  valign="top" width="10%">
						<?php echo $lists['sectionid']; ?>
					</td>
					<td valign="top"  align="left" width="auto">
						<input type="button" name="select_all" class="button" value="Select All" onclick="javascript: Select_all('sectionid');"  /><br/><br/>
						<input type="button" name="add" class="button" value="Add" onclick="javascript: addRow('list_body_se');"  />
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
						<?php echo JText::_( 'Section' ); ?>
					</th>
					<th class="title" width="10%">
						<?php echo JText::_( 'Published' ); ?>
					</th>
					<th class="title" width="5%">
						<?php echo JText::_( 'ID' ); ?>
					</th>
					<th class="title" width="10%">
						<?php echo JText::_( 'Delete' ); ?>&nbsp;&nbsp;
						<input type="button" name="clear_all" class="button" value="<?php echo JText::_( 'Clear All' ); ?>" onclick="javascript: clearTable('list_body_se');"  />
					</th>
					<th class="title" width="auto">&nbsp;
					</th>
				</tr>
			</thead>
			<tbody id="list_body_se">
			<?php
			$k = 0;
			$i = 1;
			if (is_array($lists['sections']) && count($lists['sections']))
				foreach($lists['sections'] as $row) {
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
						<input type="hidden" name="section_id[]" value="<?php echo $row->value; ?>"  />
					</td>
					<td  align="center">
						<?php echo $published; ?>
					</td>
					<td  align="center">
						<?php echo $row->value; ?>
					</td>
					<td align="center">
						<a href="javascript: void(0);" onclick="javascript:delete_row(this, 'list_body_se'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>
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
		echo $pane->startPanel( 'Categories', 'Categories' );
		?>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Add New Item' ); ?></legend>
			<table class="adminform">
				<tr>
					<td  valign="top" width="10%">
						<?php echo $lists['catid']; ?>
					</td>
					<td valign="top" align="left" width="auto">
						<input type="button" name="select_all" class="button" value="Select All" onclick="javascript: Select_all('catid');"  /><br/><br/>
						<input type="button" name="add" class="button" value="Add" onclick="javascript: addRow('list_body_ca');"  />
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
						<?php echo JText::_( 'Category' ); ?>
					</th>
					<th class="title" width="8%">
						<?php echo JText::_( 'Published' ); ?>
					</th>
					<th class="title" width="15%">
						<?php echo JText::_( 'Section' ); ?>
					</th>
					<th class="title" width="5%">
						<?php echo JText::_( 'ID' ); ?>
					</th>
					<th class="title"  width="10%">
						<?php echo JText::_( 'Delete' ); ?>&nbsp;&nbsp;
						<input type="button" name="clear_all" class="button" value="<?php echo JText::_( 'Clear All' ); ?>" onclick="javascript: clearTable('list_body_ca');"  />
					</th>
					<th class="title" width="auto">&nbsp;

					</th>
				</tr>
			</thead>
			<tbody id="list_body_ca">
			<?php
			$k = 0;
			$i = 1;
			if (is_array($lists['categories']) && count($lists['categories']))
				foreach($lists['categories'] as $row) {
					$img = $row->published ? 'tick.png' : 'publish_x.png';
					$alt 	= $row->published ? JText::_( 'Published' ) : JText::_( 'Unpublished' );
					$published 	= '<img src="images/'. $img .'" border="0" alt="'. $alt .'" />';
			?>
				<tr  class="row<?php echo $k; ?>">
					<td width="2%">
						<?php echo $i++; ?>
					</td>
					<td>
						<?php echo ($row->value > 0?$row->title: JText::_('Uncategorized')); ?>
						<input type="hidden" name="cat_id[]" value="<?php echo $row->value; ?>"  />
					</td>
					<td  align="center">
						<?php echo $published; ?>
					</td>
					<td >
						<?php echo $row->section_name; ?>
					</td>
					<td  align="center">
						<?php echo $row->value; ?>
					</td>
					<td align="center">
						<a href="javascript: void(0);" onclick="javascript:delete_row(this, 'list_body_ca'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>
					</td>
					<td>&nbsp;

					</td>
				</tr>
			<?php
					$k = 1 - $k;
				}?>
			</tbody>
			</table>
		</fieldset>
		<?php
		echo $pane->endPanel();
		echo $pane->startPanel( 'Articles', 'Articles' );
		?>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Add New Item' ); ?></legend>
			<table class="adminform">
				<tr>
					<td  valign="top" width="10%">
						<?php echo $lists['contentid']; ?>
					</td>
					<td  valign="top"  align="left" width="auto">
						<input type="button" name="select_all" class="button" value="Select All" onclick="javascript: Select_all('contentid');"  /><br/><br/>
						<input type="button" name="add" class="button" value="Add" onclick="javascript: addRow('list_body_ar');"  />
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
					<th class="title" width="35%">
						<?php echo JText::_( 'Article' ); ?>
					</th>
					<th class="title" width="8%">
						<?php echo JText::_( 'Published' ); ?>
					</th>
					<th class="title" width="15%">
						<?php echo JText::_( 'Section' ); ?>
					</th>
					<th class="title" width="15%">
						<?php echo JText::_( 'Category' ); ?>
					</th>
					<th class="title" width="10%">
						<?php echo JText::_( 'Author' ); ?>
					</th>
					<th class="title" width="2%">
						<?php echo JText::_( 'ID' ); ?>
					</th>
					<th class="title" width="10%">
						<?php echo JText::_( 'Delete' ); ?>&nbsp;&nbsp;
						<input type="button" name="clear_all" class="button" value="<?php echo JText::_( 'Clear All' ); ?>" onclick="javascript: clearTable('list_body_ar');"  />
					</th>
				</tr>
			</thead>
			<tbody id="list_body_ar">
			<?php
			$k = 0;
			$i = 1;
			if (is_array($lists['contents']) && count($lists['contents']))
				foreach($lists['contents'] as $row) {
					$img = $row->published ? 'tick.png' : 'publish_x.png';
					$alt 	= $row->published ? JText::_( 'Published' ) : JText::_( 'Unpublished' );
					$published 	= '<img src="images/'. $img .'" border="0" alt="'. $alt .'" />';
			?>
				<tr  class="row<?php echo $k; ?>">
					<td width="2%">
						<?php echo $i++; ?>
					</td>
					<td>
						<?php echo $row->title; ?>
						<input type="hidden" name="content_id[]" value="<?php echo $row->value; ?>"  />
					</td>
					<td  align="center">
						<?php echo $published; ?>
					</td>
					<td >
						<?php echo $row->section_name; ?>
					</td>
					<td >
						<?php echo $row->cat_name; ?>
					</td>
					<td >
						<?php echo $row->author_name; ?>
					</td>
					<td  align="center">
						<?php echo $row->value; ?>
					</td>
					<td align="center">
						<a href="javascript: void(0);" onclick="javascript:delete_row(this, 'list_body_ar'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>
					</td>
				</tr>
			<?php
					$k = 1 - $k;
				}?>
			</tbody>
			</table>
		</fieldset>
		<?php
		echo $pane->endPanel();
		echo $pane->startPanel( 'Components', 'Component' );
		?>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Add New Item' ); ?></legend>
		<table class="adminform">
				<tr>
					<td  valign="top" width="10%">
						<?php echo $lists['componentid']; ?>
					</td>
					<td  valign="top" width="13%" align="left">
						<label><input type="checkbox" name="front_end" id="front_end" value="1" checked="checked" />&nbsp;<?php echo JText::_( 'Front End' ); ?></label><br />
						<label><input type="checkbox" name="back_end" id="back_end" value="1" checked="checked" />&nbsp;<?php echo JText::_( 'Back End' ); ?></label>
					</td>
					<td  valign="top" width="auto" align="left">
						<input type="button" name="select_all" class="button" value="Select All" onclick="javascript: Select_all('componentid');"  /><br/><br/>
						<input type="button" name="add" class="button" value="Add" onclick="javascript: addRowC();"  />
					</td>
				</tr>
		</table>
		</fieldset>
		<fieldset class="adminform">
		<legend><?php echo ($default_action == 'deny'?JText::_( 'List of Allowed Components' ):JText::_( 'List of Forbidden Components' )); ?></legend>
		<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th class="title" width="25%">
					<?php echo JText::_( 'Component' ); ?>
				</th>
				<th class="title" width="15%">
					<?php echo ($default_action == 'deny'?JText::_( 'Allow in Front End' ):JText::_( 'Forbid in Front End' )); ?>
				</th>
				<th class="title" width="15%">
					<?php echo ($default_action == 'deny'?JText::_( 'Allow Back End' ):JText::_( 'Forbid Back End' )); ?>
				</th>
				<th class="title" width="15%">
					<?php echo JText::_( 'Delete' ); ?>&nbsp;&nbsp;
					<input type="button" name="clear_all" class="button" value="<?php echo JText::_( 'Clear All' ); ?>" onclick="javascript: clearTable('list_body_c');"  />
				</th>
				<th class="title" width="auto">
				</th>
			</tr>
		</thead>
		<tbody id="list_body_c">
		<?php
				$k = 0;
				$i = 1;
				$j = 1;
				if (is_array($lists['components']) && count($lists['components']))
					foreach($lists['components'] as $row) {
				?>
					<tr  class="row<?php echo $k; ?>">
						<td width="2%">
							<?php echo $i++; ?>
						</td>
						<td>
							<?php echo $row->title; ?>
							<input type="hidden" name="component_id[]" value="<?php echo $row->value; ?>"  />
						</td>
						<td align="center">
							<?php if ($row->isfrontend == 1) { ?>
							<a href="javascript: void(0);" onclick="javascript: changeState(<?php echo $j;?>);"><img id="img_<?php echo $j;?>" src="images/tick.png" border="0" alt="<?php echo JText::_( 'Yes' ); ?>" title="<?php echo JText::_( 'Yes' ); ?>"  />
							<input type="hidden" id="cbx_<?php echo $j++;?>" name="front_end_cb[]" value="1"  /></a>
							<?php } else {?>
							<a href="javascript: void(0);" onclick="javascript: changeState(<?php echo $j;?>);"><img id="img_<?php echo $j;?>" src="images/publish_x.png" border="0" alt="<?php echo JText::_( 'No' ); ?>" title="<?php echo JText::_( 'No' ); ?>"  />
							<input type="hidden" id="cbx_<?php echo $j++;?>" name="front_end_cb[]" value="0"  /></a>
							<?php }?>
						</td>
						<td  align="center">
							<?php if ($row->isbackend == 1) { ?>
							<a href="javascript: void(0);" onclick="javascript: changeState(<?php echo $j;?>);"><img id="img_<?php echo $j;?>" src="images/tick.png" border="0" alt="<?php echo JText::_( 'Yes' ); ?>" title="<?php echo JText::_( 'Yes' ); ?>"  />
							<input type="hidden" id="cbx_<?php echo $j++;?>" name="back_end_cb[]" value="1"  /></a>
							<?php } else {?>
							<a href="javascript: void(0);" onclick="javascript: changeState(<?php echo $j;?>);"><img id="img_<?php echo $j;?>" src="images/publish_x.png" border="0" alt="<?php echo JText::_( 'No' ); ?>" title="<?php echo JText::_( 'No' ); ?>"  />
							<input type="hidden" id="cbx_<?php echo $j++;?>" name="back_end_cb[]" value="0"  /></a>
							<?php }?>
						</td>
						<td  align="center">
							<a href="javascript: void(0);" onclick="javascript:delete_row_c(this); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>
						</td>
						<td width="auto">&nbsp;

						</td>
					</tr>
				<?php
						$k = 1 - $k;
					}?>
		</tbody>
		</table>
		</fieldset>
		<?php
		echo $pane->endPanel();

		echo $pane->startPanel( 'Menus', 'Menus' );
		?>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Add New Item' ); ?></legend>
		<table class="adminform">
				<tr>
					<td  valign="top" width="10%">
						<?php echo $lists['menuid']; ?>
					</td>
					<td  valign="top" width="auto" align="left">
						<input type="button" name="select_all" class="button" value="Select All" onclick="javascript: Select_all('menuid');"  /><br/><br/>
						<input type="button" name="add" class="button" value="Add" onclick="javascript: addRowMenu();"  />
					</td>
				</tr>
		</table>
		</fieldset>
		<fieldset class="adminform">
		<legend><?php echo ($default_action == 'deny'?JText::_( 'List of Allowed Menus' ):JText::_( 'List of Forbidden Menus' )); ?></legend>
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
				<th class="title" width="25%">
					<?php echo JText::_( 'Parent' ); ?>
				</th>
				<th class="title" width="10%">
					<?php echo JText::_( 'Item ID' ); ?>
				</th>
				<th class="title" width="15%">
					<?php echo JText::_( 'Delete' ); ?>&nbsp;&nbsp;
					<input type="button" name="clear_all" class="button" value="<?php echo JText::_( 'Clear All' ); ?>" onclick="javascript: clearTable('list_body_menu');"  />
				</th>
				<th class="title" width="auto">
				</th>
			</tr>
		</thead>
		<tbody id="list_body_menu">
		<?php
				$k = 0;
				$i = 1;
				$j = 1;
				if (is_array($lists['menus']) && count($lists['menus']))
					foreach($lists['menus'] as $row) {
				?>
					<tr  class="row<?php echo $k; ?>">
						<td width="2%">
							<?php echo $i++; ?>
						</td>
						<td>
							<?php echo $row->name; ?>
							<input type="hidden" name="menu_id[]" value="<?php echo $row->value; ?>"  />
						</td>
						<td>
							<?php echo $row->menu_name; ?>
						</td>
						<td>
							<?php echo $row->parent_name; ?>
						</td>
						<td align="center">
							<?php echo $row->value; ?>
						</td>
						<td  align="center">
							<a href="javascript: void(0);" onclick="javascript:delete_row(this, 'list_body_menu'); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>
						</td>
						<td width="auto">&nbsp;

						</td>
					</tr>
				<?php
						$k = 1 - $k;
					}?>
		</tbody>
		</table>
		</fieldset>
		<?php
		echo $pane->endPanel();
		echo $pane->startPanel( 'Modules', 'modules' );
		?>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Add New Item' ); ?></legend>
		<table class="adminform">
				<tr>
					<td  valign="top" width="10%">
						<?php echo $lists['moduleid']; ?>
					</td>
					<td  valign="top" width="auto" align="left">
						<input type="button" name="select_all" class="button" value="Select All" onclick="javascript: Select_all('moduleid');"  /><br/><br/>
						<input type="button" name="add" class="button" value="Add" onclick="javascript: addRowM();"  />
					</td>
				</tr>
		</table>
		</fieldset>
		<fieldset class="adminform">
		<legend><?php echo ($default_action == 'deny'?JText::_( 'List of Allowed Modules' ):JText::_( 'List of Forbidden Modules' )); ?></legend>
		<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th class="title" width="25%">
					<?php echo JText::_( 'Module' ); ?>
				</th>
				<th class="title" width="15%">
					<?php echo JText::_( 'Delete' ); ?>&nbsp;&nbsp;
					<input type="button" name="clear_all" class="button" value="<?php echo JText::_( 'Clear All' ); ?>" onclick="javascript: clearTable('list_body_m');"  />
				</th>
				<th class="title" width="5%">
					<?php echo JText::_( 'ID' ); ?>
				</th>
				<th class="title" width="10%">
					<?php echo JText::_( 'Position' ); ?>
				</th>
				<th class="title" width="15%">
					<?php echo JText::_( 'Type' ); ?>
				</th>
				<th class="title" width="10%" align="center">
					<?php echo JText::_( 'Enabled' ); ?>
				</th>
				<th class="title" width="auto">&nbsp;
				</th>
			</tr>
		</thead>
		<tbody id="list_body_m">
		<?php
				$k = 0;
				$i = 1;
				if (is_array($lists['modules']) && count($lists['modules']))
					foreach($lists['modules'] as $row) {
						$img = $row->published ? 'tick.png' : 'publish_x.png';
						$alt 	= $row->published ? JText::_( 'Published' ) : JText::_( 'Unpublished' );
						$published 	= '<img src="images/'. $img .'" border="0" alt="'. $alt .'" />';
				?>
					<tr  class="row<?php echo $k; ?>">
						<td width="2%">
							<?php echo $i++; ?>
						</td>
						<td>
							<?php echo $row->title; ?>
							<input type="hidden" name="module_id[]" value="<?php echo $row->value; ?>"  />
						</td>
						<td align="center">
							<a href="javascript: void(0);" onclick="javascript:delete_row_m(this); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>
						</td>
						<td align="center">
							<?php echo $row->value; ?>
						</td>
						<td>
							<?php echo $row->position; ?>
						</td>
						<td>
							<?php echo $row->module; ?>
						</td>
						<td  align="center">
							<?php echo $published; ?>
						</td>
						<td width="auto">&nbsp;
						</td>
					</tr>
				<?php
						$k = 1 - $k;
					}?>
		</tbody>
		</table>
		</fieldset>
		<?php
		echo $pane->endPanel();
		# - Kobby added a panel for the redirects

		echo $pane->startPanel( 'Redirect', 'Redirect' ); ?>
			<fieldset class="adminform">
			<legend><?php echo JText::_( 'Login Redirect' ); ?></legend>
			<table class="adminform">
					<tr>
						<td valign="top" width="10%">Frontend: </td>
						<td  valign="top">
							<input type="text" value="<?php echo @$lists['frontend_redirect']; ?>" name="frontend_redirect" size="100" /><br />
						</td>
					</tr>
					<tr>
						<td valign="top" width="10%">Backend: </td>
						<td  valign="top">
							<input type="text" value="<?php echo @$lists['backend_redirect']; ?>" name="backend_redirect" size="100" />	<br />
						</td>
					</tr>
			</table>
			</fieldset>
		<?php echo $pane->endPanel();

		echo $pane->startPanel( JText::_( 'Article Submission' ), 'Article Submission' );

		//Initialize the variables
		$fp_Yes 		= NULL;
		$meta_Yes 		= NULL;
		$startPub_Yes	= NULL;
		$startPub_No	= NULL;
		$finishPub_Yes	= NULL;
		$finishPub_No	= NULL;
		$au_Yes			= NULL;
		$au_No			= NULL;
		$ac_Yes			= NULL;
		$ac_No			= NULL;
		$meta_No		= NULL;
		$fp_Yes 		= NULL;
		$fp_No  		= NULL;

		if(!array_key_exists('article_submissions',$lists))
			$lists['article_submissions'] = array();

		//newly created role or group
		if(!$lists['article_submissions']){
			$fp_Yes 		= 'checked';
			$meta_Yes 		='checked';
			$startPub_Yes 	= 'checked';
			$finishPub_Yes 	= 'checked';
			$au_Yes 		= 'checked';
			$ac_Yes 		= 'checked';
		}



			for($i=0; $i < count($lists['article_submissions']); $i++){
				switch($i){
					case 0:
						if($lists['article_submissions'][$i] == '1')
							$fp_Yes = 'checked';
						else
							$fp_No = 'checked';
					break;
					case 1:
						if($lists['article_submissions'][$i] == '1')
							$meta_Yes ='checked';
						else
							$meta_No = 'checked';
					break;
					case 2:
						if($lists['article_submissions'][$i] == '1')
							$startPub_Yes = 'checked';
						else
							$startPub_No = 'checked';
					break;
					case 3:
						if($lists['article_submissions'][$i] == '1')
							$finishPub_Yes = 'checked';
						else
							$finishPub_No = 'checked';
					break;
					case 4:
						if($lists['article_submissions'][$i] == '1')
							$au_Yes = 'checked';
						else
							$au_No = 'checked';
					break;
					case 5:
						if($lists['article_submissions'][$i] == '1')
							$ac_Yes = 'checked';
						else
							$ac_No = 'checked';
					break;

				}
			}

			?>
				<table class="adminlist" cellpadding="1">
					<tr>
						<th width="22%">Items</th>
						<th width="22%">Choices</th>
					</tr>
					<tr>
						<td width="22%">Show Frontpage </td>
						<td width="22%"><input type="radio" name="show_frontpage" value="1" <?php echo $fp_Yes; ?>/>Yes &nbsp;
						<input type="radio" name="show_frontpage" value="0" <?php echo $fp_No; ?> />No </td>
					</tr>
					<tr>
						<td width="22%">Show Start Publishing </td>
						<td width="22%">
							<input type="radio" name="show_start_publishing" value="1" <?php echo $startPub_Yes; ?> />Yes &nbsp;
							<input type="radio" name="show_start_publishing" value="0" <?php echo $startPub_No; ?> />No
						</td>
					</tr>
					<tr>
						<td width="22%">Show Finish Publishing </td>
						<td width="22%">
							<input type="radio" name="show_finish_publishing" value="1" <?php echo $finishPub_Yes; ?> />Yes &nbsp;
							<input type="radio" name="show_finish_publishing" value="0" <?php echo $finishPub_No; ?> />No
						</td>
					</tr>
					<tr>
						<td width="22%">Show Author Alias  </td>
						<td width="22%">
							<input type="radio" name="show_alias" value="1" <?php echo $au_Yes; ?> />Yes &nbsp;
							<input type="radio" name="show_alias" value="0" <?php echo $au_No; ?>  />No
						</td>
					</tr>
					<tr>
						<td width="22%">Show Access Level </td>
						<td width="22%">
							<input type="radio" name="show_access" value="1" <?php echo $ac_Yes; ?> />Yes &nbsp;
							<input type="radio" name="show_access" value="0" <?php echo $ac_No; ?> />No
						</td>
					</tr>
					<tr>
						<td width="22%">Show Metadata Fields  </td>
						<td width="22%">
							<input type="radio" name="show_metadata" value="1" <?php echo $meta_Yes; ?> />Yes &nbsp;
							<input type="radio" name="show_metadata" value="0" <?php echo $meta_No; ?> />No
						</td>
					</tr>
				</table>
			<?php
			echo $pane->endPanel();




		// added 3rd party plugin support -BUR 01/18/2011
		if (JPluginHelper::isEnabled('system', 'cacl_docman')){
			plgSystemCacl_docman::getAdminUi($pane, $lists, $default_action);
		}
		//end 3rd party plugin support

		//adam added 3rd party plugin support
		if (JPluginHelper::isEnabled('system', 'cacl_joomsocial')){
			plgSystemCacl_joomsocial::getAdminUi($pane, $lists, $default_action);
		}
		//end adam added 3rd party plugin support

		echo $pane->endPane();

		?>
		<input type="hidden" name="option" value="com_community_acl" />
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="mode" value="<?php echo $mode; ?>" />
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php



		left_menu_footer();
	}

	function showAssignUsers($lists) {
		left_menu_header();
		?>
			<script language="javascript" type="text/javascript">
			/* <![CDATA[ */
			var grouproles = new Array;
			<?php
			$i = 0;
			foreach ($lists['cacl_rid_arr'] as $k=>$v) {
				echo "grouproles[".$k++."] = new Array( '".addslashes( $v['group'] )."','".addslashes( $v['value'] )."','".addslashes( $v['text'] )."' );\n\t\t";
			}
			?>

			function renum_table_rows(tbl_elem) {
				if (tbl_elem.rows[0]) {
					var count = 1;
					var row_k = 1 - 1%2;
					for (var i=0; i<tbl_elem.rows.length; i++) {
						tbl_elem.rows[i].cells[0].innerHTML = count;
						tbl_elem.rows[i].className = 'row'+row_k;
						count++;
						row_k = 1 - row_k;
					}
				}
			}

			function delete_row(element) {
				var del_index = element.parentNode.parentNode.sectionRowIndex;
				element.parentNode.parentNode.parentNode.deleteRow(del_index);
				//var tbody = element.parentNode.parentNode;
				var tbody = jQuery('tbody#list_body').get(0);
				renum_table_rows(tbody);
			}

			function addRow() {
				var cacl_group_list = jQuery('select#cacl_group_list').get(0);
				var cacl_role_list = jQuery('select#cacl_role_list').get(0);
				var cacl_func_list = jQuery('select#cacl_func_list').get(0);

				var tbody = jQuery('tbody#list_body').get(0);

				var row = document.createElement("TR");

				var cell0 = document.createElement("TD");
				cell0.innerHTML = '0';

				var cell1 = document.createElement("TD");
				cell1.innerHTML = cacl_group_list.options[cacl_group_list.selectedIndex].text;
				var input_hidden = document.createElement("input");
				input_hidden.type = 'hidden';
				input_hidden.name = 'cacl_group_id[]';
				input_hidden.value = cacl_group_list.options[cacl_group_list.selectedIndex].value;
				cell1.appendChild(input_hidden);

				var cell2 = document.createElement("TD");
				cell2.innerHTML = cacl_role_list.options[cacl_role_list.selectedIndex].text;
				var input_hidden = document.createElement("input");
				input_hidden.type = 'hidden';
				input_hidden.name = 'cacl_role_id[]';
				input_hidden.value = cacl_role_list.options[cacl_role_list.selectedIndex].value;
				cell2.appendChild(input_hidden);

				var cell3 = document.createElement("TD");
				cell3.innerHTML = cacl_func_list.options[cacl_func_list.selectedIndex].text;
				var input_hidden = document.createElement("input");
				input_hidden.type = 'hidden';
				input_hidden.name = 'cacl_func_id[]';
				input_hidden.value = cacl_func_list.options[cacl_func_list.selectedIndex].value;
				cell3.appendChild(input_hidden);

				var cell4 = document.createElement("TD");
				cell4.innerHTML = '<a href="javascript: void(0);" onClick="javascript:delete_row(this); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"/></a>';
				cell4.align = "center";

				var cell5 = document.createElement("TD");

				row.appendChild(cell0);
				row.appendChild(cell1);
				row.appendChild(cell2);
				row.appendChild(cell3);
				row.appendChild(cell4);
				row.appendChild(cell5);
				tbody.appendChild(row);
				renum_table_rows(tbody);
			}
		/* ]]> */
		</script>
		<form action="index.php" method="post" name="adminForm">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Assign following users to group/role' ); ?></legend>
		<?php
			if (is_array($lists['user_list']) && count($lists['user_list']) > 0)
			foreach ($lists['user_list'] as $user) {
				echo $user->name.', ';
				?>
				<input type="hidden" name="cid[]" value="<?php echo $user->id; ?>"  />
				<?php
			}

		?>
		<br />
		<br />
		<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th class="title" width="20%">
					<?php echo JText::_( 'Group' ); ?>
				</th>
				<th class="title" width="20%">
					<?php echo JText::_( 'Role' ); ?>
				</th>
				<th class="title" width="20%">
					<?php echo JText::_( 'Function' ); ?>
				</th>
				<th class="title" width="10%">
					<?php echo JText::_( 'Delete' ); ?>
				</th>
				<th class="title" width="auto">&nbsp;</th>
			</tr>
		</thead>
		<tbody id="list_body">
		</tbody>
		</table>
		<table class="adminform" cellspacing="1">
			<tr>
				<td width="1%" valign="top" class="key">&nbsp;

				</td>
				<td valign="top" class="key" width="5%">
					<?php echo $lists['cacl_gid']; ?>
				</td>
				<td valign="top" class="key" width="5%">
					<?php echo $lists['cacl_rid']; ?>
				</td>
				<td valign="top" class="key" width="5%">
					<?php echo $lists['cacl_fid']; ?>
				</td>
				<td valign="top" class="key" width="5%">
					<input <?php if ($lists['cacl_gid'] == JText::_( 'There is no groups' ) || $lists['cacl_rid'] == JText::_( 'There is no roles' ) || $lists['cacl_fid'] == JText::_( 'There is no functions' )) echo ' disabled="disabled" ';
						if($lists['cacl_rid'] == JText::_( 'None' ) ) echo ' disabled="disabled" ';?>type="button" name="select_all" class="button" value="Add" onclick="javascript: addRow();"  />
				</td>
				<td valign="top" class="key" width="auto">&nbsp;</td>
			</tr>
		</table>
		</fieldset>
		<input type="hidden" name="option" value="com_community_acl" />
		<input type="hidden" name="task" value="" />
		</form>
		<script type="text/javascript" language="javascript">
		/* <![CDATA[ */
			try {
				changeDynaList( 'cacl_role_list', grouproles, document.adminForm.cacl_group_list.options[document.adminForm.cacl_group_list.selectedIndex].value, 0, 0);
			} catch(e){}
		/* ]]> */
		</script>
		<?php
		left_menu_footer();
	}

	function showUnassignUsers($lists) {
		left_menu_header();
		?>
		<form action="index.php" method="post" name="adminForm">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Unassign following users from selected group/role' ); ?></legend>
		<?php
			if (is_array($lists['user_list']) && count($lists['user_list']) > 0)
			foreach ($lists['user_list'] as $user) {
				echo $user->name.', ';
				?>
				<input type="hidden" name="cid[]" value="<?php echo $user->id; ?>"  />
				<?php
			}

		?>
		<br />
		<br />
		<strong><?php echo JText::_( 'Select groups and roles from which user should be removed:' ); ?></strong>
		<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">&nbsp;

				</th>
				<th class="title" width="2%">
					<?php echo JText::_( 'Group' ); ?>
				</th>
				<th class="title" width="2%">
					<?php echo JText::_( 'Role' ); ?>
				</th>
				<th class="title" width="auto">&nbsp;</th>
			</tr>
		</thead>
		<tbody id="list_body">
			<tr>
				<td  valign="top" >&nbsp;
				</td>
				<td valign="top"  >
					<?php echo $lists['cacl_gid']; ?>
				</td>
				<td valign="top"  >
					<?php echo $lists['cacl_rid']; ?>
				</td>
				<td valign="top" width="auto">&nbsp;</td>
			</tr>
		</tbody>
		</table>
		</fieldset>
		<input type="hidden" name="option" value="com_community_acl" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="1" />
		</form>
		<?php
		left_menu_footer();
	}

	function showUserAccessR($rows, $pagination, $mode, $pid) {
		left_menu_header();
		?>
		<form action="index.php" method="post" name="adminForm">
		<table class="adminlist" cellpadding="1">
			<thead>
				<tr>
					<th width="2%" class="title" align="center">
						<?php echo JText::_( 'NUM' ); ?>
					</th>
					<th width="3%" class="title">
						<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" />
					</th>
					<th class="title">
						<?php echo JText::_( 'Name' ); ?>
					</th>
					<th width="15%" class="title" >
						<?php echo JText::_( 'Username' ); ?>
					</th>
					<th width="15%" class="title">
						<?php echo JText::_( 'Group' ); ?>
					</th>
					<th width="15%" class="title">
						<?php echo JText::_( 'E-Mail' ); ?>
					</th>
					<th width="10%" class="title">
						<?php echo JText::_( 'Last Visit' ); ?>
					</th>
					<th width="auto" class="title">&nbsp;
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="8">
						<?php echo $pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>
			<?php
				$k = 0;
				for ($i=0, $n=count( $rows ); $i < $n; $i++)
				{
					$row 	=& $rows[$i];

					if ($row->lastvisitDate == "0000-00-00 00:00:00") {
						$lvisit = JText::_( 'Never' );
					} else {
						$lvisit	= $row->lastvisitDate;
					}
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td>
						<?php echo $i+1+$pagination->limitstart;?>
					</td>
					<td align="center">
						<?php echo JHTML::_('grid.id', $i, $row->id ); ?>
					</td>
					<td>
						<?php echo $row->name; ?></a>
					</td>
					<td>
						<?php echo $row->username; ?>
					</td>
					<td>
						<?php  echo JText::_( $row->groupname ); ?>
					</td>
					<td>
						<a href="mailto:<?php echo $row->email; ?>">
							<?php echo $row->email; ?></a>
					</td>
					<td nowrap="nowrap">
						<?php echo $lvisit; ?>
					</td>
					<td>&nbsp;</td>
				</tr>
				<?php
					$k = 1 - $k;
					}
				?>
			</tbody>
		</table>
		<input type="hidden" name="option" value="com_community_acl" />
		<input type="hidden" name="mode" value="<?php echo $mode;?>" />
		<input type="hidden" name="pid" value="<?php echo $pid;?>" />

		<input type="hidden" name="task" value="delete_users_access" />
		<input type="hidden" name="boxchecked" value="0" />
		</form>
		<?php
		left_menu_footer();
	}

	function showUserAccessA($lists, $rows, $pagination, $mode, $pid) {
		left_menu_header();
		$rid = JRequest::getVar('role_id');

		//print_r($rows);
		?>

	<form action="index.php?option=com_community_acl&amp;task=add_users_access&amp;mode=group_id&amp;role_id=<?php echo $rid; ?>&amp;role_selected=true&amp;cid[]=<?php echo $rid; ?>" method="post" name="adminForm">

		<?php  JHTML::_('behavior.tooltip'); ?>
		<div style="text-align:right; width:100%; padding-bottom:10px;"><strong><?php echo JText::_( 'Add user(s) with function:' ) . ' ' . $lists['cacl_fid'];?></strong></div>
		<table class="adminlist" cellpadding="1">
			<thead>
				<tr>
					<th width="2%" class="title" align="center">
						<?php echo JText::_( 'NUM' ); ?>
					</th>
					<th width="3%" class="title">
						<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" />
					</th>
					<th class="title">
						<?php echo JHTML::_('grid.sort',   'Name', 'b.name', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
					<th width="15%" class="title" >
						<?php echo JText::_( 'Username' ); ?>
					</th>
					<th width="15%" class="title">
						<?php echo JText::_( 'Group' ); ?>
					</th>
					<th width="15%" class="title">
						<?php echo JText::_( 'E-Mail' ); ?>
					</th>
					<th width="10%" class="title">
						<?php echo JText::_( 'Last Visit' ); ?>
					</th>
					<th width="auto" class="title">&nbsp;
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="8">
						<?php echo $pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>
			<?php
				$k = 0;
				for ($i=0, $n=count( $rows ); $i < $n; $i++)
				{
					$row 	=& $rows[$i];

					if ($row->lastvisitDate == "0000-00-00 00:00:00") {
						$lvisit = JText::_( 'Never' );
					} else {
						$lvisit	= $row->lastvisitDate;
					}
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td>
						<?php echo $i+1+$pagination->limitstart;?>
					</td>
					<td align="center">
						<?php echo JHTML::_('grid.id', $i, $row->id ); ?>
					</td>
					<td>
						<?php echo $row->name; ?></a>
					</td>
					<td>
						<?php echo $row->username; ?>
					</td>
					<td>
						<?php echo JText::_( $row->groupname ); ?>
					</td>
					<td>
						<a href="mailto:<?php echo $row->email; ?>">
							<?php echo $row->email; ?></a>
					</td>
					<td nowrap="nowrap">
						<?php echo $lvisit; ?>
					</td>
					<td>&nbsp;</td>
				</tr>
				<?php
					$k = 1 - $k;
					}
				?>
			</tbody>
		</table>
		<input type="hidden" name="option" value="com_community_acl" />
		<input type="hidden" name="mode" value="<?php echo $mode;?>" />
		<input type="hidden" name="pid" value="<?php echo $pid;?>" />
		<input type="hidden" name="rid" value="<?php echo $rid; ?>"/>
		<input type="hidden" name="task" value="add_users_access" />
		<input type="hidden" name="boxchecked" value="0" />

		<input type="hidden" name="filter_order" value="<?php echo @$lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="" />
		</form>
		<?php
		left_menu_footer();
	}

	function changelog(){
		left_menu_header();
	?>
		<table>
		<tr>
			<td>
				<div style="text-align:left; padding:5px; font-family: verdana, arial, sans-serif; font-size: 9pt;">
					<?php include_once(_COMMUNITY_ACL_ADMIN_HOME.'/changelog.php'); ?>
				</div>
			</td>
		</tr>
		</table>
	<?php
		left_menu_footer();
	}

	function disclaimer(){
		left_menu_header();
	?>
		<table>
		<tr>
			<td>
				<div style="text-align:left; padding:5px; font-family: verdana, arial, sans-serif; font-size: 9pt;">
					<?php include_once(_COMMUNITY_ACL_ADMIN_HOME.'/disclaimer.php'); ?>
				</div>
			</td>
		</tr>
		</table>
	<?php
		left_menu_footer();
	}

	function synchronize(){
		global $option;
		$db =& JFactory::getDBO();
		$config = new CACL_config($db);
		$config->load();
		left_menu_header();
		?>
		<script language="javascript" type="text/javascript">
		/* <![CDATA[ */
		function submitbutton(pressbutton) {

			<?php if (!$config->synchronize) {?>
			alert('Synchronization is not enabled in configuration!')
			<?php }else {?>
			jQuery('div#message').get(0).style.display = 'none';
			jQuery('div#image').get(0).style.display = '';
			submitform(pressbutton);
			<?php }?>
		}
		/* ]]> */
		</script>
		<form action="index.php" method="post" name="adminForm">
		<table class="adminlist">
		<tr><th class="title">Synchonization</th></tr>
		<tr><td><br />
		<div id="message" style="width:100%; text-align:left;">
			<?php if (!$config->synchronize) {?>
			<strong>Synchronization is not enabled in configuration!</strong>
			<?php }else {?>
			<strong>Items to synchronize (defined in configuration):</strong>
			<table>
			<tr><td>Joomla! users and CB users fields:</td><td><img border="0" alt="Published" src="images/<?php echo ($config->users_and_cb? 'tick.png': 'publish_x.png')?>" />
</td></tr>
			<tr><td>CB Contact component:</td><td><img border="0" alt="Published" src="images/<?php echo ($config->cb_contact? 'tick.png': 'publish_x.png')?>" />
</td></tr>
			<tr><td>Community ACL Groups, Roles, Functions and access restrictions:</td><td><img border="0" alt="Published" src="images/<?php echo ($config->cacl_grf? 'tick.png': 'publish_x.png')?>" />
</td></tr>
			</table><br />
			<strong><?php echo JText::_('Press `Synchronize` button to begin.') ?></strong>
			<?php }?>
		</div>
		<div id="image" style="width:100%; text-align:left; display:none;">
			<img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/administrator/components/<?php echo $option; ?>/images/progress.gif" alt="Synchonization in progress" title="" border=""  /><br />

			<?php echo JText::_('Synchonization in progress. Please wait, it may take some time.') ?>

		</div>
		</td>
		</tr>
		</table>
		<input type="hidden" name="option" value="com_community_acl" />
		<input type="hidden" name="task" value="" />
		</form>
		<?php
		left_menu_footer();
	}
}



function left_menu_header($title = _COMMUNITY_ACL_COMP_NAME, $icon = 'static'){
	global $option;
	$task = JRequest::getCmd('task');
	$mode = JRequest::getCmd('mode');
	$db =& JFactory::getDBO();
	$config = new CACL_config($db);
	$config->load();

	if ($mode == 'manage_users' && $task != 'help')
		$task = $mode;

	//JToolBarHelper::title( $title, $icon.'.png' );
	require_once(_COMMUNITY_ACL_ADMIN_HOME.'/admin.community_acl.style.php');
	$show = 0;
	if ($task == 'config' || $task == 'synchronize' ) {
		$show = 0;
	}elseif ($task == 'language' || $task == 'language_files' || $task == 'edit_language' ) {
		$show = 1;
	}elseif ($task == 'manage_users' || $task == 'assign_users' || $task == 'unassign_users' ) {
		$show = 2;
	}elseif($task == 'list_sites' || $task == 'site_edit' || $task == 'site_add')  {
		$show = 3;
	}elseif ($task == 'list_groups' || $task == 'group_add' || $task == 'group_edit' || $mode == 'group_id') {
		$show = 4;
		if (!$config->synchronize)
			$show = $show - 1;
	}elseif ($task == 'list_roles' || $task == 'role_add' || $task == 'role_edit'  || $mode == 'role_id') {
		$show = 5;
		if (!$config->synchronize)
			$show = $show - 1;
	}elseif ($task == 'list_functions' || $task == 'function_add' || $task == 'function_edit' || $task == 'set_functions') {
		$show = 6;
		if (!$config->synchronize)
			$show = $show - 1;
	}elseif ($task == 'help' || $task == 'support' || $task == 'faq'  || $task == 'changelog' || $task == '' || $task == 'about' || $task == 'disclaimer' || $task == 'hacks') {
		$show = 7;
		if (!$config->synchronize)
			$show = $show - 1;
	}
	?>
	<style type="text/css" >
		.icon-32-refresh 			{ background-image: url(<?php echo substr_replace(JURI::root(), '', -1, 1);?>/administrator/templates/khepri/images/toolbar/icon-32-refresh.png); }
	</style>
	<table width="100%">
		<tr>
			<td valign="top" width="220">
			<div>
	<script type="text/javascript" src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/administrator/components/<?php echo $option; ?>/js/jquery.pack.js"></script>
	<script type="text/javascript">
    /* <![CDATA[ */
		jQuery.noConflict();
		Window.onDomReady(function(){
		new Accordion($$('.panel h3.jpane-toggler'),
		$$('.panel div.jpane-slider'),
		{show:<?php echo $show;?>,onActive: function(toggler, i)
		{ toggler.addClass('jpane-toggler-down');
			toggler.removeClass('jpane-toggler'); },
		onBackground: function(toggler, i)
			{ toggler.addClass('jpane-toggler'); toggler.removeClass('jpane-toggler-down'); },duration: 300,opacity: false}); });
    /* ]]> */
	</script>
	<table width="202px" height="100%" cellpadding="0" cellspacing="0" >
	<tr><td style="height:7px; width:200px;background:url(<?php echo substr_replace(JURI::root(), '', -1, 1);?>/administrator/components/<?php echo $option; ?>/images/top_menu_bg.jpg) no-repeat bottom left ">
	<img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/images/blank.png" alt="" />
	</td></tr>
	<tr>
		<td style="border-left:1px solid #cccccc;border-right:1px solid #cccccc; text-align:center;" align="center"><h3 style='margin:0; padding:0; padding-bottom:5px; color:#5c82c3;font-style:italic;'><?php echo _COMMUNITY_ACL_COMP_NAME;?></h3></td>
	</tr>
	<tr>
		<td style="border-left:1px solid #cccccc;border-right:1px solid #cccccc">
		<div id="content-pane" class="pane-sliders">
			<div class="panel">
				<h3 class="jpane-toggler title" id="cpanel-panel0">
				<span><?php echo JText::_( 'Configuration' ); ?></span>
				</h3>
				<div class="jpane-slider content">
				<table class="adminlist">
					<tr>
						<td width="16px"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/includes/js/ThemeOffice/config.png" alt=""/></td>
						<td class="title">
							<a class="menu_link" href="index.php?option=<?php echo $option; ?>&amp;task=config"><?php echo JText::_( 'Configuration' ); ?></a>
						</td>
					</tr>
					<?php #VKS - Checks to see if Sychrionization is enabled, else it hids the submenu Synchronize
						if ($config->synchronize) {?>
					<tr>
						<td width="16px"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/includes/js/ThemeOffice/controlpanel.png" alt="" /></td>
						<td class="title">
							<a class="menu_link" href="index.php?option=<?php echo $option; ?>&amp;task=synchronize"><?php echo JText::_( 'Synchronize' ); ?></a>
						</td>
					</tr>
					<?php } ?>
				</table>
				</div>
			</div>
			<div class="panel">
				<h3 class="jpane-toggler title" id="cpanel-panel1">
				<span><?php echo JText::_( 'Language management' ); ?></span>
				</h3>
				<div class="jpane-slider content">
				<table class="adminlist">
					<tr>
						<td width="16px"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/includes/js/ThemeOffice/language.png" alt="" /></td>
						<td class="title">
							<a class="menu_link" href="index.php?option=<?php echo $option; ?>&amp;task=language"><?php echo JText::_( 'List of languages' ); ?></a>
						</td>
					</tr>
				</table>
				</div>
			</div>
			<div class="panel">
				<h3 class="jpane-toggler title" id="cpanel-panel2">
				<span><?php echo JText::_( 'Users management' ); ?></span>
				</h3>
				<div class="jpane-slider content">
				<table class="adminlist">
					<tr>
						<td width="16px"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/includes/js/ThemeOffice/users.png" alt="" /></td>
						<td class="title">
							<a class="menu_link" href="index.php?option=<?php echo $option; ?>&amp;mode=manage_users"><?php echo JText::_( 'User Manager' ); ?></a>
						</td>
					</tr>
				</table>
				</div>
			</div>
			<?php if ($config->synchronize) { ?>
			<div class="panel">
				<h3 class="jpane-toggler title" id="cpanel-panel3">
				<span><?php echo JText::_( 'Sites management' ); ?></span>
				</h3>
				<div class="jpane-slider content">
				<table class="adminlist">
					<tr>
						<td width="16px"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/includes/js/ThemeOffice/globe1.png" alt="" /></td>
						<td class="title">
							<a class="menu_link" href="index.php?option=<?php echo $option; ?>&amp;task=list_sites"><?php echo JText::_( 'Sites management' ); ?></a>
						</td>
					</tr>
				</table>
				</div>
			</div>
			<?php } ?>
			<div class="panel">
				<h3 class="jpane-toggler title" id="cpanel-panel4">
				<span><?php echo JText::_( 'Groups' ); ?></span>
				</h3>
				<div class="jpane-slider content">
				<table class="adminlist">
					<tr>
						<td width="16px"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/includes/js/ThemeOffice/content.png" alt="" /></td>
						<td class="title">
							<a class="menu_link" href="index.php?option=<?php echo $option; ?>&amp;task=list_groups"><?php echo JText::_( 'List of groups' ); ?></a>
						</td>
					</tr>
					<tr>
						<td width="16px"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/includes/js/ThemeOffice/add_section.png" alt="" /></td>
						<td class="title">
				<a class="menu_link" href="index.php?option=<?php echo $option; ?>&amp;task=group_add"><?php echo JText::_( 'New group' ); ?></a>
						</td>
					</tr>
				</table>
				</div>
			</div>
			<div class="panel">
				<h3 class="jpane-toggler title" id="cpanel-panel5">
				<span><?php echo JText::_( 'Roles' ); ?></span>
				</h3>
				<div class="jpane-slider content">
				<table class="adminlist">
					<tr>
						<td width="16px"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/includes/js/ThemeOffice/content.png" alt="" /></td>
						<td class="title">
							<a class="menu_link" href="index.php?option=<?php echo $option; ?>&amp;task=list_roles"><?php echo JText::_( 'List of roles' ); ?></a>
						</td>
					</tr>
					<tr>
						<td width="16px"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/includes/js/ThemeOffice/add_section.png" alt="" /></td>
						<td class="title">
				<a class="menu_link" href="index.php?option=<?php echo $option; ?>&amp;task=role_add"><?php echo JText::_( 'New role' ); ?></a>
						</td>
					</tr>
				</table>
				</div>
			</div>
			<div class="panel">
				<h3 class="jpane-toggler title" id="cpanel-panel6">
				<span><?php echo JText::_( 'Functions' ); ?></span>
				</h3>
				<div class="jpane-slider content">
				<table class="adminlist">
					<tr>
						<td width="16px"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/includes/js/ThemeOffice/content.png" alt="" /></td>
						<td class="title">
							<a class="menu_link" href="index.php?option=<?php echo $option; ?>&amp;task=list_functions"><?php echo JText::_( 'List of functions' ); ?></a>
						</td>
					</tr>
					<tr>
						<td width="16px"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/includes/js/ThemeOffice/add_section.png" alt="" /></td>
						<td class="title">
				<a class="menu_link" href="index.php?option=<?php echo $option; ?>&amp;task=function_add"><?php echo JText::_( 'New functions' ); ?></a>
						</td>
					</tr>
				</table>
				</div>
			</div>
			<!--// <div class="panel">
				<h3 class="jpane-toggler title" id="cpanel-panel7">
					<span><?php echo JText::_( 'Hacks' ); ?></span>
				</h3>
				<div class="jpane-slider content">
				<table class="adminlist">
					<tr>
						<td width="16px"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/includes/js/ThemeOffice/document.png" alt="" /></td>
						<td class="title">
							<a class="menu_link" href="index.php?option=<?php echo $option; ?>&amp;task=hacks"><?php echo JText::_( 'Hack' ); ?></a>
						</td>
					</tr>
				</table>
				</div>
			</div> //-->
			<div class="panel">
				<h3 class="jpane-toggler title" id="cpanel-panel8">
					<span><?php echo JText::_( 'Help' ); ?></span>
				</h3>
				<div class="jpane-slider content">
				<table class="adminlist">
					<tr>
						<td width="16px"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/includes/js/ThemeOffice/credits.png" alt="" /></td>
						<td class="title">
							<a class="menu_link" href="index.php?option=<?php echo $option; ?>&amp;task=about"><?php echo JText::_( 'About' ); ?></a>
						</td>
					</tr>
					<?php if( checkInstall() == false ){ //Kobby Sam: hides the Patch menu when install is complete ?>
					<tr>
						<td width="16px"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/includes/js/ThemeOffice/document.png" alt="" /></td>
						<td class="title">
							<a class="menu_link" href="index.php?option=<?php echo $option; ?>&amp;task=hacks"><?php echo JText::_( 'Patch' ); ?></a>
						</td>
					</tr>
					<?php } ?>
					<tr>
						<td width="16px"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/includes/js/ThemeOffice/document.png" alt="" /></td>
						<td class="title">
							<a class="menu_link" href="index.php?option=<?php echo $option; ?>&amp;task=disclaimer"><?php echo JText::_( 'License' ); ?></a>
						</td>
					</tr>
					<tr>
						<td width="16px"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/includes/js/ThemeOffice/help.png" alt="" /></td>
						<td class="title">
							<a class="menu_link" href="index.php?option=<?php echo $option; ?>&amp;task=help"><?php echo JText::_( 'Help' ); ?></a>
						</td>
					</tr>
					<tr>
						<td width="16px"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/includes/js/ThemeOffice/help.png" alt="" /></td>
						<td class="title">
							<a class="menu_link" href="http://support.corephp.com/index.php?_m=knowledgebase&amp;_a=view&amp;parentcategoryid=2&amp;pcid=0&amp;nav=0" target="_blank" ><?php echo JText::_( 'F.A.Q.' ); ?></a>
						</td>
					</tr>
					<!-- <tr>
						<td width="16px"><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/includes/js/ThemeOffice/help.png" alt="" /></td>
						<td class="title">
							<a class="menu_link" href="http://support.corephp.com" target="_blank"><?php echo JText::_( 'Support' ); ?></a>
						</td>
					</tr> -->
				</table>
				</div>
			</div>
			<em></em><div class="clr"></div>
		</div>
	</td>
	</tr>
	<tr><td style="height:8px; width:200px;background:url(<?php echo substr_replace(JURI::root(), '', -1, 1);?>/administrator/components/<?php echo $option; ?>/images/bottom_menu_bg.jpg) no-repeat top left ">
		<br /><img src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/images/blank.png" alt="" />
	</td></tr>
</table>
</div>
			</td>
			<td valign="top">
	<?php
}

function left_menu_footer(){
?>
</td></tr></table>
<?php
}
function checkInstall(){ // Kobby created function to check patch files
	$success = true;
	switch (check_plugin()) { //Check if plugin is installed
		case -1:
			$success = false;
		break;
		case 0:
			$success = false;
		break;
	}

	if (check_core_file(JPATH_SITE.DS.'libraries'.DS.'joomla'.DS.'application'.DS.'module'.DS.'helper.php') < 1)
		 $success = false;

	return $success;
}


?>