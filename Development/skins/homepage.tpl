<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<title>New Fiber Platform Site</title>
<base href="<var:baseURL>">
<style type="text/css">
	BODY{
		height:100%;
		margin:0;
	}
	HTML{
		height:100%;
	}
	.topDiv{
		width:100%;
		background-color:#464646;
		height:85px;
	}
	.headerDiv{
		background-image:url(images/fiberLogo.gif);
		height:85px;
		background-repeat:no-repeat;
	}	
	.topMenu{
		padding-top:56px;
		float:right;
	}
	.H1{
		font-family:Verdana;
		font-size:18px;
		font-weight:bold;
		text-align:center;
		color:#4e4b4a;
	}
	.H2{
		font-family:Verdana;
		font-size:12px;
		font-weight:bold;
		text-align:center;
		color:#ff3f14;
		text-decoration:none;
	}
	.H3{
		font-family:Verdana;
		font-size:12px;
		font-weight:bold;
		text-align:center;
		color:#4e4b4a;
	}
	.H4{
		font-family:Verdana;
		font-size:14px;
		font-weight:bold;
		text-align:center;
		color:#ff3f14;
	}
	.H5{
		font-family:Verdana;
		font-size:12px;
		font-weight:normal;
		text-align:left;
		color:#4e4b4a;
	}
	.H6{
		font-family:Verdana;
		font-size:12px;
		font-weight:bold;
		text-align:left;
		color:#4e4b4a;
	}
	
	.topMenuText{
		float:left;
		font-family:Verdana;
		font-size:15px;
		font-weight:normal;
		text-align:center;
		color:#999999;
		padding-top:4px;
		padding-left:10px;
		padding-right:10px;
	}
	.topMenuTextSelected{
		float:left;
		font-family:Verdana;
		font-size:15px;
		font-weight:normal;
		color:#555555;
		background-color:#e4f2fd;
		text-align:center;
		height:25px;
		padding-top:4px;
		padding-left:10px;
		padding-right:10px;
	}
	.topMenuMouseOver{
		float:left;
		font-family:Verdana;
		font-size:15px;
		font-weight:normal;
		text-align:center;
		color:#ffffff;
		background-color:#d54e21;
		height:25px;
		padding-top:4px;
		padding-left:10px;
		padding-right:10px;		
	}
	.pageTopBorderLeft{
		float:left;
		width:10px;
		height:60px;
		background-color:#e4f2fd;
		background-image:url(images/pageTopBorderLeft.gif);
		background-repeat:no-repeat;
	}
	.pageTop{
		float:left;
		width:781px;
		height:60px;
		background-color:#e4f2fd;
	}
	.pageTopTextArea{
		text-align:left;
		width:170px;
		padding-top:20px;
		float:left;
		padding-left:15px;
	}
	.pageTopTextBreadCrumbs{
		text-align:left;
		width:170px;
		padding-top:26px;
		float:left;
		padding-left:15px;
	}
	.pageBody{
		float:left;
		width:799px;
		min-height:auto;
		background-color:#ffffff;
		border-top:solid 1px #d6d6d6;
		border-left:solid 1px #d6d6d6;
		border-right:solid 1px #d6d6d6;
		padding-top:30px;
		padding-bottom:30px;
	}
	.pageTopBorderRight{
		float:left;
		width:9px;
		height:60px;
		background-color:#e4f2fd;
		background-image:url(images/pageTopBorderRight.gif);
		background-repeat:no-repeat;
	}
	.childMenuLeft{
		float:left;
		clear:all;
		padding-bottom:5px;
		padding-top:5px;
		font-family:Verdana;
		font-size:12px;
		font-weight:bold;
		text-align:left;
		color:#ff3f14;
		border-bottom: solid 1px #dedede;
		width:140px;
	}
	.childMenuLeftSelected{
		float:left;
		clear:all;
		padding-bottom:5px;
		padding-top:5px;
		font-family:Verdana;
		font-size:12px;
		font-weight:bold;
		text-align:left;
		color:#4e4b4a;
		border-bottom: solid 1px #dedede;
		width:140px;
	}
</style> 
</head>
<body>
<div style="height:93%">
	<div align="center" class="topDiv">
		<div align="center" style="width:800px;">
			<div align="center" class="headerDiv">
				<div align="right" class="topMenu">
					<module:autoMenu:Top:1>
				</div>
			</div>
		</div>
	</div>
	<div align="center">		
		<div align="center" style="width:800px;">		
				<div align="center" style="clear:all;">
					<div class="pageTopBorderLeft"></div>
					<div class="pageTop">
						<div class="pageTopTextArea"><span class="H1">Extend</span></div>
						<div class="pageTopTextBreadCrumbs"><module:breadcrumbs:Breadcrumbs:1></div>
					</div>
					<div class="pageTopBorderRight"></div>
				</div>
		</div>
	</div>
	<div align="center">		
		<div align="center" style="width:800px;">			
				<div style="clear:all;">
					<div class="pageBody" style="min-height:100%;">
						<div style="padding-left:30px;">

							<module:autoMenu:child:1>
						</div>
						<div style="float:left; padding-left:20px; padding-right:10px;">
								<module:container:Left:1>						
						</div>

					</div>
				</div>
			</div>
		</div>
</div>
<div align="center">		
	<div align="center" style="width:800px;">			
		<div style="height:100%;">
			<div class="pageBody" style="min-height:100%; border-top:none;">
				<div style="width:750px; clear:all; border-top:solid 1px #dedede; text-align:center; font-family:Verdana; font-size:10px; font-weight:bold; color:#2599d7;">
					Terms & Conditions | Disclaimer | Contact Us
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>