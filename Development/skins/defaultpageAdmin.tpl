<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<meta http-equiv="expires" content="-1">
	<meta http-equiv= "pragma" content="no-cache" />
	<meta name="author" content="RightBrain">
	<meta name="robots" content="all">
	<meta name="MSSmartTagsPreventParsing" content="true">
	<meta name="description" content="<var:metaDescription>">
	<meta name="keywords" content="<var:metaKeywords>">   
	<base href="<var:baseURL>">
	<title>Fiber Platform - Administration System</title>
	
	<link href="css/admin.css" rel="stylesheet" type="text/css" />
	<link href="css/customClient.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<var:baseURL><var:adminPath>/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
	<link href="css/uploadify.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="css/jwysiwyg/jquery-wysiwyg.css" type="text/css" />
	<link rel="stylesheet" media="screen" type="text/css" href="css/colorpicker.css" />
	<link type="text/css" rel="stylesheet" media="screen" href="css/thickbox.css" >
	<link type="text/css" rel="stylesheet" media="screen" href="<var:baseURL><var:adminPath>/css/ui-lightness/jquery-ui.css" >
	<link rel="stylesheet" type="text/css" href="<var:baseURL><var:adminPath>/css/fiber.css">

	<script type="text/javascript" src="<var:baseURL><var:adminPath>js/jquery.js"></script>	
	<script type="text/javascript" src="<var:baseURL><var:adminPath>/js/fancybox/jquery.fancybox-1.3.4.js"></script>
	<script type="text/javascript" src="web/thickbox-compressed.js"></script>
	<script type="text/javascript" src="web/jquery-uploadify.js"></script>
	<script type="text/javascript" src="web/jquery-wysiwyg.js"></script>
	<script type="text/javascript" src="web/swfobject.js"></script>
	<script type="text/javascript" src="web/colorpicker.js"></script>
	<script type="text/javascript" src="web/jquery-qtip-1-0-0-rc3.js"></script>
	<script type="text/javascript" src="<var:baseURL><var:adminPath>js/fiber.js"></script>
	
	<script type="text/javascript">
	    var applicationUserId = '<user:mod_applicationUser_id>';
	    var applicationUserType = '<user:userType>';
	    var baseURL = '<var:baseURL>';
	    var adminPath = '<var:adminPath>';
	    var sessionID = '<var:PHPSESSID>';
	</script>

</head>
<body>
<div class="banner">
	<div class="centered">
		<div class="right padding welcome">
			Welcome back <user:username>, &nbsp <a href="_admin/logout.php">Logout</a>&nbsp;
		</div>
		<div class="left padding" style="padding-left:0px;"></div><img src="_admin/images/fiberplatform.png" alt="Fiber Platform"></div>
	</div>
</div>
<div class="menu">
	<div class="centered blue" style="padding-left:50px;">
						<a href="<var:baseURL>admin/" class="<var:selected>">Configure Site</a>
						<a href="<var:baseURL>admin/editpages/" class="<var:selected>">Edit Pages</a>
						<a href="<var:baseURL>admin/editcontent/" class="<var:selected>">Edit Content</a>
	</div>
</div>
<div class="centered background">
	<div class="paddingx2 content">
		<div class="left" style="width:100%">
			<module:container:Middle:1>
		</div>
	</div>
</div>
</body>
</html>

