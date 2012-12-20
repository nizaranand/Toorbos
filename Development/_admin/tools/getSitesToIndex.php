<?
require_once(".citadel.config.conf");
	$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'sites','section'=>'fileManager','skin'=>'fileManagerMain.tpl')));
    $databases = $__APPLICATION_['database']->fetcharray('show databases');
    $clients = array();
    foreach( $databases as $key=>$value ){
            $__APPLICATION_['database']->__selectDB_($value['Database']);
            if( $clientDetails = $__APPLICATION_['database']->fetchrownamed("select * from mod_client") ){
            	$siteDetails = $__APPLICATION_['database']->fetchrownamed("select * from mod_site");
				if( $siteDetails['indexSite']=='yes' ){
/*   					$host = $siteDetails['name'].'/_admin/tools/indexSite.php';
   					$query = '';
   
					$path=explode('/',$host);
   					$host=$path[0];
   					unset($path[0]);
   					$path='/'.(implode('/',$path));
   					$post="POST $path HTTP/1.1\r\nHost: $host\r\nContent-type: application/x-www-form-urlencoded\r\n${others}User-Agent: Mozilla 4.0\r\nContent-length: ".strlen($query)."\r\nConnection: close\r\n\r\n$query";
   					$h=fsockopen($host,80);
   					fwrite($h,$post);
   					for($a=0,$r='';!$a;){
       					$b=fread($h,8192);
       					$r.=$b;
       					$a=(($b=='')?1:0);
       					echo $r;
   					}
   					fclose($h);	*/			
					exec('php '.$__CONFIG_['__paths_']['__installationPath_'].'/clients/'.$siteDetails['databaseName'].'Client/'.$siteDetails['databaseName'].'/_admin/tools/indexSiteCurlSitemap.php');
					sleep(0.01);
				}
            }
            $clients[$key] = $clientDetails['name'];
    }
?>
