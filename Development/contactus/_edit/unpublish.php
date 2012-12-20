<?
require_once ("../config/.citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array ('in' => array ('path' => 'sites', 'section' => 'editcontent', 'skin' => 'unpublish.tpl')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

$sys_tree_id = isSet($_REQUEST['sys_tree_id']) ? $_REQUEST['sys_tree_id'] : 0;
$cmd = isSet($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';

if( $moduleValues = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetTreeDetail',array('sys_tree_id'=>$sys_tree_id )) ){
    $sys_component_id = $moduleValues['sys_component_id'];
    $sys_module_id = $moduleValues['sys_module_id'];
    $mod_content_id = $moduleValues['mod_content_id'];
    $sys_parent_id = $moduleValues['sys_parent_id'];
    $sys_skin_id = isSet($sys_skin_id) && $sys_skin_id!=0 ? $sys_skin_id : $moduleValues['tree_skin_id'];
    $tableName = $moduleValues['tableName'];
}

switch( $cmd ){
	case 'unpublishtree':
		$__APPLICATION_['database']->__runQueryByCode_( '__runquery_','MQUpdatePublished',array('sys_tree_id'=>$sys_tree_id,'published'=>0));
		echo '<script language="javascript"> window.parent.loadContent(\''.$sys_tree_id.'\',\'\');parent.$.fancybox.close(); </script>';die;
	break;
	case 'unpublishcontent':
		$__APPLICATION_['database']->__runQueryByCode_( '__runquery_','CQUpdatePublished',array('mod_content_id'=>$mod_content_id,'published'=>0,'tableName'=>$tableName));
		echo '<script language="javascript"> window.parent.loadContent(\''.$sys_tree_id.'\',\'\');parent.$.fancybox.close(); </script>';die;
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
