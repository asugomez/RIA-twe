function trace(s) {
	window.console && console.log(s);
}

function debug(s) {
	// affiche un nombre de messages limité par un compteur
	// affiche le compteur si s n'est pas fourni
	// e.g. après 10 affichages, la fonction ne fait plus rien 
	// comment remettre à 0 le compteur ?   
}

function show(refOrId,display) {
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

trace("Chargement lib utils : debug, html, val, ...");