<?
require_once ("../config/.citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array ('in' => array ('path' => 'sites', 'section' => 'editcontent', 'skin' => 'movedown.tpl')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

$sys_tree_id = isSet($_REQUEST['sys_tree_id']) ? $_REQUEST['sys_tree_id'] : 0;
$cmd = isSet($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';
$spaces = isSet($_REQUEST['spaces']) ? $_REQUEST['spaces'] : '';

if( $moduleValues = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetTreeDetail',array('sys_tree_id'=>$sys_tree_id )) ){
    $sys_component_id = $moduleValues['sys_component_id'];
    $sys_module_id = $moduleValues['sys_module_id'];
    $mod_content_id = $moduleValues['mod_content_id'];
    $sys_parent_id = $moduleValues['sys_parent_id'];
    $displayOrder = $moduleValues['displayOrder'];
    $sys_skin_id = isSet($sys_skin_id) && $sys_skin_id!=0 ? $sys_skin_id : $moduleValues['tree_skin_id'];
    $tableName = $moduleValues['tableName'];
    $moduleName = $moduleValues['moduleName'];
}

switch( $cmd ){
	case 'movedown':
		for( $x=1; $x<=$spaces; $x++ ){
		    $queryCode = 'MQGetTreeDetailBelow';// :
		    $thisID = $sys_tree_id;
		    $sys_parent_id = $sys_parent_id;
		    $thisDisplayOrder = $displayOrder;
		    $movementNumber = $GLOBALS['_REQUEST']['movementNumber'];
		    /* get the id just above if no id skip */
    	    if( !($treeItem = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed',$queryCode,array('displayOrder'=>$thisDisplayOrder,'sys_parent_id'=>$sys_parent_id )) ) ){
    		    /* set debug message */
//    		    $messages->setDebugMessage( $this, array('query'=>$db->__getQueryByCode_('MQGetTreeDetailAbove',array('displayOrder'=>$thisDisplayOrder,'sys_parent_id'=>$sys_parent_id ) ), 'status'=>'failed') );
    	    }else{
    			$otherID = $treeItem['sys_tree_id'];
    			$otherDisplayOrder = $treeItem['displayOrder'];
			    /* update the displayOrder above to this */
			    $__APPLICATION_['database']->__runQueryByCode_( '__runquery_','MQUpdateTreeID',array('displayOrder'=>$thisDisplayOrder,'sys_tree_id'=>$otherID ));
			    /* update the displayOrder of this */
                $__APPLICATION_['database']->__runQueryByCode_( '__runquery_','MQUpdateTreeID',array('displayOrder'=>$otherDisplayOrder,'sys_tree_id'=>$thisID ));
		    }

			if( $moduleValues = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetTreeDetail',array('sys_tree_id'=>$sys_tree_id )) ){
			    $sys_component_id = $moduleValues['sys_component_id'];
			    $sys_module_id = $moduleValues['sys_module_id'];
			    $mod_content_id = $moduleValues['mod_content_id'];
			    $sys_parent_id = $moduleValues['sys_parent_id'];
			    $displayOrder = $moduleValues['displayOrder'];
			    $sys_skin_id = isSet($sys_skin_id) && $sys_skin_id!=0 ? $sys_skin_id : $moduleValues['tree_skin_id'];
			    $tableName = $moduleValues['tableName'];
			    $moduleName = $moduleValues['moduleName'];
			}

		}
		echo '<script language="javascript">  window.parent.loadContent(\''.$sys_parent_id.'\',\'\'); parent.$.fancybox.close(); </script>';die;
	break;
}

// get the name
$contentName = '';
if( $moduleContent = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetModuleContent',array('tableName'=>$tableName,'mod_content_id'=>$mod_content_id )) ){
	$contentName = $moduleContent['name'];
}

$__APPLICATION_['channel']->channelReplace('<var:sys_tree_id>',$sys_tree_id);
$__APPLICATION_['channel']->channelReplace('<var:contentName>',$contentName);
$__APPLICATION_['channel']->channelReplace('<var:moduleName>',$moduleName);
$__APPLICATION_['channel']->show();

?>