<?php
/**
 * fichier à mettre dans le dossier www
 */

session_start();

/*
Cette page génère les différentes vues de l'application en utilisant des templates situés dans le répertoire "templates". Un template ou 'gabarit' est un fichier php qui génère une partie de la structure XHTML d'une page. 

La vue à afficher dans la page index est définie par le paramètre "view" qui doit être placé dans la chaîne de requête. En fonction de la valeur de ce paramètre, on doit vérifier que l'on a suffisamment de données pour inclure le template nécessaire, puis on appelle le template à l'aide de la fonction include

Les formulaires de toutes les vues générées enverront leurs données vers la page data.php pour traitement. La page data.php redirigera alors vers la page index pour réafficher la vue pertinente, généralement la vue dans laquelle se trouvait le formulaire. 
*/


	include_once "libs/maLibUtils.php";

	// Dans tous les cas, on affiche l'entete, 
	// qui contient les balises de structure de la page, le logo, etc. 
	// Le formulaire de recherche ainsi que le lien de connexion 
	// si l'utilisateur n'est pas connecté 

	// charge le header
	include("templates/header.php");

	// on récupère le paramètre view éventuel  (la foncition se trouve dans la librairie maLibUtils.php)
	$view = valider("view"); 

	//la fonction valider corresponde a ça:

	/*
	if(isset($_GET["view"]) && ($_GET["view"] != ""))
		$view= $_GET["view"];
	else  
		$view =false;
	*/

	// S'il est vide, on charge la vue accueil par défaut
	if (!$view) $view = "accueil"; 

	// En fonction de la vue à afficher, on appelle tel ou tel template
	switch($view)
	{		

		case "accueil" : 
			include("templates/accueil.php");
		break;

		case "login" : 
			include("templates/login.php");
		break; 

		case "users" : 
			include("templates/users.php");
	
		case "conversations":
		case "conversation":
			include("templates/conversations.php");
		break;

		default : // si le template correspondant à l'argument existe, on l'affiche
			if (file_exists("templates/$view.php"))
				include("templates/$view.php");
			//quand il n'exite pas le fichier
			else
				include("templates/error.php");

	}


	// Dans tous les cas, on affiche le pied de page
	// Qui contient les coordonnées de la personne si elle est connectée
	include("templates/footer.php");


	
?>
