<div class="leftFloat" style="width:100%">	
							<br/><br/>
							<div style="clear:both">
							<h2>Gallery Images</h2>
							<input type="hidden" style="width:340px;" class="inputBoxStyle" name="<var:tableName><var:fieldName>" id="<var:fieldName>" value="<var:content>"/>
							<a href="<var:pagePath>#" id="imgUploadFileLink<var:sys_control_id>" title="Upload new images"><img src="images/Fiber/btn-upload.png" border="0"/></a><br>
							</div>
							Max File Size: 1MB<br>
									<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;" width="100%">
											<tr>
												<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
												<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
												<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
											</tr>
											<tr>
												<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
												<td class="boxBG" width="100%">
												<if:pictures!=>
									<loop:pictures>
									<div class="leftFloat" style="width:100px;margin:5px;border: 1px solid #707070;padding:7px;">	

													<div>
														<div class="boxTextDiv" style="width:100%;">
															<if:src!=/pic_default.jpg><img src="files/<var:tableNameLower>/<var:content_id>/<var:fieldName>/<var:picture>" title="<var:title>" border="0" width="100" align="center"></if>
														</div>
														<div><img src="images/Fiber/icn-help.png" border="0" title="Edit the title for this image"/></div>
														<div class="boxInputDiv">
															 <!-- <b><var:src></b><br/><br/> -->
															 <div style="width:70px;float:left;">Title</div>
															 <div style="width:170px;float:left;"><input type="text" class="inputBoxStyle" name="<var:tableName><var:fieldName>title<var:mod_picture_id>" value="<var:title>" size="11"/></div>
															 <div style="width:170px;float:left;"><input type="radio" name="<var:tableName><var:fieldName>status<var:mod_picture_id>" value="1" size="11" <if:status==1>checked</if>/> Active <br/><input type="radio" name="<var:tableName><var:fieldName>status<var:mod_picture_id>" value="2" size="11" <if:status==2>checked</if>/> Inactive </div>
															 <div style="width:100%;float:left;padding-top:5px;"><input type="radio" name="<var:tableName><var:fieldName>isPrimary" value="<var:mod_picture_id>" <if:isPrimary==yes> checked</if>/> Is Primary? </div>
															 <div style="width:100%;float:left;"><input type="checkbox" name="<var:tableName><var:fieldName>deletePictures[]" value="<var:mod_picture_id>"/> Delete? </div>
														</div>
													</div>

									</div>
								</loop:pictures>
								</if>
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
							<div style="display:none;">
								<div id='imgUploadDiv<var:sys_control_id>' style='padding:20px; background:#fff; height:400px;'>
								
										<input type="file" name="uploadify<var:sys_control_id>" id="imgUploadFile<var:sys_control_id>" />
										<div class="cancelButtonDiv" style="width:200px;height:20px;padding:5px;text-align:center;vetical-align:middle; margin:5px;background-color:#c9c9c9;" onclick="javascript:jQuery('#imgUploadFile<var:sys_control_id>').uploadifyClearQueue()">Cancel All Uploads</div>
										<div id="fileQueue<var:sys_control_id>"></div>
										<table cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td align="right" colspan="2">
													<div class="cancelButtonDiv" style="float:left;width:50px;height:20px;padding:5px;text-align:center;vetical-align:middle; margin:5px;background-color:#c9c9c9;">
														<div id="cancelBoxFileUpload<var:sys_control_id>" class="buttonDiv headerLoginText"><b>Cancel</b></div>
													</div>
													<div class="saveButtonDiv" style="float:left;width:50px;height:20px;padding:5px;text-align:center;vetical-align:middle; margin:5px;background-color:#c9c9c9;">
														<div id="saveBoxFileUpload<var:sys_control_id>" class="buttonDiv headerLoginText"><b>Save</b></div>
													</div>
												</td>
											</tr>
										</table>
								</div>		
							</div>
							<script type="text/javascript">
	
								//$("#imgUploadFileLink<var:sys_control_id>").colorbox({width:"445px;", inline:"true", href:"#imgUploadDiv<var:sys_control_id>"});
								$("#imgUploadFileLink<var:sys_control_id>").fancybox({
									            			'padding'		: 15,
									            			'autoScale'		: true,
									            			'transitionIn'	: 'none',
									            			'transitionOut'	: 'none',
									            			'title'			: 'Image Upload',
									            			'width'		: 445,
									            			'height'		: 495,
									            			'href'			: '#imgUploadDiv<var:sys_control_id>',
									            			'type'			: 'inline'
									            		});
								
								$("#saveBoxFileUpload<var:sys_control_id>").click(function(){
									$("#formSubmit").submit();
								});
								$("#saveBoxFileUpload<var:sys_control_id>").mouseover(function(){
									$(this).css("cursor","pointer");
								});
								$("#cancelBoxFileUpload<var:sys_control_id>").click(function(){
									$.fn.fancybox.close();
								});
								$("#cancelBoxFileUpload<var:sys_control_id>").mouseover(function(){
									$(this).css("cursor","pointer");
								});
	
								$("#imgUploadFile<var:sys_control_id>").uploadify({
									'uploader'       : '<var:baseURL>swf/uploadify.swf',
									'script'         : '<var:baseURL>includes/uploadifyControl.php',
									'cancelImg'      : 'images/cancel.png',
									'folder'         : '',
									'queueID'        : 'fileQueue<var:sys_control_id>',
									'auto'           : true,
									'multi'          : true,
									'scriptData'	 : {contentId:"<var:content_id>",tableName:"<var:tableNameModule>",controlId:"<var:sys_control_id>",fieldName:"<var:fieldName>"}
								});
								
							</script>