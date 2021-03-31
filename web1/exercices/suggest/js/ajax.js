var __ajax__request = false;
var __ajax__fnCb = null;  //what is it?

// Attention : on ne peut faire qu'une seule requête à la fois
// TODO: renommer la fonction "ajax" ? 

function envoiRequete(type,url,donnees,callback)
{
	__ajax__request = new XMLHttpRequest(); 
	__ajax__fnCb = callback;

	if (type=='GET') 
	{
		__ajax__request.open("GET", url+"?"+donnees, true);
		donnees=null;
	}
	else 
	{
		__ajax__request.open("POST", url, true);
		__ajax__request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		__ajax__request.setRequestHeader("Content-length", donnees.length);
		__ajax__request.setRequestHeader("Connection", "close");
	}

	__ajax__request.onreadystatechange = __ajax__traiteReponse;
	__ajax__request.send(donnees);
}

function __ajax__traiteReponse()
{
	if (__ajax__request.readyState == 4) 
	{
	    if (__ajax__request.status == 200) 
	    {
			var donnee = __ajax__request.responseText;
			__ajax__fnCb(donnee); 
	    }
	}
} 

console.log("Chargement librairie ajax");

