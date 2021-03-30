<?php

session_start();
if(isset($_SESSION["pseudo"]))
    echo "Votre pseudo : " . $_SESSION["pseudo"];
else
    echo "Pseudo inconnu !";
?>

<input type="button" value="SE deconnecter" />