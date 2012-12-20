<?php

if( $moduleValues['cmd']=='' ){

	$page_id = isSet($_REQUEST['page_id']) && $_REQUEST['page_id']!='' ? $_REQUEST['page_id'] : '';
	$tree_id = isSet($_REQUEST['tree_id']) && $_REQUEST['tree_id']!='' ? $_REQUEST['tree_id'] : '';
	$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';

	if( $cmd=='new' && isSet($GLOBALS['_REQUEST']['name']) && trim($GLOBALS['_REQUEST']['name'])!='' ){

		// derive a path from the requested name

		$GLOBALS['_REQUEST']['path'] = strtolower(str_replace(' ','-',$GLOBALS['_REQUEST']['name']));
		$GLOBALS['_REQUEST']['path'] = urlencode($GLOBALS['_REQUEST']['path']);
		$GLOBALS['_REQUEST']['title'] = $GLOBALS['_REQUEST']['name'];

		// get the module details
		$moduleDetails = $db->fetchrownamed('select * from sys_module where tableName="page"');

		//	$fields = $db->fetcharray('select sys_'.$tableName.'_fields.name as fieldName,sys_'.$tableName.'_fields.* from sys_'.$tableName.'_fields where controlValues like "%frontEndEditable=yes"');
		$tableName = 'page';
		$fields = $db->fetcharray('select sys_'.$tableName.'_fields.name as fieldName,sys_'.$tableName.'_fields.* from sys_'.$tableName.'_fields order by sys_'.$tableName.'_fields_id');

		$query = 'insert into mod_'.$tableName.'(dateLastModified,published,';
		$queryEnd = '';
		foreach( $fields as $key=>$value ){
			$query .= $value['name'].($key!=count($fields)-1 ? ',' : '');
			$queryEnds .= '"'.trim(str_replace('"','\"',$_REQUEST[$value['name']])).'"'.($key!=count($fields)-1 ? ',' : '');
		}
		$query = $query.') values(now(),1,'.$queryEnds.')';
		$query = str_replace(",,",",",$query);
		$db->__runquery_($query);
		$content_id = $db->__lastID_();

		$page_id = $content_id;
		 
		 
		// check if we have it in the tree
		$moduleDetailsCustomFolder = $db->fetchrownamed('select * from sys_module where name="Site"');
		$moduleDetailsCustomFolderDetail = $db->fetchrownamed('select sys_tree.sys_tree_id from sys_tree left join mod_site on sys_tree.mod_content_id=mod_site.mod_site_id where sys_tree.sys_module_id='.$moduleDetailsCustomFolder['sys_module_id']);


		$moduleDetailsCustom = $db->fetchrownamed('select * from sys_module where name="Page"');

		$GLOBALS['_REQUEST']['sys_component_id'] = $moduleDetailsCustom['sys_component_id'];
		$GLOBALS['_REQUEST']['sys_module_id'] = $moduleDetailsCustom['sys_module_id'];
		$GLOBALS['_REQUEST']['sys_parent_id'] = $moduleDetailsCustomFolderDetail['sys_tree_id'];
		$GLOBALS['_REQUEST']['mod_content_id'] = $content_id;
		$GLOBALS['_REQUEST']['sys_field_type_id'] = '1';

		$GLOBALS['_REQUEST']['skipCreation'] = $GLOBALS['_REQUEST']['path']=='' ? true : false;
		$GLOBALS['_REQUEST']['path'] = str_replace(' ','_',$GLOBALS['_REQUEST']['path']);

		if( !($treeDetail = $db->fetchrownamed('select * from sys_tree where sys_module_id='.$moduleDetailsCustom['sys_module_id'].' and sys_parent_id='.$moduleDetailsCustomFolderDetail['sys_tree_id'].' and mod_content_id='.$content_id)) ){

			//						$module = new module(array('in'=>array('sys_module_id'=>$moduleDetails['sys_module_id'],'mod_content_id'=>$content_id,'tableName'=>$tableName,'sys_field_type_id'=>'1')),'setContent');
			//					$module = new module(array('in'=>array('sys_field_type_id'=>1,'sys_module_id'=>$moduleDetailsCustom['sys_module_id'],'mod_content_id'=>$content_id,'tableName'=>$tableName)),'setValues');

			if( isSet($moduleDetailsCustomFolderDetail['sys_tree_id']) && $moduleDetailsCustomFolderDetail['sys_tree_id']!=0 && isSet($content_id) && $content_id!=0 && isSet($moduleDetailsCustom['sys_module_id']) && $moduleDetailsCustom['sys_module_id']!=0 ){
				$GLOBALS['_REQUEST']['published'] = 1;
				$module = new module(array('in'=>array('mod_content_id'=>$content_id,'sys_module_id'=>$moduleDetailsCustom['sys_module_id'],'sys_parent_id'=>$moduleDetailsCustomFolderDetail['sys_tree_id'],'currentPath'=>'','sys_field_type_id'=>0)),'addToTree');
				$sys_tree_id = $module->moduleValues['sys']['sys_tree_id'];
				$tree_id = $sys_tree_id;
				$treeDetail['sys_tree_id'] = $sys_tree_id;
				$tableName = $module->moduleValues['sys']['tableName'];
				/* do inline commands bit */
			}

		}else{
			$sys_tree_id = $treeDetail['sys_tree_id'];
			$tree_id = $sys_tree_id;
		}


		$setValues = array('sys_tree_id'=>$treeDetail['sys_tree_id'],'sys_module_id'=>$moduleDetailsCustom['sys_module_id'],'sys_parent_id'=>$moduleDetailsCustomFolderDetail['sys_tree_id'],'mod_content_id'=>$content_id,'sys_skin_id'=>0);
		$module = new module(array('in'=>array('sys_tree_id'=>$treeDetail['sys_tree_id'],'currentPath'=>'','sys_field_type_id'=>0)),'setContent');
		$module = new module(array('in'=>array('sys_tree_id'=>$treeDetail['sys_tree_id'],'currentPath'=>'','sys_field_type_id'=>0),'setValues'=>$setValues),'setValues');
		$GLOBALS['__APPLICATION_']['database']->__runQueryByCode_('__runquery_','CQUpdatePublished',array('tableName'=>$tableName,'mod_content_id'=>$content_id,'published'=>'1'));

		// ADD SYQISYG
		$container = $db->fetchrownamed('select * from sys_tree,mod_container where sys_tree.sys_parent_id='.$sys_tree_id.' and sys_tree.sys_module_id=8 and mod_container.mod_container_id=sys_tree.mod_content_id and mod_container.name="Content"');

		if( ($wysiwygTree = $db->fetchrownamed('select * from sys_tree where sys_module_id=24 and sys_parent_id='.$container['sys_tree_id'])) ){
			$wysiwygTree = $db->fetchrownamed('select * from sys_tree where sys_module_id=24 and sys_parent_id='.$container['sys_tree_id']);
			$fieldValue = eregi_replace('"','\\"',$_REQUEST['contentWysiwyg']);
			$db->__runquery_('update mod_wysiwyg set html="'.$fieldValue.'" where mod_wysiwyg_id='.$wysiwygTree['mod_content_id']);
		}else{
			// add wysiwyg
			$GLOBALS['_REQUEST']['html'] = eregi_replace('"','\\"',$_REQUEST['contentWysiwyg']);
			$GLOBALS['_REQUEST']['name'] = $GLOBALS['_REQUEST']['name']."  Content";
			//echo $GLOBALS['_REQUEST']['html'.$value['mod_container_id']];die;
			$_REQUEST['html'.$container['mod_container_id']] = eregi_replace('"','\\"',$_REQUEST['contentWysiwyg']);

			$new_wysiwyg_id = $GLOBALS['__APPLICATION_']['utilities']->createAndAddModule( $container['sys_tree_id'], $GLOBALS['_REQUEST']['name'], 'wysiwyg', array('html'=>$_REQUEST['contentWysiwyg']),true,true );
		}

	}

	// check for an existing wysiwyg on the page...
	$treePage = $db->fetchrownamed('select * from sys_tree where sys_tree_id='.$tree_id);
	$containers = $db->fetcharray('select * from sys_tree,mod_container where sys_tree.sys_parent_id='.$tree_id.' and sys_tree.sys_module_id=8 and mod_container.mod_container_id=sys_tree.mod_content_id');
	$page = $db->fetchrownamed('select mod_page.name as pageName,mod_page.* from mod_page where mod_page_id='.$page_id);

	$path = $GLOBALS['__APPLICATION_']['utilities']->generatePagePath( $tree_id );
	$path = str_replace($GLOBALS['__CONFIG_']['__paths_']['__clientPath_'],'',$path);
	$path = str_replace('/'.$GLOBALS['__CONFIG_']['__paths_']['__httpPath_'],'',$path);

	if( $cmd!='' && isSet($_REQUEST['pageName']) && $_REQUEST['pageName']!='' && isSet($_REQUEST['pageTitle']) && $_REQUEST['pageTitle']!='' ){
		$db->__runquery_('update mod_page set name="'.$_REQUEST['pageName'].'", title="'.$_REQUEST['pageTitle'].'",metaKeywords="'.$_REQUEST['metaKeywords'].'",metaDescription="'.$_REQUEST['metaDescription'].'" where mod_page_id='.$page_id);
		$page = $db->fetchrownamed('select mod_page.name as pageName,mod_page.* from mod_page where mod_page_id='.$page_id);
	}
	if( $cmd!='' && isSet($_REQUEST['publish']) && $_REQUEST['publish']!='' ){
		$db->__runquery_('update sys_tree set sys_published='.($_REQUEST['publish']=='yes' ? '1' : '0').' where sys_tree_id='.$tree_id);
		$db->__runquery_('update mod_page set published='.($_REQUEST['publish']=='yes' ? '1' : '0').' where mod_page_id='.$page_id);
		$treePage = $db->fetchrownamed('select * from sys_tree where sys_tree_id='.$tree_id);
	}

	foreach( $containers as $key=>$value ){
		$cmd = isSet($_REQUEST['cmd'.$value['mod_container_id']]) && $_REQUEST['cmd'.$value['mod_container_id']]!='' ? $_REQUEST['cmd'.$value['mod_container_id']] : '';
		switch( $cmd ){
			case 'new':
				// add wysiwyg
				$GLOBALS['_REQUEST']['html'] = eregi_replace('"','\\"',$_REQUEST['html'.$value['mod_container_id']]);
				$GLOBALS['_REQUEST']['name'] = $page['name']." ".$value['name']." Content";
				//echo $GLOBALS['_REQUEST']['html'.$value['mod_container_id']];die;
				$_REQUEST['html'.$value['mod_container_id']] = eregi_replace('"','\\"',$_REQUEST['html'.$value['mod_container_id']]);

				$new_wysiwyg_id = $GLOBALS['__APPLICATION_']['utilities']->createAndAddModule( $value['sys_tree_id'], $page['name']." ".$value['name']." Content", 'wysiwyg', array('html'=>$_REQUEST['html'.$value['mod_container_id']]),true,true );
				//$db->__runquery_('update mod_wysiwyg set name="'.$page['name']." ".$value['name']." Content".'" where mod_wysiwyg_id='.$new_wysiwyg_id);
				//echo 'update mod_wysiwyg set name="'.$page['name']." ".$value['name']." Content".'" where mod_wysiwyg_id='.$new_wysiwyg_id;die;
				break;
			case 'update':
				$wysiwygTree = $db->fetchrownamed('select * from sys_tree where sys_module_id=24 and sys_parent_id='.$value['sys_tree_id']);
				$fieldValue = eregi_replace('"','\\"',$_REQUEST['html'.$value['mod_container_id']]);
				$db->__runquery_('update mod_wysiwyg set html="'.$fieldValue.'" where mod_wysiwyg_id='.$wysiwygTree['mod_content_id']);
				system('wkhtmltoimage --crop-w 230 --crop-h 130 --zoom 0.25 --width 100 '.$GLOBALS['__APPLICATION_']['channel']->getBaseURL().$path.' '.$paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/'.$paths['__httpPath_'].'/images/Fiber/'.($page['path']=='' ? 'home' : $page['path']).'.jpg');
mail('mare@rightbrain.co.za','Page updated',' by:'.$GLOBALS['siteSession']->user->userDetail['sys']['username'].' ip:'.$_SERVER['REMOTE_ADDR'].' to:'.$fieldValue);				
break;
		}
		if( ($wysiwygTree = $db->fetchrownamed('select * from sys_tree where sys_module_id=24 and sys_parent_id='.$value['sys_tree_id'])) ){
			$wysiwyg = $db->fetchrownamed('select * from mod_wysiwyg where mod_wysiwyg_id='.$wysiwygTree['mod_content_id']);
			$containers[$key]['wysiwyg_id'] = $wysiwyg['mod_wysiwyg_id'];
			$containers[$key]['html'] = htmlspecialchars($wysiwyg['html']);
			$containers[$key]['cmd'] = 'update';
			$containers[$key]['containerName'] = $value['name'];
		}else{
			$wysiwyg = $db->fetchrownamed('select * from mod_wysiwyg where mod_wysiwyg='.$wysiwygTree['mod_content_id']);
			$containers[$key]['cmd'] = 'new';
			$containers[$key]['html'] = "";
			$containers[$key]['containerName'] = $value['name'];
		}
	}


	$moduleValues['skinFunctions']['var']['cmd'] = 'update';
	$moduleValues['skinFunctions']['loop']['containers'] = $containers;
	$moduleValues['skinFunctions']['var']['path'] = $path;
	$moduleValues['skinFunctions']['var']['pageName'] = $page['pageName'];
	$moduleValues['skinFunctions']['var']['pageTitle'] = $page['title'];
	$moduleValues['skinFunctions']['var']['metaKeywords'] = $page['metaKeywords'];
	$moduleValues['skinFunctions']['var']['metaDescription'] = $page['metaDescription'];
	$moduleValues['skinFunctions']['var']['tree_id'] = $tree_id;
	$moduleValues['skinFunctions']['var']['mod_page_id'] = $page_id;
	$moduleValues['skinFunctions']['var']['published'] = $treePage['sys_published']=='1' ? 'yes' : 'no';


}

?>
