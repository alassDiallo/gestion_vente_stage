<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Page de connexion</title>
	<link rel="stylesheet" href="styles/css.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<style type="text/css">
		
	</style>
</head>
<body id="bd">
<div class="container row bd-primary" id="b">
	<h3 class="text-center mb-4 mt-4">Authentifiez-vous</h3><hr/>
	<?php
		if(isset($_GET["message"])){
			echo "<span class='alert alert-danger text-center'>".$_GET["message"]."</span>";
		}
	?>
	<form action="index.php?action=connexion" method="POST">
  <div class="mb-3">
    <label for="username" class="form-label">Login</label>
    <input type="text" class="form-control" id="username" aria-describedby="userHelp" placeholder="entrez votre nom utilisateur" name="username">
    <span id="userlHelp" class="form-text"></span>
  </div>
  <div class="mb-3">
    <label for="motDePass" class="form-label">Mot de passe</label>
    <input type="password" class="form-control" id="motDePass" placeholder="entrez votre mot de passe" name="motDePass">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">se souvenir de moi</label>
  </div>
  <button type="submit" class="btn btn-primary form-control">Se Connecter</button>
</form>
<span class="text-center mt-4 mb-4"><a href="#">mot de passe oublier</a></span>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>