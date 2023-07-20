<!DOCTYPE html>
<html>

<head>
    <title>Mes Produits</title>
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/mes_produitscss.css">
</head>
<?php
  include ("header.php");
?>

<body>
<h1>Mes produits</h1>
    <form class="product-form">
<h2>Ajouter un produit</h2>
<label for="product-name">Nom du produit:</label>
<input type="text" id="product-name" name="product-name" required>

<label for="product-description">Description :</label>
<input type="text" name="product-description" required>


<label for="product-description">Dimensions :</label>
<input type="int" name="product-description" required>
<input type="int" name="product-description" required>
<input type="int" name="product-description" required>

<label for="product-description">Quantité :</label>
<input type="text" name="product-description" required>

<label for="product-image">Image du produit :</label>
<input type="file" id="product-image" name="product-image" accept="image/*" required>

<button type="submit">Ajouter</button>
</form>

  <div class="product-list">
    <h2>Liste des produits</h2>
    <ul>
      <li>
        <img src="#" alt="Produit 1">
        <h3>Nom du produit</h3>
        <p>Descriptin</p>
        <button class="edit-btn">Modifier</button>
        <button class="delete-btn">Supprimer</button>
      </li>
    </ul>
  </div>
</body>
<?php
  include ("footer.php");
?>

</html>