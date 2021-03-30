<?php

if (isset($_GET["excel"])) {
	header("Content-type:application/vnd.ms-excel");
	header("Content-disposition:attachment;filename=fake.xls");
}

/*
	NB: apache compresse par d�faut. 
	Pour activer cette fonctionnalit�, il faut des liens symboliques 
	dans mods-enabled vers les fichiers de conf deflate.conf et deflate.load 
	situ�s dans /etc/apache2/mods-available

	On peut le faire aussi en d�clenchant une mise en tampon 
	et en d�finissant une fonction de rappel pour la compression 

	C�t� ent�tes, le navigateur indique quels formats il supporte lors de sa requ�te : 
	GET /xyz HTTP/1.0
	Accept-Encoding: gzip, deflate

	Le serveur lui enverra la compression utilis�e
	Content-Encoding: gzip

*/

if (!isset($_GET["excel"])){

	// On place tout le contenu en m�moire tampon en essayant de compresser 
	if (! ob_start ("ob_gzhandler")) 
	{
		echo "NB: fonction gzhandler indisponible, compression inactive"; 
	}

	echo "Pour tester cette page par telnet, utiliser : <br />";
	echo "<pre>";
	echo "GET " . $_SERVER["REQUEST_URI"] . " HTTP/1.0\n";
	echo "Accept-Encoding: gzip\n";
	echo "</pre>";

	echo "<hr/>";

	echo '<form>';
	echo '<input type="hidden" name="excel" value="" />';
	echo '<input type="submit" value="Envoyer l\'ent&ecirc;te content-type correspondant aux fichiers excel">';
	echo '</form>';
}
?>


<table>
<tr>
<td>
C11
</td>
<td>
C12
</td>
</tr>
<tr>
<td>
C21
</td>
<td>
C22
</td>
</tr>
</table>
