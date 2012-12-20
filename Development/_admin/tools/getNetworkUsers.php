<?
// get all vars
require_once(".citadel.config.conf");

print_r('select mod_person_id,name from mod_person where mod_person_id in(select person from mod_messageThreadMember where messageThread in (select messageThread from mod_messageThreadMember where person = '.$GLOBALS['siteSession']->user->userDetail['sys']['mod_person_id'].'))');

var_dump($items);exit;
foreach ($items as $key=>$value) {
		echo $value['name'].'|'.$value['mod_'.$tableName.'_id']."\n";
}

?>
