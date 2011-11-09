<?php
defined('_JEXEC') or die('Restricted access');

class Language_manager  extends JObject  {
	
	/**
	* Build the filters for a view
	* @param array an associative array of allowed fields and values
	* @param string the namespace for this view
	* @return array	The Configuration in an array
	*/
	function _buildfilters( $allowed=array(), $namespace='' )
	{
		// initialise
		global $mainframe, $option;
		$filters = array();
		if ($namespace) {
			$namespace = trim($namespace,'.') . '.';
		} else {
			$namespace = $option.'.';
		}

		// get the limitstart for this namespace
		$filters['limitstart'] = $mainframe->getUserStateFromRequest( $namespace . 'limitstart', 'limitstart', 0 );

		// then validate all the filters for this namespace
		foreach ($allowed as $k=>$v) {
			// values are all changed to lower case
			$values = explode('|',$v);
			foreach ( $values as $k2=>$v2 ) {
				$values[$k2] = strtolower($v2);
			}
			// A: get the old/current value
			$old = $mainframe->getUserState( 'request.' . $namespace . $k );
			// B: get the new value from the user input
			$new = $mainframe->getUserStateFromRequest( $namespace . $k, $k, $values[0] );
			// C: check that the new (lowercase) value is valid
			if ($k=='limit') {
				$new = (is_numeric($new)) ? abs($new) : $values[0];
			} else if ( $v && array_search(strtolower($new),$values) === false ) {
				$new = $values[0];
			}
			// D: reset the page to #1 if the value has changed
			if ( $old != $new ) {
				$options['limitstart'] = 0;
			}
			// set the value
			$filters[$k] = $new;
		}

		// return
		return $filters;
	}
	
	/**
	* Get the configuration options.
	* @return array	The Configuration in an array
	*/
	function getOptions () {
		
		return Language_manager::_buildoptions();
	}
	
	/**
	* Build the configuration options.
	* @return array	The Configuration in an array
	*/
	function _buildoptions ()
	{
		// initialise configuration variables
		global $mainframe, $task, $option;
		
		//$task	= strtolower($this->_task);
		$options['config'] 			= JComponentHelper::getParams( $option.'1' );

		$options['autoCorrect']		= $options['config']->get( 'autoCorrect', 'a^=�' );
		$options['backticks'] 		= $options['config']->get( 'backticks', 0 );
		$options['cid'] 			= JRequest::getVar( 'cid', array(''), '', 'array' );
		$options['client_lang']		= $mainframe->getUserStateFromRequest($option.'.client_lang','client_lang','');
		$options['globalChanges'] 	= $options['config']->get('globalChanges', 0 );
		$options['limitstart']		= $mainframe->getUserStateFromRequest($option.'.limitstart','limitstart','');
		$options['newprocess'] 		= JRequest::getVar('newprocess',0,'','integer' );
		$options['refLang'] 		= $options['config']->get( 'refLanguage', 'en-GB' );
		$options['refLangMissing'] 	= false;
		$options['searchStyle']		= $options['config']->get( 'searchStyle', 'background-color:yellow;' );
		$options['task'] 			= strtolower($task);

		// initialise a list of available languages
		$options['languages'] = array();
		$options['clients'] = array();

		$options['clients']['S'] =  JText::_('Site');
		foreach (JLanguage::getKnownLanguages(JPATH_SITE) as $k=>$v) {
			$options['languages']['S_'.$k] = $options['clients']['S'] . ' - '.$v['name'];
		}
		$options['clients']['A'] = JText::_('Administrator');
		foreach (JLanguage::getKnownLanguages(JPATH_ADMINISTRATOR) as $k=>$v) {
			$options['languages']['A_'.$k] = $options['clients']['A'] . ' - '.$v['name'];
		}
		if (JFolder::exists(JPATH_INSTALLATION)) {
			$options['clients']['I'] = JText::_('Installation');
			foreach (JLanguage::getKnownLanguages(JPATH_INSTALLATION) as $k=>$v) {
				$options['languages']['I_'.$k] = $options['clients']['I'] . ' - '.$v['name'];
			}
		}

		// validate client_lang (split, reassemble with cases, check against allowed values, on failure default to first allowed value)
		$cl_split = preg_split("/[^a-z]/i",$options['client_lang']);
		if($options['client_lang'])
			$options['client_lang'] = strtoupper($cl_split[0]) . '_' . strtolower($cl_split[1]) . '-' . strtoupper($cl_split[2]);
		if (!isset($options['languages'][$options['client_lang']])) {
            $options['client_lang'] = key($options['languages']);
        }

		// set client variables
		$options['client'] = $options['client_lang']{0};
		if ($options['client']=='A') {
			$options['basePath'] = JPATH_ADMINISTRATOR;
			$options['clientKey'] = 'administrator';
		} else if ($options['client']=='I') {
			$options['basePath'] = JPATH_INSTALLATION;
			$options['clientKey'] = 'installation';
		} else {
			$options['basePath'] = JPATH_SITE;
			$options['clientKey'] = 'site';
		}
		$options['clientName'] = JText::_( $options['clientKey'] );

		// validate that the reference language exists on this client
		if (!isset($options['languages'][$options['client'].'_'.$options['refLang']])) {
			// initialise to en-GB
			$use = 'en-GB';
			// look for the first key index containing the reference language string
			foreach($options['languages'] as $k=>$v) {
				if ($k{0}==$options['client']) {
					$use = substr($k,-4);
					break;
				}
			}
			// set back to $options key
			$options['refLang'] = $use;
		}

		// set language variables
		$options['lang'] = substr($options['client_lang'],2);
        $options['langLen'] = strlen($options['lang']);
		$options['langName'] = $options['languages'][$options['client_lang']];
		$options['langPath'] 	= JLanguage::getLanguagePath( $options['basePath'], $options['lang'] );
        $options['refLangLen'] = strlen($options['refLang']);
		$options['refLangPath'] = JLanguage::getLanguagePath( $options['basePath'], $options['refLang'] );

		// set reference language variables
		$options['isReference'] = intval( $options['lang']==$options['refLang'] );

		// validate the cid array
		if ( !is_array( $options['cid'] )) {
			if (!empty($options['cid'])) $options['cid'] = array($options['cid']);
			else $options['cid'] = array('');
		}

		// process the cid array to validate filenames
		foreach($options['cid'] as $k=>$v ){
			if ($v) {
				// strip unpublished prefix
				if (substr($v,0,3)=='xx.') $v = substr($v,3);
				// strip files that don't match the selected language
				if (substr($v,0,$options['langLen'])!=$options['lang']) unset($options['cid'][$k]);
				// otherwise set back to $options
				else $options['cid'][$k] = $v;
			}
		}

		// set the filename
		$options['filename'] = $options['cid'][0];

		// build the autocorrect array
		$autoCorrect = array();
		if ($options['autoCorrect']) {
			foreach(explode(';',$options['autoCorrect']) as $v){
				list($k2,$v2)=explode('=',$v);
				$k2 = trim($k2);
				$v2 = trim($v2);
				if(($k2)&&($v2)) {
					$autoCorrect[$k2] = $v2;
				}
			}
		}
		$options['autoCorrect'] = $autoCorrect;

		// return the options array
		return $options;
	}
	
	/**
	* Processing File(s)
	* @param array $options		The configuration array for the component
	* @param string $task  		a specific task (overrides $options)
	* @param mixed $file  		a specific filename or array of filenames to process (overrides $options)
	* @param string $redirect_task	the task to use when redirecting (blank means no redirection)
	* @param boolean $report	whether or not to report processing success/failure
	*/
	function multitask( $task=null, $file=null, $redirect_task='language_files', $report=true )
	{
		global $option;
		// variables
		$options = Language_manager::getOptions();
		//$task = strtolower( is_null($task) ? $this->_task : $task );

		// validate the task
		if ($task=='cancel') {
			$task = 'checkin';
			$redirect_task = 'language_files';
			$report = false;
		} 

		// validate the filename
		// 1: use a specific file or files
		// 2: use the client_lang
		// 3: check that we have at least one file
		if ($file) {
			$options['cid'] = (is_array($file)) ? $file : array($file);
		} else if ( (empty($options['cid'][0])) && ($task!='checkin') ) {
			echo "<script> alert('". JText::_('Please make a selection from the list to') . ' ' . JText::_(str_replace('xml','',$task)) ."'); window.history.go(-1);</script>\n";
			exit();
		}

		// initialise file classes
		jimport('joomla.filesystem.file');

		// initialise checkout file content
		if ($task=='checkout') {
			$user = & JFactory::getUser();
			$chk_file_content = time() . '#' . $user->get('id','0') . '#' . $user->get('name','[ Unknown User ]');
		}

		// initialise variables
		global $mainframe;
		$file_list = array();
		$nofile_list = array();
		$inifile_list = array();
		$last = '';

		// process each passed file name (always the 'real' filename)
		foreach ($options['cid'] as $file) {

			// validate the filename language prefix
			if ( preg_match('/^[a-z]{2,3}-[A-Z]{2}[.].*/',$file) ) {

				// get the language and language path
				$lang = substr($file,0,$options['langLen']);
				$langPath = JLanguage::getLanguagePath( $options['basePath'], $lang );

				// ensure that XML files are only affected by XML tasks
				if ( (substr($file,-4)=='.xml') && (substr($task,-3)!='xml') ) {
					// continue without error warning
					continue;
				}


				// get file path-names
				$chk_file = 'chk.'.$file;
				$pub_file = $file;
				$unpub_file = 'xx.'.$file;

				// check for an unpublished file
				if (JFile::exists($langPath.DS.$unpub_file)) {
					$file = $unpub_file;
				}
				// check the file exists
				else if (!JFile::exists($langPath.DS.$file)) {
					// error and continue
					$nofile_list[$file] = $file;
					continue;
				}

				// cancel/checkin a file
				// checkout a file
				// delete a file
				// delete an XML file
				// publish a file
				// unpublish a file
				// otherwise break because the task isn't recognised
				if ( ($task=='checkin') && (JFile::exists($langPath.DS.$chk_file)) ) {
					$do = JFile::delete( $langPath.DS.$chk_file );
				} else if ($task=='checkout') {
					$do = Jfile::write( $langPath.DS.$chk_file, $chk_file_content );
				} else if ($task=='remove') {
					$do = JFile::delete( $langPath.DS.$file );
				} else if ($task=='publish') {
					$do = JFile::move( $file, $pub_file, $langPath );
				} else if ($task=='unpublish') {
					$do = JFile::move( $file, $unpub_file, $langPath );
				} else {
					break;
				}

				// build an array of things to hide form the filename
				$filename_hide = array();

				// add the function to the file list on success
				if ($do) {
					$file_list[$file] = str_replace( 'xx.'.$lang, $lang,substr($file,0,-4) );
				}
			}
		}

		if ($report) {
			// report processing success
			if (count($file_list)) {
				$mainframe->enqueueMessage(sprintf(JText::_($task.' success'), count($file_list), implode(', ',$file_list) ) );
			}
			// report existing ini files
			if (count($inifile_list)) {
				$mainframe->enqueueMessage(sprintf(JText::_($task.' inifile'), count($inifile_list), implode(', ',$inifile_list) ) );
			}
		}

		// redirect
		if ($redirect_task) {
			$mainframe->redirect( 'index.php?option='.$option.'&client_lang='.$options['client_lang'].'&task='.$redirect_task );
		}
	}
	
