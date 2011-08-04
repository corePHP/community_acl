<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'User' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'user.png' );
	JToolBarHelper::save();
	JToolBarHelper::apply();
	if ( $edit ) {
		// for existing items the button is renamed `close`
		JToolBarHelper::cancel( 'cancel', 'Close' );
	} else {
		JToolBarHelper::cancel();
	}
	JToolBarHelper::custom( 'help', 'help.png', 'help.png', $alt = 'Help', false);
	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	$lvisit = $this->user->get('lastvisitDate');
	if ($lvisit == "0000-00-00 00:00:00") {
		$lvisit = JText::_( 'Never');
	}
?>
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel' || pressbutton == 'help') {
			submitform( pressbutton );
			return;
		}
		var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");

		// do field validation
		if (trim(form.name.value) == "") {
			alert( "<?php echo JText::_( 'You must provide a name.', true ); ?>" );
		} else if (form.username.value == "") {
			alert( "<?php echo JText::_( 'You must provide a user login name.', true ); ?>" );
		} else if (r.exec(form.username.value) || form.username.value.length < 2) {
			alert( "<?php echo JText::_( 'WARNLOGININVALID', true ); ?>" );
		} else if (trim(form.email.value) == "") {
			alert( "<?php echo JText::_( 'You must provide an email address.', true ); ?>" );
		} else if (form.gid.value == "") {
			alert( "<?php echo JText::_( 'You must assign user to a group.', true ); ?>" );
		} else if (((trim(form.password.value) != "") || (trim(form.password2.value) != "")) && (form.password.value != form.password2.value)){
			alert( "<?php echo JText::_( 'Password do not match.', true ); ?>" );
		} else if (form.gid.value == "29") {
			alert( "<?php echo JText::_( 'WARNSELECTPF', true ); ?>" );
		} else if (form.gid.value == "30") {
			alert( "<?php echo JText::_( 'WARNSELECTPB', true ); ?>" );
		} else {
			submitform( pressbutton );
		}
	}

	function gotocontact( id ) {
		var form = document.adminForm;
		form.contact_id.value = id;
		submitform( 'contact' );
	}


