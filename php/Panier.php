<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/Paniercss.css">
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/Main.css">
</head>
<?php
    include("header.php");
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
                <li>
                    <div class="cart-item">
                    <div class="item-image">
                        <img src="item1.jpg" alt="Item 1">
                    </div>            
                        <div class="item-details">
                            <h3>Produit 2</h3>
                            <p>Prix: 15.00€</p>
                            <input type="number" value="1" min="1" class="item-quantity">
                            <button class="remove-button">supprimer</button>
                        </div>
                    </div>
                </li>
                <!-- pour ajouter des produits bande de nuls -->
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
<?php
    include("footer.php");
?>
</html>