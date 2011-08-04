<?php
/**
 * @version $Id: cacl_docman.php 1 2010-08-02 21:00:00Z ‵corePHP′ $
 * @package Community ACL
 * @author ‵corePHP′ LLC.
 * @copyright (C) 2011- ‵corePHP′ LLC.
 * @license GNU/GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Support: http://support.corephp.com/
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.event.plugin' );

class plgSystemCacl_docman extends JPlugin
{

    function onAfterInitialise ()
    {
        $app = JFactory::getApplication();
        $db = JFactory::getDBO();
        $config = new CACL_config( $db );
        $config->load();
        $user_access = cacl_get_user_access( $config );
        $component = JRequest::getCmd( 'option' );

        if ( ! $app->isSite() || 'com_docman' != $component ) {
            return;
        }

        $catId = JSite::getMenu()->getParams( JRequest::getInt( 'Itemid' ) )->get( 'cat_id' );
        $catId = JRequest::getInt( 'gid', $catId );
        $documentId = JRequest::getInt( 'bid', null );

        //get the right parent category id from db
        if ( 'doc_download' == JRequest::getCmd('task') ){
            //maybe it's the docman document id
            $sql = "
            	SELECT cat.id FROM #__docman AS doc
            	LEFT JOIN #__categories AS cat
            	  ON doc.catid=cat.id
            	WHERE doc.id={$catId}
            ";
            $db->setQuery($sql);
            $catId = $db->loadResult();
        }

        $nodes = $this->_getNodes($db, $catId);
        if ( !empty($nodes) ){
            while ( !empty($nodes[0]->subnodes)){
                $nodes = $nodes[0]->subnodes;
            }
            $catId = $nodes[0]->id;
        }

        // cat_id is the category ID in #__docman.catid === #__categories.id
        // gid is either #__docman.catid or #__docman.id. version 1.5
        // bid is #__docman.id. tells docman which file to send for download. version 1.4

        unset( $user_access['groups'][0] );
        unset( $user_access['roles'][0] );
        if ( empty($user_access['groups']) && empty($user_access['roles'])){
            return;
        }
        $groups = implode( ',', $user_access['groups'] );
        $roles = implode( ',', $user_access['roles'] );
        $not = 'allow' == $config->default_action ? '' : 'NOT';
        $sql = "
        	SELECT *
        	FROM `#__community_acl_access`
        	WHERE `option`='com_docman' && (group_id IN ({$groups}) || role_id IN ({$roles}))
        ";
        $db->setQuery( $sql );
        $res = $db->loadAssocList( 'value' );

        // Is access allowed to this category?
        if( 'allow' == $config->default_action ) {
            if ( array_key_exists( $catId, $res ) ) {
                $app->redirect( $config->redirect_url, JText::_( 'ALERTNOTAUTH' ) );
                exit();
            }
        } else {
            if ( !array_key_exists( $catId, $res ) ) {
                $app->redirect( $config->redirect_url, JText::_( 'ALERTNOTAUTH' ) );
                exit();
            }
        }

        // DOCman 1.4
        // Somebody is trying to download. Is access allowed to this document?
        if ( $documentId !== null && $documentId > 0 ) {
            $sql = "SELECT catid FROM #__docman WHERE id={$documentId}";
            $db->setQuery( $sql );
            $catId = $db->loadResult();

            if( 'allow' == $config->default_action ) {
                if ( array_key_exists( $catId, $res ) ) {
                    $app->redirect( $config->redirect_url, JText::_( 'ALERTNOTAUTH' ) );
                    exit();
                }
            } else {
                if ( !array_key_exists( $catId, $res ) ) {
                    $app->redirect( $config->redirect_url, JText::_( 'ALERTNOTAUTH' ) );
                    exit();
                }
            }
        }
    }

    function saveAccess ( $db, $docmanId, $group_id, $role_id )
    {
        if ( ! is_array( $docmanId ) || empty( $docmanId ) ) {
            return;
        }
        $values = '';
        $i = 0;
        foreach ( $docmanId as $id ) {
            $values .= $i ++ ? ',' : '';
            $values .= "('{$group_id}','{$role_id}','com_docman','id','{$id}', 1, 1)";
        }
        $sql = "INSERT INTO `#__community_acl_access` (`group_id`, `role_id`, `option`, `name`, `value`, `isfrontend`, `isbackend`) VALUES {$values};";
        $db->setQuery( $sql );
        $db->Query();

        if ( $db->getErrorNum() ) {
            JError::raiseError( 500, $db->stderr() );
        }
    }

    public static function getAdminUi ( $pane, $lists, $default_action )
    {
        self::_getMenuJs();

        $db = JFactory::getDBO();
        $query = "SELECT id,title FROM #__categories WHERE section='com_docman' && parent_id='0' ORDER BY title";
        $db->setQuery( $query );
        $menu = JHTML::_( 'select.genericlist', $db->loadAssocList( 'id' ), 'docmanCats',
            'class="inputbox" size="5" multiple="multiple" ', 'id', 'title', 0 );

        $mode = JRequest::getVar( 'mode' );
        $modeId = current( JRequest::getVar( 'cid' ) );

        $sql = "
        	SELECT cat.id,cat.title
        	FROM #__community_acl_access as acl
        	JOIN #__categories as cat
        	  ON acl.value = cat.id
        	WHERE acl.option='com_docman' && acl.{$mode}={$modeId}
        	ORDER BY cat.title
        ";
        $db->setQuery( $sql );
        $listRows = $db->loadAssocList();

        echo $pane->startPanel( JText::_( 'DOCman' ), 'DOCman' );

        ?>
    <fieldset class="adminform">
        <legend>
            <?php
            echo JText::_( 'Add New Item' );
            ?>
        </legend>
        <table class="adminform">
            <tr>
                <td valign="top" width="10%">
                    <?php
            echo $menu;
            ?>
                </td>
                <td valign="top" align="left" width="auto">
                    <input type="button" name="select_all" class="button" value="Select All" onclick="javascript: Select_all('docmanCats');"/>
                    <br/>
                    <br/>
                    <input type="button" name="add" class="button" value="Add" onclick="javascript: docmanMenu_addRow('list_body_docman');"/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div>
                        <p>
                            There is no support for DOCman sub-categories yet. Front end user
                            restriction only.
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="adminform">
    <legend>
        <?php
        echo ($default_action == 'deny' ? JText::_( 'Lists of Allowed Items' ) : JText::_(
            'Lists of Forbidden Items' ));
        ?>
    </legend>
    <table class="adminlist" cellpadding="1">
        <thead>
            <tr>
                <th width="2%" class="title">
                    <?php echo JText::_( 'NUM' ); ?>
                </th>
                <th class="title" width="35%">
                    <?php echo JText::_( 'Category' ); ?>
                </th>
                <th class="title" width="15%">
                    <?php echo JText::_( 'Category ID' ); ?>
                </th>
                <th class="title" width="10%">
                    <?php echo JText::_( 'Delete' ); ?>
                    &nbsp;&nbsp;
                    <input type="button" name="clear_all" class="button" value="<?php echo JText::_(  'Clear All' ); ?>"onclick="javascript: clearTable('list_body_docman');" />
                </th>
            </tr>
        </thead>
        <tbody id="list_body_docman">
            <?php
            $i = 0;
            foreach ( $listRows as $row ) :
            ?>
            <tr class="row<?php echo $i  ++; ?>">
                <td width="2%"><?php echo $i; ?>
                </td>
                <td><?php echo $row['title']; ?>
                    <input type="hidden" name="docmanId[]" value="<?php echo $row['id']; ?>" /></td>
                    <td align="center">
                        <?php echo $row['id']; ?>
                    </td>
                    <td align="center">
                        <a href="javascript: void(0);" onclick="javascript:delete_row(this, 'list_body_docman'); return false;" title="Delete"><img src="images/publish_x.png" border="0" alt="Delete" /></a>
                    </td>
           </tr>
           <?php endforeach; ?>
       </tbody>
   </table>
   </fieldset>
            <?php
            echo $pane->endPanel();
        }

    private function _getMenuJs ()
    {
        ?>
            <script>
            /* <![CDATA[ */
                function docmanMenu_addRow(tbl){

                    var listitem = jQuery('select#docmanCats').get(0);
                    var menuName = jQuery('select#docmanCats').find("option:selected").parent().attr("label");
                    var hidden_name = 'docmanId[]';
                    var carray = new Array;

                    var tbody = jQuery('tbody#' + tbl).get(0);

                    for (jj = 0; jj < listitem.options.length; jj++) {
                        if (listitem.options[jj].selected == true && check_id_in_table(listitem.options[jj].value, tbl)) {
                            var row = document.createElement("TR");
                            jQuery('#docmanCats :selected').each(function(i, selected){
                                if (jQuery(selected).text() == listitem.options[jj].text) {
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

                            var cell_id = document.createElement("TD");
                            cell_id.innerHTML = listitem.options[jj].value;
                            cell_id.align = "center";

                            var cell_last = document.createElement("TD");
                            cell_last.innerHTML = '<a href="javascript: void(0);" onclick="javascript:delete_row(this,\'' + tbl + '\'); return false;" title="Delete"><img src="images/publish_x.png" border="0" alt="Delete" /></a>';
                            cell_last.align = "center";

                            row.appendChild(cell0);
                            row.appendChild(cell1);
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

    private function _getNodes($db, $id) {
        $sql = "SELECT * FROM #__categories WHERE id = {$id}";
        $db->setQuery($sql);
        $nodes = array();
        foreach ($db->loadObjectList() as $node) {
            $node->subnodes = $this->_getNodes($db, $node->parent_id);
            $nodes[] = $node;
        }
        return $nodes;
    }

}