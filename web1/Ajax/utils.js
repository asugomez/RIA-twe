
function trace(s) {
	window.console && console.log(s);
	// vérifie l'existence de l'objet window.console
	// S'il existe, on appelle console.log(s)
}

// MERDIQUE ! 
// Variables globales sont à proscrire 
// Nimporte qui peut changer le compteur et donc le comportement de notre fonction 
// sans en avoir conscience 
var __utils_compteur = 0; 
var __utils_max_compteur = 5; 

// => Mise en place d'une solution permettant 
// de déclarer des variables "privées" (non globales) 
// ET pérennes (qui ne disparaissent pas après l'exécution de la fonction) 

// => EN JS, on utilise des "fermetures" aka "closures" 
// EN JS, lors de la création d'une fonction, 
// le navigateur "enferme" dans le scope de la fonction 
// toutes les variables visibles depuis l'endroit où la fonction est créée
// Tant qu'il existera une référence vers cette fonction 
// son scope sera maintenu par le navigateur 


function mkDebug() {
	var compteur_interne=0; 
	var max_compteur_interne=5; 
	// les fonctions sont des objets comme les autres en js
	// on peut en créer et les affecter à des variables
	// on peut les faire renvoyer par des fonctions 
	// on peut les passer en paramètre de fonctions (en appelle cela des 'callback')
	// ou "fonction de rappel"
	// Cf. setTimeout(FN, DUREE)
	var fn = function(s) {
		// lors de la création de cette fonction, 
		// On a accès :  
		// aux variables globales du script 
		// à ses propres variables locales (par exemple s) 
		// ET à la variable locale de mkDebug qui s'appelle compteur_interne
		// Le scope de cette fonction contient une référence vers compteur_interne
		// MEME APRES la fin de l'exécution de la fonction mkDebug()

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

function debug(s) {
/*
	if (!s) {
		trace("1compteur vaut " + compteur);
	}

	if (s == undefined) {
		trace("2compteur vaut " + compteur);
	}

	if (s == null) {
		trace("3compteur vaut " + compteur);
	}

	if (typeof s == "undefined") {
		trace("4compteur vaut " + compteur); 
	}
*/

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

	// affiche un nombre de messages limité par un compteur
	// affiche le compteur si s n'est pas fourni
	// e.g. après 10 affichages, la fonction ne fait plus rien 
	// comment remettre à 0 le compteur ?   
	// => écrire compteur = 0 n'importe où ! 
}

/*

Supposons qu'une balise <div id="toto">
soit présente dans la structure 

hide("toto") doit la cacher (display none)
show("toto") doit la réafficher (display block)
show("toto","inline") doit la mettre en display inline
html("toto") renvoie le contenu de toto 
html("toto","valeur") change le contenu de toto pour y placer "valeur" 

var refSurDiv = document.getElementById("toto")
hide, show, html(refSurDiv) doivent encore fonctionner
si on passe en paramètre une référence et plus un "id" 

*/

function show(refOrId,display) {
	// affiche l'élément dont la référence ou l'id est fourni
	// le paramètre display doit valoir block par défaut

	if (typeof refOrId == "string") {
		refOrId = document.getElementById(refOrId);
	}

	if (display == undefined) 
		display = "block";

	refOrId.style.display = display;
}

function hide(refOrId) {
	// cache l'élément dont la référence ou l'id est fourni
	
	if (typeof refOrId == "string") {
		refOrId = document.getElementById(refOrId);
	}
	refOrId.style.display = "none";
}

function html(refOrId, val) {
	// affecte une valeur à l'élément dont la référence ou l'id est fourni; si val n'est pas fourni, on renvoie son contenu

	if (typeof refOrId == "string") {
		refOrId = document.getElementById(refOrId);
	}

	if (val == undefined) return refOrId.innerHTML; 
	else refOrId.innerHTML = val; 
}

function val(refOrId, val) {
	// affecte une valeur à l'élément dont la référence ou l'id est fourni; si val n'est pas fourni, on renvoie son contenu
	// l'élément est un champ de formulaire

	if (typeof refOrId == "string") {
		refOrId = document.getElementById(refOrId);
	}

	if (val == undefined) return refOrId.value; 
	else refOrId.value = val; 
	
}

trace("Chargement lib utils : debug, html, val, ...");


