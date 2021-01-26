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
  <title>Gestion vente</title>
   <meta charset="utf-8">
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
  <div class="row" id="contenu">
    <div class="col-md-3">
    <?php include('bar_nav.php'); ?>
  </div>
<div class="col-md-9 box mt-4 container">
<h1 class="text-center mt-4">Liste des ventes effectuées</h1><hr/>
<a class="btn btn-success mb-4" href="ajouterUneVente.php">
 <i class="fa fa-plus mr-4"></i>Effectuer une vente
</a>
<table class="table text-center hover" id="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">total vente</th>
      <th scope="col">Date et heures de vente</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>
</div>
</div>
<script type="text/javascript" src="js/control_form_prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

<script type="text/javascript" src="js/jquery-3.5.1.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap.bundle.js"></script>

<script type="text/javascript" src="js/DataTables/datatables.min.js"></script>
<script type="text/javascript">
  var table;
  $(document).ready(function(){
     table = $('#table').DataTable({
        "ajax":{
          "url":"http://localhost/stage/gestion_vente/index.php?action=vente",
          "type":"GET",
        },
        "columns":[
            {data:"0"},
            {data:"1"},
            {data:"2"},
            {data:"3"},

        ],
        "language": {
                "url": "js/DataTables/French.json"
            }
     })
  })

  function voir(id){

    $.ajax({
      url:"http://localhost/stage/gestion_vente/index.php?action=voirvente&idVente="+id,
      type:"GET",
      success:function(data){
        console.log(data);
      },
      error:function(xrh,statusText,error){
        alert(error);
      }
    })
    $('#exampleModal').modal('show');
  }
 
</script>
<!-- Modal -->

<div class="modal fade col-md-12 col-xs-12" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog"  style="width:60%">
    <div class="modal-content">
      <div class="modal-header arriereplan">
        <h5 class="modal-title" id="exampleModalLabel">Detail Vente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <table class="table table-bordered">
         <thead>
           <th>#</th>
           <th>libelle</th>
           <th>quantite</th>
           <th>prix</th>
           <th>quantite * prix</th>
         </thead>
         <tbody>
           
         </tbody>
       </table>
      </div>
    </div>
  </div>
</div>
</body>
</html>
<?php } ?>
