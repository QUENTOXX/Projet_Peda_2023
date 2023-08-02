<?php

include("header.php");

if(!isset($_SESSION['Connexion'][0]) && $_SESSION['Connexion'][1] != 'admin'){
    header('Location: /projet_pedago/php/accueil.php');
    die();
}

$data = statsA();
$total = 0;

foreach($data as $vendeur){
    $total += $vendeur["Prix"];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Statistiques Marketplace</title>
    <link rel="stylesheet" href="/projet_pedago/css/StatsA.css" href="/projet_pedago/css/Main.css">
</head>
<body>

    <main>
        <h1>Statistiques du site</h1>
        <h3>Total des tranferts monétaires : <?php print($total)?> €</h3>
        <section>
            <h2>Vendeurs</h2>
            <div class="stats-container">
                <?php
                    foreach($data as $vendeur){
                        print('<div><h5>');
                        print($vendeur['Nom'] . ' ' . $vendeur['Prenom'] . "  :  " . $vendeur['Prix'] . ' €');
                        print('</h5></div>');
                    }
                ?>
                
            </div>
        </section>
<!--
        <section>
            <h2>Meilleures Ventes</h2>
            <div class="stats-container">


            </div>
        </section>
-->
    </main>

</body>
</html>
<?php
include("footer.php");
?>