<?php
//nouvelle entete -->location (permet une redirection)
//headers --> response headers --> location :  accueil.php
header("Location:accueil.php");
die(""); //pour que l'operation header soit sécurisé 
//le fait d'envoyer l'entête location au navigateur ne signifie pas que 
//le contenu de la page côté serveur n'est pas envoyé au client!

// ATTENTION: ne pas envoyer la suite des données au client,
// sinon, il y aurait des manière pour récupérer ces données (il va quand meme le vpor) 
?>
<!-- l'entete de reponse  (response header )

-->
<h1>Redirection.php</h1>

l'entête de réponse CONtent-length corrspond à la taille de la réponse renvoyée par le serveurs, en octest.

Elle vaut ici: 171 octets.

<!--
    
on veut essayer de faire une connexion avec la page
on met dans la terminal:
telnet localhost 80 
GET/web1/TP3/ex2/redirection.php   HTTP/1.0

-- le serveur apache reponde en utilisant le protocole HTTP/1.1

HTTP/1.1 302 Found
Date: Sun, 21 Mar 2021 18:04:18 GMT
Server: Apache/2.4.29 (Ubuntu)
Location: accueil.php
Content-Length: 0
Connection: close
Content-Type: text/html; charset=UTF-8

Connection closed by foreign host.


(on dialogique avec le serveur apache)
--> 