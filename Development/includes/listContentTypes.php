<?php

if( $moduleValues['cmd']=='' ){
	
	// get all the pages in the system
	$modules = $db->fetcharray('select name as moduleName,sys_module.* from sys_module where isCustom="yes" order by name');
	
	$moduleValues['skinFunctions']['loop']['modules'] = $modules;
	
}

?>