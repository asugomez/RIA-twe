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
				$qs = "?view=login&msg=" . urlencode("il y a rien :(");
				if ($login = valider("login"))
				if ($passe = valider("passe"))
				{
					// On verifie l'utilisateur, et on crée des variables de session si tout est OK
					// Cf. maLibSecurisation
					//verifUser envoie true si le user est connecté
					if(verifUser($login,$passe)){
						$qs = "?view=accueil";

					} else{
						$qs = "?view=login&msg=" . urlencode("IDentifiants incorrects");

					}
				}

				// On redirigera vers la page index automatiquement
			break;

			case 'Logout':
				session_destroy();
				
				$qs = "?view=login&msg=" . urlencode("À bientôt!");
			
			break;

			case 'Autoriser':
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

			//TODO: NEVER TRUST USER INPUT!
			//il faut verifier que l'utilisateur n'est pas admin

			

			case 'Archiver': 
				if ($idConv = valider("idConv")) {
					archiverConversation($idConv);
				}
				$qs = "?view=conversations&idLastConv=$idConv" ;
			break ;
			case 'Réactiver': 
				if ($idConv = valider("idConv")) {
					reactiverConversation($idConv);
				}
				$qs = "?view=conversations&idLastConv=$idConv";
				
			break ;
			case 'Supprimer': 
				if ($idConv = valider("idConv")) {
					supprimerConversation($idConv);
				}
				$qs = "?view=conversations&idLastConv=$idConv";
			break ; 

			case 'Creer': 
				if ($theme = valider("theme")) {
					$idConv = creerConversation($theme);
				}
				$qs = "?view=conversations&idLastConv=$idConv";
			break ;


			case 'Poster': 
				// NEVER TRUST USER INPUT 
				if ($idConv = valider("idConv"))
				if ($contenu = valider("contenu")) 
				if ($idAuteur = valider("idUser","SESSION")){
					$dataConv = getConversation($idConv); 
					if ($dataConv["active"] == 1) { 
						// la conversation ne doit pas etre archivee 
						enregistrerMessage($idConv, $idAuteur, $contenu);
						// attention aux failles XSS 
						// il ne faut pas permettre l'enregistrement de js 
					}
				}
				$qs = "?view=chat&idConv=$idConv";
			break ;

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










