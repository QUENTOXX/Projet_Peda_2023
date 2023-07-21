<?php 

    include_once ("fonction.php");
    include_once("header.php");

    //session_start();  

    if (!isset($_SESSION['Connexion'][0]) || $_SESSION['Connexion'][1] != 'vendeur') {
      //  echo"You died !";
      header('Location: /projet_pedago/php/accueil.php');
      die();
    }

    $ID_vendeur = $_SESSION['Connexion'][1];
    $erreur = "";

    if(isset($_POST['ajouter'])){
      var_dump($_FILES);
        $name = isset($_POST['name']) ? $_POST['name'] : "";
        $description = isset($_POST['description']) ? $_POST['description'] : "";
        $prix = isset($_POST['prix']) ? $_POST['prix'] : "";
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : "";
        $hauteur = isset($_POST['hauteur']) ? $_POST['hauteur'] : "";
        $longueur = isset($_POST['longueur']) ? $_POST['longueur'] : "";
        $largeur = isset($_POST['largeur']) ? $_POST['largeur'] : "";
        $poids = isset($_POST['poids']) ? $_POST['poids'] : "";
        $image = isset($_FILES['image']) ? $_FILES['image'] : "";

      if (empty($name)) {
        $erreur .= "Le nom doit être renseigné <br>";
      }
      if (empty($description)) {
        $erreur .= "La description doit être renseigné <br>";
      }
      if (empty($prix) || !is_numeric($prix)) {
        $erreur .= "Le prix doit être renseigné et être un nombres <br>";
      }
      if (empty($quantity) || !is_numeric($quantity)) {
        $erreur .= "La quantité doit être renseigné et être un nombres <br>";
      }
      if (empty($hauteur) || !is_numeric($hauteur)) {
        $erreur .= "La hauteur doit être renseigné et être un nombres <br>";
      }
      if (empty($longueur) || !is_numeric($longueur)) {
        $erreur .= "La longueur doit être renseigné et être un nombres <br>";
      }
      if (empty($largeur) || !is_numeric($largeur)) {
        $erreur .= "La largeur doit être renseigné et être un nombres <br>";
      }
      if (empty($poids) || !is_numeric($poids)) {
        $erreur .= "Le poids doit être renseigné et être un nombres <br>";
      }
      if (empty($image)) {
        $erreur .= "Une image doit être renseigné <br>";
      }
      if (empty($erreur)) {
        $allowTypes = array('image/jpg','image/png','image/jpeg','image/gif','image/pdf');
        if(in_array($image['type'], $allowTypes)){
          $pathprod = 'C:/wamp64/www/projet_pedago/img/produits/' . $image['name'];
          if(move_uploaded_file($image["tmp_name"], $pathprod)){
            ajout_Produit($hauteur, $longueur, $largeur, $poids, $name, $ID_vendeur, $prix, $description, $image['name'], $quantity);
            $erreur .= "Le produit à bien été ajouté";
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html>

<head>
    <title>Mes Produits</title>
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/mes_produitscss.css" href="/projet_pedago/css/Main.css">
</head>
<body>
    <div class="container">
        <h1>Mes produits</h1>
        <?php echo($erreur); ?>
        <form class="product-form" method="POST" action="mes_produitsN.php" enctype="multipart/form-data"> 
            <h2>Ajouter un produit</h2>

            <label for="product-name">Nom du produit:</label>
            <input type="text" id="product-name" name="name" required>

            <label for="product-description">Description :</label>
            <input type="text" id="product-name" name="description" required>

            <label for="product-price">Prix :</label>
            <input type="number" step="0.01" min="0" name="prix" required>

            <label for="product-quantity">Quantité :</label>
            <input type="number" min="1" name="quantity" required>

            <label for="product-height">Hauteur(cm) :</label>
            <input type="number" step="0.01" min="0" name="hauteur" required>

            <label for="product-width">Largeur(cm) :</label>
            <input type="number" step="0.01" min="0" name="largeur" required>

            <label for="product-length">Longueur(cm) :</label>
            <input type="number" step="0.01" min="0" name="longueur" required>

            <label for="product-weight">Poids(Kg) :</label>
            <input type="number" step="0.01" min="0" name="poids" required>

            <label for="product-image">Image du produit :</label>
            <input type="file" id="product-image" name="image" accept="image/*" required>

            <button type="submit" name = "ajouter">Ajouter</button>
        </form>

        <div class="product-list">
            <h2>Liste des produits</h2>
            <ul>
                <li>
                    <div class="product-image">
                        <img src="#" alt="Produit 1">
                    </div>
                    <div class="product-details">
                        <h3>Nom du produit</h3>
                        <p class="product-description">Description</p>
                        <p class="product-price">Prix</p>
                        <p class="product-quantity">Quantité</p>
                        <p class="product-dimensions">Dimensions</p>
                        <p class="product-weight">Poids</p>
                        <button class="edit-btn">Modifier</button>
                        <button class="delete-btn">Supprimer</button>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const pictureInput = document.getElementById('product-image');
            const maxFileSize = 5 * 1024 * 1024; // 5 MB

            pictureInput.addEventListener('change', function() {
                if (pictureInput.files.length > 0) {
                    const fileSize = pictureInput.files[0].size;
                    if (fileSize > maxFileSize) {
                        alert('File size exceeds the limit (5 MB). Please choose a smaller file.');
                        pictureInput.value = '';
                    }
                }
            });
        });
    </script>
</body>
<?php
  include("footer.php")
?>
</html>
