		<script type="text/javascript">
			$(document).ready(function(){
				$("#addButton").mouseover(function(event) {
			 		 $(this).css("cursor","pointer");
			 	});
				$("#addButton").click(function(event) {
			 		 document.location.href='<var:baseURL><var:pagePath>editcontent/?tableName=<var:currentTableName>';
				});
				$("#uploadButton").mouseover(function(event) {
			 		 $(this).css("cursor","pointer");
			 	});
				$("#uploadButton").click(function(event) {
			 		 //$("#importForm").submit();
				});
				$("#exportButton").mouseover(function(event) {
			 		 $(this).css("cursor","pointer");
			 	});
				$("#exportButton").click(function(event) {
			 		 document.location.href='<var:baseURL><var:pagePath>?cmd=exportcsv&content_id=<var:mod_content_id>&tableName=<var:currentTableName>';
				});
				$("#templateButton").mouseover(function(event) {
			 		 $(this).css("cursor","pointer");
			 	});
				$("#templateButton").click(function(event) {
			 		 document.location.href='<var:baseURL><var:pagePath>?cmd=exportcsvtemplate&content_id=<var:mod_content_id>&tableName=<var:currentTableName>';
				});
			});
		</script>
		<div align="left" class="topBodyDiv">
			<div class="leftFloat">
				<span class="headingText">List Content</span>&nbsp;&nbsp;&nbsp;<a class="backLink" href="<var:baseURL>/adminsystem/editcontent/">Back</a>
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
									<span class="boxText">Which One</span>
								</div>
								<div class="boxInputDiv">
									<input type="text" title="Page Name" style="width:240px;" class="inputBoxStyle" name="whichOne" id="whichOne">
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
								<span class="boxText">Search</span>
								</div>
								<div class="boxInputDiv">
									<input type="text" title="Enter the Name of the Page you Would Like to Edit" style="width:230px;" class="inputBoxStyle" name="search" id="search">
									<input type="hidden" id="hiddenInput">
								</div>
								<div class="leftFloat">
									<table id="goButton" title="Search Pages" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td class="buttonLeft"><img src="images/Fiber/button-leftGrey.jpg"></td>
											<td class="buttonMiddleGrey">
												<span class="buttonText">go&nbsp;</span>
											</td>
											<td class="buttonRight"><img src="images/Fiber/button-rightGrey.jpg"></td>
										</tr>
									</table>
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
			<div class="leftFloat">	
				<div class="horizontalRuleDiv"></div>
			</div>
			<div class="leftFloat" style="padding-top:10px;">
				<div class="leftFloat">
					<table id="addButton" title="Search Pages" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td class="buttonLeft"><img src="images/Fiber/button-left.jpg"></td>
							<td class="buttonMiddle">
								<span class="buttonText">add&nbsp;</span>
							</td>
							<td class="buttonRight"><img src="images/Fiber/button-right.jpg"></td>
						</tr>
					</table>
				</div>
				<div class="leftFloat">
					<a href="#TB_inline?height=140&amp;width=270&amp;inlineId=importDiv&amp;modal=false" class="thickbox" style="border:0; text-decoration:none;"">
						<table id="importButton" title="Search Pages" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td class="buttonLeft"><img src="images/Fiber/button-left.jpg" style="border:0;"></td>
								<td class="buttonMiddle">
									<span class="buttonText">import&nbsp;</span>
								</td>
								<td class="buttonRight"><img src="images/Fiber/button-right.jpg" style="border:0;"></td>
							</tr>
						</table>
					</a>
				</div>
				<div class="leftFloat">
					<table id="exportButton" title="Search Pages" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td class="buttonLeft"><img src="images/Fiber/button-left.jpg"></td>
							<td class="buttonMiddle">
								<span class="buttonText">export data&nbsp;</span>
							</td>
							<td class="buttonRight"><img src="images/Fiber/button-right.jpg"></td>
						</tr>
					</table>
				</div>
				<div class="leftFloat">
					<table id="templateButton" title="Search Pages" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td class="buttonLeft"><img src="images/Fiber/button-left.jpg"></td>
							<td class="buttonMiddle">
								<span class="buttonText">export import data template&nbsp;</span>
							</td>
							<td class="buttonRight"><img src="images/Fiber/button-right.jpg"></td>
						</tr>
					</table>
				</div>
			</div>
			<div id="importDiv" style="float:left; width:100%; display:none;">
				<form id="importForm" enctype="multipart/form-data" action="<var:baseURL><var:pagePath>" method="post">
					<table cellpadding="0" cellspacing="10" border="0">
						<tr>
							<td colspan="2">
								<input type="hidden" name="cmd" value="import">
								<input type="file" name="file">
							</td>
						</tr>
						<tr>
							<td><input type="radio" name="clearValue" value="yes">Yes<input type="radio" name="clearValue" value="no">No</td>
							<td>Clear Value</td>
						</tr>
						<tr>
							<td><input type="text" name="excludeFields"></td>
							<td>Fields to Exclude</td>
						</tr>
						<tr>
							<td colspan="2" align="right">
								<table id="uploadButton" title="Search Pages" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td class="buttonLeft"><img src="images/Fiber/button-left.jpg"></td>
										<td class="buttonMiddle">
											<span class="buttonText">upload&nbsp;</span>
										</td>
										<td class="buttonRight"><img src="images/Fiber/button-right.jpg"></td>
									</tr>
								</table>		
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div class="leftFloat">	
				<div class="paginationDiv"><span class="paginationText"><var:previousPage> <loop:resultPages><a href="<var:baseURL><var:pagePath><var:pageUrl>" class="paginationText"><var:pageNumberDisplay></a> | </loop:resultPages> <var:nextPage></span></div>
				<div class="horizontalRuleDiv"></div>
			</div>
			<div class="leftFloat">
				<div align="left" class="bodyDiv">
					<loop:content>
						<a class="bodyLinkText" href="<var:baseURL><var:pagePath>editcontent/?content_id=<var:mod_content_id>&tableName=<var:currentTableName>" title="<var:contentName> - Click to Edit"><span class="bodyLinkTextBlue">&raquo;</span> <span class="bodyLinkTextOrange"><u>[edit]</u></span> <span class="bodyLinkTextBlue"><u><var:contentName></u></span></a><br>
					</loop:content>
				</div>
			</div>
		</div>