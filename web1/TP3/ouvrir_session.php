<?php
session_start(); 

// récupérer les données envoyée par connexion.php 
// pseudo, passe 

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


// levenshtein ( string $str1 , string $str2 ) : int
$lev = levenshtein($pseudo, $passe); 
$pseudo_soundex = soundex ($pseudo) ;
$passe_soundex = soundex ($passe) ;
 
/*
● En cas d'absence du pseudo ou du mot de passe, on évitera les alertes en déclenchant une redirection vers la page « connexion.php » tout en envoyant un message “Pseudo & Passe ne doivent pas être vides => Vérifiez votre saisie !”.
○ Comment encoder correctement ce message ?
=> Utiliser urlencode 
○ Ce message doit s’afficher dans la page connexion.php. Le code affichant ce
message ne doit pas provoquer d’erreur si aucun message n’est fourni.
=> Utiliser fn valider()


● Si pseudo et mot de passe sont fournis, ils doivent vérifier l’une des conditions
suivantes pour correspondre à des identifiants corrects (cf. ​ 
http://php.net/manual/fr pour vous documenter sur ces fonctions) :
○ Leur distance de levenshtein est inférieure à 2;
○ Leurs clés soundex sont identiques



● Quand c’est le cas, la page ouvrir_session.php renvoie l’utilisateur vers la page
profil.php;
● Quand ce n’est le cas, la page ouvrir_session.php renvoie l’utilisateur vers la page connexion.php en renvoyant le message “Mot de passe incorrect”;
● Quelle URL mettre en favoris pour se loguer automatiquement avec le pseudo
“slideman” ? 
=> 
http://localhost/backend/ex2/ouvrir_session.php?pseudo=slideman&passe=slideman
*/


if (($lev <= 2) && ($pseudo_soundex == $passe_soundex)) {
	$_SESSION["pseudo"] = $pseudo;
	header("Location:profil.php");
	die("");
} else {
	header("Location:connexion.php?msg=" .  urlencode("Mot de passe incorrect !"));
	die("");
}

?>

Lev : <?=$lev?> <br />
S1 : <?=$pseudo_soundex?> <br />
S2 : <?=$passe_soundex?> <br />

