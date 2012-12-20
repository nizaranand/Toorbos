<?
/**
 * Controls domains and email accounts
 */
require_once("../../config/.citadel.config.conf");
$__APPLICATION_['channel'] = new channel();
/* do permissions check */
$__APPLICATION_['session'] = new domainManagerSession();

$cmd = $__APPLICATION_['url']->getRequestVar('cmd');

$pageSkin = new template();

$pageSkin->get($__CONFIG_['__paths_']['__skinsPath_'].'/emailaccounts/index.tpl');

// get the site content id
$mod_site_id = $__APPLICATION_['database']->fetchrownamed('select mod_site.name, mod_site_id from mod_site, sys_tree, sys_module where sys_module.tableName="site" and sys_tree.sys_module_id=sys_module.sys_module_id and mod_site.mod_site_id=sys_tree.mod_content_id');
$site_name = $mod_site_id['name'];
$mod_site_id = $mod_site_id['mod_site_id'];
$pageSkin->replace('<var:site_name>',$site_name);


if( $cmd=='createDomain' ){
	  include_once($__CONFIG_['__paths_']['__libPath_'].'/xmlrpc.php');
	  
      $result = XMLRPC_request($__CONFIG_['__rpcServerURL_'], $__CONFIG_['__rpcServerDir_'], 'FiberAuthenticationHandler.authenticate', array(XMLRPC_prepare($__APPLICATION_['session']->user->userDetail['sys']['username']),XMLRPC_prepare($__APPLICATION_['session']->user->userDetail['sys']['password']),XMLRPC_prepare($__CONFIG_['__db_']['__dbDatabase_'])));
            
      $uniqueID = $result[1];
	  	        
	  $result = XMLRPC_request($__CONFIG_['__rpcServerURL_'], $__CONFIG_['__rpcServerDir_'], 'FiberControlPanelHandler.addDomainOnlyWeb', array(XMLRPC_prepare($site_name),XMLRPC_prepare($uniqueID)));
	  
	  print_r($result);die;
      	
}

// get all e-mail accounts
$email_accounts = array();
$email_accounts = $__APPLICATION_['database']->fetcharray('select * from sys_emailaccount where sys_site_id='.$mod_site_id);

$pageSkin->replaceLoop('emailaccounts',$email_accounts);
$__APPLICATION_['channel']->channelReplace('<var:body>',$pageSkin->output());
$__APPLICATION_['channel']->channelReplace('<var:title>',"Domains");

/* show channel */
$__APPLICATION_['channel']->show();

?>