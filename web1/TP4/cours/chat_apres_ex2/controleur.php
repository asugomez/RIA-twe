<?php
session_start();

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 

	$qs = "";

	if ($action = valider("action"))
	{
		ob_start ();

		echo "Action = '$action' <br />";

		// ATTENTION : le codage des caractères peut poser PB 
		// si on utilise des actions comportant des accents... 
		// A EVITER si on ne maitrise pas ce type de problématiques

		/* TODO: exercice 4
		// Dans tous les cas, il faut etre logue... 
		// Sauf si on veut se connecter (action == Connexion)

		if ($action != "Connexion") 
			securiser("login");
		*/

		// Un paramètre action a été soumis, on fait le boulot...
		switch($action)
		{
			
			// Connexion //////////////////////////////////////////////////


			case 'Connexion' :
				// On verifie la presence des champs login et passe
				if ($login = valider("login"))
				if ($passe = valider("passe"))
				{
					// On verifie l'utilisateur, et on crée des variables de session si tout est OK
					// Cf. maLibSecurisation
					//die(verifUser($login,$passe));
					verifUser($login,$passe);
				}
			break;

			case 'Logout': case 'logout':
				session_destroy();
				$qs = "?view=login";


			case 'Autoriser' : case 'autoriser':
				//récupérer id
				//if($idUser){
				//simple egal (=) --> pour être sur d'un truc que j'ai pas compris
				//TODO: pourquoi simple égal?
				if($idUser = valider("idUser")){
					/**
					 * 1) execution de valider("idUser")
					 * 2) affectation de la valeur à la variable $idUser
					 * 3) test de la variable $idUser
					 * 
					 * la valeur d'une affefctation, c'est la valeur affectée
					 */
					autoriserUtilisateur($idUser);
				}

				//on ajoute avec &
				// $idUser ==false --> idLastUSer sera egañ à rien du tout xd
				$qs = "?view=users&idLastUser=$idUser";
				

			// On redirigera vers la page index automatiquement
			break;

			case 'Interdire' : case 'interdire':
				if($idUser = valider("idUser")){
					interdireUtilisateur($idUser);
				}
				//TODO: qs for querystring fait quoi?
				$qs = "?view=users&idLastUser=$idUser";

			break;
		}

	}

	// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
	// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
	// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat

	$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
	// On redirige vers la page index avec les bons arguments

	header("Location:" . $urlBase . $qs);
	//qs doit contenir le symbole '?'

	// On écrit seulement après cette entête
	ob_end_flush();
	
?>










