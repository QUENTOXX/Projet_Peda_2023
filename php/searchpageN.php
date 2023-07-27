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


  $col = 'Prix';
  $filtre = "#sort_by";




?>
<body>
<h1>Résultats de recherche</h1>

<div id="filters">
  <form action = "" method = "GET"> 
    <label for="sort_by">Filtrer par:</label>
    <select id="sort_by" onchange="">
        <option value="price_high_low">Prix: Décroissant</option>
        <option value="price_low_high">Prix: Croissant</option>
    </select>
    <button type="submit" value="Filtrer" name="filtre">
</form>
</div>
<div id="container">
   <?php
       
  $search= isset($_GET['search']) ? $_GET['search'] : "";
    $res = affiche_produit($search);
    
  foreach($res as $produit){
    echo "<div class='produit'>";
    echo "<div class='resultats'>";
    echo('<img src='.$pathprod.$produit['Img'].'>');
    echo "<div class='description_produit'>";
    echo "<h3>".$produit['Nom']."</h3>";
    echo "<p>".$produit['Descript']."</p>";
    echo "<p>".$produit['Prix']."€</p>";
    echo "<p>".$produit['Quantite']." en stock</p>";
    echo "<form action='' method='POST'>";
    echo "<button class='btn' type='submit' name='commander' value=" . $produit["ID"]. ">Ajouter au panier</button>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    
    }
   

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
</div> 
</body>
</html>
<?php 
  include ("footer.php");
?>