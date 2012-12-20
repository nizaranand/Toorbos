		<script type="text/javascript">
			$(document).ready(function(){
				$("#goButton").mouseover(function(event) {
			 		 $(this).css("cursor","pointer");
			 	});
				$("#goButton").click(function(event) {
			 		 $("#hiddenInput").val = 'search';
			 		 $("#searchForm").submit();
				});
			});
		</script>
		<div align="left" class="topBodyDiv">
			<div>
			<span class="headingText">Edit Content</span>
			<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;">
				<tr>
					<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
					<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
					<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
				</tr>
				<tr>
					<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
					<td class="boxBG">
						<form id="searchForm" action="<var:baseURL><var:pagePath>" method="post">
						<div style="padding:7px;">
							<div class="boxTextDiv">
								<span class="boxText">Search</span>
							</div>
							<div class="boxInputDiv">
								<input type="text" title="Enter the Name of the Page you Would Like to Edit" width="150" class="inputBoxStyle" name="search" id="search">
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
						</form>
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
		<div class="paginationDiv"><span class="paginationText"><var:previousPage> <loop:resultPages><a href="<var:baseURL><var:pagePath><var:pageUrl>" class="paginationText"><var:pageNumberDisplay></a> | </loop:resultPages> <var:nextPage></span></div>
		<div class="horizontalRuleDiv"></div>
		<div align="left" class="bodyDiv">
			<loop:modules>
				<a class="bodyLinkText" href="<var:baseURL>adminsystem/editcontent/contenttypelist/?contentType_id=<var:sys_module_id>&tableName=<var:tableName>" title="<var:moduleName> - Click to Edit"><span class="bodyLinkTextBlue">&raquo;</span> <span class="bodyLinkTextOrange"><u>[edit]</u></span> <span class="bodyLinkTextBlue"><u><var:moduleName></u></span></a><br>
			</loop:modules>
		</div>
	</div>