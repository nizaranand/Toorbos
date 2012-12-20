<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'sites','section'=>'export')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();
/* function to get children */
function getChildren($sys_tree_id,$allowedModuleIDs){
	$condition = '';
	foreach( $allowedModuleIDs as $key=>$id ){
		if( $id!='' ){
		    $condition .= ($condition=='' ? 'and ' : 'or ').'sys_tree.sys_module_id='.$id.' ';
		}
	}
	$children = $GLOBALS['__APPLICATION_']['database']->__runQueryByCode_( 'fetcharray','MQGetChildrenOrderByModule',array('sys_tree_id'=>$sys_tree_id,'condition'=>$condition ));
	$newchildren = array();
	foreach( $children as $key=>$child ){
		$newchildren = getChildren($child['sys_tree_id'],$allowedModuleIDs);
	}
    $children = array_merge($newchildren,$children);
	return $children;
}

/* resolve vars */
$sys_tree_id = isSet($_REQUEST['sys_tree_id']) ? $_REQUEST['sys_tree_id'] : 0;
$sys_module_id = isSet($_REQUEST['sys_module_id']) ? $_REQUEST['sys_module_id'] : 0;
$modulesToExport = isSet($_REQUEST['modulesToExport']) ? $_REQUEST['modulesToExport'] : 0;
$actualModules = isSet($_REQUEST['actualModules']) ? $_REQUEST['actualModules'] : array();
$cmd = isSet($_REQUEST['cmd']) ? $_REQUEST['cmd'] : 'new';

/* do cmd bit */
switch( $cmd ){
	case "new":
	break;
	case "update":
	break;
}

/* do commands bit */
$commands = array();
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('editmodule',array('sys_tree_id'=>$sys_tree_id))));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('previewmodule',array('sys_tree_id'=>$sys_tree_id))));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('export',array('sys_tree_id'=>$sys_tree_id))));

if( $sys_module_id!=0 && $cmd=='exportcsv' ){
	$children = getChildren($sys_tree_id,array($sys_module_id));
	if( count($children)>0 ){
		$doneHeaders = 0;
		foreach($children as $key=>$child){
			$module = new module(array('in'=>array('sys_tree_id'=>$child['sys_tree_id'])),'admin');
			if( !$doneHeaders ){
				$columns = 0;
				$xls = '<tr>';
				foreach( $module->moduleValues['fields'] as $key=>$field ){
					$xls .= '<td bgcolor="#CCCCCC"><b>'.$field['displayName'].'</b></td>';
					$columns++;
				}
    			$xls .= '</tr>';
				$doneHeaders=1;
     		    $xls = '<table><tr><td colspan="'.$columns.'" bgcolor="#CC3300"><font size="3" color="white"><b>Expert (Child) Report</b></td></tr>'.$xls;
			    $xls .= '<tr>';
			}
			foreach( $module->moduleValues['fields'] as $key=>$field ){
				$xls .= '<td>'.$module->moduleValues['content'][$field['name']].'</td>';
			}
  			$xls .= '</tr>';
		}
	}else{
		$xls = '<table><tr><td bgcolor="#CC3300"><font size="3" color="white"><b>Expert (Child) Report</b></td></tr></table>';
	}
	header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
	header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
	header ( "Pragma: no-cache" );
	header ( "Content-type: application/x-msexcel" );
	header ( "Content-Disposition: attachment; filename=Expert-Export-Children.xls" );
	header ( "Content-Description: PHP Generated XLS Data" );
	print $xls.'</table>';
	die;
}

/* retrieve all modules in a list for selecting export modules */
if( $cmd=='new' ){
	/* initiate parent module to get allowed chidlren */
	$sys_parent_id = $sys_tree_id;
	$parentmodule = new module(array('in'=>array('sys_tree_id'=>$sys_parent_id)),'admin');
	$allowedChildren = split(',',$parentmodule->moduleValues['sys']['allowedChildren']);
	$disallowedModules = split(',',$__APPLICATION_['session']->user->userDetail['group']['linkedModules']);
	
	/* get all modules */
	$actualModules = array();
	if( ($modules = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','MQGetAllModules',array() ) ) ){
		foreach( $modules as $key=>$value ){
			/* check if allowed */
			if( array_search($value['sys_module_id'],$allowedChildren) && !array_search($value['sys_module_id'],$disallowedModules)){
				/* do delete and edit commands */
				$moduleSkin = $__APPLICATION_['channel']->getSkin('listmodules-module.tpl');
				$moduleCommands = array();
				array_push($moduleCommands,array('output'=>$__APPLICATION_['channel']->getCommand('exportmodule',array('sys_tree_id'=>$sys_tree_id,'sys_module_id'=>$value['sys_module_id']))));
				$moduleSkin->replaceLoop('commands',$moduleCommands);
				$moduleSkin->replace('<var:name>',$value['name']);
				/* check for image else use default */
				if( !is_file($__CONFIG_['__paths_']['__installationPath_'].'/'.$__CONFIG_['__paths_']['__adminDirectory_'].'/images/tree/icons/icn-'.$value['tableName'].'.gif')){
					$value['tableName'] = 'default';
				}
				$moduleSkin->replace('<var:tableName>',$value['tableName']);
				$actualModules[$key] = array();
				$actualModules[$key]['output'] = $moduleSkin->output();
			}
		}
	}
    $cmd = 'exportcsv';
}

/* replace values */
$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);
$__APPLICATION_['channel']->replace('<var:modulesToExport>',$modulesToExport);
$__APPLICATION_['channel']->replaceLoop('modules',$actualModules);

/* replace values */
$__APPLICATION_['channel']->replace('<var:cmd>',$cmd);
$__APPLICATION_['channel']->replace('<var:sys_tree_id>',$sys_tree_id);

/* show channel */
$__APPLICATION_['channel']->show();
?>