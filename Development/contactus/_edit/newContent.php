<?
require_once ("../config/.citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array ('in' => array ('path' => 'sites', 'section' => 'editcontent', 'skin' => 'newContent.tpl')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$sys_parent_id = isSet($_REQUEST['sys_parent_id']) ? $_REQUEST['sys_parent_id'] : 0;
$sys_module_id = isSet($_REQUEST['sys_module_id']) ? $_REQUEST['sys_module_id'] : 0;
$currentPath = isSet($_REQUEST['currentPath']) ? $_REQUEST['currentPath'] : '';
$sys_field_type_id = isSet($_REQUEST['sys_field_type_id']) ? $_REQUEST['sys_field_type_id'] : 1;
$cmd = isSet($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';
$iconTreeURL = isSet($_REQUEST['iconTreeURL']) ? $_REQUEST['iconTreeURL'] : '';

if( $cmd=='new' ){
	$module = new module(array('in'=>array('sys_module_id'=>$sys_module_id,'sys_parent_id'=>$sys_parent_id,'sys_field_type_id'=>$sys_field_type_id)),'add');
	if( $sys_parent_id==0 ){
        echo '
            <script language="javascript">' .
            		'
               if( window.top ){
               	  parent.$.fancybox.close();

//                  window.top.location.reload();
				  if( window.top.location.href.indexOf("?")>-1 ){
	                  window.top.location.href = window.top.location.href+"&reloaded";				  
				  }else{
	                  window.top.location.href = window.top.location.href+"?reloaded";				  
				  }
                  //window.opener.location.href = href[0];
               }
            </script>
        ';
	}else{
   	  header("Location: editContent.php?cmd=new&sys_parent_id=".$sys_parent_id."&sys_module_id=".$sys_module_id."&mod_content_id=".$module->moduleValues['sys']['mod_content_id']."&currentPath=".$currentPath."&sys_field_type_id=".$sys_field_type_id);
	}
}

/* get content options */
$module = new module(array('in'=>array('sys_module_id'=>$sys_module_id)),'admin');

/* replace values */
$__APPLICATION_['channel']->channelReplace('<var:moduleOutput>',$module->output());
$__APPLICATION_['channel']->channelReplace('<var:sys_parent_id>',$sys_parent_id);
$__APPLICATION_['channel']->channelReplace('<var:sys_module_id>',$sys_module_id);
$__APPLICATION_['channel']->channelReplace('<var:currentPath>',$currentPath);
$__APPLICATION_['channel']->channelReplace('<var:cmd>',($cmd=='' ? 'new' : $cmd));
$__APPLICATION_['channel']->channelReplace('<var:iconTreeURL>',$iconTreeURL);

/* show channel */
$__APPLICATION_['channel']->show();

?>
