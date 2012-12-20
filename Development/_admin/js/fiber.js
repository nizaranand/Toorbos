document.write('<script type="text/javascript" src="_admin/js/swfupload.js"></script>');
document.write('<script type="text/javascript" src="_admin/js/swfupload.queue.js"></script>');
document.write('<script type="text/javascript" src="_admin/js/fileprogress.js"></script>');
document.write('<script type="text/javascript" src="_admin/js/handlers.js"></script>');
document.write('<script type="text/javascript" src="_admin/js/jquery-ui-1.8.13.custom.min.js"></script>');
document.write('<script type="text/javascript" src="_admin/js/jquery.fileupload.js"></script>');

$(document).ready(function(){
	$(".background").css('min-height',($(window).height()-111)+"px");
	
	$('.input-clear').live('click',function(){
		if( $(this).attr('oldhtml')==undefined || $(this).val()==$(this).attr('oldhtml') ){
			$(this).attr('oldhtml',$(this).val());
			$(this).val("");
		}
	});
	$('.input-clear').live('focus',function(){
		if( $(this).attr('oldhtml')==undefined || $(this).val()==$(this).attr('oldhtml') ){
			$(this).attr('oldhtml',$(this).val());
			$(this).val("");
		}
	});
	$('.input-clear').live('blur',function(){
		if( $(this).val()=='' ){
			$(this).val($(this).attr('oldhtml'));
		}
	});
	
	$( ".datepicker" ).each(function(){
		var val = $(this).val();
		$(this).datepicker();
		$(this).datepicker( "option", "dateFormat",'yy-mm-dd' );
		$(this).datepicker("setDate",val);
	});
	
	$( ".date" ).each(function(){
		var val = $(this).val();
		$(this).datepicker();
		$(this).datepicker( "option", "dateFormat",'yy-mm-dd' );
		$(this).datepicker("setDate",val);
	});

	
	$('.fiber-autosave').change(function(){
		var moduleName = $(this).attr('moduleName');
		var fieldName = $(this).attr('fieldName');
		var contentId = $(this).attr('contentId');
		var parentEl = $(this).parent();
		
		var url = baseURL+adminPath+'/tools/updateContentAjax.php?'+fieldName+'='+$(this).val()+'&requestTime='+(new Date()).getTime()+"&PHPSESSID="+sessionID+"&moduleName="+moduleName+"&contentId="+contentId;
		
		$.ajax({
			type: 'GET',
			url : url,
			context : document.body,
			dataType : "json",
			success : function(data) {
				parentEl.css('border','0px');
				parentEl.css('border-bottom','1px solid #a4a4a4');
			},
			error : function(error, errorMessage, test) {
				alert("There was an error saving " + fieldName + " please contact support:" + errorMessage);
			}
		});
	});
	
	$('.fiber-autosave').keydown(function(){
		$(this).parent().css('border','1px solid red');
	});
	
});

$(window).resize(function() {
	$(".background").css('min-height',($(window).height()-111)+"px");
});

function loadModuleFieldAdmin(fieldName,contentId,tableName,value){
	$.ajax({
		url: baseURL+adminPath+"/tools/getControlAjax.php?moduleName="+tableName+"&content_id="+contentId+"&fieldName="+fieldName+"&cmd=admin&uiId="+fieldName,
		dataType: "json",
		data: {
			requestTime: (new Date()).getTime()		
		},
		success: function( data ) {
			$("#"+tableName+"-field-"+data[0].uiId+"-edit").html(data[0].output);
	}
	});
}

function loadModuleFieldAdminList(fieldName,contentId,tableName,value){
	$.ajax({
		url: baseURL+adminPath+"/tools/getControlAjax.php?moduleName="+tableName+"&content_id="+contentId+"&fieldName="+fieldName+"&cmd=admin&uiId="+fieldName,
		dataType: "json",
		data: {
			requestTime: (new Date()).getTime()		
		},
		success: function( data ) {
			$("#"+tableName+"-field-"+data[0].uiId+"-edit-"+contentId).html(data[0].output);
	}
	});
}

