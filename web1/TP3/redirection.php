<?php
header("Location:accueil.php");
//die("");

// ATTENTION : le fait d'envoyer l'entête Location au navigateur ne signifie pas que le contenu de la page côté serveur n'est pas envoyé au client ! 

// ATTENTION : ne pas envoyer la suite des données 
// au client, sinon il y aurait des manières pour récupérer ces données 

// Par exemple, en ouvrant une connexion sur le port 80 vers la page serveur avec la commande telnet 
?>

<h1>Redirection.php</h1>

L'entête de réponse Content-Length correspond à la taille de la réponse renvoyée par le serveur, en octets. 

ELle vaut ici : 171 Octets. 
