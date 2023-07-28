<!DOCTYPE html>
<html>  
<head>
  <title>Mon Compte</title>
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/AccountCcss.css">
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/Main.css">
</head>
<?php
  include ("header.php");

  if (isset($_SESSION['Connexion'][0])) {
    if ($_SESSION['Connexion'][1] == 'client') {
        $qui = 1;
        $id_client = $_SESSION['Connexion'][0];
    }
    if ($_SESSION['Connexion'][1] == 'vendeur') {
      $qui = 2;
      $id_vendeur = $_SESSION['Connexion'][0];
    }
    if ($_SESSION['Connexion'][1] == 'livreur') {
      $qui = 3;
      $id_livreur = $_SESSION['Connexion'][0];
    }
    if ($_SESSION['Connexion'][1] == 'admin') {
      $qui = 4;
      $id_livreur = $_SESSION['Connexion'][0];
    }
}

?>
<body>
  <div class="container">
    <h1>Mon Compte</h1>
    <?php 

      if($qui == 1){

        echo '<div class="menu">';
        echo '<a href="/projet_pedago/php/suivi_colis.php">Suivi de colis</a>';
        echo '<a href="/projet_pedago/php/Aide.php">Aide</a>';
        echo '<a href="/projet_pedago/php/mes_informations.php">Mes informations</a>';
        echo '<a href="/projet_pedago/php/abonnement.php">Abonnement</a>';
        echo '</div>';
        
      }elseif($qui == 2){
     
        echo '<div class="menu">';
        echo '<a href="/projet_pedago/php/mes_produitsN.php">Mes produits</a>';
        echo '<a href="/projet_pedago/php/VentesN.php">Ventes</a>';
        echo '<a href="/projet_pedago/php/ExpeditionsN.php">Expéditions</a>';
        echo '<a href="/projet_pedago/php/mes_informations.php">Gestion du compte</a>';
        echo '</div>';

      }elseif($qui == 3){

        echo '<div class="menu">';
        echo '<a href="/projet_pedago/php/Livreur.php">Mes livraisons</a>';
        echo '<a href="/projet_pedago/php/Aide.php">Aide</a>';
        echo '<a href="/projet_pedago/php/mes_informations.php">Mes informations</a>';
        echo '</div>';
      }elseif($qui == 4){
        echo '<div class="menu">';
        echo '<a href="/projet_pedago/php/mes_produitsN.php">Mes produits</a>';
        echo '<a href="/projet_pedago/php/StatsA.php" class="options-button">Statistiques</a>';
        echo '<a href="/projet_pedago/php/Acontrats.php" class="options-button">Contrats</a>';
        echo '<a href="/projet_pedago/php/ajouter_livreur.php">Ajouter un livreur</a>';
        echo '<a href="/projet_pedago/php/Agestion.php">Gestion</a>';
        echo '<a href="/projet_pedago/php/VentesN.php">Ventes</a>';
        echo '<a href="/projet_pedago/php/mes_produitsN.php">Nos Produits</a>';
        echo '<a href="/projet_pedago/php/mes_informations.php">Gestion du compte</a>';
        echo '</div>';
      }


    ?>
  </div>
</body>

</html>
<?php
  include ("footer.php");
?>