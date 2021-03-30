<?php
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
	include("templates/header.php");

	// on récupère le paramètre view éventuel 
	$view = valider("view"); 

/* équivalent à : 
	if (	isset($_GET["view"]) 
			&& ($_GET["view"] != "")
		) 
		$view = $_GET["view"];
	else 
		$view = false; 
*/

	// S'il est vide, on charge la vue accueil par défaut
	if ($view === false ) $view = "accueil"; 

	// opérateur == : forcage de type
	// : on ne compare que les valeurs 
	// (false == 0) est vrai 

	// opérateur === : comparaison des types, puis des valeurs 
	// (false === 0) est faux 
	// car false est un booléen	et "0" est une chaine 
	// (0 est un entier) 

	// En fonction de la vue à afficher, on appelle tel ou tel template
	switch($view)
	{		

/* inutile 
		case "accueil" : case "Accueil" : 
			include("templates/accueil.php");
		break;

		case "login" : 
			include("templates/login.php");
		break; 

		case "users" : 
			include("templates/users.php");
		break;

		case "conversations" : 
		case "conversation" :
			include("templates/conversations.php");
		break;

*/

		default : // si le template correspondant à l'argument existe, on l'affiche
			if (file_exists("templates/$view.php"))
				include("templates/$view.php");
			else 
				include("templates/error.php");

	}


	// Dans tous les cas, on affiche le pied de page
	// Qui contient les coordonnées de la personne si elle est connectée
	include("templates/footer.php");


	
?>
