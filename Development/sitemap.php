<? require_once(".citadel.config.conf");echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n <urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">"; ?><? 
					if( isSet($GLOBALS['__CONFIG_']['mod_siteReference_id'] )){
						$db = $GLOBALS['__APPLICATION_']['database'];
						// check for overiding configuration
						$query = 'select * from mod_customSiteContent where moduleType="page" and contentId=114 and site='.$GLOBALS['__CONFIG_']['mod_siteReference_id'];
						if( $pageOverides = $db->fetcharray($query) ){
							foreach( $pageOverides as $oKey=>$oValue ){
								$value[$oValue['contentName']] = $oValue['contentValue'];
							}
							if( $value['published'] == '1' ){?>
							<url>
							 <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>/about/</loc>
							 <lastmod>2012-12-06</lastmod>
							 <changefreq>monthly</changefreq>
							 <priority>0.8</priority>
							</url>
							<?}
						}else{?>
							<url>
							 <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>/about/</loc>
							 <lastmod>2012-12-06</lastmod>
							 <changefreq>monthly</changefreq>
							 <priority>0.8</priority>
							</url>		
						<?}?>
					  <?}else{?>
							<url>
							 <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>/about/</loc>
							 <lastmod>2012-12-06</lastmod>
							 <changefreq>monthly</changefreq>
							 <priority>0.8</priority>
							</url>	
					  <?}?><? 
					if( isSet($GLOBALS['__CONFIG_']['mod_siteReference_id'] )){
						$db = $GLOBALS['__APPLICATION_']['database'];
						// check for overiding configuration
						$query = 'select * from mod_customSiteContent where moduleType="page" and contentId=110 and site='.$GLOBALS['__CONFIG_']['mod_siteReference_id'];
						if( $pageOverides = $db->fetcharray($query) ){
							foreach( $pageOverides as $oKey=>$oValue ){
								$value[$oValue['contentName']] = $oValue['contentValue'];
							}
							if( $value['published'] == '1' ){?>
							<url>
							 <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>/contactus/</loc>
							 <lastmod>2012-12-06</lastmod>
							 <changefreq>monthly</changefreq>
							 <priority>0.8</priority>
							</url>
							<?}
						}else{?>
							<url>
							 <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>/contactus/</loc>
							 <lastmod>2012-12-06</lastmod>
							 <changefreq>monthly</changefreq>
							 <priority>0.8</priority>
							</url>		
						<?}?>
					  <?}else{?>
							<url>
							 <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>/contactus/</loc>
							 <lastmod>2012-12-06</lastmod>
							 <changefreq>monthly</changefreq>
							 <priority>0.8</priority>
							</url>	
					  <?}?><? 
					if( isSet($GLOBALS['__CONFIG_']['mod_siteReference_id'] )){
						$db = $GLOBALS['__APPLICATION_']['database'];
						// check for overiding configuration
						$query = 'select * from mod_customSiteContent where moduleType="page" and contentId=124 and site='.$GLOBALS['__CONFIG_']['mod_siteReference_id'];
						if( $pageOverides = $db->fetcharray($query) ){
							foreach( $pageOverides as $oKey=>$oValue ){
								$value[$oValue['contentName']] = $oValue['contentValue'];
							}
							if( $value['published'] == '1' ){?>
							<url>
							 <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>/error/</loc>
							 <lastmod>2012-12-06</lastmod>
							 <changefreq>monthly</changefreq>
							 <priority>0.8</priority>
							</url>
							<?}
						}else{?>
							<url>
							 <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>/error/</loc>
							 <lastmod>2012-12-06</lastmod>
							 <changefreq>monthly</changefreq>
							 <priority>0.8</priority>
							</url>		
						<?}?>
					  <?}else{?>
							<url>
							 <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>/error/</loc>
							 <lastmod>2012-12-06</lastmod>
							 <changefreq>monthly</changefreq>
							 <priority>0.8</priority>
							</url>	
					  <?}?><? 
					if( isSet($GLOBALS['__CONFIG_']['mod_siteReference_id'] )){
						$db = $GLOBALS['__APPLICATION_']['database'];
						// check for overiding configuration
						$query = 'select * from mod_customSiteContent where moduleType="page" and contentId=125 and site='.$GLOBALS['__CONFIG_']['mod_siteReference_id'];
						if( $pageOverides = $db->fetcharray($query) ){
							foreach( $pageOverides as $oKey=>$oValue ){
								$value[$oValue['contentName']] = $oValue['contentValue'];
							}
							if( $value['published'] == '1' ){?>
							<url>
							 <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>/error/fileNotFound/</loc>
							 <lastmod>2012-12-06</lastmod>
							 <changefreq>monthly</changefreq>
							 <priority>0.8</priority>
							</url>
							<?}
						}else{?>
							<url>
							 <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>/error/fileNotFound/</loc>
							 <lastmod>2012-12-06</lastmod>
							 <changefreq>monthly</changefreq>
							 <priority>0.8</priority>
							</url>		
						<?}?>
					  <?}else{?>
							<url>
							 <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>/error/fileNotFound/</loc>
							 <lastmod>2012-12-06</lastmod>
							 <changefreq>monthly</changefreq>
							 <priority>0.8</priority>
							</url>	
					  <?}?><? 
					if( isSet($GLOBALS['__CONFIG_']['mod_siteReference_id'] )){
						$db = $GLOBALS['__APPLICATION_']['database'];
						// check for overiding configuration
						$query = 'select * from mod_customSiteContent where moduleType="page" and contentId=1 and site='.$GLOBALS['__CONFIG_']['mod_siteReference_id'];
						if( $pageOverides = $db->fetcharray($query) ){
							foreach( $pageOverides as $oKey=>$oValue ){
								$value[$oValue['contentName']] = $oValue['contentValue'];
							}
							if( $value['published'] == '1' ){?>
							<url>
							 <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>/toorbos/</loc>
							 <lastmod>2012-12-06</lastmod>
							 <changefreq>monthly</changefreq>
							 <priority>0.8</priority>
							</url>
							<?}
						}else{?>
							<url>
							 <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>/toorbos/</loc>
							 <lastmod>2012-12-06</lastmod>
							 <changefreq>monthly</changefreq>
							 <priority>0.8</priority>
							</url>		
						<?}?>
					  <?}else{?>
							<url>
							 <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>/toorbos/</loc>
							 <lastmod>2012-12-06</lastmod>
							 <changefreq>monthly</changefreq>
							 <priority>0.8</priority>
							</url>	
					  <?}?><? 
					if( isSet($GLOBALS['__CONFIG_']['mod_siteReference_id'] )){
						$db = $GLOBALS['__APPLICATION_']['database'];
						// check for overiding configuration
						$query = 'select * from mod_customSiteContent where moduleType="page" and contentId=122 and site='.$GLOBALS['__CONFIG_']['mod_siteReference_id'];
						if( $pageOverides = $db->fetcharray($query) ){
							foreach( $pageOverides as $oKey=>$oValue ){
								$value[$oValue['contentName']] = $oValue['contentValue'];
							}
							if( $value['published'] == '1' ){?>
							<url>
							 <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>/services/</loc>
							 <lastmod>2012-12-06</lastmod>
							 <changefreq>monthly</changefreq>
							 <priority>0.8</priority>
							</url>
							<?}
						}else{?>
							<url>
							 <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>/services/</loc>
							 <lastmod>2012-12-06</lastmod>
							 <changefreq>monthly</changefreq>
							 <priority>0.8</priority>
							</url>		
						<?}?>
					  <?}else{?>
							<url>
							 <loc>http://<? echo $_SERVER["HTTP_HOST"]; ?>/services/</loc>
							 <lastmod>2012-12-06</lastmod>
							 <changefreq>monthly</changefreq>
							 <priority>0.8</priority>
							</url>	
					  <?}?><?if( is_file($GLOBALS["__CONFIG_"]["__paths_"]["__installationPath_"]."/clients/".$GLOBALS["__CONFIG_"]["__paths_"]["__clientPath_"]."/".$GLOBALS["__CONFIG_"]["__paths_"]["__httpPath_"]."/includes/generateSitemap.php") ){    include_once($GLOBALS["__CONFIG_"]["__paths_"]["__installationPath_"]."/clients/".$GLOBALS["__CONFIG_"]["__paths_"]["__clientPath_"]."/".$GLOBALS["__CONFIG_"]["__paths_"]["__httpPath_"]."/includes/generateSitemap.php");}	?> </urlset>