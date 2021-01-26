<?php
try{
	$con = new PDO('mysql:host=localhost;dbname=stage_gestion_vente','root','');
}
catch(PDOException $e){
	echo $e->getMessage();
}

//$con=null;