<?php
//sleep(2);
// code robuste : toujours renvoyer la meme structure de réponse
$data = array(); 
$data["promo"] = 2021; 
$data["etudiants"] = array(); 
 
if (isset($_GET["debutNom"])) 
{
	$cherche = $_GET["debutNom"]; 
	
	// On va ouvrir un fichier et afficher les lignes 
	// où le prénom ou le nom contient ce texte

	$tabLignes = file("twe_2021.txt");
	foreach ($tabLignes as $ligne)
	{
		// EXO1 : effectuer une recherche sur nom ou prénom 
		if (
			preg_match("/^(.*):(" . $cherche . ".*)$/i",$ligne,$tabResultats) 
		|| 
			preg_match("/^(" . $cherche . ".*):(.*)$/i",$ligne,$tabResultats)
		)
		{
			// EXO2 afficher nom ET prénom 
			// echo "<li>$tabResultats[2] $tabResultats[1] </li>"; 
			$data["etudiants"][] = array("prenom"=>$tabResultats[2], "nom"=>$tabResultats[1]);
			//print_r(array("prenom"=>$tabResultats[2], "nom"=>$tabResultats[1]));
		}
	}
}

//print_r($data);
echo json_encode($data);

?>