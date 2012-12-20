	/***** Node js *****/
	var socket;
	
	$.getScript("http://"+window.location.hostname+":3000/socket.io/socket.io.js",function(){
		// socket.io specific code
		socket = io.connect('http://'+window.location.hostname+':3000');

		socket.on('connect', function () {
		  console.log("Connect");
		});

		socket.on('done', function (process) {
		    console.log("Done "+process.cmd);
		    var data = $.parseJSON(process.stdout);
		    if( process.variable!='' ){
		    	eval(process.func+"("+process.variable+");");
		    }else{
		    	eval(process.func+"(data);");	
		    }
		});
	});
	