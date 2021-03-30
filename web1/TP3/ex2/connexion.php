<?php

function valider($nom,$tab) {
	// Vérifier la présence d'une variable dans un tableau 
	// renvoyer sa valeur si elle existe
	// renvoyer false sinon 
	if (isset($tab[$nom]) && ($tab[$nom]!="")) { return $tab[$nom]; }
	else return false;  
}

$msg = valider("msg",$_GET);

//echo $msg = msg
if(!$msg) $msgHTML = "";
else $msgHTML = "<div style=\"color:red;\">Attention : $msg</div>";

?>

<?=$msgHTML?>



<!-- envoyer les donnes à la page ouvrir_session.php  -> ça se fait avec l'attribut 'action' -->
<form action="ouvrir_session.php">
    Pseudo : <input type="text" name="pseudo" />
    Passe : <input type="password" name="passe" />
    <input type="submit"/>

</form>