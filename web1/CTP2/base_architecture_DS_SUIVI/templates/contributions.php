<?php
// Ce fichier permet de tester les fonctions développées dans le fichier malibforms.php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=contributions&" . $_SERVER["QUERY_STRING"]);

	die("");
}

include_once("libs/modele.php"); // listes
include_once("libs/maLibUtils.php");// tprint
include_once("libs/maLibForms.php");// mkTable, mkLiens, mkSelect ...



?>

<h1>Saisie d'un contribution : </h1>

<?php
/*
La liste détaillée des contributions déjà faites par cet utilisateur sur ce projet
Un formulaire permettant :
de choisir une étape du projet
de saisir l’url de la contribution
de valider la saisie de cette contribution
*/

$idProjet = getValue("idProjet");
if (!$idProjet)
{
	// pas d'identifiant ! On redirige vers la page de choix de la conversation

	// NB : pose quelques soucis car on a déjà envoyé la bannière... 
	// Il y a opportunité d'écrire cette bannière plus tard si on la place en absolu
	header("Location:index.php?view=projets"); 
	die("idProjet manquant");
}

// On récupère les paramètres des projet
$dataProjet = getInfosProjet($idProjet); 
if (!$dataProjet)
{
	// Le projet n'existe pas ! 
	header("Location:index.php?view=conversations");
	die("Le projet n'existe pas ");
}

// Afficher le nomProjet du projet courant
// tprint($dataConv);
echo "<h2>$dataProjet[nomProjet]</h2>";


// Les etapes
//function listerEtapes($idProjet,$idUser,$option="toutes")
//echo $dataProjet['idResponsable'];
$contributions = listeContributions($idProjet, $dataProjet['idResponsable']);

echo count($contributions);

foreach ($contributions as $nextCont) {
	//echo '<div style="color:' . $nextEtap["couleur"] . '">'; 
    echo "<div>";
	echo "[" . $nextCont["idProjet"] . "] "; 
	echo $nextCont["idEtape"];
    echo $nextCont["urlContribution"];
	echo "</div>";
}
/*
Remarques :
La date de la contribution doit être sauvegardée en  base de données. 
NB : En php :
l’appel à la fonction date('Y-m-d') permet de générer la date qui sera insérée dans la base de données;
L’appel à la fonction strtotime(chaineDate) permet de transformer une date récupérée en base de données en type time, et donc de pouvoir comparer des dates

La contribution est associée à l’utilisateur connecté.
Seules les étapes pour lesquelles l’utilisateur n’a pas encore saisi de contribution sont disponibles dans le sélecteur d’étapes du formulaire.
Les contributions qui ont été faites après la date limite de l’étape doivent apparaître en rouge dans la liste.

*/

if (valider("connecte","SESSION")) {
    mkForm("controleur.php");
    $etapes = listerEtapes($idProjet, $dataProjet['idResponsable']);

    $idLastUser = valider("idLastUser");
    // préférer un appel à mkSelect("idUser",$users, ...)
    mkSelect("idEtape", $etapes, "idEtape","descriptionEtape" );

    //echo "<input type=\"$type\" name=\"$name\" value=\"$value\"/>\n";
    //mkInput("submit","action", "Creer");
    mkInput("submit","action", "Choisir Etape");
    mkInput("submit","action", "URL");
    mkInput("submit","action", "Valider");
    //il manque d'autres comme creer, etc

    endForm();
}
?>
