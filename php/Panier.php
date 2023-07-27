<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/Paniercss.css">
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/Main.css">
    
</head>
<?php
    include("header.php");

    $prix = 0;
    
    if (isset($_SESSION['Connexion'][0])) {
        if ($_SESSION['Connexion'][1] == 'client') {
            $id_client = $_SESSION['Connexion'][0];
            $articles = getCart($id_client);
            if(isset($_POST['commander'])){
                array_pop($_POST);
                foreach ($_POST as $key => $value) {
                    change_quantite($id_client, $key, $value);  
                }
                if($articles == null){
                    echo "Aucun produit dans la commande !";
                }else{
                header('Location: /projet_pedago/php/checkout.php');
                die();
                }
            }
            if(isset($_POST['supprimer'])){
        
                $id_to_Sup = $_POST['supprimer'];
                $id_Cmd = getIDcmd($id_client);

                if ($id_Cmd != FALSE) {
                    supprimerPanier($id_Cmd, $id_to_Sup);
                }
            }

        }else{
            header('Location: /projet_pedago/php/accueil.php');
            die();
        }
    }
    else{
        header('Location: /projet_pedago/php/accueil.php');
        die();
    }

?>

<body>
    <h1>Panier</h1>
    <div id="cart-container">
        <form action="" method="POST" enctype="multipart/form-data">
            <div id="cart-items">
                <ul class="cart">
                    <?php
                    global $pathprod;
                    if (!$articles){
                        echo "Aucun article dans le panier !";
                    }else{
                    foreach ($articles as $item) {
                        $produit = getProduitsByID($item['ID_produit']);
                        $prix += $produit['Prix'] * $item['quantite'];
                        echo '<li>
                            <div class="cart-item">
                                <div class="item-image">';
                        echo '<img src="' . $pathprod . $produit['Img'] . '">';
                        echo '</div>';
                        echo '<div class="item-details">';
                        echo '<h3>' . $produit['Nom'] . '</h3><br>';
                        echo '<p>' . $produit['Descript'] . '</p>';
                        echo $produit['Prix'] . '€<br>';
                        echo '<input type="number" value="' . $item['quantite'] . '" min="1" name="' . $item['ID_produit'] . '" max="' . $produit['Quantite'] . '" class="item-quantity">';
                        echo 'En stock : ' . $produit['Quantite'] . '<br>';
                        echo '</div>';
                        echo '<button class="remove-button" type="submit" name="supprimer" value="' . $item['ID_produit'] . '">Supprimer</button>';
                        echo '</div>';
                        echo '</li>';
                    }
                }
                    ?>
                </ul>
            </div>

            <div id="cart-total">
                Total: <?php echo ($prix); ?>€
            </div>

            <div id="cart-actions">
                <button class="checkout-button" type="submit" name="commander">Commander</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
    include("footer.php");  
?>