	function list_languages() {
		// variables
		global $mainframe, $option;

		$options = Language_manager::getOptions();

		// default languages
		$params = JComponentHelper::getParams('com_languages');
		$default['A'] = $params->get('administrator','en-GB');
		$default['I'] = $params->get('installation','en-GB');
		$default['S'] = $params->get('site','en-GB');

		// validate all the filters (specific to this view)
		// each filter key has a list of allowed values; the first is the default value
		// a blank value skips validation
		// the  key "limit" allows any integer
		$allowed = array(
			'filter_client' 	=> '*|' . implode( '|', array_keys($options['clients']) ),
			'filter_order' 		=> 'tag',
			'filter_order_Dir' 	=> 'asc|desc',
			'limit' 			=> $mainframe->getCfg('list_limit')
		);
		$filters = Language_manager::_buildfilters( $allowed, $option.'.languages.' );

		// copy to $options
		$options = array_merge( $options, $filters );

		// copy to $lists
		$lists['order'] 	= $options['filter_order'];
		$lists['order_Dir'] = $options['filter_order_Dir'];

		// get the list of languages
		$rows = array();
		foreach ($options['languages'] as $k=>$v) {
			$row = new StdClass();
			$row->tag = substr($k,2);
			$row->client = strtoupper($k{0});
			$row->client_lang = $k;
			$row->filename = $row->tag . '.xml';

			// check filter
			if ($options['filter_client']!='*') {
				if ($row->client != $options['filter_client']) {
					continue;
				}
			}

			// check default status
			$row->isdefault = intval( $default[$row->client]==$row->tag );

			// get the directory path
			if ($k{0}=='A') {
				$path = JPATH_ADMINISTRATOR;
				$row->client_name = JText::_('Administrator');
			} else if ($k{0}=='I') {
				$path = JPATH_INSTALLATION;
				$row->client_name = JText::_('Installation');
			} else {
				$path = JPATH_SITE;
				$row->client_name = JText::_('Site');
			}
			$path .= DS.'language'.DS.$row->tag;

			// count the number of INI files (published or unpublished)
			//echo '(xx[.]|^)'.$row->tag.'.*ini$';die;
			$opt_name = substr($option, 4);
			$row->files = count( JFolder::files( $path, '(xx[.]|^)'.$row->tag.'.*'.$opt_name.'.*ini$' ) );

			// load and add XML attributes
			// force the tag
		    $data = TranslationsHelper::getXMLMeta($path.DS.$row->filename);
			$data['tag'] = $row->tag;
 			foreach($data as $k2=>$v2) {
				$row->$k2 = $v2;
			}

			// add to rows
			$rows[] = $row;
		}

		// build the pagination
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( count($rows), $options['limitstart'], $options['limit'], 'index.php?option='.$option.'&task=language' );

		// sort the $rows array
		$order_Int = (strtolower($lists['order_Dir'])=='desc') ? -1 : 1;
		JArrayHelper::sortObjects( $rows, $lists['order'], $order_Int );

		// slice the array so we only show one page
		$rows = array_slice( $rows, $pageNav->limitstart, $pageNav->limit );

		// call the html view
		Language_manager_html::Show_languages($rows, $options, $lists, $pageNav);
	}
	
