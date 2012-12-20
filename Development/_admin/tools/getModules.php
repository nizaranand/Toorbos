<?
    require_once(".citadel.config.conf");
    $databases = $__APPLICATION_['database']->fetcharray('show databases');
    echo "<ol>";
    $modules = array();
    foreach( $databases as $key=>$value ){
            $__APPLICATION_['database']->__selectDB_($value['Database']);
             if( $moduleDetails = $__APPLICATION_['database']->fetcharray("select * from sys_module") ){
             	foreach( $moduleDetails as $moduleKey=>$moduleValue ){
    	            if( !in_array($moduleValue['name'],$modules) ){
	                    echo '<li>'.$moduleValue['name'].'</li>';
	                    echo '<ol>';
						if( $fields = $__APPLICATION_['database']->fetcharray("select * from sys_".$moduleValue['tableName'].'_fields') ){
             				foreach( $fields as $fieldsKey=>$fieldsValue ){
             					echo '<li>'.$fieldsValue['name'].'</li>';
             				}
						}
					    echo "</ol>";
                	}
                    array_push($modules,$moduleValue['name']);
             	}
            }
    }
    echo "</ol>";
    
?>
