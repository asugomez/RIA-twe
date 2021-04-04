
var refNomText = null;
var refImgAjax=null;
var refListNoms = null;




function init(){
    refNomText = document.getElementById("nom");
    refImgAjax = document.getElementById("imgLoad");
    refListNoms = document.getElementById("listNoms");
}

function integrer(reponse){
    console.log("reponse: "+reponse);
    html("ulNom",reponse);
    show("listNoms","block");
    hide("imgLoad");

}

function suggerer(refSaisie){
    //console.log("appel a suggerer");
    
    saisieVal = refSaisie.value;
    console.log(saisieVal);
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
    }

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