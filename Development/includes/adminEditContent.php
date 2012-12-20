<?php

if( $moduleValues['cmd']=='' ){

	$content_id = $this->url->getRequestVar('content_id');
	$tableName = $this->url->getRequestVar('contentType');
	$cmd = $this->url->getRequestVar('cmd');
	$cmd2 = $this->url->getRequestVar('cmd2');
	$message = $this->url->getRequestVar('message');

	// get the module details
	$moduleDetails = moduleUtilities::getByTableName($tableName);

	//	$fields = $db->fetcharray('select sys_'.$tableName.'_fields.name as fieldName,sys_'.$tableName.'_fields.* from sys_'.$tableName.'_fields where controlValues like "%frontEndEditable=yes"');
	$fields = $db->fetcharray('select sys_'.$tableName.'_fields.name as fieldName,sys_'.$tableName.'_fields.* from sys_'.$tableName.'_fields order by sys_'.$tableName.'_fields_id');
	// minisite custom content
	
	switch( $cmd ){
		case 'new':
			// check for the same name


			$query = 'insert into mod_'.$tableName.'(dateLastModified,published,';
			$queryEnd = '';
			foreach( $fields as $key=>$value ){
				$query .= $value['name'].($key!=count($fields)-1 ? ',' : '');
				$_REQUEST[$value['name']] = mb_convert_encoding($_REQUEST[$value['name']],'HTML-ENTITIES','UTF-8');
				$queryEnds .= '"'.trim(str_replace('"','\"',$_REQUEST[$value['name']])).'"'.($key!=count($fields)-1 ? ',' : '');
				if( $value['name']=='tags' ){

					$tags = explode(',',$_REQUEST[$value['name']]);

				}
			}
			$query = $query.') values(now(),1,'.$queryEnds.')';
			$query = str_replace(",,",",",$query);
			$db->__runquery_($query);
			$content_id = $db->__lastID_();

			if( isSet($tags) && count($tags)>0 ){
				foreach( $tags as $key=>$value ){
					// check the database
					$query = 'select * from mod_tag where LOWER(name)=LOWER("'.trim($value).'")';
					if( !($tagDetail = $db->fetchrownamed($query)) ){
						$query = 'insert into mod_tag(name) values("'.trim($value).'")';
						$tagDetail = array();
						$tagDetail['mod_tag_id'] = $db->__lastID_();
					}

					$deletequery = 'delete from mod_tagRelationship where mod_tagRelationship.contentId='.$content_id.' and mod_tagRelationship.moduleType="'.$tableName.'"';
					$db->__runquery_($deletequery);		
							
					$query = 'select * from mod_tagRelationship where tag='.$tagDetail['mod_tag_id'].' and contentId='.$content_id.' and moduleType="'.$tableName.'"';
					if( !($db->fetchrownamed($query)) ){
						$query = 'insert into mod_tagRelationship(tag,contentId,moduleType) values('.$tagDetails['mod_tag_id'].','.$content_id.',"'.$tableName.'")';
						$db->__runquery_($query);
					}
				}

			}

			$message = "New content of type ".$tableName." created";

			break;
		case 'update':

			// check the name
			$increment = 0;
			while( true ){
				$query = 'select * from mod_'.$tableName.' where name="'.$this->url->getRequestVar('name').($increment!=0 ? $increment : '').'" and mod_'.$tableName.'_id!='.$content_id;
				if( !( $currentContent = $db->fetchrownamed($query) ) ){
					break;
				}else{
					$increment++;
				}
			}
			if( !( $currentContent = $db->fetchrownamed($query) ) ){

				if( $increment!=0 ){

					$message = "Data coulnd't be saved, content with the same name already exists: ".$this->url->getRequestVar('name').' name changed to: '.$this->url->getRequestVar('name').$increment;
					$GLOBALS['_REQUEST']['name'] = $this->url->getRequestVar('name').$increment;
					$_REQUEST['name'] = $this->url->getRequestVar('name').$increment;
				}

				$query = 'select * from mod_'.$tableName.' where mod_'.$tableName.'_id!='.$content_id;
				$currentContent = $db->fetchrownamed($query);

				/*$fields = array();
				foreach( $_REQUEST as $key=>$value ){
					array_push($fields,array('name'=>$key,'value'=>$value));
				}				
				
				content::update($tableName, $content_id, $fields);*/
				
				$module = new module(array('in'=>array('sys_module_id'=>$moduleDetails['sys_module_id'],'mod_content_id'=>$content_id,'tableName'=>$tableName,'sys_field_type_id'=>'1')),'setContent');
				$query = 'update mod_'.$tableName.' set ';

				foreach( $fields as $key=>$value ){
					if( isSet($_REQUEST[$value['name']]) ){
						$_REQUEST[$value['name']] = mb_convert_encoding($_REQUEST[$value['name']],'HTML-ENTITIES','UTF-8');
						$query .= $value['name'].'="'.trim(str_replace('"','\"',$_REQUEST[$value['name']])).'"'.($key!=count($fields)-1 ? ',' : '');
						if( $value['name']=='tags' ){

							$tags = explode(',',$_REQUEST[$value['name']]);

						}

					}
				}
				$query .= ',dateLastModified=now() where mod_'.$tableName.'_id='.$content_id;

				$query = str_replace(",,",",",$query);


				$db->__runquery_($query);

				if( isSet($tags) && count($tags)>0 ){
					$query = 'delete from mod_tagRelationship where contentId='.$content_id.' and moduleType="'.$tableName.'"';
					$db->__runquery_($query);
					
					foreach( $tags as $key=>$value ){
						// check the database
						$query = 'select * from mod_tag where LOWER(name)=LOWER("'.$value.'")';

						if( !($tagDetail = $db->fetchrownamed($query)) ){
							$query = 'insert into mod_tag(name) values("'.$value.'")';
							$tagDetail = array();
							$tagDetail['mod_tag_id'] = $db->__lastID_();
						}


						$query = 'select * from mod_tagRelationship where tag='.$tagDetail['mod_tag_id'].' and contentId='.$content_id.' and moduleType="'.$tableName.'"';

						if( !($db->fetchrownamed($query)) ){
							$query = 'insert into mod_tagRelationship(tag,contentId,moduleType) values('.$tagDetail['mod_tag_id'].','.$content_id.',"'.$tableName.'")';
							$db->__runquery_($query);
						}
					}

				}

				$message .= "<br>Data updated!";

			}else{
				$message = "Data coulnd't be saved, content with the same name already exists: ".$this->url->getRequestVar('name');
			}
			break;
	}

	$query = 'select mod_'.$tableName.'.name as contentName,mod_'.$tableName.'.* from mod_'.$tableName.' where mod_'.$tableName.'_id='.$content_id;
	$content = $db->fetchrownamed($query);

	foreach( $fields as $key=>$value ){

		$fields[$key]['tableName'] = $moduleDetails['tableName'];
		$fields[$key]['moduleName'] = $moduleDetails['tableName'];
		$fields[$key]['moduleNameLower'] = strtolower($moduleDetails['tableName']);
		$fields[$key]['sys_component_id'] = $moduleDetails['sys_component_id'];
		$fields[$key]['screenshot'] = htmlspecialchars($value['screenshot']);
		$controlDetails = controlUtilities::get($value['sys_control_id']);

		if( $value['sys_control_id']=='9' ){
			$fields[$key]['content'] = eregi_replace("\"","\\\"",eregi_replace("\\\r","",eregi_replace("\\\n","",htmlspecialchars($content[$value['name']]))));
		}else if( $value['sys_control_id']=='28' ){

			$query = 'select * from mod_picture where moduleType="'.$tableName.'" and contentId='.$content_id;
			$pictures = $db->fetcharray($query);

			foreach( $pictures as $key2=>$value2 ){

				if( $cmd=='update' ){
					$query = 'update mod_picture set tags="'.$_REQUEST[$tableName.$value['name'].'tags'.($key2+1)].'" where mod_picture_id="'.$value2['mod_picture_id'].'"';
					$db->__runquery_($query);
					$value2['tags'] = $_REQUEST[$tableName.$value['name'].'tags'.($key2+1)];
					$pictures[$key2]['tags'] = $value2['tags'];



					$tags = explode(',',$value2['tags']);

					if( isSet($tags) && count($tags)>0 ){
						$query = 'delete from mod_tagRelationship where contentId='.$value2['mod_picture_id'].' and moduleType="picture"';
						$db->__runquery_($query);
						foreach( $tags as $key3=>$value3 ){
							// check the database
							$query = 'select * from mod_tag where LOWER(name)=LOWER("'.trim($value3).'")';

							if( !($tagDetail = $db->fetchrownamed($query)) ){
								$query = 'insert into mod_tag(name) values("'.trim($value3).'")';
								$tagDetail = array();
								$tagDetail['mod_tag_id'] = $db->__lastID_();
							}


							$query = 'select * from mod_tagRelationship where tag='.$tagDetail['mod_tag_id'].' and contentId='.$value2['mod_picture_id'].' and moduleType="picture"';

							if( !($db->fetchrownamed($query)) ){
								$query = 'insert into mod_tagRelationship(tag,contentId,moduleType) values('.$tagDetail['mod_tag_id'].','.$value2['mod_picture_id'].',"picture")';
								$db->__runquery_($query);
							}
						}

					}
				}

			}
			

			//if( $content[$value['name']]!='' ){
			/*$images = array();
				if( strstr($content[$value['name']],',') ){
				$images = explode(',',$content[$value['name']]);
				}else{
				$images = array($content[$value['name']]);
				}

				$imageValues = array();
				$exists = false;

				$deletePictures = isSet($GLOBALS['_REQUEST'][$tableName.$value['name'].'deletePictures']) ? $GLOBALS['_REQUEST'][$tableName.$value['name'].'deletePictures'] : array();

				foreach( $images as $key2=>$value2 ){

				$values = explode('|',$value2);

				if( array_search($key+1,$deletePictures)!==false ){
					
				$query = 'delete from mod_picture where moduleType="'.$tableName.'" and contentId='.$content_id.' and picture="'.$values[0].'"';
				$db->__runquery_($query);
					
				}else{

				// get the picture values
				$query = 'select * from mod_picture where moduleType="'.$tableName.'" and contentId='.$content_id.' and picture="'.$values[0].'"';
					
				$pictureTags = array();

				if( $_REQUEST[$tableName.'tags'.($key2+1)]!='' ){
				$pictureTags = explode(',',$_REQUEST[$tableName.'tags'.($key2+1)]);
				}
					
				if( !($picture = $db->fetchrownamed($query)) ){

				$query = 'insert into mod_picture(moduleType,contentId,picture,tags,status) values("'.$tableName.'","'.$content_id.'","'.$values[0].'","'.$_REQUEST[$tableName.'tags'.($key2+1)].'",'.(isSet($_REQUEST[$tableName.'status'.($key2+1)]) ? $_REQUEST[$tableName.'status'.($key2+1)] : 0).')';
				$db->__runquery_($query);

				}else{
				if( $cmd=='update' ){
				$query = 'update mod_picture set status='.$_REQUEST[$tableName.'status'.($key2+1)].', tags="'.$_REQUEST[$tableName.'tags'.($key2+1)].'" where moduleType="'.$tableName.'" and contentId='.$content_id.' and picture="'.$values[0].'"';
				//echo $query;
				$db->__runquery_($query);
				$picture['tags'] = $_REQUEST[$tableName.'tags'.($key2+1)];
				$picture['status'] = $_REQUEST[$tableName.'status'.($key2+1)];
				}
				}

				if( isSet($pictureTags) && count($pictureTags)>0 ){
				$query = 'delete from mod_tagRelationship where contentId='.$picture['mod_picture_id'].' and moduleType="picture"';
				$db->__runquery_($query);
				foreach( $pictureTags as $key3=>$value3 ){
				// check the database
				$query = 'select * from mod_tag where LOWER(name)=LOWER("'.$value3.'")';

				if( !($tagDetail = $db->fetchrownamed($query)) ){
				$query = 'insert into mod_tag(name) values("'.$value3.'")';
				$tagDetail = array();
				$tagDetail['mod_tag_id'] = $db->__lastID_();
				}


				$query = 'select * from mod_tagRelationship where tag='.$tagDetail['mod_tag_id'].' and contentId='.$picture['mod_picture_id'].' and moduleType="picture"';

				if( !($db->fetchrownamed($query)) ){
				$query = 'insert into mod_tagRelationship(tag,contentId,moduleType) values('.$tagDetails['mod_tag_id'].','.$picture['mod_picture_id'].',"picture")';
				$db->__runquery_($query);
				}
				}
				// generate tags
				}


				//$pictureTags = explode(',',$_REQUEST[$tableName.'tags']);
				if( $values[0]!='' ){
				array_push($imageValues,array('status'=>$picture['status'],'tags'=>$picture['tags'],'src'=>$values[0],'alt'=>$values[1],'primary'=>$values[2],'selected'=>($values[2]=='yes' ? 'checked' : '' )));
				}
				if( $values[0]==$fileName ){
				$exists = true;
				}
				}
				}*/

			$fields[$key]['pictures'] = $pictures;
			//print_r($fields[$key]['pictures']);die;

			parse_str($value['controlValues']);
			$text = $db->fetchrownamed('select * from mod_'.$moduleName.' where mod_'.$moduleName.'_id='.$content[$value['name']]);
			$fields[$key]['contentText'] = $text['name'];
			$fields[$key]['moduleName'] = $moduleName;
			$fields[$key]['moduleNameLower'] = strtolower($moduleName);
			$fields[$key]['content'] = $content[$value['name']];
			/*}else{
				$fields[$key]['pictures'] = array();;
				//print_r($fields[$key]['pictures']);die;

				parse_str($value['controlValues']);
				$text = $db->fetchrownamed('select * from mod_'.$moduleName.' where mod_'.$moduleName.'_id='.$content[$value['name']]);
				$fields[$key]['contentText'] = $text['name'];
				$fields[$key]['moduleName'] = $moduleName;
				$fields[$key]['moduleNameLower'] = strtolower($moduleName);
				$fields[$key]['content'] = $content[$value['name']];

				}*/

		}else if( $value['sys_control_id']=='21' ){
			parse_str($value['controlValues']);
			$text = $db->fetchrownamed('select * from mod_'.$moduleName.' where mod_'.$moduleName.'_id='.$content[$value['name']]);
			$fields[$key]['contentText'] = $text['name'];
			$fields[$key]['moduleName'] = $moduleName;
			$fields[$key]['content'] = $content[$value['name']];
		}else if( $value['sys_control_id']=='22' ){
			$fieldName = $moduleDetails['tableName'].$value['name'];
			$moduleDetails['mod_content_id'] = $content_id;
			$field = new control(array('in'=>array('mod_content_id'=>$content_id,'actualFieldName'=>$value['name'],'sys_control_id'=>$controlDetails['sys_control_id'],'controlValues'=>$value['controlValues'],'tableName'=>$moduleDetails['tableName'],'fieldValue'=>$content[$value['name']],'fieldName'=>$fieldName,'displayName'=>$value['displayName'],'sys_tree_id'=>0,'content'=>$content,'module'=>$moduleDetails,'editable'=>1)),'admin');
			$fields[$key]['output'] = $field->output();
			if( !isSet($field->controlValues['out']['skinFunctions']['loop'][$value['name']]) ){
//				$moduleValues['skinFunctions']['var'][$value['name']] = $field->output();
/*				if( $editable=='yes' ){
					if( !isSet($moduleValues['skinFunctions']['edit']) ){
						$moduleValues['skinFunctions']['edit'] = array();
					}
					$moduleValues['skinFunctions']['edit'][$value['name']] = $field->editableoutput();
				}*/
			}
			if( isSet($field->controlValues['out']['skinFunctions']['loop']) ){
				$fields[$key] = array_merge($moduleValues['skinFunctions']['loop'],$field->controlValues['out']['skinFunctions']['loop']);
			}
			if( isSet($field->controlValues['out']['skinFunctions']['var']) ){
				$fields[$key] = array_merge($moduleValues['skinFunctions']['var'],$field->controlValues['out']['skinFunctions']['var']);
			}
		}else if( $value['sys_control_id']=='10' ){
			$displays = array();
			$values = array();
			parse_str($value['controlValues']);
			$fields[$key]['options'] = array();

			foreach( $displays as $key2=>$value2 ){
				array_push($fields[$key]['options'],array('optionName'=>$value2,'optionValue'=>$values[$key2],'optionSelected'=>($values[$key2]==$content[$value['name']] ? ' checked' : '')) );
			}
		}else if( $value['sys_control_id']=='2' && strstr($value['controlValues'],'restriction=images') && strstr($value['controlValues'],'x') ){
			parse_str($value['controlValues']);

			$resizeImageSizes = split(',',$imageSesizes);


			// get the file name
			$fileName = explode('.',$content[$value['name']]);
			$fileType = $fileName[1];
			$fileName = $fileName[0];
			foreach( $resizeImageSizes as $key2=>$value2 ){
				//				echo 'content'.$value2;die;
				$fields[$key]['content'.$value2] = $fileName.$value2.'.'.$fileType;
			}

			$fields[$key]['content'] = $content[$value['name']];
			$fields[$key]['moduleName'] = $moduleName;

		}else{
			$fields[$key]['content'] = $content[$value['name']];
		}


	}


	$moduleValues['skinFunctions']['var']['message'] = $message;
	$moduleValues['skinFunctions']['var']['contentName'] = $content['contentName'];
	$moduleValues['skinFunctions']['var']['headerTitle'] = 'Editing '.$content['contentName'];
	$moduleValues['skinFunctions']['var']['cmd'] = $content_id!='' ? 'update' : 'new';
	//	echo  $moduleValues['skinFunctions']['var']['cmd'];die;
	if( $content ){
		$moduleValues['skinFunctions']['var'] = array_merge($content,$moduleValues['skinFunctions']['var']);
	}

	$moduleValues['skinFunctions']['var']['tableNameModule'] = $tableName;
	$moduleValues['skinFunctions']['var']['tableNameLower'] = strtolower($tableName);
	$moduleValues['skinFunctions']['var']['content_id'] = $content_id;
	$moduleValues['skinFunctions']['loop']['contentFields'] = $fields;


	//	print_r($moduleValues['skinFunctions']['loop']['contentFields']);die;

	if( is_file($paths['__installationPath_'].'/'.'clients'.$paths['__clientPath_'].'/skins/edit-'.$tableName.'.tpl') ){
		$moduleValues['in']['skinName'] = 'edit-'.$tableName.'.tpl';
	}
}

?>