<?php

//dans toutes les pages qu'on a besoin d'utiliser le tableau session,
//il faut écrirer 'session_start()'
session_start();

function valider($nom,$tab) {
	// Vérifier la présence d'une variable dans un tableau 
	// renvoyer sa valeur si elle existe
	// renvoyer false sinon 
	if (isset($tab[$nom])) { return $tab[$nom]; }
	else return false;  
}

/** 
if(isset($_SESSION['pseudo']))
    echo "Votre pseudo : " . $_SESSION['pseudo'];
else    
    echo "Pseudo inconnu!";
*/
if (valider("pseudo",$_SESSION)) 
	echo "Votre pseudo : " . $_SESSION["pseudo"]; 
else
	echo "Pseudo inconnu ! ";

?>

<a href="logout.php">Se deconnecter</a>