<?

// get all modules with the control for document protection
$modules = $db->fetcharray('select * from sys_module');

foreach( $modules as $key=>$value ){
	if( $fields = $db->fetcharray('select * from sys_'.$value['tableName'].'_fields where controlValues like "%passwordProtect=yes%"') ){
		foreach( $fields as $fieldKey=>$fieldValueValue ){
			$fieldValue = $fieldValueValue['fieldValue'];
			parse_str($fieldValueValue['controlValues']);
			if( isSet($passwordProtect) && $passwordProtect=='yes'){

				// check for paths
				if( strstr($fieldValue,'/') ){
					$pathsD = split('/',$fieldValue);
					$documentName = array_pop($pathsD);
					$documentPath = implode('/',$pathsD).'/';
				}else{
					$documentName = $fieldValue;
					$documentPath = '';
				}

				// string to add
				$protectString = "AuthName \"Restricted File\nAuthType Basic\nAuthUserFile ".$paths['__installationPath_'].'/clients/'.$paths['__httpPath_'].'Client/'.$paths['__httpPath_']."/documents/.htpasswd\nAuthGroupFile /dev/null\n";

				$documentProtection = "\n<Files \"".$documentName."\">\nrequire valid-user\n</Files>";

				// check for existing .htaccess file
				if( is_file($paths['__installationPath_'].'/clients/'.$paths['__httpPath_'].'Client/'.$paths['__httpPath_'].'/documents/'.$documentPath.'.htaccess') ){
					// get the contents
					$htaccessContents = $GLOBALS['__APPLICATION_']['utilities']->getFile($paths['__installationPath_'].'/clients/'.$paths['__httpPath_'].'Client/'.$paths['__httpPath_'].'/documents/'.$documentPath.'.htaccess');
					$htaccess = file($paths['__installationPath_'].'/clients/'.$paths['__httpPath_'].'Client/'.$paths['__httpPath_'].'/documents/'.$documentPath.'.htaccess');
					if( !eregi($protectString,$htaccessContents) ){
						array_push($htaccess,$protectString);
					}
					if( !eregi($documentProtection,$htaccessContents) ){
						array_push($htaccess,$documentProtection);
					}
					unlink($paths['__installationPath_'].'/clients/'.$paths['__httpPath_'].'Client/'.$paths['__httpPath_'].'/documents/'.$documentPath.'.htaccess');
					$htaccess = implode("",$htaccess);
				}else{
					$htaccess = $protectString.$documentProtection;
				}


				// overwrite password file
				if( isSet($userModule) && $userModule!='' ){
					// get all users
					$users = $db->fetcharray('select * from '.$userModule);
					$passwordFile = '';
					foreach( $users as $key=>$value ){
						$passwordFile .= $value['username'].':'.crypt($value['password'])."\n";
					}
					$GLOBALS['__APPLICATION_']['utilities']->writeFile($paths['__installationPath_'].'/clients/'.$paths['__httpPath_'].'Client/'.$paths['__httpPath_'].'/documents/.htpasswd',$passwordFile);
				}else{
					$GLOBALS['__APPLICATION_']['utilities']->writeFile($paths['__installationPath_'].'/clients/'.$paths['__httpPath_'].'Client/'.$paths['__httpPath_'].'/documents/.htpasswd',$documentUser.':'.crypt($documentPassword));
				}

				$GLOBALS['__APPLICATION_']['utilities']->writeFile($paths['__installationPath_'].'/clients/'.$paths['__httpPath_'].'Client/'.$paths['__httpPath_'].'/documents/'.$documentPath.'.htaccess',$htaccess);

			}
		}
	}
}

?>