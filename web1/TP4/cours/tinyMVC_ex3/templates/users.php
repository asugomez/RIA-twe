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
//DEBOGAGE: interdire le premier utilisateur de la base
// 1) trouver son identifiant
$tousUsers = listerUtilisateurs();
$idPremier = $tousUsers[0]["id"];

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
$users = listerUtilisateurs();

// On récupère l'id du dernier utilisateur manipulé 
$idLastUser = valider("idLastUser"); 
// $idLastUser = $_GET["idLastUser"]; 
// provoquerait un message d'avertissement
// La fn valider utiliser if(isset()) pour éviter ce message  

// On préselectionne cet utilisateur dans le menu 
// $idLastUser contient l'id de l'user sélectionné ou false 

// préférer un appel à mkSelect("idUser",$users, ...)
foreach ($users as $dataUser)
{
	// On parcourt les users l'un apres l'autre
	// pour chacun, on stocke dans $dataUser ses méta-données 
	// L'id de l'utilisateur courant est dans $dataUser["id"]

/*
	if ($idLastUser == $dataUser["id"]) {
		echo "<option selected value=\"$dataUser[id]\">\n";
		// équivalent à 
		// echo "<option value=\"" . $dataUser["id"] ."\">\n";		
	} else {
		echo "<option value=\"$dataUser[id]\">\n";
	}
*/

	if ($idLastUser == $dataUser["id"]) $sel = "selected"; 
	else $sel =""; 

	echo "<option $sel value=\"$dataUser[id]\">\n";

	echo  $dataUser["pseudo"];
	echo "\n</option>\n"; 
}

// produit : 
/*
<select name="idUser">
<option value="3">
tom
</option>
<option value="6" selected>
isabelle
</option>
</select>
*/
?>
</select>

<input type="submit" name="action" value="Interdire" />
<input type="submit" name="action" value="Autoriser" />
</form>

<?php


	// dans une chaine encadrée par des guillemets 
	// php interprète les variables 
	// $var = "valeur"
	// $chaine1 = "valeur de \$var = $var"
	// $chaine1 vaut : "valeur de $var = valeur"

	// Lorsque la variable que l'on insère est une case d'un tableau associatif 
	// On peut ne pas mettre les guillemets autour du nom de la clé 

	// l'interprétation n'a pas lieu si la chaine est encadrée
	// par des apostrophes
	// $chaine2 = 'valeur de \$var = $var'
	// $chaine2 vaut : "valeur de \$var = $var"


$var = "valeur";
$chaine1 = "valeur de \$var = $var";
echo "<br>" . $chaine1; 
	// $chaine1 vaut : "valeur de $var = valeur"

	// l'interprétation n'a pas lieu si la chaine est encadrée
	// par des apostrophes
$chaine2 = 'valeur de \$var = $var';
echo "<br>" . $chaine2; 
	// $chaine2 vaut : "valeur de \$var = $var"


$tab = array("cle"=>"val2");
$chaine3 = "valeur de cle = $tab[cle]";
echo "<br>" . $chaine3; 
?>




