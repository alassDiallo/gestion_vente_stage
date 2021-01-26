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
  <title>Gestion produit</title>
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
  <div class="row" id="contenu">
    <div class="col-md-3">
    <?php include('bar_nav.php'); ?>
  </div>  
 <div class="col-md-9 box mt-4 container" >
<h1 class="text-center mt-4" >gestion produit</h1><hr/>
<button type="button" class="btn btn-success mb-4 glyphicon glyphicon-plus" onclick="ajoutProduit()" ><i class="fa fa-plus"></i>
  ajouter un produit
</button>
<table class="table text-center table-bordered table-striped mt-4 mb-4" id="tab" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th scope="col">#</th>
       <th scope="col">ID</th>
      <th scope="col">libelle</th>
      <th scope="col">Description</th>
      <th scope="col">prix</th>    
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

<script type="text/javascript" src="js/DataTables/datatables.min.js"></script>



<script type="text/javascript">


    var erreur=false;
    var save_method; //for save method string
    var table;
    $(document).ready(function() {
      table=$('#tab').DataTable({
       // "processing": true,
        //"serverSide":true,
        "ajax":{
          "url":"http://localhost/stage/gestion_vente/index.php?action=listeProd",
          "type":"GET",
        },
        "columns":[
          {data:'0'},
          {data:'1'},
          {data:'2'},
          {data:'3'},
          {data:'4'},
          {data:'5'},
        ],
        "columnDefs": [
        { 
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },
        ],
        //pageLength:2,
        lengthMenu:[5,10,25,100],
        "language": {
                "url": "js/DataTables/French.json"
            }
       

      
      });

    $("#libelle").on("keypress",function(event){
    console.log(event.charCode);
   if(event.keyCode >45 && event.keyCode<=57){
            return false;
  }
})

    $("#libelle").on("input",function(event){
    
    if(event.target.value.length<3){
      $('#libelle').addClass("is-invalid");
      $('#libelle_err').text("le libelle doit contenir au moins 3 caractere");
    }
    else{
      $('#libelle').removeClass("is-invalid");
      $('#libelle_err').text("");
    }
})

    $("#prix").on("keypress",function(event){
    console.log(event.charCode);
   if(event.keyCode <46 || event.keyCode>57){
    return false;
  }
})
});


function ajoutProduit()
    {
      save_method = 'ajouter';
      $('#form')[0].reset(); // reset form on modals
      $('#exampleModal').modal('show'); // show bootstrap modal
      $('.modal-title').text('Ajouter un produit'); // Set Title to Bootstrap modal title
    }

   function modifier(id){
      save_method="modifier";
      $('.modal-title').text('Modifeir le produit');
      $('#form')[0].reset();

      $.ajax({
        url:"http://localhost/stage/gestion_vente/index.php?action=modifierProd&id="+id,
        type:"GET",
        dataType:"JSON",
        success:function(data){
          console.log(data);
          $('#libelle').val(data.libelle);
          $('#description').val(data.description);
          $('#prix').val(data.prix);
          $('#id').val(data.idProd);
          $("#exampleModal").modal('show');
        },
        error:function(xrh,statusText,error){
          console.log(error);
        }
      })
     }

    function enregistrer(event){
        event.preventDefault();
        var url;
        if(save_method==="ajouter"){
          url="http://localhost/stage/gestion_vente/index.php?action=enregistrerProd";
        }
        else{
            url="http://localhost/stage/gestion_vente/index.php?action=enregistrerModifProd";
        }

    if($('#libelle').val()===""){
          erreur=true;
        $('#libelle').addClass("is-invalid");
         $('#libelle_err').text("veuillez-remplir le champs");
    }
    else{
      erreur=false;
      $('#libelle').removeClass("is-invalid");
       $('#libelle_err').text("");
    }

    if($('#prix').val()===""){
         erreur=true;
         $('#prix').addClass("is-invalid");
         $('#prix_err').text("veuillez-remplir le champs");
    }
    else{
        erreur=false;
        $('#prix').removeClass("is-invalid");
       $('#prix_err').text("");
    }

   if($('#description').val()===""){
          erreur=true;
          $('#description').addClass("is-invalid");
         $('#description_err').text("veuillez-remplir le champs");
    }
    else{
      $('#description').removeClass("is-invalid");
      erreur=false;
       $('#description_err').text("");
    }
    if(!erreur){
        data=$('#form').serialize();
       $.ajax({
        url:url,
        type:"POST",
        data:data,
        dataType:"JSON",
        success:function(data){
              console.log(data);
             reload_table();
            $("#exampleModal").modal('hide');
           
        },
        error:function(xrh,statusText,error){
          alert(error);
        }
       })
         //$('#tab').dataTable.ajax.reload(null,false);
       }
     }

function reload_table(){
  table.ajax.reload(null,false);
}
      function supprimer(id){
        if(confirm('voulez-vous vraiment supprimer ce produit ?')){
       
        $.ajax({
          url:"http://localhost/stage/gestion_vente/index.php?action=supprimerProduit&id="+id,
          type:"GET",
          dataType:"JSON",
          success:function(data){
            reload_table();
            console.log(data);
            
          },
          error:function(xhr,statusText,error){
            console.log(error);
          }
        })
      }
    }

  </script>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-center arriereplan">
        <h5 class="modal-title text-center" id="exampleModalLabel">Ajouter un produit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <span id="erreur_serveur"></span>
      <form id="form" action="#" onsubmit="enregistrer(event);">
        <input type="hidden" value="" id="id" name="id"/> 
   <div class="mb-3">
    <label for="libelle" class="form-label">Libelle</label>
    <input type="text" class="form-control c" name="libelle" id="libelle" aria-describedby="emailHelp" placeholder="entrez le libelle du produi">
    <span id="libelle_err" class="form-text helper" style="color:red;"></span>
  </div>
  <div class="mb-3">
    <label for="prix" class="form-label">Prix</label>
    <input type="text" class="form-control" name="prix" id="prix" placeholder="entrez le prix">
    <span id="prix_err" class="form-text helper" style="color:red;"></span>
  </div>
  <div class="mb-3">
    <label for="description" class="form-label c">Description</label>
    <textarea class="form-control" id="description" name="description"></textarea>
    <span id="description_err" class="form-text helper" style="color:red;"></span>
  </div>
      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary" data-bs-dismiss="">annuler</button>
        <button type="submit" class="btn btn-primary">enregistrer</button>
      </div>
    </div>
  </div>
</div>
 </body>
 </html>
 <?php } ?>