<?
require_once(".citadel.config.conf");
// update
$db = $__APPLICATION_['database'];
$tables = $db->fetcharray('show tables');
foreach( $tables as $key=>$value ){
        print_r($value);
        echo "<p>".$value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']]."</p>";
	if( $__APPLICATION_['database']->__runquery_('alter table '.$value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']].' change '.$value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']].'_id '.$value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']].'_id int(15) not null auto_increment') ){
		echo $value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']].' has been altered<br>';
	}else{
		echo $value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']].' was not altered<br>';
		echo 'alter table '.$value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']].' change '.$value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']].'_id '.$value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']].'_id int(15) not null auto_increment<br>';
	}
}

?>