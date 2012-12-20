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
		<div align="left" class="topBodyDiv">
			<form id="formSubmit" action="<var:baseURL><var:pagePath>" method="POST">
			<input type="hidden" name="cmd" value="<var:cmd>">
			<input type="hidden" name="page_id" value="<var:mod_page_id>">
			<input type="hidden" name="tree_id" value="<var:tree_id>">
			<div class="leftFloat">
				<span class="headingText">Edit Page</span>&nbsp;&nbsp;&nbsp;<a style="font-family: Arial; font-size:12px; color:#ff3f14;" href="<var:baseURL>admin/editpages/" title="Back to List of pages"><img src="images/Fiber/btn-back.png" border="0"></a>
			<div class="leftFloat">
			<div class="leftFloat">	
				<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;">
					<tr>
						<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
						<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
						<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
					</tr>
					<tr>
						<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
						<td class="boxBG" width="366">
							<div style="padding:7px;">
								<div class="boxTextDiv">
									<span class="boxText">Page Name</span>
								</div>
								<div class="boxInputDiv">
									<input type="text" title="Page Name" style="width:240px;" class="inputBoxStyle" name="pageName" id="pageName" value="<var:pageName>">
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
			<div style="float:right;">	
				<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;">
					<tr>
						<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
						<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
						<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
					</tr>
					<tr>
						<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
						<td class="boxBG" width="366">
							<div style="padding:7px;">
								<div class="boxTextDiv">
									<span class="boxText">Page Title</span>
								</div>
								<div class="boxInputDiv">
									<input type="text" title="Page Title" style="width:240px;" class="inputBoxStyle" name="pageTitle" id="pageTitle" value="<var:pageTitle>">
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
<!-- 		<div style="float:left;">	
				<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;">
					<tr>
						<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
						<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
						<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
					</tr>
					<tr>
						<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
						<td class="boxBG" width="366">
							<div style="padding:7px;">
								<div class="boxTextDiv">
									<span class="boxText">Publish this Page</span>
								</div>
								<div class="boxInputDiv" style="padding-top:8px;">
									<span class="boxText"><input type="radio" name="publish" value="yes" <if:published==yes>checked</if>> Yes <input type="radio" name="publish" value="no" <if:published==no>checked</if>> No</span>
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
			<div style="float:right;">	
				<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;">
					<tr>
						<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
						<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
						<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
					</tr>
					<tr>
						<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
						<td class="boxBG" width="366">
							<div style="padding:7px;">
								<div class="boxTextDiv">
									<span class="boxText">Page Path</span>
								</div>
								<div class="boxInputDiv" style="padding-top:10px;">
									<span class="systemText"><var:pagePath> {system generated}</span>
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
			</div>//-->
			<div class="leftFloat">	
				<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;">
					<tr>
						<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
						<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
						<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
					</tr>
					<tr>
						<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
						<td class="boxBG" width="366">
							<div style="padding:7px;">
								
								<span class="boxText">Page Keywords</span>
								<br/>
								<textarea name="metaKeywords" cols="40" rows="5"><var:metaKeywords></textarea>
								
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
			<div style="float:right;">	
				<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;">
					<tr>
						<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
						<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
						<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
					</tr>
					<tr>
						<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
						<td class="boxBG" width="366">
							<div style="padding:7px;">
								<span class="boxText">Page Description</span>
								<br/>
								<textarea name="metaDescription" cols="40" rows="5"><var:metaDescription></textarea>
								
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
			<div class="leftFloat">	
				<div class="horizontalRuleDiv"></div>
			</div>
			<div class="leftFloat">
				<div align="left" class="bodyDiv">
					<span class="headingText">Content Areas on Page</span>
					<loop:containers>
					<input type="hidden" name="cmd<var:mod_container_id>" value="<var:cmd>">
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
										<span class="containerText"><var:containerName></span>
									</div>
									<div style="padding:7px;">
										<input type="hidden" id="html<var:mod_container_id>" name="html<var:mod_container_id>" value="<var:html>" style="display:none" /><input type="hidden" id="html<var:mod_container_id>___Config" value="sBasePath=<var:baseURL>_admin/tools/fckeditor/&EditorAreaCSS=<var:baseURL>css/stylesheet.css&BaseHref=<var:baseURL>" style="display:none" /><iframe id="html<var:mod_container_id>___Frame" src="<var:baseURL>_admin/tools/fckeditor/editor/fckeditor.html?InstanceName=html<var:mod_container_id>&amp;Toolbar=Expert" width="745px;" height="300" frameborder="0" scrolling="no"></iframe>
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
					</loop:containers>
				</div>
				<div class="rightFloat">
					<input type="image" src="images/Fiber/btn-update.png"/>
				</div>
			</div>
		</form>
		</div>
