<?
require_once(".citadel.config.conf");

$db = $__APPLICATION_['database'];
$db->__runquery_('CREATE TABLE `sys_trash` (
`sys_trash_id` INT( 15 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`sys_trash_display_text` VARCHAR( 255 ) NOT NULL ,
`sys_trash_type` VARCHAR( 255 ) NOT NULL ,
`sys_trash_values` VARCHAR( 255 ) NOT NULL
) ENGINE = MYISAM ;');

$tables = $db->fetcharray('show tables');

foreach( $tables as $key=>$value ){
        print_r($value);
        echo "<p>".$value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']]." : ".strstr($value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']],'_fields')."</p>";
	if( strstr($value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']],'mod_')!='' ){
		echo "Attempt Altering...<br>";
		if( $__APPLICATION_['database']->__runquery_('alter table '.$value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']].' add sys_trash int(1) not null default 0') ){
			echo $value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']].' has been altered<br>';
		}else{
			echo $value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']].' was not altered<br>';
			echo 'alter table '.$value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']].' add sys_trash int(1) not null default 0<br>';
		}
	}else{
		echo $value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']].' was not altered<br>';
	}
}

$__APPLICATION_['database']->__runquery_('alter table sys_tree add sys_trash int(1) not null default 0');

?>