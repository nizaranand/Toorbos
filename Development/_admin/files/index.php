<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'files','section'=>'filemanager')));
$paths = $__CONFIG_['__paths_'];
/* do permissions check */
//$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$dirPath = isSet($_GET['dirPath']) ? $_GET['dirPath'] : '';
$dirPath = isSet($_POST['dirPath']) ? $_POST['dirPath'] : $dirPath;
$refField = isSet($_REQUEST['refField']) ? $_REQUEST['refField'] : '';
$refFunction = isSet($_REQUEST['refFunction']) ? $_REQUEST['refFunction'] : '';
$fieldValue = isSet($_REQUEST['fieldValue']) ? $_REQUEST['fieldValue'] : '';
$filePath = isSet($_REQUEST['filePath']) ? $_REQUEST['filePath'] : '';
$restriction = isSet($_REQUEST['restriction']) ? $_REQUEST['restriction'] : '';
$newFolderName = isSet($_REQUEST['newFolderName']) ? $_REQUEST['newFolderName'] : '';
$showImages = isSet($_REQUEST['showImages']) ? $_REQUEST['showImages'] : '0';
$cmd = isSet($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';
$path = isSet($_REQUEST['path']) ? $_REQUEST['path'] : '';

/* set and get default dir for client logged in would be contentID 1 in db */
if( $client = $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','MQGetModuleContent',array('tableName'=>'client','mod_content_id'=>1)) ){
    $basePath = $__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$client['path'].'/files';
    if( isSet($restriction) && $restriction!='' ){
    	$basePath = $basePath.'/'.$restriction;
    	if( !is_dir($basePath) ){
    		mkdir($basePath);
    	}
    }
}else{
	//echo "couldn't find root!";
	//die;
}

if( isSet($cmd) && $cmd=='upload' ){
	
	$__APPLICATION_['utilities']->uploadFile($basePath.'/'.$dirPath.'/');
	// check for .tpl and create a skin
	
	if( strstr($_FILES['file']['name'],'.tpl') ){
		$names = explode('.',$_FILES['file']['name']);
		$vals = explode("-",$names[0]);
		
		//find module
		if( ($moduleDetails = $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','MQGetModuleDetailByTableName',array('tableName'=>$vals[0]))) ){
			//check skin
			if( !($skinDetails = $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','SQGetSkinDetailByName',array('name'=>$_FILES['file']['name']))) ){
				$__APPLICATION_['database']->__runQueryByCode_('__runquery_','SQAddSkin',array('name'=>$_FILES['file']['name'],'path'=>'','description'=>'Created by filemanager','linkedModules'=>','.$moduleDetails['sys_module_id']));
				$skinDetails = $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','SQGetSkinDetailByName',array('name'=>$_FILES['file']['name']));
			}
			if( isSet($vals[2]) && $vals[2]=='default' ){
				$__APPLICATION_['database']->__runQueryByCode_('__runquery_','MQUpdateModuleDetailField',array('fieldName'=>'sys_skin_id','fieldValue'=>$skinDetails['sys_skin_id'],'sys_module_id'=>$moduleDetails['sys_module_id']));
			}
		}
				
	}
	// set to site folder
	$imageLinkPathTo = $paths['__installationPath_'].'/clients'.'/'.$paths['__clientPath_'].'/'.$paths['__httpPath_'].(isSet($restriction) && $restriction!='' ? '/'.$restriction : '').'/'.$dirPath.'/'.$_FILES['file']['name'];
	@link($basePath.'/'.$dirPath.'/'.$_FILES['file']['name'],$imageLinkPathTo);
}elseif( isSet($cmd) && $cmd=='delete' ){
	@unlink($basePath.'/'.$dirPath.'/'.$filePath);
	@unlink($paths['__installationPath_'].'/clients'.'/'.$paths['__clientPath_'].'/'.$paths['__httpPath_'].(isSet($restriction) && $restriction!='' ? '/'.$restriction : '').'/'.$dirPath.'/'.$filePath);
}elseif( isSet($cmd) && $cmd=='addFolder' ){
	if( !is_dir($basePath.'/'.$dirPath.'/'.$newFolderName) ){
		@mkdir($basePath.'/'.$dirPath.'/'.$newFolderName);
		@mkdir($paths['__installationPath_'].'/clients'.'/'.$paths['__clientPath_'].'/'.$paths['__httpPath_'].(isSet($restriction) && $restriction!='' ? '/'.$restriction : '').'/'.$dirPath.'/'.$newFolderName);
	}
}elseif( isSet($cmd) && $cmd=='deleteFolder' ){
	$messages = $GLOBALS['__APPLICATION_']['utilities']->deleteFoldersRecursive($basePath.$path);
	$messages .= $GLOBALS['__APPLICATION_']['utilities']->deleteFoldersRecursive($paths['__installationPath_'].'/clients'.'/'.$paths['__clientPath_'].'/'.$paths['__httpPath_'].(isSet($restriction) && $restriction!='' ? '/'.$restriction : '').'/'.$path);
	if( $messages!='' ) echo $messages;
}


/* get dir contents */
$dir = $__APPLICATION_['utilities']->getDir($dirPath,$basePath,$restriction);

/* loop through and set commands an calc selectPath */
$newDirs = array();
foreach( $dir['dir'] as $key=>$value ){
	if( $value['name']!='CVS' ){
	/* get skin */
	$file = 'fileManager-directory.tpl';
	$skin = $__APPLICATION_['channel']->getSkin($file);	
	
	/* do skin */
	$skin->replace('<var:path>',$value['path']);
	$skin->replace('<var:name>',$value['name']);
	$skin->replace('<var:restriction>',$restriction);
	$skin->replace('<var:refField>',$refField);
	$skin->replace('<var:refFunction>',$refFunction);
	$skin->replace('<var:deleteCommand>',($value['name']!='../' ? '<a href="Javascript: if( confirm(\'Are you sure you want to delete the folder: '.$value['name'].'?\') ) document.location.href=\'<var:baseURL>_admin/files/?cmd=deleteFolder&dirPath='.$dirPath.'&path='.$value['path'].'&restriction='.$restriction.'&refField='.$refField.'&refFunction='.$refFunction.'\';" class="command-new">Delete</a>' : ''));
	
	/* set output */
	$newDirs[$key]['output'] = $skin->output();
	}
}
$dir['dir'] = $newDirs;
foreach( $dir['file'] as $key=>$value ){
	/* show image or not */
	if( isSet($showImages) && $showImages ){
		$value['imagePath'] = $basePath.'/'.$dirPath.'/'.$value['name'];
		$file = 'fileManager-displayImage.tpl';
	}else{
		$value['imagePath'] = '';
		$value['imagePath'] = $basePath.'/'.$dirPath.'/'.$value['name'];
	    $file = 'fileManager-file.tpl';
	}
	
	/* get skin */
	$skin = $__APPLICATION_['channel']->getSkin($file);
	
	/* do commands */
	$itemCommands = array();
	if( isSet($refField) && $refField!='' ){
	    array_push($itemCommands,array('output'=>$__APPLICATION_['channel']->getCommand('selectfile',array('refField'=>$refField,'restriction'=>$restriction))));
	}
    if( isSet($refFunction) && $refFunction!='' ){
	    array_push($itemCommands,array('output'=>$__APPLICATION_['channel']->getCommand('selectfile2',array('fieldValue'=>$fieldValue,'restriction'=>$restriction))));
	}
	array_push($itemCommands,array('output'=>$__APPLICATION_['channel']->getCommand('deletefile',array('refField'=>$refField,'restriction'=>$restriction,'filePath'=>$value['path']))));
	
	/* do skin */
	$prependPath = isSet($dirPath) && $dirPath!='' ? $dirPath.'/' : '';
	$skin->replaceLoop('commands',$itemCommands);
	$skin->replace('<var:path>',eregi_replace("^/","",$value['path']));
	$skin->replace('<var:imagePath>',$value['imagePath']);
	$skin->replace('<var:name>',$value['name']);
	$skin->replace('<var:number>',$key);	
		
	/* set output */
	$dir['file'][$key]['output'] = $skin->output();
}

/* do all application stuff here replace channel template values */
$__APPLICATION_['channel']->replaceLoop('directories',$dir['dir']);
$__APPLICATION_['channel']->replaceLoop('files',$dir['file']);
$__APPLICATION_['channel']->replace('<var:dirPath>',$dirPath);
$__APPLICATION_['channel']->replace('<var:sessionID>',session_id());
$__APPLICATION_['channel']->replace('<var:clientURL>',$__CONFIG_['__paths_']['__fiberClientPath_']);
$__APPLICATION_['channel']->replace('<var:restriction>',$restriction);
$__APPLICATION_['channel']->replace('<var:showImages>',(isSet($showImages) && $showImages ? 'checked' : ''));
$__APPLICATION_['channel']->replace('<var:showImagesValue>',(isSet($showImages) && $showImages ? '0' : '1'));
$__APPLICATION_['channel']->replace('<var:refField>',$refField);
$__APPLICATION_['channel']->replace('<var:refFunction>',$refFunction);
$__APPLICATION_['channel']->replace('<var:fieldValue>',$fieldValue);

/* show channel */
$__APPLICATION_['channel']->show();
?>