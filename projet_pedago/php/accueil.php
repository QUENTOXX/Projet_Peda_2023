<?php
include("header.php");
include_once("fonction.php");

$articlePromo = array_slice($GLOBALS['produits'], 0, 6);

?>

<!DOCTYPE html>
<html>

<head lang="fr">
    <title>New Amazony</title>
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/Style.css">

</head>


<body>
    <div class="quickaccess">
        <ul class="list">
            <li><a href="#">Catégorie 1</a></li>
            <li><a href="#">Catégorie 2</a></li>
            <li><a href="#">Catégorie 3</a></li>
            <li><a href="#">Catégorie 4</a></li>
            <li><a href="#">Catégorie 5</a></li>
        </ul>
    </div>
    <div class="containerbanner">
        <div class="bannerslides">
            <img src="/projet_pedago/img/realism-hand-drawn-horizontal-banner_23-2150203461.jpg" alt="Img1">
            <img src="/projet_pedago/img/computer-sales-design-template-cb39cf57b55fecf5847061fb33755a0b_screen.jpg"
                alt="Img2">
            <img src="/projet_pedago/img/retailer_banner_image.jpg" alt="Img3">
            <img src="/projet_pedago/img/banniere-vente-mega-ruban-rouge-illustration_275806-126-1.jpg" alt="Img4">
        </div>
    </div>

    <section class="products">
        <div class="containerproducts">
            <!--
          <div class="product">
                <img id="product img" src="/projet_pedago/img/product1.jpg" alt="Product1">
                <h2>Mixcder E9 Casque Bluetooth à Réduction de Bruit Active</h2>
                <p>69,99€</p>
                <a href="#" class="btn">Ajouter au panier</a>
                -->

            <?php
            foreach ($articlePromo as $item) {
                print('<div class="product">');
                print('<img src="data:image/jpeg;base64,' . base64_encode($item['Image']) . '"/>');
                print('<h2>' . $item['Nom'] . '</h2><br>');
                print($item['Prix'] . '€<br>');
                print('En stock : ' . $item['Quantite'] . '<br>');
                print('
                    <form method="post">
                    <button class="btn" type="submit" name="commander" value="' . $item['ID'] . '">Ajouter au panier</button>
                    </form>
                    ');
                print("</div>");
            }
            ?>
            <!--
        </div>
        <div class="product">
            <img id="product img" src="/projet_pedago/img/product2.jpg" alt="Product2">
            <h2>Fire TV Stick 4K Max | Aphpareil de streaming, Wi-Fi 6</h2>
            <p>109,99€ Livraison GRATUITE en France</p>
            <a href="#" class="btn">Ajouter au panier</a>
        </div>
        <div class="product">
            <img id="product img" src="/projet_pedago/img/product3.jpg" alt="Product3">
            <h2>Fossil Montre pour hommes Commuter</h2>
            <p>108,15€ PVC: 119,00€</p>
            <a href="#" class="btn">Ajouter au panier</a>
        </div>
      -->
        </div>
    </section>
</body>
<?php
include("footer.php");
?>

</html>