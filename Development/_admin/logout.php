<?
require_once("../config/.citadel.config.conf");
//$__APPLICATION_['session'] = new expertSession();
	// killSession
$__APPLICATION_['session'] = new expertSession();
$__APPLICATION_['session']->user->setUserDetail();
$__APPLICATION_['session']->user->setState(0);
$__APPLICATION_['session']->saveUser();
//var_dump($GLOBALS);
header('Location: ../_admin');
?>
