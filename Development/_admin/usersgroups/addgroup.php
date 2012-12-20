<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'usersgroups','section'=>'addgroup')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* get all groups */
if( !($groupDetail = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','GQGetGroups',array()) ) ){
	//echo "couldn't get groups";
}

/* create replacement value */
//$__APPLICATION_['channel']->replace('<var:group>',$groupsOutput);


/* show channel */
$__APPLICATION_['channel']->show();
?>
