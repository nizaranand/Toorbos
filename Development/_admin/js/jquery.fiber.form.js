$(document).ready(function(){
	
	$('form').submit(function(){
		
		return validation('#'+$(this).attr('id'));
		
	});
	
	$('input').keyup(function(e){
		validate($(this),e);
	});
	
});

var skipcompare = false;
var formValidated = false;

function validation(form){
	form = $(form);
	
	var returnValue = true;
	
	form.find('input').each(function(){
		if( !validate($(this),null) ){
//			alert("Didnt validate input: ".$(this).attr('name'));
			returnValue = false;
		}
		
	});
	
	form.find('textarea').each(function(){
		if( !validate($(this),null) ){
			//alert("Didnt validate textarea: ".$(this).attr('name'));
			returnValue = false;
		}
		
	});
	
	form.find('select').each(function(){
		if( !validate($(this),null) ){
			//alert("Didnt validate select: ".$(this).attr('name'));
			returnValue = false;
		}
		
	});
	
	form.find('textarea').keyup(function(e){
		validate($(this),e);
	});
	
	form.find('select').change(function(e){
		validate($(this),e);
	});
	
	formValidated = returnValue;
	return returnValue;
}

function validate(el,event){
	var messages = '';
	messages += (messages!='' ? '<br>' : '')+checkRequired(el);
	messages += (messages!='' ? '<br>' : '')+checkMin(el);
	messages += (messages!='' ? '<br>' : '')+checkMax(el);
	messages += (messages!='' ? '<br>' : '')+checkType(el,event);
	messages += (messages!='' ? '<br>' : '')+checkCompare(el);
	
	if( messages=='' ){
		clearError(el);
		return true;
	}else{
		showError(el,messages);
		return false;
	}
}

function checkRequired(el){
	if( el.attr('required')!=undefined && (el.attr('required')=='yes' || el.attr('required')=='required') && el.val()=='' ){
		return 'This field is required';
	}
	
	return '';
}

function checkMin(el){
	if( (el.attr('min')!=undefined && el.attr('min')!='' && el.val()=='') || (el.attr('min')!=undefined && el.attr('min')!='' && el.val()!='' && parseFloat(el.val().length)<parseFloat(el.attr('min'))) ){
		return 'The minimum value for this field is: '+el.attr('min');
	}
	
	return '';
}

function checkMax(el){
	if( (el.attr('max')!=undefined && el.attr('max')!='' && el.val()=='') || (el.attr('max')!=undefined && el.attr('max')!='' && el.val()!='' && parseFloat(el.val())>parseFloat(el.attr('max'))) ){
		return 'The maximum value for this field is: '+el.attr('max');
	}
	return '';
}

function checkType(el,event){
	if( el.attr('fieldType')!=undefined && el.attr('fieldType')!='' && el.attr('fieldType')=='number' && el.val()!='' && isNaN(el.val()) || (event!=undefined && event.keyCode==32)){
		return 'This field requires numeric entry';
	}
		
	if( el.attr('fieldType')!=undefined && el.attr('fieldType')!='' && el.attr('fieldType')=='string' && el.val()!='' && (event!=undefined && event.keyCode>=48 && event.keyCode<=57) ){
		return 'This field requires string entry';
	}
	
	return '';
}

function checkCompare(el){
	var test = 'input[name='+el.attr('compareTo')+']';
	if( el.attr('compareTo')!=undefined && el.attr('compareTo')!='' && $(test).val()!=el.val() ){
		var name =  $('input[name='+el.attr('compareTo')+']').attr('displayName')!=undefined ?  $('input[name='+el.attr('compareTo')+']').attr('displayName') : el.attr('compareTo');
		return 'This field must match: '+name;
	}else if( !skipcompare ){
		skipcompare = true;
		validate($(test));
	}
	
	if( skipcompare ){
		skipcompare = false;
	}
	
	return '';
}

function showError(el,error){
	var id = el.attr('id')!='' ? el.attr('id') : el.attr('name');
	
	var position = el.offset();
	var width = el.width();
	var height = el.height();
	var top = position.top;
	var left = position.left+(width);
	
	if( $('#'+id+'-error').length==0 ){
		$('body').prepend('<div id="'+id+'-error" style="position: absolute; top:'+top+'px; left:'+left+'px; background-color:red;z-index:1000;padding:10px;color:white;" class="absolute error">'+error+'</div>');
	}else{
		$('#'+id+'-error').html(error);
	}
}

function clearError(el){
	var id = el.attr('id')!='' ? el.attr('id') : el.attr('name');
	$('#'+id+'-error').remove();
}
