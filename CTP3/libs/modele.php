<?php
include_once("maLibSQL.pdo.php"); 
// définit les fonctions SQLSelect, SQLUpdate...


// Users ///////////////////////////////////////////////////

function validerUser($pseudo, $pass){
	$SQL = "SELECT id FROM chat_users WHERE pseudo='$pseudo' AND passe='$pass'";
	if ($id=SQLGetChamp($SQL))
		return getHash($id);
	else return false;
}

function hash2id($hash) {
	$SQL = "SELECT id FROM chat_users WHERE hash='$hash'";
	return SQLGetChamp($SQL); 
}

function hash2pseudo($hash) {
	$SQL = "SELECT pseudo FROM chat_users WHERE hash='$hash'";
	return SQLGetChamp($SQL); 
}

function getUsers($classe = "both"){
	$SQL = "SELECT id,pseudo FROM chat_users";
	if ($classe == "bl") $SQL = $SQL . " WHERE blacklist=1";
	if ($classe == "nbl") $SQL .= " WHERE blacklist=0";

	return parcoursRs(SQLSelect($SQL));
}

function getUser($idUser){
	$SQL = "SELECT id,pseudo FROM chat_users WHERE id='$idUser'";
	$rs = parcoursRs(SQLSelect($SQL));
	if (count($rs)) return $rs[0]; 
	else return array();
}

function getHash($idUser){
	$SQL = "SELECT hash FROM chat_users WHERE id='$idUser'";
	return SQLGetChamp($SQL);
}

function mkHash($idUser) {
	// génère un (nouveau) hash pour cet user
	// il faudrait ajouter une date d'expiration
	$dataUser = getUser($idUser);
	if (count($dataUser) == 0) return false;
 
	$payload = $dataUser["pseudo"] . date("H:i:s");
	$hash = md5($payload); 
	$SQL = "UPDATE chat_users SET hash='$hash' WHERE id='$idUser'"; 
	SQLUpdate($SQL); 
	return $hash; 
}

function mkUser($pseudo, $pass){
	$SQL = "INSERT INTO chat_users(pseudo,passe) VALUES('$pseudo', '$pass')";
	$idUser = SQLInsert($SQL);
	mkHash($idUser); 
	return $idUser; 
}


function rmUser($idUser) {
	$SQL = "DELETE FROM chat_users WHERE id='$idUser'";
	return SQLDelete($SQL);
}

function chgPassword($idUser,$pass) {
	$SQL = "UPDATE chat_users SET passe='$pass' WHERE id='$idUser'";
	SQLUpdate($SQL);
	return 1; 
}

function interdireUtilisateur($idUser) {
	$SQL = "UPDATE chat_users SET blacklist = 1 WHERE id='$idUser'";
	SQLUpdate($SQL);
}

function autoriserUtilisateur($idUser) {
	$SQL = "UPDATE chat_users SET blacklist = 0 WHERE id='$idUser'";
	SQLUpdate($SQL);
}

// Conversations ///////////////////////////////////////////////////

function getConversations($mode="tout"){
	$SQL="SELECT * FROM chat_conversations "; 
	if ($mode == "actives") $SQL  .= " WHERE active=1"; 
	if ($mode == "inactives") $SQL  .= " WHERE active=0"; 
	return parcoursRs(SQLSelect($SQL));
}

function getConversation($idConv){
	$SQL = "SELECT theme, active FROM chat_conversations WHERE id='$idConv'";
	$rs = parcoursRs(SQLSelect($SQL));
	if (count($rs)) return $rs[0]; 
	else return array();
}

function mkConversation($theme){
	$SQL = "INSERT INTO chat_conversations(theme) VALUES('$theme')";
	return SQLInsert($SQL);
}

function rmConversation($id) {
	$SQL = "DELETE FROM chat_conversations WHERE id='$id'";
	SQLDelete($SQL);

	// automatique normalement
	//$SQL = "DELETE FROM chat_messages WHERE idConversation='$idConv'";
	//SQLUpdate($SQL);
}

function chgThemeConversation($id,$theme) {
	$SQL = "UPDATE chat_conversations SET theme='$theme' WHERE id='$id'";
	SQLUpdate($SQL);
	return 1; 
	// return SQLUpdate() pose souci si il n'y a pas modif de titre
	// SQLUpdate renvoie alors 0 ! 
}

function archiverConversation($idConversation)
{
	// rend une conversation inactive
	$SQL ="UPDATE chat_conversations SET active=0 WHERE id='$idConversation'";
	SQLUpdate($SQL);
	return 1; 
}

function reactiverConversation($idConversation)
{
	// rend une conversation active
	$SQL ="UPDATE chat_conversations SET active=1 WHERE id='$idConversation'";
	SQLUpdate($SQL);
	return 1; 
}

// Messages ///////////////////////////////////////////////////

function getMessages($idConv) {
	$SQL = "SELECT m.id, m.contenu, u.pseudo as auteur, u.couleur "; 
	$SQL .= " FROM chat_users u INNER JOIN chat_messages m";
	$SQL .= " ON m.idAuteur = u.id ";  
	$SQL .= " WHERE m.idConversation='$idConv'"; 
	$SQL .= " AND u.blacklist=0"; 
	$SQL .= " ORDER BY m.id ASC";

	return parcoursRs(SQLSelect($SQL));
}

function getMessage($id, $idConversation=false) {
	$SQL = "SELECT m.id, m.contenu, u.pseudo as auteur, u.couleur FROM chat_users u INNER JOIN chat_messages m WHERE m.id='$id'"; 
	if ($idConversation) $SQL .= " AND m.idConversation='$idConversation'";

	$rs = parcoursRs(SQLSelect($SQL));
	if (count($rs)) return $rs[0]; 
	else return array();
}


function rmMessage($id,$idConversation=false) {
	$SQL = "DELETE FROM chat_messages WHERE id='$id'";
	if ($idConversation) $SQL .= " AND idConversation='$idConversation'";
	return SQLDelete($SQL);
}

function mkMessage($idConversation, $idAuteur, $contenu){
	$contenu = htmlentities($contenu);
	$SQL ="INSERT INTO chat_messages(idConversation, idAuteur, contenu)"; 
	$SQL .= " VALUES ('$idConversation', '$idAuteur', '$contenu')";
	return SQLInsert($SQL);
}


function listerUtilisateurs($classe = "both")
{
	// Cette fonction liste les utilisateurs de la base de données 
	// et renvoie un tableau d'enregistrements. 
	// Chaque enregistrement est un tableau associatif contenant les champs 
	// id,pseudo,blacklist,couleur

	// Lorsque la variable $classe vaut "both", elle renvoie tous les utilisateurs
	// Lorsqu'elle vaut "bl", elle ne renvoie que les utilisateurs blacklistés
	// Lorsqu'elle vaut "nbl", elle ne renvoie que les utilisateurs non blacklistés

	$SQL = "SELECT id,pseudo,blacklist,couleur from chat_users";
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

/********* CTP2 *********/

function verifUserBdd($login,$passe)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès
	$SQL = "SELECT id FROM chat_users WHERE pseudo='$login' AND passe='$passe'";
	// On utilise SQLGetCHamp
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect

	//die($SQL);  //pour voir la requete qu'on est en train d'exécuter 
	return SQLGetChamp($SQL);

	
}

function isAdmin($idUser)
{
	// vérifie si l'utilisateur est un administrateur
	$SQL = "SELECT admin FROM chat_users WHERE id='$idUser'";
	return SQLGetChamp($SQL);
}


?>
