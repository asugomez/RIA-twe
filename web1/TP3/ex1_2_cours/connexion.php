
<?php

if(isset($_REQUEST["msg_error"]) and $_REQUEST["msg_error"]==true){
    /* a faire */
    echo $_GET["msg_error"];
}



?>
<h1>
    Connexion!
</h1>

<form  action="ouvrir_session.php" method="GET" >

<!-- qu'est-ce que l'attribut "for" fait? --> 
<label for="pseudo">Pseudo : </label>
<input type="text" id="pseudo" name="login" />
<br/>
<br/>
<label for="mdp">Mot de passe : </label>
<input type="password" id="mdp" name="passe" /> 

<br/>
<br/>
<input type="submit" value="Envoyer" />

</form>


<hr />

