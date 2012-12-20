<?
/* get the starting point for the user from session */
require_once (".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array ('in' => array ('path' => 'sites', 'section' => 'www', 'skin' => 'blankChannel.tpl')));
system('chmod -R 0777 '.$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/files');
system('chmod -R 0777 '.$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/files/skins');
system('chmod -R 0777 '.$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/skins');
?>