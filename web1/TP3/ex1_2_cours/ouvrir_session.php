<?php

if($_GET["login"]!="" and $_GET["passe"]!=""){

    session_start(); /* response header -->  "Set-cookie" */
    /* Puis, la cookie reste sur "request headers" as cookie */
    $_SESSION["pseudo"] =  $_GET["login"];
    $_SESSION["mdp"] = $_GET["passe"];
    header("Location:profil.php?msg=" . urlencode("Vous avez saisi : ($login,$passe)"));	
    /* redirection vers la page profil.php */

    die();
}
else{
    /* a faire!! */
    echo "<h3>";
    echo "Pseudo & Passe ne doivent pas être vides => Vérifiez votre saisie !";
    echo "</h3>";
    header("Location:connexion.php");

}



?>

<!-- comment affiche un link ver profil.php? -->

<a href="profil.php"> Accèss à une autre page hihi </a>  