<?php

/*
Dans ce fichier, on définit diverses fonctions permettant de récupérer des données utiles pour notre TP d'identification. Deux parties sont à compléter, en suivant les indications données dans le support de TP
*/


/********* EXERCICE 2 : prise en main de la base de données *********/


// inclure ici la librairie faciliant les requêtes SQL (en veillant à interdire les inclusions multiples)
include_once("maLibSQL.pdo.php"); //ce fichier inclue aussi le fichier config.php 

function listerUtilisateurs($classe = "both")
{
	// Cette fonction liste les utilisateurs de la base de données 
	// et renvoie un tableau d'enregistrements. 
	// Chaque enregistrement est un tableau associatif contenant les champs 
	// id,pseudo,statut

	// Lorsque la variable $classe vaut "both", elle renvoie tous les utilisateurs
	// Lorsqu'elle vaut "P", elle ne renvoie que les utilisateurs enseignants
	// Lorsqu'elle vaut "E", elle ne renvoie que les utilisateurs étudiants

	//$SQL = "select * from users";
	//return parcoursRs(SQLSelect($SQL));
    $SQL = "SELECT * FROM users";
	if($classe == 'P'){
		$SQL .= " WHERE statut='P'";
	}
	if($classe == 'E'){
		$SQL .= " WHERE statut='E'";
	}
	return parcoursRs(SQLSelect($SQL));

}

function verifUserBdd($login,$passe)
{
    $SQL = "SELECT idUser from users where pseudo='".$login."' AND passe='".$passe."';";
    return SQLGetChamp($SQL);
}

function isProf($idUser)
{
	// vérifie si l'utilisateur est un enseignant
    $SQL = "SELECT idUser FROM users";
    $SQL .= " WHERE idUser='$idUser' AND statut='P'";
	return SQLGetChamp($SQL);
}

function listerProjets($selection)
{
    $SQL= " SELECT * FROM projets";
    if(!($selection=='')) $SQL .= " WHERE anneeScolaire='$selection'";

    return parcoursRs(SQLSelect($SQL));

}


function getInfosProjet($idProjet)
{	
	// Récupère les données du projet
	$SQL = "SELECT nomProjet, anneeScolaire, idResponsable FROM projets WHERE idProjet='$idProjet'";
	$listProjets = parcoursRs(SQLSelect($SQL));

	if (count($listProjets) == 0) return false;
	else return $listProjets[0];
}


function creerContribution($idEtape,$idUser,$dateContribution, $urlContribution)
{
    $urlContribution = htmlentities($urlContribution);

	$SQL = "INSERT INTO contributions(idEtape,dateContribution, urlContribution) "; 
	$SQL .= " VALUES ('$idEtape','$idUser','$dateContribution', '$urlContribution')"; 

	SQLInsert($SQL);

}


function listerEtapes($idProjet,$idUser,$option="toutes")
{
    if ($option=="toutes") {
        $SQL = "SELECT * from etapes where idProjet = " . $idProjet;
    }
    else
    {
        $SQL = "SELECT etapes.* from etapes WHERE idProjet=$idProjet AND idEtape NOT IN (SELECT idEtape from contributions where idUser=$idUser)";
    }
    return parcoursRs(SQLSelect($SQL));
}


function listeContributions($idProjet,$idUser)
{
    $SQL = "SELECT u.idUser as idUser, p.idProjet as idProjet, c.idEtape as idEtape, c.urlContribution as urlContribution";
    $SQL .= " FROM (users u INNER JOIN  contributions c ON u.idUser=c.idUser)";
    $SQL .= " INNER JOIN projets p ON  c.idUser=p.idResponsable";
    $SQL .= " WHERE u.idUser=$idUser AND p.idProjet=$idProjet ";
	//$SQL .= " ORDER BY c.dateContribution ASC";

    //die("id recu : $idUser");
	return parcoursRS(SQLSelect($SQL));

}
?>
