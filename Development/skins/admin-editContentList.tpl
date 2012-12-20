					<div style="width:100%; float:left;text-align:left;"><span class="paginationText"><var:previousPage> <loop:resultPages><a href="<var:baseURL><var:pagePath><var:pageUrl>"><var:pageNumberDisplay></a> | </loop:resultPages> <var:nextPage></span></div>
					
					<div style="float:left;padding-top:20px; width:100%;">
						<div style="float:left;">
							<table cellpadding="0" cellspacing="0" border="0" bgcolor="#e6e6e6" width="550">
								<tr>
									<td width="12" height="12"><img src="images/profileBoxTopLeft.gif"></td>
									<td background="images/profileBoxTop.gif"><img src="images/profileBoxTop.gif"></td>
									<td width="12" height="12"><img src="images/profileBoxTopRight.gif"></td>
								</tr>
								<tr>
									<td background="images/profileBoxLeft.gif"><img src="images/profileBoxLeft.gif"></td>
									<td width="100%" align="left">
									<form id="searchForm" action="<var:pagePath>" method="post">
											<div style="height:25px; float:left;">Search: <input type="text" name="search" id="search"></div> <input type="hidden" id="hiddenInput"> <!-- <input type="submit" value="clear" onclick="Javascript:document.getElementById('search').value='';doument.forms[0].submit();"> -->
											<div style="padding-left:5px; padding-top:3px; height:30px; float:left;"><div style="padding-left:5px; background-image:url(<var:baseURL>images/searchButtonRed.gif); height:17px; width:42px; background-repeat:no-repeat;" onMouseOver="Javascript: this.style.cursor='pointer';" onClick="Javascript: document.getElementById('hiddenInput').value='search'; document.getElementById('searchForm').submit();"></div></div>
											<div style="padding-top:3px;  float:left;"><div style="padding-left:5px; background-image:url(<var:baseURL>images/clearButtonRed.gif); height:17px; width:42px; background-repeat:no-repeat;" onMouseOver="Javascript: this.style.cursor='pointer';" onclick="Javascript:document.getElementById('search').value='';document.forms[0].submit();"></div></div>
											<br>
									</form>
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
					
					<loop:pages>
					<div style="float:left;padding-top:20px; width:100%;">
						<div style="float:left;">
							<table cellpadding="0" cellspacing="0" border="0" bgcolor="#e6e6e6" width="550" onMouseOver="Javascript: this.style.cursor='pointer';this.style.color='#d81921';" onMouseOut="Javascript: this.style.color='black';" onClick="Javascript: document.location.href='<var:baseURL><var:pagePath>editpagecontent/?page_id=<var:mod_page_id>&tree_id=<var:sys_tree_id>';">
								<tr>
									<td width="12" height="12"><img src="images/profileBoxTopLeft.gif"></td>
									<td background="images/profileBoxTop.gif"><img src="images/profileBoxTop.gif"></td>
									<td width="12" height="12"><img src="images/profileBoxTopRight.gif"></td>
								</tr>
								<tr>
									<td background="images/profileBoxLeft.gif"><img src="images/profileBoxLeft.gif"></td>
									<td width="100%" align="left">
										<span style="font-family:Arial; font-weight:bold; font-size:11px;"><var:pageName> - <var:baseURL><var:path>.</span><br/>
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
					</loop:pages>

