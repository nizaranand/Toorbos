<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title><if:title!=><var:title></if><if:title==><var:seoTitle></if></title>
	<meta name="keywords" content="<var:metaKeywords>">
	<meta name="description" content="<var:metaDescription>">
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<meta name="google-site-verification" content="<site:googleVerification>">
	<meta http-equiv="expires" content="-1">
	<meta http-equiv= "pragma" content="no-cache" >
	<meta name="robots" content="all">
	<meta name="MSSmartTagsPreventParsing" content="true">  
	<base href="<var:baseURL>">
 	<meta name="author" content="RightBrain Technologies">
 	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/tango/skin.css">
	<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.1.custom.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/colorbox.css">
	<script type="text/javascript" src="web/jquery-1-4-2-min.js"></script>
	<script type="text/javascript" src="web/jquery-colorbox.js"></script>
	<script type="text/javascript" src="web/jquery-ui-1-8-1-custom-min.js"></script>
	<style type="text/css">
		BODY{
			background-color: <var:bgColor>;
			text-color: <var:textColor>;
		}
		
		A {
			color:<var:menuBGColor>;
		}
	
		A:visited {
			color:<var:menuSelectedBGColor>;
		}
		
		A:hover {
			color:<var:menuSelectedBGColor>;
		}
		
		H1{
			color:<var:headingColor>;
		}
		
		H2{
			color:<var:headingColor>;
		}
		
		H3{
			color:<var:headingColor>;
		}
		
		H4{
			color:<var:headingColor>;
		}
		
		H5{
			color:<var:headingColor>;
		}
		
		.menuBg{
			background-color:<var:menuBGColor>;
		}
		
		.topMenu{
			background-color:<var:menuBGColor>;
		}
		
		.topMenu A{
			color: <var:menuTextColor>;
		}
			
		.topMenu .active{
			background-color: <var:menuSelectedBGColor>;
			color:<var:menuSelectedTextColor>;
		}
		
		
		.topMenu .current{
			background-color: <var:menuSelectedBGColor>;
			color:<var:menuSelectedTextColor>;
		}
		
	
		.header{
			background-color:<var:primaryColor>;
		}
		
		.body{
			background-color: <var:pageBGColor>;
		}
		
	</style>
 </head>
<body>
	<div style="width:100%;background-color:#92131f;">
		<div style="width:100%;"><center><span style="color:#a91724;size:6px;"><var:metaKeywords></span></center></div>
	</div>
	<div class="header">
		<ol style="list-style-type:none;">
			<li class="headerLayout">
				<ol>
					<li class="logo">
						<a href="<var:baseURL>" title="<var:title>"><img src="files/site/6/<site:logo>" title="<var:title> | <var:seoTitle>" alt="<var:title> | <var:seoTitle>" border="0"/></a>
					</li>
				</ol>
				<ol><li class="menuBg">
					<module:autoMenu:Top:1>
				</li></ol>
			</li>
		</ol>
	</div>
	<div class="body">
		<h1><var:title> | <var:seoTitle></h1>
		<module:container:Content:1> 
		<div class="footer">	
		<module:wysiwyg:Footer:1>
		</div>
		<div class="footer">	
		<p align="center"><a target="_blank" href="http://www.rightbrain.co.za"><span style="font-size: small;"><span style="font-family: Verdana;">Creation</span></span></a> <span style="font-size: small;"><span style="font-family: Verdana;"> by RightBrain Technologies</span></span></p>
		<p align="center"><span style="font-size: small;"><span style="font-family: Verdana;">Powered by </span></span><a target="_blank" href="http://www.fiberplatform.com"><span style="font-size: small;"><span style="font-family: Verdana;padding-top:5px;"><img height="16" border="0" width="50" alt="Fiber Logo" src="images/fiberLogo.png" /></span></span></a></p>
		</div>
	</div>
		<script type="text/javascript">
			 var _gaq = _gaq || [];
			 _gaq.push(['_setAccount', '<site:googleAnalytics>']);
			 _gaq.push(['_trackPageview']);
			 (function() {
			  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			 })();

			$(document).ready(function(){
				
				$(".topMenu A").mouseover(function(){
					if( !$(this).is(".current") ){
						$(this).addClass("active");
					}				
				});
	
				$(".topMenu A").mouseout(function(){
					$(this).removeClass("active");				
				});

			});
			
		</script>

<center><span style="color:#c9c9c9;size:8px;"><var:metaKeywords></span></center>
</body>
</html>