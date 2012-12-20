<?
require_once (".citadel.config.conf");
include_once ($__CONFIG_ ['__paths_'] ['__installationPath_'] . '/clients/' . $__CONFIG_ ['__paths_'] ['__clientPath_'] . '/files/includes/lib/xmlrpc.php');

$db = $GLOBALS ['__APPLICATION_'] ['database'];

$accl = isSet ( $_SESSION ['accl'] ) && $_SESSION ['accl'] != '' ? $_SESSION ['accl'] : "00102";
$clientCode = isSet ( $_SESSION ['clientCode'] ) && $_SESSION ['clientCode'] != '' ? $_SESSION ['clientCode'] : "FHF";
$accl = isSet ( $_REQUEST ['accl'] ) && $_REQUEST ['accl'] != '' ? $_REQUEST ['accl'] : $accl;
$clientCode = isSet ( $_REQUEST ['clientCode'] ) && $_REQUEST ['clientCode'] != '' ? $_REQUEST ['clientCode'] : $clientCode;

//$beamRequestLookup = array ('debtorComment' => 'eqar10', 'debtorTransaction' => 'eqat10' );
$beamRequestLookup = array ('debtorTransaction' => 'eqat10' ,'debtorComment' => 'eqar10' );

$tableToSync = isSet ( $_REQUEST ['tableToSync'] ) && $_REQUEST ['tableToSync'] != '' ? $_REQUEST ['tableToSync'] : 'debtorComment';

$result = XMLRPC_request ( "sourceline.co.za:8080", "/xmlrpc", 'FiberAuthenticationHandler.authenticate', array (XMLRPC_prepare ( "vertex" ), XMLRPC_prepare ( "souix01" ), XMLRPC_prepare ( "fhfDynafin" ) ) );
$uniqueID = $result [1];

//    $debtor['accountNumber'] = $debtor['accountNumber']=='' ? $userClient['clientCode'].$debtor['mod_debtor_id'] : $debtor['accountNumber'];


$debtors = $db->fetcharray ( 'select * from mod_debtor where debtorStatus=4' );

$comparisonTable = array ();

