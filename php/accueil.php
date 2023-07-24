<?php
include("header.php");
include_once("fonction.php");

$articlePromo = array_slice($GLOBALS['produits'], 0, 12);

if (isset($_SESSION['Connexion'][0])) {
    if ($_SESSION['Connexion'][1] == 'client') {
        $id_client = $_SESSION['Connexion'][0];
        if (isset($_POST['commander'])) {
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
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/Style.css" href="/projet_pedago/css/Main.css">

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
            global $pathprod;

            for ($i = 0; $i < 3; $i++) {
                print("<div>");
                for ($j = 0; $j < 4; $j++) {
                    $item = $articlePromo[$i*4 + $j];
                    print('<div class="product">');
                    print('<img src='.$pathprod.$item['Img'].'>');
                    print('<h2>' . $item['Nom'] . '</h2><br>');
                    print('<p>' . $item['Descript'] . '</p>');
                    print($item['Prix'] . '€<br>');
                    print('En stock : ' . $item['Quantite'] . '<br>');
                    print('
                        <form action="/projet_pedago/php/accueil.php" method="POST">
                        <button class="btn" type="submit" name="commander" value="' . $item['ID'] . '">Ajouter au panier</button>
                        </form>
                        ');
                    print("</div>");
            }
                print("</div><br>");
        }
            ?>
        </div>
    </section>

</body>
</html>
<?php
include("footer.php");
?>