
/**
 * variables
 */

 var refChampEntree = null;

 var refButMenu = null;
 var refTitre1 = null;
 var refTitre2 = null;
 var refParagraphe = null;
 var refImage = null;
 
 var refMenuID =null;
 
 var refEdition = null;
 /**
  * functions
  */
 
 function init(){
     refChampEntree = document.getElementById("champ-entree");
     refButMenu = document.getElementById("button-menu");
     //console.log(refButMenu.innerHTML);
     console.log(refChampEntree);
     refMenuID = document.getElementById("menuID");
 
 
     refTitre1 = document.getElementById("titre1");
     //console.log(refTitre1.innerHTML);
     
     refTitre2 = document.getElementById("titre2");
     refParagraphe = document.getElementById("paragraph");
     refImage = document.getElementById("image");
 
 
     refEdition = document.getElementById("edition");
     //console.log(refEdition.innerHTML);
 
 }