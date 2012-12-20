<?
ob_start();
// get all vars
require_once(".citadel.config.conf");
$imageSrc = isSet($_REQUEST['imageSrc']) ? $_REQUEST['imageSrc'] : $imageSrc;
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'sites','section'=>'www','skin'=>'blankPage.tpl')));
$__APPLICATION_['channel']->channelReplace('<var:output>','<img src="<var:imagesPath>/'.$imageSrc.'">');
$__APPLICATION_['channel']->channelReplace('<var:title>','Image Popup');
ob_end_clean();
$__APPLICATION_['channel']->show();
?>
