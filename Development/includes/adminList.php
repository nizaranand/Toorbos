<?php

if( $moduleValues['cmd']=='' ){

	$contentType = $this->url->getRequestVar('contentType');

	$moduleDetails = moduleUtilities::getByTableName($contentType);

	$searchName = $this->url->getRequestVar('searchName');
	$newName = $this->url->getRequestVar('newName');
	$message = $this->url->getRequestVar('message');
	$deleteList = $this->url->getRequestVar('deleteList');
	$cmd = $this->url->getRequestVar('cmd');
	$searchField = $this->url->getRequestVar('searchField');

	$requestVars = http_build_query($_REQUEST);

	if( is_array($deleteList) && count($deleteList)>0 ){
		$message = "The following ".$contentType."(s) has been deleted: ";

		foreach( $deleteList as $key=>$value ){
			$query = 'select * from mod_'.$contentType.' where mod_'.$contentType.'_id='.$value.'';
			$detailsToDelete = $db->fetchrownamed($query);

			$query = 'delete from mod_'.$contentType.' where mod_'.$contentType.'_id='.$value;
			$db->__runquery_($query);
			$message .= $detailsToDelete['name'].($key!=count($deleteList)-1 ? ', ' : '');
		}

	}

	if( $newName!='' ){
		$query = 'select * from mod_'.$contentType.' where name="'.$newName.'"';
		if( !( $existingContent = $db->fetchrownamed($query) ) ){
			$query = 'insert into mod_'.$contentType.'(name,published) values("'.$newName.',1")';
			$db->__runquery_($query);
			$message = $contentType.' with name: '.$newName.' created!';
		}else{
			$message = $contentType.' with name: '.$newName.' already exists!';
		}
	}

	$moduleValues['skinFunctions']['var']['isImage'] = 'no';

	$message = $searchName!='' ? 'Search results for <strong>'.$searchName.'</strong>' : $message;

	if( $contentType=="picture" ){
		$query = 'select mod_'.$contentType.'.contentId as relatedContentId,mod_'.$contentType.'.picture,mod_'.$contentType.'.title,mod_'.$contentType.'.name,mod_'.$contentType.'.name as contentName,
				  mod_'.$contentType.'.mod_'.$contentType.'_id as contentId
				  from mod_'.$contentType.'
				  '.($searchName!='' ? 'where mod_'.$contentType.'.'.$searchField.' like "%'.$searchName.'%" and ' : ' where ').' published=1
			  	  group by mod_'.$contentType.'.mod_'.$contentType.'_id order by mod_'.$contentType.'.name ASC';
	}else{
		$query = 'select mod_'.$contentType.'.*,mod_'.$contentType.'.name as contentName,
				  mod_'.$contentType.'.mod_'.$contentType.'_id as contentId
				  from mod_'.$contentType.'
				  '.($searchName!='' ? 'where mod_'.$contentType.'.'.$searchField.' like "%'.$searchName.'%" and ' : ' where ').' published=1
			  	  group by mod_'.$contentType.'.mod_'.$contentType.'_id order by mod_'.$contentType.'.'.($contentType=="article" ? 'date DESC' : 'name ASC').'';
	}


	// get a list of content
	$contentList = $db->fetcharray($query);

	$query = 'select * from sys_'.$contentType.'_fields';
	$fieldsList = $db->fetcharray($query);

	$moduleValues['skinFunctions']['loop']['fieldsList'] = $fieldsList;

	$moduleValues['skinFunctions']['var']['isGroup'] = 'no';

	// do an export if that is what is required
	if( $cmd=='export' ){

		$filename = $moduleDetails['moduleName'].'-list-'.date('Y-m-d');
		header("Content-type: {text/csv}");
		header("Content-Disposition: attachment; filename=\"".str_replace(" ", "-", $filename).".csv\"");

		foreach( $contentList as $key=>$value ){
			$value = content::get($moduleDetails['moduleName'], $value['mod_'.$contentType.'_id']);
			if( $key==0 ){
				foreach( $fieldsList as $key2=>$value2 ){
					echo ($key2!=0 ? ',' : '').$value2['displayName'].($key2==count($fieldsList)-1 ? "\n" : "");
				}
			}
			foreach( $fieldsList as $key2=>$value2 ){
				$fieldValue = '';
				if( is_array($value[$value2['name']]) ){
					foreach( $value[$value2['name']] as $key3=>$value3 ){
						$fieldValue .= ($key3!=0 ? ' ' : '').$value3['name'];
					}
				}else{
					$fieldValue = $value[$value2['name']];
				}
				echo ($key2!=0 ? ',' : '').$fieldValue.($key2==count($fieldsList)-1 ? "\n" : "");
			}
		}

		die;
	}

	if( $contentType=='picture' ){

		foreach( $contentList as $key=>$value ){

			// get all the sites

			if( !strstr($contentList[$key]['picture'],'.jpg') ){
				$contentList[$key]['picture'] = $contentList[$key]['picture'].'.jpg';
			}

		}
	}

	$moduleValues['skinFunctions']['var']['contentTypePath'] = strtolower($contentType);
	$moduleValues['skinFunctions']['var']['contentType'] = $contentType;
	$moduleValues['skinFunctions']['var']['propertyStatus'] = $propertyStatus;
	$moduleValues['skinFunctions']['var']['propertyGroup'] = $propertyGroup;
	$moduleValues['skinFunctions']['var']['title'] = 'List '.$moduleDetails['moduleName'];
	$moduleValues['skinFunctions']['var']['message'] = $message;
	$moduleValues['skinFunctions']['loop']['contentList'] = $contentList;
	$moduleValues['skinFunctions']['var']['moduleName'] = $moduleDetails['moduleName'];
	$moduleValues['skinFunctions']['var']['requestVars'] = $requestVars;

}

?>