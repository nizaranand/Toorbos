<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'skins','section'=>'listskins')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';
$sys_module_id = isSet($_SESSION['sys_module_id']) && $_SESSION['sys_module_id']!='' ? $_SESSION['sys_module_id'] : '';
if( isSet($_REQUEST['sys_module_id']) ){
  $sys_module_id = isSet($_REQUEST['sys_module_id']) && $_REQUEST['sys_module_id']!='' ? $_REQUEST['sys_module_id'] : '';
}
$_SESSION['sys_module_id'] = $sys_module_id;

$listCommands = array();
array_push($listCommands,array('output'=>$__APPLICATION_['channel']->getCommand('newskin',array())));

/* get all skins */
if( ($skins = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','SQGetAssociatedSkins',array('sys_module_id'=>$sys_module_id) ) ) ){
	foreach( $skins as $key=>$value ){
		/* do delete and edit commands */
		$skinsSkin = $__APPLICATION_['channel']->getSkin('main-skin.tpl');
		$skinCommands = array();
		array_push($skinCommands,array('output'=>$__APPLICATION_['channel']->getCommand('editskin',array('sys_skin_id'=>$value['sys_skin_id']))));
		array_push($skinCommands,array('output'=>$__APPLICATION_['channel']->getCommand('deleteskin',array('sys_skin_id'=>$value['sys_skin_id']))));
		$skinsSkin->replaceLoop('commands',$skinCommands);
		$skinsSkin->replace('<var:name>',$value['name']);
		$skinsSkin->replace('<var:description>',$value['description']);
		/* check for image else use default */
		$iconName = 'skin';
		if( !is_file($__CONFIG_['__paths_']['__installationPath_'].'/'.$__CONFIG_['__paths_']['__adminDirectory_'].'/images/tree/icons/icn-skin.gif') ){
			$iconName = 'default';
		}
		$skinsSkin->replace('<var:iconName>',$iconName);
		$skins[$key]['output'] = $skinsSkin->output();
	}
}

/* replace values */
$__APPLICATION_['channel']->replaceLoop('commands',$listCommands);
$__APPLICATION_['channel']->replaceLoop('skins',$skins);

/* show channel */
$__APPLICATION_['channel']->show();
?>
