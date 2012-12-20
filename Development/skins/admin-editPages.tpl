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
			<h1>Edit Pages</h1>
			<br/>
			<a href="Javascript:;" onclick="Javascript: $('#search').fadeIn();$('#new').fadeOut();" title="Search content"><img src="images/Fiber/btn-search.png" border="0"/></a> <a href="Javascript:;" title="New content" onclick="Javascript: $('#new').fadeIn();$('#search').fadeOut();"><img src="images/Fiber/btn-new.png" border="0"/></a> <br/>
			
			<div id="search" style="display:none;">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
						<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
						<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
					</tr>
					<tr>
						<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
						<td class="boxBG" style="width:100%">
							<form id="searchForm" action="<var:baseURL><var:pagePath>" method="post">
							<div style="padding:7px;">
								<div class="boxTextDiv">
									<span class="boxText">Search</span>
								</div>
								<div class="boxInputDiv">
									<input type="text" title="Enter the Name you want to search for" size="40" class="inputBoxStyle" name="search" id="search">
								</div>
								<div class="leftFloat">
									<input type="image" src="images/Fiber/btn-go.png"/><input type="image" src="images/Fiber/btn-clear.png"/>
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
			<div id="new" style="display:none;">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
						<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
						<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
					</tr>
					<tr>
						<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
						<td class="boxBG" style="width:100%">
							<form id="searchForm" action="<var:baseURL><var:pagePath>editpage/" method="post">
							<input type="hidden" name="cmd" value="new"/>
							<div style="padding:7px;">
								<div class="boxTextDiv">
									<span class="boxText">Page Title</span>
								</div>
								<div class="boxInputDiv">
									<input type="text" title="Enter the Name of the page you want to create" size="40" class="inputBoxStyle" name="name" id="name">
								</div>
								<div class="leftFloat">
									<input type="image" src="images/Fiber/btn-create.png"/>
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
		</div>
		<div class="paginationDiv" style="margin:10px;"><span class="paginationText"><var:previousPage> <loop:resultPages><a href="<var:baseURL><var:pagePath><var:pageUrl>" class="paginationText"><var:pageNumberDisplay></a> | </loop:resultPages> <var:nextPage></span></div>
		<div class="horizontalRuleDiv"></div>
		<div align="left" class="bodyDiv">
			<loop:pages>
							<div class="leftFloat" style="width:50%;">	
								<table cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;" width="100%">
									<tr>
										<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
										<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
										<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
									</tr>
									<tr>
										<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
										<td class="boxBG" width="100%">
											<div style="padding:7px;height:180px;">
												<div class="boxTextDiv" style="width:250px;">
													<span class="boxText"><a href="<var:baseURL>admin/editpages/editpage/?page_id=<var:mod_page_id>&tree_id=<var:sys_tree_id>" style="color:#1a1a1a;text-decoration:none;font-weight:bold;"><var:title></a></span>
												</div>
												<div style="float:left;padding:2px;"><a href="<var:baseURL>admin/editpages/editpage/?page_id=<var:mod_page_id>&tree_id=<var:sys_tree_id>"><img src="images/Fiber/<var:image>" title="<var:title>" border="0"/></a></div>
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
			</loop:pages>
		</div>
	</div>