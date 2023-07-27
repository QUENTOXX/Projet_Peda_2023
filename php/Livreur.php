<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livreur</title>
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/livreur2.css" href="/projet_pedago/css/Main.css">
</head>

<?php
  include("header.php");

  if (!isset($_SESSION['Connexion'][0])) {
    header('Location: /projet_pedago/php/accueil.php');
    die();
  }

  $id = $_SESSION['Connexion'][0];
?>
<body>
    <div class="Mcontainer">
        <h1>Mon Compte Livreur</h1>
        <div class="menu">
          <h2> Mes commandes </h2>
          <?php
            $tab_Cli_Cmd = affiche_cmd($id);
          ?>
          <button name="info" id="info"> Infos </button>

          <div class="popup-container" id="popup">
            <div class="popup-content">
              <h2>Infos Commandes par Client</h2>
              <?php

                foreach ($tab_Cli_Cmd as $key => $value) {

                  echo "Client n°$key :<br>";
                  
                  foreach ($value as $cmd) {
                      echo "Commande n°$cmd <br>";

                      $tab = recu_Produit_By_Cmd($cmd);

                      foreach ($tab as $key => $desc){

                        echo "Produit n°$key :" . $desc[0] ." x " . $desc[1] . "<br>";

                      }

                  }
                  echo "<br>";
                }

              ?>
              <button id="closePopup">Fermer</button>
            </div>
          </div>

          <h2> Mon trajet </h2>
          <?php
            $arret = built_tab($id);    //creer le tableau des arret du livreur
            // verif si pas nul
            if ($arret == NULL) {
              return NULL;
            }else {

              $trajet = CheminLePlusCourt($arret);  // calcul l'itineraire le plus rapide !

              array_shift($trajet); // on enleve celle du livreur

              echo "Le trajet le plus court de livraison est : ";
              echo "<br>";
              echo "Point de départ ";
              foreach ($trajet as $value) {
                echo " -> Client n° $value ";
              }
              echo " -> Point de départ ";
            }
          ?>
        </div>
        
      </div>

      <script type="text/Javascript">

        document.addEventListener("DOMContentLoaded", function () {
          const popup = document.getElementById("popup");
          const closeBtn = document.getElementById("closePopup");
          const btnOpenPopup = document.getElementById("info");

          function showPopup() {
            popup.style.display = "block";
          }

          function hidePopup() {
            popup.style.display = "none";
          }
          //Ouvrir la popup
          btnOpenPopup.addEventListener("click", showPopup);

          // Fermer la popup
          closeBtn.addEventListener("click", hidePopup);
        });
      </script>
</body>
</html>
<?php
  include("footer.php");
  ?>