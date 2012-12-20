<?
require_once(".citadel.config.conf");
	/* resolve get var imagePath */
	$filePath = isSet($_SESSION['filePath']) ? $_SESSION['filePath'] : '';
	$filePath = isSet($_REQUEST['filePath']) ? $_REQUEST['filePath'] : $filePath;
	$binary_junk = $__APPLICATION_['utilities']->bs_file($filePath);
	$type = explode('.',$filePath);
	$type = $type[1];
	header("Content-type: ".$__APPLICATION_['utilities']->getMimeType($type));
	echo $binary_junk;
?>