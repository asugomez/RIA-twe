    //quand le document sera complètement chargé
    $( document ).ready(function() {
        console.log( "document loaded" );
    });


    $("input.btnAfficherCacher").click(function(val){
        //$ est une alias pour une fonction qui s'appelle jQuery
        //jQuery(selecteurCSSEtendu, [context])
        //renvoie un objet jQuery représentant une ensemble de balises HTML
        //on manipule un ensemble d'élements 

        console.log(val.target.value);
        

        if(val.target.value=="Afficher"){
            console.log("aqui");
            $("div#contenu").addClass("allume").show("slow"); //on ajoute la class "allume" à l'ensemble d'élements p qui ont la class "exemple"
            //console.log($("#contenu").addClass("allume").show("slow"));
            $("input.btnAfficherCacher").attr('value', 'Cacher');
        }else{


            $("div#contenu").removeClass("allume").hide("slow"); 

            $("input.btnAfficherCacher").attr('value', 'Afficher');
        }
        /**
         *  SI on ne peut pas utiliser "this", on le fait de cette manière
         * $("input[value='Cacher']").length){} --> donc s'il existe cet élement ------>
         */
        
    });
    

    var i=5;
    $("input.btnPlusMoins").click(function(val){

        // pour ajouter un élement dans une position en particulier --> on pourrait utiliser next()
        // on peut aussi récupérer le numéro de l'élement  (.index)
        //console.log(val.target.value);
        var txt = "<p> New paragraphe ";
        txt+= i;
        txt+=" </p>";
        i+=1
        if(val.target.value=="+"){
            console.log("ajouter");
            if(val.target.id=="btnPlusMoinsHaut"){
                console.log("AQUIII");
                $("div#contenu").prepend(txt);

            }else{
                $("div#contenu").append(txt);
            }
            //$("input.btnPlusMoins").attr('value','-');

        }else{
            if(val.target.id=="btnPlusMoinsHaut"){
                $("div#contenu").prepend(txt);

            }else{
                $("div#contenu").append(txt);
            }
            $("input.btnPlusMoins").attr('value','+');
        }

    });