<?
require_once(".citadel.config.conf");
/* resolve get var imagePath */
$imagePath = isSet($_REQUEST['imagePath']) ? $_REQUEST['imagePath'] : '';
$binary_junk = $__APPLICATION_['utilities']->bs_file($imagePath);
$type = explode('.',$imagePath);
$type = $type[1];
header("Content-type: ".$__APPLICATION_['utilities']->getMimeType($type));
echo $binary_junk;
?>