foreach ( $debtors as $key => $value ) {
	
	$db->__runquery_('delete from mod_debtorTransaction where debtor='.$value['mod_debtor_id']);
	
	foreach ( $beamRequestLookup as $key2 => $value2 ) {
		$tableToSync = $key2;
		$debtor = $value;
		
		$request = $beamRequestLookup [$tableToSync];
		
		$result = XMLRPC_request ( "sourceline.co.za:8080", "/xmlrpc", 'DynafinHandler.makeRequest', array (XMLRPC_prepare ( $request ), XMLRPC_prepare ( $accl ), XMLRPC_prepare ( $value ['accountNumber'] ), XMLRPC_prepare ( $uniqueID ) ) );
		
		if (eregi ( "Error", $result [1] )) {
			$moduleValues ['skinFunctions'] ['var'] ['errorMessage'] = $result [1];
			$changeDateTime = date ( "Y-m-d H:i:s" );
			mail("mare@sourceline.co.za,ken@sourceline.co.za,jason@fhf.co.za","Beam Error when running sync","Account not in beam or error from beam when running syncronisation\n\n Account Number:".$value ['accountNumber'],"From: FHF Dynafin System <system@fhf.co.za>");
		//			$db->__runquery_ ( "INSERT INTO `mod_dpPlusUnitEvent` ( `name`, `eventDescription`, `eventDate`, `eventType`, `eventBy`, `assignedToUser`, `debtor`) VALUES ( 'Error from BEAM:" . $accode . ":" . $changeDateTime . "', '" . $result [1] . "', '" . $changeDateTime . "', 5, 'user', '" . $GLOBALS ['siteSession']->user->userDetail ['sys'] ['mod_applicationUser_id'] . "', " . $appID . ")" );
		} else {
			
			if ($tableToSync == 'debtorTransaction') {
				$db->__runquery_('delete from mod_debtorTransaction where debtor='.$value['mod_debtor_id']);
				echo "Deleting transactions for ".$value['accountNumber']."\n";
			}
			
			
			$result = explode ( "\n", $result [1] );
			array_pop ( $result );
			$result = array_reverse ( $result );
			array_pop ( $result );
			$result [count ( $result )] = "<?xml version=\"1.0\"?>";
			$result = array_reverse ( $result );
			$result = implode ( "\n", $result );
			
			//			echo $result;
			
			if ($result != "<?xml version=\"1.0\"?>") {
				
				$xml = new SimpleXMLElement ( $result );
				
				if (count ( $xml->chunk [0]->line ) > 1) {
					foreach ( $xml->chunk [0]->line as $line ) {
						if (count ( $line->val ) > 0) {
							$lineVars = array ();
							foreach ( $line->val as $val ) {
								$dimName = $val ['name'] . "";
								$lineVars [$dimName] = array ();
								if ($dimName == 'ARDAT') {
									$dateT = strtotime ( trim ( $val ) . "" );
									$lineVars [$dimName] = date ( "d M Y", $dateT );
									$lineVars [$dimName . 'DB'] = date ( "Y-m-d", $dateT );
								} else {
									$lineVars [$dimName] = $val . "";
								}
								if ($dimName == 'ARRMOD') {
									$user = $db->fetchrownamed ( 'select * from mod_applicationUser where mod_applicationUser_id=' . $lineVars [$dimName] );
									$lineVars [$dimName] = $user ['name'];
									$lineVars [$dimName . 'ORIG'] = $val;
									if ($val == 'KEN') {
										$lineVars [$dimName . 'ORIG'] = 13;
										$lineVars [$dimName] = 'Ken';
									}
								}
								if ($dimName == 'ATTYP') {
									$user = $db->fetchrownamed ( 'select * from mod_debtorTransactionType where beamId="' . $val . '"' );
									$lineVars ['mod_debtorTransactionType_id'] = $user ['mod_debtorTransactionType_id'];
								}
								if (strstr ( $dimName, "DAT" )) {
									$dateT = strtotime ( $val . "" );
									$lineVars [$dimName] = date ( "d M Y", $dateT );
									$lineVars [$dimName . 'DB'] = date ( "Y-m-d", $dateT );
								}
							}
							
							if ($tableToSync == 'debtorComment') {
								//								echo 'select * from mod_debtorComment where name="'.$value['name'].' - '.$lineVars['ARDAT'].'-'.$lineVars['ARRMOD'].'" and commentDate="'.$lineVars['ARDATDB'].'" and comment="'.$lineVars['ARREM'].'" and debtor='.$value['mod_debtor_id'].'<br>';
								if (! ($db->fetchrownamed ( 'select * from mod_debtorComment where name="' . $value ['name'] . ' - ' . $lineVars ['ARDAT'] . '-' . $lineVars ['ARRMOD'] . '" and commentDate="' . $lineVars ['ARDATDB'] . '" and comment="' . $lineVars ['ARREM'] . '" and debtor=' . $value ['mod_debtor_id'] . '' ))) {
									$query = 'insert into mod_debtorComment( name, commentDate, comment, debtor' . ($lineVars ['ARRMODORIG'] != '' ? ', assignedToUser' : '') . ' ) values( "' . $value ['name'] . ' - ' . $lineVars ['ARDAT'] . '-' . $lineVars ['ARRMOD'] . '","' . $lineVars ['ARDATDB'] . '","' . $lineVars ['ARREM'] . '",' . $value ['mod_debtor_id'] . ($lineVars ['ARRMODORIG'] != '' ? ',' . $lineVars ['ARRMODORIG'] : '') . ')';
									$db->__runquery_ ( $query );
									echo $query;
								}
							
							} else if ($tableToSync == 'debtorTransaction') {
								echo 'select * from mod_debtorTransaction where name="' . $value ['name'] . ' - ' . $lineVars ['ATDAT'] . '-' . $lineVars ['ATREF'] . '-R' . $lineVars ['ATAMT'] . '-'.$lineVars['ATSEQ'].'"'."\n";
								if (! ($db->fetchrownamed ( 'select * from mod_debtorTransaction where name="' . $value ['name'] . ' - ' . $lineVars ['ATDAT'] . '-' . $lineVars ['ATREF'] . '-R' . $lineVars ['ATAMT'] . '-'.$lineVars['ATSEQ'].'"' ))) {
$query = 'insert into mod_debtorTransaction( name, actualDate, transactionType, reference, amount, dateCaptured, narrative, debtor, balance, arrears ) values( 
									"' . $debtor ['name'] . ' - ' . $lineVars ['ATDAT'] . '-' . $lineVars ['ATREF'] . '-R' . $lineVars ['ATAMT'] . '","' . $lineVars ['ATDATDB'] . '",' . $lineVars ['mod_debtorTransactionType_id'] . ',"' . $lineVars ['ATREF'] . '","' . $lineVars ['ATAMT'] . '","' . $lineVars ['ATMDATDB'] . '","' . $lineVars ['ATNAR'] . '",' . $debtor ['mod_debtor_id'] . ',"' . $lineVars ['ACBAL'] . '","'.$lineVars['ACARR'].'")';
									$db->__runquery_ ( $query );
									echo $query;
								}
							
							}
						
						}
					}
				}
			}
		}
	}

}

?>
