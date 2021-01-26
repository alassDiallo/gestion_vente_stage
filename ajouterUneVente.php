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
   <title></title>
   <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles/css.css">
  <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="styles/bootstrap.min.css">
 </head>
 <body>
   <div class="row">
    <?php include("nav_bar.php");?>
  </div>
  <div class="row" id="contenu">
    <div class="col-md-3" style="height: 580px">
    <?php include('bar_nav.php'); ?>
  </div>
<div class="col-md-9 contenu">
  <div class="row mt-4" id="">
    <div class="col-md-4 mt-4" style="border: 2px solid  #DF2060; background: #DF2060;color:white;">
      <h4 class="text-center mt-4">Enregistrer une vente</h4><hr>
    <form id="form" action="#" onsubmit="enregistrer(event);">
   <div class="mb-3">
    <label for="libelle" class="form-label">Produit</label>
    <select class="form-select form-select-lg text-center" id="select" name="produit" required>
        <option value="">--selectionner un produit--</option>
</select>
 <span id="produit_err" class="form-text" style="color: red"></span>
  </div>
  <div class="mb-3">
    <label for="prix" class="form-label">Quantite</label>
    <input type="text" class="form-control" name="quantite" id="quantite" placeholder="entrez la quantite" required>
    <span id="quantite_err" class="form-text" style="color:red"></span>
  </div>
  <div>
    <button type="submit" class="btn btn-primary form-control mb-4">enregistrer</button>
  </div>
</form>
    </div>
   
 <div class="col-md-8 container" style="border: 0px 0px 2px 0px solid  #DF2060;">
	<h1 class="text-center mt-4">Detail ventes</h1><hr/>

  <table class="table text-center table-bordered table-striped mt-4" id="tab" cellspacing="0" width="100%">
  <thead>
    <tr>
     
      <th scope="col">libelle</th>
      <th scope="col">prix</th> 
      <th scope="col">quantite Commander</th> 
      <th>quantite x prix</th>
     
    </tr>
  </thead>
  <tbody id="tbody">
  
  </tbody>
</table>
<div style="margin-top: 100px;">
  <form onsubmit="validerCom(event);" id="vente">
    <div class="col-md-10 input-group mb-3">
   <h4>Total de la vente : </h4>
  <input type="text" class="form-control ml-2" value="0" id="total" name="total">
  <span class="input-group-text" id="basic-addon2">.00 Franc CFA</span> 
</div>
<button type="submit" class="col-md-6 btn btn-primary form-control ml-2 mb-4">Terminer la vente</button>
  </div>
  <div>
   
  </div>
    </div>
  </form> 
</div>
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
  var erreur=false;
  $(document).ready(function(){

    $.ajax({
      url:"http://localhost/stage/gestion_vente/index.php?action=liste",
      type:"GET",
      dataType:"JSON",
      success:function(data){
        data.forEach(e=>{
           $('#select').append("<option value="+e.idProd+">"+e.libelle+"</option>");
        });
       

      },
      error:function(xrh,statusText,error){
        alert(error);
      }
    });

   $('#quantite').on('keypress',function(event){
    console.log(event.charCode);
   if(event.keyCode <46 || event.keyCode>57){
    return false;
  }
   });


  });
  console.log($("#vente").val());
  

  function enregistrer(event){
    event.preventDefault();
   if($('#quantite').val()==="" || $('#quantite').val()==="0"){
    erreur=true;
    $('#quantite').addClass("is-invalide");
    $('#quantite_err').text("veillez choisir la quantite et elle doit etre superieur a 0");

   }
   else{
    erreur=false;
    $('#quantite').removeClass("is-invalide");
    $('#quantite_err').text("");
   }
   if($('#select').val()===""){
    erreur=true;
    $('#select').addClass("is-invalide");
    $('#produit_err').text("veillez choisir un produit");

   }
   else{
   erreur=false;
   $('#select').removeClass("is-invalide");
    $('#produit_err').text("");
   }
   if(!erreur){

    $.ajax({
      url:"http://localhost/stage/gestion_vente/index.php?action=ajoutProdVente",
      type:"POST",
      data:$('#form').serialize(),
      dataType:"JSON",
      success:function(data){
          console.log(data);
          var ligne="<tr>"+
                    "<td>"+data.libelle+"</td>"+
                    "<td>"+data.prix+"</td>"+
                    "<td>"+data.quantite+"</td>"+
                    "<td>"+(data.prix*data.quantite)+"</td>"+
                    "</tr>";

          $('#tbody').append(ligne);
          $('#select').val("");
          $('#quantite').val("");
          $('#total').val(parseInt($('#total').val())+(data.prix*data.quantite));
      },
      error:function(xrh,statusText,error){
        alert(error);
      }
    });
  }
  
  }

  function validerCom(event){
    event.preventDefault();
   $.ajax({
      url:"http://localhost/stage/gestion_vente/index.php?action=enregistrerVente",
      type:"POST",
      data:$('#vente').serialize(),
      dataType:"JSON",
      success:function(data){
        $('#tbody').remove();
        $('#total').val("0");
        console.log(data);
      },
      error:function(xrh,statusText,error){
          console.log(error);
      }
    });
  }
</script>
</body>
</html>
<?php } ?>