function loadModuleField(fieldName,contentId,tableName,value){
	$.ajax({
		url: baseURL+adminPath+"/tools/getControlAjax.php?moduleName="+tableName+"&content_id="+contentId+"&fieldName="+fieldName+"&cmd=get&uiId="+fieldName,
		dataType: "json",
		data: {
			requestTime: (new Date()).getTime()		
		},
		success: function( data ) {
			$("#"+tableName+"-field-"+data[0].uiId+'-view').html(data[0].output);
	}
	});
}

function loadModuleFieldList(fieldName,contentId,tableName,value){
	$.ajax({
		url: baseURL+adminPath+"/tools/getControlAjax.php?moduleName="+tableName+"&content_id="+contentId+"&fieldName="+fieldName+"&cmd=get&uiId="+fieldName,
		dataType: "json",
		data: {
			requestTime: (new Date()).getTime()		
		},
		success: function( data ) {
			$("#"+tableName+"-field-"+data[0].uiId+'-view-'+contentId).html(data[0].output);
	}
	});
}

function loadLookups(){

	$( ".lookup" ).autocomplete({
		source: function( request, response ) {
			var addValues = ""; 
			
			if( additionalLookupParams!=undefined && additionalLookupParams.length>0 ){
				for( var i=0; i<additionalLookupParams.length; i++ ){
					addValues += '&'+additionalLookupParams[i]+"="+additionalLookupValues[i];
				}
			}
			$.ajax({
				url: baseURL+"_admin/tools/getContentAjax.php?requestTime="+(new Date()).getTime()+addValues,
				dataType: "json",
				data: {
					moduleName: currentLookupModule,
					wildcard: request.term,
					requestTime: (new Date()).getTime(),
					filterRelationshipFields: filterRelationshipFields!=undefined ? filterRelationshipFields : new Array(),
					filterRelationshipValues: filterRelationshipValues!=undefined ? filterRelationshipValues : new Array(),
					onlyRelationships: onlyRelationships!=undefined ? onlyRelationships : 'no',
					filterFields: filterFields!=undefined ? filterFields : new Array(),
					filterValues: filterValues!=undefined ? filterValues : new Array(),
				    PHPSESSID: sessionID
				},
				success: function( data ) {
					response( $.map( data, function( item ) {
						return {
							label: item.displayName!=undefined ? item.displayName : item.name,
							value: item.mod_content_id
						}
					}));
				}
			});
		},
		minLength: 2,
		focus: function() {
			// prevent value inserted on focus
			return false;
		},
		select: function( event, ui ) {
			
			var currentHTML = $(currentLookupModuleListId).html();
							
			var newHtml = '<div style="float:left;padding:10px;" id="'+currentLookupModuleListFieldName+'-'+ui.item.value+'"><img src="'+baseURL+'/'+adminPath+'/images/icn-delete.png" class="lookup-delete" style="cursor:pointer;" align="left"> &nbsp;&nbsp; <input type="hidden" name="'+currentLookupModuleListFieldName+'[]" value="'+ui.item.value+'"> <a href="admin/editcontent/edit/?contentType='+currentLookupModule+'&content_id='+ui.item.value+'">'+ui.item.label+'</a></div>';
			
			$(currentLookupModuleListId).html(currentHTML+newHtml);
			return false;
		}
	});
}

var sessionID = "";
var clientURL = "";
var dirPath = "";
var initFileUploader = "no";
var filterRelationshipFields = new Array();
var filterRelationshipValues = new Array();
var filterFields = new Array();
var filterValues = new Array();
var currentLookupModule = '';
var currentLookupModuleListId = '';
var currentLookupModuleFieldName = '';
var additionalLookupParams = ''; 

