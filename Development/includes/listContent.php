<?php

if( $moduleValues['cmd']=='' ){
	
	$contentType_id = isSet($_SESSION['contentType_id']) && $_SESSION['contentType_id']!='' ? $_SESSION['contentType_id'] : ''; 
	$contentType_id = isSet($_REQUEST['contentType_id']) && $_REQUEST['contentType_id']!='' ? $_REQUEST['contentType_id'] : $contentType_id;
	$tableName = isSet($_SESSION['tableName']) && $_SESSION['tableName']!='' ? $_SESSION['tableName'] : ''; 
	$tableName = isSet($_REQUEST['tableName']) && $_REQUEST['tableName']!='' ? $_REQUEST['tableName'] : $tableName;
	$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';
	$content_id = isSet($_REQUEST['content_id']) && $_REQUEST['content_id']!='' ? $_REQUEST['content_id'] : '';
	
	$_SESSION['contentType_id'] = $contentType_id;
	$_SESSION['tableName'] = $tableName;
	
	
	// set all request variables
	$search = isSet( $_REQUEST['search'] ) && $_REQUEST['search'] != '' ? $_REQUEST['search'] : '';//$search;
	$itemsPerPage = 30; // total amount of items to get
	$currentPage = isSet( $_REQUEST['currentPage'] ) && $_REQUEST['currentPage'] != '' ? $_REQUEST['currentPage'] : '';//$currentPage;
	$totalItemsToGet = 10000000;
	
	switch( $cmd ){
		case 'delete':
			$db->__runquery_('delete from mod_'.$tableName.' where mod_'.$tableName.'_id='.$content_id);
		break;
		case 'exportcsvtemplate':
			$fields = $db->fetcharray('select sys_'.$tableName.'_fields.name as fieldName,sys_'.$tableName.'_fields.* from sys_'.$tableName.'_fields');
			header("Content-type: application/octet-stream");
  			header("Content-disposition: attachment; filename=\"".$tableName.'.csv"');
  			foreach( $fields as $key=>$value ){
  				 echo $value['displayName'].($key!=count($fields)-1 ? ',' : '');
  			}
  			die;			
		break;
		case 'exportcsv':
			$fields = $db->fetcharray('select sys_'.$tableName.'_fields.name as fieldName,sys_'.$tableName.'_fields.* from sys_'.$tableName.'_fields');
			$content = $db->fetcharray('select name as contentName,mod_'.$tableName.'.mod_'.$tableName.'_id as mod_content_id,mod_'.$tableName.'.* from mod_'.$tableName.(isSet( $search ) && $search != '' ? ' where  name like "%' . $search . '%"' : '')." order by name");
  			header("Content-disposition: attachment; filename=\"".$tableName.'.csv"');
			header("Content-type: application/octet-stream");

  			foreach( $fields as $key=>$value ){
  				 echo $value['displayName'].($key!=count($fields)-1 ? ',' : '');
  			}
  			echo "\n";
  			foreach( $content as $key=>$value ){
  			  foreach( $fields as $key2=>$value2 ){
  			  	if( $value2['sys_control_id']==21 || $value2['sys_control_id']==28 ){
  			  		parse_str($value2['controlValues']);
  			  		$modValue = $db->fetchrownamed('select mod_'.$moduleName.'.name as contentName from mod_'.$moduleName.' where mod_'.$moduleName.'_id='.$value[$value2['name']]);
  			  		echo str_replace(',','|',$modValue['contentName']).($key2!=count($fields)-1 ? ',' : '');
  			  	}else if($value2['sys_control_id']==9){
  					echo str_replace(',','|',str_replace("\r","",str_replace("\n",'',trim($value[$value2['name']])))).($key2!=count($fields)-1 ? ',' : '');
  			  	}else{
  			  		echo str_replace(',','|',str_replace("\r","",str_replace("\n",'',trim($value[$value2['name']])))).($key2!=count($fields)-1 ? ',' : '');
  			  	}
  			  }	
  			  echo "\n";
  			}
  			die;			
		break;
		case 'import':
			$fp = fopen( $_FILES['file']['tmp_name'], "r" );
			$clear = isSet($_REQUEST['clearValue']) && $_REQUEST['clearValue']!='' ? $_REQUEST['clearValue'] : '';
			$excludeFields = isSet($_REQUEST['excludeFields']) && $_REQUEST['excludeFields']!='' ? $_REQUEST['excludeFields'] : '';
			$excludeFields = $excludeFields!='' ? explode(',',$excludeFields) : array();
			$fields = $db->fetcharray('select sys_'.$tableName.'_fields.name as fieldName,sys_'.$tableName.'_fields.* from sys_'.$tableName.'_fields');
			
			if( $clear=='yes' ){
				$db->__runquery_('truncate mod_person');
				$index = 0;
				while ( ($csvvalue = fgetcsv( $fp, 1000, "," )) !== FALSE ) {
//					print_r($csvvalue);die;
					if( $index!=0 ){
						$query = 'insert into mod_'.$tableName.'(';
						$queryEnds = '';
						foreach( $fields as $key=>$value ){
							if( in_array($value['name'],$excludeFields) === false && isSet($csvvalue[$key]) ){
								// check for module content controls
								if( $value['sys_control_id']=='21' ){
									parse_str($value['controlValues']);
									echo "checking for a +:".$csvvalue[$key]."\n";
									if( strstr($csvvalue[$key],'+')>-1 ){
										echo "found one\n";
										$valuesSplit = split('\+',$csvvalue[$key]);
										$csvvalue[$key] = '';
										foreach( $valuesSplit as $key2=>$value2 ){
											if( !($values = $db->fetchrownamed("select mod_".$moduleName."_id from mod_".$moduleName.' where LOWER(name)=LOWER("'.str_replace('"','\"',trim( $value2 )).'")')) && trim($value2)!='' ){
												// insert it
												$db->__runquery_('insert into mod_'.$moduleName.'(name) values("'.$value2.'")');
												echo $moduleName." entry not found, new one created:".$value2.':'.'insert into mod_'.$moduleName.'(name) values("'.$value2.'")'."\n";
												$csvvalue[$key] .= ($key2!=0 ? ',' : '').$db->__lastID_();
											}else{
												$csvvalue[$key] .= ($key2!=0 ? ',' : '').$values["mod_".$moduleName."_id"];
												echo "found existing entry for:".$value2." value is:".$csvvalue[$key]."\n";
											}
										}
									}else if( !($values = $db->fetchrownamed("select mod_".$moduleName."_id from mod_".$moduleName.' where LOWER(name)=LOWER("'.str_replace('"','\"',trim( $csvvalue[$key] )).'")')) && trim($csvvalue[$key])!='' ){
										// insert it
										$db->__runquery_('insert into mod_'.$moduleName.'(name) values("'.$csvvalue[$key].'")');
										echo $moduleName." entry not found, new one created:".$csvvalue[$key].':'.'insert into mod_'.$moduleName.'(name) values("'.$csvvalue[$key].'")'."\n";
										$csvvalue[$key] = $db->__lastID_();
									}else{
										$csvvalue[$key] = $values["mod_".$moduleName."_id"];
									}
								}
								$query .= $value['name'].($key!=count($fields)-1 ? ',' : '');
								$queryEnds .= '"'.str_replace('"','\"',trim( $csvvalue[$key] )).'"'.($key!=count($fields)-1 ? ',' : '');
							}
						}
						$query = eregi(",$",$query) ? eregi_replace(",$","",$query) : $query;
						$queryEnds = eregi(",$",$queryEnds) ? eregi_replace(",$","",$queryEnds) : $queryEnds;
						$query = $query.') values('.$queryEnds.')'."\n\n";
						$db->__runquery_($query);

					}
					$index++;
					//$db->__runquery_($query);
				}
			}else{
				$content = $db->fetcharray('select name as contentName,mod_'.$tableName.'.mod_'.$tableName.'_id as mod_content_id,mod_'.$tableName.'.* from mod_'.$tableName.(isSet( $search ) && $search != '' ? ' where  name like "%' . $search . '%"' : '')." order by name");
				$query = '';
				$index = 0;
				while ( ($csvvalue = fgetcsv( $fp, 1000, "," )) !== FALSE ) {
					if( $index!=0 ){
						$query = 'update mod_'.$tableName.' set ';
						foreach( $fields as $key=>$value ){
							if( in_array($value['name'],$excludeFields) === false ){
								if( $value['sys_control_id']=='21' ){
									parse_str($value['controlValues']);
									echo "checking for a +:".$csvvalue[$key]."\n";
									if( strstr($csvvalue[$key],'+')>-1 ){
										echo "found one\n";
										$valuesSplit = split('\+',$csvvalue[$key]);
										$csvvalue[$key] = '';
										foreach( $valuesSplit as $key2=>$value2 ){
											if( !($values = $db->fetchrownamed("select mod_".$moduleName."_id from mod_".$moduleName.' where LOWER(name)=LOWER("'.str_replace('"','\"',trim( $value2 )).'")')) && trim($value2)!='' ){
												// insert it
												//$db->__runquery_('insert into mod_'.$moduleName.'(name) values("'.$value2.'")');
												echo $moduleName." entry not found, new one created:".$value2.':'.'insert into mod_'.$moduleName.'(name) values("'.$value2.'")'."\n";
												$csvvalue[$key] .= ($key2!=0 ? ',' : '').$db->__lastID_();
											}else{
												$csvvalue[$key] .= ($key2!=0 ? ',' : '').$values["mod_".$moduleName."_id"];
												echo "found existing entry for:".$value2." value is:".$csvvalue[$key]."\n";
											}
										}
									}else if( !($values = $db->fetchrownamed("select mod_".$moduleName."_id from mod_".$moduleName.' where LOWER(name)=LOWER("'.str_replace('"','\"',trim( $csvvalue[$key] )).'")')) && trim($csvvalue[$key])!='' ){
										// insert it
										//$db->__runquery_('insert into mod_'.$moduleName.'(name) values("'.$csvvalue[$key].'")');
										echo $moduleName." entry not found, new one created:".$csvvalue[$key].':'.'insert into mod_'.$moduleName.'(name) values("'.$csvvalue[$key].'")'."\n";
										$csvvalue[$key] = $db->__lastID_();
									}else{
										$csvvalue[$key] = $values["mod_".$moduleName."_id"];
									}
								}
								echo "final value is:".$value['name'].'='.'"'.str_replace('"','\"',trim( $csvvalue[$key] ))."\"\n";
								$query .= $value['name'].'='.'"'.str_replace('"','\"',trim( $csvvalue[$key] )).'"'.($key!=count($fields)-1 ? ',' : '');
							}
						}
						$query = eregi(",$",$query) ? eregi_replace(",$","",$query) : $query;
						$query .= ' where mod_'.$tableName.'_id='.$content[$index]['mod_'.$tableName.'_id']."";
						echo $query."\n";
						if( $index == 20 ){
							die;
						}
						/*
						 * 
						 * 
						 */
						//showInExtranet,bioImage,miniBiography,fullBiography,listingBio,username,password
					}
					$index++;
				}
				
				die;
			}
		break;
	}
	
    // base calculations
	$startNumber = $currentPage*$itemsPerPage;
    $endNumber = $startNumber+$itemsPerPage;
    
	$listQueryLmiter = ' limit '.$startNumber.','.($totalItemsToGet < $itemsPerPage && $totalItemsToGet!=0 ? $totalItemsToGet : $itemsPerPage);
			
    // get the count    
    $countResults = $db->fetchrownamed('select count(*) from mod_'.$tableName.(isSet( $search ) && $search != '' ? ' where  name like "%' . $search . '%"' : '')." order by name");
    
    //echo $listQueryCount.$listQuery;die;
    $moduleValues['skinFunctions']['loop']['pages'] = array();
    if( $countResults['count(*)']>0 ){
 		   	// calculate the resulting pages
            $totalPages = round(($countResults['count(*)']/$itemsPerPage)-0.49);
            $startNumber = $currentPage*$itemsPerPage;
            $endNumber = $startNumber+$itemsPerPage;
            $endNumber = $endNumber > $countResults['count(*)'] ? $countResults['count(*)'] : $endNumber;
            
            $moduleValues['skinFunctions']['loop']['resultPages'] = array();
            for( $counter=0; $counter<=$totalPages; $counter++ ){
	            $moduleValues['skinFunctions']['loop']['resultPages'][$counter] = array();
	            $moduleValues['skinFunctions']['loop']['resultPages'][$counter]['pageNumber'] = $counter+1;
//	            $moduleValues['skinFunctions']['loop']['pages'][$counter]['pageUrl'] = '?orderBy'=>$orderBy,'orderDirection'=>$orderDirection,'pageNumber'=>$counter));
	            $moduleValues['skinFunctions']['loop']['resultPages'][$counter]['pageUrl'] = '?currentPage='.$counter.'&tableName='.$tableName.'&search='.$search.'&contentType_id='.$contentType_id;
	            $moduleValues['skinFunctions']['loop']['resultPages'][$counter]['pageNumberDisplay'] = $counter+1;
	            $moduleValues['skinFunctions']['loop']['resultPages'][$counter]['append'] = $counter==$currentPage ? 'selected' : '';
	            $moduleValues['skinFunctions']['loop']['resultPages'][$counter]['prepend'] = $counter==$currentPage ? 'selected' : '';
            }
            // generate next and previous
/*            $moduleValues['skinFunctions']['var']['nextPage'] = ($currentPage)!=$totalPages && $totalPages!=0 ? '<a href="<var:pagePath>?'.$this->url->create('get',array('orderBy'=>$orderBy,'orderDirection'=>$orderDirection,'pageNumber'=>($currentPage+1))).'" class="nav">next>></a>' : '';
            $moduleValues['skinFunctions']['var']['previousPage'] = $currentPage!=0 ? '<a href="<var:pagePath>?'.$this->url->create('get',array('orderBy'=>$orderBy,'orderDirection'=>$orderDirection,'pageNumber'=>($currentPage-1))).'" class="nav">&lt;&lt;previous</a>' : '';
            $moduleValues['skinFunctions']['var']['orderBy'] = $orderBy;
            $moduleValues['skinFunctions']['var']['currentPage'] = $currentPage;
            $moduleValues['skinFunctions']['var']['currentPageDisplay'] = $currentPage+1;
            $moduleValues['skinFunctions']['var']['totalPages'] = $totalPages+1;*/
            $moduleValues['skinFunctions']['var']['nextPage'] = ($currentPage)!=$totalPages && $totalPages!=0 ? '<a href="<var:pagePath>?currentPage='.($currentPage+1).'&search='.$search.'&stakeholderGroup_id='.$stakeholderGroup_id.'" class="nav">next>></a>' : '';
            $moduleValues['skinFunctions']['var']['previousPage'] = $currentPage!=0 ? '<a href="<var:pagePath>?'.'currentPage='.($currentPage-1).'&search='.$search.'&stakeholderGroup_id='.$stakeholderGroup_id.'" class="nav">&lt;&lt;previous</a>' : '';
            $moduleValues['skinFunctions']['var']['currentPage'] = $currentPage;
            $moduleValues['skinFunctions']['var']['currentPageDisplay'] = $currentPage+1;
            $moduleValues['skinFunctions']['var']['totalPages'] = $totalPages+1;
            // recalc bioimage
            
    }
    
	
	// get all the content in the system
	$content = $db->fetcharray('select name as contentName,mod_'.$tableName.'.mod_'.$tableName.'_id as mod_content_id,mod_'.$tableName.'.* from mod_'.$tableName.(isSet( $search ) && $search != '' ? ' where  name like "%' . $search . '%"' : '')." order by name".$listQueryLmiter);
	
	foreach( $content as $key=>$value ){
		$content[$key]['contentFriendlyName'] = htmlspecialchars(str_replace("'","",$value['contentName']));
	}
	
	$moduleValues['skinFunctions']['loop']['content'] = $content;
	$moduleValues['skinFunctions']['var']['currentTableName'] = $tableName;
	$moduleValues['skinFunctions']['var']['contentType_id'] = $contentType_id;	
}

?>