	function list_files()
	{
		global $option;
		// filesystem functions
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');

		// variables
		global $mainframe;
		$options = Language_manager::getOptions();
		$user = &JFactory::getUser();
		$userid = $user->get('id',0);

		// build client_lang select box
		foreach ($options['languages'] as $k=>$v) {
			$sel_lang[] = JHTML::_( 'select.option', $k, $v );
		}
		$lists['client_lang'] = JHTML::_( 'select.genericlist', $sel_lang, 'client_lang', 'class="inputbox" size="1" onchange="document.adminForm.limitstart.value=0;document.adminForm.submit( );"', 'value', 'text', $options['client_lang'] );

		// validate all the filters (specific to this view)
		$allowed = array(
			'client_lang'			=> '',
			'filter_search' 		=> '',
			'filter_state' 			=> '*|U|P',
			'filter_status' 		=> '*|NS|IP|C',
			'filter_order' 			=> 'name|status|strings|version|datetime|author',
			'filter_order_Dir' 		=> 'asc|desc',
			'limit' 				=> $mainframe->getCfg('list_limit')
		);
		$filters = Language_manager::_buildfilters( $allowed, $option.'.files.' );

		// copy to $options
		$options = array_merge( $options, $filters );

		// copy to $lists
		$lists['order'] = $options['filter_order'];
		$lists['order_Dir'] = $options['filter_order_Dir'];

		// validate and build the filter_search box
		$options['dosearch'] = '';
		if ($options['filter_search']) {
			// 1: turn it into a case-insensitive regexp
			// 2: check and use a submitted regexp
			// 3: invalid regexp
			if ($options['filter_search']{0}!='/') {
				$options['dosearch'] = '/.*'.trim($options['filter_search'],'/').'.*/i';
			} else if ( @preg_match($options['filter_search'],'') !== false ) {
				$options['dosearch'] = $options['filter_search'];
			} else {
				$mainframe->enqueueMessage( JText::_('Search') . ': ' . sprintf( JText::_('Invalid RegExp'), htmlentities($options['filter_search']) ), 'error' );
				$options['filter_search'] = '';
			}
		}
		$lists['search'] = '<input name="filter_search" id="filter_search" class="inputbox" "type="text" value="'.htmlspecialchars($options['filter_search'],ENT_QUOTES).'" onchange="this.form.submit();" size="15" />';

		// build the filter_state select box
		$extra = 'class="inputbox" size="1" onchange="document.adminForm.submit();"';
		$sel_state[] = JHTML::_( 'select.option',  '*', JText::_( 'Any State' ) );
		$sel_state[] = JHTML::_( 'select.option',  'P', JText::_( 'Published' ) );
		$sel_state[] = JHTML::_( 'select.option',  'U', JText::_( 'Not Published' ) );
		$lists['state'] = JHTML::_( 'select.genericlist',  $sel_state, 'filter_state', $extra, 'value', 'text', $options['filter_state'] );

		// build the filter_status select box
		$sel_status[] = JHTML::_( 'select.option',  '*', JText::_( 'Any Status' ) );
		$sel_status[] = JHTML::_( 'select.option',  'NS', JText::_( 'Not Started' ) );
		$sel_status[] = JHTML::_( 'select.option',  'IP', JText::_( 'In Progress' ) );
		$sel_status[] = JHTML::_( 'select.option',  'C', JText::_( 'Complete' ) );
		if ($options['isReference']) {
			$options['filter_status'] = '*';
		}
		if ($options['lang'] == $options['refLang']) {
			$extra .= ' disabled';
		}
		$lists['status'] = JHTML::_( 'select.genericlist',  $sel_status, 'filter_status', $extra, 'value', 'text', $options['filter_status'] );

		// create objects for loading data
		$refLangLoader = new JLanguage( $options['refLang'] );
		$LangLoader = ( $options['lang'] == $options['refLang'] ) ? $refLangLoader : new JLanguage( $options['lang'] );

		// load all the the ini filenames (published or unpublished) from the reference directory
		// load the same from the selected language directory
		$opt_name = substr($option, 4);
		$refLangFiles = JFolder::files( $options['refLangPath'] , '^(xx|'.$options['refLang'].')[.].*'.$opt_name.'[.].*ini$' );
		if ($options['isReference']) {
			$LangFiles = array_flip( $refLangFiles );
		} else {
			$LangFiles = JFolder::files( $options['langPath'] , '^(xx|'.$options['lang'].')[.].*'.$opt_name.'[.].*ini$' );
			$LangFiles = array_flip( $LangFiles );
		}

		// build a composite filename list, keyed using the filename without language tag
		$allFiles = array();		
		foreach ( $refLangFiles as $v ) {
			$k = preg_replace('/^(xx[.])*'.$options['refLang'].'[.]/','',$v);
			$allFiles[$k]['refLang'] = $v;
		}
		foreach ( $LangFiles as $v=>$k ) {
			$k = preg_replace('/^(xx[.])*'.$options['lang'].'[.]/','',$v);
			$allFiles[$k]['lang'] = $v;
		}
		// get default metadata for the selected language
		$xmlData = TranslationsHelper::getXMLMeta( $options['langPath'].DS.$options['lang'].'.xml' );

		// process the reference language INI files and compare them against the files for the selected language
		$rows = array ();
		$rowid = 1;
		foreach ($allFiles as $k=>$v)	{

			// get the content, bare filename, Meta and Strings from the reference language INI file
			// in some cases there may not be a reference language INI file
			if (isset($v['refLang'])) {
				$refContent = file( $options['refLangPath'].DS.$v['refLang'] );
                $refFileName = ( substr($v['refLang'],0,3)=='xx.' ) ?  substr($v['refLang'],3) : $v['refLang'];
				$fileName = $options['lang'] . substr($refFileName,$options['refLangLen']);
				$refStrings = array();
				$refMeta  = TranslationsHelper::getINIMeta( $refContent, $refStrings );
			} else {
				$refContent = array();
				$fileName = ( substr($v['lang'],0,3)=='xx.' ) ?  substr($v['lang'],3) : $v['lang'];
				$refFileName = $options['refLang'] . substr($fileName,$options['langLen']);
				$refStrings = array();
				$refMeta  = array(
					'author' => '',
					'date' => '',
					'strings' => '',
					'time' => '',
					'version' => ''
				);
			}

			// initialise the row
			$row = new StdClass();
			$row->author 		= $refMeta['author'];
			$row->bom 			= 'UTF-8';
			$row->checkedout 	= 0;
			$row->changed 		= 0;
			$row->date 			= $refMeta['date'];
			$row->extra 		= 0;
			$row->filename 		= $fileName;
			$row->id 			= $rowid++;
			$row->name 			= substr($row->filename,($options['langLen']+1),-4);
			$row->refexists 	= intval( isset($v['refLang']) );
			$row->reffilename 	= $refFileName;
			$row->refstrings	= $refMeta['strings'];
			$row->searchfound 	= 0;
			$row->status 		= 0;
			$row->strings 		= $refMeta['strings'];
			$row->time 			= $refMeta['time'];
			$row->unchanged		= 0;
			$row->unpub_filename = 'xx.'.$row->filename;
			$row->version 		= $refMeta['version'];

			// 1: file is published
			// 2: file is unpublished
			// 3: file does not exist
			if ( JFile::exists($options['langPath'].DS.$row->filename) ) {
				$row->exists 		= 1;
				$row->path_file 	= $options['langPath'].DS.$row->filename;
				$row->published 	= 1;
				$row->writable 		= is_writable($row->path_file);
			} else if ( JFile::exists($options['langPath'].DS.$row->unpub_filename) ) {
				$row->exists 		= 1;
				$row->path_file 	= $options['langPath'].DS.$row->unpub_filename;
				$row->published 	= 0;
				$row->writable 		= is_writable($row->path_file);
			} else {
				$row->author 		= '';
				$row->date	 		= '';
				$row->exists 		= 0;
				$row->path_file 	= $options['langPath'].DS.$row->unpub_filename;
				$row->published 	= 0;
				$row->status 		= 0;
				$row->version 		= '';
				$row->writable 		= 1;
			}

			// get the checkout status of the selected file
			if ( $content = @file_get_contents($options['langPath'].DS.'chk.'.$row->filename)) {
				$row->checkedout = ( (strpos($content,'#'.$userid.'#')) || (strpos($content,'#0#')) ) ? 0 : 1;
			}

			// scan an existing language file
			if ( (!$options['isReference']) && ($row->exists) ) {
				$fileContent = file($row->path_file);
				$fileStrings = array();
				$fileMeta = TranslationsHelper::getINIMeta( $fileContent, $fileStrings, $refStrings );
				if ( $fileMeta['bom'] == 'UTF-8' ) {
					foreach ($fileMeta as $k=>$v) {
						$row->{$k} = $v;
					}
				} else {
					$row->bom = $fileMeta['bom'];
					$row->writable = 0;
				}
			} else {
				$fileContent = array();
				$fileStrings = array();
				$fileMeta = array();
			}

			// search the files
			// $refContent and $fileContent are arrays containing each line of the reference and translation file
			if ( $options['dosearch'] ) {
				$row->searchfound_ref = preg_match_all($options['dosearch'], implode("\n",$refContent), $arr );
                if (! $options['isReference'] ) {
                    $row->searchfound_tran = preg_match_all($options['dosearch'], implode("\n",$fileContent), $arr );
                } else {
                    $row->searchfound_tran = $row->searchfound_ref;
                }
				$row->searchfound = $row->searchfound_ref + $row->searchfound_tran;
			}

			// set the datetime
			$row->datetime = $row->date.$row->time;

			// change the name
			if ($row->name == '') {
				$row->name = ' [core]';
			}

			// store the file
			$rows[$row->name] = $row;
		}


		// build the fileset totals and filter out rows we don't need/want
		$options['fileset-files'] 	= 0;
		$options['fileset-exists'] 	= 0;
		$options['fileset-published'] = 0;
		$options['fileset-refstrings'] = 0;
		$options['fileset-changed'] = 0;
		foreach( $rows as $k=>$row) {
			// add to totals
			$options['fileset-files']++;
			$options['fileset-exists'] 		+= $row->exists;
			$options['fileset-published'] 	+= $row->published;
			$options['fileset-refstrings'] 	+= $row->refstrings;
			$options['fileset-changed'] 	+= $row->changed;

			// filter out searched items
			// filter out published or unpublished items
			// filter out status of items
			if 	(
				( ($options['dosearch']) && ($row->searchfound == 0) )
			||	( ($options['filter_state']=='P') && ($row->published <> 1) )
			||	( ($options['filter_state']=='U') && ($row->published <> 0) )
			||	( ($options['filter_status']=='NS') && ($row->status > 0) )
			||	( ($options['filter_status']=='IP') && (($row->status <= 0)||($row->status >= 100)) )
			||	( ($options['filter_status']=='C') && ($row->status < 100) )
				) {
				unset($rows[$k]);
			}
		}

		// set fileset status
		if ($options['fileset-changed'] == 0) {
			$options['fileset-status'] = 0;
		}
		if ($options['fileset-refstrings'] == $options['fileset-changed']) {
			$options['fileset-status'] = 100;
		} else {
			$options['fileset-status'] = floor( ($options['fileset-changed']/$options['fileset-refstrings'])*100 );
		}

		// build the pagination
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( count($rows), $options['limitstart'], $options['limit'], 'index.php?option='.$option.'&amp;task=language_files' );

		// sort the $rows array
		$order_Int = (strtolower($lists['order_Dir'])=='desc') ? -1 : 1;
		JArrayHelper::sortObjects( $rows, $lists['order'], $order_Int );

		// slice the array so we only show one page
		$rows = array_slice( $rows, $pageNav->limitstart, $pageNav->limit );

		// call the html view
		Language_manager_html::Show_files($rows, $options, $lists, $pageNav);
		
	}
	
