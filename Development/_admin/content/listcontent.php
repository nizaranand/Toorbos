<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'content','section'=>'listcontent')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

$db = $__APPLICATION_['database'];

/* resolve vars */
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';
$tableName = isSet($_REQUEST['tableName']) && $_REQUEST['tableName']!='' ? $_REQUEST['tableName'] : '';
$currentPage = isSet($_REQUEST['currentPage']) && $_REQUEST['currentPage']!='' ? $_REQUEST['currentPage'] : 0;
$sys_module_id = isSet($_REQUEST['sys_module_id']) && $_REQUEST['sys_module_id']!='' ? $_REQUEST['sys_module_id'] : '';
$mod_content_id = isSet($_REQUEST['mod_content_id']) && $_REQUEST['mod_content_id']!='' ? $_REQUEST['mod_content_id'] : '';
$orderBy = isSet($_REQUEST['orderBy']) && $_REQUEST['orderBy']!='' ? $_REQUEST['orderBy'] : 'name';
$orderDirection = isSet($_REQUEST['orderDirection']) && $_REQUEST['orderDirection']!='' ? $_REQUEST['orderDirection'] : 'ASC';
$itemsPerPage = 30; // total amount of items to get

switch( $cmd ){
	case "deleteContent":
	    $module = new module(array('in'=>array('sys_module_id'=>$sys_module_id,'mod_content_id'=>$mod_content_id,'tableName'=>$tableName)),'deleteContent');
        $__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQDeleteContent',array('sys_module_id'=>$sys_module_id,'mod_content_id'=>$mod_content_id,'tableName'=>$tableName));
	break;
	case "exportcsv":
	if( ($moduleContent = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','MQGetAllModuleContent',array('tableName'=>$tableName) ) ) ){
		foreach( $moduleContent as $key=>$value ){
		    $module = new module(array('in'=>array('sys_module_id'=>$sys_module_id,'mod_content_id'=>$value['mod_content_id'],'tableName'=>$value['tableName'])),'admin');
			if( !$doneHeaders ){
				$columns = 0;
				$xls = '<tr>';
				foreach( $module->moduleValues['fields'] as $key=>$field ){
					$xls .= '<td bgcolor="#CCCCCC"><b>'.$field['displayName'].'</b></td>';
					$columns++;
				}
				$xls .= '</tr>';
				$doneHeaders=1;
				$xls = '<table><tr><td colspan="'.$columns.'" bgcolor="#CC3300"><font size="3" color="white"><b>Expert (Child) Report</b></td></tr>'.$xls;
				$xls .= '<tr>';
			}
			foreach( $module->moduleValues['fields'] as $key=>$field ){
				$xls .= '<td>'.$module->moduleValues['content'][$field['name']].'</td>';
			}
			$xls .= '</tr>';
		}
	}else{
		$xls = '<table><tr><td bgcolor="#CC3300"><font size="3" color="white"><b>Expert (Child) Report</b></td></tr></table>';
	}
	header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
	header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
	header ( "Pragma: no-cache" );
	header ( "Content-type: application/x-msexcel" );
	header ( "Content-Disposition: attachment; filename=Expert-Export-Content.xls" );
	header ( "Content-Description: PHP Generated XLS Data" );
	print $xls.'</table>';
	die;
	break;
}

$moduleDetail = $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','MQGetModuleDetail',array('sys_module_id'=>$sys_module_id,'mod_content_id'=>$mod_content_id,'tableName'=>$tableName));

/* get commands */
$commands = array();
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('newcontent',array('sys_module_id'=>$sys_module_id,'tableName'=>$tableName))));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('exportcsv',array('sys_module_id'=>$sys_module_id,'tableName'=>$tableName))));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('importcsv',array('sys_module_id'=>$sys_module_id))));

// base calculations
$startNumber = $currentPage*$itemsPerPage;
$endNumber = $startNumber+$itemsPerPage;

// check for id order direction
$idOrderDirection = $orderBy=='mod_'.$tableName.'_id' && $orderDirection == 'ASC' ? 'DESC' : 'ASC';

$searchParameters = '';

