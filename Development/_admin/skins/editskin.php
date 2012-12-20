<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'skins','section'=>'editskin')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

$paths = $__CONFIG_['__paths_'];
$utilities = $__APPLICATION_['utilities'];

/* resolve vars */
$sys_skin_id = isSet($_REQUEST['sys_skin_id']) && $_REQUEST['sys_skin_id']!='' ? $_REQUEST['sys_skin_id'] : '';
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : 'new';
$skinName = isSet($_REQUEST['skinName']) && $_REQUEST['skinName']!='' ? $_REQUEST['skinName'] : '';
$skinPath = isSet($_REQUEST['skinPath']) && $_REQUEST['skinPath']!='' ? $_REQUEST['skinPath'] : '';
$skinDescription = isSet($_REQUEST['skinDescription']) && $_REQUEST['skinDescription']!='' ? $_REQUEST['skinDescription'] : '';
$linkedModules = isSet($_REQUEST['linkedModules']) && $_REQUEST['linkedModules']!='' ? $_REQUEST['linkedModules'] : '';
$skinContents = isSet($_REQUEST['skinContents']) && $_REQUEST['skinContents']!='' ? $_REQUEST['skinContents'] : '';
$skinFileUpload = isSet($_REQUEST['skinFileUpload']) && $_REQUEST['skinFileUpload']!='' ? $_REQUEST['skinFileUpload'] : '';

// get all linked module fields
$moduleFields = $utilities->getModuleFields($linkedModules);

$skinFile = $paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/skins'.$skinPath.'/'.$skinName;

