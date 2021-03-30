<?php

/*
Dans ce fichier, on définit diverses fonctions permettant de récupérer des données utiles pour notre TP d'identification. Deux parties sont à compléter, en suivant les indications données dans le support de TP
*/


/********* EXERCICE 2 : prise en main de la base de données *********/


// inclure ici la librairie faciliant les requêtes SQL (en veillant à interdire les inclusions multiples)

include_once("maLibSQL.pdo.php");


function listerUtilisateurs($classe = "both")
{
	// Cette fonction liste les utilisateurs de la base de données 
	// et renvoie un tableau d'enregistrements. 
	// Chaque enregistrement est un tableau associatif contenant les champs 
	// id,pseudo,blacklist,couleur

	// Lorsque la variable $classe vaut "both", elle renvoie tous les utilisateurs
	// Lorsqu'elle vaut "bl", elle ne renvoie que les utilisateurs blacklistés
	// Lorsqu'elle vaut "nbl", elle ne renvoie que les utilisateurs non blacklistés

	$SQL = "SELECT id,pseudo,blacklist,couleur FROM users";
	if ($classe == "bl") 
		$SQL .= " WHERE blacklist=1";
	if ($classe == "nbl") 
		$SQL .= " WHERE blacklist=0";

	//die($SQL);

	return parcoursRs(SQLSelect($SQL));
	// SQLSelect($SQL) exécute la requete 
	// et renvoie un objet "resource php" (RecordSet)
	// qui contient les enregistrements demandés 

	// Résultats renvoyés sous la forme d'un tableau (indicé par des entiers) 
	// de tableaux associatifs

}

function interdireUtilisateur($idUser)
{
	// cette fonction affecte le booléen "blacklist" à vrai 
	// NEVER TRUST USER INPUT !!
	// SI l'utilisateur envoie id=3; drop tables users;
	// INJECTION SQL !!
	// UPDATE users SET blacklist=1 WHERE id=3; drop tables users; 

	// Première solution (la meilleure) : requêtes préparées 
	// exec_SQL(format, arg1, arg2, ...)

	// Notre solution : encadrer les arguments par des apostrophes 
	// ET banaliser d'éventuelles apostrophes dans les chaines qui viennent 
	// du client : fonction addslashes
	// les arguments devront avoir été récupérés à l'aide de la fonction 
	// valider() (cf. lib. maLibUtils)

	$SQL = "UPDATE users SET blacklist=1 WHERE id='$idUser'"; 
	SQLUpdate($SQL); 

}

function autoriserUtilisateur($idUser)
{
	// cette fonction affecte le booléen "blacklist" à faux 
	$SQL = "UPDATE users SET blacklist=0 WHERE id='$idUser'"; 
	SQLUpdate($SQL); 

}

/********* EXERCICE 4 *********/

function verifUserBdd($login,$passe)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès


	// On utilise SQLGetCHamp
	//permet de récupérer un seul champ d'un seul enregistrement
	//dans une table (
	$SQL = "SELECT id FROM users WHERE pseudo='$login' AND passe='$passe'";
	//$tab = parcoursRs(SQLSelect($SQL));
	//if (count($tab)>0) $tab[0]["id"] est l'ide cherche

	return SQLGetChamp($SQL);


	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect
}

function isAdmin($idUser)
{
	// vérifie si l'utilisateur est un administrateur
	//TODO: verifier diff entre ' et "

	$SQL = "SELECT admin FROM users WHERE id='$idUser'";
	return SQLGetChamp($SQL);
}

/********* EXERCICE 5 *********/

function listerConversations($mode="tout")
{
	// Liste toutes les conversations ($mode="tout")
	// OU uniquement celles actives  ($mode="actives"), ou inactives  ($mode="inactives")
	//faites attention aux spaces!!
	$SQL = "SELECT theme FROM conversations ";
	if ($mode == "actives") $SQL .= " WHERE active=1";
	if ($mode == "inactives") $SQL .= " WHERE active=0";

	return parcoursRs(SQLSelect($SQL));
}

function archiverConversation($idConversation)
{
	// rend une conversation inactive
	$SQL = "UPDATE conversations SET active=0 WHERE id='$idConversation'";
	SQLUpdate($SQL);

}

function reactiverConversation($idConversation)
{
	// rend une conversation active
	$SQL = "UPDATE conversations SET active=1 WHERE id='$idConversation'";
	SQLUpdate($SQL);

}

function creerConversation($theme)
{
	// crée une nouvelle conversation 
	$SQL = "INSERT INTO conversations(theme) VALUES ('$theme')";
	// renvoie son identifiant 
	SQLInsert($SQL);

}

function supprimerConversation($idConv)
{
	// supprime une conversation et ses messages
	// Utiliser pour cela des mises à jour en cascade en appliquant l'intégrité référentielle
	$SQL = "DELETE FROM conversations WHERE id='$idConv'";
	SQLDelete($SQL);

}


/********* EXERCICE 6 *********/

function enregistrerMessage($idConversation, $idAuteur, $contenu)
{
	// Enregistre un message dans la base en encodant les caractères spéciaux HTML : <, > et & 
	// pour interdire les messages HTML

	
}
function listerMessages($idConv)
{
	// Liste les messages de cette conversation
	// Champs à extraire : contenu, auteur, couleur 
	// en ne renvoyant pas les utilisateurs blacklistés


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
