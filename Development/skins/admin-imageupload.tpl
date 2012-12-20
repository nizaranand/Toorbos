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
												   <img src="files/<var:tableNameLower>/<var:content_id>/<var:content>" width="300">																			
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
							
														//$("#imgUploadFileLink<var:fieldName>").colorbox({width:"445px;", inline:"true", href:"#imgUploadDiv<var:fieldName>"});
														$("#imgUploadFileLink<var:fieldName>").fancybox({
									            			'padding'		: 15,
									            			'autoScale'		: true,
									            			'transitionIn'	: 'none',
									            			'transitionOut'	: 'none',
									            			'title'			: 'Image Upload',
									            			'width'		: 445,
									            			'height'		: 495,
									            			'href'			: '#imgUploadDiv<var:fieldName>',
									            			'type'			: 'inline'
									            		});

														$("#imgDeleteFileLink<var:fieldName>").click(function(){
															$.ajax({
																   url: "<var:baseURL>includes/uploadifyField.php",
																   data: "contentId=<var:content_id>&tableName=<var:tableNameModule>&fieldName=<var:fieldName>&controlValues=<var:controlValues>&cmd=delete",
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
															$.fn.fancybox.close();
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
															'scriptData'	 : {contentId:"<var:content_id>",tableName:"<var:tableNameModule>",fieldName:"<var:fieldName>",controlValues:"<var:controlValues>"}
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