<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

?>

<div id="pied">

<?php
// Si l'utilisateur est connecte, on affiche un lien de deconnexion 
//deuxieme variable: SESSION
if (valider("connecte","SESSION"))
//if (isset($_SESSION["conne"]))
{
	echo "Utilisateur <b>$_SESSION[pseudo]</b> connecté depuis <b>$_SESSION[heureConnexion]</b> &nbsp; "; 
	//se deconnecter --> autour d'un lien (pas un champ formulaire)
	//on va qm envoyer la commande au controleur 
	echo "<a href=\"controleur.php?action=Logout\">Se Déconnecter</a>";
}
?>
</div>

</body>
</html>
