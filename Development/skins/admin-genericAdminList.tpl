			<li style="list-style:none;display:table-cell;vertical-align:top;width:75%;padding:10px;">
			<if:contentType!=>
				<h2><var:title></h2>
				<br/>
				
				<a href="Javascript:;" onclick="Javascript: $('#search').fadeIn();$('#new').fadeOut();" title="Search content"><img src="images/Fiber/btn-search.png" border="0"/></a> <a href="Javascript:;" title="New content" onclick="Javascript: $('#new').fadeIn();$('#search').fadeOut();"><img src="images/Fiber/btn-new.png" border="0"/></a> <a href="<var:pagePath>?cmd=export&<var:requestVars>" title="Export content"><img src="images/Fiber/btn-export.png" border="0"/></a><br/>
				
				<form id="searchForm" action="<var:baseURL><var:pagePath>" method="post">
				<input type="hidden" name="contentType" value="<var:contentType>"/>
				<div style="padding:7px;display:none;" id="search">
				<table cellpadding="0" cellspacing="0" border="0" heigh="100%">
					<tr>
						<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
						<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
						<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
					</tr>
					<tr>
						<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
						<td class="boxBG" style="width:100%">
						
							<div class="boxTextDiv">
								<span class="boxText">Search</span>
							</div>
							<div class="boxInputDiv">
								<input type="text" title="Enter the Name you want to search for" size="35" class="inputBoxStyle" name="searchName" id="searchName">
							</div>
							<div class="leftFloat">
								<input type="image" src="images/Fiber/btn-go.png"/><input type="image" src="images/Fiber/btn-clear.png"/>
							</div>
							<div class="boxTextDiv">
								<span class="boxText"><b>Search in </b> <loop:fieldsList><input type="radio" name="searchField" value="<var:name>"/> <var:name> </loop:fieldsList></span>
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
				</form>


				<form id="searchForm" action="<var:baseURL><var:pagePath>edit/" method="post">
				<input type="hidden" name="contentType" value="<var:contentType>"/>
				<input type="hidden" name="cmd" value="new"/>
				<div style="padding:7px;display:none;" id="new">
				<table cellpadding="0" cellspacing="0" border="0" heigh="100%">
					<tr>
						<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
						<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
						<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
					</tr>
					<tr>
						<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
						<td class="boxBG" style="width:100%">
							<div class="boxTextDiv">
								<span class="boxText">New</span>
							</div>
							<div class="boxInputDiv">
								<input name="name" title="Enter the name of the new item you want to add" size="35" class="inputBoxStyle" />
							</div>
							<div class="leftFloat">
								<input type="image" src="images/Fiber/btn-create.png"/>
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
				</form>
				
				<if:message!=><div id="message" style="width:400px;margin:30px auto;padding:10px;background-color:#ffa305;"><var:message></div></if>
				
				<form method="post" id="contentListForm" onsubmit="return confirm('Are you sure you want to delete selected items?');" action="<var:pagePath>">
				
				<input type="hidden" name="cmd" value="update"/>
				
				<input type="hidden" name="contentType" value="<var:contentType>"/>

				<div>&nbsp;</div>

				<div style="float:right"><input type="image" src="images/Fiber/btn-delete.png" title="Delete selected" align="right"/></div>
				<table cellpadding="0" cellspacing="0" border="0" width="100%" class="dataList">
				<tr>
					<if:contentType==picture><th>Picture</th></if>
					<th>Name</th>
					<th width="20">Delete</th>
				</tr>
				<loop:contentList>
				<tr>
					<if:contentType==picture><td><img src="files/article/<var:relatedContentId>/pictures/135135/<var:picture>"/></td></if>
					<td><a href="<var:pagePath>edit/?contentType=<var:contentType>&content_id=<var:contentId>" title="Edit <var:title>"><var:name></a></td>
					<td align="center"><input type="checkbox" name="deleteList[]" value="<var:contentId>"/></td>
				</tr>
				</loop:contentList>
				</table>
				<div style="float:right"><input type="image" src="images/Fiber/btn-delete.png" title="Delete selected" align="right"/></div>

				</form>
				<script type="text/javascript">
					$(".dataList tr").mouseover(function(){
						if( !$(this).is(".active") ){
							$(this).addClass("active");
						}				
					});
	
					$(".dataList tr").mouseout(function(){
						if( $(this).is(".active") ){
							$(this).removeClass("active");
						}				
					});
				</script>
			</if>
			<if:contentType==>
				<h1>Edit Content</h1><br/>
				Select the content on the left you'd like to edit...
			</if>
				
			</li>
		</ul>
