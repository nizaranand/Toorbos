<?
require_once(".citadel.config.conf");

// get all the modules
$modules = $__APPLICATION_['database']->fetcharray('select * from sys_module');

foreach( $modules as $key=>$value ){
	if( $__APPLICATION_['database']->__runquery_('alter table mod_'.$value['tableName'].' add dateLastModified datetime null, add lastModifiedBy char(100) null') ){
		echo 'mod_'.$value['tableName'].' has been altered<br>';
	}else{
		echo 'mod_'.$value['tableName'].' was not altered<br>';
		echo 'alter table mod_'.$value['tableName'].' add dateLastModified datetime null, add lastModifiedBy char(100) null<br>';
	}
}

?>