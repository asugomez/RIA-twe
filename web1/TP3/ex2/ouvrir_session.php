<?php
session_start();
//nouvelle variable de session appelé 'pseudo' qui vaut 'asu'
/* avant
$_SESSION['pseudo']='asu';
header("Location:profil.php");
*/

/*apres (Question 5)
1. recuperer les données envoyées par connexion.php --> pseudo, passe
*/

//$pseudo = $_GET["pseudo"]; //PROBLÈME: ça risque de poser des problèmes si y en a pas de pseudo fourni
function valider($nom,$tab) {
	// Vérifier la présence d'une variable dans un tableau 
	// renvoyer sa valeur si elle existe
	// renvoyer false sinon 
	if (isset($tab[$nom]) && ($tab[$nom]!="")) { return $tab[$nom]; }
	else return false;  
}


$pseudo = valider("pseudo",$_GET); 
$passe = valider("passe",$_GET);

if ((!$pseudo) || (!$passe)) {
	// forme d'une chaine de requete : ?cle=valeur&cle2=valeur2...
	header("Location:connexion.php?msg=" .  urlencode("Pseudo & Passe ne doivent pas être vides => Vérifiez votre saisie !"));
	die("");
}

//levenshtein (string $str1, string $str2) : int

$lev = levenshtein($pseudo,$passe);
$pseudo_soundex = soundex($pseudo);
$passe_soundex = soundex($passe);


if (($lev <= 2) && ($pseudo_soundex == $passe_soundex)) {
	$_SESSION["pseudo"] = $pseudo;
	header("Location:profil.php");
	die("");
} else {
	header("Location:connexion.php?msg=" .  urlencode("Mot de passe incorrect !"));
	die("");
}

?>

<h1>HOLA</h1>
<!-- lien vers la page profil  -->

<!--
Une variable de session pseudo=tom vient d'être créée.

Un identifiant de session unique a été généré et envoyé au client (navigateur)
sous forme de cookie. Le nom du cookit PHPSESSID
-->

<!-- la cookie se trouve dans Headers > response headers > set-cookie

pour une nouvelle requete, les entetes de responses du serveur change (y a plus la cookie)
headers > request headers > cookie

le navigateur envoye la cookie au serveur
ce cookit est renvoyé quand on entre une autre fois à la page
le navgitaeur envoye la cookie

quand on supprime les cookies, le cookie d'id de session est supprimé aussi et la page profil ne peut plus accéder
à la variable de session pseudo car elle ne récupère plus l'id de session 


pour un navigateur privé, il va pas trouver de cookie
du coté serveur il reconnnais pas de cookie car il a pas trouvé de cookie ( y a pas de cookie affecté)

-->
Lev : <?=$lev?> <br />
S1 : <?=$pseudo_soundex?> <br />
S2 : <?=$passe_soundex?> <br />

<!--
<a href="profil.php"> Lien vers profil </a>

-->