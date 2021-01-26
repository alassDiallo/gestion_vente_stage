<?php

require("connexion.php");

function enregistrerProd(){

	$libelle=$_POST["libelle"];
	$prix = $_POST["prix"];
	$description = $_POST["description"];
	if(!empty($libelle) && !empty($prix) && !empty($description)){


	if($prix<0){
		echo "le prix doit etre superieur a 0";
	}
	else{

		//$tab = ['libelle'=>$libelle,'prix'=>$prix,'description'=>$description];

		//echo json_encode($tab);
		require("connexion.php");
		$req = "insert into produit values('".$libelle."','".$description."','".$prix."')";
		try{
			$req=$con->prepare("insert into produit(libelle,description,prix) values(:libelle,:description,:prix)");
			$result=$req->execute(array('libelle'=>$libelle,'description'=>$description,'prix'=>$prix));
			$tab=[];
		$req = "select * from produit where idProd=(select max(idProd) from produit)";
		$r=$con->query($req);
				while($res=$r->fetch()){
				$tab=['idProd'=>$res['idProd'],
						'libelle'=>$res['libelle'],
						'description'=>$res['description'],
						'prix'=>$res['prix']
					];
			}
			echo json_encode($tab);

		}
		catch(SQLSTATE $e){
			die("Erreur ".$e.getMessage());
		}


	}
		}else{
			echo "veullez renseigner tous les champs";
		}
}

function supprimerProduit($id){
	require("connexion.php");
	$req =$con->prepare("delete from produit where idProd=:id");
	$req->execute(['id'=>$id]);
	//header("location:index.php?action=listeProd");
	echo json_encode("produit supprimer avec success");

}

function modifierProduit($id){
	require("connexion.php");
	$req= $con->prepare("select * from produit where idProd=:id");
	$req->execute(["id"=>$id]);
	$data=array();
	while($resultat= $req->fetch()){
		$data=[
				"idProd"=>$resultat["idProd"],
				"libelle"=>$resultat["libelle"],
				"description"=>$resultat["description"],
				"prix"=>$resultat["prix"]
			];
	}
	echo json_encode($data);
}

function enregistrerModifProd(){

	$libelle=$_POST["libelle"];
	$prix = $_POST["prix"];
	$description = $_POST["description"];
	$id=$_POST["id"];
	if(!empty($libelle) && !empty($prix) && !empty($description)){


	if($prix<0){
		echo json_encode("le prix doit etre superieur a 0");
	}
	else{

		//$tab = ['libelle'=>$libelle,'prix'=>$prix,'description'=>$description];

		//echo json_encode($tab);
		require("connexion.php");
		$req = "update produit set libelle='".$libelle."',description='".$description."',prix='".$prix."' where idProd='".$id."'";
				$con->query($req);
			echo json_encode("modification effectuer avec success");

	}
		}else{
			echo json_encode("veullez renseigner tous les champs");
		}

		//echo json_encode(["id"=>$id]);
}

