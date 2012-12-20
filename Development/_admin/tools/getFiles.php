<?
require_once(".citadel.config.conf");

//system("mkdir ".$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/files/sql');
//echo "mysqldump root:S0uix!!@".$__CONFIG_['__paths_']['__dbDatabase_']." ".$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/files/sql/'.$__CONFIG_['__paths_']['__dbDatabase_'].'.sql';
//system("mysqldump root:S0uix!!@".$__CONFIG_['__paths_']['__dbDatabase_']." ".$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/files/sql/'.$__CONFIG_['__paths_']['__dbDatabase_'].'.sql');

$getOnly = isSet($_REQUEST['getOnly']) && $_REQUEST['getOnly']!='' ? $_REQUEST['getOnly'] : ''; 

system("tar -cf ".$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/files.tar '.$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/files'.($getOnly!='' ? '/'.$getOnly : '').' ');
system("gzip ".$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/files.tar');
system("cp ".$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/files.tar.gz '.$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/'.$__CONFIG_['__paths_']['__httpPath_'].'/files.tar.gz');

system("rm -rf ".$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/files.tar');
system("rm -rf ".$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/files.tar.gz');

header("Location: http://".$_SERVER['HTTP_HOST'].''.($__CONFIG_['__paths_']['__urlPath_']=='' ? '/' : $__CONFIG_['__paths_']['__urlPath_']).'files.tar.gz');

?>
