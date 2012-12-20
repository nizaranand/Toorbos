<?
require_once(".citadel.config.conf");
   system('mysql --user=\'root\' --database=\''.$__CONFIG_['__db_']['__dbDatabase_'].'\' < '.$__CONFIG_['__paths_']['__installationPath_'].'/sql/demosite.sql');
   header("Location: /_admin/tools/creatSite.php");
?>
