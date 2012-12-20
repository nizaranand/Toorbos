<?
ob_start();
require_once(".citadel.config.conf");
require_once("JSON.php");
$__APPLICATION_['channel'] = new channel( array('in' => array('path' => 'sites', 'section' => 'www', 'skin' => 'blankChannel.tpl' ) ) );
// get all vars

$moduleName = isSet($_REQUEST['moduleName']) ? $_REQUEST['moduleName'] : '';
$filterFields = isSet($_REQUEST['filterFields']) ? $_REQUEST['filterFields'] : '';
$filterValues = isSet($_REQUEST['filterValues']) ? $_REQUEST['filterValues'] : '';
$filterComparison = isSet($_REQUEST['filterComparison']) ? $_REQUEST['filterComparison'] : '';
$filterOperator = isSet($_REQUEST['filterOperator']) ? $_REQUEST['filterOperator'] : '';
$filterRelationshipFields = isSet($_REQUEST['filterRelationshipFields']) ? $_REQUEST['filterRelationshipFields'] : '';
$filterRelationshipValues = isSet($_REQUEST['filterRelationshipValues']) ? $_REQUEST['filterRelationshipValues'] : '';
$wildcard = isSet($_REQUEST['wildcard']) ? $_REQUEST['wildcard'] : '';
$onlyRelationships = isSet($_REQUEST['wildcard']) ? $_REQUEST['onlyRelationships'] : '';
$json = new Services_JSON();

$paths = $__CONFIG_['__paths_'];

$editMode = isSet( $_REQUEST['editMode'] ) ? $_REQUEST['editMode'] : 0;
$createMode = isSet( $_REQUEST['createMode'] ) ? $_REQUEST['createMode'] : 0;
$__APPLICATION_['channel'] = new channel( array('in' => array('path' => 'sites', 'section' => 'www', 'skin' => 'blankChannel.tpl' ) ) );

// check for a custom session object
if( is_file($paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/files/includes/siteSession.php') ){
	include_once($paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/files/includes/siteSession.php');
}else{
	include_once($paths['__libPath_'].'/siteSession.php');
}

//check for email usage
$useEmail = true;
$GLOBALS['siteSession'] = new siteSession($GLOBALS['__APPLICATION_']['uniqueID'],'mod_applicationUser',$useEmail);

$fields = array();
if( count($filterFields)>0 ){
	foreach( $filterFields as $key=>$value ){
		array_push($fields,array('name'=>$filterFields[$key],'value'=>$filterValues[$key],'operator'=>(isSet($filterOperator[$key]) && $filterOperator[$key]!='' ? $filterOperator[$key] : ($key==0 ? 'and (' : 'or')),'comparison'=>(isSet($filterComparison[$key]) ? $filterComparison[$key] : '')));
	}
}

$relFields = array();
$existingRelationships = array();
if( $filterRelationshipFields!='' && count($filterRelationshipFields)>0 ){
	foreach( $filterRelationshipFields as $key=>$value ){
			// decide on tablename
			$tableNameToCheck = 'rel_'.$moduleName.'_'.$filterRelationshipFields[$key];
			//check that we have a reference table
			$query = 'show tables like "'.$tableNameToCheck.'"';
			if( !$GLOBALS['__APPLICATION_']['database']->fetchrownamed($query) ){
				//  check for reverse connection
				$tableNameToCheck = 'rel_'.$filterRelationshipFields[$key].'_'.$moduleName;
			}
			array_push($relFields,array('tableNameToCheck'=>$tableNameToCheck,'name'=>$filterRelationshipFields[$key],'value'=>$filterRelationshipValues[$key],'operator'=>($key==0 ? 'and (' : 'or')));
	}
}

if( $onlyRelationships!='yes' ){
	if( count($fields) == 0 && $wildcard=='' ){
		$list = content::getList($moduleName);
	}else{
		$list = content::getList($moduleName,$orderBy="name",$orderDirection="DESC",$limit=null,$page=null,$fields,$wildcard);
	}
}

if( count($relFields)>0 ){
	
	$list2 = content::getRelationships($moduleName,$orderBy="name",$orderDirection="DESC",$limit=null,$page=null,$relFields,$wildcard);
	if( $list!=null ){
		foreach( $list2 as $key=>$value ){
			$found = false;
			foreach( $list as $key2=>$value2 ){
				if( $value['mod_content_id']==$value2['mod_content_id'] ){
					$found = true;
					break;
				}
			}
			if( !$found ){
				array_push($list,$value);
			}
		}
	}else{
		$list = $list2;
	}
}

echo $json->encode($list);
?>
