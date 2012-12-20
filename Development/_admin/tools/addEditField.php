<? 
ob_start();
// get all vars
require_once (".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array ('in' => array ('path' => 'sites', 'section' => 'www', 'skin' => 'addEditField.tpl')));
$sys_control_id = isSet ($GLOBALS['_REQUEST']['sys_control_id']) && $GLOBALS['_REQUEST']['sys_control_id'] != '' ? $GLOBALS['_REQUEST']['sys_control_id'] : '';
$fieldName = isSet ($GLOBALS['_REQUEST']['fieldName']) && $GLOBALS['_REQUEST']['fieldName'] != '' ? $GLOBALS['_REQUEST']['fieldName'] : '';
$name = isSet($GLOBALS['_REQUEST']['name']) && $GLOBALS['_REQUEST']['name']!='' ? $GLOBALS['_REQUEST']['name'] : '';
$type = isSet($GLOBALS['_REQUEST']['type']) && $GLOBALS['_REQUEST']['type']!='' ? $GLOBALS['_REQUEST']['type'] : '';
$listField = isSet($GLOBALS['_REQUEST']['listField']) && $GLOBALS['_REQUEST']['listField']!='' ? $GLOBALS['_REQUEST']['listField'] : '';
$db = $__APPLICATION_['database'];

$types = array(array('type'=>'inputbox','typeDisplayName'=>'Input Box'),array('type'=>'textarea','typeDisplayName'=>'Textarea'));
$listFields = array(array('listField'=>'yes'),array('listField'=>'no'));

foreach( $types as $key=>$value ){
	$types[$key]['selected'] = $value['type']==$type ? ' selected' : '';
}

foreach( $listFields as $key=>$value ){
	$listFields[$key]['selected'] = $value['listField']==$listField ? ' selected' : '';
}

$__APPLICATION_['channel']->channelReplaceLoop('types', $types);
$__APPLICATION_['channel']->channelReplaceLoop('listFields', $listFields);
$__APPLICATION_['channel']->channelReplace('<var:fieldName>', $fieldName);
$__APPLICATION_['channel']->channelReplace('<var:sys_control_id>', $sys_control_id);
$__APPLICATION_['channel']->channelReplace('<var:name>', $name);

$__APPLICATION_['channel']->channelReplace('<var:title>', 'Add/Edit Field');
ob_end_clean();
$__APPLICATION_['channel']->show();
?>