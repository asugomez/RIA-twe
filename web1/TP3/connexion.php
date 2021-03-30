<?php

/*
4. Une page “connexion.php” contient un formulaire qui permet à l'utilisateur d'entrer
lui-même un pseudo et un mot de passe et de l’envoyer à la page “ouvrir_session.php”.
*/
function valider($nom,$tab) {
	// Vérifier la présence d'une variable dans un tableau 
	// renvoyer sa valeur si elle existe
	// renvoyer false sinon 
	if (isset($tab[$nom]) && ($tab[$nom]!="")) { return $tab[$nom]; }
	else return false;  
}

$msg = valider("msg",$_GET);

//echo "msg = $msg";
if (!$msg) $msgHTML = ""; 
else $msgHTML = "<div style=\"color:red;\">Attention : $msg</div>";

?>

<?=$msgHTML?>

<form action="ouvrir_session.php">
Pseudo : <input type="text" name="pseudo" />
Passe : <input type="password" name="passe" /> 
<input type="submit" />
</form>
