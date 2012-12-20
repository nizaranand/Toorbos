<?
require_once("../config/.citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array ('in' => array ('path' => 'sites', 'section' => 'www')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

if( $__APPLICATION_['session']->user->getState()==2 ){
	header('Location: ../?editMode=1');
	die;
}

/* show channel */
$__APPLICATION_['channel']->show();
?>