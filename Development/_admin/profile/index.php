<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'profile','section'=>'main')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$sys_user_id = $__APPLICATION_['session']->user->userDetail['sys']['sys_user_id'];
$sys_group_id = isSet($_REQUEST['sys_group_id']) && $_REQUEST['sys_group_id']!='' ? $_REQUEST['sys_group_id'] : '';
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';
$username = isSet($_REQUEST['username']) && $_REQUEST['username']!='' ? $_REQUEST['username'] : '';
$password = isSet($_REQUEST['password']) && $_REQUEST['password']!='' ? $_REQUEST['password'] : '';
$firstname = isSet($_REQUEST['firstname']) && $_REQUEST['firstname']!='' ? $_REQUEST['firstname'] : '';
$surname = isSet($_REQUEST['surname']) && $_REQUEST['surname']!='' ? $_REQUEST['surname'] : '';
$email = isSet($_REQUEST['email']) && $_REQUEST['email']!='' ? $_REQUEST['email'] : '';
$start_tree_id = isSet($_REQUEST['start_tree_id']) && $_REQUEST['start_tree_id']!='' ? $_REQUEST['start_tree_id'] : '';

/* handle commands */
switch( $cmd ){
	case 'update':
    	/* update user */
    	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','UQUpdateUser',array('username'=>$username,'password'=>$password,'firstname'=>$firstname,'surname'=>$surname,'email'=>$email,'sys_user_id'=>$sys_user_id));
	break;
}

/* check for new or exisitng group */
if( $sys_user_id != 0 ){
	/* get group details */
	if( !($userDetail = $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','UQGetUserDetail',array('sys_user_id'=>$sys_user_id)) ) ){
		$cmd = 'notfound';
	}else{
		$cmd = 'update';
	}
}

/* get commands */
$commands = array();
if( $cmd!='new' ){
    array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('edituserperms',array('sys_user_id'=>$userDetail['sys_user_id']))));
}else{
	array_push($commands,array('output'=>''));
}

/* create replace values by default */
$username = isSet($userDetail) ? $userDetail['username'] : '';
$password = isSet($userDetail) ? $userDetail['password'] : '';
$firstname = isSet($userDetail) ? $userDetail['firstname'] : '';
$surname = isSet($userDetail) ? $userDetail['surname'] : '';
$email = isSet($userDetail) ? $userDetail['email'] : '';
$start_tree_id = isSet($userDetail) ? $userDetail['start_tree_id'] : '';

/* do controls */
$username = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$username,'fieldName'=>'username','displayName'=>'Username')),'admin');
$username = $username->output();
$password = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$password,'fieldName'=>'password','displayName'=>'Password')),'admin');
$password = $password->output();
$firstname = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$firstname,'fieldName'=>'firstname','displayName'=>'Name')),'admin');
$firstname = $firstname->output();
$surname = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$surname,'fieldName'=>'surname','displayName'=>'Surname')),'admin');
$surname = $surname->output();
$email = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$email,'fieldName'=>'email','displayName'=>'E-Mail')),'admin');
$email = $email->output();
$start_tree_id = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$start_tree_id,'fieldName'=>'start_tree_id','displayName'=>'Tree Starting Point')),'admin');
$start_tree_id = $start_tree_id->output();


/* replace values */
/* replace commands */
$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);
$__APPLICATION_['channel']->replace('<var:cmd>',$cmd);
$__APPLICATION_['channel']->replace('<var:sys_user_id>',$sys_user_id);
$__APPLICATION_['channel']->replace('<var:sys_group_id>',$sys_group_id);
$__APPLICATION_['channel']->replace('<var:username>',$username);
$__APPLICATION_['channel']->replace('<var:password>',$password);
$__APPLICATION_['channel']->replace('<var:firstname>',$firstname);
$__APPLICATION_['channel']->replace('<var:surname>',$surname);
$__APPLICATION_['channel']->replace('<var:email>',$email);
$__APPLICATION_['channel']->replace('<var:start_tree_id>',$start_tree_id);

/* show channel */
$__APPLICATION_['channel']->show();
?>
