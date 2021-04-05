    
    var i = 0;
    var jP = $("<p>").html("New paragraph ");

    var btnPlus = $("<input type='button'>").val("+").click(function(val){
        i+=1
        //console.log("ajouter");
        var jClone = jP.clone(true);
        jClone.append(i);
        //console.log(val.target.prev());
        

        lbl=  $(this).prev().val();
        if(lbl!=''){
            //$(this).prev().select(); --> pour selectionner
            jClone.html(lbl);

        }
        if(val.target.id=="haut"){
            //console.log("AQUIII");
            $("div#contenu").prepend(jClone);

        }else{
            $("div#contenu").append(jClone);
        }
        $(this).prev().val('');

    });

    function divBtnPlus(btn){
        divBtn = $("<div>").append("<input type='text' />").append(btn);
        return divBtn;
    }


    var jTa = $("<textarea>").keydown(function(contexte){
        //console.log(contexte.which);
        if(contexte.which == 13){
            var content = $(this).val();
            $(this).replaceWith(mkP(content));
        }

    });


    //cree un textarea a partir d'un paragraph
    //il prends des chaines de caracter comme parametres
    function mkTextarea(contenu){
        var jCTa=jTa.clone(true);
        //jCTa.html(refJP.html());
        jCTa.val(contenu).data("contenuInitial",contenu);
        return jCTa;
    }


    //make paragraph a partire d'un texte area
    function mkP(contenu){
        var jCP = jP.clone();
        //recup contenu --> val() pour le textarea
        jCP.html(contenu);
        return jCP;
    }
    
    
   
    //quand le document sera complètement chargé
    $( document ).ready(function() {
        var btn1= btnPlus.clone(true).attr('id','haut');
        var btn2= btnPlus.clone(true).attr('id','bas');

        $("#contenu").before(divBtnPlus(btn1));
        $("#contenu").after(divBtnPlus(btn2));


        $(document).on("click","#contenu p", function(){
            var content = $(this).html();
            $(this).replaceWith(mkTextarea(content));
        });

        $(document).on("keyup", function(contexte){
            //appui sur escape
            if(contexte.which == 27){
                //on veut annuler tous les textarea
                $("#contenu textarea").each(function(){
                    console.log("manipulation de "+ $(this).val());
                    
                    var lastContent = $(this).data("contenuInitial");
                    $(this).replaceWith(mkP(lastContent));
                });

            }
        });

        $(document).on("mouseover","textarea",function(){
            console.log($(this).data());
        });
        /*
        $(document).on("click","#contenu p", function(contexte){
            //console.log("click para");
            //console.log(contexte.target.innerHTML);
            $(this).replaceWith(function(){
                return '<textarea id='+contexte.target.id+" class="
                        +contexte.target.class
                        +'>'
                        +contexte.target.innerHTML
                        +"</textarea>"
            })
    
        });
        */

    
        
    });


   