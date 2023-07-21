<?php
  include ("header.php");
?>
<!DOCTYPE html>
<html>

    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Gestion Administrateur </title>
        <link rel="stylesheet" href="/projet_pedago/css/Agestioncss.css" href="/projet_pedago/css/Main.css">

    </head>

    <?php

    if (isset($_POST['rech_id'])){

        $rechercheId = $_POST["rech_id"];
        global $pathprod;

        $product= getProduitsByID($rechercheId);

        $nom = $product["Nom"];
        $qtt = $product["Quantite"];
        $prix = $product["Prix"];
        $img = $product["Image"];
    }else{
        $nom = "";
        $qtt = "";
        $prix = "";
        $img = "";
    }

    ?>

    <body>

        <div class="product_container">
            <form action="" method="post" name="rech_id">
                <div class="product_search">
                    <input type="text" name="rech_id" placeholder="Recherche ID ">
                    <button type="submit"><img id="loupe" src="/projet_pedago/img/loupe.png" alt="img.png"> </button>
                </div>
            </form>
        </div>

        <div class="product_table">

            <table class="products">

                <thead>
                    <tr>
                        <th><?php print('<img src='.$pathprod.$img.'>');?></th>
                        <th>Nom : <?php echo(htmlspecialchars($nom));?></th>
                        <th>Prix : <?php echo(htmlspecialchars($prix));?></th>
                        <th>Quantité : <?php echo(htmlspecialchars($qtt));?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <td>Option placeholder</td>
                    <td>Option Placeholder</td>
                    <td> <button id="edit">Modifier</button></td>
                    <td> <button id="warning">Avertissement</button></td>
                    <td><button id="del">Suprimer</button></td>

                </tbody>

            </table>

        </div>

        <div class="warning_from">

            <form id="warning-input" action="#" method="POST">

                    <h2>Avertissement</h2>
                    
                    <textarea name="warning" id="about" maxlength="255" placeholder="Saisissez l'avertissement" rows="5" cols="40"></textarea>

                <button type="submit" class="add" > Avertir </button>
            </form>


        </div>

        <div class="edit_from">

            <form id="edit-input" action="#" method="POST">

                
                    <h2>Modifications</h2>
                    
                    <input type="file" id="pictureInput" accept="image/*">
                    <input type="text" name = "name" placeholder="Nom de l'article" id="title" value="<?php echo(htmlspecialchars($nom));?>">
                    <input type="number" name = "quantite" placeholder="Quantité" id="quant" value="<?php echo(htmlspecialchars($qtt));?>">
                    <input type="number" name = "price" placeholder="Prix" id="price" value="<?php echo(htmlspecialchars($prix));?>">




                
                <button type="submit" class="add" > Enregistrer les modifications </button>
            </form>


        </div>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const pictureInput = document.getElementById('pictureInput');
            const maxFileSize = 5 * 1024 * 1024; // 5 MB

            pictureInput.addEventListener('change', function() {
                if (pictureInput.files.length > 0) {
                    const fileSize = pictureInput.files[0].size;
                    if (fileSize > maxFileSize) {
                        alert('File size exceeds the limit (5 MB). Please choose a smaller file.');
                        pictureInput.value = '';
                    }
                }
            });
        });
    </script>



    
    </body>

</html>
<?php
  include ("footer.php");
?>

