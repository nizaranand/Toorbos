<?
require_once(".citadel.config.conf");

$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'sites','section'=>'fileManager','skin'=>'fileManagerMain.tpl')));

$db = $__APPLICATION_['database'];
$databases = $__APPLICATION_['database']->fetcharray('show databases');
$clients = array();

foreach( $databases as $key=>$value ){
	$__APPLICATION_['database']->__selectDB_($value['Database']);

	if( $clientDetails = $__APPLICATION_['database']->fetchrownamed("select * from mod_client") ){
	
		$siteDetails = $__APPLICATION_['database']->fetchrownamed("select * from mod_site");

		$moduleDetails = $db->fetchrownamed('select * from sys_module where tableName="page"');
		$fields = $db->fetcharray('select sys_page_fields.name as fieldName,sys_page_fields.* from sys_page_fields');
			
		$pages = $db->fetcharray('select mod_page.name as pageName,sys_tree.*,mod_page.* from sys_tree,mod_page where sys_tree.sys_module_id=7 and mod_page.mod_page_id=sys_tree.mod_content_id '.($search!='' ? ' and LOWER(mod_page.name) like LOWER("%'.trim($search).'%")' : '').' order by mod_page.name'.$listQueryLmiter);
			
		$map = '<? require_once(".citadel.config.conf");';
		$map .= 'echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n <urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">"; ?>';
			
		foreach( $pages as $key=>$value ){
				
			$path = $GLOBALS['__APPLICATION_']['utilities']->generatePagePath( $value['sys_tree_id'] );
			$path = str_replace($siteDetails['clientPath'],'',$path);
			$path = str_replace('/'.$siteDetails['path'],'',$path);
			$path = eregi_replace("^/","",$path).'/';

			if( isSet($value['seoUrl']) && $value['seoUrl']!='' ) $path = '/id/'.$value['seoUrl'].'/';
			
			if( !eregi('admin/',$path) && !eregi('adminsystem/',$path) ){
				$map .= "<url>\n";
				$map .= ' <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>'.$path."</loc>\n";
				$map .= " <lastmod>".date("Y-m-d")."</lastmod>\n";
				$map .= " <changefreq>monthly</changefreq>\n";
				$map .= " <priority>0.8</priority>\n";
				$map .= "</url>\n";
			}
		}
					
		$map .= '<?'; 
				// check for overide
		$map .= 'if( is_file($GLOBALS["__CONFIG_"]["__paths_"]["__installationPath_"]."/clients/".$GLOBALS["__CONFIG_"]["__paths_"]["__clientPath_"]."/".$GLOBALS["__CONFIG_"]["__paths_"]["__httpPath_"]."/includes/generateSitemap.php") ){';
		$map .= '    include_once($GLOBALS["__CONFIG_"]["__paths_"]["__installationPath_"]."/clients/".$GLOBALS["__CONFIG_"]["__paths_"]["__clientPath_"]."/".$GLOBALS["__CONFIG_"]["__paths_"]["__httpPath_"]."/includes/generateSitemap.php");';
		$map .= '}	?> </urlset>';

		$GLOBALS['__APPLICATION_']['utilities']->writeFile($GLOBALS['__CONFIG_']['__paths_']['__installationPath_'].'/clients/'.$siteDetails['clientPath'].'/'.$siteDetails['path'].'/sitemap.php',$map);
			
		sleep(0.01);

	}

	$clients[$key] = $clientDetails['name'];
}

?>
