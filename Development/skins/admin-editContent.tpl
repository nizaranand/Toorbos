		
		
		<script type="text/javascript">
			$(document).ready(function(){
				$("#updateButton").mouseover(function(event) {
			 		 $(this).css("cursor","pointer");
			 	});
				$("#updateButton").click(function(event) {
			 		 $("#formSubmit").submit();
				});
				$(".textarea").wysiwyg({
				    controls: {
				      strikeThrough : { visible : false },
				      underline     : { visible : false },
				      italic     : { visible : false },
				      
				      separator00 : { visible : false },
				      
				      justifyLeft   : { visible : false },
				      justifyCenter : { visible : false },
				      justifyRight  : { visible : false },
				      justifyFull   : { visible : false },
				      
				      separator01 : { visible : false },
				      
				      indent  : { visible : false },
				      outdent : { visible : false },
				      
				      separator02 : { visible : false },
				      
				      subscript   : { visible : false },
				      superscript : { visible : false },
				      
				      separator03 : { visible : false },

				      bold : { visible : true },
				      h1 : { visible : true },
				      h2 : { visible : true },
				      h3 : { visible : false },
				      insertImage : { visible : false },
				      createLink : { visible : false },
				      
				      separator04 : { visible : true },
				      
				      undo : { visible : true },
				      redo : { visible : true },
				      
				      separator05 : { visible : true },
				      
				      insertOrderedList    : { visible : true },
				      insertUnorderedList  : { visible : true },
				      insertHorizontalRule : { visible : false },

				      separator06 : { visible : true },
				      
				      cut   : { visible : true },
				      copy  : { visible : true },
				      paste : { visible : true }
				    }
				  });
				
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
						<if:message!=><div id="message" style="width:400px;margin:30px auto;padding:10px;background-color:#ffa305;"><var:message></div></if>
						<h2><var:headerTitle></h2><br/>
						<a href="<var:pagePath>../?contentType=<var:tableNameModule>" title="Back to Content List"><img src="images/Fiber/btn-back.png" border="0"/></a>
						<form id="formSubmit" action="<var:baseURL><var:pagePath>" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="cmd" id="cmd" value="<var:cmd>">
						<input type="hidden" name="cmd2" id="cmd2" value="">
						<input type="hidden" name="content_id" value="<var:content_id>">
						<input type="hidden" name="contentType" value="<var:tableNameModule>">
						<loop:contentFields>
						<if:sys_control_id==1>
							<replace:admin-inputBox.tpl>
						</if>						
						<if:sys_control_id==9>
							<replace:admin-wysiwyg.tpl>
						</if>
						<if:sys_control_id==10>
						    <replace:admin-radio.tpl>
						</if>
						<if:sys_control_id==14>
						    <replace:admin-colorpicker.tpl>
						</if>
						<if:sys_control_id==28>
							<replace:admin-gallery.tpl>
						</if>
						<if:sys_control_id==2>
						    <replace:admin-imageupload.tpl>
						</if>
						<if:sys_control_id==5>
							<replace:admin-textarea.tpl>
						</if>
						<if:sys_control_id==21>
							<replace:admin-dropdowncontent.tpl>
						</if>
						<if:sys_control_id==22>
							<replace:admin-crossreference.tpl>
						</if>
						<if:sys_control_id==7>
						    <replace:admin-datepicker.tpl>
						</if>
						</loop:contentFields>
						
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
												<input type="submit" value="Update"/>
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

							

<if:displayName!=Story Date>
<script type="text/javascript">
var arrayOfContentPopulationFields;

$(document).ready(function(){   
 if (arrayOfContentPopulationFields != undefined && arrayOfContentPopulationFields != null){
	 
	 for( var i=0; i<arrayOfContentPopulationFields.length; i++ ){
	  var tmp=arrayOfContentPopulationFields[i];
	  tmp = tmp.split("-");
	  $.getJSON("<var:baseURL>_admin/tools/getModuleAjaxJson.php",{tableName:tmp[1],fieldToPopulate:tmp[0],fieldValue:tmp[2]}, function(j){    
	   var options = '<option value="">Select...</option>';
	   var fieldToPopulate = j[0].fieldToPopulate;
	   for (var i = 0; i < j.length; i++) {
	      options += '<option value="' + j[i].contentId + '"'+(j[i].fieldValue==j[i].contentId ? ' selected' : '')+'>' + j[i].contentName + '</option>';      
	   }      
	   $("#"+fieldToPopulate).html(options);   
	  }
	      )  
	   }
	  }
	});

</script>
</if>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
