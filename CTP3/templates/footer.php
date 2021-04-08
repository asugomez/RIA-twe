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

//echo "Var de Session : "; 
//tprint($_SESSION);
// Si l'utilisateur est connecte, on affiche un lien de deconnexion 
if (valider("connecte","SESSION")) //il faut creer l'attribut connecte à $_SESSION
{
	echo "Utilisateur <b>$_SESSION[pseudo]</b> est connecté(e) depuis <b>$_SESSION[heureConnexion]</b> &nbsp; "; 
	echo "<a href=\"controleur.php?action=Logout\">Se Déconnecter</a>";
}
?>
</div>

</body>
</html>
