<!DOCTYPE html>
<html>
<head>
  <title>Expéditions</title>
  <link rel="stylesheet" type="text/css" href="./css/expeditions.css" href="/projet_pedago/css/Main.css">
</head>
<?php
  include ("header.php");
?>
<body>
  <div class="container-exp">

  <form action="/submit_form" method="post">
  <label for="name">Vendeur</label>
  <input type="text" id="name" name="name">

  <label for="email">Email:</label>
  <input type="email" id="email" name="email">

  <label for="message">Message:</label>
  <textarea id="message" name="message"></textarea>

  <label>Aricles</label>
  <ul>
    <li>
      Article 1
    </li>

    <li>
      Article 2
    </li>

    <li>
      Article 3
    </li>
    
  </ul>

</form>

  <div>
    <ul id="dynamic-list"><input type="text" id="productid" name="productid" placeholder="ID Produit"></input></ul>
    <button id="add-button">Ajouter un nouvel article</button>
  </div>

  </div>

  <button type="submit">Envoyer Notification</button>


  <script type="text/Javascript">


    document.addEventListener('DOMContentLoaded', function () {
      const addButton = document.getElementById('add-button');
      const dynamicList = document.getElementById('dynamic-list');

      let elementCount = 0;

      addButton.addEventListener('click', function () {

        const listItem = document.createElement('li');
        listItem.textContent = `Element ${elementCount + 1}`;

        dynamicList.appendChild(listItem);

        elementCount++;
      });
    });


  </script>
</body>

</html>
<?php
  include ("footer.php");
?>