<?php 

    include_once ("fonction.php");
    include_once("header.php");

    //session_start();  

    if (!isset($_SESSION['Connexion'][0]) || ($_SESSION['Connexion'][1] != 'vendeur' && $_SESSION['Connexion'][1] != 'admin' )) {
      //  echo"You died !";
      header('Location: /projet_pedago/php/accueil.php');
      die();
    }

    $ID_vendeur = $_SESSION['Connexion'][0];
    $erreur = "";

    if(isset($_POST['ajouter'])){
      
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
            ajout_Produit($hauteur, $longueur, $largeur, $poids, $name, $prix, $description, $image['name'], $quantity, $ID_vendeur);
            $erreur .= "Le produit à bien été ajouté";
        }
      }
    }
  }

  if(isset($_POST['sup'])){

    $ID_prod = $_POST['md_ID'];
    suppr_Produit($ID_prod);
  }

  if(isset($_POST['modif'])){

    $ID_prod = $_POST['md_ID'];
    $H = $_POST['md_H'];
    $L = $_POST['md_L'];
    $l = $_POST['md_l'];
    $P = $_POST['md_P'];
    $Nom = $_POST['md_nom'];
    $Prix = $_POST['md_prix'];
    $Desc = $_POST['md_desc'];
    $Image = isset($_FILES['md_img']) ? $_FILES['md_img'] : "";
    $Quantite = $_POST['md_qtt'];
    $ID_Vendeur = $_POST['md_ID_vend'];

    if (empty($Image)) {

      $Image = $_POST['md_oldimg'];
      update_Produit($H, $L, $l, $P, $Nom, $Prix, $Desc, $Image, $Quantite, $ID_prod, $ID_Vendeur);
    }else{

      $allowTypes = array('image/jpg','image/png','image/jpeg','image/gif','image/pdf');
      if(in_array($Image['type'], $allowTypes)){
        $pathprod = 'C:/wamp64/www/projet_pedago/img/produits/' . $Image['name'];
        if(move_uploaded_file($Image["tmp_name"], $pathprod)){
          update_Produit($H, $L, $l, $P, $Nom, $Prix, $Desc, $Image['name'], $Quantite, $ID_prod, $ID_Vendeur);
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
            <textarea id="product-desc" name="description" rows="10" cols="50"></textarea>

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
                <?php
                $pathprod = '/projet_pedago/img/produits/';
                $all_Product = recu_Produit_By_Vendeur($ID_vendeur);

                foreach ($all_Product as $value) {
                    ?>
                    <form class="product-form" method="POST" action="" enctype="multipart/form-data">
                      <li>
                          <div class="product-image">
                              <?php print('<img src='.$pathprod.$value['Img'].'>'); ?>
                              <input type="file" id="product-image" name="md_img" accept="image/*">
                              <input type="hidden" name="md_oldimg" value="<?php echo(htmlspecialchars($value["Img"])); ?>" required>
                          </div>
                          <div class="product-details">
                              <h3><?php echo(htmlspecialchars($value["Nom"]));?></h3>

                              <p>Description <textarea name="md_desc" id="desc" rows="8" cols="70" required><?php echo($value["Descript"]); ?></textarea></p>
                              <p>Prix <input type="number" name="md_prix" value="<?php echo(htmlspecialchars($value["Prix"]));?>" required></p>
                              <p>Quantité <input type="number" name="md_qtt" value="<?php echo(htmlspecialchars($value["Quantite"]));?>" required></p>
                              <p>Hauteur <input type="number" name="md_H" value="<?php echo(htmlspecialchars($value["Hauteur"]));?>" required>
                              Longueur <input type="number" name="md_L" value="<?php echo(htmlspecialchars($value["Longueur"]));?>" required>
                              Largeur <input type="number" name="md_l" value="<?php echo(htmlspecialchars($value["Largeur"]));?>" required>
                              </p>
                              <p>Poids <input type="number" name="md_P" value="<?php echo(htmlspecialchars($value["Poids"]));?>" required></p>
                              <input type="hidden" name="md_ID" value="<?php echo $value["ID"]; ?>" required>
                              <input type="hidden" name="md_nom" value="<?php echo(htmlspecialchars($value["Nom"])); ?>" required>
                              <input type="hidden" name="md_ID_vend" value="<?php echo $value["ID_Vendeur"]; ?>" required>
                              <button type="submit" name = "modif" class="edit-btn">Modifier</button>
                              <button type="submit" name = "sup" class="delete-btn">Supprimer</button>
                          </div>
                        </li>
                      </form>
                    <?php } ?>
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

</html>
<?php
  include("footer.php");
  //get_footer();
?>