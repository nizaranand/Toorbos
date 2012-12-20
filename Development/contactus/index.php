<?
require_once ("../../../../config/.citadel.config.conf");
if( ! isSet( $_REQUEST['fiberExport'] ) && !isSet($_REQUEST['fiberPDF']) ){
	ob_start();
}
$editMode = isSet( $_REQUEST['editMode'] ) ? $_REQUEST['editMode'] : 0;
$createMode = isSet( $_REQUEST['createMode'] ) ? $_REQUEST['createMode'] : 0;
$__APPLICATION_['channel'] = new channel( array('in' => array('path' => 'sites', 'section' => 'www', 'skin' => 'blankChannel.tpl' ) ) );
$module = new module(array('in'=>array('sys_tree_id'=>3092,'editMode'=>$editMode,'createMode'=>$createMode)),'');
$__APPLICATION_['channel']->channelReplace('<var:output>',$module->output());
if( !isSet($_REQUEST['fiberExport']) && !isSet($_REQUEST['fiberPDF']) ){
	ob_end_clean();
}
if( !isSet($_REQUEST['fiberPDFNew']) && !isSet($_REQUEST['fiberExport']) && !isSet($_REQUEST['fiberEmail']) && !isSet($_REQUEST['fiberPDF'])  ){
	$__APPLICATION_['channel']->show();
}else if( isSet($_REQUEST['fiberExport']) ){
	header("Content-type: application/octet-stream");
	header("Content-disposition: attachment; filename=\"".$_REQUEST['fiberExportFileName'].'.csv"');
	echo $__APPLICATION_['channel']->show();
	die;
}else if( isSet($_REQUEST['fiberEmail']) ){
	// determine from name and email
	$fromSplit = split("<",$_REQUEST['fiberEmailFrom']);
	$fromName = $fromSplit[0];
	$fromEmail = str_replace(">","",$fromSplit[1]);
	$fileName = $_REQUEST['fiberEmailSubject'].microtime().'.html';
	$GLOBALS['__APPLICATION_']['utilities']->writeFile('/tmp/'.$fileName,$__APPLICATION_['channel']->show());
	$GLOBALS['__APPLICATION_']['utilities']->sendhtmlemailembedded($_REQUEST['fiberEmailTo'], $fromEmail, $fromName, $_REQUEST['fiberEmailSubject'], "HTML page attached", "HTML page attached",array(),'/tmp/'.$fileName);
	//  $__APPLICATION_['utilities']->sendhtmlemail($_REQUEST['fiberEmailTo'], $_REQUEST['fiberEmailFrom'], $_REQUEST['fiberEmailSubject'], "Your email client doesn't support HTML.", $__APPLICATION_['channel']->show());
}else if( isSet($_REQUEST['fiberPDFNew']) ){

	$url = str_replace('&fiberPDFNew=1','',str_replace('?fiberPDFNew=1','',$_SERVER['REQUEST_URI']));
	$url = str_replace($__CONFIG_['__paths_']['__urlPath_'],'',str_replace('?fiberPDFNew=1','',$url));

	if( strstr($_SERVER['HTTP_HOST'],'192.168.2.11')>-1 ){
		$url = $GLOBALS['__APPLICATION_']['channel']->getBaseURL().$url;
		$url = str_replace('192.168.2.11','sourceline.bounceme.net',$url);
	}else{
		$url = $GLOBALS['__APPLICATION_']['channel']->getBaseURL().$url;
	}

	$url = str_replace('//','/',$url);
	$url = str_replace('http:/','http://',$url);

	$url .= (strstr($url,'?') > -1 ? '&' : '?').'fiberPDFSkin=1';
	//echo $url;
	//$url = urlencode($url.(strstr($url,'?') > -1 ? '&' : '?').'fiberPDFSkin=1');

	include_once ($__CONFIG_['__paths_']['__installationPath_'] . '/clients/' . $__CONFIG_['__paths_'] ['__clientPath_'] . '/files/includes/lib/xmlrpc.php');

	$result = XMLRPC_request ( "sourceline.co.za:8080", "/xmlrpc", 'FiberAuthenticationHandler.authenticate', array (XMLRPC_prepare ( "vertex" ), XMLRPC_prepare ( "souix01" ), XMLRPC_prepare ( "fhfDynafin" ) ) );
	$uniqueID = $result [1];
	$documentName = '/tmp/'.$module->moduleValues['content']['name'].'-'.microtime().'.pdf';

	$result = XMLRPC_request ( "sourceline.co.za:8080", "/xmlrpc", 'FiberDocuments.createPDFDocument', array (XMLRPC_prepare ( $url ), XMLRPC_prepare ( $documentName ), XMLRPC_prepare ( $uniqueID ) ) );
		
	if (eregi ( "Error", $result [1] )) {
	}else{
		if( isSet($_REQUEST['fiberPDFEmail']) ){
			//$GLOBALS['__APPLICATION_']['utilities']->sendhtmlemailembedded($_REQUEST['fiberPDFEmail'], 'fiber@fiber.co.za', 'Fiber', 'PDF', "HTML page attached", "HTML page attached",array(),'/tmp/'.$module->moduleValues['content']['name'].'-'.microtime().'.pdf');
			$GLOBALS['__APPLICATION_']['utilities']->sendmailattachment($_REQUEST['fiberPDFEmail'], 'Fiber <system@fiber.co.za>', $documentName, "dfgdfg", "application/pdf", $documentName);
			//$GLOBALS['__APPLICATION_']['utilities']->sendhtmlemailembedded('mare@sourceline.co.za', 'fiber@fiber.co.za', 'Fiber', 'PDF', "HTML page attached", "HTML page attached",array(),$documentName);
		}
	}
	$__APPLICATION_['channel']->show();
}else if( isSet($_REQUEST['fiberPDF']) ){

	$pdf_screen_size = 800;
	//paper size (Letter,Legal,Executive,A0Oversize,A0,A1,A2,A3,A4,A5,B5,Folio,A6,A7,A8,A9,A10)
	$pdf_paper_size = "A4";
	//eft margin of the pdf
	//pdf_left_margin = 15;
	//#right margin of the pdf
	$pdf_right_margin = 15;
	//#top margin of the pdf
	$pdf_top_margin = 15;
	//#bottom margin of the pdf
	$pdf_bottom_margin = 15;


	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");       // Date in the past

	$myloc  = $GLOBALS['__APPLICATION_']['channel']->getBaseURL()."/_admin/tools/pdf/html2ps.php";  // This file must be in the root of the application folder where the index.php resides
	$myloc .= "?";
	$myloc .= "&process_mode=single";
	$myloc .= "&renderfields=1";
	$myloc .= "&renderlinks=1";
	$myloc .= "&renderimages=1";
	$myloc .= "&scalepoints=1";
	$myloc .= "&pixels="            . $pdf_screen_size;
	$myloc .= "&media="             . $pdf_paper_size;
	$myloc .= "&leftmargin="        . $pdf_left_margin;
	$myloc .= "&rightmargin="       . $pdf_right_margin;
	$myloc .= "&topmargin="         . $pdf_top_margin;
	$myloc .= "&bottommargin="      . $pdf_bottom_margin;
	$myloc .= "&transparency_workaround=1";
	$myloc .= "&imagequality_workaround=1";
	$myloc .= "&output=1";
	$myloc .= "&location=pdf";
	$myloc .= "&pdfname="           . $module->moduleValues['content']['name'].'-'.microtime().'.pdf';
	$url = str_replace('&fiberPDF=1','',str_replace('?fiberPDF=1','',$_SERVER['REQUEST_URI']));
	$url = str_replace($__CONFIG_['__paths_']['__urlPath_'],'',str_replace('?fiberPDF=1','',$url));

	if( strstr($_SERVER['HTTP_HOST'],'sourceline.bounceme.net')>-1 ){
		$url = $GLOBALS['__APPLICATION_']['channel']->getBaseURL().$url;
		$url = str_replace('sourceline.bounceme.net','192.168.2.11',$url);
	}else{
		$url = $GLOBALS['__APPLICATION_']['channel']->getBaseURL().$url;
	}
	$myloc .= "&URL="                       . urlencode($url.(strstr($url,'?') > -1 ? '&' : '?').'fiberPDFSkin=1');
	//echo $myloc;die;



	header("Location: $myloc");


}
?>