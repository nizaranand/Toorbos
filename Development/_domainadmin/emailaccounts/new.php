<?
/**
 * Controls domains and email accounts
 */
require_once("../../config/.citadel.config.conf");
include_once($__CONFIG_['__paths_']['__libPath_'].'/xmlrpc.php');
$__APPLICATION_['channel'] = new channel();
/* do permissions check */
$__APPLICATION_['session'] = new domainManagerSession();

$pageSkin = new template();

$pageSkin->get($__CONFIG_['__paths_']['__skinsPath_'].'/emailaccounts/new.tpl');

$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';
$username = isSet($_REQUEST['username']) && $_REQUEST['username']!='' ? $_REQUEST['username'] : '';
$password = isSet($_REQUEST['password']) && $_REQUEST['password']!='' ? $_REQUEST['password'] : '';
$sys_emailaccount_id = isSet($_REQUEST['sys_emailaccount_id']) && $_REQUEST['sys_emailaccount_id']!='' ? $_REQUEST['sys_emailaccount_id'] : 0;
$confirmPassword = isSet($_REQUEST['confirmPassword']) && $_REQUEST['confirmPassword']!='' ? $_REQUEST['confirmPassword'] : '';

// get the site content id
$mod_site_id = $__APPLICATION_['database']->fetchrownamed('select mod_site.name, mod_site_id from mod_site, sys_tree, sys_module where sys_module.tableName="site" and sys_tree.sys_module_id=sys_module.sys_module_id and mod_site.mod_site_id=sys_tree.mod_content_id');
$site_name = $mod_site_id['name'];
$mod_site_id = $mod_site_id['mod_site_id'];

if( $cmd=='new' || $cmd=='update' ){
	if( $password!=$confirmPassword ){
	  // message
	  $message = "Passwords don't match!";
	}else{
	  $query = $cmd=='new' ? 'insert into sys_emailaccount( username, password, sys_site_id) values ( "'.$username.'@'.$site_name.'", "'.$password.'", "'.$mod_site_id.'")' : 'insert into sys_emailaccount( username, password, sys_site_id) values ( "'.$username.'", "'.$password.'", "'.$mod_site_id.'") ';

      $result = XMLRPC_request($__CONFIG_['__rpcServerURL_'], $__CONFIG_['__rpcServerDir_'], 'FiberAuthenticationHandler.authenticate', array(XMLRPC_prepare($__APPLICATION_['session']->user->userDetail['sys']['username']),XMLRPC_prepare($__APPLICATION_['session']->user->userDetail['sys']['password']),XMLRPC_prepare($__CONFIG_['__db_']['__dbDatabase_'])));
      $uniqueID = $result[1];
	  	  
	  $result = XMLRPC_request($__CONFIG_['__rpcServerURL_'], $__CONFIG_['__rpcServerDir_'], 'FiberControlPanelHandler.addDomain', array(XMLRPC_prepare($site_name),XMLRPC_prepare($uniqueID)));
      
      $result = XMLRPC_request($__CONFIG_['__rpcServerURL_'], $__CONFIG_['__rpcServerDir_'], 'FiberControlPanelHandler.addDomainUser', array(XMLRPC_prepare($site_name),XMLRPC_prepare($username),XMLRPC_prepare($password),XMLRPC_prepare($uniqueID)));  

	  if( !$__APPLICATION_['database']->fetchrownamed('select * from sys_emailaccount where username="'.$username.'@'.$site_name.'"') && $__APPLICATION_['database']->__runquery_($query) ){
  	    $message = "New account created!";
        echo '
            <script language="javascript">' .
            		'
               if( window.top ){
               	  window.top.hideEditScreen();

                  window.top.loadContent("'.($newOne? $sys_parent_id : $sys_tree_id).'","'.$iconTreeURL.'");
                  //window.opener.location.href = href[0];
               }
            </script>
        ';
	  }else{
   	    $message = "E-mail account exists!";
	  }
	  $cmd = $cmd=='news' ? 'update' : $cmd;
	}
}

if( isSet($sys_emailaccount_id) && $sys_emailaccount_id!=0 ){
  $email_account = $__APPLICATION_['database']->fetchrownamed('select * from sys_emailaccount where sys_emailaccount_id='.$sys_emailaccount_id);
}else{
  $email_account = array();
  $email_account['username'] = '';
  $email_account['password'] = '';
  $email_account['sys_emailaccount_id'] = 0;
}

$pageSkin->replace('<var:username>',$email_account['username']);
$pageSkin->replace('<var:password>',$email_account['password']);
$pageSkin->replace('<var:sys_emailaccount_id>',$email_account['sys_emailaccount_id']);
$pageSkin->replace('<var:msg>',$message);
$pageSkin->replace('<var:site_name>',$site_name);
$pageSkin->replace('<var:title>','Fiber Domain Manager - Add E-Mail account');
$pageSkin->replace('<var:baseURL>',$__APPLICATION_['channel']->getBaseURL());
$pageSkin->replace('<var:adminPath>',$__CONFIG_['__paths_']['__adminDirectory_']);

echo $pageSkin->output();
?>