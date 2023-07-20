<?php
  include ("header.php");
?>
<!DOCTYPE html>
<html>

    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Gestion Administrateur </title>
        <link rel="stylesheet" href="/projet_pedago/css/Agestioncss.css">

    </head>

    <body>

        <div class="product_container">

            <div class="product_search">
                <input type="text" placeholder="Recherche ID ">
                <button type="submit"><img id="loupe" src="/projet_pedago/img/loupe.png" alt="img.png"> </button>
            </div>

        </div>

        <div class="product_table">

            <table class="products">

                <thead>
                    <tr>
                        <th>Product Picture</th>
                        <th>Prix</th>
                        <th></th>
                        <th></th>
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
                    <input type="text" name = "name" placeholder="Nom de l'article" id="title">
                    <input type="number" name = "quantite" placeholder="Quantité" id="quant">
                    <input type="number" name = "price" placeholder="Prix" id="price">




                
                <button type="submit" class="add" > Enregistrer les modifications </button>
            </form>


        </div>

  


    
    </body>

</html>
<?php
  include ("footer.php");
?>
<script type="text/javascript">
  document.getElementById('pictureInput').addEventListener('change', function() {
    const fileInput = this;
    const maxFileSize = 5 * 1024 * 1024; // 10 MB (you can adjust this value)

    if (fileInput.files.length > 0) {
      const fileSize = fileInput.files[0].size;
      if (fileSize > maxFileSize) {
        alert('File size exceeds the limit (5 MB). Please choose a smaller file.');
        // Clear the selected file to prevent form submission
        fileInput.value = '';
      }
    }
  });
</script>