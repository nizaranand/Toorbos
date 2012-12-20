<?php 

require_once ('.citadel.config.conf');

require_once ($__CONFIG_['__paths_']['__installationPath_'].'/lib/databases/syncDatabase.php');

$server = $__APPLICATION_['url']->getRequestVar('server');
$fromclient = $__APPLICATION_['url']->getRequestVar('fromclient');
$toclient = $__APPLICATION_['url']->getRequestVar('toclient');
$cmd = $__APPLICATION_['url']->getRequestVar('cmd');
$default = $__APPLICATION_['url']->getRequestVar('default');


if( $server!='' && $fromclient!='' && $toclient!='' ){

	$remoteDatabase = new database( $__CONFIG_['__server_'][$server]['__dbUsername_'], $__CONFIG_['__server_'][$server]['__dbPassword_'], $toclient, $__CONFIG_['__server_'][$server]['__dbHost_'], $__CONFIG_['__server_'][$server]['__dbPort_'], 'mysql' );
	$remoteDatabase->__selectDB_($toclient);
	$localDatabase = $__APPLICATION_['database'];
	$localDatabase->__selectDB_($fromclient);
	
	// check the connections
	if( !$remoteDatabase->isActive() && !$localDatabase()->isActive() ){
		die("No databases are connected");
	}else if( !$remoteDatabase->isActive() ){
		die("Remote database not connected");
	}else if( !$localDatabase->isActive() ){
		die("Local database not connected");
	}
	
	switch( $cmd ){
		case "":
			$modules = SyncDatabase::getModules($remoteDatabase);
			
			echo 'Select modules to sync contents (structure,content):<br/><form action="" method="post"><input type="hidden" name="cmd" value="syncronise"/>';
			
			foreach( $modules as $key=>$value ){
				echo '<input type="checkbox" name="smodule'.$value['sys_module_id'].'" value="yes" '.$default.'/><input type="checkbox" name="cmodule'.$value['sys_module_id'].'" value="yes" '.$default.'/>'.$value['name'].' <br/>';
			}
			
			echo '<input type="checkbox" name="systemtables" value="yes" '.$default.'/> Sync System tables <br/>';
			
			echo '<br/><input type="submit" value="Syncronise"/></form>';
			
		break;
		case "syncronise":
			$modules = SyncDatabase::getModules($remoteDatabase);
			foreach( $modules as $key=>$value ){
				if( $__APPLICATION_['url']->getRequestVar('smodule'.$value['sys_module_id'])!='' ){
					SyncDatabase::syncModule($remoteDatabase,$localDatabase,$value);					
				}
				if( $__APPLICATION_['url']->getRequestVar('cmodule'.$value['sys_module_id'])!='' ){
					SyncDatabase::syncModuleContent($remoteDatabase,$localDatabase,$value['tableName']);					
				}
			}
			
			if( $__APPLICATION_['url']->getRequestVar('systemtables')!='' ){
				SyncDatabase::syncSystemTables($remoteDatabase,$localDatabase);
			}
		break;		
	}

	$remoteDatabase->close();
	$localDatabase->close();
	
}else{

	echo 'Error, no parameters received, required params: server, fromclient, toclient and perhaps default (checked)';
	die;

}


?>