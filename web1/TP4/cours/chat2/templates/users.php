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
$users = listerUtilisateurs("nbl");
tprint($users);	// préférer un appel à mkTable($users);

echo $users[0]["pseudo"];

foreach($users as $nextUser) {
	echo "<li> $nextUser[pseudo] </li> ";
	echo "<ul>"; 
	foreach ($nextUser as $nomChamp=>$valeurChamp) {
		echo "<li> $nomChamp vaut $valeurChamp </li> ";
	}
	echo "</ul>";
}
echo "<ol>"; 
for($i=0;$i<count($users);$i++) {
	echo "<li>" .  $users[$i]["pseudo"] . "</li> ";
}
echo "</ol>"; 

/*
$users contient un tableau de tableaux associatifs : 
Array
(
    [0] => Array
        (
            [id] => 3
            [pseudo] => tom
            [blacklist] => 1
            [couleur] => orange
        )

    [1] => Array
        (
            [id] => 6
            [pseudo] => user1
            [blacklist] => 1
            [couleur] => green
        )

)

*/

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

// préférer un appel à mkSelect("idUser",$users, ...)
foreach ($users as $dataUser)
{
	echo "<option value=\"$dataUser[id]\">\n";
	echo  $dataUser["pseudo"];
	echo "\n</option>\n"; 
}
?>
</select>

<input type="submit" name="action" value="Interdire" />
<input type="submit" name="action" value="Autoriser" />
</form>






