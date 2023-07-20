<?php
include("header.php");
include_once("fonction.php");

$articlePromo = array_slice($GLOBALS['produits'], 0, 6);

if (isset($_SESSION['Connexion'][0])) {
    if ($_SESSION['Connexion'][1] == 'client') {
        $id_client = $_SESSION['Connexion'][0];
        if (isset($_POST['commander'])) {
            var_dump($_POST['commander']);
            ajout_panier($_POST['commander'], $id_client, 1);
            header('Location: /projet_pedago/php/accueil.php');
        }
    }
}
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
            <img src="/projet_pedago/img/computer-sales-design-template-cb39cf57b55fecf5847061fb33755a0b_screen.jpg" alt="Img2">
            <img src="/projet_pedago/img/retailer_banner_image.jpg" alt="Img3">
            <img src="/projet_pedago/img/banniere-vente-mega-ruban-rouge-illustration_275806-126-1.jpg" alt="Img4">
        </div>
    </div>

    <section class="products">
        <div class="containerproducts">
            <?php
            foreach ($articlePromo as $item) {
                print('<div class="product">');
                print('<img src="data:image/jpeg;base64,' . base64_encode($item['Image']) . '"/>');
                print('<h2>' . $item['Nom'] . '</h2><br>');
                print('<p>' . $item['Description'] . '</p>');
                print($item['Prix'] . '€<br>');
                print('En stock : ' . $item['Quantite'] . '<br>');
                print('
                    <form action="/projet_pedago/php/accueil.php" method="POST">
                    <button class="btn" type="submit" name="commander" value="' . $item['ID'] . '">Ajouter au panier</button>
                    </form>
                    ');
                print("</div>");
            }
            ?>
        </div>
    </section>

</body>
<?php
include("footer.php");
?>

</html>