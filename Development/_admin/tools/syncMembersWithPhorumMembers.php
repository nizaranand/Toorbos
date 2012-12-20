<?
require_once(".citadel.config.conf");

$members = $__APPLICATION_['database']->fetcharray('select * from mod_member');

foreach( $members as $key=>$value ){
	// check if user exists in the database
	if( !$__APPLICATION_['database']->fetchrownamed('select * from phorum_users where username="'.$value['username'].'"') ){
		// if not exists then insert into the database
		$__APPLICATION_['database']->__runquery_('insert into phorum_users( username,password,password_temp,email,email_temp,active ) values ( "'.$value['username'].'","'.md5($value['password']).'","'.md5($value['password']).'","'.$value['email'].'","'.$value['email'].'",1)');
	}
}

?>