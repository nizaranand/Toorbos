<?php 

if( $moduleValues['cmd']=='' ){
	
	$contentType = $this->url->getRequestVar('contentType');
	
	// get all the pages in the system
	$modules = $db->fetcharray('select name as moduleName,sys_module.* from sys_module where isCustom="yes" order by name');
	
	foreach( $modules as $key=>$value ){
		if( $contentType==$value['tableName'] ){
			$modules[$key]['selected'] = 'yes'; 			
		}else{
			$modules[$key]['selected'] = 'no';
		}
	}
	
	
	$moduleValues['skinFunctions']['loop']['modules'] = $modules;
	
	$moduleValues['skinFunctions']['var']['contentType'] = $contentType;

	
}

?>