<?
require_once(".citadel.config.conf");
// do images
system("cp -rf ".$__CONFIG_['__paths_']['__installationPath_'].'/_admin/tools/.htaccess '.$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/'.$__CONFIG_['__paths_']['__httpPath_'].'/.');
?>
