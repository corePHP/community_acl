<?php
// Deny direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.filesystem.folder' );
jimport('joomla.filesystem.file');

function com_install()
{
	$destination = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_community_acl' . DS;
	$buffer = "installing";
	
	if(!JFile::write($destination.'installer.dummy.ini', $buffer))
	{
		ob_start();
		?>
		<table width="100%" border="0">
			<tr>
				<td>				
					There was an error while trying to create an installation file.
					Please ensure that the path <strong><?php echo $destination; ?></strong> has correct permissions and try again.
				</td>
			</tr>
		</table>
		<?php
		$html = ob_get_contents();
		@ob_end_clean();
	}
	else
	{
		$link = rtrim( JURI::root() , '/' ) . '/administrator/index.php?option=com_community_acl&task=install&step=1';
		
		ob_start();
		?>
		<style type="text/css">
		.button-next 
		{
			height: 34px;
			line-height: 34px;
			width: 200px;
			text-align: center;
			font-weight: 700;
			color: white;
			background: red;
			border: solid 1px #690;
			cursor: pointer;
		}
		</style>
		<table width="100%" border="0">
			<tr>
				<td>				
					Thank you for choosing Community ACL, please click on the following button to complete your installation.
				</td>
			</tr>
			<tr>
				<td>
					<input type="button" class="button-next" onclick="window.location = '<?php echo $link; ?>'" value="<?php echo JText::_('Click to complete your installation');?>"/>
				</td>
			</tr>
		</table>
		<?php
		$html = ob_get_contents();
		@ob_end_clean();
	}
	
	echo $html;
}