// get headers to generate
if( !($headers = $db->fetcharray('select name,displayName from sys_'.$tableName.'_fields where listColumn=1')) ){
	$headersString = 'mod_'.$tableName.'.name';
	$headersLoop = array(array('header'=>'name','headerFriendly'=>'Name','headerOrderDirection'=>($orderBy=='name' && $orderDirection=='ASC' ? 'DESC' : 'ASC')));
	$searchParameters .= isSet($GLOBALS['_REQUEST']['nameSearch']) && $GLOBALS['_REQUEST']['nameSearch']!='' ? (strstr($searchParameters,'=') ? ' and ' : '').'name like "%'.$GLOBALS['_REQUEST']['nameSearch'].'%"' : '';
}else{
	$headersLoop = array();
	$headersString = '';
	foreach( $headers as $key=>$value ){
		$searchParameters .= isSet($GLOBALS['_REQUEST'][$value['name'].'Search']) && $GLOBALS['_REQUEST'][$value['name'].'Search']!='' ? (strstr($searchParameters,'like') ? ' and ' : ' ').$value['name'].' like "%'.$GLOBALS['_REQUEST'][$value['name'].'Search'].'%"' : ''; 
		array_push($headersLoop,array('header'=>$value['name'],'headerFriendly'=>$value['displayName'],'headerOrderDirection'=>($orderBy==$value['name'] && $orderDirection=='ASC' ? 'DESC' : 'ASC')));
		$headersString .= 'mod_'.$tableName.'.'.$value['name'].($key!=(count($headers)-1) ? ',' : '');
	}
}

// implement search cabality
 

// build the query
$listQueryNonCount = 'select mod_'.$tableName.'.mod_'.$tableName.'_id as mod_content_id,'.$headersString;
$listQueryCount = 'select count(*)';
$listQuery = ' from mod_'.$tableName;
$listQuery .= isSet($searchParameters) && $searchParameters!='' ? ' where '.$searchParameters : '';
$listQuery .= $orderBy!='' && $orderDirection!='' ? ' order by mod_'.$tableName.'.'.$orderBy.' '.$orderDirection : '';
$listQueryEnd = ' limit '.$startNumber.','.$itemsPerPage;

// get the counts
$countResults = $db->fetchrownamed($listQueryCount.$listQuery);
$totalItems = $countResults['count(*)'];
$hasPages = array();
$items = array();
$values = array();
$pages = array();
if( $totalItems>0 ){

	   	// calculate the resulting pages
        $totalPages = round(($totalItems/$itemsPerPage)-0.49);
        $startNumber = $currentPage*$itemsPerPage;
        $endNumber = $startNumber+$itemsPerPage;
        $endNumber = $endNumber > $totalItems ? $totalItems+1 : $endNumber;

        // generate pages
        $pages = array();
        for( $counter=0; $counter<$totalPages; $counter++ ){
            $pages[$counter] = array();
            $pages[$counter]['pageNumber'] = $counter;
            $pages[$counter]['pageUrl'] = '?sys_module_id='.$sys_module_id.'&tableName='.$tableName.'&currentPage='.$counter;
            $pages[$counter]['pageNumberDisplay'] = $counter+1;
            $pages[$counter]['append'] = $counter==$currentPage ? '</b>' : '';
            $pages[$counter]['prepend'] = $counter==$currentPage ? '<b>' : '';
        }
        
        if( count($pages)==0 ){
        	 $hasPages = array();
        }else{
   			$hasPages = array(array('pages'=>$pages)); 
        }        	
        
        
        // generate next and previous
        $nextPage = $currentPage!=$totalPages ? '<a href="_admin/<var:pagePath>listcontent.php?sys_module_id='.$sys_module_id.'&tableName='.$tableName.'&currentPage='.($currentPage+1).'" class="nav">next>></a>' : '';
        $previousPage = $currentPage!=0 ? '<a href="_admin/<var:pagePath>listcontent.php?sys_module_id='.$sys_module_id.'&tableName='.$tableName.'&currentPage='.($currentPage-1).'" class="nav">&lt;&lt;previous</a>' : '';
        $currentPage = $currentPage;
        $currentPageDisplay = $currentPage+1;
        $totalPages = $totalPages+1;
		
		// get the count
	    $items = $db->fetcharray($listQueryNonCount.$listQuery.$listQueryEnd);
	   	$values = array();
	   	
	    // get commands
	    foreach( $items as $key=>$value ){
	    	$values[$key] = !is_array($values[$key]) ? array() : $values[$key];
	    	$values[$key]['values'] = !is_array($values[$key]['values']) ? array() : $values[$key]['values'];
	    	foreach( $value as $key2=>$value2 ){
	    		array_push($values[$key]['values'],array('value'=>$value[$key2]));
	    	}
	    	
	    	
	    	// check if we are trash
            if( $sys_trash = $__APPLICATION_['database']->fetchrownamed('select * from sys_trash where sys_trash_type="module" and sys_trash_values="tableName='.$moduleDetail['tableName'].'&sys_module_id='.$moduleDetail['sys_module_id'].'&mod_content_id='.$value['mod_content_id'].'"') ){
              $values[$key]['trash'] = 'yes';
            }else{
              $values[$key]['trash'] = 'no';
            }
			$moduleContentCommands = array();
			array_push($moduleContentCommands,array('output'=>$__APPLICATION_['channel']->getCommand('editcontent',array('sys_module_id'=>$sys_module_id,'mod_content_id'=>$value['mod_content_id']))));
        	array_push($moduleContentCommands,array('output'=>$__APPLICATION_['channel']->getCommand('deletecontent',array('sys_module_id'=>$sys_module_id,'mod_content_id'=>$value['mod_content_id']))));
        	$values[$key]['commands'] = $moduleContentCommands;
	    }
}
$__APPLICATION_['channel']->replaceLoop('hasPages',$hasPages);
$__APPLICATION_['channel']->replaceLoop('items',$values);

