<? 
ob_start();
// get all vars
require_once (".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array ('in' => array ('path' => 'sites', 'section' => 'www', 'skin' => 'selectModule.tpl')));
$tableName = isSet ($GLOBALS['_REQUEST']['tableName']) && $GLOBALS['_REQUEST']['tableName'] != '' ? $GLOBALS['_REQUEST']['tableName'] : '';
$sys_control_id = isSet ($GLOBALS['_REQUEST']['sys_control_id']) && $GLOBALS['_REQUEST']['sys_control_id'] != '' ? $GLOBALS['_REQUEST']['sys_control_id'] : '';
$fieldName = isSet ($GLOBALS['_REQUEST']['fieldName']) && $GLOBALS['_REQUEST']['fieldName'] != '' ? $GLOBALS['_REQUEST']['fieldName'] : '';
$selectedItems = isSet ($GLOBALS['_REQUEST']['selectedItems']) && $GLOBALS['_REQUEST']['selectedItems'] != '' ? $GLOBALS['_REQUEST']['selectedItems'] : '';
$currentPage = isSet ($_REQUEST['currentPage']) && $_REQUEST['currentPage'] != '' ? $_REQUEST['currentPage'] : 0;
$orderBy = 'mod_'.$tableName.'.name';
$orderDirection = 'ASC';
$itemsPerPage = 10; // total amount of items to get
$db = $__APPLICATION_['database'];


// base calculations
$startNumber = $currentPage * $itemsPerPage;
$endNumber = $startNumber + $itemsPerPage;

// build the query
$listQueryNonCount = 'select mod_'.$tableName.'.mod_'.$tableName.'_id as mod_content_id,mod_'.$tableName.'.*';
$listQueryCount = 'select count(*)';
$listQuery = ' from mod_'.$tableName;
$listQuery .= $orderBy != '' && $orderDirection != '' ? ' order by '.$orderBy.' '.$orderDirection : '';
$listQueryEnd = ' limit '.$startNumber.','.$itemsPerPage;

// get the count
$countResults = $db->fetchrownamed($listQueryCount.$listQuery);
$totalItems = $countResults['count(*)'];
$hasPages = array ();
$items = array ();
$pages = array ();
if ($totalItems > 0) {

	// calculate the resulting pages
	$totalPages = round(($totalItems / $itemsPerPage) - 0.49);
	$startNumber = $currentPage * $itemsPerPage;
	$endNumber = $startNumber + $itemsPerPage;
	$endNumber = $endNumber > $totalItems ? $totalItems +1 : $endNumber;

	// generate pages
	$pages = array ();
	for ($counter = 0; $counter < $totalPages; $counter ++) {
		$pages[$counter] = array ();
		$pages[$counter]['pageNumber'] = $counter;
		$pages[$counter]['pageUrl'] = '?selectedItems='.$selectedItems.'tableName='.$tableName.'&currentPage='.$counter;
		$pages[$counter]['pageNumberDisplay'] = $counter +1;
		$pages[$counter]['append'] = $counter == $currentPage ? '</b>' : '';
		$pages[$counter]['prepend'] = $counter == $currentPage ? '<b>' : '';
	}

	if (count($pages) == 0) {
		$hasPages = array ();
	} else {
		$hasPages = array (array ('pages' => $pages));
	}

	// generate next and previous
	$nextPage = $currentPage != $totalPages ? '<a href="_admin/<var:pagePath>listcontent.php?sys_module_id='.$sys_module_id.'&tableName='.$tableName.'&currentPage='. ($currentPage +1).'" class="nav">next>></a>' : '';
	$previousPage = $currentPage != 0 ? '<a href="_admin/<var:pagePath>listcontent.php?sys_module_id='.$sys_module_id.'&tableName='.$tableName.'&currentPage='. ($currentPage -1).'" class="nav">&lt;&lt;previous</a>' : '';
	$currentPage = $currentPage;
	$currentPageDisplay = $currentPage +1;
	$totalPages = $totalPages +1;

	// get the count
	$items = $db->fetcharray($listQueryNonCount.$listQuery.$listQueryEnd);

	// get commands
	$selectedItemsArray = explode(',',$selectedItems);
	foreach ($items as $key => $value) {
		if( in_array($value['mod_content_id'],$selectedItems) ){
			$items[$key]['selected'] = 'selected';
		}else{
			$items[$key]['selected'] = '';
		}
	}
}
$__APPLICATION_['channel']->channelReplaceLoop('hasPages', $hasPages);
$__APPLICATION_['channel']->channelReplaceLoop('items', $items);
$__APPLICATION_['channel']->channelReplaceLoop('pages', $pages);
$__APPLICATION_['channel']->channelReplace('<var:fieldName>', $fieldName);
$__APPLICATION_['channel']->channelReplace('<var:sys_control_id>', $sys_control_id);
$__APPLICATION_['channel']->channelReplace('<var:nextPage>', $nextPage);
$__APPLICATION_['channel']->channelReplace('<var:previousPage>', $previousPage);
$__APPLICATION_['channel']->channelReplace('<var:totalPages>', $totalPages);
$__APPLICATION_['channel']->channelReplace('<var:tableName>', $tableName);

$__APPLICATION_['channel']->channelReplace('<var:title>', 'Select Modules');
ob_end_clean();
$__APPLICATION_['channel']->show();
?>