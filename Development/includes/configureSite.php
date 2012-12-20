<?php 

if( $moduleValues['cmd']=='' ){
	
	$cmd = $this->url->getRequestVar('cmd');
	
	$siteFields = $db->fetcharray('select name as fieldName, sys_site_fields.* from sys_site_fields where name!="path" and name!="clientPath" and name!="urlPath" and name!="indexSite" order by sys_site_fields_id ASC');
		
	if( $cmd=='update' ){
		
		foreach( $siteFields as $key=>$value ){
			if( $this->url->isRequestVar($value['name']) ){
				$query = 'update mod_site set '.$value['name'].'="'.$this->url->getRequestVar($value['name']).'" where mod_site_id=6';
				$db->__runquery_($query);
			}			
		}
		
		$footer = $this->url->getRequestVar('footer');
		
		$query = 'update mod_wysiwyg set html="'.str_replace('"','\"',$footer).'" where name="Footer"';
		$db->__runquery_($query);
		
		
	}
	
	$site = $db->fetchrownamed('select * from mod_site where mod_site_id=6');
	
	foreach( $siteFields as $key=>$value ){
		$siteFields[$key]['content'] = $site[$value['name']];
	}
	
	//$siteFields = array_reverse($siteFields);
	
	$moduleValues['skinFunctions']['var'] = array_merge($site,$moduleValues['skinFunctions']['var']);
	
	$moduleValues['skinFunctions']['loop']['siteFields'] = $siteFields;
	
	// Footer
	$footer = $db->fetchrownamed('select * from mod_wysiwyg where name="Footer"');
		
	$moduleValues['skinFunctions']['var']['footer'] = htmlspecialchars($footer['html']); 
	
}

?>