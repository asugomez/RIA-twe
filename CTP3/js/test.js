

$(document).ready(function(){
	authenticate(getUsers);
	//authenticate(getArticles);
	//authenticate(postArticle);
	//postArticle();  
	//putArticle(11,"T3");
	//deleteArticle(2182,hash);
	//getParagraphes();
});

function getParagraphes(){
	$.ajax({
		type: "GET",
		url: apiRoot + "/articles/" + idArticle+"/paragraphes",
		headers: {"hash":hash},
		success: function(oRep){
		console.log(oRep);

		},
		dataType: "json"
	});
}

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

function getUsers(){

	$.ajax({
		type: "GET",
		url: apiRoot + "/users",
		headers: {"hash":hash,"debug-data":true},
		data: {},
		success: function(oRep){
		console.log(oRep);

		},
		dataType: "json"
	});
}

function getArticles(){
	$.ajax({
		type: "GET",
		url: apiRoot + "/articles",
		headers: {"hash":hash,"debug-data":true},
		success: function(oRep){
			console.log(oRep);
			var idFirst = oRep.articles[0].id; 
		},
		dataType: "json"
	});
}

function postArticle(){
	$.ajax({
		type: "POST",
		url: apiRoot + "/articles",
		headers: {"hash":hash,"debug-data":true},
		data: {"titre":"Titre article"},
		success: function(oRep){
		console.log(oRep);	
		putArticle(oRep.article.id,"Titre article modifié");	
	},
	dataType: "json"
	});
}

function putArticle(id,titre){
	// NB : l'envoi de données par la méthode PUT
	// ne fonctionne pas avec la propriété .data()
	// il faut envoyer les données en QS après l'URL
	$.ajax({
		type: "PUT",
		url: apiRoot + "/articles/" + id + "?titre=" + titre,		
		headers: {"hash":hash,"debug-data":true},
		success: function(oRep){
		console.log(oRep);			
	},
	dataType: "json"
	});
}

function deleteArticle(id,titre){
	// NB : l'envoi de données par la méthode PUT
	// ne fonctionne pas avec la propriété .data()
	// il faut envoyer les données en QS après l'URL
	$.ajax({
		type: "DELETE",
		url: apiRoot + "/articles/" + id,		
		headers: {"hash":hash,"debug-data":true},
		success: function(oRep){
		console.log(oRep);			
	},
	dataType: "json"
	});
}
