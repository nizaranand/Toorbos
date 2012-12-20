<?
require_once ("../config/.citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array ('in' => array ('path' => 'sites', 'section' => 'editcontent', 'skin' => 'remove.tpl')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

$sys_tree_id = isSet($_REQUEST['sys_tree_id']) ? $_REQUEST['sys_tree_id'] : 0;
$sys_parent_id = isSet($_REQUEST['sys_parent_id']) ? $_REQUEST['sys_parent_id'] : 0;
$mod_content_id = isSet($_REQUEST['mod_content_id']) ? $_REQUEST['mod_content_id'] : 0;
$tableName= isSet($_REQUEST['tableName']) ? $_REQUEST['tableName'] : 0;
$sys_module_id = isSet($_REQUEST['sys_module_id']) ? $_REQUEST['sys_module_id'] : 0;
$cmd = isSet($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';

$module = new module(array('in'=>array('sys_tree_id'=>$sys_tree_id,'currentPath'=>'')),'get');

if( ($sys_tree_id!=0 && $moduleValues = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetTreeDetail',array('sys_tree_id'=>$sys_tree_id ))) ){
  $sys_component_id = $moduleValues['sys_component_id'];
  $sys_module_id = $moduleValues['sys_module_id'];
  $tableName = $moduleValues['tableName'];
  $moduleName = $moduleValues['moduleName'];
}else{
  $moduleValues = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetModuleDetailByTableName',array('tableName'=>$tableName ));
  $moduleName = $moduleValues['moduleName'];
  $sys_component_id = $moduleValues['sys_component_id'];
}
switch( $cmd ){
  case 'removeall':
    // get all the sys_tresh items
    $trash = $__APPLICATION_['database']->fetcharray('select * from sys_trash');
    foreach( $trash as $key=>$value ){
      $sys_tree_id = 0;
      $mod_content_id = 0;
      parse_str($value['sys_trash_values']);
      if( $sys_tree_id!=0 ){
        $moduleToDelete = new module(array('in'=>array('sys_tree_id'=>$sys_tree_id,'currentPath'=>'')),'delete');
      }else if( $mod_content_id!=0 ){
        $moduleToDelete = new module(array('in'=>array('sys_component_id'=>$sys_component_id,'sys_module_id'=>$sys_module_id,'tableName'=>$tableName,'mod_content_id'=>$mod_content_id,'currentPath'=>'')),'deleteContent');
      }
      $__APPLICATION_['database']->__runquery_('delete from sys_trash where sys_trash_id='.$value['sys_trash_id']);
    }
    echo '<script language="javascript">  window.parent.location.reload(); </script>';die;         

    break;
  case 'yes':

    $contentName = '';
    if( $moduleContent = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetModuleContent',array('tableName'=>$tableName,'mod_content_id'=>$mod_content_id )) ){
      $contentName = $moduleContent['name'];
    }

    if( $sys_tree_id!=0 ){
      $moduleToDelete = new module(array('in'=>array('sys_tree_id'=>$sys_tree_id,'currentPath'=>'')),'delete');
      $__APPLICATION_['database']->__runquery_('delete from sys_trash where sys_trash_display_text="'.$contentName.' ('.$moduleName.')('.$sys_tree_id.')" and sys_trash_type="tree"');
      if( strstr($_SERVER['PHP_SELF'],'content') ){
        echo '<script language="javascript">  window.parent.location.reload(); </script>';die;         
      }else{
        echo '<script language="javascript">  window.parent.location.reload(); </script>';die;                
      }
    }else{
      $moduleToDelete = new module(array('in'=>array('sys_module_id'=>$sys_module_id,'tableName'=>$tableName,'mod_content_id'=>$mod_content_id,'currentPath'=>'')),'deleteContent');
      
      $__APPLICATION_['database']->__runquery_('delete from sys_trash where sys_trash_display_text="'.$contentName.' ('.$moduleName.')" and sys_trash_type="module" and sys_trash_values="tableName='.$tableName.'&sys_module_id='.$sys_module_id.'&mod_content_id='.$mod_content_id.'"');
      echo '<script language="javascript">  parent.$.fancybox.close(); window.parent.location.reload(); </script>';die;
    }
    break;
  case 'no':
    echo 'window.parent.hideEditScreen(); </script>';die;
    break;
}

// get the name
$contentName = '';
if( $moduleContent = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetModuleContent',array('tableName'=>$tableName,'mod_content_id'=>$mod_content_id )) ){
  $contentName = $moduleContent['name'];
}

$__APPLICATION_['channel']->channelReplace('<var:sys_tree_id>',$sys_tree_id);
$__APPLICATION_['channel']->channelReplace('<var:sys_parent_id>',$module->moduleValues['sys']['sys_parent_id']);
$__APPLICATION_['channel']->channelReplace('<var:sys_module_id>',$module->moduleValues['sys']['sys_module_id']);
$__APPLICATION_['channel']->channelReplace('<var:mod_content_id>',$module->moduleValues['sys']['mod_content_id']);
$__APPLICATION_['channel']->channelReplace('<var:tableName>',$module->moduleValues['sys']['tableName']);
$__APPLICATION_['channel']->channelReplace('<var:contentName>',$contentName);
$__APPLICATION_['channel']->channelReplace('<var:moduleName>',$moduleName);
$__APPLICATION_['channel']->show();

?>