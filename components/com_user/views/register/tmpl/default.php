<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript">
<!--
	Window.onDomReady(function(){
		document.formvalidator.setHandler('passverify', function (value) { return ($('password').value == value);}	);
	});
	
	
// -->
</script>

<?php
	$Community_ACL_release_date = 'Septmeber: 2009';
	
	if(isset($this->message)){
		$this->display('message');
	}	
	 
	$document = &JFactory::getDocument();
	
	if(file_exists(JPATH_SITE.'/administrator/components/com_community_acl/community_acl.class.php'))
		require_once (JPATH_SITE.'/administrator/components/com_community_acl/community_acl.class.php');
	 
	//$document->addScript('/includes/js/joomla.javascript.js');
	if(file_exists(JPATH_SITE.'/administrator/components/com_community_acl/community_acl.class.php')){
		$db =& JFactory::getDBO();
	
		$query = 'SELECT id AS value, name AS text'
		. ' FROM `#__community_acl_membership_types`'
		. ' ORDER BY id' 
		;
		$db->setQuery( $query );
		$cb_members = $db->loadObjectList();		
		$list['membership'] = $cb_members;
		if($list['membership'])		
			$list['member_lists'] = JHTML::_('select.genericlist',   $cb_members, 'member_list', ' class="inputbox" size="1" ', 'value', 'text', null );
	}		
?>

<form action="<?php echo JRoute::_( 'index.php?option=com_user' ); ?>" method="post" id="josForm" name="josForm" class="form-validate">

<?php if ( $this->params->def( 'show_page_title', 1 ) ) : ?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><?php echo $this->escape($this->params->get('page_title')); ?></div>
<?php endif; ?>

<table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
<tr>
	<td width="30%" height="40">
		<label id="namemsg" for="name">
			<?php echo JText::_( 'Name' ); ?>:
		</label>
	</td>
  	<td>
  		<input type="text" name="name" id="name" size="40" value="<?php echo $this->escape($this->user->get( 'name' ));?>" class="inputbox required" maxlength="50" /> *
  	</td>
</tr>
<tr>
	<td height="40">
		<label id="usernamemsg" for="username">
			<?php echo JText::_( 'User name' ); ?>:
		</label>
	</td>
	<td>
		<input type="text" id="username" name="username" size="40" value="<?php echo $this->escape($this->user->get( 'username' ));?>" class="inputbox required validate-username" maxlength="25" /> *
	</td>
</tr>
<tr>
	<td height="40">
		<label id="emailmsg" for="email">
			<?php echo JText::_( 'Email' ); ?>:
		</label>
	</td>
	<td>
		<input type="text" id="email" name="email" size="40" value="<?php echo $this->escape($this->user->get( 'email' ));?>" class="inputbox required validate-email" maxlength="100" /> *
	</td>
</tr>
<tr>
	<td height="40">
		<label id="pwmsg" for="password">
			<?php echo JText::_( 'Password' ); ?>:
		</label>
	</td>
  	<td>
  		<input class="inputbox required validate-password" type="password" id="password" name="password" size="40" value="" /> *
  	</td>
</tr>
<tr>
	<td height="40">
		<label id="pw2msg" for="password2">
			<?php echo JText::_( 'Verify Password' ); ?>:
		</label>
	</td>
	<td>
		<input class="inputbox required validate-passverify" type="password" id="password2" name="password2" size="40" value="" /> *
	</td>
</tr>
<?php if(file_exists(JPATH_SITE.'/administrator/components/com_community_acl/community_acl.class.php') && $list['membership']){ ?>
<tr>
	<td>
		<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><?php echo 'Community ACL User Setup'; ?></div>
	</td>
</tr>
<tr>
		<script type="text/javascript" src="<?php echo substr_replace(JURI::root(), '', -1, 1);?>/administrator/components/com_community_acl/js/jquery.pack.js"></script>
	
		<script type="text/javascript">
	    // <!--	
			jQuery.noConflict();
			
	    // -->
		</script>
			<table class="adminlist" cellpadding="1">
					<thead>
						<script language="javascript" type="text/javascript">
							<!--
												
							
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
									var tbody = jQuery('tbody#list_body').get(0); 
									renum_table_rows(tbody);
								}
								function addMembershipType() {
									
									var member_list = jQuery('select#member_list').get(0);									
									var tbody = jQuery('tbody#list_body').get(0);
									
									var row = document.createElement("TR");
									
									var cell0 = document.createElement("TD");
									cell0.innerHTML = '0';
									
									var cell1 = document.createElement("TD");
									cell1.innerHTML = member_list.options[member_list.selectedIndex].text;
									var input_hidden = document.createElement("input"); 
									input_hidden.type = 'hidden';
									input_hidden.name = 'membership_type_id[]';
									input_hidden.value = member_list.options[member_list.selectedIndex].value;
									cell1.appendChild(input_hidden);
									
									var cell2 = document.createElement("TD");
									cell2.innerHTML = '<a href="javascript: void(0);" onClick="javascript:delete_row(this); return false;" title="Delete">Delete</a>';
									cell2.align = "left";
									
									
									row.appendChild(cell0);
									row.appendChild(cell1);
									row.appendChild(cell2);
									tbody.appendChild(row);
									renum_table_rows(tbody);													
								}
								//-->
							</script>	
							
							<tr> 
								<th width="2%" class="title">
									<?php echo JText::_( 'NUM' ); ?>
								</th>
								<th class="title" width="30%">
									<?php echo JText::_( 'Membership Type' ); ?>
								</th>
								<th class="title" width="30%">
									<?php echo JText::_( 'Add' ); ?>
								</th>
							</tr>
					</thead>
					
					<tbody id="list_body">
					</tbody>
					<table class="adminform" cellspacing="1">
						<tr>
							<td width="2%" valign="top" class="key">&nbsp;
							</td>							
							<td valign="top" class="key" width="30%">					
								<?php print_r($list['member_lists']); ?> 						
							</td>							
							<td valign="top" class="key" width="9%">
								<input type="button" name="select_all" class="button" value="Add"  onclick="javascript: addMembershipType();" />						
							</td>
						</tr>				
				</table>
			</table>

</tr>
<?php } ?>
<tr>
	<td colspan="2" height="40">
		<br/>
		<?php echo JText::_( 'REGISTER_REQUIRED' ); ?>
	</td>
</tr>
</table>
	<br/><br/>
	<button class="button validate" type="submit"><?php echo JText::_('Register'); ?></button>
	<input type="hidden" name="task" value="register_save" />
	<input type="hidden" name="id" value="0" />
	<input type="hidden" name="gid" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
<script type="text/javascript" language="javascript">
			try {
				changeDynaList( 'public_role', grouproles, document.josForm.public_group.options[document.josForm.public_gtoup.selectedIndex].value, 0, 0);
			} catch(e){}
		</script>
