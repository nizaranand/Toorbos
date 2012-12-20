<?
require_once(".citadel.config.conf");
// update
$db = $__APPLICATION_['database'];
$tables = $db->fetcharray('show tables');
foreach( $tables as $key=>$value ){
        print_r($value);
        echo "<p>".$value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']]."</p>";
        $db->__runquery_('ALTER TABLE `'.$value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']].'` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci');
        $fields = $db->fetcharray('desc '.$value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']]);
        foreach( $fields as $fieldKey=>$fieldValue ){
                echo "<p>".$fieldValue[Field]."</p>";
                if( $fieldValue[Key]!="PRI" ){
                        $db->__runquery_('ALTER TABLE `'.$value['Tables_in_'.$__CONFIG_['__db_']['__dbDatabase_']].'` CHANGE `'.$fieldValue[Field].'` `'.$fieldValue[Field].'` '.$fieldValue[Type].' CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL');
                }
        } 
        echo "<p>Updated</p>";
}
?>

