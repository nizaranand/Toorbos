<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'system','section'=>'importmodule')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

include_once($__CONFIG_['__paths_']['__libPath_'].'/xmlProcessor.php');
include_once($__CONFIG_['__paths_']['__libPath_'].'/moduleDescriptorProcessor.php');

/* resolve vars */
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';

/* handle commands */
switch( $cmd ){
	case 'import':
	    $file = $GLOBALS['_FILES']['moduleDescriptor']['tmp_name'];
        $moduleDescriptorProcessor = new moduleDescriptorProcessor();
        $moduleDescriptorProcessor->parse($file);
        $moduleDescriptorProcessor = $GLOBALS['parser'];
        $report = "";
        // start by checking if module exists exists...
        if( !($moduleDetail = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetModuleDetailByTableName',array('tableName'=>$moduleDescriptorProcessor->moduleDetail['tableName'] ))) ){
          // get component detail to link to.
          if( !($componentDetail = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetComponentDetailByName',array('componentName'=>$moduleDescriptorProcessor->componentDetail[0]['NAME'] ))) ){
          	$parentComponentDetail = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetComponentDetailByName',array('componentName'=>$moduleDescriptorProcessor->componentDetail[0]['parentComponent'] ));
          	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','MQAddComponent',array('name'=>$moduleDescriptorProcessor->componentDetail[0]['NAME'],'path'=>$moduleDescriptorProcessor->componentDetail[0]['PATH'],'parent_component_id'=>$parentComponentDetail['sys_component_id']));
          	$componentDetail = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetComponentDetailByName',array('componentName'=>$moduleDescriptorProcessor->componentDetail[0]['NAME'] ));
          	$report .= "<p><b>Component didn't exist and a new one was created: ".$moduleDescriptorProcessor->componentDetail[0]['NAME'].".</b></p>";
          }

          $__APPLICATION_['database']->__runQueryByCode_('__runquery_','MQAddModule',array('tableName'=>$moduleDescriptorProcessor->moduleDetail['tableName'],'moduleName'=>$moduleDescriptorProcessor->moduleDetail['name'],'sys_component_id'=>$componentDetail['sys_component_id'],'sys_skin_id'=>0,'allowedChildren'=>''));
          $sys_module_id = $__APPLICATION_['database']->__lastID_();
          $__APPLICATION_['database']->__runQueryByCode_('__runquery_','MQCreateModuleTable',array('tableName'=>$moduleDescriptorProcessor->moduleDetail['tableName']));
          $__APPLICATION_['database']->__runQueryByCode_('__runquery_','MQCreateModuleFieldsTable',array('tableName'=>$moduleDescriptorProcessor->moduleDetail['tableName']));
          $__APPLICATION_['database']->__runQueryByCode_('__runquery_','FQAddField',array('tableName'=>$moduleDescriptorProcessor->moduleDetail['tableName'],'fieldName'=>'name','displayName'=>'Name','sys_control_id'=>1,'controlValues'=>'','sys_field_type_id'=>1));
          $moduleDetail = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetModuleDetailByTableName',array('tableName'=>$moduleDescriptorProcessor->moduleDetail['tableName'] ));
          $report .= "<p><b>Module didn't exist and a new one was created: ".$moduleDescriptorProcessor->moduleDetail['name'].".</b></p>";

          // create all skins if not exist and get default skin
          foreach( $moduleDescriptorProcessor->skins as $key=>$value ){
          	if( !($skinDetail = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','SQGetSkinDetailByName',array('name'=>$value['NAME'] ))) ){
          		$__APPLICATION_['database']->__runQueryByCode_('__runquery_','MQAddSkin',array('name'=>$value['NAME'],'path'=>$value['PATH'],'desription'=>$value['description'],'linkedModules'=>$value['linkedModules'].','.$moduleDetail['sys_module_id']));
          		$skinDetail = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','SQGetSkinDetailByName',array('name'=>$value['NAME'] ));
          		$report .= "<p><b>Skin didn't exist and a new one was created: ".$value['NAME'].".</b></p>";
          	}
          	if( $value['DEFAULTSKIN'] == 'yes' ){
          		$__APPLICATION_['database']->__runQueryByCode_('__runquery_','MQUpdateModuleDetail',array('tableName'=>$moduleDescriptorProcessor->moduleDetail['tableName'],'moduleName'=>$moduleDescriptorProcessor->moduleDetail['name'],'sys_component_id'=>$componentDetail['sys_component_id'],'sys_skin_id'=>$skinDetail['sys_skin_id'],'allowedChildren'=>'','sys_module_id'=>$moduleDetail['sys_module_id']));
          		$moduleDetail = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetModuleDetailByTableName',array('tableName'=>$moduleDescriptorProcessor->moduleDetail['tableName'] ));
          	}elseif( !strstr($skinDetail['linkedModules']) ){
          		// update skin detail to have this module linked
          		$__APPLICATION_['database']->__runQueryByCode_('__runquery_','SQUpdateSkin',array('name'=>$value['NAME'],'path'=>$value['PATH'],'desription'=>$value['description'],'linkedModules'=>$value['linkedModules'].','.$moduleDetail['sys_module_id'],'sys_skin_id'=>$skinDetail['sys_skin_id']));
          	}
          }

          // do allowed children
          $allowedChildren = '';
          foreach( $moduleDescriptorProcessor->allowedChildren as $key=>$value ){
          	// get module id if not exists ignore
          	if( ($moduleDetailNew = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetModuleDetailByTableName',array('tableName'=>$value['TABLENAME'] )))){
          		$allowedChildren .= ','.$moduleDetailNew['sys_module_id'];
          	}
          }
          if( $linkedModules!='' ){
          	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','MQUpdateModuleDetail',array('tableName'=>$moduleDescriptorProcessor->moduleDetail['tableName'],'moduleName'=>$moduleDescriptorProcessor->moduleDetail['name'],'sys_component_id'=>$componentDetail['sys_component_id'],'sys_skin_id'=>$skinDetail['sys_skin_id'],'allowedChildren'=>$allowedChildren,'sys_module_id'=>$moduleDetail['sys_module_id']));
          	$moduleDetail = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetModuleDetailByTableName',array('tableName'=>$moduleDescriptorProcessor->moduleDetail['tableName'] ));
          }

        }else{
          $report .= "<p><b>Module existed and field comparison initalised.</b></p>";
        }
        // do fields
        foreach( $moduleDescriptorProcessor->fields as $key=>$value ){
        	// get control detail
        	if( !( $controlDetail = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','CQGetControlDetailByName',array('name'=>$value['controlName'] ))) ){
        		// add control
        		$__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQAddControl',array('name'=>$value['controlName'],'path'=>$value['controlPath']));
        		$controlDetail = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','CQGetControlDetailByName',array('name'=>$value['controlName']));
        	}
        	// check field exists
        	if( !( $fieldDetail = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','FQCheckField',array('tableName'=>$moduleDescriptorProcessor->moduleDetail['tableName'],'fieldName'=>$value['NAME'] )) ) ){
        		$__APPLICATION_['database']->__runQueryByCode_('__runquery_','FQAddField',array('fieldName'=>$value['NAME'],'displayName'=>$value['DISPLAYNAME'],'sys_control_id'=>$controlDetail['sys_control_id'],'controlValues'=>str_replace(',','&',$value['controlValues']),'tableName'=>$moduleDescriptorProcessor->moduleDetail['tableName'],'defaultValue'=>$value['defaultContent'],'sys_field_type_id'=>1));
        		// set type and maxlength
        		$value['MAXLENGTH'] = $value['TYPE']=='text' || $value['TYPE']=='date' || $value['TYPE']=='datetime' ? '' : '('.$value['MAXLENGTH'].')';
        		$__APPLICATION_['database']->__runQueryByCode_('__runquery_','FQAddFieldToTable',array('fieldName'=>$value['NAME'],'tableName'=>$moduleDescriptorProcessor->moduleDetail['tableName'],'fieldType'=>$value['TYPE'],'fieldSize'=>$value['MAXLENGTH'],'defaultValue'=>$value['defaultContent'],'sys_field_type_id'=>1));
        		$fieldDetail = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','FQCheckField',array('tableName'=>$moduleDescriptorProcessor->moduleDetail['tableName'],'fieldName'=>$value['NAME'] ));
        		$report .= "<p><b>Field didn't exist and new one created: ".$value['NAME'].".</b></p>";
        	}else{
        		// alter table to make sure type and length mathces
        		$__APPLICATION_['database']->__runQueryByCode_('__runquery_','FQUpdateField',array('fieldName'=>$value['NAME'],'displayName'=>$value['DISPLAYNAME'],'sys_control_id'=>$controlDetail['sys_control_id'],'controlValues'=>str_replace(',','&',$value['controlValues']),'tableName'=>$moduleDescriptorProcessor->moduleDetail['tableName'],'defaultValue'=>$value['defaultContent'],'sys_field_id'=>$fieldDetail['sys_field_id']));
        		// set type and maxlength
        		$value['MAXLENGTH'] = $value['TYPE']=='text' || $value['TYPE']=='date' || $value['TYPE']=='datetime' ? '' : '('.$value['MAXLENGTH'].')';
        		$__APPLICATION_['database']->__runQueryByCode_('__runquery_','FQAlterFieldName',array('oldName'=>$value['NAME'],'newName'=>$value['NAME'],'tableName'=>$moduleDescriptorProcessor->moduleDetail['tableName'],'fieldType'=>$value['TYPE'],'fieldSize'=>$value['MAXLENGTH']));
        		$report .= "<p><b>Field existed and altered to: ".$value['NAME']." ".$value['TYPE'].$value['MAXLENGTH'].".</b></p>";
        	}
        }
        $module = new module(array('in'=>array('sys_module_id'=>$sys_module_id)),'admin');
	break;
}

/* get commands */
$commands = array();
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('channels',array())));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('modules',array())));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('components',array())));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('controls',array())));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('config',array())));

/* replace values */
$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);
$__APPLICATION_['channel']->replace('report',$report);

/* show channel */
$__APPLICATION_['channel']->show();
?>
