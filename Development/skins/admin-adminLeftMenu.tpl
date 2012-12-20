<ul style="list-style:none;display:table-row;width:100%;">
<li class="adminMenu">
				<h1>Content</h1><br/>
				<table cellpadding="0" cellspacing="0" border="0" heigh="100%">
					<tr>
						<td class="boxTopLeft"><img src="images/Fiber/editBoxTopLeft.jpg"></td>
						<td class="boxTop"><img src="images/Fiber/editBoxTop.jpg"></td>
						<td class="boxTopRight"><img src="images/Fiber/editBoxTopRight.jpg"></td>
					</tr>
					<tr>
						<td class="boxLeft"><img src="images/Fiber/editBoxLeft.jpg"></td>
						<td class="boxBG" style="width:100%">
							<ul>
								<loop:modules>
									<li<if:selected==yes> class="current"</if> onclick="Javascript: document.location='<var:baseURL><var:pagePath>?contentType=<var:tableName>';"><a href="<var:pagePath>?contentType=<var:tableName>" title="<var:name>"><var:name></a></li>
								</loop:modules>					
							</ul>
						</td>
						<td class="boxRight"><img src="images/Fiber/editBoxRight.jpg"></td>
					</tr>
					<tr>
						<td class="boxBottomLeft"><img src="images/Fiber/editBoxBottomLeft.jpg"></td>
						<td class="boxBottom"><img src="images/Fiber/editBoxBottom.jpg"></td>
						<td class="boxBottomRight"><img src="images/Fiber/editBoxBottomRight.jpg"></td>
					</tr>
				</table>

	<script type="text/javascript">
		$(document).ready(function(){

			$(".adminMenu li").mouseover(function(){
				if( !$(this).is(".current") ){
					$(this).addClass("active");
				}				
			});

			$(".adminMenu li").mouseout(function(){
				$(this).removeClass("active");				
			});


			
		});
	</script>
</li>