<?php

if( $moduleValues['cmd']=='' ){
	
	$content_id = isSet($_REQUEST['content_id']) && $_REQUEST['content_id']!='' ? $_REQUEST['content_id'] : '';
	$tableName = isSet($_REQUEST['tableName']) && $_REQUEST['tableName']!='' ? $_REQUEST['tableName'] : '';
	$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';
	
	// get the module details
	$moduleDetails = $db->fetchrownamed('select * from sys_module where tableName="'.$tableName.'"');
	
//	$fields = $db->fetcharray('select sys_'.$tableName.'_fields.name as fieldName,sys_'.$tableName.'_fields.* from sys_'.$tableName.'_fields where controlValues like "%frontEndEditable=yes"');
	$fields = $db->fetcharray('select sys_'.$tableName.'_fields.name as fieldName,sys_'.$tableName.'_fields.* from sys_'.$tableName.'_fields');
	
	switch( $cmd ){
		case 'new':
			$query = 'insert into mod_'.$tableName.'(dateLastModified,';
			$queryEnd = '';
			foreach( $fields as $key=>$value ){
				$query .= $value['name'].($key!=count($fields)-1 ? ',' : '');
				$queryEnds .= '"'.trim(str_replace('"','\"',$_REQUEST[$value['name']])).'"'.($key!=count($fields)-1 ? ',' : '');
			}
			$query = $query.') values(now(),'.$queryEnds.')';
			$query = str_replace(",,",",",$query);
			$db->__runquery_($query);
			$content_id = $db->__lastID_(); 
		break;
		case 'update':
		
			$module = new module(array('in'=>array('sys_module_id'=>$moduleDetails['sys_module_id'],'mod_content_id'=>$content_id,'tableName'=>$tableName,'sys_field_type_id'=>'1')),'setContent');
		
			$query = 'update mod_'.$tableName.' set ';
			
			
			foreach( $fields as $key=>$value ){
				if( isSet($_REQUEST[$value['name']]) ){
					$query .= $value['name'].'="'.trim(str_replace('"','\"',$_REQUEST[$value['name']])).'"'.($key!=count($fields)-1 ? ',' : '');
				}
			}
			$query .= ',dateLastModified=now() where mod_'.$tableName.'_id='.$content_id;
			$query = str_replace(",,",",",$query);
			$db->__runquery_($query);
		break;
	}
	
	$content = $db->fetchrownamed('select mod_'.$tableName.'.name as contentName,mod_'.$tableName.'.* from mod_'.$tableName.' where mod_'.$tableName.'_id='.$content_id);
			
	foreach( $fields as $key=>$value ){
		$fields[$key] = array_merge($value,$moduleDetails);
		if( $value['sys_control_id']=='9' ){
			$fields[$key]['content'] = eregi_replace("\"","\\\"",eregi_replace("\\\r","",eregi_replace("\\\n","",eregi_replace("'","\\'",htmlspecialchars($content[$value['name']])))));
		}else if( $value['sys_control_id']=='21' || $value['sys_control_id']=='28' ){
			parse_str($value['controlValues']);
			$text = $db->fetchrownamed('select * from mod_'.$moduleName.' where mod_'.$moduleName.'_id='.$content[$value['name']]);
			$fields[$key]['contentText'] = $text['name'];
			$fields[$key]['moduleName'] = $moduleName; 
			$fields[$key]['content'] = $content[$value['name']];
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
	
	$moduleValues['skinFunctions']['var']['contentName'] = $content['contentName']; 
	$moduleValues['skinFunctions']['var']['cmd'] = $content_id!='' ? 'update' : 'new';
//	echo  $moduleValues['skinFunctions']['var']['cmd'];die;
	if( $content ){
		$moduleValues['skinFunctions']['var'] = array_merge($content,$moduleValues['skinFunctions']['var']);
	}
	$moduleValues['skinFunctions']['loop']['contentFields'] = $fields;
	$moduleValues['skinFunctions']['var']['tableNameModule'] = $tableName;
	$moduleValues['skinFunctions']['var']['content_id'] = $content_id;
	
	
//	print_r($moduleValues['skinFunctions']['loop']['contentFields']);die;
	
	if( is_file($paths['__installationPath_'].'/'.'clients'.$paths['__clientPath_'].'/skins/edit-'.$tableName.'.tpl') ){
		$moduleValues['in']['skinName'] = 'edit-'.$tableName.'.tpl';
	}	
}

?>