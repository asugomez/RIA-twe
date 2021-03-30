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
	// id,pseudo,blacklist,couleur

	// Lorsque la variable $classe vaut "both", elle renvoie tous les utilisateurs
	// Lorsqu'elle vaut "bl", elle ne renvoie que les utilisateurs blacklistés
	// Lorsqu'elle vaut "nbl", elle ne renvoie que les utilisateurs non blacklistés

	$SQL = "SELECT id,pseudo,blacklist,couleur from users";
	if($classe == 'nbl'){
		$SQL .= " WHERE blacklist=0";
	}
	if($classe == 'bl'){
		$SQL .= " WHERE blacklist=1";
	}

	
	return parcoursRs(SQLSelect($SQL));
	//SQLSelect($SQL) execute la requete et renvoie un objet "resource php"
	// qui contient les enregistrements demandés

}

function interdireUtilisateur($idUser)
{
	// cette fonction affecte le booléen "blacklist" à vrai 
	$SQL = "UPDATE users SET blacklist=1 WHERE id='$idUser'";
	//pour executer la requete
	SQLUpdate($SQL);

}

function autoriserUtilisateur($idUser)
{
	// cette fonction affecte le booléen "blacklist" à faux 

	//1. il faut encadrer les champs dangereuz par des apostrophes
	//2. banaliser ces caractères speciaux SQL
	//des entrées des utilisateurs => realiser par la fonciton valider()
	//qui appelle addslashes()
	//l'effet de cette protection: banaliser les ' --> \'

	//TODO: la meilleures manière de se premunir des injections est d'utiliser des requetes preparees
	$SQL = "UPDATE users SET blacklist=0 WHERE id='$idUser'";
	//pour executer la requete
	SQLUpdate($SQL);

}

/********* EXERCICE 4 *********/

function verifUserBdd($login,$passe)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès
	$SQL = "SELECT id FROM users WHERE pseudo='$login' AND passe='$passe'";
	// On utilise SQLGetCHamp
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect

	//die($SQL);  //pour voir la requete qu'on est en train d'exécuter 
	return SQLGetChamp($SQL);

	
}

function isAdmin($idUser)
{
	// vérifie si l'utilisateur est un administrateur
	$SQL = "SELECT admin FROM users WHERE id='$idUser'";
	return SQLGetChamp($SQL);
}

/********* EXERCICE 5 *********/

function listerConversations($mode="tout")
{
	// Liste toutes les conversations ($mode="tout")
	// OU uniquement celles actives  ($mode="actives"), ou inactives  ($mode="inactives")
	$SQL = "SELECT * FROM conversations";
	if($mode=='actives'){
		$SQL .= " WHERE active=1";
	}
	if($mode == 'inactives'){
		$SQL .= " WHERE active=0";
	}
	return parcoursRs(SQLSelect($SQL));
}

function archiverConversation($idConversation)
{
	// rend une conversation inactive

	$SQL = "UPDATE conversations SET active=0 WHERE id='$idConversation'";
	//pour executer la requete
	SQLUpdate($SQL);
}

function reactiverConversation($idConversation)
{
	// rend une conversation active
	$SQL = "UPDATE conversations SET active=1 WHERE id='$idConversation'";
	//pour executer la requete
	SQLUpdate($SQL);

}

function creerConversation($theme)
{
	// crée une nouvelle conversation et renvoie son identifiant
	$SQL = "INSERT INTO `conversations` (`id`, `active`, `theme`) VALUES (NULL, '1', '$theme');";
	
	return SQLInsert($SQL);

	
}

function supprimerConversation($idConv)
{
	// supprime une conversation et ses messages
	// TODO: Utiliser pour cela des mises à jour en cascade en appliquant l'intégrité référentielle
	$SQL = "DELETE FROM `conversations` WHERE id= '$idConv'";
	SQLDelete($SQL);
}


/********* EXERCICE 6 *********/

function enregistrerMessage($idConversation, $idAuteur, $contenu)
{
	// Enregistre un message dans la base en encodant les caractères spéciaux HTML : <, > et & 
	// pour interdire les messages HTML
	//failles XSS: cross-site-scripting
	$contenu = htmlentities($contenu);

	$SQL = "INSERT INTO messages(contenu,idAuteur, idConversation) "; 
	$SQL .= " VALUES ('$contenu', '$idAuteur', '$idConversation')"; 

	SQLInsert($SQL);

	
}
function listerMessages($idConv)
{
	// Liste les messages de cette conversation
	// Champs à extraire : contenu, auteur, couleur 
	// en ne renvoyant pas les utilisateurs blacklistés
	//$SQL = " SELECT * FROM messages WHERE idConversation='$idConv'";
	//$SQL = "SELECT contenu, auteur, couleur FROM messages WHERE conversations.id='$idConv";
	
	
	$SQL = "SELECT m.contenu, u.pseudo as auteur, u.couleur "; 
	$SQL .= " FROM messages m INNER JOIN users u ON m.idAuteur=u.id";
	$SQL .= " WHERE m.idConversation='$idConv' "; 
	$SQL .= " AND u.blacklist=0";
	$SQL .= " ORDER BY m.id ASC";

	return parcoursRS(SQLSelect($SQL));  


}

function listerMessagesFromIndex($idConv,$index)
{
	// Liste les messages de cette conversation, 
	// dont l'id est superieur à l'identifiant passé
	// Champs à extraire : contenu, auteur, couleur 
	// en ne renvoyant pas les utilisateurs blacklistés

}

function getConversation($idConv)
{	
	// Récupère les données de la conversation (theme, active)
	$SQL = "SELECT theme, active FROM conversations WHERE id='$idConv'";
	$listConversations = parcoursRs(SQLSelect($SQL));

	// Attention : parcoursRS nous renvoie un tableau contenant potentiellement PLUSIEURS CONVERSATIONS
	// Il faut renvoyer uniquement la première case de ce tableau, c'est à dire la case 0 
	// OU false si la conversation n'existe pas
	 
	if (count($listConversations) == 0) return false;
	else return $listConversations[0];
}

?>
