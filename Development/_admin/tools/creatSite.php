<?
/* get the starting point for the user from session */
	require_once(".citadel.config.conf");
	$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'sites','section'=>'www','skin'=>'blankChannel.tpl')));
	$start_tree_id = 1;
	
	$deleteChildren = $__APPLICATION_['url']->getRequestVar('deleteChildren');

	$_SESSION['openTreeItems'][0]='all';

	/* do all application stuff here replace channel template values */	
	$module = new module(array('in'=>array('createPage'=>'1','sys_tree_id'=>$start_tree_id,'childDepth'=>0,'deleteChildren'=>$deleteChildren)),'tree');
	$_SESSION['openTreeItems'] = '';
	$_SESSION['openTreeItems'][0]='';
	
	header("Location:".$__CONFIG_['__paths_']['__urlPath_']."/_admin/tools/syncFiles.php?redirectToLogin=yes");
	
	unset($_SESSION['openTreeItems']);
?>