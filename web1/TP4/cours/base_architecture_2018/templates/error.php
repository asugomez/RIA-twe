<?php


 if (basename($_SERVER["PHP_SELF"]) != "index.php")
 {
     header("Location:../index.php?view=accueil");
     die("");
 }

?>


<div id="corps">

    <h1> Oups </h1>
    Une erreur s'est produite, la vue selectionnee n'existe pas!
    <a href= "index.php?view=accueil"> Retour à la page d'accueil </a>
    <!--
    One peut aussi mettre      href="?view=accueil"> 
    -->

</div>