$(window).ready(function() {

		var swfu;
	    if( initFileUploader=="yes" ){
			var settings = {
				flash_url : "_admin/js/swfupload.swf",
				upload_url: "../files/upload.php",
				post_params: {"PHPSESSID" : sessionID,"clientURL":clientURL,"dirPath":dirPath},
				file_size_limit : "100 MB",
				file_types : "*.*",
				file_types_description : "All Files",
				file_upload_limit : 100,
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				// Button settings
				button_width: "125",
				button_height: "29",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: 'Select Files',
				button_text_style: ".theFont { font-size: 16; }",
				button_text_left_padding: 12,
				button_text_top_padding: 3,
				
				// The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	// Queue plugin event
			};
			swfu = new SWFUpload(settings);
		}
	    	
	    $( ".lookup" ).live('mouseover',function(){
			currentLookupModule =  $(this).attr("tableName");
			currentLookupModuleListId = '#'+$(this).attr("uiId");
			currentLookupModuleListFieldName = $(this).attr("fieldName");
			onlyRelationships = $(this).attr("onlyRelationships");
		});
		
		$( ".lookup-create" ).live('click',function(){
			
			var valueId = "#"+$(this).attr("valueId");
			var tableName = $(this).attr("tableName");
			var value = $(valueId).val();
			
			var addValues = ""; 
			
			if( additionalLookupParams!=undefined && additionalLookupParams.length>0 ){
				for( var i=0; i<additionalLookupParams.length; i++ ){
					addValues += '&'+additionalLookupParams[i]+"="+additionalLookupValues[i];
				}
			}
			
			$.ajax({
				url: baseURL+"_admin/tools/createContentAjax.php?moduleName="+tableName+"&name="+value+"&tableName="+tableName+addValues,
				dataType: "json",
				data: {
					moduleName: tableName,
					tableName: tableName,
					name: value,
					displayName: value,
					requestTime: (new Date()).getTime(),
				    PHPSESSID: sessionID
					
				},
				success: function( data ) {
					var currentHTML = $(currentLookupModuleListId).html();
					var newHtml = '<div style="float:left;padding:10px;" id="'+currentLookupModuleListFieldName+'-'+data.id+'"><img src="'+baseURL+'/'+adminPath+'/images/icn-delete.png" class="lookup-delete" style="cursor:pointer;" align="left"> &nbsp;&nbsp; <input type="hidden" name="'+currentLookupModuleListFieldName+'[]" value="'+data.id+'"> <a href="admin/editcontent/edit/?contentType='+currentLookupModule+'&content_id='+data.id+'">'+data.name+'</a></div>';
					$(currentLookupModuleListId).html(currentHTML+newHtml)
				}
			});
			
		});
		
		$(".lookup-delete").live('click',function(){
			$(this).parent().remove();
		});
		
	    
   });	

$(function() {
	
	function log( message ) {
		$( "<div/>" ).text( message ).prependTo( "#log" );
		$( "#log" ).attr( "scrollTop", 0 );
	}
	loadLookups();
});

