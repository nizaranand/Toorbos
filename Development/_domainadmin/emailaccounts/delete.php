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

$pageSkin->get($__CONFIG_['__paths_']['__skinsPath_'].'/emailaccounts/delete.tpl');

$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';
$sys_emailaccount_id = isSet($_REQUEST['sys_emailaccount_id']) && $_REQUEST['sys_emailaccount_id']!='' ? $_REQUEST['sys_emailaccount_id'] : 0;

// get the site content id
$sys_emailaccount = $__APPLICATION_['database']->fetchrownamed('select * from sys_emailaccount where sys_emailaccount_id='.$sys_emailaccount_id);
$username = $sys_emailaccount['username'];
$password = $sys_emailaccount['password'];

if( $cmd=='emaildelete' ){
	  $query = 'delete from sys_emailaccount where sys_emailaccount_id='.$sys_emailaccount_id;
      $site_name = split('@',$username);
      $username = $site_name[0];
      $site_name = $site_name[1];     
      $result = XMLRPC_request($__CONFIG_['__rpcServerURL_'], $__CONFIG_['__rpcServerDir_'], 'FiberControlPanelHandler.deleteDomainUser', array(XMLRPC_prepare($site_name),XMLRPC_prepare($username),XMLRPC_prepare($password)));  

	  if( $__APPLICATION_['database']->__runquery_($query) ){
  	    $message = "E-mail account deleted!";
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
   	    $message = "E-mail account failed to delete!";
	  }
}else if($cmd == 'nodelete' ){
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
}

$pageSkin->replace('<var:username>',$username);
$pageSkin->replace('<var:sys_emailaccount_id>',$sys_emailaccount['sys_emailaccount_id']);
$pageSkin->replace('<var:msg>',$message);
$pageSkin->replace('<var:title>','Fiber Domain Manager - Delete E-Mail account');
$pageSkin->replace('<var:baseURL>',$__APPLICATION_['channel']->getBaseURL());
$pageSkin->replace('<var:adminPath>',$__CONFIG_['__paths_']['__adminDirectory_']);

echo $pageSkin->output();
?>