	/**
	* Create Edit or Save a Translation File
	*/
	function edit_language()
	{
		global $option;
		// import file functions
		jimport('joomla.filesystem.file');

		// variables
		global $mainframe;
		$options = Language_manager::getOptions();
		$options['newprocess'] = 0;
		
		// build the search highlight array
		$options['filter_search'] =	$mainframe->getUserStateFromRequest( $option.'.files.filter_search',	'filter_search', '' );


		// 2: otherwise verify that we have a filename
		// 3: otherwise validate the checkout status of the selected file
		if (empty($options['filename'])) {
			$mainframe->enqueueMessage( JText::_('You must select a file to edit') );
			$mainframe->redirect( 'index.php?option='.$option.'&task=language_files' );
		} else if ( $content = @file_get_contents($options['langPath'].DS.'chk.'.$options['filename'])) {
			list ($timestamp,$userid,$username) = explode( '#', $content.'##' );
			$user = & JFactory::getUser();
			// validate the checkout
			if	(
				( (time()-$timestamp) < 3600 )
			&&	( $userid <> 0 )
			&&	( $userid <> $user->get('id','0') )
				) {
				// report and redirect
				$checkin = '<a href="index.php?option='.$option.'&task=checkin&id='.$options['filename'].'" title="'. JText::_( 'Force Checkin' ) . '" style="font-size:smaller">[' . JText::_( 'Checkin' ) . ']</a>';
				$mainframe->enqueueMessage(sprintf(JText::_('checked out by'), $options['filename'], $username, $checkin ) );
				$mainframe->redirect( 'index.php?option='.$option.'&task=language_files' );
			}
		}

		// set the reference language filename from the selected filename
		$options['refFilename'] = str_replace($options['lang'],$options['refLang'],$options['filename']);

		// find the published reference language file
		// default to an unpublished reference file
		if ( JFile::exists($options['refLangPath'].DS.$options['refFilename']) ) {
			$options['ref_path_file'] = $options['refLangPath'].DS.$options['refFilename'];
		} else {
			$options['ref_path_file'] = $options['refLangPath'].DS.'xx.'.$options['refFilename'];
		}

		// find the published selected language file
		// default to an unpublished new file
		if ( JFile::exists($options['langPath'].DS.$options['filename']) ) {
			$options['path_file'] = $options['langPath'].DS.$options['filename'];
		} else {
			$options['path_file'] = $options['langPath'].DS.'xx.'.$options['filename'];
		}

		// STRINGS: initialise $editData from the reference language file contents
		// $editData is an analogue of the reference file
		// header lines are skipped
		// comments and blank lines are strings with an integer index
		// key=value pairs are arrays with the key as an index
		$editData = array();
		$header = 0;
		$refStrings = array();
		if ( $refContent = @file($options['ref_path_file']) ) {
			foreach ($refContent as $k=>$v) {
				$v = trim($v);
				// grab the comments (but skip up to 6 lines before we have any strings in the file)
				// grab the strings
				if ( (empty($v))||($v{0}=='#')||($v{0}==';') ) {
					if($header++>6) $editData[$k] = $v;
				} else if(strpos($v,'=')) {
					$header = 7;
					list($key,$value) = explode('=',$v,2);
					$key = strtoupper($key);
					$refStrings[$key] = $value;
					$editData[$key] = array('ref'=>$value,'edit'=>$value);
					if ($options['isReference']) {
						$editData[$key]['lang_file'] = $value;
					}
				}
			}
		}

		// STRINGS: load the selected file contents and process into $editData
		// only when the selected language is not the same as the reference language
		if ($options['isReference']) {
			$fileContent = $refContent;
			$fileStrings = array();
			$fileMeta = TranslationsHelper::getINIMeta( $fileContent, $fileStrings );
			$editStrings = $fileStrings;
		} else if ( $fileContent = @file($options['path_file']) )  {
			$fileStrings = array();
			$fileMeta = TranslationsHelper::getINIMeta( $fileContent, $fileStrings );
			$editStrings = $fileStrings;
			foreach ( $fileStrings as $k=>$v ) {
				$editData[$k]['edit'] = $v;
				$editData[$k]['lang_file'] = $v;
			}
		} else {
			$fileContent = array();
			$fileStrings = array();
			$fileMeta = array( 'headertype'=>1, 'owner'=>'ff', 'complete'=>0 );
			$editStrings = array();
		}

		// STRINGS: load the user form contents and process into $editData
		$editFormOnly = array();
		if ($FormKeys = JRequest::getVar( 'ffKeys', array(), '', 'ARRAY', JREQUEST_ALLOWRAW )) {
			$FormValues = JRequest::getVar( 'ffValues', array(), '', 'ARRAY', JREQUEST_ALLOWRAW );
			// process each key=value pair from the form into $editData
			foreach ($FormKeys as $k=>$v) {
				if ( ($v) && (isset($FormValues[$k])) ) {
					$key = strtoupper(trim(stripslashes($v)));
					$value = trim(stripslashes(str_replace('\n',"\n",$FormValues[$k])));
					$editStrings[$key] = $value;
					$editData[$key]['edit'] = $value;
					$editData[$key]['user_form'] = $value;
				}
			}
			// every element of $editData must have a form entry
			foreach($editData as $k=>$v){
				if ( is_array($v) && !isset($v['user_form']) ) {
					unset($editStrings[$k]);
					unset($editData[$k]);
				}
			}
		}

		// META: get the XML and status meta then initialise
		$options['XMLmeta'] = TranslationsHelper::getXMLMeta($options['langPath'].DS.$options['lang'].'.xml');
		$statusMeta = TranslationsHelper::getINIstatus( $refStrings, $editStrings );
		$editMeta = array_merge( $options['XMLmeta'], $fileMeta, $statusMeta );
		$editMeta['filename'] = $options['filename'];

		// META: apply any user form values
		foreach($editMeta as $k=>$v) {
			$editMeta[$k] = JRequest::getVar($k,$v,'','string');
		}

		// META: require meta values
		foreach(array('version','author') as $v) {
			if(empty($editMeta[$v])) {
				$options['field_error_list'][$v] = JText::_($v);
			}
		}

		// ERRORS: report any errors and change the task
		if ((!empty($options['field_error_list']))) {
			$mainframe->enqueueMessage( sprintf( JText::_('Values Required'), implode(', ',$options['field_error_list']) ) );
			$options['task'] = 'language_edit';
		}

		// create a new file or save an existing file
		if (($options['task']=='apply_language')||($options['task']=='save_language')) {

			// ensure the file does not already exist when we are creating a new file
			if ( ($options['newprocess'])&&(JFile::exists($options['path_file'])) ) {
				// report error and set task flag
				$mainframe->enqueueMessage( sprintf(JText::_('Language INI Exists'),$options['newfilename']) );
				$options['task'] = 'language_edit';
			}

			// otherwise save the file
			else {
				// check the complete status
				// we set the complete value to the number of strings that are 'unchanged'
				// so that if the reference INI file should change the 'complete' flag is unset/broken
				$editMeta['complete'] = JRequest::getVar( 'complete', '', 'post', 'string' );
				$editMeta['complete'] = ( $editMeta['complete'] == 'COMPLETE' ) ? $editMeta['unchanged'] : 0;
				// build the header
				if ($editMeta['headertype']==1) {
					$saveContent = '# $Id: ' . $options['filename'] . ' ' . $editMeta['version'] . ' ' . date('Y-m-d H:i:s') . ' ' . $editMeta['owner'] . ' ~' . $editMeta['complete'] . ' $';
				} else {
					$saveContent = '# version ' . $editMeta['version'] . ' ' . date('Y-m-d H:i:s') . ' ~' . $editMeta['complete'];
				}
				$saveContent .= "\n" . '# author ' . $editMeta['author'];
				$saveContent .= "\n" . '# copyright ' . $editMeta['copyright'];
				$saveContent .= "\n" . '# license ' . $editMeta['license'];
				$saveContent .= "\n\n" .  '# Note : All ini files need to be saved as UTF-8';
				$saveContent .= "\n\n";

				// process the $editData array to get the remaining content
				$changedStrings = array();
				$header = 0;
				foreach ($editData as $k=>$v) {
					// 1: add a blank line or comment
					// 2: add a key=value line (no need to addslashes on quote marks)
					if (!is_array($v)) {
						$saveContent .= $v . "\n";
					} else {
						// change newlines in the value
						$value = preg_replace( '/(\r\n)|(\n\r)|(\n)/', '\n', $v['edit'] );
						// change single-quotes or backticks in the value
						if ($options['backticks']>0) {
							$value = strtr( $value, "'", '`' );
						} else if ($options['backticks']<0) {
							$value = strtr( $value, '`', "'" );
						}
						// set back to $editData
						$editData[$k]['edit'] = $value;
						// add to file content
						$saveContent .= $k . '=' . $value . "\n";
						// if the string is in the selected language file
						if (isset($v['lang_file'])) {
							// and it has changed (via the user form)
							if ($v['lang_file'] != $v['edit']) {
								// log the change in a translation array
								$changedStrings[ "\n".$k.'='.$v['lang_file'] ] = "\n".$k.'='.$v['edit'];
							}
						}
					}
				}

				// if there is no reference Language File, automatically initialise/create one which is the same as the selected language file
				if ($options['refLangMissing']) {
					if ( JFile::write( $options['refLangPath'].DS.$options['refLangFile'], trim($saveContent) ) ) {
						$mainframe->enqueueMessage(sprintf(JText::_('Language INI Created'), $options['refLangFile'] ) );
					}
				}

				// 1: write the selected language file and clear newprocess flag
				// 2: report failure
				if ( JFile::write( $options['path_file'], trim($saveContent) ) ) {
					$mainframe->enqueueMessage(sprintf(JText::_('Language INI '.(($options['newprocess'])?'Created':'Saved') ),$options['clientName'],$options['filename'] ) );
					$options['newprocess'] = 0;
				} else {
					$mainframe->enqueueMessage( sprintf(JText::_('Could not write to file'),$options['path_file']) );
				}

				// process changed strings globally across all the the ini files from the selected language directory
				if ( (count($changedStrings)) && ($options['globalChanges']) ) {
					$write = 0;
					$writeFiles = array();
					if ($files = JFolder::files($options['langPath'])) {
						foreach ($files as $file) {
							// skip non-INI files
							// skip this file
							// skip this file (unpublished)
							// skip checked out files
							if	(
								(strtolower(substr($file,-4)!='.ini'))
								|| ($file==$options['filename'])
								|| ($file=='xx.'.$options['filename'])
								|| (array_search($options['langPath'].DS.'chk.'.$file,$files))
								) {
								continue;
							}

							// otherwise grab the file content
							if ($content = file_get_contents($options['langPath'].DS.$file)) {
								// parse the changed strings
								$new_content = strtr( $content, $changedStrings );
								// check for changes then write to the file
								if ($new_content != $content) {
									if ( JFile::write( $options['langPath'].DS.$file, trim($new_content) ) ) {
										$writeFiles[$write++] = $file;
									}
								}
							}
						}
					}
					// report
					if ($write) {
						$mainframe->enqueueMessage( sprintf(JText::_('Global String Change'), $write, implode('; ',$writeFiles) ) );
					}
				}
			}

		}

		// 1: checkin when we are saving (this will redirect also)
		// 2: call the html when we are editing or applying (and checkout existing files)
		if ($options['task'] == 'save_language') {
			Language_manager::multitask( 'checkin', $options['filename'], 'language_files', false );
		} else {		
			Language_manager_html::Show_edit($editData, $editMeta, $options);
			if (!$options['newprocess']) {
				Language_manager::multitask( 'checkout', $options['filename'], false, false );
			}
		}
	}
}


