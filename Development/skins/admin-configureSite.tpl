		<script type="text/javascript">
			$(document).ready(function(){
				$("#updateButton").mouseover(function(event) {
			 		 $(this).css("cursor","pointer");
			 	});
				$("#updateButton").click(function(event) {
			 		 $("#formSubmit").submit();
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#updateButton").mouseover(function(event) {
			 		 $(this).css("cursor","pointer");
			 	});
				$("#updateButton").click(function(event) {
			 		 $("#formSubmit").submit();
				});
				$(".textarea").wysiwyg();
			});
			 function setDate(whichDiv,dateDB,date){
				document.getElementById(whichDiv+"Text").innerHTML = date;
				//alert(document.getElementById(whichDiv+"Text"));
				document.getElementById(whichDiv+"Div").style.display = 'none';
				document.getElementById(whichDiv).value = dateDB;
			  }
			  function close(whichDiv){
				document.getElementById(whichDiv).style.display = 'none';
			  }
			  function characterCount(elName){
				  var countElement = "#"+elName;
				  var count = $(countElement).val().length;
				  var updateDisplay = "#"+elName+"Display";
				  $(updateDisplay).html("Characters: "+count);
			  }
		</script>

		<div align="left" class="topBodyDiv">
			<form id="formSubmit" action="<var:baseURL><var:pagePath>" method="POST">
			<input type="hidden" name="cmd" value="update">
			<div class="leftFloat">
				<span class="headingText">Configure Site</span>
			</div>
			<loop:siteFields>
						<if:sys_control_id==1>
							<div class="leftFloat" style="width:100%;clear:both;">	
								<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;" width="100%">
									<tr>
										<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
										<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
										<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
										<td class="boxBG" width="100%">
											<div style="padding:7px;">
												<div class="boxTextDiv" style="width:250px;">
													<span class="boxText"><var:displayName></span>
												</div>
												<div class="boxInputDiv" <if:fieldName==miniSite>style="display:none;width:100%;" id="miniSiteContent"</if>>
													<input type="<if:fieldName==password>password</if><if:fieldName!=password>text</if>" style="width:340px;" class="inputBoxStyle" name="<var:fieldName>" id="<var:fieldName>" value="<var:content>"<if:description!=> title="<var:description>"</if>/>
												</div>
											</div>
										</td>
										<td class="boxRight"><img src="images/Fiber/editBoxRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxBottomLeft"><img src="images/Fiber/editBoxBottomLeft.jpg"></td>
										<td class="boxBottom"><img src="images/Fiber/editBoxBottom.jpg"></td>
										<td class="boxBottomRight"><img src="images/Fiber/editBoxBottomRight.jpg"></td>
									</tr>
								</table>
							</div>
						</if>						
						<if:sys_control_id==9>
							<div class="leftFloat" style="width:100%;clear:both;">	
								<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;" width="100%">
									<tr>
										<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
										<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
										<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
										<td class="boxBG" width="100%">
											<div style="padding:7px;">
												<div class="boxTextDiv" style="width:250px;">
													<span class="boxText"><var:displayName></span>
												</div>
												<div style="float:right;padding:2px;cursor:pointer;" onclick="Javascript: closeField('<var:fieldName>');" id="<var:fieldName>Close"><img src="images/Fiber/icn-minimize.png" border="0" title="Minimize wysiwyg"/></div>
												<div style="float:right;display:none;padding:2px;cursor:pointer;" onclick="Javascript: openField('<var:fieldName>');" id="<var:fieldName>Open"><img src="images/Fiber/icn-maximize.png" border="0" title="Maximize wysiwyg"/></div>
												<if:description!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-help.png" border="0" title="<var:description>"/></div>
												</if>
												<div class="boxInputDiv" style="width:100%;" id="<var:fieldName>Content">
													<textarea id="<var:fieldName>" class="textarea" name="<var:fieldName>" cols="70" rows="20"><var:content></textarea>
													<!-- <input type="hidden" id="<var:fieldName>" name="<var:fieldName>" value="<var:content>" style="display:none" /><input type="hidden" id="<var:fieldName>___Config" value="sBasePath=<var:baseURL>_admin/tools/fckeditor/&EditorAreaCSS=<var:baseURL>css/stylesheet.css" style="display:none" /><iframe id="<var:fieldName>___Frame" src="<var:baseURL>_admin/tools/fckeditor/editor/fckeditor.html?InstanceName=<var:fieldName>&amp;Toolbar=Expert" width="100%" height="300" frameborder="0" scrolling="no"></iframe> -->
												</div>
											</div>
										</td>
										<td class="boxRight"><img src="images/Fiber/editBoxRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxBottomLeft"><img src="images/Fiber/editBoxBottomLeft.jpg"></td>
										<td class="boxBottom"><img src="images/Fiber/editBoxBottom.jpg"></td>
										<td class="boxBottomRight"><img src="images/Fiber/editBoxBottomRight.jpg"></td>
									</tr>
								</table>
							</div>
						</if>
						<if:sys_control_id==28>
							<div class="leftFloat" style="width:100%;clear:both;">	
								<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;" width="100%">
									<tr>
										<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
										<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
										<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
										<td class="boxBG" width="100%">
											<div style="padding:7px;">
												<div class="boxTextDiv" style="width:250px;">
													<span class="boxText"><var:displayName></span>
												</div>
												<if:screenshot!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-maximize.png" border="0" title="<var:screenshot>"/></div>
												</if>
												<if:description!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-help.png" border="0" title="<var:description>"/></div>
												</if>
												<div class="boxInputDiv">
													<select id="<var:fieldName>" name="<var:fieldName>" style="width: 200px;" /><option value="">Loading ...</option></select>
													<script type="text/javascript">
														
														if( !arrayOfContentPopulationFields ){
														 var arrayOfContentPopulationFields = new Array();
														}
														
														arrayOfContentPopulationFields.push("<var:fieldName>-<var:moduleName>-<var:content>");
					
					
													
													 </script> 
												</div>
											</div>
										</td>
										<td class="boxRight"><img src="images/Fiber/editBoxRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxBottomLeft"><img src="images/Fiber/editBoxBottomLeft.jpg"></td>
										<td class="boxBottom"><img src="images/Fiber/editBoxBottom.jpg"></td>
										<td class="boxBottomRight"><img src="images/Fiber/editBoxBottomRight.jpg"></td>
									</tr>
								</table>
							</div>
						</if>
						<if:sys_control_id==10>
							<div class="leftFloat" style="width:100%;clear:both;">	
								<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;" width="100%">
									<tr>
										<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
										<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
										<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
										<td class="boxBG" width="100%">
											<div style="padding:7px;">
												<div class="boxTextDiv" style="width:250px;">
													<span class="boxText"><var:displayName></span>
												</div>
												<if:screenshot!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-maximize.png" border="0" title="<var:screenshot>"/></div>
												</if>
												<if:description!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-help.png" border="0" title="<var:description>"/></div>
												</if>
												<div class="boxInputDiv">
													<loop:options>&nbsp;<input type="radio" name="<var:fieldName>" value="<var:optionValue>" <var:optionSelected>>&nbsp;<var:optionName>&nbsp;</loop:options>
												</div>
											</div>
										</td>
										<td class="boxRight"><img src="images/Fiber/editBoxRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxBottomLeft"><img src="images/Fiber/editBoxBottomLeft.jpg"></td>
										<td class="boxBottom"><img src="images/Fiber/editBoxBottom.jpg"></td>
										<td class="boxBottomRight"><img src="images/Fiber/editBoxBottomRight.jpg"></td>
									</tr>
								</table>
							</div>
						</if>
						<if:sys_control_id==14>
							<div class="leftFloat" style="width:50%">	
								<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;" width="100%">
									<tr>
										<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
										<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
										<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
										<td class="boxBG" width="100%">
											<div style="padding:7px;">
												<div class="boxTextDiv" style="width:250px;">
													<div class="boxInputDiv">
														<input type="hidden" name="<var:fieldName>" id="<var:fieldName>" value="<var:content>" style="width: 200px;">
														<div id="colorSelector<var:fieldName>" class="colorSelector"><div style="background-color: <var:content>"></div></div>
														<script type="text/javascript">
														$('#colorSelector<var:fieldName>').ColorPicker({
															color: '<var:content>',
															onShow: function (colpkr) {
																$(colpkr).fadeIn(500);
																return false;
															},
															onHide: function (colpkr) {
																$(colpkr).fadeOut(500);
																return false;
															},
															onChange: function (hsb, hex, rgb) {
																$('#colorSelector<var:fieldName> div').css('backgroundColor', '#' + hex);
																$('#<var:fieldName>').val('#' + hex);
															}
														});
			
														</script>	
													</div>
													<span class="boxText"><var:displayName></span>
												</div>
												<if:screenshot!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-maximize.png" border="0" title="<var:screenshot>"/></div>
												</if>
												<if:description!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-help.png" border="0" title="<var:description>"/></div>
												</if>
											</div>
										</td>
										<td class="boxRight"><img src="images/Fiber/editBoxRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxBottomLeft"><img src="images/Fiber/editBoxBottomLeft.jpg"></td>
										<td class="boxBottom"><img src="images/Fiber/editBoxBottom.jpg"></td>
										<td class="boxBottomRight"><img src="images/Fiber/editBoxBottomRight.jpg"></td>
									</tr>
								</table>
							</div>
						</if>
						<if:sys_control_id==2>
							<div class="leftFloat" style="width:100%">	
								<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;" width="100%">
									<tr>
										<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
										<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
										<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
										<td class="boxBG" width="100%">
											<div style="padding:7px;">
												<div class="boxTextDiv" style="width:250px;">
													<span class="boxText"><var:displayName></span>
												</div>
												<if:screenshot!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-maximize.png" border="0" title="<var:screenshot>"/></div>
												</if>
												<if:description!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-help.png" border="0" title="<var:description>"/></div>
												</if>
												<div class="boxInputDiv">
												    <div style="padding:5px;font-family:Verdana;font-size:12px;" id="imgDisplay<var:fieldName>"><img src="files/site/<var:mod_site_id>/<var:content>"></div>																			
													<a href="<var:pagePath>#" id="imgUploadFileLink<var:fieldName>"><img src="images/Fiber/btn-upload.png" title="Upload a new image" border="0"/></a><a href="Javascript:;" id="imgDeleteFileLink<var:fieldName>"><img src="images/Fiber/btn-delete.png" title="Delete image" border="0"/></a>
													<div id="status<var:fieldName>"></div>
													<div style="display:none;">
														<div id='imgUploadDiv<var:fieldName>' style='padding:20px; background:#fff; height:400px;'>														
																<input type="file" name="uploadify" id="imgUploadFile<var:fieldName>" />
																<div class="cancelButtonDiv" style="width:200px;height:20px;padding:5px;text-align:center;vetical-align:middle; margin:5px;background-color:#c9c9c9;" onclick="javascript:jQuery('#imgUploadFile2').uploadifyClearQueue()">Cancel All Uploads</div>
																<div id="fileQueue<var:fieldName>" style="font-weight:bold;font-color:green"></div>
																<table cellpadding="0" cellspacing="0" border="0">
																	<tr>
																		<td align="right" colspan="2">
																			<div class="cancelButtonDiv" style="float:left;width:50px;height:20px;padding:5px;text-align:center;vetical-align:middle; margin:5px;background-color:#c9c9c9;">
																				<div id="cancelBoxFileUpload<var:fieldName>" class="buttonDiv headerLoginText"><b>Cancel</b></div>
																			</div>
																			<div class="saveButtonDiv" style="float:left;width:50px;height:20px;padding:5px;text-align:center;vetical-align:middle; margin:5px;background-color:#c9c9c9;">
																				<div id="saveBoxFileUpload<var:fieldName>" class="buttonDiv headerLoginText"><b>Save</b></div>
																			</div>
																		</td>
																	</tr>
																</table>
														</div>		
													</div>
													<script type="text/javascript">
							
														$("#imgUploadFileLink<var:fieldName>").colorbox({width:"445px;", inline:"true", href:"#imgUploadDiv<var:fieldName>"});

														$("#imgDeleteFileLink<var:fieldName>").click(function(){
															$.ajax({
																   url: "<var:baseURL>includes/uploadifyField.php",
																   data: "contentId=<var:mod_site_id>&tableName=site&fieldName=<var:fieldName>&controlValues=<var:controlValues>&cmd=delete",
																   success: function(msg){
																     $("#status<var:fieldName>").html("Image deleted");
																     $("#imgDisplay<var:fieldName>").html("");
																   }
															});
														});
														
														$("#saveBoxFileUpload<var:fieldName>").click(function(){
															$("#formSubmit").submit();
														});
														$("#saveBoxFileUpload<var:fieldName>").mouseover(function(){
															$(this).css("cursor","pointer");
														});
														$("#cancelBoxFileUpload<var:fieldName>").click(function(){
															$.fn.colorbox.close();
														});
														$("#cancelBoxFileUpload<var:fieldName>").mouseover(function(){
															$(this).css("cursor","pointer");
														});
							
														$("#imgUploadFile<var:fieldName>").uploadify({
															'uploader'       : '<var:baseURL>swf/uploadify.swf',
															'script'         : '<var:baseURL>includes/uploadifyField.php',
															'cancelImg'      : 'images/cancel.png',
															'folder'         : '',
															'queueID'        : 'fileQueue<var:fieldName>',
															'auto'           : true,
															'multi'          : false,
															'scriptData'	 : {contentId:"<var:mod_site_id>",tableName:"site",fieldName:"<var:fieldName>",controlValues:"<var:controlValues>"}
														});
														
													</script>

												</div>
											</div>
										</td>
										<td class="boxRight"><img src="images/Fiber/editBoxRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxBottomLeft"><img src="images/Fiber/editBoxBottomLeft.jpg"></td>
										<td class="boxBottom"><img src="images/Fiber/editBoxBottom.jpg"></td>
										<td class="boxBottomRight"><img src="images/Fiber/editBoxBottomRight.jpg"></td>
									</tr>
								</table>
							</div>
						</if>
						<if:sys_control_id==5>
							<div class="leftFloat" style="width:100%">	
								<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;" width="100%">
									<tr>
										<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
										<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
										<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
										<td class="boxBG" width="100%">
											<div style="padding:7px;">
												<div class="boxTextDiv" style="width:250px;">
													<span class="boxText"><var:displayName></span>
												</div>
												<div style="float:right;display:none;padding:2px;cursor:pointer;" onclick="Javascript: closeField('<var:fieldName>');" id="<var:fieldName>Close"><img src="images/Fiber/icn-minimize.png" border="0" title="Minimize wysiwyg"/></div>
												<div style="float:right;padding:2px;cursor:pointer;" onclick="Javascript: openField('<var:fieldName>');" id="<var:fieldName>Open"><img src="images/Fiber/icn-maximize.png" border="0" title="Maximize wysiwyg"/></div>
												<if:description!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-help.png" border="0" title="<var:description>"/></div>
												</if>
												<div class="boxInputDiv" style="display:none;" width="100%" id="<var:fieldName>Content">
													<textarea name="<var:fieldName>" id="<var:fieldName>" cols="75" rows="5" onkeyup="Javascript: characterCount('<var:fieldName>');"><var:content></textarea>
													<div id="<var:fieldName>Display"></div>
													<script type="text/javascript"> characterCount('<var:fieldName>'); </script>
												</div>
											</div>
										</td>
										<td class="boxRight"><img src="images/Fiber/editBoxRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxBottomLeft"><img src="images/Fiber/editBoxBottomLeft.jpg"></td>
										<td class="boxBottom"><img src="images/Fiber/editBoxBottom.jpg"></td>
										<td class="boxBottomRight"><img src="images/Fiber/editBoxBottomRight.jpg"></td>
									</tr>
								</table>
							</div>
						</if>
						<if:sys_control_id==21>
							<div class="leftFloat" style="width:100%">	
								<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;" width="100%">
									<tr>
										<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
										<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
										<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
										<td class="boxBG" width="100%">
											<div style="padding:7px;">
												<div class="boxTextDiv" style="width:250px;">
													<span class="boxText"><var:displayName></span>
												</div>
												<if:screenshot!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-maximize.png" border="0" title="<var:screenshot>"/></div>
												</if>
												<if:description!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-help.png" border="0" title="<var:description>"/></div>
												</if>
												<div class="boxInputDiv">
													<select id="<var:fieldName>" class="inputBoxStyle" name="<var:fieldName>" style="width: 360px;" /><option value="">Loading ...</option></select>
													<script type="text/javascript">
														if( !arrayOfContentPopulationFields ){
														 var arrayOfContentPopulationFields = new Array();
														}
														arrayOfContentPopulationFields.push("<var:fieldName>-<var:moduleName>-<var:content>");
													 </script> 
												</div>
											</div>
										</td>
										<td class="boxRight"><img src="images/Fiber/editBoxRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxBottomLeft"><img src="images/Fiber/editBoxBottomLeft.jpg"></td>
										<td class="boxBottom"><img src="images/Fiber/editBoxBottom.jpg"></td>
										<td class="boxBottomRight"><img src="images/Fiber/editBoxBottomRight.jpg"></td>
									</tr>
								</table>
							</div>
						</if>
						<if:sys_control_id==7>
							<div class="leftFloat" style="width:100%">	
								<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;" width="100%">
									<tr>
										<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
										<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
										<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
										<td class="boxBG" width="100%">
											<div style="padding:7px;">
												<div class="boxTextDiv" style="width:250px;">
													<span class="boxText"><var:displayName></span>
												</div>
												<if:screenshot!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-maximize.png" border="0" title="<var:screenshot>"/></div>
												</if>
												<if:description!=>
													<div style="float:right;padding:2px;"><img src="images/Fiber/icn-help.png" border="0" title="<var:description>"/></div>
												</if>
												<div class="boxInputDiv">
													<input type="text" style="width:340px;" class="inputBoxStyle" name="<var:fieldName>" id="<var:fieldName>" value="<var:content>"/>
													<script type="text/javascript">
														$("#<var:fieldName>").datepicker();
														$('#<var:fieldName>').datepicker('option', {dateFormat: "yy-mm-dd"});
														$('#<var:fieldName>').datepicker('setDate', "<var:content>");
													 </script> 
												</div>
											</div>
										</td>
										<td class="boxRight"><img src="images/Fiber/editBoxRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxBottomLeft"><img src="images/Fiber/editBoxBottomLeft.jpg"></td>
										<td class="boxBottom"><img src="images/Fiber/editBoxBottom.jpg"></td>
										<td class="boxBottomRight"><img src="images/Fiber/editBoxBottomRight.jpg"></td>
									</tr>
								</table>
							</div>
						</if>
			</loop:siteFields>
			<div class="leftFloat">
				<div align="left" class="bodyDiv">
					<div style="float:left; width:100%;" >
						<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;">
							<tr>
								<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
								<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
								<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
							</tr>
							<tr>
								<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
								<td class="boxBG" width="785px">
									<div style="padding:7px;">
										<span class="boxText">Footer</span>
									</div>
									<div style="padding:7px;">
										<input type="hidden" id="footer" name="footer" value="<var:footer>" style="display:none" /><input type="hidden" id="footer___Config" value="sBasePath=<var:baseURL>_admin/tools/fckeditor/&EditorAreaCSS=<var:baseURL>css/stylesheet.css" style="display:none" /><iframe id="footer___Frame" src="<var:baseURL>_admin/tools/fckeditor/editor/fckeditor.html?InstanceName=footer&amp;Toolbar=Expert" width="745px;" height="300" frameborder="0" scrolling="no"></iframe>
									</div>
								</td>
								<td class="boxRight"><img src="images/Fiber/editBoxRight.jpg"></td>
							</tr>
							<tr>
								<td class="boxBottomLeft"><img src="images/Fiber/editBoxBottomLeft.jpg"></td>
								<td class="boxBottom"><img src="images/Fiber/editBoxBottom.jpg"></td>
								<td class="boxBottomRight"><img src="images/Fiber/editBoxBottomRight.jpg"></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="rightFloat">
					<table id="updateButton" title="Search Pages" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td class="buttonLeft"><img src="images/Fiber/button-left.jpg"></td>
							<td class="buttonMiddle">
								<span class="buttonText">Update&nbsp;</span>
							</td>
							<td class="buttonRight"><img src="images/Fiber/button-right.jpg"></td>
						</tr>
					</table>
				</div>
			</div>
		</form>
		</div>
							<div style="display:none;">
								<div id='imgUploadDiv' style='padding:20px; background:#fff; height:400px;'>
								
									<form action="<var:pagePath>" method="Post" id="imgUploadForm" enctype="multipart/form-data">
										<input type="file" name="uploadify" id="imgUploadFile" />
										<div class="cancelButtonDiv" style="width:200px;height:20px;padding:5px;text-align:center;vetical-align:middle; margin:5px;background-color:#c9c9c9;" onclick="javascript:jQuery('#imgUploadFile').uploadifyClearQueue()">Cancel All Uploads</div>
										<div id="fileQueue"></div>
										<table cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td align="right" colspan="2">
													<div class="cancelButtonDiv" style="float:left;width:50px;height:20px;padding:5px;text-align:center;vetical-align:middle; margin:5px;background-color:#c9c9c9;">
														<div id="cancelBoxFileUpload" class="buttonDiv headerLoginText"><b>Cancel</b></div>
													</div>
													<div class="saveButtonDiv" style="float:left;width:50px;height:20px;padding:5px;text-align:center;vetical-align:middle; margin:5px;background-color:#c9c9c9;">
														<div id="saveBoxFileUpload" class="buttonDiv headerLoginText"><b>Save</b></div>
													</div>
												</td>
											</tr>
										</table>
									</form>
								</div>		
							</div>
							<script type="text/javascript">
	
								$("#imgUploadFileLink").colorbox({width:"445px;", inline:"true", href:"#imgUploadDiv"});
								
								$("#saveBoxFileUpload").click(function(){
									$("#formSubmit").submit();
								});
								$("#saveBoxFileUpload").mouseover(function(){
									$(this).css("cursor","pointer");
								});
								$("#cancelBoxFileUpload").click(function(){
									$.fn.colorbox.close();
								});
								$("#cancelBoxFileUpload").mouseover(function(){
									$(this).css("cursor","pointer");
								});
	
								$("#imgUploadFile").uploadify({
									'uploader'       : '<var:baseURL>swf/uploadify.swf',
									'script'         : '<var:baseURL>includes/uploadify.php',
									'cancelImg'      : 'images/cancel.png',
									'folder'         : '',
									'queueID'        : 'fileQueue',
									'auto'           : true,
									'multi'          : true,
									'scriptData'	 : {contentId:"<var:content_id>",tableName:"<var:tableNameModule>"}
								});
								
							</script>