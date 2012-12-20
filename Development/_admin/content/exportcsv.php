<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'content','section'=>'editcontent')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

$db = $GLOBALS['__APPLICATION_']['database'];

/* resolve vars */
$tableName = isSet($_REQUEST['tableName']) ? $_REQUEST['tableName'] : '';

// get count
$numberOfResults = $db->fetchrownamed('select count(*) from mod_'.$tableName);

$loops = $numberOfResults['count(*)']/100;
$loops<1 ? 1 : 0;

$counter = 0;
$csvFile = '';

// get module name
$moduleDetail = $db->fetchrownamed('select * from sys_module where tableName="'.$tableName.'"');

// get headers
$headers = $db->fetcharray('select * from sys_'.$tableName.'_fields');

$csvFile .= '<table><tr><td bgcolor="#CC3300" colspan="'.(count($headers)+1).'"><font size="3" color="white"><b>Expert '.$moduleDetail['name'].' Content List</b></td></tr><tr>';
$csvFile .= '<td bgcolor="#CCCCCC"><b>'.$moduleDetail['name'].' - id</b></td>';
foreach( $headers as $key=>$value ){
	$csvFile .= '<td bgcolor="#CCCCCC"><b>'.$value['displayName'].'</b></td>';
}
$csvFile .= '</tr>';

while( $counter<$loops ){
	$results = $db->fetcharray('select * from mod_'.$tableName.' limit '.($counter*100).',100');
	foreach( $results as $key=>$value ){
		$csvFile .= '<tr>';
		$csvFile .= '<td>'.$value['mod_'.$tableName.'_id'].'</td>';
		foreach( $headers as $headerKey=>$headerValue ){
			$csvFile .= '<td>'.$value[$headerValue['name']].'</td>';
		}
		$csvFile .= '</tr>';
	}
	$counter++;
}
$csvFile .= '</table>';
header("Content-type: application/excel");
header("Content-disposition: attachment; filename=".$moduleDetail['name'].'.xls');
echo $csvFile;

?>