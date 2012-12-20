<?
/* get the starting point for the user from session */
require_once (".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array ('in' => array ('path' => 'sites', 'section' => 'www', 'skin' => 'blankChannel.tpl')));

// get url
$url = $__APPLICATION_['url']->getRequestVar('url');

// determine values
$urlParts = explode('/',$url);
$baseUrl = $urlParts[2];
$baseUrlPath = str_replace('.','',$baseUrl);

if( strstr($url,' ') ){
	$urlParts = explode('/',$url);
	$urlParts[count($urlParts)-2] = urlencode($urlParts[count($urlParts)-2]);
	$url = implode('/',$urlParts);
}

mkdir($paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/'.$paths['__httpPath_'].'/files');
mkdir($paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/'.$paths['__httpPath_'].'/files/site');
mkdir($paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/'.$paths['__httpPath_'].'/files/site/'.$baseUrlPath);

if( !is_file($paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/'.$paths['__httpPath_'].'/files/site/'.$baseUrlPath.'/'.urlencode($url).'.jpg')){
	system('wkhtmltoimage --crop-w 230 --crop-h 130 --zoom 0.25 --width 100 '.$url.' '.$paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/'.$paths['__httpPath_'].'/files/site/'.$baseUrlPath.'/'.urlencode($url).'.jpg');
}

echo 'files/site/'.$baseUrlPath.'/'.urlencode($url).'.jpg';

?>