/* do cmd bit */
switch( $cmd ){
	case "update":
	    if( isSet($skinName) && $skinName!='' ){
            $__APPLICATION_['database']->__runQueryByCode_('__runquery_','SQUpdateSkin',array('sys_skin_id'=>$sys_skin_id,'name'=>$skinName,'path'=>$skinPath,'description'=>$skinDescription,'linkedModules'=>$linkedModules,'sys_skin_id'=>$sys_skin_id));
            if( isSet($skinContents) && $skinFileUpload=='' ){
              $skin = new template();
              $skin->set($skinContents);
              foreach( $moduleFields as $key=>$value ){
              	if( $value['type'] == 'var' ){
              		$skin->replace('<INPUT style="BORDER-LEFT-COLOR: red; BORDER-BOTTOM-COLOR: red; BORDER-TOP-COLOR: red; BACKGROUND-COLOR: white; BORDER-RIGHT-COLOR: red" disabled type=button value='.$value['name'].' name='.$value['name'].'>','<var:'.$value['name'].'>');
              	}
              }
              $skinContents = $skin->output();
              $__APPLICATION_['utilities']->writeFile($skinFile,$skinContents);
            }
            if( isSet($skinFileUpload) && $skinFileUpload!='' ){
            	copy($paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/files/skins/'.$skinFileUpload,$paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/skins/'.$skinName);
            	$skinFileUpload = '';
            }
	    }
	break;
	case "new":
	    if( isSet($skinName) && $skinName!='' ){
            $__APPLICATION_['database']->__runQueryByCode_('__runquery_','SQAddSkin',array('sys_skin_id'=>$sys_skin_id,'name'=>$skinName,'path'=>$skinPath,'description'=>$skinDescription,'linkedModules'=>$linkedModules));
            $sys_skin_id = $__APPLICATION_['database']->__lastID_();
            // copy the whole directory...
	    system('cp -rf '.$paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/files/skins/* '.$paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/skins/.');
            if( isSet($skinFileUpload) && $skinFileUpload!='' ){
            	copy($paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/files/skins/'.$skinFileUpload,$paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/skins/'.$skinName);
            	$skinFileUpload = '';
            }
	    }
	break;
}

/* get skin detail */
if( ($skin = $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','SQGetSkinDetail',array('sys_skin_id'=>$sys_skin_id) ) ) ){
	  /* set cmd to update */
	  $cmd = 'update';
    /* set values */
    $skinName = $skin['name'];
    $skinPath = $skin['path'];
    // skin full path
    $skinDescription = $skin['description'];
    $linkedModules = $skin['linkedModules'];
    // get all linked module fields
    $moduleFields = $utilities->getModuleFields($linkedModules);
    $skinFile = $paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/skins'.$skinPath.'/'.$skinName;
}

// replace all skinContent tags with image placeholders //
$skinContents = $__APPLICATION_['utilities']->getFile($skinFile);
$skin = new template();
$skin->set($skinContents);
$fields = array();
$modules = array();
foreach( $moduleFields as $key=>$value ){
  if( $value['type'] == 'var' ){
      $skin->replace('<var:'.$value['name'].'>','<INPUT style="BORDER-LEFT-COLOR: red; BORDER-BOTTOM-COLOR: red; BORDER-TOP-COLOR: red; BACKGROUND-COLOR: white; BORDER-RIGHT-COLOR: red" disabled type=button value='.$value['name'].' name='.$value['name'].'>');
      array_push($fields,$value);
  }
/*  else{
  	  $skin->replace('<module:'.$value['name'].':[A-zZ-a 0-9]*:[0-1]>','<INPUT style="BORDER-LEFT-COLOR: red; BORDER-BOTTOM-COLOR: red; BORDER-TOP-COLOR: red; BACKGROUND-COLOR: white; BORDER-RIGHT-COLOR: red" disabled type=button value='.$value['name'].' name='.$value['name'].'>');
  	  array_push($modules,$value);
  }*/
}
$skinContents = $skin->output();

/* do controls */
$skinName = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$skinName,'fieldName'=>'skinName','displayName'=>'Skin Name')),'admin');
$skinName = $skinName->output();

$skinPath = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$skinPath,'fieldName'=>'skinPath','displayName'=>'Path')),'admin');
$skinPath = $skinPath->output();
$skinDescription = new control(array('in'=>array('sys_control_id'=>5,'fieldValue'=>$skinDescription,'fieldName'=>'skinDescription','displayName'=>'Description')),'admin');
$skinDescription = $skinDescription->output();
$skinFileUpload = new control(array('in'=>array('sys_control_id'=>2,'fieldValue'=>$skinFileUpload,'fieldName'=>'skinFileUpload','displayName'=>'Skin File','controlValues'=>'restriction=skins')),'admin');
$skinFileUpload = $skinFileUpload->output();
//$skinContents = new control(array('in'=>array('sys_control_id'=>5,'fieldValue'=>$skinContents,'fieldName'=>'skinContents','displayName'=>'Contents','moduleFields'=>$fields,'modules'=>$modules)),'admin');
//$skinContents = $skinContents->output();
$skinContents = '<input type="hidden" name="skinContents" value="">';
$linkedModules = new control(array('in'=>array('sys_control_id'=>4,'system_table'=>'sys_module','fieldValue'=>$linkedModules,'fieldName'=>'linkedModules','displayName'=>'Linked Content')),'admin');
$linkedModules = $linkedModules->output();

/* replace values */
$__APPLICATION_['channel']->replace('<var:cmd>',$cmd);
$__APPLICATION_['channel']->replace('<var:sys_skin_id>',$sys_skin_id);
$__APPLICATION_['channel']->replace('<var:name>',$skinName);
$__APPLICATION_['channel']->replace('<var:path>',$skinPath);
$__APPLICATION_['channel']->replace('<var:skinFileUpload>',$skinFileUpload);
$__APPLICATION_['channel']->replace('<var:skinContents>',$skinContents);
$__APPLICATION_['channel']->replace('<var:description>',$skinDescription);
$__APPLICATION_['channel']->replace('<var:linkedModules>',$linkedModules);

/* show channel */
$__APPLICATION_['channel']->show();
?>
