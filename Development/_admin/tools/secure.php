<?
require_once(".citadel.config.conf");
$databases = $__APPLICATION_['database']->fetcharray('show databases');
$clients = array();
foreach( $databases as $key=>$value ){
$__APPLICATION_['database']->__selectDB_($value['Database']);		
$__APPLICATION_['database']->__runquery_('update '.$value['Database'].'.mod_applicationUser set password="R1ghtbr@1n!!" where password="siteadmin01"');
	echo 'update '.$value['Database'].'.mod_applicationUser set password="R1ghtbr@1n!!" where password="siteadmin01"';	
		system('cp -rf /export/Fiber/workspace/default/client/files/includes/editPage.php /export/Fiber/clients/'.$value['Database'].'Client/files/includes/.');
		sleep(2);
}


?>
