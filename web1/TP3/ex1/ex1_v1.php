<style>
	table {
		border:1px solid black; 
		border-collapse:collapse;
	}
	th,td {
		border:1px solid black; 
		padding:5px;
	}
</style>

<?php
function show($tab)
{
	echo "<table><tr><th>Nom</th><th>Valeur</th></tr>";
	foreach( $tab as $cle => $val)
	{
		echo "<tr><th>$cle</th><td>";
		if (is_array($val))
			show($val);
		else 
			echo "$val"; 
		echo "</td></tr>";
	}
	echo "</table>";
}

// pour éviter les soucis avec des configurations de php utilisant les tags courts
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- **** H E A D **** -->
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->
<body>

<?php

echo "<h2>Cette page a été appelée par la méthode " . $_SERVER["REQUEST_METHOD"] ;
echo "</h2><p>Données reçues : </p>";

if ($_SERVER["REQUEST_METHOD"] == "GET") 
{	
	if (count($_GET)>0) { 
		show($_GET);
	}
	else echo "Aucune";
}
else 
{
	if (count($_POST)>0) { 
		show($_POST);
	}
	else echo "Aucune";
}
?>

<p></p>
<!-- on trouve la chaine de requete (querystring) en cliquant sur l'onglet "headers" après avoir
sélectionné la requete qui nous intéresse dans l'affichage de l'inspecteur du navigateur


structure des chaines de requete:
cle=valeur&cle2=valeur2

les champs qui sont envoyés par le navigateur sont uniquements ceux qui sont
dedans le "form" et qui ont un attribut name

l'attribut value est la valeur par défaut du champ (différent à l'attribut placeholder (infobulle))
qui est une information de documentation du champ

le serveur ne parvient pas à récupérer toutes les valeurs si elles ont le même nom (name)

-->



<form action="" method="">
CT1 : <input type="text" name="champ_texte" value="" 
placeholder="insérer ici la première valeur"/> <br/>

CT2: <input type="radio" name="champ_texte2" value="val2"/><br/>

CT3: <input type="checkbox" name="champ_texte3" value="val3"/><br/>

<input type="submit" />
</form>

<!-- comment envoyer plusieurs valeurs associées à la même clé en éditant manuellement 
la chaîne de requête dans la barre d'adresse?
-> menu deroulant
-->
<form action="" method="">
	<select name="courses">
		<option value="id1"> legumes </option>
		<option value="id2"> fruits </option>
		<option value="id3"> bonbons </option>
	</select>

	<input type="submit" />
</form>

<form action="" method="">
	<select name="courses-2" multiple>
		<option value="ide1"> legumes 2 </option>
		<option value="ide2"> fruits 2 </option>
		<option value="ide3"> bonbons 2 </option>
	</select>

	<input type="submit" />
</form>

<!--
comment nommer la clé pour pouvoir récupérer toutes les valeurs côté serveur?
il faut la faire suivre par une paire de crochets: []

-->
<form action="" method="">
	<select name="courses-3[]" multiple>
		<option value="ide1"> legumes 2 </option>
		<option value="ide2"> fruits 2 </option>
		<option value="ide3"> bonbons 2 </option>
	</select>

	<input type="submit" />
</form>

<!-- avec la methode POST
on ne voit pas les valeurs dans la barre d'adresse, mais on peut le voir dans
NEtwork > headers > form data 

la methode post n'est pas limite en termes de taillle de données.
on passe les données après la fin des entetes de requête

les flux ne s'affichent pas dans la barre d'adresse
-->
<form action="" method="post">
	<select name="courses-post[]" multiple>
		<option value="ide1"> legumes 2 </option>
		<option value="ide2"> fruits 2 </option>
		<option value="ide3"> bonbons 2 </option>
	</select>

	<input type="submit" />
</form>

<!-- 2 bouton submit? - oui c'est possible

permet de mutaliser des champs dans un formulaire, typiquement ici le menu déroulant

quel que soit le bouton, les données sont envoyées. l'attribut name donné aux boutons (ici "action") 
est également envoyé au serveur, associé à la valeur du bouton sélectionné
(ici, soit "commander" so
it "supprimer")
-->
<form action="" method="post">
	<select name="courses2-post[]" multiple>
		<option value="ide1"> legumes 2 </option>
		<option value="ide2"> fruits 2 </option>
		<option value="ide3"> bonbons 2 </option>
	</select>

	<input type="submit" name="action" value="commander" />
	<input type="submit" name="action" value="supprimer" />
</form>
  
</body>
<!-- **** F I N **** B O D Y **** -->

</html>
