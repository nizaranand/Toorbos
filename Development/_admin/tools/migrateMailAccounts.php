<?
require_once(".citadel.config.conf");

$db = $__APPLICATION_['database'];
$db->__selectDB_('mail');


// get all the user accounts
$query = 'select * from users';
$accounts = $db->fetcharray($query);

$domains = array();

foreach( $accounts as $key=>$value ){
	
	$splitDomain = split('@',$value['email']);
	$domain = $splitDomain[1];
	$user = $splitDomain[0];
	
	$query = 'insert into mailbox values("'.$value['email'].'","'.$value['password'].'","'.$value['email'].'","'.$value['email'].'/",0,"'.$user.'","'.$domain.'",now(),now(),1);';
	
	echo $query."";
	
	if( !in_array($domain,$domains) ){
		array_push($domains,$domain);
	}
	
//	$db->__runquery_($query);
	
//	$db->__runquery_($query);
}

foreach( $domains as $key=>$value ){
	$query = 'insert into alias values("abuse@'.$value.'","info@rightbrain.co.za","'.$value.'",now(),now(),1);';
	
	echo $query."";
	
	$query = 'insert into alias values("webmaster@'.$value.'","info@rightbrain.co.za","'.$value.'",now(),now(),1);';
	
	echo $query."";
	
	$query = 'insert into alias values("postmaster@'.$value.'","info@rightbrain.co.za","'.$value.'",now(),now(),1);';
	
	echo $query."";
	
	$query = 'insert into alias values("hostmaster@'.$value.'","info@rightbrain.co.za","'.$value.'",now(),now(),1);';
	
	echo $query."";
	
}

?>