<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livreur</title>
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/livreur.css" href="/projet_pedago/css/Main.css">
</head>
<header>
<?php
  include("header.php");

  if (!isset($_SESSION['Connexion'][0])) {
    header('Location: /projet_pedago/php/accueil.php');
    die();
  }

  $id = $_SESSION['Connexion'][0];
?>
<body>
    <div class="container">
        <h1>Mon Compte Livreur</h1>
        <div class="menu">
          <h2> Mes commandes </h2>
          <?php
            affiche_cmd($id);
          ?>
          <button name="info"> Infos </button>

          <h2> Mon trajet </h2>
          <?php
            $arret = built_tab($id);    //creer le tableau des arret du livreur
            // verif si pas nul
            if ($arret == NULL) {
              return NULL;
            }else {

              $trajet = CheminLePlusCourt($arret);  // calcul l'itineraire le plus rapide !

              array_shift($trajet);
              array_push($trajet, "Point de départ");

              echo "Le trajet le plus court de livraison est : Point de départ -> " . implode(' -> ', $trajet);
            }
          ?>
        </div>
      </div>
</body>
</html>
<?php
  include("footer.php");
  ?>