<?php
session_start();

session_destroy(); // supprimer les variables de session 
header("Location:connexion.php?msg=" .urlencode("A bientôt !"));

?>
