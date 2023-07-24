<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/Paniercss.css">
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/Main.css">
</head>
<?php
    include("header.php");
    
    if (isset($_SESSION['Connexion'][0])) {
        if ($_SESSION['Connexion'][1] == 'client') {
            $id_client = $_SESSION['Connexion'][0];
            if (isset($_POST['commander'])) {
                //passer commande
            }
        }else{
            header('Location: /projet_pedago/php/accueil.php');
            die();
        }
    }

    $id = $_SESSION['Connexion'][0];

    var_dump(getCart($id));
?>

<body>
    <h1>Panier</h1>
    <div id="cart-container">
        <div id="cart-items">

            <ul class="cart">

                <li>
                    <div class="cart-item">
                    <div class="item-image">
                            <img src="item1.jpg" alt="Item 1">
                        </div>                        
                        <div class="item-details">
                            <h3>Produit 1</h3>
                            <p>Prix: 20.00€</p>
                            <input type="number" value="1" min="1" class="item-quantity">
                            <button class="remove-button">Supprimer</button>
                        </div>
                    </div>
                </li>
                <?php
            global $pathprod;
                foreach ($articles as $item){
                    print('<li>
                    <div class="cart-item">
                    <div class="item-image">');
                    // WIP //
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
            ?>
            </ul>
        </div>

        <div id="cart-total">
            Total: 0€
        </div>

        <div id="cart-actions">
            <button class="checkout-button" onclick="goToCheckout()">Commander</button>
        </div>
    </div>

    <script src="/projet_pedago/js/panier.js"></script>

</body>

</html>
<?php
    include("footer.php");
?>