$__APPLICATION_['channel']->replaceLoop('headers',$headersLoop);
$__APPLICATION_['channel']->replaceLoop('pages',$pages);
$__APPLICATION_['channel']->replace('<var:sys_module_id>',$sys_module_id);
$__APPLICATION_['channel']->replace('<var:idOrderDirection>',$idOrderDirection);
$__APPLICATION_['channel']->replace('<var:nextPage>',$nextPage);
$__APPLICATION_['channel']->replace('<var:previousPage>',$previousPage);
$__APPLICATION_['channel']->replace('<var:totalPages>',$totalPages);

/* replace values */
$__APPLICATION_['channel']->replaceLoop('commands',$commands);
$__APPLICATION_['channel']->replaceLoop('moduleContent',$moduleContent);
$__APPLICATION_['channel']->replace('<var:tableName>',$tableName);
$__APPLICATION_['channel']->replace('<var:moduleName>',$moduleDetail['moduleName']);

//
//
///* get all module content
//if( ($moduleContent = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','MQGetAllModuleContent',array('tableName'=>$tableName) ) ) ){
//	foreach( $moduleContent as $key=>$value ){
//		// do delete and edit commands
//		$moduleContentSkin = $__APPLICATION_['channel']->getSkin('listcontent-content.tpl');
//		$moduleContentCommands = array();
//		array_push($moduleContentCommands,array('output'=>$__APPLICATION_['channel']->getCommand('editcontent',array('sys_module_id'=>$sys_module_id,'mod_content_id'=>$value['mod_content_id']))));
//        array_push($moduleContentCommands,array('output'=>$__APPLICATION_['channel']->getCommand('deletecontent',array('sys_module_id'=>$sys_module_id,'mod_content_id'=>$value['mod_content_id']))));
//		$moduleContentSkin->replaceLoop('commands',$moduleContentCommands);
//		$moduleContentSkin->replace('<var:name>',$value['name']);
//		$moduleContent[$key]['output'] = $moduleContentSkin->output();
//	}
//}*/
//
//// base calculations
//$startNumber = $currentPage*$itemsPerPage;
//$endNumber = $startNumber+$itemsPerPage;
//
//   // build the query
//$listQueryNonCount = 'select mod_'.$tableName.'.sys_trash, mod_'.$tableName.'.mod_'.$tableName.'_id as mod_content_id,mod_'.$tableName.'.*';
//$listQueryCount = 'select count(*)';
//$listQuery = ' from mod_'.$tableName;
//$listQuery .= $orderBy!='' && $orderDirection!='' ? ' order by '.$orderBy.' '.$orderDirection : '';
//$listQueryEnd = ' limit '.$startNumber.','.$itemsPerPage;
//
//
//// get the count
//$countResults = $db->fetchrownamed($listQueryCount.$listQuery);
//$totalItems = $countResults['count(*)'];
//$hasPages = array();
//$items = array();
//$pages = array();
//if( $totalItems>0 ){
//
//	   	// calculate the resulting pages
//        $totalPages = round(($totalItems/$itemsPerPage)-0.49);
//        $startNumber = $currentPage*$itemsPerPage;
//        $endNumber = $startNumber+$itemsPerPage;
//        $endNumber = $endNumber > $totalItems ? $totalItems+1 : $endNumber;
//
//        // generate pages
//        $pages = array();
//        for( $counter=0; $counter<$totalPages; $counter++ ){
//            $pages[$counter] = array();
//            $pages[$counter]['pageNumber'] = $counter;
//            $pages[$counter]['pageUrl'] = '?sys_module_id='.$sys_module_id.'&tableName='.$tableName.'&currentPage='.$counter;
//            $pages[$counter]['pageNumberDisplay'] = $counter+1;
//            $pages[$counter]['append'] = $counter==$currentPage ? '</b>' : '';
//            $pages[$counter]['prepend'] = $counter==$currentPage ? '<b>' : '';
//        }
//
//        if( count($pages)==0 ){
//        	 $hasPages = array();
//        }else{
//   			$hasPages = array(array('pages'=>$pages));
//        }
//
//
//        // generate next and previous
//        $nextPage = $currentPage!=$totalPages ? '<a href="_admin/<var:pagePath>listcontent.php?sys_module_id='.$sys_module_id.'&tableName='.$tableName.'&currentPage='.($currentPage+1).'" class="nav">next>></a>' : '';
//        $previousPage = $currentPage!=0 ? '<a href="_admin/<var:pagePath>listcontent.php?sys_module_id='.$sys_module_id.'&tableName='.$tableName.'&currentPage='.($currentPage-1).'" class="nav">&lt;&lt;previous</a>' : '';
//        $currentPage = $currentPage;
//        $currentPageDisplay = $currentPage+1;
//        $totalPages = $totalPages+1;
//
//		// get the count
//	    $items = $db->fetcharray($listQueryNonCount.$listQuery.$listQueryEnd);
//
//	    // get commands
//	    foreach( $items as $key=>$value ){
//			$moduleContentCommands = array();
//			array_push($moduleContentCommands,array('output'=>$__APPLICATION_['channel']->getCommand('editcontent',array('sys_module_id'=>$sys_module_id,'mod_content_id'=>$value['mod_content_id']))));
//        	array_push($moduleContentCommands,array('output'=>$__APPLICATION_['channel']->getCommand('deletecontent',array('sys_module_id'=>$sys_module_id,'mod_content_id'=>$value['mod_content_id']))));
//            if( $value['sys_trash']==1 ){
//              $items[$key]['sys_trash'] = ' style="text-decoration:line-through;"';
//            }else{
//              $items[$key]['sys_trash'] = '';
//            }
//        	$items[$key]['commands'] = $moduleContentCommands;
//	    }
//}
//$__APPLICATION_['channel']->replaceLoop('hasPages',$hasPages);
//$__APPLICATION_['channel']->replaceLoop('items',$items);
//$__APPLICATION_['channel']->replaceLoop('pages',$pages);
//$__APPLICATION_['channel']->replace('<var:nextPage>',$nextPage);
//$__APPLICATION_['channel']->replace('<var:previousPage>',$previousPage);
//$__APPLICATION_['channel']->replace('<var:totalPages>',$totalPages);
//
///* replace values */
//$__APPLICATION_['channel']->replaceLoop('commands',$commands);
//$__APPLICATION_['channel']->replaceLoop('moduleContent',$moduleContent);
//$__APPLICATION_['channel']->replace('<var:tableName>',$tableName);
//$__APPLICATION_['channel']->replace('<var:moduleName>',$moduleDetail['moduleName']);
//
///* show channel */
$__APPLICATION_['channel']->show();
?>
