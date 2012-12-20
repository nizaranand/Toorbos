<?php
if( $moduleValues['cmd']=='' ){
	// set all request variables
	$search = isSet( $_REQUEST['search'] ) && $_REQUEST['search'] != '' ? $_REQUEST['search'] : '';//$search;
	$itemsPerPage = 30; // total amount of items to get
	$currentPage = isSet( $_REQUEST['currentPage'] ) && $_REQUEST['currentPage'] != '' ? $_REQUEST['currentPage'] : '';//$currentPage;
	$totalItemsToGet = 10000000;

	// base calculations
	$startNumber = $currentPage*$itemsPerPage;
	$endNumber = $startNumber+$itemsPerPage;

	$listQueryLmiter = ' limit '.$startNumber.','.($totalItemsToGet < $itemsPerPage && $totalItemsToGet!=0 ? $totalItemsToGet : $itemsPerPage);
		

	//	echo 'select count(*) from sys_tree,mod_page where sys_tree.sys_module_id=7 and mod_page.mod_page_id=sys_tree.mod_content_id '.($search!='' ? ' and LOWER(mod_page.name) like LOWER("%'.trim($search).'%")' : '').' order by mod_page.name';die;
	// get the count
	$countResults = $db->fetchrownamed('select count(*) from sys_tree,mod_page where sys_tree.sys_module_id=7 and mod_page.mod_page_id=sys_tree.mod_content_id '.($search!='' ? ' and LOWER(mod_page.name) like LOWER("%'.trim($search).'%")' : '').' order by mod_page.name');

	//echo $listQueryCount.$listQuery;die;
	$moduleValues['skinFunctions']['loop']['resultPages'] = array();
	if( $countResults['count(*)']>0 ){
		// calculate the resulting pages
		$totalPages = round(($countResults['count(*)']/$itemsPerPage)-0.49);
		$startNumber = $currentPage*$itemsPerPage;
		$endNumber = $startNumber+$itemsPerPage;
		$endNumber = $endNumber > $countResults['count(*)'] ? $countResults['count(*)'] : $endNumber;

		$moduleValues['skinFunctions']['loop']['pages'] = array();
		for( $counter=0; $counter<=$totalPages; $counter++ ){
			$moduleValues['skinFunctions']['loop']['resultPages'][$counter] = array();
			$moduleValues['skinFunctions']['loop']['resultPages'][$counter]['pageNumber'] = $counter+1;
			//	            $moduleValues['skinFunctions']['loop']['pages'][$counter]['pageUrl'] = '?orderBy'=>$orderBy,'orderDirection'=>$orderDirection,'pageNumber'=>$counter));
			$moduleValues['skinFunctions']['loop']['resultPages'][$counter]['pageUrl'] = '?currentPage='.$counter.'&search='.$search;
			$moduleValues['skinFunctions']['loop']['resultPages'][$counter]['pageNumberDisplay'] = $counter+1;
			$moduleValues['skinFunctions']['loop']['resultPages'][$counter]['append'] = $counter==$currentPage ? 'selected' : '';
			$moduleValues['skinFunctions']['loop']['resultPages'][$counter]['prepend'] = $counter==$currentPage ? 'selected' : '';
		}
		// generate next and previous
		/*            $moduleValues['skinFunctions']['var']['nextPage'] = ($currentPage)!=$totalPages && $totalPages!=0 ? '<a href="<var:pagePath>?'.$this->url->create('get',array('orderBy'=>$orderBy,'orderDirection'=>$orderDirection,'pageNumber'=>($currentPage+1))).'" class="nav">next>></a>' : '';
		 $moduleValues['skinFunctions']['var']['previousPage'] = $currentPage!=0 ? '<a href="<var:pagePath>?'.$this->url->create('get',array('orderBy'=>$orderBy,'orderDirection'=>$orderDirection,'pageNumber'=>($currentPage-1))).'" class="nav">&lt;&lt;previous</a>' : '';
		 $moduleValues['skinFunctions']['var']['orderBy'] = $orderBy;
		 $moduleValues['skinFunctions']['var']['currentPage'] = $currentPage;
		 $moduleValues['skinFunctions']['var']['currentPageDisplay'] = $currentPage+1;
		 $moduleValues['skinFunctions']['var']['totalPages'] = $totalPages+1;*/
		$moduleValues['skinFunctions']['var']['nextPage'] = ($currentPage)!=$totalPages && $totalPages!=0 ? '<a href="<var:pagePath>?currentPage='.($currentPage+1).'&search='.$search.'" class="nav">next>></a>' : '';
		$moduleValues['skinFunctions']['var']['previousPage'] = $currentPage!=0 ? '<a href="<var:pagePath>?'.'currentPage='.($currentPage-1).'&search='.$search.'" class="nav">&lt;&lt;previous</a>' : '';
		$moduleValues['skinFunctions']['var']['currentPage'] = $currentPage;
		$moduleValues['skinFunctions']['var']['currentPageDisplay'] = $currentPage+1;
		$moduleValues['skinFunctions']['var']['totalPages'] = $totalPages+1;
		// recalc bioimage

	}

	// get all the pages in the system
	$pages = $db->fetcharray('select mod_page.name as pageName,sys_tree.*,mod_page.* from sys_tree,mod_page where sys_tree.sys_module_id=7 and mod_page.mod_page_id=sys_tree.mod_content_id '.($search!='' ? ' and LOWER(mod_page.name) like LOWER("%'.trim($search).'%")' : '').' order by mod_page.name'.$listQueryLmiter);

	$actualPages = array();

	foreach( $pages as $key=>$value ){
		$path = $GLOBALS['__APPLICATION_']['utilities']->generatePagePath( $value['sys_tree_id'] );
		$path = str_replace($GLOBALS['__CONFIG_']['__paths_']['__clientPath_'],'',$path);
		$path = str_replace('/'.$GLOBALS['__CONFIG_']['__paths_']['__httpPath_'],'',$path);
		$path = eregi_replace("^/","",$path);

		if( !strstr($path,'admin') ){
			if( isSet($_REQUEST['generateImages']) ){
				system('wkhtmltoimage --crop-w 230 --crop-h 130 --zoom 0.25 --width 100 '.$GLOBALS['__APPLICATION_']['channel']->getBaseURL().$path.' '.$paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/'.$paths['__httpPath_'].'/images/Fiber/'.($value['path']=='' ? 'home' : $value['path']).'.jpg');
			}
			$value['image'] = $value['path']=='' ? 'home' : $value['path'].'.jpg';			 
			$value['path'] = $path;
			array_push($actualPages,$value);
		}
	}

	$moduleValues['skinFunctions']['loop']['pages'] = $actualPages;
}
?>