

var refCadreSuggest = null;
var refSaisie= null;
var refImgLoad= null;
var refSuggestions= null;

function init(){
    refCadreSuggest = document.getElementById("cadreSuggest");
    refSaisie = document.getElementById("saisie");
    refImgLoad = document.getElementById("imgLoad");
    refSuggestions = document.getElementById("suggestions");
}

function suggerer(){
    var contenu = refSaisie.value ; /** pour les champs formulaires, sinon c'est innerHtml */
    console.log("contenu: "+ contenu);
    if (contenu == ""){
        refSuggestions.style.display = "none";
        refImgLoad.style.display = "none";
    }
    else{
        refImgLoad.style.display = "block";
        //refSuggestions.style.display = "block";
        //declencher une requete ajax   
        /**
         * utiliser js/ajax.js
         * function envoie requete
         * js/ajax_refacto.js
         * fonction ajax
         */
        //sol 1 ex 1
        //envoiRequete('GET',"fixture.php","",integration);

        //sol 1 ex 2
        //envoiRequete('GET',"data.php","debutNom="+ contenu, integration);

        //sol2 ex1
        //ajax({url: "fixture.php", callback: integration});

        //sol2 ex2
        /*ajax({  url:"data.php",
                callback: integration,
                data: {debutNom:contenu, cle:"valeur"}
            });*/

        //sol2 ex3 JSON
        /*ajax({  url:"data_json.php",
                callback: integration,
                data: {debutNom:contenu, cle:"valeur"}
            });*/


            //sol2 ex3 SQL
        ajax({  url:"data_bdd.php",
        callback: integration,
        data: {debutNom:contenu, cle:"valeur"}
    });
        //window.setTimeout(integration,2000);
             
    }
}

function integration(reponse){

    oRep = JSON.parse(reponse);
    console.log(oRep);
    //TODO: parcourir l'objet reponse du serveur
    var i;
    var nextItem = "";

    refSuggestions.innerHTML = "";
    refSuggestions.style.display =  "none";

    refImgLoad.style.display="none";

    if(oRep.etudiants.length == 0) return;

    for(i=0; i<oRep.etudiants.length;i++){
        nextItem = "<li>";
        //afficher le nom p.Nom
        nextItem += oRep.etudiants[i].prenom.substr(0,1) + ". ";
        nextItem += oRep.etudiants[i].nom.substr(0,1).toUpperCase();
        nextItem += oRep.etudiants[i].nom.substr(1).toLowerCase();

        nextItem += "</li>";

        console.log(nextItem);
        
        refSuggestions.innerHTML += nextItem;
    }
    refSuggestions.style.display="block";
}

function choisir(contexte){
    //console.log("click");
    var refItemClique = contexte.target;
    console.log("click sur :" + refItemClique.innerHTML);

    refSaisie.value = refItemClique.innerHTML;

    refSuggestions.style.display="none";

    refImgLoad.style.display="none";

}

function annuler(contexte){
    //console.log(contexte.keyCode);
    //console.log(contexte.key);
    // Number 27 is the "Enter" key on the keyboard
    if (contexte.key === 'Escape')  {
        refSaisie.value="";

        refImgLoad.style.display = "none";

        refSuggestions.style.display="none";
	}

}



function stocker(){
    refFormulaire.addEventListener("submit", envoiRequete());
}