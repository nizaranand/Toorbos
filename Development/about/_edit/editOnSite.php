<?
require_once ("../config/.citadel.config.conf");

$__APPLICATION_['channel'] = new channel(array ('in' => array ('path' => 'sites', 'section' => 'editcontent', 'skin' => 'editContent.tpl')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

$sys_tree_id = $GLOBALS['_REQUEST']['sys_tree_id'];

$pagePath = $__APPLICATION_['utilities']->generatePagePath($sys_tree_id);
$pagePath = str_replace($__CONFIG_['__paths_']['__clientPath_'],'',$pagePath);
$pagePath = str_replace($__CONFIG_['__paths_']['__httpPath_'],'',$pagePath);
$pagePath = $__CONFIG_['__paths_']['__urlPath_'].$path;

echo '
	        <script language="javascript">
	             window.parent.location.href="http://'.$__CONFIG_['__paths_']['__hostName_'].$pagePath.'?editMode=1";
	        </script>
	    ';
die;
?>
