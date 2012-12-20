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

$indexPath = $__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/indexes';
if (!is_dir($indexPath))
	mkdir($indexPath);

$indexPath .= '/'.$__CONFIG_['__paths_']['__httpPath_'];
if (!is_dir($indexPath))
	mkdir($indexPath);

// clear out folder
exec("rm -rf ".$indexPath.'/*.php');

function cleanMe($me) {
	$me = preg_replace("/<br *\/*>/i", " ", $me); // replace <br> by one blank
	$me = preg_replace("/[\n\r\t]/", " ", $me); // remove linebreaks
	$me = preg_replace("/&nbsp;/", " ", $me); // replace 'hard-blank'
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

// get the site details
$siteDetails = $GLOBALS['__APPLICATION_']['database']->fetchrownamed('select mod_site.name,mod_site.path from mod_site, sys_tree where sys_tree_id='.$__APPLICATION_['site_tree_id'].' and mod_site.mod_site_id=sys_tree.mod_content_id');
print_r($siteDetails);

$processModules = array ('container', 'wysiwyg');

// get all the pages in the system and calculate

echo "<p>Processing pages ... </p>";

$pages = $__APPLICATION_['database']->fetcharray('select mod_page.*, sys_tree.* from mod_page, sys_module, sys_tree where sys_module.name="page" and sys_tree.sys_module_id=sys_module.sys_module_id and sys_tree.mod_content_id=mod_page.mod_page_id');
foreach ($pages as $key => $value) {

	// calculate path for each page
	$pagePath = $__APPLICATION_['utilities']->generatePagePath($value['sys_tree_id']);
    echo '<p>'.$pagePath.'</p>';
//	if (strstr('/'.$siteDetails['path'].'/',$pagePath )) {

		// remove the client path
		$pagePath = eregi_replace("^/[A-zZ-a]*", "", $pagePath);
		// get the site
		$paths = explode('/', $pagePath);
		// get the site domain

		$pagePath = eregi_replace("^/[A-zZ-a]*", "", $pagePath);
		$pagePath = 'http://'.$siteDetails['name'].$pagePath;

		$pageModule = new module(array ('in' => array ('sys_tree_id' => $value['sys_tree_id'])));
		if (is_array($pageModule->moduleValues['childrenValues'])) {
			foreach ($pageModule->moduleValues['childrenValues'] as $childrenKey => $childrenValue) {
				if (in_array($childrenValue['tableName'], $processModules)) {

					echo '<p>Processing '.$childrenValue['name'].'<br>';

					$content = cleanMe($pageModule->moduleValues['children'][$childrenKey]);
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
								$words[$wordKey]['page'] = $pagePath;
								$words[$wordKey]['title'] = $pageModule->moduleValues['content']['title'];
								processWord($words[$wordKey]);
								sleep(0.001);
							}
						}
					}
				}
			}
		}
		writeOutWords();
	//}
}

// find all lists and calculate their modules cotnent using the name as the titles of the pages...
echo "<p>Processing lists ... </p>";
$lists = $__APPLICATION_['database']->fetcharray('select mod_list.*, sys_tree.* from mod_list, sys_module, sys_tree where sys_module.name="list" and sys_tree.sys_module_id=sys_module.sys_module_id and mod_list.dynamicPageURL!="" and mod_list.mod_list_id=sys_tree.mod_content_id');
foreach ($lists as $key => $value) {
	echo $value['name'].'<p>';
	echo $value['dynamicPageURL'].'<p>';
	// get module details
	$moduleDetails = $__APPLICATION_['database']->fetcharray('select mod_'.$value['tableNameRandom'].'.mod_'.$value['tableNameRandom'].'_id as mod_content_id, mod_'.$value['tableNameRandom'].'.*, sys_module.* from sys_module, mod_'.$value['tableNameRandom'].' where tableName="'.$value['tableNameRandom'].'"');
	foreach ($moduleDetails as $moduleKey => $moduleValue) {
		$listModule = new module(array ('in' => array ('sys_module_id' => $moduleValue['sys_module_id'], 'mod_content_id' => $moduleValue['mod_content_id'], 'tableName' => $moduleValue['tableName'])));
		//            echo '<p>Processing '.$childrenValue['name'].'<br>';

		$content = cleanMe($listModule->output());
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
					$words[$wordKey]['page'] = 'http://'.$siteDetails['name'].'/'.$value['dynamicPageURL'];
					
					$pageUrlTemplate = new template();
					$pageUrlTemplate->set($words[$wordKey]['page']);
					$listModule->moduleValues['skinFunctions']['var'] = array_merge($listModule->moduleValues['skinFunctions']['var'],$listModule->moduleValues['content']);
					$pageUrlTemplate->processSkinValues($listModule->moduleValues);
					$words[$wordKey]['page'] = $pageUrlTemplate->output();
										
					$words[$wordKey]['title'] = $listModule->moduleValues['content']['name'];
					processWord($words[$wordKey]);
					sleep(0.001);
				}
			}
		}
	}
}

// find all lists and calculate their modules cotnent using the name as the titles of the pages...
echo "<p>Processing randoms ... </p>";
$lists = $__APPLICATION_['database']->fetcharray('select mod_random.*, sys_tree.* from mod_random, sys_module, sys_tree where sys_module.name="random" and sys_tree.sys_module_id=sys_module.sys_module_id and mod_random.dynamicPageURL!="" and mod_random.mod_random_id=sys_tree.mod_content_id');
foreach ($lists as $key => $value) {
	// get module details
	echo $value['name'];
	$moduleDetails = $__APPLICATION_['database']->fetcharray('select mod_'.$value['tableNameRandom'].'.mod_'.$value['tableNameRandom'].'_id as mod_content_id, mod_'.$value['tableNameRandom'].'.*, sys_module.* from sys_module, mod_'.$value['tableNameRandom'].' where tableName="'.$value['tableNameRandom'].'"');
	foreach ($moduleDetails as $moduleKey => $moduleValue) {
		$randomModule = new module(array ('in' => array ('sys_module_id' => $moduleValue['sys_module_id'], 'mod_content_id' => $moduleValue['mod_content_id'], 'tableName' => $moduleValue['tableName'])));
		//            echo '<p>Processing '.$childrenValue['name'].'<br>';
		$content = cleanMe($randomModule->output());
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
					$words[$wordKey]['page'] = 'http://'.$siteDetails['name'].'/'.$value['dynamicPageURL'];
					$words[$wordKey]['title'] = $randomModule->moduleValues['content']['name'];
					
					$pageUrlTemplate = new template();
					$pageUrlTemplate->set($words[$wordKey]['page']);
					$randomModule->moduleValues['skinFunctions']['var'] = array_merge($randomModule->moduleValues['skinFunctions']['var'],$randomModule->moduleValues['content']);
					$pageUrlTemplate->processSkinValues($randomModule->moduleValues);
					$words[$wordKey]['page'] = $pageUrlTemplate->output();
					
					processWord($words[$wordKey]);
					sleep(0.001);
				}
			}
		}
	}
}

writeOutWords();
echo "<p>Done ... </p>";
?>
