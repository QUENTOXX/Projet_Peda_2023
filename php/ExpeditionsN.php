<!DOCTYPE html>
<html>
<head>
  <title>Expéditions</title>
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/expeditions.css">
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/Main.css">
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

  <label>Articles</label>
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
</body>
</html>
<?php
  include ("footer.php");
?>