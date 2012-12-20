<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'sites','section'=>'main')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$sys_tree_id = isSet($_REQUEST['sys_tree_id']) ? $_REQUEST['sys_tree_id'] : 0;
$currentPath = isSet($_REQUEST['currentPath']) ? $_REQUEST['currentPath'] : 0;
$cmd = isSet($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';
$mode = isSet($_SESSION['mode']) ? $_SESSION['mode'] : 'basic';
$mode = isSet($_REQUEST['mode']) ? $_REQUEST['mode'] : $mode;
// register mode
$_SESSION['mode'] = $mode;

switch($cmd){
	case "delete":
    	$moduleToDelete = new module(array('in'=>array('sys_tree_id'=>$sys_tree_id,'currentPath'=>$currentPath)),'delete');
	break;
}

/* get the starting point for the user from session */
$start_tree_id = $mode=='basic' ? 13 : $__APPLICATION_['session']->user->userDetail['sys']['start_tree_id'];
$restriction = $mode=='basic' ? 'and sys_module_id=7 ' : '';


/* do all application stuff here replace channel template values */
$module = new module(array('in'=>array('sys_tree_id'=>$start_tree_id,'sys_skin_id'=>3,'childDepth'=>0,'restriction'=>$restriction)),'tree');
$__APPLICATION_['channel']->replace('<var:tree>',$module->output());

/* show channel */
$__APPLICATION_['channel']->show();
?>
