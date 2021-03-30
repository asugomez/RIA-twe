<?php
// Ce fichier permet de tester les fonctions développées dans le fichier malibforms.php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "projets.php")
{
    header("Location:../index.php?view=projets");
    die("");
}

include_once("libs/modele.php"); // listes
include_once("libs/maLibUtils.php");// tprint
include_once("libs/maLibForms.php");// mkTable, mkLiens, mkSelect ...



?>

<!-- Cette page affiche la liste des projets sous forme de liens  -->
<h1>Projets</h1>

<h2>Liste des projets en cours</h2>


<?php
//inspirée du TP5
$projets = listerProjets('');

//echo count($projets);
//mkTable($projets); 
// A remplacer par mkLiens
mkLiens($projets, "nomProjet", "idProjet","index.php?view=contributions","idProjet" );

echo '</br>';
//echo '<a href="index.php?view=contributions">Contributions</a>';


?>



