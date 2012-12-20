<? 
require_once ("../../config/.citadel.config.conf");
echo "attempting";
// get all the modules
$modules = $__APPLICATION_['database']->fetcharray('select * from sys_module');
echo "attempting";
foreach( $modules as $key=>$value ){
	echo 'sys_'.$value['tableName'].'_fields has been altered<br>';
	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','MQAlterModuleFieldsTable',array('tableName'=>$value['tableName']));
	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','MQAlterModuleFieldsTableDisplayOrder',array('tableName'=>$value['tableName']));
	// get all module fields
	$fields = $__APPLICATION_['database']->fetcharray('select * from sys_'.$value['tableName'].'_fields');
	foreach( $fields as $fieldKey=>$fieldValue ){
		$__APPLICATION_['database']->__runquery_('update sys_'.$value['tableName'].'_fields set displayOrder='.$fieldKey.' where sys_'.$value['tableName'].'_fields_id='.$fieldValue['sys_'.$value['tableName'].'_fields_id']);
		echo "&nbsp;&nbsp;&nbsp;field:".$fieldValue['displayName']." update... <br>";
	}
}

?>