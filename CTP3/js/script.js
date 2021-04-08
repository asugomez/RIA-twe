
var apiRoot = "http://tomnab.fr/chat-api";

var hash = "0eb409153d4810da23b49ec436b3c2de"; 

var idUser = 37;
//var idArticle = 2218; 


function authenticate(cbNext) {
	$.ajax({
		type: "POST",
		url: apiRoot + "/authenticate",
		headers: {"debug-data":true},
		data: {"user":"asu","password":"postman"},
		success: function(oRep){
		console.log(oRep); 
		hash = oRep.hash; 
		cbNext(); 
	},
	dataType: "json"
	});
} 
