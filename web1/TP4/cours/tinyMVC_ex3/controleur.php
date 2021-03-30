<?php
session_start();

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 

	$qs = "";

	// le controleur reçoit : idUser=6&action=Interdire

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
					verifUser($login,$passe); 	
				}

				// On redirigera vers la page index automatiquement
			break;

			case 'Autoriser' :

	/*	Le code suivant : 
		if ($idUser = valider("idUser"))
		réalise les traitements successifs : 
		1) appel à valider("idUser") qui renvoie false 
		OU la valeur de la donnée envoyée par l'utilisateur (protégée)
		2) $idUser = ... => déclaration et initilisation d'une variable $idUser
		3)  $idUser = valider("idUser") est une affectation 
		La valeur d'une affectation, c'est la valeur affectée 
		La valeur de ($idUser = valider("idUser")) est celle de $idUser
		4) if ($idUser = valider("idUser")) est la même chose 
			que if ($idUser) { ... }

	*/
				
				if ($idUser = valider("idUser")) {
					autoriserUtilisateur($idUser);
				}
					// pour choisir la vue, 
					// il faut envoyer un paramètre "view" 
					// à la page index, lors d'une redirection 
					$qs = "?view=users&idLastUser=$idUser";
			break; 

			case 'Interdire' :
				if ($idUser = valider("idUser")) {
					interdireUtilisateur($idUser);
				}
				$qs = "?view=users&idLastUser=$idUser";
			break; 
		}

	}

	// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
	// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
	// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat

	$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
	// die($urlBase);
	// On redirige vers la page index avec les bons arguments

	header("Location:" . $urlBase . $qs);
	//qs doit contenir le symbole '?'

	// On écrit seulement après cette entête
	ob_end_flush();
	
?>










