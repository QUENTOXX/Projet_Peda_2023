<?php
  include ("header.php");

  if(isset($_SESSION['Connexion']) && ($_SESSION['Connexion'][1] != 'admin' && $_SESSION['Connexion'][1] != 'vendeur')){
    {
         header('Location: /projet_pedago/php/accueil.php');
         die();
     }
 }
 $ID_vend = $_SESSION['Connexion'][0];

?>
<!DOCTYPE html>
<html>
<head>
  <title>Ventes</title>
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/ventes.css">
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/Main.css">
</head>
<body>
  <main>
    <div class="sales-container">
      <h2>Statistiques de ventes</h2>
      <?php
        global $pathprod;
        $ventes = stats($ID_vend);   //form tab[id_prod] = tab_stat[Qvendu][Qtotal][IMG][Nom][Prix]
        $total = totalVendeur($ID_vend);

        echo '<h2> Total des gains : ' . $total . '€</h2>';

        foreach ($ventes as $value) {
          echo '<div class="statistic">';
          echo '<h3>' . $value['Nom'] . '</h3>';
          echo ('<img src='.$pathprod.$value['IMG'].'>');
          echo '<p>Ventes : ' . $value['Qvendu'] . ' / ' . $value['Qtotal'] . '</p>';
          echo '<p>Revenu total : ' . $value['Prix'] . ' €</p>';
          echo '</div>';
        }
      ?>
    </div>
    
  </main>
</body>
</html>
<?php
  include ("footer.php");
?>