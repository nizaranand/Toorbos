<?
require_once (".citadel.config.conf");

// get the clientpath to install
$clientName = isSet ($_REQUEST['clientName']) ? $_REQUEST['clientName'] : '';
$domain = isSet ($_REQUEST['domain']) ? $_REQUEST['domain'] : '';

if ($clientName != '') {
	
	mail("mare@rightbrain.co.za","New Fiber Install: ".$clientName,"New Fiber client install: ".$_SERVER['HTTP_HOST'],'Fiber <system@fiberplatform.com');
	
	$remoteDatabase = new database('vertex', 'S0uix!!', 'Fiber', 'www.rightbrain.co.za', 0, 'mysql');
	
	$remoteDatabase->__selectDB_('Fiber');
	
	$query = 'insert into mod_fiberInstall(name,server) values("'.$clientName.'","'.$_SERVER['HTTP_HOST'].'")';
	$remoteDatabase->__runquery_($query);
	
	// create a temporary folder under Expert install path called workspace
	echo "Creating temporary workspace: ";
	system('mkdir '.$__CONFIG_['__paths_']['__installationPath_'].'/workspace/'.$clientName);
	if (is_dir($__CONFIG_['__paths_']['__installationPath_'].'/workspace/'.$clientName)) {
		echo "<b>Sucess</b><br>";

		// load the database script and replace values
		system('cp -rf '.$__CONFIG_['__paths_']['__installationPath_'].'/workspace/default/sql.tpl '.$__CONFIG_['__paths_']['__installationPath_'].'/workspace/'.$clientName.'/.');
		// db install = 
		$dbskin = new template();
		$dbskin->get($__CONFIG_['__paths_']['__installationPath_'].'/workspace/'.$clientName.'/sql.tpl');
		$dbskin->replace('<var:clientName>', $clientName);

		echo "Creating client database file: ";
		$__APPLICATION_['utilities']->writeFile($__CONFIG_['__paths_']['__installationPath_'].'/workspace/'.$clientName.'/sql.tpl', $dbskin->output());
		if (is_file($__CONFIG_['__paths_']['__installationPath_'].'/workspace/'.$clientName.'/sql.tpl')) {

			echo "<b>Sucess</b><br>";
			echo "Ceating Database: ";
			if (!(system("mysqladmin --user='".$__CONFIG_['__db_']['__dbUsername_']."' --password='".$__CONFIG_['__db_']['__dbPassword_']."' --host='".$__CONFIG_['__db_']['__dbHost_']."' create ".$clientName) === false)) {

				echo "Creation successfull, importing Database: ";
				if (!(system("mysql --user='".$__CONFIG_['__db_']['__dbUsername_']."' --password='".$__CONFIG_['__db_']['__dbPassword_']."' --host='".$__CONFIG_['__db_']['__dbHost_']."' ".$clientName." < ".$__CONFIG_['__paths_']['__installationPath_'].'/workspace/'.$clientName.'/sql.tpl') === false)) {
					echo "<b>Sucess</b><br>";
					echo "Setting up base directories and files: ";
					// setup base for client
					if (!is_dir($__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client')) {
						/* create dir */
						mkdir($__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client', 0777);
						/* create skins dir for shared files across sites*/
						mkdir($__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client'.'/skins', 0777);
						/* create skins dir */
						/* create cache dir */
						/* create components dir */
						mkdir($__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client'.'/components', 0777);
						/* create controls dir */
						mkdir($__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client'.'/controls', 0777);

						/* create dir */
						mkdir($__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName, 0777);
						/* create .config dir */
						mkdir($__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName.'/.config', 0777);
						/* create images dir */
						mkdir($__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName.'/images', 0777);
						mkdir($__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName.'/web', 0777);
						mkdir($__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName.'/includes', 0777);
						mkdir($__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName.'/skins', 0777);
						/* create css dir */
						mkdir($__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName.'/css', 0777);
						/* create css dir */
						mkdir($__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName.'/swf', 0777);
						/* create documents dir */
						mkdir($__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName.'/documents', 0777);

						//create wysiwyg tmp file
						/* create dir */
						system("touch ".$__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName.'/tmp.htm');
						system("chmod 0777 ".$__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName.'/tmp.htm');

						/* load template for config file and replace values */
						$configTemplate = new template();
						$configTemplate->get($__CONFIG_['__paths_']['__componentPath_'].'/site/skins/overrideConfig.tpl');
						$configTemplate->replace('<var:siteDatabase>', $clientName);
						$configTemplate->replace('<var:siteHostname>', $_SERVER['HTTP_HOST']);
						$configTemplate->replace('<var:siteHttpPath>', $clientName);
						$configTemplate->replace('<var:siteURLPath>', '/'.$clientName.'/');
						$configTemplate->replace('<var:siteName>', $clientName);
						$configTemplate->replace('<var:siteTreeID>', 2581);
						$configTemplate->replace('<var:clientPath>', $clientName.'Client');
						$GLOBALS['__APPLICATION_']['utilities']->writeFile($__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName.'/.config/.citadel.overide.conf', $configTemplate->output());
						
						$GLOBALS['__APPLICATION_']['utilities']->writeFile($__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName.'/robots.txt', "User-agent: *\nDisallow: /_admin\nDisallow: /adminsystem\nDisallow: /admin\nDisallow: /error\nAllow: /\nSitemap: /sitemap.php");		
						
						/* link in /config/.citadel.config.conf */
						symlink($__CONFIG_['__paths_']['__installationPath_'].'/config/.citadel.config.conf', $__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName.'/.citadel.config.conf');
						/* link in _admin */
						symlink($__CONFIG_['__paths_']['__installationPath_'].'/'.$__CONFIG_['__paths_']['__adminDirectory_'], $__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName.'/'.$__CONFIG_['__paths_']['__adminDirectory_']);
						symlink($__CONFIG_['__paths_']['__installationPath_'].'/'.$__CONFIG_['__paths_']['__editDirectory_'], $__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName.'/'.$__CONFIG_['__paths_']['__editDirectory_']);
						symlink($__CONFIG_['__paths_']['__domainAdminInstallationDirectory_'].'/'.$__CONFIG_['__paths_']['__domainAdminDirectory_'], $__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName.'/'.$__CONFIG_['__paths_']['__domainAdminDirectory_']);
						/* link to httpPath */

						// copy the files
						system("cp -rf ".$__CONFIG_['__paths_']['__installationPath_'].'/workspace/default/client/* '.$__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/.');
						
						system("chmod -R 0777 ".$__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/files');
						system("chmod -R 0777 ".$__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/skins');

						echo "Linking in sites folder: ";
						if ((system("ln -s ".$__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName.' '.$__CONFIG_['__paths_']['__webServerDocumentRoot_'].'/'.$__CONFIG_['__paths_']['__domainPath_'].'/.') === false)) {
							echo "<b>Failed</b><br>"."ln -s ".$__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$clientName.'Client/'.$clientName.' '.$__CONFIG_['__paths_']['__webServerDocumentRoot_'].'/'.$__CONFIG_['__paths_']['__domainPath_'].'/.';
						}
						// link into web ro

						system("rm -rf ".$__CONFIG_['__paths_']['__installationPath_'].'/workspace/'.$clientName);

						
						if( isSet($domain) && $domain!='' ){

							echo "<b>Creating domain<br/></b>";
							include_once($paths['__libPath_'].'/xmlrpc.php');

							$result = XMLRPC_request('localhost:8080', '/xmlrpc', 'FiberAuthenticationHandler.authenticate', array(XMLRPC_prepare('mare@rightbrain.co.za'),XMLRPC_prepare('Thevertex01'),XMLRPC_prepare($GLOBALS['__CONFIG_']['__db_']['__dbDatabase_'])));
								
							$uniqueID = $result[1];
							
							$result = XMLRPC_request('localhost:8080', '/xmlrpc', 'FiberControlPanelHandler.addDomainOnlyWebFiber', array(XMLRPC_prepare($clientName),XMLRPC_prepare($clientName),XMLRPC_prepare($domain),XMLRPC_prepare($uniqueID)));
							
							Echo "<b>Domain created and linked<br/></b>";
						}
						
						echo "<b>Sucess</b><br>";
						
						header("Location:/".$clientName."/_admin/tools/creatSite.php");
					}
				} else {
					echo "<b> Faield and stopping </b><br> mysqladmin --user='".$__CONFIG_['__db_']['__dbUsername_']."' --password='".$__CONFIG_['__db_']['__dbPassword_']."' --host='".$__CONFIG_['__db_']['__dbHost_']."' create ".$clientName;
				}
			} else {
				echo "<b>Failed and stopping</b><br> mysql --user='citadel' --password='manhattan' --host='127.0.0.1' ".$clientName." < ".$__CONFIG_['__paths_']['__installationPath_'].'/workspace/'.$clientName.'/sql.tpl';
			}
		} else {
			echo "<b>Failed and stopping</b><br>";
		}
	} else {
		echo "<b>Failed and stopping</b><br>";
	}
}
?>