var controls = new Array();
  function addControl(control){
     controls.push(control);
  }
  function expandControl(number){
     var control = controls[number];
     control.style.display='block';
  }
  function contractControl(number){
     var control = controls[number];
     control.style.display='none';
  }
  function expandAll(){
     for( var x=0; x<controls.length; x++ ){
        expandControl(x);
     }
  }
  function contractAll(){
     for( var x=0; x<controls.length; x++ ){
        contractControl(x);
     }
  }
  function expandAllBelow(control){
     var below = 0;
     for( var x=0; x<controls.length; x++ ){
       var controlToMatch = controls[x];
       if( below || controlToMatch == control ){
          expandControl(x);
          below = 1;
       }
     }
  }
  

	var saveForm = '';


	
	function hideLoading(){
	//	document.getElementById("loadingWindow2").style.display = 'none';	
	}
	
	function showEditScreen(url){
		
		$.fancybox({
			'padding'		: 15,
			'autoScale'		: true,
			'transitionIn'	: 'none',
			'transitionOut'	: 'none',
			'title'			: this.title,
			'width'		: 680,
			'height'		: 495,
			'href'			: url,
			'type'			: 'iframe'
		});


		
			


//			$.colorbox(url+"&pagePath=");
/*			document.getElementById("loadingWindow2").style.display = 'block';
			var el = document.getElementById("editWindow");
			el.style.display = "block";
		    var el2 = document.getElementById("opacityWindow");
		    el2.style.display = "block";
		    document.getElementById("editWindowBoxes").src=url+'&pagePath=<var:pagePath>';
		    document.getElementById("saveButton").style.display = 'block';
		    positionEditWindow();*/
	}

	function hideSaveButton(){
		document.getElementById("saveButton").style.display = 'none';
	}
	
	function showSaveButton(){
		document.getElementById("saveButton").style.display = 'block';
	}
	
	function hideCreateButton(){
		document.getElementById("createButton").style.display = 'none';
	}
	
	function showCreateButton(){
		document.getElementById("createButton").style.display = 'block';
	}

	function setSaveForm(iSaveForm){
	saveForm = iSaveForm;
	}

	function saveContent(){
	    saveForm.submit();
	}

    function hideEditScreen(){
			var el = document.getElementById("editWindow");
			el.style.display = "none";
		    var el2 = document.getElementById("opacityWindow");
		    el2.style.display = "none";
	}
	function displayToolbar(id){
		var object = document.getElementById("layer"+id);
	    var objectToolbar = document.getElementById("toolbar"+id);
	    var objectShade = document.getElementById("shade"+id);
	    if(_ie == true){
	//	    eval("var object  = window.layer"+id+";");
	//	    eval("var objectToolbar  = window.toolbar"+id+";");
	        object.style.borderStyle = 'dotted';
			object.style.borderColor = '#336699';

//			objectShade.style.display = 'block';

			objectToolbar.style.visibility = 'visible';
			objectToolbar.style.left = object.style.left;
			objectToolbar.style.top = object.style.top;
			objectToolbar.style.align = 'left';


			objectShade.style.width = object.offsetWidth;
			objectShade.style.left = object.offsetLeft;
			objectShade.style.top = object.offsetTop;
			objectShade.style.height = object.offsetHeight;

	    } else if (_ns == true){
	        object.style.borderStyle = 'dotted';
			object.style.borderColor = '#336699';

			objectToolbar.style.visibility = 'visible';
			objectToolbar.style.left = object.style.left;
			objectToolbar.style.top = object.style.top;
			objectToolbar.style.align = 'left';
	    }
	}

	function hideToolbar(id)
	{
		var object = document.getElementById("layer"+id);
	    var objectToolbar = document.getElementById("toolbar"+id);
	    var objectShade = document.getElementById("shade"+id);
        if(_ie == true){
			object.style.borderColor = '<var:borderColor>';
			objectToolbar.style.visibility = 'hidden';
			objectShade.style.display = 'none';
        } else if (_ns == true){
			object.style.borderColor = '<var:borderColor>';
			objectToolbar.style.visibility = 'hidden';
        }
	}

var js_ScriptFragment = '(?:<script.*?>)((\n|\r|.)*?)(?:<\/script>)';
var js_ScriptSrcFragment = '<script.+(src[ ]*=[ ]*\'(.*?)\'|src[ ]*=[ ]*"(.*?)").+';

function js_extractScripts(str)
{
	var matchAll = new RegExp(js_ScriptFragment, 'img');
	var matchOne = new RegExp(js_ScriptFragment, 'im');
	var matchSrc = new RegExp(js_ScriptSrcFragment, 'im');

	var arr = str.match(matchAll) || [];
	var res = [];

	for (var i = 0; i < arr.length; i++)
	{
		var srcMt = arr[i].match(matchSrc);
		if (srcMt)
		{
			if (srcMt.length > 3) res.push(['src', srcMt[3]]);
			else res.push(['src', srcMt[2]]);
		}

		var mtCode = arr[i].match(matchOne) || ['', ''];
		if (mtCode[1] != '') res.push(['code', mtCode[1]]);
	}

	return res;
}

function js_evalScripts(str)
{
	var ex;
	var arr = js_extractScripts(str);

	for (var i = 0; i < arr.length; i++)
	{
		switch (arr[i][0])
		{
			case 'src':
				js_loadScript(arr[i][1]);
				break;

			case 'code':
				var cnt = arr[i][1];

				// hack for RadTabStrip
				// but the best way is set HttpContext.Current.Request["httprequest"] to true in code behind
				cnt = cnt.replace(/AppendStyleSheet\(false,/g, 'AppendStyleSheet(true,');
				var firstDiv = document.getElementById("content2900x3");
				eval(cnt);
				break;
		}
	}
}

