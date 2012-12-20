<?
require_once("../config/.citadel.config.conf");
$__APPLICATION_['session'] = new domainManagerSession();
$__APPLICATION_['session']->user->setState(0);
$__APPLICATION_['session']->saveUser();
header('Location: ../_domainadmin');
?>
