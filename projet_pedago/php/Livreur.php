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

  if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $tabconv = $_POST["tab"];
    $tab = json_decode($tabconv);  // tab form -> [id_cmd] = array([id_pro] = [nom][qtt])

    foreach ($tab as $idcmd => $produits){

      foreach ($produits as $key => $value) {

        $qui = "liste_statut".$idcmd.$key;
        $statut = $_POST[$qui];
        if ($statut == "depot") {   //0
          
          upd_Statuts(0, $idcmd, $key);

        }elseif($statut == "Récupéré") {   //1
          
          upd_Statuts(1, $idcmd, $key);

        }elseif($statut == "Livré") {  //2

          upd_Statuts(2, $idcmd, $key);

        }
      }
    }
  }
  $id = $_SESSION['Connexion'][0];
?>
<body>
  <main>
<h1>Mon Compte Livreur</h1>
    <div class="Mcontainer">
        
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

                      $tab = recu_Produit_By_Cmd($cmd); //tab des produit de cmd -> id=[nom][desc]
                      $tabpush[$cmd] = $tab;
                      $tabconv = json_encode($tabpush);

                      foreach ($tab as $key => $desc){

                        $bddstatut = recup_Statut($cmd, $key);

                        $opt1_select = '';
                        $opt2_select = '';
                        $opt3_select = '';

                        if ($bddstatut == 0) {
                            $opt1_select = 'selected';
                        } elseif ($bddstatut == 1) {
                            $opt2_select = 'selected';
                        } elseif ($bddstatut == 2) {
                            $opt3_select = 'selected';
                        }

                        echo "Produit n°$key :" . $desc[0] ." x " . $desc[1] . "<br>";
                        echo '<form action="" method="POST" enctype="multipart/form-data">';
                        ?>
                        <input type="hidden" name="tab" value="<?php echo htmlspecialchars($tabconv); ?>">
                        <?php
                          $qui = $cmd.$key;
                          echo '<select name="liste_statut'.$qui.'">';
                            echo '<option value="depot" '.$opt1_select.' >Au dépot</option>';
                            echo '<option value="Récupéré" '.$opt2_select.' >Récupéré</option>';
                            echo '<option value="Livré" '.$opt3_select.' >Livré</option>';
                          echo '</select>';
                        echo "<br>";
                      }
                  }
                  echo "<br>";
                }

              ?>
              <button id="closePopup" type="input" name="close">Fermer</button>
              </form>
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
          </main>
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