
function boucle(iPeriode,fnCbTraitement,fnCbContinuer) {
	console.log("appel à boucle");
	// rendre le 3ème argument optionnel
	var boucle_interne = function() {
		console.log("appel à boucle interne");
		// iPeriode,fnCbTraitement,fnCbContinuer
		// sont dans le scope de la fonction

		// SI (fnCbContinuer() renvoie VRAI)	
		if ((fnCbContinuer==undefined) || fnCbContinuer()) {
			// 	executer fnCbTraitement()
			fnCbTraitement();

			// Preparer la prochaine itération dans 3s...  
			window.setTimeout(boucle_interne, iPeriode*1000);
		}
	}
	boucle_interne(); 
	
}

// TDD : Test-Driven-Development 

function traiter() {
	console.log("appel à traiter"); 
}

var compteur=0; 
function poursuivre() {
	compteur++; 
	console.log("appel à poursuivre, compteur = " + compteur); 
	if (compteur > 5 ) return false; 
	else return true; 
}

var oDefault = {
	periode: 5, 
	fnTraitement: function(){
		console.log("appel à traiter"); 
	},
	fnPoursuite : function() {
		return true;
	}
};

function boucleV2(oConfig) {

	var oParams = enrichir(oDefault, oConfig);
	// renvoie un nouvel objet 
	// qui contienne toutes les propriétés de oDefault
	// avec pour valeurs celles dans oConfig
	// si elles sont présentes, 
	// dans oDefault sinon 

	var boucle_interne = function() {
		
		if (oParams.fnPoursuite()) {
			// 	executer fnCbTraitement()
			oParams.fnTraitement();

			// Preparer la prochaine itération dans 3s...  
			window.setTimeout(boucle_interne, oParams.periode*1000);
		}
	}
	boucle_interne(); 
}



boucleV2({	});

//clonage sueprficiel
function enrichir(oDefault, oConfig) {
	// renvoie un nouvel objet 
	// qui contienne toutes les propriétés de oDefault
	// avec pour valeurs celles dans oConfig
	// si elles sont présentes, 
	// dans oDefault sinon 

	// Attention : on reste sur un clonage superficiel !!

	var aux = {};
	
	for (param in  oDefault) {
		// param prendra pour valeurs successivement 
		// "periode", "fnCbTraitement" puis "fnPoursuite"
		if (oConfig[param] == undefined) {
			aux[param] = oDefault[param]; 
		} else aux[param] = oConfig[param]; 
	}

	return aux; 
}

//boucle(3,traiter,poursuivre);

trace("Chargement lib boucle ..");