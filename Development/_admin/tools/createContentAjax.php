<?
ob_start();
// get all vars
require_once(".citadel.config.conf");
require_once("JSON.php");

$paths = $__CONFIG_['__paths_'];

$editMode = isSet( $_REQUEST['editMode'] ) ? $_REQUEST['editMode'] : 0;
$createMode = isSet( $_REQUEST['createMode'] ) ? $_REQUEST['createMode'] : 0;
$__APPLICATION_['channel'] = new channel( array('in' => array('path' => 'sites', 'section' => 'www', 'skin' => 'blankChannel.tpl' ) ) );

// check for a custom session object
if( is_file($paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/files/includes/siteSession.php') ){
	include_once($paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/files/includes/siteSession.php');
}else{
	include_once($paths['__libPath_'].'/siteSession.php');
}

//check for email usage
$useEmail = true;
$GLOBALS['siteSession'] = new siteSession($GLOBALS['__APPLICATION_']['uniqueID'],'mod_applicationUser',$useEmail);

$moduleName = isSet($_REQUEST['moduleName']) ? $_REQUEST['moduleName'] : '';
$st = isSet($_REQUEST['st']) ? $_REQUEST['st'] : '';
$et = isSet($_REQUEST['et']) ? $_REQUEST['et'] : '';
$rb = isSet($_REQUEST['rb']) ? $_REQUEST['rb'] : '';

$json = new Services_JSON();

$moduleFields = moduleUtilities::getFields($moduleName);

$fields = array();

foreach( $moduleFields as $key=>$value ){
	if( isSet($_REQUEST[$value['name']]) && $_REQUEST[$value['name']]!='' ){
		array_push($fields,array('name'=>$value['name'],'value'=>$_REQUEST[$value['name']]));
	}
}


$contentId = content::create($moduleName,$fields,($st=='1' ? true : false),($et=='1' ? true : false));

if( $rb=='1' )
	$GLOBALS['__APPLICATION_']['database']->rollback();

echo $json->encode(array('name'=>$_REQUEST['name'],'id'=>$contentId,'module'=>$moduleName));
?>
