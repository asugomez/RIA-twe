<?php
session_start();

/*
Une seconde page “profil.php” affiche cette variable.
*/

function valider($nom,$tab) {
	// Vérifier la présence d'une variable dans un tableau 
	// renvoyer sa valeur si elle existe
	// renvoyer false sinon 
	if (isset($tab[$nom])) { return $tab[$nom]; }
	else return false;  
}

/*
if (isset($_SESSION["pseudo"])) 
	echo "Votre pseudo : " . $_SESSION["pseudo"]; 
else
	echo "Pseudo inconnu ! ";
*/

if (valider("pseudo",$_SESSION)) 
	echo "Votre pseudo : " . $_SESSION["pseudo"]; 
else
	echo "Pseudo inconnu ! ";

/*
On souhaite permettre à l’utilisateur de se déconnecter. Proposer une solution dans
laquelle la déconnexion se fait en cliquant sur un lien, de sorte que l’utilisateur une fois
déconnecté revienne à la page de connexion qui affiche alors le message “A Bientôt”.
*/


/*
TODO: Un utilisateur non connecté ne doit pas pouvoir afficher la page de profil
mais doit être redirigé vers la page de connexion 

Les identifiants doivent être vérifiés depuis une liste d'utilisateurs valides, composé de paires pseudo/passe. 
TODO: Créer ce tableau, vérifier les identifiants en vous servant de ce tableau.
Vérifier que la paire pseudo_inconnu, passe vide ne permette pas de se connecter.  
*/
?>

<a href="logout.php">Se déconnecter </a>

