
var refNomText = null;
var refImgAjax=null;
var refListNoms = null;




function init(){
    refNomText = document.getElementById("nom");
    refImgAjax = document.getElementById("imgLoad");
    refListNoms = document.getElementById("listNoms");
}

var cache = {
    currentSuggestions : []
}

function integrer(reponse){
    console.log("reponse: "+reponse);
    hide("listNoms");
    hide("imgLoad");

    oRep = JSON.parse(reponse);
    console.log(oRep);
    //TODO: parcourir l'objet reponse du serveur
    var i;
    var nextItem = "";

    refSuggestions.innerHTML = "";


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
    html("ulNom",reponse);
    show("ulNom","block");

}

function suggerer(refSaisie){
    //console.log("appel a suggerer");
    
    saisieVal = refSaisie.value;
    console.log(saisieVal);
    show("imgLoad","inline-block");
    //declencher une req
    ajax({ //data:, type:,
            url:"data.php",
            data:{"debutNom":val(refSaisie),"cle":"valeur"},
            callback:integrer

    });
    /*
    if(saisieVal!=""){
        show("imgLoad","inline-block");
        //declencher une req
        ajax({ //data:, type:,
                url:"data.php",
                data:{"debutNom":val(refSaisie),"critere":"prenom"},
                callback:integrer

        });
        //show("listNoms","block");
       
    } else{
        hide("imgLoad");
    }*/

}

function choisir(contexte){
    console.log("appel a choisir");
    //show("imgLoad","inline-block");
    console.log("cont: "+contexte)
    val("nom",html(contexte.target));
    //hide("imgLoad");
    hide("listNoms");
}


trace("Chargement script.js");