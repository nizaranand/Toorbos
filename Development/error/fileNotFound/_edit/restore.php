<?
require_once ("../config/.citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array ('in' => array ('path' => 'sites', 'section' => 'editcontent', 'skin' => 'restore.tpl')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

$sys_tree_id = isSet($_REQUEST['sys_tree_id']) ? $_REQUEST['sys_tree_id'] : 0;
$mod_content_id = isSet($_REQUEST['mod_content_id']) ? $_REQUEST['mod_content_id'] : 0;
$tableName= isSet($_REQUEST['tableName']) ? $_REQUEST['tableName'] : 0;
$sys_module_id = isSet($_REQUEST['sys_module_id']) ? $_REQUEST['sys_module_id'] : 0;
$cmd = isSet($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';


if( $moduleValues = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetTreeDetail',array('sys_tree_id'=>$sys_tree_id )) ){
  $sys_component_id = $moduleValues['sys_component_id'];
  $sys_module_id = $moduleValues['sys_module_id'];
  $mod_content_id = $moduleValues['mod_content_id'];
  $sys_parent_id = $moduleValues['sys_parent_id'];
  $sys_skin_id = isSet($sys_skin_id) && $sys_skin_id!=0 ? $sys_skin_id : $moduleValues['tree_skin_id'];
  $tableName = $moduleValues['tableName'];
  $moduleName = $moduleValues['moduleName'];
}else{
  $moduleValues = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetModuleDetailByTableName',array('tableName'=>$tableName ));
  $moduleName = $moduleValues['moduleName'];
  $sys_component_id = $moduleValues['sys_component_id'];
}

switch( $cmd ){
  case 'yes':
    // $moduleToDelete = new module(array('in'=>array('sys_tree_id'=>$sys_tree_id,'currentPath'=>'')),'delete');
    // move to trash
    // get the name
    $contentName = '';
    if( $moduleContent = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetModuleContent',array('tableName'=>$tableName,'mod_content_id'=>$mod_content_id )) ){
      $contentName = $moduleContent['name'];
    }

    if( $sys_tree_id!=0 ){
      $__APPLICATION_['database']->__runquery_('update sys_tree set sys_trash=0, sys_published=1 where sys_tree_id='.$sys_tree_id);
      $__APPLICATION_['database']->__runquery_('delete from sys_trash where sys_trash_display_text="'.$contentName.' ('.$moduleName.')('.$sys_tree_id.')" and sys_trash_type="tree"');
      echo '<script language="javascript">  window.parent.loadContent(\''.$sys_parent_id.'\',\'\'); parent.$.fancybox.close(); </script>';die;
    }else{
      $__APPLICATION_['database']->__runquery_('update mod_'.$tableName.' set sys_trash=0, sys_published=1 where mod_'.$tableName.'_id='.$mod_content_id);
      $__APPLICATION_['database']->__runquery_('delete from sys_trash where sys_trash_display_text="'.$contentName.' ('.$moduleName.')" and sys_trash_type="module" and sys_trash_values="tableName='.$tableName.'&sys_module_id='.$sys_module_id.'&mod_content_id='.$mod_content_id.'"');
      echo '<script language="javascript">  parent.$.fancybox.close(); window.parent.location.reload(); </script>';die;      
    }
    break;
  case 'no':
    echo 'parent.$.fancybox.close(); </script>';die;
    break;
}

// get the name
$contentName = '';
if( $moduleContent = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetModuleContent',array('tableName'=>$tableName,'mod_content_id'=>$mod_content_id )) ){
  $contentName = $moduleContent['name'];
}

$__APPLICATION_['channel']->channelReplace('<var:sys_tree_id>',$sys_tree_id);
$__APPLICATION_['channel']->channelReplace('<var:sys_module_id>',$sys_module_id);
$__APPLICATION_['channel']->channelReplace('<var:mod_content_id>',$mod_content_id);
$__APPLICATION_['channel']->channelReplace('<var:tableName>',$tableName);
$__APPLICATION_['channel']->channelReplace('<var:contentName>',$contentName);
$__APPLICATION_['channel']->channelReplace('<var:moduleName>',$moduleName);
$__APPLICATION_['channel']->show();

?>