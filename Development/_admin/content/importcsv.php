<?
require_once("../../config/.citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'content','section'=>'importcsv')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

$db = $__APPLICATION_['database'];

/* resolve vars */
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';
$sys_module_id = isSet($_REQUEST['sys_module_id']) && $_REQUEST['sys_module_id']!='' ? $_REQUEST['sys_module_id'] : '';

$csvDataColumns = array();
$csvDataValues = array();

$message = '';
$button = '';

switch( $cmd ){
	case "importcsv":
	  $csvData = $__APPLICATION_['utilities']->getCSV($_FILES['file']['tmp_name']);
	  $_SESSION['csvData'] = $csvData;
	  // reformat array
	  // do columns
	  foreach( $csvData[0] as $key=>$value ){
	  	array_push($csvDataColumns,array('heading'=>$value));
	  } 
	  array_shift($csvData);
	  // format data
	  foreach( $csvData as $key=>$value ){
	  	foreach( $value as $key2=>$value2 ){
	  		$csvDataValues[$key]['data'] = !is_array($csvDataValues[$key]['data']) ? array() : $csvDataValues[$key]['data'];
	  		array_push($csvDataValues[$key]['data'],array('contentValue'=>$value2));
	  	}
	  }
	  $message = "<p>Please verify the following data.</p>";
	  $button = '<hr><input type="button" value="confirm" onclick="document.location.href=\'<var:baseURL>_admin/content/importcsv.php?cmd=confirmed&sys_module_id='.$sys_module_id.'\';">';
	break;
	case "confirmed":
	  $csvData = $_SESSION['csvData'];
	  $tableNameResult = $db->fetchrownamed('select tableName from sys_module where sys_module_id='.$sys_module_id);
	  $tableName = $tableNameResult['tableName'];

	  // find company column if were findstuff, hack for the client
      if( $__CONFIG_['__db_']['__dbDatabase_']=='findstuff' && $sys_module_id==157 ){
//        $db->__runquery_('delete from mod_'.$tableName.' where company="'.$csvData[0][count($csvData[0])-1].'"');
        $column = count($csvData[1])-1;
        $db->__runquery_('delete from mod_'.$tableName.' where company="'.$csvData[1][$column].'"');
      }

	  $columnsResult = $db->fetcharray('select name from sys_'.$tableName.'_fields');
	  $insertQueries1 = 'insert into mod_'.$tableName.'(';
	  foreach( $csvData[0] as $key=>$value ){
	  	$insertQueries1 .= $columnsResult[$key]['name'].($key!=(count($csvData[0])-1) ? ',' : ')');
	  }
	  array_shift($csvData);
	  // format data
	  foreach( $csvData as $key=>$value ){
	  	$rowInsertQuery = $insertQueries1.' values(';
	  	foreach( $value as $key2=>$value2 ){
	  		$rowInsertQuery .= '"'.$value2.($key2!=(count($value)-1) ? '"'.',' : '"'.')');
	  	}
	  	$db->__runQuery_($rowInsertQuery);
	  }
	  $message = "<p>CSV Data has been imported</p>";
	break;
}

$__APPLICATION_['channel']->replaceLoop('csvDataColumns',$csvDataColumns);
$__APPLICATION_['channel']->replaceLoop('csvDataValues',$csvDataValues);
$__APPLICATION_['channel']->replace('<var:sys_module_id>',$sys_module_id);
$__APPLICATION_['channel']->replace('<var:tableName>',$tableName);
$__APPLICATION_['channel']->replace('<var:message>',$message);
$__APPLICATION_['channel']->replace('<var:button>',$button);

/* show channel */
$__APPLICATION_['channel']->show();
?>
