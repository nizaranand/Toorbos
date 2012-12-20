<?
require_once(".citadel.config.conf");

$db = $__APPLICATION_['database'];
$db->__runquery_('alter table sys_module add sys_quicklink int(1) not null default 0');

?>