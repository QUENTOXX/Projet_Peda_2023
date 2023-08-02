<?php
  include("header.php");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Suivi de colis</title>
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/Main.css">
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/suivi.css">
</head>

<body>

<header>
  <h1>Suivi de colis</h1>
</header>

<?php
if(!isset($_SESSION['Connexion'][0]) || $_SESSION['Connexion'][1] != 'client'){
  header('Location: /projet_pedago/php/accueil.php');
  die();
}
  $ID_client = $_SESSION['Connexion'][0];

  $data = recup_Cmd_By_Cli($ID_client);

  foreach ($data as $idCmd) {
    
    $tab = recu_Produit_By_Cmd($idCmd);  //tab des produit de cmd -> id=[nom][desc]
    
    foreach ($tab as $idPro => $value) {
      
      $bddstatut = recup_Statut($idCmd, $idPro);

      if ($bddstatut == 0) {
        $ou = "Colis au dépot";
      } elseif ($bddstatut == 1) {
        $ou = "Colis en cours de Livraison";
      } elseif ($bddstatut == 2) {
        $ou = "Colis livé !!";
      }

      echo '<div class="container">';
        echo '<div class="shipment">';
          echo '<h2>Colis #'.$idPro.'</h2>';
          echo '<p class="delivery-info">'.$value[0].'</p>';
          echo '<p>'.$ou.'</p>';
        echo '</div>';
      echo '</div>';
    }
  }
?>
</body>
</html>

<?php
  include("footer.php");
?>
</html>