function connexion(){
	$login=$_POST["username"];
	$mp = $_POST["motDePass"];
	$nbr;
	require("connexion.php");
	$re="select count(*) from admin where login='".$login."' and motDePasse='".$mp."'";
	if($r=$con->query($re)){
		while($rs=$r->fetch()){
			$nbr=$rs[0];
		}
		if($nbr>0){
		$req="select * from admin where login='".$login."' and motDePasse='".$mp."'";
		$rsl=$con->query($req);
		while($rs=$rsl->fetch()){
			session_start();
			$_SESSION['login']=$login;
			header("location:page_accueil_admin.php");
		}
		
	}
	else{
			header("location:page_accueil.php?message=login ou mot de passe incorrect");
		}
	
	
	
}

}
function listeProd(){
	require("connexion.php");

//echo $con;
	$data=array();
	$req = "select * from produit order by libelle";
	$resultat =$con->query($req);
	$i=1;
	while($resul = $resultat->fetch()){
		$row=array();
		$i++;
		$row[]=$i;
		$row[]=$resul["idProd"];
		$row[]=$resul["libelle"];
		$row[]=$resul["description"];
		$row[]=$resul["prix"];
		$row[]='<a class="btn btn-sm btn-primary" href="javascript:void();" title="Edit" onclick="modifier('."'".$resul["idProd"]."'".');"><i class="glyphicon glyphicon-pencil"></i> Modifier</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void();" title="Hapus" onclick="supprimer('."'".$resul["idProd"]."'".');"><i class="glyphicon glyphicon-trash"></i> Supprimer</a>';
		
	$data[] = $row;
	}
	$ret = array(
		"draw"=>1,
		"recordsTotal"=>count($data),
		"recordsFiltered"=>count($data),
		"data"=>$data
	);
	echo json_encode($ret);
	$con=null;
	//require("gestion_produits.php");
}
function listeProds(){
	require("connexion.php");
	$req = "select * from produit";
	$resultat=$con->query($req);
	$tab=[];
	while($resul = $resultat->fetch()){
		$tab[]=["idProd"=>$resul["idProd"],"libelle"=>$resul["libelle"]];
		//$row[]=;
	//$tab[]=$row;
	}
	echo json_encode($tab);
}

	function listerVente(){

		require("connexion.php");
		$req = "select * from vente";
		$resultat = $con->query($req);
		$data=array();
		$i=0;
		while($r=$resultat->fetch()){
			$row=array();
			$i++;
			$row[]=$i;
			$row[]=$r["totalVente"];
			$row[]=$r["date"];
			$row[]='<a class="btn btn-sm btn-primary" href="javascript:void();" title="voir" onclick="voir('."'".$r["idVente"]."'".');"><i class="fa fa-eye"></i> voir</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void();" title="Hapus" onclick="supprimer('."'".$r["idVente"]."'".');"><i class="glyphicon glyphicon-trash"></i> Supprimer</a>';

			$data[]=$row;
		}

		$ret = array(
			"draw"=>1,
			"recordsTotal"=>count($data),
			"recordsFiltered"=>count($data),
			"data"=>$data
		);
		echo json_encode($ret);
	}

	function ajoutProdVente(){
	require('connexion.php');
	$data=[];
	$req="select max(idVente) from vente";
	$re=$con->query($req);
	$id;
	while($r=$re->fetch()){
		$id=$r[0];
	}
	$idProd=$_POST['produit'];
	$q=$_POST['quantite'];
	$aj=$con->prepare("insert into venteeffectuer values(:id,:idProd,:q)");
	$aj->execute(['id'=>($id+1),'idProd'=>$idProd,'q'=>$q]);
	$req1="select p.libelle,p.prix,ve.quantiteVendu,sum(ve.quantiteVendu*p.prix) as t from produit p,venteeffectuer ve where p.idProd=ve.idProd and ve.idVente='".($id+1)."' and ve.idProd='".$idProd."'";
	//echo $req1;
	$res=$con->query($req1);
	while($rt=$res->fetch()){
		$data=[
			"libelle"=>$rt[0],
			"prix"=>$rt[1],
			"quantite"=>$rt[2]
		];
	}

	
		echo json_encode($data);
}

function enregistrerVente(){
	$totalVente=$_POST["total"];
	$date=date("Y-m-d H:i:s");
	$total=1000;
	require('connexion.php');
	$req=$con->prepare("insert into vente(totalVente,date) values(:totalVente,:date)");
	$req->execute(["totalVente"=>$totalVente,"date"=>$date]);

	echo json_encode("commande enregistrer avec success");
}


function voirdetail($idVente){

/*$req1="select p.libelle,p.prix,ve.quantiteVendu,ve.quantiteVendu*p.prix as t,v.totalVente,v.date from produit p,venteeffectuer ve,vente v where p.idProd=ve.idProd and v.idVente='"$idVente."' and ve.idVente=v.idVente";
	//echo $req1;
	$res=$con->query($req1);
	while($rt=$res->fetch()){
		$data=[
			"libelle"=>$rt[0],
			"prix"=>$rt[1],
			"quantite"=>$rt[2]
		];
	}

	
		echo json_encode($data);*/

}

function total(){

	require('connexion.php');
	$rp="select count(*) from produit";
	$tp;
	$rep=$con->query($rp);
	while($reps=$rep->fetch()){
		$tp = $reps[0];
	}

	$rv="select count(*) from vente";
	$tv;
	$rev=$con->query($rv);
	while($revs=$rev->fetch()){
		$tv = $revs[0];
	}
	echo json_encode(array("tp"=>$tp,"tv"=>$tv));
}
?>