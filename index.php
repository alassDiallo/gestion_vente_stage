<?php
require("controller.php");
if(isset($_GET["action"])){
	$action=$_GET["action"];
	if($action==="connexion"){
		connexion();
	}

	if($action==="deconnexion"){
		session_start();
		session_destroy();
		header("location:index.php");
	}

	if($action==="listeProd"){
		listeProd();
	}
	if($action==="liste"){
		listeProds();
	}

	if($action==="enregistrerProd"){
		//echo $_POST["libelle"];
		enregistrerProd();
		//return;
	}
if($action==="supprimerProduit"){
	if(isset($_GET['id'])){

		supprimerProduit($_GET['id']);
	}
}

if($action==="modifierProd"){

	if(isset($_GET['id'])){

		modifierProduit($_GET['id']);
	}
	
}

if($action==="voirvente"){
	if(isset($_GET['idVente'])){

		voirdetail($_GET['idVente']);
	}
}

if($action==="enregistrerModifProd"){
		
		enregistrerModifProd();
}

if($action==="vente"){
	listerVente();
}

if($action==="ajoutProdVente"){
	ajoutProdVente();
}

if($action==="enregistrerVente"){
	enregistrerVente();
}

if($action==="total"){
	total();
}

}
else{
	$message = "vous etes a l'accueil";
	require("page_accueil.php");
}