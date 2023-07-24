<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Searchpage</title>
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/searchpagecss.css">
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/Main.css">
</head>
<?php
  include ("header.php");
?>
<body>
<div id="container">
      <h1>Résultats de recherche</h1>

      <div id="filters">
          <label for="sort_by">Filtrer par:</label>
          <select id="sort_by">
              <option value="pertinence">Pertinence</option>
              <option value="price_high_low">Prix: Décroissant</option>
              <option value="price_low_high">Prix: Croissant</option>
          </select>
      </div>

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
</body>
</html>
<?php 
  include ("footer.php");
?>