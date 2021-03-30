<?php

/*
Dans ce fichier, on définit diverses fonctions permettant de récupérer des données utiles pour notre TP d'identification. Deux parties sont à compléter, en suivant les indications données dans le support de TP
*/


/********* EXERCICE 2 : prise en main de la base de données *********/


// inclure ici la librairie faciliant les requêtes SQL (en veillant à interdire les inclusions multiples)
include_once("libs/maLibSQL.pdo.php");

function listerUtilisateurs($classe = "both")
{
	// Cette fonction liste les utilisateurs de la base de données 
	// et renvoie un tableau d'enregistrements. 
	// Chaque enregistrement est un tableau associatif contenant les champs 
	// id,pseudo,blacklist,couleur

	// Lorsque la variable $classe vaut "both", elle renvoie tous les utilisateurs
	// Lorsqu'elle vaut "bl", elle ne renvoie que les utilisateurs blacklistés
	// Lorsqu'elle vaut "nbl", elle ne renvoie que les utilisateurs non blacklistés

	$SQL = "SELECT * FROM users";
	// attention à l'espace entre le nom de la table et le mot-clé WHERE
	if ($classe == "bl") $SQL .= " WHERE blacklist=1";
	if ($classe == "nbl") $SQL .= " WHERE blacklist=0";

	return parcoursRs(SQLSelect($SQL));

}

function interdireUtilisateur($idUser)
{
	// DANGER ! 
	// La valeur de $idUser provient de l'utilisateur du site
	// NEVER TRUST USER INPUT !!
	// Que se passe-t-il si l'utilisateur envoie 
	// 1; DROP TABLE users; 
	// INJECTION SQL : très dangereux

	// Pour s'en prémunir : 
	// 1) systématiquement encadrer les champs dangereux par des apostrophes

	// l'utilisateur pourrait aussi injecter des apostrophes !!
	// 1'; DROP TABLE users;' 

	// 2) banaliser les caractères spéciaux SQL 
	// des entrées des utilisateurs
	// => réalisé par la fonction valider() 
	// qui appelle addslashes() 
	// l'effet de cette protection : banaliser les ' 
	// L'entrée : 1'; DROP TABLE users;' 
	// se transforme en 
	// 1\'; DROP TABLE users;\' 

	// Dans les frameworks plus évolués, la meilleure manière de se prémunir
	// des injections est d'utiliser des requetes préparées
	// Principe : 
	// format de requete 
	// SQL : "UPDATE users SET blacklist=1 WHERE id=%s"
	// l'argument est fourni à la fonction de requetage 
	// qui protège contre les injections SQL 
	// $pdo->query(format,argument1, argument2, ...)

	// Les requêtes préparées permettent aussi d'optimiser 
	// l'exécution des requetes qui ne sont interprétées qu'une fois

	// cette fonction affecte le booléen "blacklist" à vrai 
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
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect
}

function isAdmin($idUser)
{
	// vérifie si l'utilisateur est un administrateur
}

/********* EXERCICE 5 *********/

function listerConversations($mode="tout")
{
	// Liste toutes les conversations ($mode="tout")
	// OU uniquement celles actives  ($mode="actives"), ou inactives  ($mode="inactives")
}

function archiverConversation($idConversation)
{
	// rend une conversation inactive

}

function reactiverConversation($idConversation)
{
	// rend une conversation active

}

function creerConversation($theme)
{
	// crée une nouvelle conversation et renvoie son identifiant

}

function supprimerConversation($idConv)
{
	// supprime une conversation et ses messages
	// Utiliser pour cela des mises à jour en cascade en appliquant l'intégrité référentielle

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
