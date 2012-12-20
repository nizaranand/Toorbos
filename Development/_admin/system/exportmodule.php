<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'system','section'=>'exportmodule')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$sys_module_id = isSet($_REQUEST['sys_module_id']) && $_REQUEST['sys_module_id']!='' ? $_REQUEST['sys_module_id'] : '';

/* Descriptor for module:
   get module detail
   get field detail
   get component detail
   get allowed children
   get skins */

   $descriptorSkin = $__APPLICATION_['channel']->getSkin('exportmodule-base.tpl');
   // get module detail
   $module = new module(array('in'=>array('sys_module_id'=>$sys_module_id,'sys_field_type_id'=>'0')),'admin');
   $moduleName = $module->moduleValues['sys']['moduleName'];
   $tableName = $module->moduleValues['sys']['tableName'];
   $sys_component_id = $module->moduleValues['sys']['sys_component_id'];

   
   $componentDetail = $__APPLICATION_['database']->fetchrownamed('select * from sys_component where sys_component_id='.$sys_component_id);
   
   $parent_component_id = $componentDetail['parent_component_id'];
   $componentName = $componentDetail['name'];
   $componentPath = $componentDetail['path'];
//   $sys_control_id = $module->moduleValues['sys']['sys_component_id'];
   $sys_control_id = $module->moduleValues['sys']['sys_component_id'];
   $sys_skin_id = $module->moduleValues['sys']['module_skin_id'];
   $allowedChildren = $module->moduleValues['sys']['allowedChildren'];
   
   // get field detail
   foreach( $module->moduleValues['fields'] as $key=>$value ){
   	    $value['sys_control_id'] = $value['sys_control_id'] == 0 ? 1 : $value['sys_control_id'];
        /* get control detail */
    	if( !($controlDetail = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','CQGetControlDetail',array('sys_control_id'=>$value['sys_control_id'] )) ) ){
    		/* set debug message */
    		$__APPLICATION_['messages']->setDebugMessage( $this, array('query'=>$__APPLICATION_['database']->__getQueryByCode_('CQGetControlDetail',array('sys_control_id'=>$value['sys_control_id'] ) ), 'status'=>'failed') );
    	//	die;
    	}else{
    		$fieldValues = $__APPLICATION_['database']->fetchrownamed('desc mod_'.$tableName.' '.$value['name'] );
     	    $module->moduleValues['fields'][$key]['controlName'] = $controlDetail['name'];
     	    $module->moduleValues['fields'][$key]['controlPath'] = $controlDetail['path'];
     	    $module->moduleValues['fields'][$key]['fieldType'] = eregi_replace('\([0-9]*\)','',$fieldValues['Type']);
     	    $module->moduleValues['fields'][$key]['fieldLength'] = eregi_replace('[a-zA-z]*\(','',eregi_replace('\)','',$fieldValues['Type']));
     	    $module->moduleValues['fields'][$key]['controlValues'] = str_replace('&',',',$module->moduleValues['fields'][$key]['controlValues']);
    	}
   }
   
   $descriptorSkin->replaceLoop('fields',$module->moduleValues['fields']);
   
   // get parent component detail
   $componentDetail = $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','MQGetComponentDetail',array('sys_component_id'=>$parent_component_id) );
   
   // get associated skins
   $skins = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','SQGetAssociatedSkins',array('sys_module_id'=>$sys_module_id) );
   foreach( $skins as $key=>$value ){
   	  if( $value['sys_skin_id'] != $sys_skin_id ){
   	  	$skins[$key]['defaultSkin'] = 'no';
   	  }else{
   	  	$skins[$key]['defaultSkin'] = 'yes';
   	  }
   }
   $descriptorSkin->replaceLoop('skins',$skins);
   
   // get allowed children by name
   $allowedChildrenArray = explode(',',$allowedChildren);
   $children = array();
   foreach( $allowedChildrenArray as $key=>$value ){
   	   if( $value!='' ){
           $childDetail = $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','MQGetModuleDetail',array('sys_module_id'=>$value) );
           array_push($children,$childDetail);
   	   }
   }
   $descriptorSkin->replaceLoop('children',$children);
      
   // replace relevant values last
   $descriptorSkin->replace('<var:displayName>',$moduleName);
   $descriptorSkin->replace('<var:tableName>',$tableName);
   $descriptorSkin->replace('<var:componentDisplayName>',$componentName);
   $descriptorSkin->replace('<var:componentPath>',$componentPath);
   $descriptorSkin->replace('<var:componentParentName>',$componentDetail['componentName']);

   header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
   header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
   header ( "Pragma: no-cache" );
   header ( "Content-type: application/xml" );
   header ( "Content-Disposition: attachment; filename=Expert-".$tableName.'-Module-Descriptor.xml' );
   header ( "Content-Description: PHP Generated XML Descriptor" );
   print $descriptorSkin->output();
   die;   
?>
