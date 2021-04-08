
var apiRoot = "http://tomnab.fr/paragraphes-api";

var hash = "7a45f4d78a9f823bcf513b5f847128fe"; 

var idArticle = 2218; 

var i = 0;
var jP = $("<p>").html("New paragraph ")
            .data({
                id: 0,
                ordre: 0,
                disabled : true,
                contenu: "New paragraph"
});

var btnPlus = $("<input type='button'>").val("+").click(function(val){
    i+=1
    //console.log("ajouter");
    var jClone = jP.clone(true).addClass("disabled"); //on lcone le P. et ses méta-données
    jClone.append(i);
    //console.log(val.target.prev());
    
    lbl=  $(this).prev().val();
    if(lbl!=''){
        //$(this).prev().select(); --> pour selectionner
        jClone.html(lbl);
        jClone.data("contenu",lbl);

    }

    //on prévoit que le paragraphe ne doit pas être éditable immédiatement
    // => cf. modele de P. (jP)

    //haut
    if(val.target.id=="haut"){
        //console.log("AQUIII");
        $("div#contenu").prepend(jClone);

    }else{
        $("div#contenu").append(jClone);
    }
    $(this).prev().val('');

    /**
     * 1) envoyer une requete au serveur pour creer un nouveau paragraphe
     * 2) lorsque la reponse est reçue, attribuer l'id du P. créé côté serveur
     *          au P. correspondant côté client 
     * 3) un P. qui n'aurait pas d'identifiant sera grisé et 
     *          ne sera pas éditable 
     *  => on prévoit un champ "disabled" dans les méta-données
     */

    //tomnab.fr/paragraphes-api/articles/9/paragraphes?contenu=test
    $.ajax({
		type: "POST",
		url: apiRoot + "/articles/" + idArticle + "/paragraphes",
		headers: {"hash":hash},
		data: {"contenu": jClone.html()},
		success: function(oRep){
            console.log(oRep.paragraphe);
            //putArticle(oRep.article.id,"Titre article modifié");	
            //reçu: {"version":1.3,"success":true,"status":200,"paragraphes":[{"id":"6419","contenu":"kodasasf","ordre":"0"},{"id":"6425","contenu":"New paragraph 2","ordre":"0"},{"id":"6426","contenu":"New paragraph 3","ordre":"0"},{"id":"6427","contenu":"New paragraph 4","ordre":"0"},{"id":"6428","contenu":"New paragraph 5","ordre":"0"}]}
            jClone.removeClass("disabled");
            jClone.data("id",oRep.paragraphe.id);
            jClone.data("disabled",false);
        },
	dataType: "json"
	});

});

function divBtnPlus(btn){
    divBtn = $("<div>").append("<input type='text' />").append(btn);
    return divBtn;
}


var jTa = $("<textarea>").keydown(function(contexte){
    //console.log(contexte.which);
    if(contexte.which == 13){

        //il faut mettre à jour les meta-données
        var content = $(this).val(); //modifie
        var meta=$(this).data(); //il faut mettre à jour le contenu
        meta.contenu = content;

        $(this).replaceWith(mkP(content,meta));

        //envoyer une requete ajax pour la mise à jour!
        //tomnab.fr/paragraphes-api/articles/9/paragraphes/7?contenu=Test2
        $.ajax({
            type: "PUT",
            url: apiRoot + "/articles/" + idArticle
                        + "/paragraphes/" + meta.id
                        + "?contenu="+ content, //"?titre=" + titre,		
            headers: {"hash":hash},
            success: function(oRep){
                console.log(oRep);			
            },
        dataType: "json"
        });
    
    }

});

//metadonnées --> avec la methode data


//cree un textarea a partir d'un paragraph
//il prends des chaines de caracter comme parametres
function mkTextarea(contenu,meta){
    var jCTa=jTa.clone(true);
    //jCTa.html(refJP.html());
    //recup contenu --> val() pour le textarea
    //le second parametre contient le contenu initial
    // + ordre, +id
    jCTa.val(contenu).data(meta);
    return jCTa;
}


//make paragraph a partire d'un texte area
function mkP(contenu,meta){
    var jCP = jP.clone();
    jCP.html(contenu).data(meta); //on ajoute des méta-données
    return jCP;
}

function getParagraphesAndInsertIntoContenu(){


    
    //sol 1 --> la plus general (pour le .get, .post, .put,etc)
	$.ajax({
		type: "GET",
		url: apiRoot + "/articles/" + idArticle+"/paragraphes",
		headers: {"hash":hash},
		success: function(oRep){ //oRep reponse du serveur envoyé en json --> pour 
            //cette raison y a dataType: json
		    console.log(oRep);
            //il faut enregistrer pour chaque parag. ses méta-données
            //on parcourt les paragraphes
            var meta;
            
            for(i=0;i<oRep.paragraphes.length;i++){
                meta = oRep.paragraphes[i];
                meta.disabled =false;

                $("#contenu").append(mkP(oRep.paragraphes[i].contenu, 
                                meta));
            }

		},
		dataType: "json" 
	});
    

    //sol2  --> neanmoins il n'existe pas une fonction .put, etc 
    /*
    $.get(apiRoot + "/articles/" + idArticle+"/paragraphes",
        {"hash":hash},
        function(reponse){
            console.log(reponse);
            var oRep= JSON.parse(reponse);
            console.log(oRep);
        });
        */

    //sol3
    /*
    $.getJSON(apiRoot + "/articles/" + idArticle+"/paragraphes",
        {"hash":hash},
        function(reponse){
            console.log(oRep);
            console.log(oRep);
        });
        */

}

//quand le document sera complètement chargé
$( document ).ready(function() {
    var btn1= btnPlus.clone(true).attr('id','haut');
    var btn2= btnPlus.clone(true).attr('id','bas');

    $("#contenu").before(divBtnPlus(btn1));
    $("#contenu").after(divBtnPlus(btn2));

    getParagraphesAndInsertIntoContenu();


    $(document).on("click","#contenu p", function(){
        var content = $(this).html();
        var meta=$(this).data();
        if(meta.disabled) return;
        $(this).replaceWith(mkTextarea(content,meta));
    });

    $(document).on("keyup", function(contexte){
        //appui sur escape
        if(contexte.which == 27){
            //on veut annuler tous les textarea
            $("#contenu textarea").each(function(){
                console.log("manipulation de "+ $(this).val());
                
                var lastContent = $(this).data("contenu");
                var meta = $(this).data();

                $(this).replaceWith(mkP(lastContent,meta));
            });

        }
    });

    //lors du survol d'un textarea ou un p dans le #contenu
    $(document).on("mouseover","#contenu *",function(){
        console.log($(this).data());
    });
    
});


