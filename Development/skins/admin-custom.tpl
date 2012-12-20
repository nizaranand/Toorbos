					<div style="width:100%; float:left; text-align:left;"><span class="paginationText"><var:previousPage> <loop:resultPages><a href="<var:baseURL><var:pagePath><var:pageUrl>"><var:pageNumberDisplay></a> | </loop:resultPages> <var:nextPage></span></div>
					<div style="float:left;padding-top:20px; width:100%;">
						<div style="float:left;">
						<table cellpadding="0" cellspacing="0" border="0" bgcolor="#e6e6e6" width="650">
								<tr>
									<td width="12" height="12"><img src="images/profileBoxTopLeft.gif"></td>
									<td background="images/profileBoxTop.gif"><img src="images/profileBoxTop.gif"></td>
									<td width="12" height="12"><img src="images/profileBoxTopRight.gif"></td>
								</tr>
								<tr>
									<td background="images/profileBoxLeft.gif"><img src="images/profileBoxLeft.gif"></td>
									<td width="100%" align="left">
										<div style="float:left;"><span class="pageBreadCrumbsText">Customize Platform. </div><div style="float:left; padding-top:3px; padding-left:10px; height:30px;"><div style="padding-left:5px; float:left; background-image:url(<var:baseURL>images/updateButtonRed.gif); height:17px; width:42px; background-repeat:no-repeat;" onMouseOver="Javascript: this.style.cursor='pointer';" onClick="Javascript: document.getElementById('formSubmit').submit();"></div><div style="padding-left:5px; float:left; background-image:url(<var:baseURL>images/backButtonRed.gif); height:17px; width:42px; background-repeat:no-repeat;" onMouseOver="Javascript: this.style.cursor='pointer';" onClick="Javascript: document.location.href='<var:baseURL>/adminsystem/contenttype/contenttypelist/';"></div></div></span><br/>
										<div style="clear:all; width:90%; border-bottom: solid 2px #d9d9d9; font-family:Arial; font-weight:bold; font-size:11px; padding-bottom:5px;">
										</div>
										<form id="formSubmit" action="<var:baseURL><var:pagePath>" method="POST">	
										<input type="hidden" name="cmd" value="update">
										<input type="hidden" name="content_id" value="<var:content_id>">
										<input type="hidden" name="tableName" value="<var:tableNameModule>">
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tr>
													<td align="left" class="adminTable">Logo</td>
													<td>
														<!-- **************Image Upload Control************** -->
														<div id="cmdUpdateBio Image (remember to do sizeing)">
															
															<div style="float:left; width:160px; background-position:middle; background-repeat:no-repeat;">
															<script src="web/AC_OETags.js" language="javascript"></script>
															<script language="JavaScript" type="text/javascript">
															<!--
															/*function setbioImageValue(value){
															     
															     document.getElementById("bioImage").value = value;
															     alert(document.getElementById("bioImage").value);
															     alert("test");
															}*/
															
															
															// -----------------------------------------------------------------------------
															// Globals
															// Major version of Flash required
															var requiredMajorVersion = 9;
															// Minor version of Flash required
															var requiredMinorVersion = 0;
															// Minor version of Flash required
															var requiredRevision = 28;
															// -----------------------------------------------------------------------------
															// -->
															</script>
															
															<script language="JavaScript" type="text/javascript">
															<!--
															// Version check for the Flash Player that has the ability to start Player Product Install (6.0r65)
															var hasProductInstall = DetectFlashVer(6, 0, 65);
															
															// Version check based upon the values defined in globals
															var hasRequestedVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
															
															if ( hasProductInstall && !hasRequestedVersion ) {
																// DO NOT MODIFY THE FOLLOWING FOUR LINES
																// Location visited after installation is complete if installation is required
																var MMPlayerType = (isIE == true) ? "ActiveX" : "PlugIn";
																var MMredirectURL = window.location;
															    document.title = document.title.slice(0, 47) + " - Flash Player Installation";
															    var MMdoctitle = document.title;
															
																AC_FL_RunContent(
																	"src", "<var:baseURL>swf/playerProductInstall",
																	"FlashVars", "MMredirectURL="+MMredirectURL+'&MMplayerType='+MMPlayerType+'&MMdoctitle='+MMdoctitle+"",
																	"width", "240",
																	"height", "180",
																	"align", "middle",
																	"id", "FiberImageFileUploadControl",
																	"quality", "high",
																	"bgcolor", "#869ca7",
																	"name", "FiberImageFileUploadControl",
																	"allowScriptAccess","sameDomain",
																	"type", "application/x-shockwave-flash",
																	"pluginspage", "http://www.adobe.com/go/getflashplayer"
																);
															} else if (hasRequestedVersion) {
																// if we've detected an acceptable version
																// embed the Flash Content SWF when all tests are passed
																AC_FL_RunContent(
																		"width", "240",
																		"src", "<var:baseURL>swf/FiberImageFileUploadControl",
																		"FlashVars", "imageFile=<var:baseURL>images/clientLogo.gif&baseURL=<var:baseURL>&destinationPath=<var:clientPath>/files/images/",
																		"height", "180",
																		"align", "middle",
																		"id", "FiberImageFileUploadControl",
																		"quality", "high",	
																		"bgcolor", "#869ca7",
																		"name", "FiberImageFileUploadControl",
																		"allowScriptAccess","sameDomain",
																		"type", "application/x-shockwave-flash",
																		"pluginspage", "http://www.adobe.com/go/getflashplayer"
																);
															  } else {  // flash is too old or we can't detect the plugin
															    var alternateContent = 'Alternate HTML content should be placed here. '
															  	+ 'This content requires the Adobe Flash Player. '
															   	+ '<a href=http://www.adobe.com/go/getflash/>Get Flash</a>';
															    document.write(alternateContent);  // insert non-flash content
															  }
															// -->
															</script>
															<noscript>
															  	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
																		id="TestProfilePicture" width="100" height="122"
																		codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
																		<param name="movie" value="swf/FiberImageFileUploadControl.swf?imageFile=<var:baseURL>images/clientLogo.gif&baseURL=<var:baseURL>&destinationPath=<var:clientPath>/files/images/" />
																		<param name="quality" value="high" />
																		<param name="bgcolor" value="#869ca7" />
																		<param name="allowScriptAccess" value="sameDomain" />
																		<embed src="swf/FiberImageFileUploadControl.swf?imageFile=<var:baseURL>images/clientLogo.gif&baseURL=<var:baseURL>&destinationPath=<var:clientPath>/files/images/" quality="high" bgcolor="#869ca7"
																			width="100" height="122" name="FiberImageFileUploadControl" align="middle"
																			play="true"
																			loop="false"
																			quality="high"
																			allowScriptAccess="sameDomain"
																			type="application/x-shockwave-flash"
																			pluginspage="http://www.adobe.com/go/getflashplayer">
																		</embed>
																</object>
															</noscript>
															</div>
														</div>
													</td>
													<td></td>
												</tr>
												<tr>
													<td align="left" class="adminTable">
														<span style="color:#<var:menuBgColor>">Menu Bar Background color:</span><br><br>
														<INPUT type="text" id="menuBgColor" name="menuBgColor" VALUE="#<var:menuBgColor>"><br>
														<script language="JavaScript">
														<!-- 
															function menuBgColor(c){document.getElementById("menuBgColor").value = c;} 
														// -->
														</script>
														<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="180" height="140">
													      	<param name="movie" value="swf/colorpicker.swf?func=menuBgColor">
													        <param name="quality" value="high">
													        <embed src="swf/colorpicker.swf?func=menuBgColor" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="180" height="140"></embed>
													    </object>
													</td>
													<td align="left" class="adminTable">
														<span style="color:#<var:menuItemsText>">Menu Bar Items Text:</var:span><br><br>
														<INPUT type="text" id="menuItemsText" name="menuItemsText" value="<var:menuItemsText>"><br>
														<script language="JavaScript">
														<!-- 
															function menuItemsText(c){document.getElementById("menuItemsText").value = c;} 
														// -->
														</script>
														<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="180" height="140">
													      	<param name="movie" value="swf/colorpicker.swf?func=menuItemsText">
													        <param name="quality" value="high">
													        <embed src="swf/colorpicker.swf?func=menuItemsText" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="180" height="140"></embed>
													    </object>
													</td>
												</tr>
												<tr>
													<td align="left" class="adminTable">
														<span style="color:#<var:menuItemsBgOver>">Menu Bar Background Colour Mouse Over:</span><br><br>
														<INPUT type="text" id="menuItemsOver" name="menuItemsOver" value="<var:menuItemsBgOver>"><br>
														<script language="JavaScript">
														<!-- 
															function menuItemsOver(c){document.getElementById("menuItemsOver").value = c;} 
														// -->
														</script>
														<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="180" height="140">
													      	<param name="movie" value="swf/colorpicker.swf?func=menuItemsOver">
													        <param name="quality" value="high">
													        <embed src="swf/colorpicker.swf?func=menuItemsOver" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="180" height="140"></embed>
													    </object>
													</td>
													<td align="left" class="adminTable">
														<span style="color:#<var:menuItemsOverText>">Menu Bar Items Mouse Over Text:</span><br><br>
														<INPUT type="text" id="menuItemsOverText" name="menuItemsOverText" value="<var:menuItemsTextOver>"><br>
														<script language="JavaScript">
														<!-- 
															function menuItemsOverText(c){document.getElementById("menuItemsOverText").value = c;} 
														// -->
														</script>
														<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="180" height="140">
													      	<param name="movie" value="swf/colorpicker.swf?func=menuItemsOverText">
													        <param name="quality" value="high">
													        <embed src="swf/colorpicker.swf?func=menuItemsOverText" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="180" height="140"></embed>
													    </object>
													</td>
												</tr>
												<tr>
													<td align="left" class="adminTable">
														<span style="color:#<var:breadcrumbsBgColor>">Breadcrumbs Bar Background Color: </span><br><br>
														<INPUT type="text" id="breadcrumbsBgColor" name="breadcrumbsBgColor" value="<var:breadcrumbsBgColor>"><br>
														<script language="JavaScript">
														<!-- 
															function breadcrumbsBgColor(c){document.getElementById("breadcrumbsBgColor").value = c;} 
														// -->
														</script>
														<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="180" height="140">
													      	<param name="movie" value="swf/colorpicker.swf?func=breadcrumbsBgColor">
													        <param name="quality" value="high">
													        <embed src="swf/colorpicker.swf?func=breadcrumbsBgColor" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="180" height="140"></embed>
													    </object>
													</td>
													<td align="left" class="adminTable">
														<span style="color:#<var:breadcrumbsColorText>">Breadcrumbs Bar Background Color: </span><br><br>
														<INPUT type="text" id="breadcrumbsColorText" name="breadcrumbsColorText" value="<var:breadcrumbsColorText>"><br>
														<script language="JavaScript">
														<!-- 
															function breadcrumbsColorText(c){document.getElementById("breadcrumbsColorText").value = c;} 
														// -->
														</script>
														<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="180" height="140">
													      	<param name="movie" value="swf/colorpicker.swf?func=breadcrumbsColorText">
													        <param name="quality" value="high">
													        <embed src="swf/colorpicker.swf?func=breadcrumbsColorText" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="180" height="140"></embed>
													    </object>
													</td>
												</tr>
												<tr>									
													<td align="left" class="adminTable">
														<span style="color:#<var:colorA>">Color A: </span><br><br>
														<INPUT type="text" id="colorA" name="colorA" value="<var:colorA>"><br>
														<script language="JavaScript">
														<!-- 
															function colorA(c){document.getElementById("colorA").value = c;} 
														// -->
														</script>
														<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="180" height="140">
													      	<param name="movie" value="swf/colorpicker.swf?func=colorA">
													        <param name="quality" value="high">
													        <embed src="swf/colorpicker.swf?func=colorA" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="180" height="140"></embed>
													    </object>
													</td>
													<td align="left" class="adminTable">
														<span style="color:#<var:colorB>">Color B: </span><br><br>
														<INPUT type="text" id="colorB" name="colorB" value="<var:colorB>"><br>
														<script language="JavaScript">
														<!-- 
															function colorB(c){document.getElementById("colorB").value = c;} 
														// -->
														</script>
														<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="180" height="140">
													      	<param name="movie" value="swf/colorpicker.swf?func=colorB">
													        <param name="quality" value="high">
													        <embed src="swf/colorpicker.swf?func=colorB" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="180" height="140"></embed>
													    </object>
													</td>
												</tr>
												<tr>
													<td align="left" class="adminTable">
														<span style="color:#<var:colorC>">Color C: </span><br><br>
														<INPUT type="text" id="colorC" name="colorC" value="<var:colorC>"><br>
														<script language="JavaScript">
														<!-- 
															function colorC(c){document.getElementById("colorC").value = c;} 
														// -->
														</script>
														<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="180" height="140">
													      	<param name="movie" value="swf/colorpicker.swf?func=colorC">
													        <param name="quality" value="high">
													        <embed src="swf/colorpicker.swf?func=colorC" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="180" height="140"></embed>
													    </object>
													</td>
													<td align="left" class="adminTable">
														<span style="color:#<var:colorD>">Color D: </span><br><br>
														<INPUT type="text" id="colorD" name="colorD" value="<var:colorD>"><br>
														<script language="JavaScript">
														<!-- 
															function colorD(c){document.getElementById("colorD").value = c;} 
														// -->
														</script>
														<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="180" height="140">
													      	<param name="movie" value="swf/colorpicker.swf?func=colorD">
													        <param name="quality" value="high">
													        <embed src="swf/colorpicker.swf?func=colorD" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="180" height="140"></embed>
													    </object>
													</td>
												</tr>
												<tr>
													<td align="left" class="adminTable">
														<span style="color:#<var:colorE>">Color E: </span><br><br>
														<INPUT type="text" id="colorE" name="colorE" value="<var:colorE>"><br>
														<script language="JavaScript">
														<!-- 
															function colorE(c){document.getElementById("colorE").value = c;} 
														// -->
														</script>
														<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="180" height="140">
													      	<param name="movie" value="swf/colorpicker.swf?func=colorE">
													        <param name="quality" value="high">
													        <embed src="swf/colorpicker.swf?func=colorE" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="180" height="140"></embed>
													    </object>
													</td>
													<td align="left" class="adminTable">
														<span style="color:#<var:colorF>">Color F: </span><br><br>
														<INPUT type="text" id="colorF" name="colorF" value="<var:colorF>"><br>
														<script language="JavaScript">
														<!-- 
															function colorF(c){document.getElementById("colorF").value = c;} 
														// -->
														</script>
														<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="180" height="140">
													      	<param name="movie" value="swf/colorpicker.swf?func=colorF">
													        <param name="quality" value="high">
													        <embed src="swf/colorpicker.swf?func=colorF" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="180" height="140"></embed>
													    </object>
													</td>
												</tr>
												<tr>
													<td align="left" class="adminTable">
														<span style="color:#<var:colorG>">Color G: </span><br><br>
														<INPUT type="text" id="colorG" name="colorG" value="<var:colorG>"><br>
														<script language="JavaScript">
														<!-- 
															function colorG(c){document.getElementById("colorG").value = c;} 
														// -->
														</script>
														<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="180" height="140">
													      	<param name="movie" value="swf/colorpicker.swf?func=colorG">
													        <param name="quality" value="high">
													        <embed src="swf/colorpicker.swf?func=colorG" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="180" height="140"></embed>
													    </object>
													</td>
													<td align="left" class="adminTable">
														<span style="color:#<var:colorH>">Color H: </span><br><br>
														<INPUT type="text" id="colorH" name="colorH" value="<var:colorG>"><br>
														<script language="JavaScript">
														<!-- 
															function colorH(c){document.getElementById("colorH").value = c;} 
														// -->
														</script>
														<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="180" height="140">
													      	<param name="movie" value="swf/colorpicker.swf?func=colorH">
													        <param name="quality" value="high">
													        <embed src="swf/colorpicker.swf?func=colorH" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="180" height="140"></embed>
													    </object>
													</td>
												</tr>
											</table>
										</form>
										<div style="float:right; width:20%; font-family:Arial; font-weight:normal; font-size:11px; padding:15px; color:#666666;">
											<div style="height:25px;"><div style="padding-left:5px; float:right; background-image:url(<var:baseURL>images/updateButtonRed.gif); height:17px; width:42px; background-repeat:no-repeat;" onMouseOver="Javascript: this.style.cursor='pointer';" onClick="Javascript: document.getElementById('formSubmit').submit();"></div></div>
										</div>
										</td>
										<td background="images/profileBoxRight.gif"><img src="images/profileBoxRight.gif"></td>
									</tr>
									<tr>
										<td><img src="images/profileBoxBottomLeft.gif"></td>
										<td background="images/profileBoxBottom.gif"><img src="images/profileBoxBottom.gif"></td>
										<td><img src="images/profileBoxBottomRight.gif"></td>
									</tr>
								</table>
						
						</div>
					</div>