class Language_manager_html {
	function Show_languages($data, $options, $lists, $pagenav) {
		global $option;
		// TOOLBAR
		JToolbarHelper::title( JText::_( 'Language Manager' ), 'langmanager.png' );
		JToolbarHelper::custom('language_files','edit','','View Files');
		
		?>
		
		<div>
		<form action="index.php" method="post" name="adminForm">
			<input type="hidden" name="<?php echo JUtility::getToken(); ?>" value="1" />
			<input type="hidden" name="option" value="<?php echo $option;?>" />
			<input type="hidden" name="task" value="language" />
			<input type="hidden" name="boxchecked" value="1" />
			<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
			<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
		
			<table class="adminlist" id="languages">
		
				<thead>
					<tr>
						<th width="20">&nbsp;</th>
						<th width="15%"><?php echo JText::_( 'Client' ); ?></th>
						<th width="20%"><?php echo JHTML::_( 'grid.sort', 'Language', 'tag', $lists['order_Dir'], $lists['order'], $options['task'] ); ?></th>
						<th width="5%"><?php echo JText::_( 'Default' ); ?></th>
						<th width="5%"><?php echo JText::_( 'Files' ); ?></th>
						<th width="5%"><?php echo JText::_( 'Version' ); ?></th>
						<th width="60"><?php echo JText::_( 'Date' ); ?></th>
						<th width="20%"><?php echo JText::_( 'Author' ); ?></th>
					</tr>
				</thead>
		
				<tfoot>
					<td width="100%" colspan="9"><?php echo $pagenav->getListFooter(); ?></td>
				</tfoot>
		
				<tbody>
				<?php
				// process the rows (each is an XML language file)
				$k = 0;
				for ($i=0, $n=count( $data ); $i < $n; $i++) {
					$row =& $data[$i];
					?>
					<tr class="row<?php echo $i; ?>">
						<td width="20">
							<?php echo '<input type="radio" name="client_lang" value="' . $row->client_lang . '" ' . ( ($row->client_lang==$options['client_lang']) ? 'checked ' : '' ); ?> />
						</td>
						<td width="15%">
							<b><?php echo $row->client_name	;?></b>
						</td>
						<td width="25%">
							<?php echo Language_manager_html::getTooltip( '['.$row->tag.'] &nbsp; '.$row->name, $row->description, $row->name, '' ); ?>
						</td>
						<td align="center">
							<?php echo ($row->isdefault) ? '<img src="templates/khepri/images/menu/icon-16-default.png" alt="'.JText::_('Default').'" />' : '&nbsp;'; ?>
						</td>
						<td align="center">
							<?php echo '<a href="index.php?option='.$option.'&amp;task=language_files&amp;client_lang=' . $row->client_lang .'">' . Language_manager_html::getTooltip( $row->files, null, 'View Files', 'TC' ) . '</a>'; ?>
						</td>
						<td align="center">
							<?php echo $row->version; ?>
						</td>
						<td align="center">
							<?php echo $row->creationDate; ?>
						</td>
						<td align="center">
							<?php echo $row->author; ?>
						</td>
					</tr>
				<?php
				}
				?>
				</tbody>
		
			</table>
		
		</form>
		</div>
		<?php
	}
	
	function Show_files($data, $options, $lists, $pagenav) {
		global $option;
		// TOOLBAR
		$langName = ' <small><small> : ' . $options['langName'] . '</small></small>';
		JToolbarHelper::title( JText::_( 'Language Files' ) . $langName, 'langmanager.png' );
		JToolbarHelper::custom('language','upload.png','upload_f2.png','Languages',false);
		JToolbarHelper::divider();
		JToolbarHelper::unpublishList('language_unpublish');
		JToolbarHelper::publishList('language_publish');
		JToolbarHelper::deleteList(JText::_('Confirm Delete INI'), 'remove_language');
		JToolbarHelper::editList('edit_language');
		
		?>
		<div >
		<form action="index.php" method="post" name="adminForm">
			<input type="hidden" name="<?php echo JUtility::getToken(); ?>" value="1" />
			<input type="hidden" name="option" value="<?php echo $option;?>" />
			<input type="hidden" name="task" value="language_files" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
			<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
		
			<table  width="100%">
			<tr>
				<td><b><?php echo JText::_( 'Language' ); ?>:</b></td>
				<td><?php echo $lists['client_lang']; ?></td>
				<?php
					if (!$options['isReference']) {
						echo '<td align="left"><div style="border:solid silver 1px;background:white;width:100px;height:8px;"><div style="height:100%; width:' . $options['fileset-status'] . 'px;background:green;"></div></div></td><td><b>'. $options['fileset-status'] .'%&nbsp;</b></td>';
						echo '<td width="100%" align="left"><div style="font-size:smaller">'. sprintf( JText::_('of translated'), $options['fileset-changed'], $options['fileset-refstrings'] ) .'<br>'. sprintf( JText::_('of published'), $options['fileset-exists'], $options['fileset-published'], $options['fileset-files']  ) .'</td>';
					}
					else {
						echo '<td width="100%" align="left"><div style="font-size:smaller"><div style="color:red">'. JText::_('Warning Default Language') .'</div>'. sprintf( JText::_('of published'), $options['fileset-published'], $options['fileset-exists'], $options['fileset-files'] ) .'</div></td>';
					}
				?>
				<td align="right" nowrap="nowrap">
					<?php
					$html = '<img src="images/search_f2.png" align="absmiddle" width="16" height="16" alt="?" style="cursor:pointer" onclick="if(e=getElementById(\'filter_search\')){e.form.submit();}">';
					echo '<div style="border:1px solid gray;background-color:#e9e9e9"> &nbsp; ' . Language_manager_html::getTooltip( $html, 'Search Translation Files', 'Search', 'TC' ) . ' ';
					echo $lists['search'].' &nbsp; </div>';
					?>
				</td>
				<td align="right"><?php echo $lists['state']; ?></td>
				<td align="right"><?php echo $lists['status']; ?></td>
			</tr>
			</table>
		
			<table class="adminlist" id="files">
		
				<thead>
				<tr>
					<th width="20"><?php echo JText::_( 'Num' ); ?></th>
					<th width="20"><input type="checkbox" name="toggle" value=""  onclick="checkAll(<?php echo count( $data ); ?>);" /></th>
					<th width="25%"><?php echo JHTML::_( 'grid.sort',  'File', 'name', $lists['order_Dir'], $lists['order'], $options['task'] ); ?></th>
					<th width="40"><?php echo JText::_( 'State' ); ?></th>
					<th width="100"><?php echo JHTML::_( 'grid.sort',  'Status', 'status', $lists['order_Dir'], $lists['order'], $options['task'] ); ?></th>
					<th width="100"><?php echo JHTML::_( 'grid.sort',  'Strings', 'strings', $lists['order_Dir'], $lists['order'], $options['task'] ); ?></th>
					<th width="40"><?php echo JHTML::_( 'grid.sort',  'Version', 'version', $lists['order_Dir'], $lists['order'], $options['task'] ); ?></th>
					<th width="40"><?php echo JHTML::_( 'grid.sort',  'Date', 'datetime', $lists['order_Dir'], $lists['order'], $options['task'] ); ?></th>
					<th width="20%"><?php echo JHTML::_( 'grid.sort',  'Author', 'author', $lists['order_Dir'], $lists['order'], $options['task'] ); ?></th>
				</tr>
				</thead>
		
				<tfoot>
					<td  width="100%" colspan="9">
						<?php echo $pagenav->getListFooter(); ?>
					</td>
				</tfoot>
		
				<tbody>
				<?php
				// process the rows (each is an INI translation file)
				for ($i=0, $n=count( $data ); $i < $n; $i++) {
					$row =& $data[$i];
					$link = 'index.php?option='.$option.'&task=edit_language&client_lang='.$options['client_lang'].'&cid[]='. $row->filename;
					?>
					<tr class="row<?php echo $i; ?>">
						<td width="20">
							<?php echo $pagenav->getRowOffset( $i ); ?>
						</td>
						<td width="20">
							<?php
							// only select writable files
							if ($row->checkedout) {
								echo '<img src="images/checked_out.png" title="'.JText::_( 'Checked Out' ).'" alt="x" />';
							} else if ($row->writable) {
								echo '<input type="checkbox" id="cb'.$i.'" name="cid[]" value="'.$row->filename.'" onclick="isChecked(this.checked);" />';
							} else {
								echo '&nbsp;';
							}
							?>
						</td>
						<td width="25%">
							<?php
							// edit all files
							if ($row->writable) {
								echo '<a href="' . $link . '" title="' . JText::_( 'Edit' ) . '">' . $row->name . '</a>';
							} else {
								echo $row->name;
							}
							if ( $row->bom != 'UTF-8' ) {
								echo ' &nbsp; <a href="http://en.wikipedia.org/wiki/UTF-8" target="_blank"><b style="font-size:smaller;color:red">' . Language_manager_html::getTooltip( $row->bom, null, 'Not UTF-8', 'TC' ) . '</b></a>';
							}
							// search matches
							if ($row->searchfound) {
								$row->searchtext = htmlspecialchars($options['filter_search'],ENT_QUOTES);
								if ($row->searchfound_ref) {
									echo '<div style="font-size:smaller;color:red"> &nbsp; ' . sprintf( JText::_('matches ref file'), $row->searchfound_ref, $row->searchtext ) . '</div>';
								}
								if ($row->searchfound_tran) {
									echo '<div style="font-size:smaller;color:green"> &nbsp; ' . sprintf( JText::_('matches tran file'), $row->searchfound_tran, $row->searchtext ) . '</div>';
								}
							}
							?>
						</td>
						<td align="center">
							<?php
							// only publish / unpublish writable files
							if (!$row->exists) {
								echo Language_manager_html::getTooltip( '<img src="images/disabled.png" alt="x" />', null, 'Does Not Exist', 'TC' );
							} else if ($row->writable) {
								echo JHTML::_( 'grid.published',  $row, $i, 'publish_g.png', 'publish_r.png', 'language_' );
							} else if ($row->published) {
								echo '<img src="images/publish_g.png" alt="'.JText::_( 'Published' ).'" />';
							} else {
								echo '<img src="images/publish_r.png" alt="'.JText::_( 'Not Published' ).'" />';
							}
							?>
						</td>
						<td width="100" align="center">
							<?php
							// no reference file
							// status is inapplicable
							// status is 100 (complete)
							// status is 0 (not started)
							// status is in progress
							if ( $row->bom != 'UTF-8' ) {
								echo Language_manager_html::getTooltip( '<a href="http://en.wikipedia.org/wiki/UTF-8" target="_blank"><img src="'.substr_replace(JURI::root(), '', -1, 1).'/includes/js/ThemeOffice/warning.png" alt="!" /></a>', null, 'Not UTF-8', 'TC' );
							} else if (!$row->refexists) {
								echo Language_manager_html::getTooltip( '<img src="images/disabled.png" alt="x" />', null, 'No Reference File', 'TC' );
							} else if ($options['isReference']) {
								echo Language_manager_html::getTooltip( '<img src="images/disabled.png" alt="x" />', null, 'This is the Reference Language', 'TC' );
							} else if ($row->status == 100) {
								echo Language_manager_html::getTooltip( '<img src="images/tick.png" alt="1000%" />', null, 'Complete', 'TC' );
							} else if ($row->status == 0) {
								echo Language_manager_html::getTooltip( '<img src="images/publish_x.png" alt="0%" />', null, 'Not Started', 'TC' );
							} else {
								echo '<span title="'. JText::_('In Progress') .': '. $row->changed . ' '. JText::_('Changed') .'">' . $row->status . '%<div style="text-align:left;border:solid silver 1px;width:100px;height:2px;"><div style="height:100%; width:' . $row->status . '%;background:green;"></div></div></span>';
							}
							?>
						</td>
						<td align="center">
							<?php
							if ($options['isReference']) {
								$status = $row->strings;
							} else {
								if ($row->changed==$row->refstrings) {
									$status = $row->refstrings;
								} else {
									$status = $row->changed . '/' . $row->refstrings;
								}
								if($row->extra) {
									$status .= ' +' . $row->extra;
								}
							}
							if ($row->changed==0) {
								$tip = null;
								$caption = 'Not Started';
								$jtext = 'TC';
							} else if ($row->unchanged + $row->missing + $row->extra == 0) {
								$tip = null;
								$caption = 'Complete';
								$jtext = 'TC';
							} else {
								$tip = '';
								$tip .= ($row->unchanged==0) ? '' : sprintf(JText::_('Overlib Unchanged'), $row->unchanged) . '<br>';
								$tip .= ($row->missing==0) ? '' : sprintf(JText::_('Overlib Missing'), $row->missing) . '<br>';
								$tip .= ($row->extra==0) ? '' : sprintf(JText::_('Overlib Extra'), $row->extra) . '<br>';
								$caption = sprintf(JText::_('Overlib Strings'), $row->refstrings);
								$jtext = '';
							}
							echo Language_manager_html::getTooltip( $status, $tip, $caption, $jtext );
							?>
						</td>
						<td align="center">
							<?php echo $row->version; ?>
						</td>
						<td align="center">
							<?php echo '<span title="' . $row->time .'">' . $row->date . '</span>'; ?>
						</td>
						<td align="center">
							<?php echo $row->author; ?>
						</td>
					</tr>
				<?php
				}
				?>
				</tbody>
		
			</table>
		
		</form>
		</div>
		<?php
	}
	
