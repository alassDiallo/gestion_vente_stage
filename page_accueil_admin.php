<?php
session_start();
	if(! isset($_SESSION["login"])){
		header("location:index.php");
	} 
	else{


?>

<!DOCTYPE html>
<html>
<head>
	<title>Page acceuil Administrateur</title>
 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles/css.css">
  <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="styles/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 </head>
 <body>
  <div class="row">
    <?php include("nav_bar.php");?>
  </div>
  <div class="row">
    <div class="col-md-3" style="height: 600px;">
    <?php include('bar_nav.php'); ?>
  </div>  
 	<div class="col-md-8 " style="margin-top: 100px;">
      <div class="mt-4 row" >
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
              <i class="fa fa-cart-plus ml-4"></i>
              <div class="count" id="nbrp"></div>
              <div class="title"><h4>Produits</h4>
              </div><!--/.info-box-->
          </div>
      </div><!--/.col-->

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <div class="info-box orange-bg">
            <i class="fa fa-balance-scale ml-4"></i>
            <div class="count" id="nbrv"></div><br/>
            <div class="title"><h4 class="">ventes</h4>
            </div>
          </div><!--/.info-box-->
        </div>
 	</div>
 </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

<script type="text/javascript" src="js/jquery-3.5.1.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	$.ajax({
		url:"http://localhost/stage/gestion_vente/index.php?action=total",
		type:"GET",
		dataType:"JSON",
		success:function(data){
			console.log(data);
			$('#nbrp').text(data.tp);
			$('#nbrv').text(data.tv);

		},
		error:function(xhr,statusText,error){
			alert(error);
		}
	})
	})
</script>
</body>
</html>
<?php
	} 
?>