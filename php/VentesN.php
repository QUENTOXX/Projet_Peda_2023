<!DOCTYPE html>
<html>
<head>
  <title>Ventes</title>
  <link rel="stylesheet" type="text/css" href="./css/ventes.css" href="/projet_pedago/css/Main.css">
  <link rel="stylesheet" type="text/css" href="./css/ventes.css" href="/projet_pedago/css/ventes.css">
</head>
<?php
  include ("header.php");
?>
<body>
  <main>
    <div class="sales-container">
      <h2>Statistiques de ventes</h2>
      <?php
        $ventes = [
          ['produit' => 'Produit 1', 'ventes' => 50, 'revenu' => 5000],
          ['produit' => 'Produit 2', 'ventes' => 30, 'revenu' => 3000],
        ];

        foreach ($ventes as $vente) {
          echo '<div class="statistic">';
          echo '<h3>' . $vente['produit'] . '</h3>';
          echo '<p>Ventes : ' . $vente['ventes'] . '</p>';
          echo '<p>Revenu total : ' . $vente['revenu'] . ' €</p>';
          echo '</div>';
        }
      ?>
    </div>
  </main>
</body>
<?php
  include ("footer.php");
?>
</html>
