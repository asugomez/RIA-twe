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

echo "liste des utilisateurs autorises de la base :"; 
$users = listerUtilisateurs("nbl");// ((nbl = non blakliste))
tprint($users);	// préférer un appel à mkTable($users);

echo $users[0]["pseudo"];

foreach($users as $nextUser){
	//echo $nextUser["pseudo"];
	echo "<li> $nextUser[pseudo] </li>";
	
	echo "<ul>";
	foreach($nextUser as $nomChamp => $valeurChamp){
		echo "<li> $nomChamp vaut $valeurChamp </li>";

	}
	echo "</ul>";
}

echo "<ol>"; //liste numerotee
for($i=0; $i<count($users); $i++){
	echo "<li>" . $users[$i]["pseudo"] . "</li>";
}
echo "</ol>";




echo "<hr />";
echo "liste des utilisateurs non autorises de la base :"; 
$users = listerUtilisateurs("bl"); // blackliste
tprint($users);	// préférer un appel à mkTable($users);

?>
<hr />
<h2>Changement de statut des utilisateurs</h2>

<form action="controleur.php">

<select name="idUser">
<?php
$users = listerUtilisateurs();

$idLastUser = valider("idLastUser");
// préférer un appel à mkSelect("idUser",$users, ...)

foreach ($users as $dataUser)
{

	if ($idLastUser == $dataUser["id"]) $sel = "selected"; 
	else $sel =""; 
	//pour que il soit affiché dans le menu deroulant le nom de l'utilisteur
	echo "<option $sel value=\"$dataUser[id]\">\n";
	echo  $dataUser["pseudo"];
	echo "\n</option>\n"; 
}
?>
</select>

<input type="submit" name="action" value="Interdire" />
<input type="submit" name="action" value="Autoriser" />
</form>






