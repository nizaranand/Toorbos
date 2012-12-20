<?
/* get the starting point for the user from session */
require_once (".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array ('in' => array ('path' => 'sites', 'section' => 'www', 'skin' => 'blankChannel.tpl')));

// set the starting point for the tree
$sys_tree_id = $GLOBALS['__APPLICATION_']['site_tree_id'];
$descriptionCharacters = 200;
$wordsRef = array ();
$ignoredWords = array ('and', 'or', 'if', 'this', 'there', 'them');

// get start off memmory usage
$my_pid = getmypid();
exec('ps --pid '.$my_pid.' --no-headers -o%mem,rss,pid', $output);
$mem = explode(' ', $output[0]);
$mem = $mem[2] / 1000;

// clear out folder

function cleanMe($me) {
	$me = preg_replace("/<br *\/*>/i", " ", $me); // replace <br> by one blank
	$me = preg_replace("/[\n\r\t]/", " ", $me); // remove linebreaks
	$me = preg_replace("/&nbsp;/", " ", $me); // replace 'hard-blank'
	$me = preg_replace("/<script\b[^>]*>(.*?)<\/script>/i", " ", $me);
	$me = strip_tags($me);
	return $me;
}

function checkMemmory() {
	$my_pid = getmypid();
	exec('ps --pid '.$my_pid.' --no-headers -o%mem,rss,pid', $output);
	$mem = explode(' ', $output[0]);
	$mem = $mem[2] / 1000;

	if ($mem - $GLOBALS['mem'] > 1) {
		writeOutWords();
		unset ($GLOBALS['wordsRef']);
		$GLOBALS['wordsRef'] = array ();
		return false;
	} else {
		return true;
	}

}

function writeOutWords() {
	foreach ($GLOBALS['wordsRef'] as $key => $ref) {
		// write out words
		$stringToFile = '<? $wordPages = array(';
		foreach ($ref['pages'] as $pageKey => $pageValue) {
			$stringToFile .= 'array("pageURL"=>"'.$pageValue['pageURL'].'","pageTitle"=>"'.$pageValue['pageTitle'].'","description"=>"'.str_replace('"', '\"', $pageValue['description']).'"),';
		}
		$stringToFile = eregi_replace(",$", "", $stringToFile);
		$stringToFile .= '); ?>';
		$GLOBALS['__APPLICATION_']['utilities']->writeFile($GLOBALS['indexPath'].'/'.$key.'.php', $stringToFile);
	}
}

function loadWord($word) {
	if (!isSet ($GLOBALS['wordsRef'][$word]))
	$GLOBALS['wordsRef'][$word] = array ();
	if (!isSet ($GLOBALS['wordsRef'][$word]['pages']))
	$GLOBALS['wordsRef'][$word]['pages'] = array ();
	if (is_file($GLOBALS['indexPath'].'/'.$word.'.php')) {
		require ($GLOBALS['indexPath'].'/'.$word.'.php');
		$GLOBALS['wordsRef'][$word]['pages'] = $wordPages;
		// set the pages ref
		if (!isSet ($GLOBALS['wordsRef'][$word]['pagesRef']))
		$GLOBALS['wordsRef'][$word]['pagesRef'] = array ();
			
		foreach( $GLOBALS['wordsRef'][$word]['pages'] as $key=>$value ){
			$GLOBALS['wordsRef'][$word]['pagesRef'][$value['pageURL']] = 1;
		}
	}
}

function processWord($wordArray) {
	if (!checkMemmory() || !isSet ($GLOBALS['wordsRef'][$wordArray[0]])) {
		loadWord($wordArray[0]);
	}

	// check that we don't have that in our array of pages
	if (!isSet ($GLOBALS['wordsRef'][$wordArray[0]]['pagesRef'][$wordArray['page']])) {
		if (!isSet ($GLOBALS['wordsRef'][$wordArray[0]]['pagesRef']))
		$GLOBALS['wordsRef'][$wordArray[0]]['pagesRef'] = array ();
		if (!isSet ($GLOBALS['wordsRef'][$wordArray[0]]['pages']))
		$GLOBALS['wordsRef'][$wordArray[0]]['pages'] = array ();
		$GLOBALS['wordsRef'][$wordArray[0]]['pagesRef'][$wordArray['page']] = 1;
		array_push($GLOBALS['wordsRef'][$wordArray[0]]['pages'], array ('pageURL' => $wordArray['page'], 'pageTitle' => $wordArray['title'], 'description' => $wordArray['description']));
	}

}

function processSiteMap($site){
	global $descriptionCharacters;
	global $wordsRef;
	global $ignoredWords;

	$GLOBALS['indexPath'] = $GLOBALS['__CONFIG_']['__paths_']['__installationPath_'].'/clients'.$GLOBALS['__CONFIG_']['__paths_']['__clientPath_'].'/indexes';
	if (!is_dir($GLOBALS['indexPath']))
	mkdir($GLOBALS['indexPath']);

	$GLOBALS['indexPath'] .= '/'.str_replace('.','',$site);
	if (!is_dir($GLOBALS['indexPath']))
	mkdir($GLOBALS['indexPath']);

	exec("rm -rf ".$GLOBALS['indexPath'].'/*.php');


	$options = array(
	CURLOPT_RETURNTRANSFER => true,     // return web page
	CURLOPT_HEADER         => false,    // don't return headers
	CURLOPT_FOLLOWLOCATION => true,     // follow redirects
	CURLOPT_ENCODING       => "",       // handle all encodings
	CURLOPT_USERAGENT      => "spider", // who am i
	CURLOPT_AUTOREFERER    => true,     // set referer on redirect
	CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
	CURLOPT_TIMEOUT        => 120,      // timeout on response
	CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
	);


	$ch      = curl_init( 'http://www.'.$site.'/sitemap.php' );
	echo "Retrieving: ".'http://www.'.$site.'/sitemap.php'."\n";
	curl_setopt_array( $ch, $options );
	$content = curl_exec( $ch );
	$err     = curl_errno( $ch );
	$errmsg  = curl_error( $ch );
	$header  = curl_getinfo( $ch );
	curl_close( $ch );

	$header['errno']   = $err;
	$header['errmsg']  = $errmsg;
	$header['content'] = $content;

	// get the sitemap
	$xml = new SimpleXMLElement($header['content']);

	//print_r($xml);

	foreach( $xml->url as $key=>$value ){
		$processUrl = $value->loc;
		if( strstr($processUrl,' ') ){
			$urlParts = explode('/',$processUrl);
			$urlParts[count($urlParts)-2] = urlencode($urlParts[count($urlParts)-2]);
			$processUrl = implode('/',$urlParts);
		}
		echo "Processing:".$processUrl."\n";
		$ch      = curl_init( $processUrl );
		curl_setopt_array( $ch, $options );
		$content = curl_exec( $ch );
		$err     = curl_errno( $ch );
		$errmsg  = curl_error( $ch );
		$header  = curl_getinfo( $ch );
		curl_close( $ch );

		$header['errno']   = $err;
		$header['errmsg']  = $errmsg;
		$header['content'] = $content;

		if( $err!='' ){
			echo $errmsg;
		}else{

			//echo "Content:".$content;

			preg_match('/<title>([^>]*)<\/title>/si', $content, $match );

			if (isset($match) && is_array($match) && count($match) > 0)
			{
				$title = strip_tags($match[1]);
			}
				
			$content = cleanMe($header['content']);
			$words = preg_split('/[\s,.]+/', $content, -1, PREG_SPLIT_OFFSET_CAPTURE);
			// get all the descriptions
			if (is_array($words)) {
				foreach ($words as $wordKey => $word) {
					if (trim($word[0]) != '') {
						$words[$wordKey][0] = strtolower($word[0]);
						if (strstr($words[$wordKey][0], '/'))
						str_replace('/', '', $words[$wordKey][0]);
						$startDescription = $word[1] < ($descriptionCharacters / 2) ? 0 : $word[1] - ($descriptionCharacters / 2);
						if (strlen($content) < ($startDescription + $descriptionCharacters) && $startDescription != 0) {
							$diff = ($startDescription + $descriptionCharacters) -strlen($content);
							$startDescription -= $diff;
						}
						$words[$wordKey]['description'] = substr($content, $startDescription, $descriptionCharacters);
						$words[$wordKey]['page'] = $processUrl;
						$words[$wordKey]['title'] = $title;
						processWord($words[$wordKey]);
						sleep(0.5);
					}
				}
			}
			
		}
		sleep(1);
	}
}

// get the site details
$siteDetails = $GLOBALS['__APPLICATION_']['database']->fetchrownamed('select mod_site.name,mod_site.path from mod_site, sys_tree where sys_tree_id='.$__APPLICATION_['site_tree_id'].' and mod_site.mod_site_id=sys_tree.mod_content_id');

if( $siteDetails['name']=='Default Site' ){

	$siteReferences = $GLOBALS['__APPLICATION_']['database']->fetcharray('select * from mod_siteReference');

	foreach( $siteReferences as $key=>$value ){
		echo "Doing site reference: ".$value['name']."\n";

		processSiteMap($value['name']);
		sleep(1);
	}

}else{
	processSiteMap($siteDetails['name']);
}


writeOutWords();
echo "<p>Done ... </p>";
?>
