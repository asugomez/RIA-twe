<?php
//sleep(2); //latence 
// si on foruni rien, la page n s'affiche pas 


//charger malibutils

include_once "libs/maLibUtils.php";
include_once "libs/maLibSQL.pdo.php";

$data = array();
$data["promo"] = 2021 ;
$data["etudiants"]= array();

//print_r($data);

if ($cherche = valider("debutNom")) 
{
	$SQL = "SELECT * FROM etudiants WHERE ";
    $SQL .= " prenom LIKE '$cherche%'";
    $SQL .= " OR nom LIKE '$cherche%'";

    $data["etudiants"] = parcoursRs(SQLSelect($SQL));
    

}

//print_r($data);
echo json_encode($data);

?>