<!-- 
	<div align="center" class="headerBar">
		<div class="headerDiv">
			<div class="leftFloat" title="Fiber Content Management System"><a href="admin/"><img border="0" src="images/Fiber/fiberLogo.jpg"></a></div>
			<div class="topMenuDiv">
				<table cellpadding="5" cellspacing="7" border="0">
					<tr>
						<td title="Configure Site"><a href="<var:baseURL>admin/"><img border="0" src="images/Fiber/icon-editStyles.jpg"></a></td>
						<td title="Configure Site"><a href="<var:baseURL>admin/" class="topMenuText">Configure Site</a></td>
						<td title="List Editable Pages"><a href="<var:baseURL>admin/editpages/"><img border="0" src="images/Fiber/icon-editPage.jpg"></a></td>
						<td title="List Editable Pages"><a href="<var:baseURL>admin/editpages/" class="topMenuText">Edit Pages</a></td>
						<td title="List Editable Content"><a href="<var:baseURL>admin/editcontent/"><img border="0" src="images/Fiber/icon-editContent.jpg"></a></td>
						<td title="List Editable Content"><a href="<var:baseURL>admin/editcontent/" class="topMenuText">Edit Content</a></td>
					</tr>
				</table>
			</div>
			<div class="rightFloat" title="Visit Our Website"><a href="http://www.rightbrain.co.za/"><img border="0" src="images/Fiber/rightbrainLogo.png"></a></div>
		</div>
	</div>
	<div class="mainBodyDiv">
		<module:container:Middle:1>
	</div>
	<script type="text/javascript">
		function openField(element){
			$("#"+element+"Content").fadeIn(20);
			$("#"+element+"Open").fadeOut(20);		
			$("#"+element+"Close").fadeIn(20);
		}
	
		function closeField(element){
			$("#"+element+"Content").fadeOut(20);
			$("#"+element+"Open").fadeIn(20);		
			$("#"+element+"Close").fadeOut(20);
		}	
		
		$(document).ready(function(){
			$('img[title]').qtip({
	            content: false, 
	            position: {
	                adjust: {
	                      screen: true
	                }
	            },
	            show: {
	               when: "mouseover",
	               ready: false
	            },
	            hide: "mouseout", 
	            style: {
	               border: {
	                  width: 2,
	                  radius: 10
	               },
	               padding: 10, 
	               textAlign: 'center',
	               tip: true, 
	               name: 'dark',
	               "font-family":"Arial",
	               "font-size":"14px"
	            }
			});
			$('input[title]').qtip({
	            content: false, 
	            position: {
	                adjust: {
	                      screen: true
	                }
	            },
	            show: {
	               when: "mouseover",
	               ready: false
	            },
	            hide: "mouseout", 
	            style: {
	               border: {
	                  width: 2,
	                  radius: 10
	               },
	               padding: 10, 
	               textAlign: 'center',
	               tip: true, 
	               name: 'dark',
	               "font-family":"Arial",
	               "font-size":"14px"
	            }
			});
			$('a[href][title]').qtip({
	            content: false, 
	            position: {
	                adjust: {
	                      screen: true
	                }
	            },
	            show: {
	               when: "mouseover",
	               ready: false
	            },
	            hide: "mouseout", 
	            style: {
	               border: {
	                  width: 2,
	                  radius: 10
	               },
	               padding: 10, 
	               textAlign: 'center',
	               tip: true, 
	               name: 'dark',
	               "font-family":"Arial",
	               "font-size":"14px"
	            }
			});
			$('div[title]').qtip({
	            content: false, 
	            position: {
	                adjust: {
	                      screen: true
	                }
	            },
	            show: {
	               when: "mouseover",
	               ready: false
	            },
	            hide: "mouseout", 
	            style: {
	               border: {
	                  width: 2,
	                  radius: 10
	               },
	               padding: 10, 
	               textAlign: 'center',
	               tip: true, 
	               name: 'dark',
	               "font-family":"Arial",
	               "font-size":"14px"
	            }
			});
			$('td[title]').qtip({
	            content: false, 
	            position: {
	                adjust: {
	                      screen: true
	                }
	            },
	            show: {
	               when: "mouseover",
	               ready: false
	            },
	            hide: "mouseout", 
	            style: {
	               border: {
	                  width: 2,
	                  radius: 10
	               },
	               padding: 10, 
	               textAlign: 'center',
	               tip: true, 
	               name: 'dark',
	               "font-family":"Arial",
	               "font-size":"14px"
	            }
			});			
			
			$("#textarea").wysiwyg();
		});
	</script>-->
</body>
</html>


