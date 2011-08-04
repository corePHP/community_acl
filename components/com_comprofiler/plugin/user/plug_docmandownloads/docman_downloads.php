<?php
/**
 * @version 1.0.0
 * @package Docman Downloads
 * @author 'corePHP' LLC.
 * @copyright (C) 2011- 'corePHP' LLC.
 * @license GNU/GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Support: http://support.corephp.com/
 */
if (! (defined ( '_VALID_CB' ) || defined ( '_JEXEC' ) || defined ( '_VALID_MOS' ))) {
	die ( 'Direct Access to this location is not allowed.' );
}

class getDOCmanDownloadsTab extends cbTabHandler {
	function getDOCmanDownloadsTab() {
		$this->cbTabHandler ();
	}
	function getEditTab($tab, $user, $ui) {
		$db = JFactory::getDBO();
		$sql = "
			SELECT *
			FROM #__docman_log
			LEFT JOIN #__docman ON #__docman_log.log_docid=#__docman.id
			LEFT JOIN #__categories on #__docman.catid=#__categories.id
			WHERE log_user={$user->id}";
		$db->setQuery($sql);
		$rows = $db->loadAssocList();
		$return = '<div style="padding:1em 0 0 0;">';
		foreach($rows as $row ){
			$return .= '<fieldset>';
			$return .= "<legend>{$row['dmname']}</legend>";
			$return .= "<p>File Name: {$row['dmfilename']}<p>";
			$return .= "<p>Category: {$row['title']}<p>";
			$return .= "<p>Downloaded on: ".date('M d Y \a\t h:ia T',strtotime($row['log_datetime']))."<p>";
			$return .= '</fieldset>';
		}
		$return .= '</div>';

		return $return;
	}
}