<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Fiber Platform - Login</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<meta http-equiv="expires" content="-1">
	<meta http-equiv= "pragma" content="no-cache">
	<meta name="robots" content="all">
	<meta name="MSSmartTagsPreventParsing" content="true">
	<base href="<var:baseURL>">
	<link rel="icon" type="image/x-icon" href="images/favicon.ico" />  
 	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
	<link rel="stylesheet" type="text/css" href="<var:adminPath>/css/colorbox.css">
	<link rel="stylesheet" type="text/css" href="<var:adminPath>/css/login.css">
</head>
<body>
	
	<div class="center">
		<p style="color:white;"><var:loginMessage><br></p>
		<img src="<var:adminPath>/images/fiberplatform.png"/>
		<div style="width:371px;height:304px;background-image: url('<var:adminPath>/images/login-bg.png');padding-top:60px;padding-left:70px;background-repeat:no-repeat;text-align:left;">
			<form action="<var:pagePath>" method="post">
				Username<br> <input type="text" name="username" class="roundedInput" title="Enter your username or e-mail address">
				<br>
				Password<br> <input type="password" name="password" class="roundedInput" title="Enter your password">
				<div style="padding-left:0px;padding-right:40px;font-size:12px;padding-top:10px;"><div style="float:left;padding-left:15px;"><input type="image" src="<var:adminPath>/images/button-login.png"></div></div>
			</form>
		</div>
		
	</div>
</body>
</html>