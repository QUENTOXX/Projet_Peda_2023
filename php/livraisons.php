<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Livreur</title>
    <link rel="stylesheet" type="text/css" href="./css/livraisons.css" href="/projet_pedago/css/Main.css">
    <script src="./js/script.js"></script>
</head>
<?php
include ("header.php");
?>
<body>
    <header>
        <h1>Mes Commandes</h1>
      </header>
    
      <div id="commandes-container">
        <div class="commande">
          <h2>Commande #1</h2>
          <p>Adresse de livraison : 123 Rue Principale, Ville, Pays</p>
          <p>Poids : 2 kg</p>
          <p>Statut : En cours de livraison</p>
        </div>
        
        <div class="commande">
          <h2>Commande #2</h2>
          <p>Adresse de livraison : 456 Rue Secondaire, Ville, Pays</p>
          <p>Poids : 1.5 kg</p>
          <p>Statut : Livré</p>
        </div>
        
        <!-- même chose mais si jamais ya plus pour vous en back-->
        
      </div>
</body>
<?php
include ("footer.php");
?>
</html>