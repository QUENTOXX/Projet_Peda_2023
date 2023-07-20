<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Searchpage</title>
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/searchpagecss.css" href="/projet_pedago/css/Main.css">
</head>
<?php
  include ("header.php");
?>
<body>
   <h1>Résultats de recherche</h1>
   <?php

  $search= isset($_GET['search']) ? $_GET['search'] : "";
  affiche_produit($search);

  if (isset($_SESSION['Connexion'][0])) {
    if ($_SESSION['Connexion'][1] == 'client') {
        $id_client = $_SESSION['Connexion'][0];
        if (isset($_POST['commander'])) {
            var_dump($_POST['commander']);
            ajout_panier($_POST['commander'], $id_client, 1);
        
        }
    }
}
?>    
  <!--
        </div>
        <div id="pagination">
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">4</a>
            <a href="#">5</a>
          </div>
       --> 
      </body>
<?php 
  include ("footer.php");
?>