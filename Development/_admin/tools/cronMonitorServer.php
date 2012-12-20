<?
require_once (".citadel.config.conf");
include_once ($__CONFIG_ ['__paths_'] ['__installationPath_'] . '/lib/xmlrpc.php');

$db = $GLOBALS ['__APPLICATION_'] ['database'];
$freeSpace = '';
$freeMemmory = '';
$numberOfFiles = '';

$result = XMLRPC_request ( "digichemplus.com:8080", "/xmlrpc", 'FiberAuthenticationHandler.authenticate', array (XMLRPC_prepare ( "vertex" ), XMLRPC_prepare ( "souix01" ), XMLRPC_prepare ( "cwc" ) ) );
if( is_array($result[1]) ){
	mail('mare@rightbrain.co.za,larry@cwc.com.au,andrew@cwc.com.au','Error on digichemplus server','error on digichemplus server, settings wont write out',"From: RightBrain Server <server@rightbrain.co.za>");
        mail("+258840777784.dptt12@ttsms.com.au", "", 'Error on digichemplus server, can\'t connect to system monitor, settings won\'t write out', "application@digichemplus.com");
        //mail("+61414932265.dptt12@ttsms.com.au", "", 'Error on digichemplus server, can\'t connect to system monitor, settings wont write out', "application@digichemplus.com");
       //mail("+61402813320.dptt12@ttsms.com.au", "", 'Error on digichemplus server, can\'t connect to system monitor, settings wont write out', "application@digichemplus.com");
        
    echo "Exiting";
}else{

$uniqueID = $result [1];

$result = XMLRPC_request ( "digichemplus.com:8080", "/xmlrpc", 'SystemMonitor.getFreeSpace', array (XMLRPC_prepare ( $uniqueID ) ) );


if( eregi ( "Error", $result [1] )){
	mail('mare@rightbrain.co.za,larry@cwc.com.au,andrew@cwc.com.au','Error on digichemplus server','error on digichemplus server',"From: RightBrain Server <server@rightbrain.co.za>");
	mail("+258840777784.dptt12@ttsms.com.au", "", 'Error on digichemplus server, can\'t connect to system monitor', "application@digichemplus.com");	
	//mail("+61414932265.dptt12@ttsms.com.au", "", 'Error on digichemplus server, can\'t connect to system monitor', "application@digichemplus.com");
	//mail("+61402813320.dptt12@ttsms.com.au", "", 'Error on digichemplus server, can\'t connect to system monitor', "application@digichemplus.com");
}else{
	if( ($result[1]/1000) < 10 ){
		mail('mare@rightbrain.co.za,larry@cwc.com.au,andrew@cwc.com.au','Server space less than 10 on digichemplus.com','Server space is: '.($result[1]/1000) ,"From: RightBrain Server <server@rightbrain.co.za>");
		mail("+258840777784.dptt12@ttsms.com.au", "", 'Server space less than 10 on digichemplus.com:'.($result[1]/1000), "application@digichemplus.com");	
		//mail("+61414932265.dptt12@ttsms.com.au", "", 'Server space less than 10 on digichemplus.com:'.($result[1]/1000), "application@digichemplus.com");
		//mail("+61402813320.dptt12@ttsms.com.au", "", 'Server space less than 10 on digichemplus.com:'.($result[1]/1000), "application@digichemplus.com");
	}else{
		mail('mare@rightbrain.co.za','Server space on digichemplus.com','Server space is: '.($result[1]/1000) ,"From: RightBrain Server <server@rightbrain.co.za>");
	}
}

$result = XMLRPC_request ( "digichemplus.com:8080", "/xmlrpc", 'SystemMonitor.getFreeMemory', array (XMLRPC_prepare ( $uniqueID ) ) );


if( eregi ( "Error", $result [1] )){
	mail('mare@rightbrain.co.za,larry@cwc.com.au,andrew@cwc.com.au','Error on digichemplus server','error on digichemplus server',"From: RightBrain Server <server@rightbrain.co.za>");
	mail("+258840777784.dptt12@ttsms.com.au", "", 'Error on digichemplus server, can\'t connect to system monitor', "application@digichemplus.com");	
	//mail("+61414932265.dptt12@ttsms.com.au", "", 'Error on digichemplus server, can\'t connect to system monitor', "application@digichemplus.com");
	//mail("+61402813320.dptt12@ttsms.com.au", "", 'Error on digichemplus server, can\'t connect to system monitor', "application@digichemplus.com");	
}else{
	if( $result[1] == 100 ){
		mail('mare@rightbrain.co.za,larry@cwc.com.au,andrew@cwc.com.au','Java server using all of the physical server memory on digichemplus.com','Server memmory usage is: '.($result[1]) ,"From: RightBrain Server <server@rightbrain.co.za>");	
		mail("+258840777784.dptt12@ttsms.com.au", "", 'Java server using all of the physical server memory on digichemplus.com', "application@digichemplus.com");	
		//mail("+61414932265.dptt12@ttsms.com.au", "", 'Java server using all of the physical server memory on digichemplus.com', "application@digichemplus.com");
		//mail("+61402813320.dptt12@ttsms.com.au", "", 'Java server using all of the physical server memory on digichemplus.com', "application@digichemplus.com");
	}else if($result[1]>96){
		mail('mare@rightbrain.co.za','Server memmory on digichemplus.com','Server memmory is: '.($result[1]) ,"From: RightBrain Server <server@rightbrain.co.za>");
	}
}

$result = XMLRPC_request ( "digichemplus.com:8080", "/xmlrpc", 'SystemMonitor.getNumberOfFiles', array (XMLRPC_prepare ( "/export/data/data" ),XMLRPC_prepare ( $uniqueID ) ) );


if( eregi ( "Error", $result [1] )){
	mail('mare@rightbrain.co.za,larry@cwc.com.au,andrew@cwc.com.au','Error on digichemplus server','error on digichemplus server',"From: RightBrain Server <server@rightbrain.co.za>");
	mail("+258840777784.dptt12@ttsms.com.au", "", 'Error on digichemplus server, can\'t connect to system monitor', "application@digichemplus.com");	
	//mail("+61414932265.dptt12@ttsms.com.au", "", 'Error on digichemplus server, can\'t connect to system monitor', "application@digichemplus.com");
	//mail("+61402813320.dptt12@ttsms.com.au", "", 'Error on digichemplus server, can\'t connect to system monitor', "application@digichemplus.com");	
}else{
	if( ($result[1]) > 200 ){
		mail('mare@rightbrain.co.za,larry@cwc.com.au,andrew@cwc.com.au','More than 200 files in data dirs','More than 200 files in data dirs: '.($result[1]) ,"From: RightBrain Server <server@rightbrain.co.za>");	
		mail("+258840777784.dptt12@ttsms.com.au", "", 'More than 200 files in data dirs: '.($result[1]), "application@digichemplus.com");	
		//mail("+61414932265.dptt12@ttsms.com.au", "", 'More than 200 files in data dirs: '.($result[1]), "application@digichemplus.com");
		//mail("+61402813320.dptt12@ttsms.com.au", "", 'More than 200 files in data dirs: '.($result[1]), "application@digichemplus.com");
	}else{
		mail('mare@rightbrain.co.za','Number of files in data dir digichemplus.com:'.$result[1],'Number of files in data dir digichemplus.com:'.$result[1] ,"From: RightBrain Server <server@rightbrain.co.za>");
	}
}

}

?>
