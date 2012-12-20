<?
require_once(".citadel.config.conf");

// get the clientpath to install
$clientName = isSet($_REQUEST['clientName']) ? $_REQUEST['clientName'] : '';

if( $clientName!='' ){
	// create a temporary folder under Expert install path called workspace
	system('rm -rf '.$__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client');
	$GLOBALS['__APPLICATION_']['database']->__runquery_('drop database '.$clientName);
//	system('rm -rf '.$__CONFIG_['__paths_']['__webServerDocumentRoot_'].'/'.$__CONFIG_['__paths_']['__domainPath_'].'/'.$clientName);
}

?>