<?
/* get the starting point for the user from session */
require_once (".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array ('in' => array ('path' => 'sites', 'section' => 'www', 'skin' => 'blankChannel.tpl')));

$pagesRef = array();

$keyword = strtolower($_REQUEST['keyword']);
$keywords = split(' ',$keyword);
if( count($keywords)==0 ) $keywords[0] = $keyword;

$indexPath = $__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/indexes/'.$__CONFIG_['__paths_']['__httpPath_'];

$pages = array();

foreach($keywords as $key=>$value){
	if( is_file($GLOBALS['indexPath'].'/'.$value.'.php') ){
		require($GLOBALS['indexPath'].'/'.$value.'.php');
		$pages = array_merge($pages, $wordPages);
	}
}

foreach( $pages as $key=>$value ){
//	if( !isSet($pagesRef[$value['pageURL']]) ){
		echo '<p><a href="'.$value['pageURL'].'">'.$value['pageTitle'].'</a><br>'.$value['description'].'<br><a href="'.$value['pageURL'].'">'.$value['pageURL'].'</a></p>';
		$pagesRef[$value['pageURL']] = 1;
//	}
}

?>