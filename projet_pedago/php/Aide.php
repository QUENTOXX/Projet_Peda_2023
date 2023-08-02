<!DOCTYPE html>
<html>
<head>
  <title>Aide</title>
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/Aide.css" href="/projet_pedago/css/Main.css">
</head>
<?php
  include ("header.php");

 
?>
<body>
  <div class="container-aide">
    <h1>Aide</h1>
    <div class="help-form">

      <form action="/projet_pedago/php/accueil.php">

        <input type="text" class="helpinput" placeholder="Entrer le titre de votre message"></input>

        <textarea id="textareaInput" placeholder="En quoi pouvons-nous vous aider?"></textarea>

        <div class="button"><input class="help" type="submit" id="help" name="help" value="Envoyer">
        </div>


      </form>

    </div>
  </div>
</body>


</html>
<?php
  include ("footer.php");
?>