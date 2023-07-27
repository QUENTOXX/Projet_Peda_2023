<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/checkout.css">
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/Main.css">

</head>

<?php
    include("header.php");

    if(isset($_SESSION['Connexion']) && $_SESSION['Connexion'][1] == 'client'){
        $id_client = $_SESSION['Connexion'][0];
    }else{
        header('Location : /projet_pedago/php/accueil.php');
        die();
    }

    $value = recup_Data_Client($id_client);

    if(isset($_POST['confirm'])){
        
        $address = isset($_POST['address']) ? $_POST['address'] : "";
        $cardnumber = isset($_POST['cardnumber']) ? $_POST['cardnumber'] : "";
        $expiry = isset($_POST['expiry']) ? $_POST['expiry'] : "";
        $cvv = isset($_POST['cvv']) ? $_POST['cvv'] : "";

        maj_CB_Add($id_client, $cardnumber, $expiry, $cvv, $address);
        confirm_panier($id_client);
    }
    if(isset($_POST['retour'])){
        header('Location: /projet_pedago/php/Panier.php');
        die();
    }
?>

<body>
    <h1>Checkout</h1>
    <div id="checkout-form">
        <h2>Adresse de livraison</h2>
        <form id="billing-form" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="fullname">Nom:</label>
                <input type="text" id="fullname" name="nom" value="<?php echo(htmlspecialchars($value["Nom"]));?>" required>
            </div>
            <div class="form-group">
                <label for="fullname">Prénom:</label>
                <input type="text" id="fullname" name="prenom" value="<?php echo(htmlspecialchars($value["Prénom"]));?>" required>
            </div>
            <div class="form-group">
                <label for="address">Adresse:</label>
                <input type="text" id="address" name="address" value="<?php echo(htmlspecialchars($value["Adresse"]));?>" required>
            </div>

        <h2>Informations de paiement</h2>
            <div class="form-group">
                <label for="cardnumber">Numéro de carte:</label>
                <input type="text" id="cardnumber" name="cardnumber" value="<?php echo(htmlspecialchars($value["numero_CB"]));?>" required>
            </div>
            <div class="form-group">
                <label for="expiry">Date d'expiration:</label>
                <input type="text" id="expiry" name="expiry" placeholder="MM/YY" value="<?php echo(htmlspecialchars($value["date_CB"]));?>" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" value="<?php echo(htmlspecialchars($value["crypto_CB"]));?>" required>
            </div>

            <button class="remove-button" type="submit" name="retour">Retour au panier</button>
            <!--<a class="remove-button" href="/projet_pedago/php/Panier.php">Retour au panier</a>-->
            <button class="checkout-button" name="confirm" type="submit">Confirmer la commande</button>
        </form>
    </div>

</body>

</html>
<?php
    include("footer.php");
?>