	function Show_edit($data, $meta, $options) {
		global $option;
		// CONFIGURATION
		$metaTokens = array (
			'version' 	=> 10,
			'author'	=> 80,
			'copyright'	=> 80,
			'license' 	=> 80,
		);
		
		// TOOLBAR
		$newprocess = JRequest::getVar('newprocess',0,'','integer' );
		$action = 'Edit';
		JToolbarHelper::title(JText::_($action.' INI'),'langmanager.png');
		JToolbarHelper::save('save_language');
		JToolbarHelper::apply('apply_language');
		JToolbarHelper::cancel('cancel_language');
		
		?>
		<style type="text/css" >
			#fftranslation legend {
				color:black;
			}
			
			#fftranslation tr {
				vertical-align:top;
			}
			
			td.ffMeta b i {
				color:red;
			}
			td.ffMetaToken {
				background-color: #f6f6f6;
				border-bottom: 1px solid #e9e9e9;
				border-right: 1px solid #e9e9e9;
				color: #666;
				font-weight: bold;
				text-align: right;
				vertical-align:top;
				width:150px;
			}
			td.ffKeys {
				background-color: #f6f6f6;
				border:solid black 1px;
				color: #666;
				font-weight: bold;
				text-align: right;
				width:250px;
			}
			td.ffKeys input {
				width:200px;
			}
			td.ffCounter {
				color:gray;
				font-size:smaller;
				width:10px;
			}
			td.ffToken{
				background-color: #f6f6f6;
				border-bottom: 1px solid #e9e9e9;
				border-right: 1px solid #e9e9e9;
				color: #666;
				font-weight: bold;
				text-align: right;
				width:50%;
			}
			span.ffToken {
				font-weight:normal;
			}
			
			td.ffValue{
				width:50%;
			}
			
			.ffChanged, .ffError, .ffExtra, .ffUnchanged {
				width:90%;
				padding-left:2px;
				vertical-align:top;
			}
			.ffError {
				border-left:solid red 2px;
			}
			.ffExtra {
				border-left:solid green 2px;
			}
			.ffUnchanged {
				border-left:solid red 2px;
			}
			
			.ffCopy {
				float:right;
				margin-top:2px;
			}
			.ffReset {
				margin-top:2px;
				margin-right:2px;
			}
		</style>
		
		<script language="javascript" type="text/javascript">
		var ffacElement;
		var ffacList = new Array();
		var ffacOldName = '';
		var ffacOldValue = '';
		function ffAutoCorrect(element) {
			// initialise variables on first call, then timeout for one second
			if (typeof(element) == 'object') {
				ffacElement = element;
				element = null;
				ffacOldName = ffacElement.name;
				ffacOldValue = ffacElement.value;
				setTimeout("ffAutoCorrect()",1000);
			}
			// process on second call, only if name and value are unchanged
			else if ( (ffacElement.name == ffacOldName) && (ffacElement.value == ffacOldValue) ) {
				// get element length
				el = ffacElement.value.length;
				// process the AutoCorrect List
				for (s in ffacList) {
					// skip non-strings
					if ( typeof(ffacList[s]) != "string" ) continue;
					// get search string length
					sl = s.length;
					// check element is at least as long as search string
					if (el>=sl) {
						// check for matching string at end of element
						if ( ffacElement.value.slice(el-sl) == s ) {
							// replace matching string
							ffacElement.value = ffacElement.value.slice(0,el-sl) + ffacList[s];
							// return after making the replacement
							return;
						}
					}
				}
			}
		}
		
		/**
		 * ffAppendRow
		 * Append a row (src) to the end of a table (table)
		 */
		function ffAppendRow(table,src) {
			if ( document.getElementById(table) && document.getElementById(src) ) {
				// add new row at end of table
				var newTR = document.getElementById(table).insertRow(-1);
				// IE won't let us set the innerHTML of a row object, we need to copy the cells and their properties from the source
				var cells = document.getElementById(src).cells;
				var props = new Array('width','align','valign','colSpan','innerHTML','className');
				for(var td=0;td<cells.length;td++){
					// add new cell at the end of the row, then copy the properties
					var newTD = newTR.insertCell(-1);
					for (var p=0;p<props.length;p++) {
						var prop = props[p];
						if (cells[td][prop]) newTD[prop] = cells[td][prop];
					}
				}
			}
		}
		
		/**
		 * ffCheckDisable
		 * Disable the fields linked to a checkbox (chk) by ID (id)
		 */
		var ffchkconfirm = true;
		var ffchkmessage = 'Are you sure you want to delete this phrase?';
		function ffCheckDisable(chk,id) {
			if ((!chk) || (!id)) return;
			// 1: box has been checked - turn off flag
			// 2: box has been cleared - flag is on
			if (! chk.checked) {
				ffchkconfirm = true;
			} else if (ffchkconfirm) {
				chk.checked = ffchkconfirm = window.confirm(ffchkmessage);
			}
			// set the key and input form
			chk.form['key'+id].disabled = chk.form['value'+id].disabled = chk.checked;
		}
		/**
		 * ffCopySpanToInput
		 * Copy the reference value to an input box
		 */
		function ffCopyRef2Val(i) {
			src = 'ref' + i;
			dst = 'value' + i;
			if ( document.getElementById(src) && document.getElementById(dst) ) {
				document.getElementById(dst).value = document.getElementById(src).innerHTML;
			}
		}
		/**
		 * ffReset
		 * Reset the value of a form field to its default value
		 */
		function ffResetVal(id) {
			if ( document.getElementById(id) ) {
				document.getElementById(id).value = document.getElementById(id).defaultValue;
			}
		}

		function submitbutton(pressbutton) {
			if (pressbutton == "cancel_language") {
				submitform(pressbutton);
				return;
			}
			var form = document.adminForm;
			submitform(pressbutton);
		}
		// set a timeout to refresh the page
		window.setTimeout ('if( window.confirm("<?php echo JText::_( 'Apply Reminder', 1 ); ?>" ) ) submitform("apply");', 300000);
		// initialise ffAutoCorrect array
		<?php foreach ($options['autoCorrect'] as $k=>$v) echo "ffacList['$k'] = '$v';\n"; ?>
		// initialise ffCheckDisable message
		ffchkmessage = '<?php echo ( $options['isReference'] ? JText::_('Warning Default Language',1) . '\n' : '' ) . JText::_('Confirm Delete String',1); ?>';
		</script>
		
		<div>
		<form action="index.php" method="post" name="adminForm">
			<input type="hidden" name="<?php echo JUtility::getToken(); ?>" value="1" />
			<input type="hidden" name="option" value="<?php echo $option;?>" />
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="client_lang" value="<?php echo $options['client_lang']; ?>" />
			<input type="hidden" name="newprocess" value="<?php echo $options['newprocess']; ?>" />
			<input type="hidden" name="limitstart" value="<?php echo $options['limitstart']; ?>" />
		
			<div class="col100">
				<fieldset class="adminform">
					<legend><?php echo JText::_( 'Details' ) ; ?></legend>
					<table class="admintable" width="100%">
						<tr>
							<td class="ffMetaToken"><?php echo Language_manager_html::getTooltip('Language'); ?></td>
							<td class="ffMeta" nowrap><b><?php echo $options['langName'];?></b> <?php if ($options['isReference']) echo ' <i>['.JText::_('Warning Default Language').']</i></b>'; ?></td>
							<td class="ffKeys" rowspan="3" nowrap>
								<?php echo Language_manager_html::getTooltip('Key'); ?> &nbsp;
								<input class="ffChanged" type="text" readonly value="<?php echo JText::_('String Changed'); ?>"><br>
								<input class="ffUnchanged" type="text" readonly value="<?php echo JText::_('String Unchanged'); ?>"><br>
								<input class="ffExtra" type="text" readonly value="<?php echo JText::_('String Extra'); ?>">
							</td>
						</tr>
						<tr>
							<td class="ffMetaToken">
								<?php echo Language_manager_html::getTooltip('Filename'); ?>
							</td>
							<td>
								<b><?php
								// 1: NEW FILE = text input (with error CSS)
								// 2: EXISTING = hidden input
								if ($options['newprocess']) {
									echo '<input ' . ( ( ($options['task']!='add') && (isset($options['field_error_list']['filename'])) ) ? 'class="ffError"' : '' ) . ' type="text" class="inputbox" size="30" name="newfilename" value="' . htmlspecialchars($options['newfilename']) . '" />';
								} else {
									echo '<input type="hidden" name="cid[]" value="'. htmlspecialchars($options['filename']) .'" />' . $options['filename'];
								}
								?></b>
							</td>
						</tr>
					<?php
					// show Meta
					foreach ( $metaTokens as $k=>$v ) {
						$img = '<img src="templates/khepri/images/menu/icon-16-default.png" alt="*" onclick="document.adminForm.'. $k .'.value=\''. htmlspecialchars($options['XMLmeta'][$k]) .'\'" />';
						echo '
						<tr>
							<td class="ffMetaToken">
								<label for="' . $k . '">' . Language_manager_html::getTooltip( ucfirst($k) ) . '</label>
							</td>
							<td colspan="2">
								<input ' . ( ( ($options['task']!='add') && (isset($options['field_error_list'][$k])) ) ? 'class="ffError"' : '' ) . ' type="text" size="'.$v.'" name="'.$k.'" id="'.$k.'" value="'.$meta[$k].'" onkeyup="ffAutoCorrect(this)" />' . Language_manager_html::getTooltip( $img, $options['XMLmeta'][$k], sprintf( JText::_('Use The Default'), JText::_($k) ), false ) . '
							</td>
						</tr>';
					}
					// show Status/Complete
					if (!$options['isReference']) {
						$status = sprintf( JText::_('of translated'), $meta['changed'], $meta['refstrings'], $meta['extra'] );
						if ($meta['extra']) $status .= ', '. sprintf( JText::_('extra strings'), $meta['extra'] );
						echo '
						<tr>
							<td class="ffMetaToken">
								<label for="complete">' . Language_manager_html::getTooltip( 'Status' ) . '</label>
							</td>
							<td colspan="2">
								<b>'. $meta['status'] .'%</b> &nbsp; ['. $status .'] &nbsp; <input class="ffCheckbox" type="checkbox" name="complete" value="COMPLETE" />'. Language_manager_html::getTooltip( 'Mark as Complete' ) . '
							</td>
						</tr>
						';
					}
					?>
					</table>
				</fieldset>
			</div>
			<div class="clr"></div>
		
					<?php
					// Configure the search highlighting
					$search = array();
					if ($options['searchStyle']) {
						$replace = '<span style="'.$options['searchStyle'].'">$0</span>';
						foreach(explode(' ',$options['filter_search']) as $v) {
							if ($v) {
								$search[] = '/'.$v.'/i';
							}
						}
					}
					// process the file data into sections and HTML strings
					$i = 0;
					$heading = 0;
					$output = array();
					foreach($data as $k=>$v) {
		
						// 1: strings are comments or lines from the INI file (change the section name if we have a comment)
						// 2: arrays are key=value lines from the INI file
						if ( is_string($v) ) {
							if (!empty($v)) {
								$heading = trim($v,';# ');
							}
						} else {
							// initialise the row object
							$row 		= new stdClass();
							$row->cb 	= '';
							$row->css 	= 'class="ffChanged"';
							$row->edit	= $v['edit'];
							$row->i 	= ++$i;
							$row->key 	= htmlspecialchars($k,ENT_QUOTES);
							$row->match = 0;
							$row->ref 	= (!isset($v['ref'])) ? null : $v['ref'];
							$row->refshow = htmlspecialchars($row->ref);
		
							// prepare form elements and styles
							// 1: there is no reference language entry for this string
							// 2: this is the reference language file
							// 3: the reference language entry has not been changed
							// 4: the reference language entry has been changed
							if (is_null($row->ref)) {
								$row->refshow 	= '<span class="ffToken">['.$row->key.']</span>';
								$row->cb 		= '<input class="ffCheckbox" type="checkbox" onclick="javascript:ffCheckDisable(this,'.$i.');" />';
								$row->css 		= 'class="ffExtra"';
							} else if ($options['isReference']) {
								$row->cb 		= '<input class="ffCheckbox" type="checkbox" onclick="javascript:ffCheckDisable(this,'.$i.');" />';
								$row->css 		= 'class="ffChanged"';
							} else if ($row->ref == $row->edit) {
								$row->css 		= 'class="ffUnchanged"';
							}
		
							// highlight search terms
							if (count($search)) {
								$chk = preg_replace( $search, $replace, $row->refshow );
								if ( $row->refshow != $chk ) {
									$row->match++;
									$row->refshow = $chk;
								} else {
									$chk = preg_replace( $search, $replace, $row->edit );
									if ( $row->edit != $chk ) {
										$row->match++;
									} else {
										$chk = preg_replace( $search, $replace, $row->key );
										if ( $row->key != $chk ) {
											$row->match++;
										}
									}
								}
							}
		
							// store the input
							if ( (strlen($row->ref)>80) || (strlen($row->edit)>80) ) {
								$row->input = '<textarea '. $row->css .' name="ffValues[]" id="value'.$i.'" cols="80" rows="4" onkeyup="ffAutoCorrect(this)">'. htmlspecialchars( $row->edit, ENT_QUOTES ) .'</textarea>';
							} else {
								$row->input = '<input '. $row->css .' name="ffValues[]" id="value'.$i.'" type="text" size="80" value="'. htmlspecialchars( $row->edit, ENT_QUOTES ) .'" onkeyup="ffAutoCorrect(this)" />';
							}
		
							// store to the $extra or the $sections array
							if ( (!$row->ref) && (!$options['isReference']) ) {
								$extra[$k] = $row;
							} else {
								$sections[$heading][$k] = $row;
							}
						}
					}
					// add on any extra phrases at the end
					if (isset($extra)) {
						$sections['extra'] = $extra;
					}
		
					if (isset($sections)) {
		
						// process the output data by section and then by row
						foreach($sections as $k=>$v){
							// section legend
							$legend = (empty($k)) ? '' : '<legend>' . JText::_($k) . '</legend>';
							// section help
							$help = '';
							if ($k) {
								$help_key = $k . ' DESC';
								$help = JText::_($help_key);
								$help = ($help==$help_key) ? '' : '<tr valign="top"><td colspan="4">' . $help . '</td></tr>';
							}
							// section delete column (if there are any 'delete' checkboxes in the section)
							foreach ( $v as $v2 ) {
								if ($v2->cb) {
									$help .= '<tr valign="bottom"><td colspan="2"></td><td nowrap align="right"><b>' . Language_manager_html::getTooltip( 'Delete', null, 'Delete Phrase' ) . '</b></td></tr>';
									break;
								}
							}
							?>
			<div class="col100">
				<fieldset class="adminform">
					<?php echo $legend; ?>
					<table class="admintable" width="100%">
						<?php
						echo $help;
						$i=1;
						foreach($v as $row){
							?>
						<tr valign="top" id="row<?php echo $row->i; ?>">
							<td class="ffCounter">
								<?php echo ($row->match) ? '<span style="' . $options['searchStyle'] . ';width:100%">' . $i++ . '</span>' : $i++; ?>
							</td>
							<td class="ffToken">
								<?php
								if (!is_null($row->ref)) {
									echo '<a class="ffCopy" href="javascript:ffCopyRef2Val(' . $row->i . ')">' . Language_manager_html::getTooltip( '<img src="../images/M_images/arrow.png" alt="&gt;" />', null, 'COPY STRING', 'TC') . '</a>';
								}
								?>
								<input type="hidden" name="ffKeys[]" value="<?php echo $row->key ?>" id="key<?php echo  $row->i ?>"/><?php echo Language_manager_html::getTooltip( '<span id="ref' . $row->i .'">' . $row->refshow . '</span>', $row->key, JText::_('Key'), false); ?>
							</td>
							<td class="ffValue" nowrap valign="middle">
								<?php
								echo $row->input;
								echo '<a class="ffReset" href="javascript:ffResetVal(\'value' . $row->i . '\')">' . Language_manager_html::getTooltip( '<img src="'.substr_replace(JURI::root(), '', -1, 1).'/includes/js/ThemeOffice/arrow_rtl.png" vspace="middle" alt="&lt;" />', null, 'RESET STRING', 'TC') . '</a>';
								echo $row->cb;
								?>
						
							</td>
						</tr>
							<?php
							}
							?>
					</table>
				</fieldset>
			</div>
			<div class="clr"></div>
							<?php
						}
					}
						?>
		
			<div class="col100">
				<fieldset class="adminform">
					<legend><?php echo JText::_('New Phrases'); ?></legend>
					<table class="admintable" width="100%" id="extraTable">
					<tr valign="top">
						<td colspan="4"><?php echo JText::_('New Phrases DESC'); ?></td>
					</tr>
					<tr>
						<td><div id="ffExtra"></div></td>
					</tr>
					</table>
					<a href="javascript:ffAppendRow('extraTable','extraRow');"><b>[+]</b> <?php echo JText::_('Add phrases'); ?></a>
				</fieldset>
			</div>
			<div class="clr"></div>
		
			<div id="ffAddField" style="display:none">
				<table class="admintable" width="100%">
					<tr valign="top" id="extraRow">
						<td class="ffToken">
							[new key] <input class="ffUnchanged" name="ffKeys[]" type="text" size="80"  value="" style="width:50%" onchange="this.value=this.value.replace(/[=]/,'').toUpperCase()" />
						</td>
						<td class="ffValue">
							<input class="ffChanged" name="ffValues[]" type="text" size="80"  value="" />
						</td>
					</tr>
				</table>
			</div>
		
		</form>
		</div>
		<?php
	}
	
	function getTooltip ( $html, $tip=null, $caption=null, $jtext = 'HTC' )
	{
        // behaviour flag
        $behavior = false;

        // prepare JText config
        $jtext = ' ' . strtoupper($jtext);

		// 1: lookup an Automatic JText tip and caption
		// 2: lookup an Automatic JText caption
		// 3: lookup JText $tip and $caption
		if ($jtext) {
			if (is_null($tip)) {
				$caption_key = ($caption) ? $caption : $html;
				$tip_key = $caption_key . ' DESC';
				$caption = strpos($jtext,'C') ? JText::_($caption_key) : $caption_key;
				$tip = strpos($jtext,'T') ? JText::_($tip_key) : $tip_key;
				$tip = ($tip==$tip_key) ? '' : $tip;
			} else if (is_null($caption)) {
				$caption = strpos($jtext,'C') ? JText::_($html) : $html;
			} else {
				$caption = strpos($jtext,'C') ? JText::_($caption) : $caption;
				$tip = strpos($jtext,'T') ? JText::_($tip) : $tip;
			}
			// lookup JText $html
			$html = strpos($jtext,'H') ? JText::_($html) : $html;
		}
		// add the tooltip to the html
		if (($tip) || ($caption!=$html)) {
			// apply title to tip
			if (!$tip) {
				$tip = $caption;
				$caption = '';
			}
			if (!$behavior) {
				JHTML::_('behavior.tooltip');
				$behavior = true;
			}
			// build tooltip span
			$html = '<span class="editlinktip hasTip" title="' . ( $caption ? htmlspecialchars($caption) . '::' : '' ) . htmlspecialchars($tip) . '">' . $html . '</span>';
		}
		// return
		return $html;
	} 
}

