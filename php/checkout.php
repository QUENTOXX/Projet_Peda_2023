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
    <h1>Checkout</h1>
    <div id="checkout-form">
        <h2>Adresse de livraison</h2>
        <form id="billing-form">
            <div class="form-group">
                <label for="fullname">Nom et Prénom:</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="address">Adresse:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="city">Ville:</label>
                <input type="text" id="city" name="city" required>
            </div>
            <div class="form-group">
                <label for="zipcode">Code Postal:</label>
                <input type="text" id="zipcode" name="zipcode" required>
            </div>
            <div class="form-group">
                <label for="country">Ville:</label>
                <input type="text" id="country" name="country" required>
            </div>
        </form>

        <h2>Informations de paiement</h2>
        <form id="payment-form">
            <div class="form-group">
                <label for="cardname">Nom du titulaire de la carte:</label>
                <input type="text" id="cardname" name="cardname" required>
            </div>
            <div class="form-group">
                <label for="cardnumber">Numéro de carte:</label>
                <input type="text" id="cardnumber" name="cardnumber" required>
            </div>
            <div class="form-group">
                <label for="expiry">Date d'expiration:</label>
                <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" required>
            </div>
        </form>

        <button class="checkout-button" onclick="goBackToCart()">Retour au panier</button>
        <button class="checkout-button" onclick="submitOrder()">Confirmer la commande</button>
    </div>

    <script src="/projet_pedago/js/panier.js"></script>
</body>
<?php
    include("footer.php");
?>
</html>
