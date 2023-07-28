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

include_once ('fonction.php');
session_start();

if (isset($_SESSION['Connexion'][0])) {
  if ($_SESSION['Connexion'][1] == 'client') {
      $id_client = $_SESSION['Connexion'][0];
      if (isset($_POST['commander'])) {
          ajout_panier($_POST['commander'], $id_client, 1);
      
      }
  }
}

$decroissant = "";
$croissant = "";

if(isset($_POST['deconnect'])){
    deconnexion();
    header('Location: /projet_pedago/php/accueil.php');
}

if(isset($_POST['submit'])){
  $search= isset($_POST['search']) ? $_POST['search'] : "";  
  //$_GET['search']
    header('Location: /projet_pedago/php/searchpageN.php?search='.$search);
}

if (!isset($_SESSION['Connexion'][0])) {
  $button = "<a href='/projet_pedago/php/connexion.php'>Connexion</a>";
}
else{
  $button = "<a href='/projet_pedago/php/AccountC.php'>Compte</a>";
}

$col = 'Prix';
$filtre = "#sort_by";

$search= isset($_GET['search']) ? $_GET['search'] : "";
$prixMIN= isset($_GET['prixMIN']) ? $_GET['prixMIN'] : 0;
$prixMAX= isset($_GET['prixMAX']) ? $_GET['prixMAX'] : 10000;

if (isset($_GET['tri']) && $_GET['tri'] == "price_high_low"){
  $res = filtre_produit($search, $prixMIN, $prixMAX, "DESC");
  $decroissant = 'selected';
} elseif (isset($_GET['tri'])  && $_GET['tri'] == "price_low_high"){
  $res = filtre_produit($search, $prixMIN, $prixMAX, "ASC");
  $croissant = 'selected';
} else {
  $res = filtre_produit($search, $prixMIN, $prixMAX);
}

?>
<header>
    <nav> 
        <div class="hcontainer">
            <a href="/projet_pedago/php/accueil.php" class="logo">New Amazony</a>
            <ul class="navigation">
                <li><?php print($button) ?></li>
                <li><a href="/projet_pedago/php/Panier.php">Panier</a></li>
                <?php 
                if(isset($_SESSION['Connexion'][0])){
                    print('<li><form id="deconnexion" action="/projet_pedago/php/accueil.php" method="POST">
                        <button class="nav-button" type="submit" name="deconnect" value="deconnect">Déconnexion</button></form></li>');
                }
                ?>
            </ul>
        </div>
    </nav>
</header>
<body>
<div id="filters">
  <form action = "" method = "GET"> 
  <div class="search-bar">
    <input type="text" name="search" placeholder="Recherche" value ="<?php echo(htmlspecialchars($search));?>">
    <button id ="loupe_loupe"type="submit" name="submit">
      <img id="loupe" src="/projet_pedago/img/loupe.png" alt="img.png"> 
    </button>
  </div><br>
    <label for="sort_by">Filtrer par:</label>
    <h5>Prix</h5>
    <select id="sort_by" name="tri">
        <option value="prixDefault" name="prixDefault"> - </option>
        <option <?php echo($decroissant) ?> value="price_high_low" >Décroissant</option>
        <option <?php echo($croissant) ?> value="price_low_high" >Croissant</option>
    </select>
    <div>
    <h5>Prix MIN</h5><input type="number" min='0' step='1' name="prixMIN" value=<?php echo($prixMIN) ?>>
    <h5>Prix MAX</h5><input type="number" max='10000' step='1' name="prixMAX" value=<?php echo($prixMAX) ?>>
    </div>
</form>
</div>
<h1>Résultats de recherche</h1>
<div id="container">
   <?php

    
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
?>   
</div> 
</body>
</html>
<?php 
  include ("footer.php");
?>