</script>
<form action="index.php" method="post" name="adminForm" autocomplete="off">
	<div class="col width-45">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'User Details' ); ?></legend>
			<table class="admintable" cellspacing="1">
				<tr>
					<td width="150" class="key">
						<label for="name">
							<?php echo JText::_( 'Name' ); ?>
						</label>
					</td>
					<td>
						<input type="text" name="name" id="name" class="inputbox" size="40" value="<?php echo $this->user->get('name'); ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="username">
							<?php echo JText::_( 'Username' ); ?>
						</label>
					</td>
					<td>
						<input type="text" name="username" id="username" class="inputbox" size="40" value="<?php echo $this->user->get('username'); ?>" autocomplete="off" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="email">
							<?php echo JText::_( 'Email' ); ?>
						</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="email" id="email" size="40" value="<?php echo $this->user->get('email'); ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="password">
							<?php echo JText::_( 'New Password' ); ?>
						</label>
					</td>
					<td>
						<?php if(!$this->user->get('password')) : ?>
							<input class="inputbox disabled" type="password" name="password" id="password" size="40" value="" disabled="disabled" />
						<?php else : ?>
							<input class="inputbox" type="password" name="password" id="password" size="40" value=""/>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="password2">
							<?php echo JText::_( 'Verify Password' ); ?>
						</label>
					</td>
					<td>
						<?php if(!$this->user->get('password')) : ?>
							<input class="inputbox disabled" type="password" name="password2" id="password2" size="40" value="" disabled="disabled" />
						<?php else : ?>
							<input class="inputbox" type="password" name="password2" id="password2" size="40" value=""/>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<label for="gid">
							<?php echo JText::_( 'Group' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['gid']; ?>
					</td>
				</tr>
				<?php if ($this->user->authorize( 'com_users', 'block user' )) { ?>
				<tr>
					<td class="key">
						<?php echo JText::_( 'Block User' ); ?>
					</td>
					<td>
						<?php echo $this->lists['block']; ?>
					</td>
				</tr>
				<?php } if ($this->user->authorize( 'com_users', 'email_events' )) { ?>
				<tr>
					<td class="key">
						<?php echo JText::_( 'Receive System Emails' ); ?>
					</td>
					<td>
						<?php echo $this->lists['sendEmail']; ?>
					</td>
				</tr>
				<?php } if( $this->user->get('id') ) { ?>
				<tr>
					<td class="key">
						<?php echo JText::_( 'Register Date' ); ?>
					</td>
					<td>
						<?php echo $this->user->get('registerDate');?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php echo JText::_( 'Last Visit Date' ); ?>
					</td>
					<td>
						<?php echo $lvisit; ?>
					</td>
				</tr>
				<?php } ?>
			</table>
		</fieldset>
		<?php if ($this->user->usertype != 'Super Administrator') {?>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Community ACL Details' ); ?></legend>
			<script language="javascript" type="text/javascript">
				<!--

				var grouproles = new Array;

				<?php
				$i = 0;
				foreach ($this->lists['cacl_rid_arr'] as $k=>$v) {
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
					cell4.innerHTML = '<a href="javascript: void(0);" onClick="javascript:delete_row(this); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"></a>';
					cell4.align = "center";


					row.appendChild(cell0);
					row.appendChild(cell1);
					row.appendChild(cell2);
					row.appendChild(cell3);
					row.appendChild(cell4);
					tbody.appendChild(row);
					renum_table_rows(tbody);
				}
				//-->
			</script>
			<table class="adminlist" cellpadding="1">
			<thead>
				<tr>
					<th width="2%" class="title">
						<?php echo JText::_( 'NUM' ); ?>
					</th>
					<th class="title" width="30%">
						<?php echo JText::_( 'Group' ); ?>
					</th>
					<th class="title" width="30%">
						<?php echo JText::_( 'Role' ); ?>
					</th>
					<th class="title" width="30%">
						<?php echo JText::_( 'Function' ); ?>
					</th>
					<th class="title" width="auto">
						<?php echo JText::_( 'Delete' ); ?>
					</th>
				</tr>
			</thead>
			<tbody id="list_body">
			<?php
			$i = 1;
			$k = 0;
			if (is_array($this->lists['cacl_user']) && count($this->lists['cacl_user']))
				foreach($this->lists['cacl_user'] as $user) {?>
				<tr class="row<?php echo $k; ?>">
					<td >
						<?php echo $i++; ?>
					</td>
					<td >
						<?php echo $user->g_name; ?>
						<input type="hidden" name="cacl_group_id[]" value="<?php echo $user->group_id; ?>" />
					</td>
					<td >
						<?php echo $user->r_name; ?>
						<input type="hidden" name="cacl_role_id[]" value="<?php echo $user->role_id; ?>" />
					</td>
					<td >
						<?php echo ($user->function_id > 0 ? $user->f_name: JText::_( 'None' )); ?>
						<input type="hidden" name="cacl_func_id[]" value="<?php echo $user->function_id; ?>" />
					</td>
					<td >
						<a href="javascript: void(0);" onClick="javascript:delete_row(this); return false;" title="Delete"><img src="images/publish_x.png"  border="0" alt="Delete"></a>
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
					<td valign="top" class="key" width="30%">
						<?php echo $this->lists['cacl_gid']; ?>
					</td>
					<td valign="top" class="key" width="30%">
						 <?php echo $this->lists['cacl_rid']; ?>
					</td>
					<td valign="top" class="key" width="30%">
						<?php echo $this->lists['cacl_fid']; ?>
					</td>
					<td valign="top" class="key" width="auto">
						<input <?php if ($this->lists['cacl_gid'] == JText::_( 'There is no groups' ) || $this->lists['cacl_rid'] == JText::_( 'There is no roles' ) || $this->lists['cacl_fid'] == JText::_( 'There is no functions' ) || $this->lists['cacl_rid'] == JText::_( 'None' ) || $this->lists['cacl_rid'] == JText::_( 'hjkhk' )) echo ' disabled="disabled" ';?>type="button" name="select_all" class="button" value="Add"
									onclick="javascript: if(document.adminForm.cacl_role_list.options[document.adminForm.cacl_role_list.selectedIndex].text != 'None') {addRow(); } else alert('NO ROLE=Can not add Groups with no roles. Please add a role to this group before attempting to add'); " />
					</td>
				</tr>
			</table>			<?php if(false): //removed because it is unused.?>
			<table class="admintable" cellspacing="1">
				<tr>
					<td width="150" class="key">
						<label for="name">
							<?php echo JText::_( 'Email notification when new content is submitted' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['publisher_notification']; ?>
					</td>
				</tr>
			</table>			<?php endif; ?>
		</fieldset>
		<?php }?>
	</div>
	<div class="col width-55">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Parameters' ); ?></legend>
			<table class="admintable">
				<tr>
					<td>
						<?php
							$params = $this->user->getParameters(true);
							echo $params->render( 'params' );
						?>
					</td>
				</tr>
			</table>
		</fieldset>
		<?php
		#- Check if the user is an Admininstrator
			if($this->user->get('gid') != 25){ ?>
		<fieldset class="adminform">
			<?php
			#- Kobby Sam: Get the redirects for a user
			$db =& JFactory::getDBO();
			$query = "SELECT `redirect_FRONT`, `redirect_ADMIN` FROM `#__community_acl_users` WHERE `user_id` = ". $this->user->get('id');
			$db->setQuery( $query );
			$user_redirects = $db->loadObjectList();

			if(!$user_redirects){
				$user_redirects[0]->redirect_FRONT = "";
				$user_redirects[0]->redirect_ADMIN = "";
				}
			//print_r($user_redirects);

			 ?>
		<legend><?php echo JText::_( 'Redirects' ); ?></legend>
			<table class="admintable">
				<tr>
					<td width="150" class="key">
						<label for="redirect_URL_FRONT"">
							<?php echo JText::_( 'Frontend Redirect' ); ?>
						</label>
					</td>
					<td>
						<input type="text" name="redirect_URL_FRONT" id="redirect_URL_FRONT" class="inputbox" size="40" value="<?php echo $user_redirects[0]->redirect_FRONT; ?>"  />
						<br /> (e.x. index.php)
					</td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="redirect_URL_ADMIN"">
							<?php echo JText::_( 'Backend Redirect' ); ?>
						</label>
					</td>
					<td>
						<input type="text" name="redirect_URL_ADMIN" id="redirect_URL_ADMIN" class="inputbox" size="40" value="<?php echo $user_redirects[0]->redirect_ADMIN; ?>"  />
						<br />(e.x. index.php)
					</td>
				</tr>
			</table>
				<?php } ?>
		</fieldset>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Contact Information' ); ?></legend>
		<?php if ( !$this->contact ) { ?>
			<table class="admintable">
				<tr>
					<td>
						<br />
						<span class="note">
							<?php echo JText::_( 'No Contact details linked to this User' ); ?>:
							<br />
							<?php echo JText::_( 'SEECOMPCONTACTFORDETAILS' ); ?>.
						</span>
						<br /><br />
					</td>
				</tr>
			</table>
		<?php } else { ?>
			<table class="admintable">
				<tr>
					<td width="120" class="key">
						<?php echo JText::_( 'Name' ); ?>
					</td>
					<td>
						<strong>
							<?php echo $this->contact[0]->name;?>
						</strong>
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php echo JText::_( 'Position' ); ?>
					</td>
					<td >
						<strong>
							<?php echo $this->contact[0]->con_position;?>
						</strong>
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php echo JText::_( 'Telephone' ); ?>
					</td>
					<td >
						<strong>
							<?php echo $this->contact[0]->telephone;?>
						</strong>
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php echo JText::_( 'Fax' ); ?>
					</td>
					<td >
						<strong>
							<?php echo $this->contact[0]->fax;?>
						</strong>
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php echo JText::_( 'Misc' ); ?>
					</td>
					<td >
						<strong>
							<?php echo $this->contact[0]->misc;?>
						</strong>
					</td>
				</tr>
				<?php if ($this->contact[0]->image) { ?>
				<tr>
					<td class="key">
						<?php echo JText::_( 'Image' ); ?>
					</td>
					<td valign="top">
						<img src="<?php echo JURI::root() . $cparams->get('image_path') . '/' . $this->contact[0]->image; ?>" align="middle" alt="<?php echo JText::_( 'Contact' ); ?>" />
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td class="key">&nbsp;</td>
					<td>
						<div>
							<br />
							<input class="button" type="button" value="<?php echo JText::_( 'change Contact Details' ); ?>" onclick="gotocontact( '<?php echo $this->contact[0]->id; ?>' )" />
							<i>
								<br /><br />
								'<?php echo JText::_( 'Components -> Contact -> Manage Contacts' ); ?>'
							</i>
						</div>
					</td>
				</tr>
			</table>
			<?php } ?>
		</fieldset>
	</div>
	<div class="clr"></div>
	<script type="text/javascript" language="javascript">
		try {
			changeDynaList( 'cacl_role_list', grouproles, document.adminForm.cacl_group_list.options[document.adminForm.cacl_group_list.selectedIndex].value, 0, 0);
		} catch(e){}
	</script>
	<input type="hidden" name="id" value="<?php echo $this->user->get('id'); ?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->user->get('id'); ?>" />
	<input type="hidden" name="option" value="com_community_acl" />
	<input type="hidden" name="mode" value="manage_users" />

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="contact_id" value="" />
	<?php if (!$this->user->authorize( 'com_users', 'email_events' )) { ?>
	<input type="hidden" name="sendEmail" value="0" />
	<?php } ?>
	<?php echo JHTML::_( 'form.token' ); ?>
</form>