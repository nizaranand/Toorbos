// Function to calculate length of stay
function dateDiff(dateFrom,dateTo) {
	
	// Set dates
  	var datefrom = dateFrom;
	var dateto = dateTo;
	
	if ( datefrom == 'From' ) { datefrom = 0; }
	if ( dateto == 'To' ) { dateto = 0; }
	
	// Changes dates so Jquery can understand them
	newdatefrom = datefrom.replace(new RegExp("/", "g"), '-');
	newdateto = dateto.replace(new RegExp("/", "g"), '-')
	
	// Calculate difference between dates
	var start = new Date(datefrom);
	var end = new Date(dateto);
	var diff = new Date(end - start);
	var days = diff/1000/60/60/24;
	
	return days;
	
}

jQuery("#datefrom").change(function () {
	
	// Calculate length of stay
	days = dateDiff(jQuery(this).val(),jQuery("#dateto").val());
	
	// Calculate new price based on price of room
	var roomprice = getPrice;
	
	// Calculate new price based on price of room and length of stay
	var newprice = days * roomprice;
	
	// Display new price
  	jQuery(".room-price").text(newprice);
	jQuery(".price-detail-value").text(days);
	
	if ( jQuery("#datefrom").val() > jQuery("#dateto").val() ) {
		jQuery("#datefrom").effect("pulsate", { times:3 }, 250);
		jQuery(".room-price").text("0");
		jQuery(".price-detail-value").text("0");
		//alert('The "Arrival" date cannot be after the "Departure" date');
	}

}).keyup();

jQuery("#dateto").change(function () {
	
	// Calculate length of stay
	days = dateDiff(jQuery("#datefrom").val(),jQuery(this).val());
	
	// Calculate new price based on price of room
	var roomprice = getPrice;
	
	// Calculate new price based on price of room and length of stay
	var newprice = days * roomprice;
	
	// Display new price
  	jQuery(".room-price").text(newprice);
	jQuery(".price-detail-value").text(days);
	
	if ( jQuery("#dateto").val() < jQuery("#datefrom").val() ) {
		jQuery("#dateto").effect("pulsate", { times:3 }, 250);
		jQuery(".room-price").text("0");
		jQuery(".price-detail-value").text("0");
		//alert('The "Departure" date cannot be before the "Arrival" date');
	}

}).keyup();