class TranslationsHelper
{
	/**
	* Get Meta Info from language translation file content.
	* @param mixed 		The contents of the file using file() or get_file_contents().
	* @param array  	A blank array, strings will be returned by association
	* @param array  	Optional associative array of reference strings
	* @return array		The Meta Info in an array
	*/
	function getINIMeta( $content, &$strings, $ref_strings = null )
	{
		// convert a string to an array
		if (is_string($content)) {
			$content = explode("\n",$content,10);
		} else if (!is_array($content)) {
			$content = array();
		}

		// look for a Byte-Order-Marker at the start of the file
		$file['bom'] = 'UTF-8';
		if ($content) {
			$bom = strtolower(bin2hex(substr($content[0],0,4)));
			if ( $bom == '0000feff' ) {
				$file['bom'] = 'UTF-32 BE';
			} else if ( $bom == 'feff0000' ) {
				$file['bom'] = 'UTF-32 LE';
			} else if ( substr($bom,0,4) == 'feff' ) {
				$file['bom'] = 'UTF-16 BE';
			} else if ( substr($bom,0,4) == 'fffe' ) {
				$file['bom'] = 'UTF-16 LE';
			}
		}

		// parse the top line from one of these two formats
		//	# $Id: en-GB.mod_poll.ini 6167 2007-01-04 01:16:01Z eddiea $
		//	# version 1.5.0 2007-01-25 10:40:16 ~0 +0
		if (strpos($content[0],'.ini')) {
			$line = preg_replace('/^.*[.]ini[ ]+/','',$content[0]);
			list( $file['version'], $file['date'], $file['time'], $file['owner'], $file['complete'] ) = explode( ' ', $line . '   ', 6 );
			$file['headertype'] = 1;
		} else {
			$line = preg_replace('/^.*version/i','',$content[0]);
			$line = trim($line);
			list( $file['version'], $file['date'], $file['time'], $file['complete'] ) = explode( ' ', $line . '   ', 5 );
			$file['owner'] = '';
			$file['headertype'] = 2;
		}

		// tidy up the values
		$file['complete']	= preg_replace('/[^0-9]/', '', $file['complete']);
		$file['author'] 	= preg_replace('/^.*author[ ]+/i', '', trim($content[1],'# ') );
		$file['copyright'] 	= preg_replace('/^.*copyright[ ]+/i', '', trim($content[2],'# ') );
		$file['license'] 	= preg_replace('/^.*license[ ]+/i', '', trim($content[3],'# ') );

		// parse the strings in the file into an associative array
		$strings = array();
		foreach ($content as $line) {
			$line = trim($line);
			// 1: skip comments and blanks
			// 2: get the ucase key and value
			if ((empty($line))||($line{0}=='#')||($line{0}==';')) {
				continue;
			} else if (strpos($line,'=')) {
				list($key,$value) = explode('=',$line,2);
				$key = strtoupper($key);
				$strings[$key] = $value;
			}
		}

		// get the status compared to the ref strings
		$file = array_merge( $file, TranslationsHelper::getINIstatus( $ref_strings, $strings ) );

		// set a complete flag
		if ( ( $file['complete'] == $file['unchanged'] ) && ( $file['missing'] == 0 ) ) {
			$file['status'] = 100;
		}

		// return
		return $file;
	}

