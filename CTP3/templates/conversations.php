<?php
// Ce fichier permet de tester les fonctions développées dans le fichier malibforms.php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "conversations.php")
{
	header("Location:../index.php?view=conversations");
	die("");
}

include_once("libs/modele.php"); // listes
include_once("libs/maLibUtils.php");// tprint
include_once("libs/maLibForms.php");// mkTable, mkLiens, mkSelect ...




?>

<h1>Conversations du site</h1>

<h2>Liste des conversations actives</h2>

<?php
$conversations = getConversations("actives");
//$conversations = listerConversations("actives");
//tprint($conversations);
// produit:
// <pre>
//appel à print_r($conversations)
//</pre>

mkTable($conversations); 
mkLiens($conversations, "theme", "id","index.php?view=chat","idConv" );

// Comment n'afficher que id & thèmes ?
// A remplacer par mkLiens
?>

<h2>Liste des conversations inactives</h2>

<?php
$conversations = getConversations("inactives");
mkTable($conversations); 
// A remplacer par mkLiens
mkLiens($conversations, "theme", "id","index.php?view=chat","idConv" );
?>

<hr />
<h2>Gestion des conversations</h2>

<?php

$conversations = getConversations(); // toutes
mkTable($conversations); // A remplacer par mkSelect

/*
<form action="controleur.php" method="get">

*/
mkForm("controleur.php");
//idLastConv vient du ficiheir controleur
mkSelect("idConv", $conversations, "id","theme", valider("idLastConv"), "active");

//echo "<input type=\"$type\" name=\"$name\" value=\"$value\"/>\n";
//mkInput("submit","action", "Creer");
mkInput("submit","action", "Archiver");
mkInput("submit","action", "Réactiver");
mkInput("submit","action", "Supprimer");
//il manque d'autres comme creer, etc

endForm();
?>















