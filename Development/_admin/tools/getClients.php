<?
    require_once(".citadel.config.conf");
    $databases = $__APPLICATION_['database']->fetcharray('show databases');
    echo "<ol>";
    $clients = array();
    foreach( $databases as $key=>$value ){
            $__APPLICATION_['database']->__selectDB_($value['Database']);
            if( $clientDetails = $__APPLICATION_['database']->fetchrownamed("select * from mod_client") ){
                if( !in_array($clientDetails['name'],$clients) ){
                    echo '<li>'.$clientDetails['name'].'</li>';
                }
            }
            $clients[$key] = $clientDetails['name'];
    }
    echo "</ol>";
    
?>
