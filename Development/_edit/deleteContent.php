<?
require_once ("../config/.citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array ('in' => array ('path' => 'sites', 'section' => 'editcontent', 'skin' => 'deleteContent.tpl')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

$sys_module_id = isSet($_REQUEST['sys_module_id']) ? $_REQUEST['sys_module_id'] : 0;
$mod_content_id = isSet($_REQUEST['mod_content_id']) ? $_REQUEST['mod_content_id'] : 0;
$cmd = isSet($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';

if( $moduleValues = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetModuleDetail',array('sys_module_id'=>$sys_module_id )) ){
  $sys_component_id = $moduleValues['sys_component_id'];
  $sys_module_id = $moduleValues['sys_module_id'];
  //  $mod_content_id = $moduleValues['mod_content_id'];
  //  $sys_parent_id = $moduleValues['sys_parent_id'];
  //  $sys_skin_id = isSet($sys_skin_id) && $sys_skin_id!=0 ? $sys_skin_id : $moduleValues['tree_skin_id'];
  $tableName = $moduleValues['tableName'];
  $moduleName = $moduleValues['moduleName'];
}

$treeItemsCount = $__APPLICATION_['database']->fetchrownamed('select count(*) from sys_tree where sys_module_id='.$sys_module_id.' and mod_content_id='.$mod_content_id);

// check for any modules using it (user)
$module = $__APPLICATION_['database']->fetcharray('select * from sys_module');
$count = 0;
foreach( $module as $key=>$value ){
  if( $moduleContent = $__APPLICATION_['database']->fetchrownamed('select count(*) from mod_'.$value['tableName'].' where assignedToUser='.$mod_content_id.'') ){
    $count = $count+$moduleContent['count(*)'];
  }
}

// check for any modules linked
$module = $__APPLICATION_['database']->fetcharray('select * from sys_module');
foreach( $module as $key=>$value ){
  if( $fieldContent = $__APPLICATION_['database']->fetchrownamed('select * from sys_'.$value['tableName'].'_fields where controlValues like "%moduleName='.$tableName.'&%"') ){
    // check if there are any references
    $modulesToDelete = $__APPLICATION_['database']->fetchrownamed('select count(*) from mod_'.$value['tableName'].' where '.$fieldContent['name'].'="'.$mod_content_id.'"');
    echo 'select count(*) from mod_'.$value['tableName'].' where '.$fieldContent['name'].'="'.$mod_content_id.'"<br>';
    $count += $modulesToDelete['count(*)'];
  }
}
// get the name
$contentName = '';
if( $moduleContent = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetModuleContent',array('tableName'=>$tableName,'mod_content_id'=>$mod_content_id )) ){
  $contentName = $moduleContent['name'];
}

switch( $cmd ){
  case 'yes':
    // $moduleToDelete = new module(array('in'=>array('sys_tree_id'=>$sys_tree_id,'currentPath'=>'')),'delete');
    // move to trash
    // get the name
 /*   $contentName = '';
    if( $moduleContent = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetModuleContent',array('tableName'=>$tableName,'mod_content_id'=>$mod_content_id )) ){
      $contentName = $moduleContent['name'];
    }*/

    // find all the places that it's used in the tree
    $treeItems = $__APPLICATION_['database']->fetcharray('select * from sys_tree where sys_module_id='.$sys_module_id.' and mod_content_id='.$mod_content_id);
    foreach( $treeItems as $key=>$value ){
      if( $moduleValuesTree = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetTreeDetail',array('sys_tree_id'=>$value['sys_tree_id'] )) ){
        $sys_component_id = $moduleValuesTree['sys_component_id'];
        $sys_module_id = $moduleValuesTree['sys_module_id'];
        $mod_content_id = $moduleValuesTree['mod_content_id'];
        $sys_parent_id = $moduleValuesTree['sys_parent_id'];
        $tableName = $moduleValuesTree['tableName'];
        $moduleName = $moduleValuesTree['moduleName'];
        $sys_tree_id = $moduleValuesTree['sys_tree_id'];
      }
      $__APPLICATION_['database']->__runquery_('update sys_tree set sys_trash=1, sys_published=0 where sys_tree_id='.$sys_tree_id);
      $__APPLICATION_['database']->__runquery_('insert into sys_trash(sys_trash_display_text,sys_trash_type,sys_trash_values) values ("'.$contentName.' ('.$moduleName.')('.$sys_tree_id.')","tree","sys_tree_id='.$sys_tree_id.'")');
    }
    
    // check for any modules using it as well
    $module = $__APPLICATION_['database']->fetcharray('select * from sys_module');
    foreach( $module as $key=>$value ){
      if( $moduleContent = $__APPLICATION_['database']->fetchrownamed('select * from mod_'.$value['tableName'].' where assignedToUser="'.$mod_content_id.'"') ){
        // set the content item as deleted
        $__APPLICATION_['database']->__runquery_('update mod_'.$value['tableName'].' set sys_trash=1 where mod_'.$value['tableName'].'_id='.$moduleContent['mod_'.$value['tableName'].'_id']);
        $__APPLICATION_['database']->__runquery_('insert into sys_trash(sys_trash_display_text,sys_trash_type,sys_trash_values) values ("'.$moduleContent['name'].' ('.$value['name'].')","module","tableName='.$value['tableName'].'&sys_module_id='.$value['sys_module_id'].'&mod_content_id='.$moduleContent['mod_'.$value['tableName'].'_id'].'")');  
      }
    }
    
    // check for any modules linked
    $module = $__APPLICATION_['database']->fetcharray('select * from sys_module');
    foreach( $module as $key=>$value ){
      if( $fieldContent = $__APPLICATION_['database']->fetchrownamed('select * from sys_'.$value['tableName'].'_fields where controlValues like "%moduleName='.$tableName.'&%"') ){
        // check if there are any references
        $modulesToDelete = $__APPLICATION_['database']->fetcharray('select * from mod_'.$value['tableName'].' where '.$fieldContent['name'].'="'.$mod_content_id.'"');
        foreach( $modulesToDelete as $key2=>$value2 ){
          // set the content item as deleted
          $__APPLICATION_['database']->__runquery_('update mod_'.$value['tableName'].' set sys_trash=1 where mod_'.$value['tableName'].'_id='.$value2['mod_'.$value['tableName'].'_id']);
          $__APPLICATION_['database']->__runquery_('insert into sys_trash(sys_trash_display_text,sys_trash_type,sys_trash_values) values ("'.$value2['name'].' ('.$value['name'].')","module","tableName='.$value['tableName'].'&sys_module_id='.$value['sys_module_id'].'&mod_content_id='.$value2['mod_'.$value['tableName'].'_id'].'")');  
        }  
      }
    }
    
    // set the content item as deleted
    $__APPLICATION_['database']->__runquery_('update mod_'.$tableName.' set sys_trash=1 where mod_'.$tableName.'_id='.$mod_content_id);
    $__APPLICATION_['database']->__runquery_('insert into sys_trash(sys_trash_display_text,sys_trash_type,sys_trash_values) values ("'.$contentName.' ('.$moduleName.')","module","tableName='.$tableName.'&sys_module_id='.$sys_module_id.'&mod_content_id='.$mod_content_id.'")');
    
    echo '<script language="javascript">  window.parent.location.reload(); </script>';die;
    break;
  case 'no':
    echo 'parent.$.fancybox.close(); </script>';die;
    break;
}


$__APPLICATION_['channel']->channelReplace('<var:sys_module_id>',$sys_module_id);
$__APPLICATION_['channel']->channelReplace('<var:mod_content_id>',$mod_content_id);
$__APPLICATION_['channel']->channelReplace('<var:numberOfItems>',($treeItemsCount['count(*)']+1+$count));
$__APPLICATION_['channel']->channelReplace('<var:contentName>',$contentName);
$__APPLICATION_['channel']->channelReplace('<var:moduleName>',$moduleName);
$__APPLICATION_['channel']->channelReplace('<var:tableName>',$tableName);
$__APPLICATION_['channel']->channelReplace('<var:sys_module_id>',$sys_module_id);
$__APPLICATION_['channel']->show();

?>
