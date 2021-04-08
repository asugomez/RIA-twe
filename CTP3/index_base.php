
<?php
include_once("libs/maLibUtils.php");
include_once("libs/modele.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

$data = array("version"=>1.3);

// 1.3 : interdiction de modification des users 1 et 2

// Routes : /api/...

$method = $_SERVER["REQUEST_METHOD"];
debug("method",$method);

if ($method == "OPTIONS") die("ok - OPTIONS");

$data["success"] = false;
$data["status"] = 400; 

// Verif autorisation : il faut un hash
// Il peut être dans le header, ou dans la chaîne de requête

$connected = false; 

if (!($hash = valider("hash"))) 
	$hash = valider("HTTP_HASH","SERVER"); 

if($hash) {
	// Il y a un hash, il doit être correct...
	if ($connectedId = hash2id($hash)) $connected = true; 
	else {
		// non connecté - peut-être est-ce POST vers /autenticate...
		$method = "error";
		$data["feedback"] = "Authentification incorrecte";
		$data["status"] = 403;
	}
}

if (valider("request")) {
	$requestParts = explode('/',$_REQUEST["request"]);

	debug("rewrite-request" ,$_REQUEST["request"] ); 
	debug("#parts", count($requestParts) ); 

	$entite1 = false;
	$idEntite1 = false;
	$entite2 = false; 
	$idEntite2 = false; 

	if (count($requestParts) >0) {
		$entite1 = $requestParts[0];
		debug("entite1",$entite1); 
	} 

	if (count($requestParts) >1) {	
		if (is_id($requestParts[1])) {
			$idEntite1 = intval($requestParts[1]);
			debug("idEntite1",$idEntite1); 
		} else {
			// erreur !
			$method = "error";
			$data["status"] = 400; 
		}
	}

	if (count($requestParts) >2) {
		$entite2 = $requestParts[2];
		debug("entite2",$entite2); 
	}

	if (count($requestParts) >3) {
		if (is_id($requestParts[3])) {
			$idEntite2 = intval($requestParts[3]);
			debug("idEntite2",$idEntite2); 
		} else {
			// erreur !
			$method = "error";
			$data["status"] = 400;
		}

	}  

// TODO: en cas d'erreur : changer $method pour préparer un case 'erreur'

	$action = $method; 
	if ($entite1) $action .= "_$entite1";
	if ($entite2) $action .= "_$entite2";
 
	debug("action", $action);

	if ($action == "POST_authenticate") {
		if ($user = valider("user"))
		if ($password = valider("password")) {
			if ($hash = validerUser($user, $password)) {
				$data["hash"] = $hash;
				$data["success"] = true;
				$data["status"] = 202;
			} else {
				// connexion échouée
				$data["status"] = 401;
			}
		}
	}
	elseif ($connected)
	{
		// On connaît $connectedId
		switch ($action) {

			case 'GET_users' :			
				if ($idEntite1) {
					// GET /api/users/<id>
					$data["user"] = getUser($idEntite1);
					$data["success"] = true;
					$data["status"] = 200; 
				} 
				else {
					// GET /api/users				
					if (($status = valider("status")) !== false) {
						// GET /api/users?status=
						if ($status=="authorized") {
							$data["users"] = getUsers("nbl");
							$data["success"] = true;
							$data["status"] = 200;
						}
						else if ($status=="blacklisted") {
							$data["users"] = getUsers("bl");
							$data["success"] = true;
							$data["status"] = 200;
						}
						else {
							// erreur 	
						}
					}
					else {
						// tous : // GET /api/users
						$data["users"] = getUsers();
						$data["success"] = true;
						$data["status"] = 200;
					}
				}
			break; 

			case 'GET_conversations' : 
				if ($idEntite1){
					// GET /api/conversations/<id>
					$data["conversation"] = getConversation($idEntite1);
					$data["success"] = true;
					$data["status"] = 200;
				} else {
					// GET /api/conversations
					// Les conversations					
					if (($mode = valider("mode")) !== false) {
						// distinguer active/inactive
						// GET /api/conversations?mode=
						$data["conversations"] = getConversations($mode);
						$data["success"] = true;
						$data["status"] = 200;
					} else {
						// toutes 
						$data["conversations"] = getConversations();
						$data["success"] = true;
						$data["status"] = 200; 
					}
				}
			break;

			case 'GET_conversations_messages' : 
				if ($idEntite1)
				if ($idEntite2) {
					// GET /api/conversations/<id>/messages/<id>
					$data["message"] = getMessage($idEntite2, $idEntite1);
					$data["success"] = true;
					$data["status"] = 200;
				} else {
					// GET /api/conversations/<id>/messages
					$data["messages"] = getMessages($idEntite1);
					$data["success"] = true;
					$data["status"] = 200;		 
				}
			break; 

			case 'POST_users' : 
				// POST /api/users?pseudo=&pass=...
				if ($pseudo = valider("user"))
				if ($pass = valider("password")) {
					$id = mkUser($pseudo, $pass); 
					$data["user"] = getUser($id);
					$data["success"] = true;
					$data["status"] = 201;
				}
			break; 

			case 'POST_conversations' :
				// POST /api/conversations?theme=...
				if (($theme = valider("theme")) !== false) {
					$id = mkConversation($theme); 
					$data["conversation"] = getConversation($id);
					$data["success"] = true; 
					$data["status"] = 201;
				}
			break;

			case 'POST_conversations_messages' :
				// POST /api/conversations/<id>/messages?contenu=...
				// TODO: interdire user blacklisté ?
				if ($idEntite1)
				if (($contenu = valider("contenu")) !== false) {
					$id = mkMessage($idEntite1, $connectedId, $contenu);					
					$data["message"] = getMessage($id,$idEntite1);
					$data["success"] = true; 
					$data["status"] = 201;
				}
			break; 
 
			case 'PUT_authenticate' : 
				// régénère un hash ? 
				$data["hash"] = mkHash($connectedId); 
				$data["success"] = true; 
				$data["status"] = 200;
			break; 

			case 'PUT_users' :				
				if ($idEntite1) {
					// PUT  /api/users/<id>?status=...
					if ($status = valider("status")) {
						if ($status == "blacklisted") {
							interdireUtilisateur($idEntite1);
							$data["user"] = getUser($idEntite1);
							$data["success"] = true; 
							$data["status"] = 200;
						}
						else if ($status == "authorized") {
							autoriserUtilisateur($idEntite1);
							$data["user"] = getUser($idEntite1);
							$data["success"] = true; 
							$data["status"] = 200;
						}
						else {
							// erreur 
						}
					}
				} 
				else {
					// PUT  /api/users/?password=...
					if ($connectedId)
					if ($pass = valider("password")) {
		              	if (($connectedId == 1) || ($connectedId==2)) {
							$data["feedback"] = "Il est interdit de changer ce mot de passe";
							$data["status"] = 403;
						} 
						else if (chgPassword($connectedId,$pass)) {
							$data["user"] = getUser($connectedId);
							$data["success"] = true; 
							$data["status"] = 200;
						} else {
							// erreur 
						}
					}
				}
				
			break; 

			case 'PUT_conversations' : 
				// PUT /api/conversations/<id>?theme=...
				if ($idEntite1)
				if (($theme = valider("theme")) !== false) {
					if (chgThemeConversation($idEntite1,$theme)) {
						$data["conversation"] = getConversation($idEntite1);
						$data["success"] = true; 
						$data["status"] = 200;
					} else {
						// erreur
					}
				} else if (($mode = valider("mode")) !== false) {
					if ($mode == "active") {
						reactiverConversation($idEntite1);
						$data["conversation"] = getConversation($idEntite1);
						$data["success"] = true; 
						$data["status"] = 200;
					}
					else if ($mode == "inactive") {
						archiverConversation($idEntite1);
						$data["conversation"] = getConversation($idEntite1);
						$data["success"] = true; 
						$data["status"] = 200;
					}
					else {
						// erreur 		
					} 
				}
			break; 


			case 'DELETE_users' : 
				// DELETE /api/users/<id> 
				if ($idEntite1) {
					if ($connectedId != $idEntite1) {
						$data["status"] = 403;
						$data["feedback"] = "On ne peut supprimer un utilisateur avec lequel on n'est pas connecté";
					} else {
                      	if (($idEntite1 == 1) || ($idEntite1==2)) {
							$data["status"] = 403;
							$data["feedback"] = "Il est interdit de supprimer cet utilisateur";
                        } else if (rmUser($idEntite1)) {
							$data["success"] = true;
							$data["status"] = 200;
						} else {
							// erreur 
						} 
					}
				}
			break; 

			case 'DELETE_conversations' : 
				// DELETE /api/conversations/<id>
				if ($idEntite1) {
					if (rmConversation($idEntite1)) {				
						$data["success"] = true;
						$data["status"] = 200; 
					} else {
						// erreur 
					}
				}
			break; 

			case 'DELETE_conversations_messages' : 
				// DELETE /api/conversations/<id>/messages/<id>
				if ($idEntite1)
				if ($idEntite2) {
					if (rmMessage($idEntite2, $idEntite1)) {				
						$data["success"] = true;
						$data["status"] = 200;  
					} else {
						// erreur 
					}
				}
			break; 
		} // switch(action)
	} //connected
}

switch($data["status"]) {
	case 200: header("HTTP/1.0 200 OK");	break;
	case 201: header("HTTP/1.0 201 Created");	break; 
	case 202: header("HTTP/1.0 202 Accepted");	break;
	case 204: header("HTTP/1.0 204 No Content");	break;
	case 400: header("HTTP/1.0 400 Bad Request");	break; 
	case 401: header("HTTP/1.0 401 Unauthorized");	break; 
	case 403: header("HTTP/1.0 403 Forbidden");		break; 
	case 404: header("HTTP/1.0 404 Not Found");		break;
	default: header("HTTP/1.0 200 OK");
		
}

echo json_encode($data);

?>