	/**
	* Get Meta Info from language translation file content.
	* @param array  	The reference strings in an associative array
	* @param array  	The language strings in an associative array
	* @return array		The Meta Info in an array
	*/
	function getINIstatus( $ref_strings, $strings )
	{
		// initialise
		$file = array();
		$file['changed'] 	= 0;
		$file['extra'] 		= 0;
		$file['missing'] 	= 0;
		$file['refstrings'] = count($ref_strings);
		$file['status']		= 0;
		$file['strings']	= count($strings);
		$file['unchanged'] 	= 0;

		// count changes
		if (!$file['strings']) {
			$file['missing'] = $file['refstrings'];
		} else if (!$file['refstrings']) {
			$file['extra'] = $file['strings'];
		} else {
			// count the changes
			$all_strings = array_merge($ref_strings,$strings);
			foreach($all_strings as $k=>$v){
				if (!isset($ref_strings[$k])) {
					$file['extra']++;
				} else if (!isset($strings[$k])) {
					$file['missing']++;
				} else if ($v!=$ref_strings[$k]) {
					$file['changed']++;
				} else {
					$file['unchanged']++;
				}
			}
		}

		// set status
		if ($file['changed'] == 0) {
			$file['status'] = 0;
		} else if ($file['strings'] == $file['changed']) {
			$file['status'] = 100;
		} else {
			$file['status'] = min(100,floor( ($file['changed']/$file['strings'])*100 ));
		}

		// return
		return $file;
	}

	/**
	* Get Meta Info from an XML language file (extends Joomla method to handle mixed/lower cases)
	* @param string $xmlFile	The file to parse including the path.
	* @return array				The Meta Info in an array
	*/
	function getXMLMeta( $xmlFile ) {

		$xmlData = array(
			'author' 		=> '',
			'authorEmail' 	=> '',
			'authorUrl'		=> '',
			'client'		=> '',
			'copyright'		=> '',
			'creationDate'	=> '',
			'date'			=> date('Y-m-d'),
			'description'	=> '',
			'license'		=> '',
			'name'			=> '',
			'tag'			=> '',
			'time'			=> date('H:m:i'),
			'version'		=> '',
		);

		// load the XML file and run some tests to ensure that it exists and is a metafile
		$xml = & JFactory::getXMLParser('Simple');
		if (is_file($xmlFile)) {
			if ( $xml->loadFile($xmlFile) ) {
				if ($xml->document->name() == 'metafile') {
				    // all the nodes in the XML file will come through as lowercase keys
				    // process the $xmlData array against the XML object tree
        			foreach ($xmlData as $k=>$v) {
					    $k_lc = strtolower($k);
						$element = & $xml->document->{$k}[0];
						if ($element) {
						    $xmlData[$k] = $element->data();
						} else {
                            $element = & $xml->document->{$k_lc}[0];
                            if ($element) {
                                $xmlData[$k] = $element->data();
                            } else {
                                $xmlData[$k] = $v;
                            }
                        }
					}
				}
			}
			// patch the date
			if ( (empty($xmlData['date'])) && (!empty($xmlData['creationdate'])) ) $xmlData['date'] = $xmlData['creationdate'];
		}

		// return
		return $xmlData;
	}

	/**
	* Transform a translation phrase.
	* @param string $s		The phrase to transform.
	* @param array $options	The configuration array for the component.
	* @return string		The transformed phrase
	*/
	function strtr($s,$options) {
		// backticks
		if ($options['backticks']>0) {
			$s = strtr($s,"'",'`');
		} else if ($options['backticks']<0) {
			$s = strtr($s,'`',"'");
		}
		// return
		return $s;
	}
}

?>