<?
require_once(".citadel.config.conf");
$databases = $__APPLICATION_['database']->fetcharray('show databases');
$clients = array();
foreach( $databases as $key=>$value ){
	if( $value['Database']!='sultans-of-science'){
		system('mysqlcheck -u root -pThevertex01 '.$value['Database'].'  2>&1', $output);
		if( strstr($output,'crashed') ) mail('mare@rightbrain.co.za','table marked as rashed: '.$value['Database'],$output);
		system("mv ".$__CONFIG_['__paths_']['__installationPath_'].'/backups/'.$value['Database'].".backup ".$__CONFIG_['__paths_']['__installationPath_'].'/backups/'.$value['Database'].".backup.old");
		system("mysqldump  -R -q --single-transaction  --user='".$__CONFIG_['__db_']['__dbUsername_']."' --pass='".$__CONFIG_['__db_']['__dbPassword_']."' ".$value['Database']." > ".$__CONFIG_['__paths_']['__installationPath_'].'/backups/'.$value['Database'].".backup");
		sleep(2);
	}
}

system('rsync -r /export/Fiber /root/.');
?>
