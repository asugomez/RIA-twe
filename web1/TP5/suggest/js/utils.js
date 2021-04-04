function trace(s) {
	window.console && console.log(s);
}

function mkDebug() {
	var compteur_interne=0; 
	var max_compteur_interne=5; 
	var fn = function(s) {

		if (s == undefined) {
			trace("compteur vaut " + compteur_interne);
			return; 
		}
	
		if (s == "reset") {
			compteur_interne = 0; 
			return; 
		}

		if (compteur_interne++<max_compteur_interne) {
			trace(s);
		}
	};

	return fn;  
}


function mkObjetDebug(max_compteur) {
	var compteur_interne=0; 
	if (max_compteur == undefined) 
		max_compteur = 5; 

	var max_compteur_interne=max_compteur; 

	var fnDebug = function(s) {
		if (compteur_interne++<max_compteur_interne) {
			trace(s);
		}
	};

	var fnReset = function() {
		compteur_interne=0;
	};

	// On renvoie un objet qui contient les 3 méthodes 
	return {
		"debug" : fnDebug, 
		"reset" : fnReset, 
		"getCompteur" : function() {
			return compteur_interne; 
		},
		"setMax" : function(m) {
			max_compteur_interne=m;
		}
	};  
} 


var __utils_compteur = 0; 
var __utils_max_compteur = 5; 
function debug(s) {
	// affiche un nombre de messages limité par un compteur
	// affiche le compteur si s n'est pas fourni
	// e.g. après 10 affichages, la fonction ne fait plus rien 
	// comment remettre à 0 le compteur ?  
	if (s == undefined) {
		trace("compteur vaut " + __utils_compteur);
		return; 
	}

	// Il faut pouvoir se souvenir de la valeur du compteur
	// entre deux appels de la fonction debug 
	// => besoin var globale 

	if (__utils_compteur++<__utils_max_compteur) {
		// écrire compteur++ <=> POST incrémentation 
		// l'incrémentation est réalisée après le test 
		trace(s);
	} 
}

function show(refOrId,display) {
	console.log("appel show");
	// affiche l'élément dont la référence ou l'id est fourni
	// le paramètre display doit valoir block par défaut
	if(typeof refOrId == "undefined"){
		return;
	}

	if(display == "undefined"){
		display="block";
	}

	if(typeof refOrId == "string"){
		element = document.getElementById(refOrId);
		element.style.display=display;
	}
	if(typeof refOrId == "object"){
		refOrId.style.display=display;
	}
	else{
		return;
	}
}

function hide(refOrId) {
	// cache l'élément dont la référence ou l'id est fourni
	if(typeof refOrId == "undefined"){
		return;
	}
	else if(typeof refOrId == "string"){
		element = document.getElementById(refOrId);
		element.style.display="none";
	}
	else if(typeof refOrId == "object"){
		refOrId.style.display="none";
	}
	else{
		return;
	}
	
}

function html(refOrId, val) {
	// affecte une valeur à l'élément dont la référence ou l'id est fourni; si val n'est pas fourni, on renvoie son contenu
	if(val==undefined || (typeof refOrId == "undefined")){
		return refOrId.innerHTML;
	}

	if(typeof refOrId == "string"){
		refOrId = document.getElementById(refOrId);
	
	}
	refOrId.innerHTML = val;
}

function val(refOrId, val) {
	// affecte une valeur à l'élément dont la référence ou l'id est fourni; si val n'est pas fourni, on renvoie son contenu
	// l'élément est un champ de formulaire

	if(val==undefined ||(typeof refOrId == "undefined")){
		return refOrId.value;
	}
	else if(typeof refOrId == "string"){
		refOrId= document.getElementById(refOrId);
	}
	refOrId.value=val;
}

trace("Chargement lib utils : debug, html, val, ..");