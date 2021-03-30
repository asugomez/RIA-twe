<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "users.php")
{
	header("Location:../index.php?view=users");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php"); // tprint

?>

<h1>Administration du site</h1>

<h2>Liste des utilisateurs de la base </h2>

<?php

/*
// DEBOGAGE : interdire le premier utilisateur de la base 
// 1) trouver son identifiant

$tousUsers = listerUtilisateurs(); 
$idPremier = $tousUsers[0]["id"]; 

// 2) interdireUtilisateur($id)
interdireUtilisateur($idPremier); 
*/

echo "liste des utilisateurs autorises de la base :"; 
$users = listerUtilisateurs("nbl");
tprint($users);	// préférer un appel à mkTable($users);


echo "<hr />";
echo "liste des utilisateurs non autorises de la base :"; 
$users = listerUtilisateurs("bl");
tprint($users);	// préférer un appel à mkTable($users);

?>
<hr />
<h2>Changement de statut des utilisateurs</h2>

<form action="controleur.php">

<select name="idUser">
<?php
/*
Considérons le formulaire présent dans la page users.php
1. A quelle page sont envoyés les données du formulaire ?
=> "controleur.php"

2. Quelles données sont envoyées ?
=> idUser, action 
Pourquoi y-a-t-il deux boutons submit ?
=> permet d'utiliser le même menu déroulant pour réaliser deux opérations différentes

3. Compléter les labels du menu déroulant pour y afficher les statuts des utilisateurs ('bl' ou 'nbl') en plus de leurs noms.
*/

// 1) recuperer cette information
$idLastUser = valider("idLastUser"); // equivalent a
//$idLastUser = $_GET["idLastUser"]; et bien plus

$users = listerUtilisateurs();
// tableau de tableaux associatifs

// préférer un appel à mkSelect("idUser",$users, ...)
foreach ($users as $dataUser)
{
	//2) preselectionner le bon user
	if("idLastUser" == $dataUser["id"]) $TOSELECT = "selected";
	else $TOSELECT = "";


	// $dataUser contient les méta-données de l'utilisateur courant 
	echo "<option $TOSELECT value=\"$dataUser[id]\">\n";
	echo  $dataUser["pseudo"];
	if ($dataUser["blacklist"] == 1) echo " (bl)"; 
	else echo " (nbl)";

	echo ($dataUser["blacklist"] == 1) ? " (bl)" : " (nbl)"; 
	echo "\n</option>\n"; 
}
?>
</select>

<input type="submit" name="action" value="Interdire" />
<input type="submit" name="action" value="Autoriser" />
</form>






