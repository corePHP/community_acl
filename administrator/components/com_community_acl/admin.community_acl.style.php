<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<style>html#minwidth body#minwidth-body div#content-box div.border div.padding div#element-box div.m table tbody tr td form div.col fieldset.adminform table.adminform tbody tr td.key select#cacl_group_list.inputbox ,html#minwidth body#minwidth-body div#content-box div.border div.padding div#element-box div.m table tbody tr td form div.col fieldset.adminform table.adminform tbody tr td.key select#cacl_role_list.inputbox, html#minwidth body#minwidth-body div#content-box div.border div.padding div#element-box div.m table tbody tr td form div.col fieldset.adminform table.adminform tbody tr td.key select#cacl_func_list.inputbox{
width:100%;}
	.icon-48-static 		{ background-image: url(./templates/khepri/images/header/icon-48-static.png); } 
	.icon-32-cpanel 		{ background-image: url(./templates/khepri/images/toolbar/icon-32-send.png); } 
	.icon-32-addusers 		{ background-image: url(./templates/khepri/images/toolbar/icon-32-adduser.png); }
	
	h3 { font-size:13px !important;}
	
	a.menu_link:link, a.menu_link:visited {font-weight:bold;color:#000000;	}
	a.menu_link:hover{ color:#3366CC;	text-decoration:none; }
	/* pane-sliders  */
	.pane-sliders .title {	margin: 0;padding: 2px;color: #666;	cursor: pointer;}	
	.pane-sliders .panel   { border: 1px solid #ccc; margin-bottom: 3px; text-align:left;}
	
	.pane-sliders .panel h3 { background: #f6f6f6; color: #666}
	
	.pane-sliders .content { background: #f6f6f6; }
	
	.pane-sliders .adminlist     { border: 0 none; }
	.pane-sliders .adminlist td  { border: 0 none; }
	
	.jpane-toggler  span     { background: transparent url(<?php echo substr_replace(JURI::root(), '', -1, 1);?>/administrator/components/<?php echo $option; ?>/images/j_arrow.png) 5px 50% no-repeat; padding-left: 20px;}
	.jpane-toggler-down span { background: transparent url(<?php echo substr_replace(JURI::root(), '', -1, 1);?>/administrator/components/<?php echo $option; ?>/images/j_arrow_down.png) 5px 50% no-repeat; padding-left: 20px;}
	
	.jpane-toggler-down {  border-bottom: 1px solid #ccc;  }
	
	.jpane-toggler .adminlist tr { text-align:left;}
</style>