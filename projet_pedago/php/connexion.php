<?php
include_once("fonction.php");

$answer = "";

if (isset($_POST['valider'])) {
  $username = isset($_POST['mail']) ? $_POST['mail'] : "";
  $mdp = isset($_POST['mdp']) ? $_POST['mdp'] : "";

  //Vérification des logins

  if (!empty($username) && !empty($mdp)) {
    global $serveur;
    $res = connexion($username, $mdp);
    if ($res == false) {
      $answer = "Identifiants incorrects";
    } else {
      header("Location: http://$serveur/projet_pedago/php/accueil.php");
    }
  }
}

?>

<!DOCTYPE html>
<html>

<head lang="fr">
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/connexion.css">

</head>

<body>
    <?php
  include("header.php");
  ?>

    <div class="container_form">
      <?=$answer?>  
        <form action="connexion.php" method="POST">
            <label for="mail">Adresse mail</label>
            <input placeholder="Adresse mail" class="formsign" type="email" name="mail" id="mail">

            <label for="password">Mot de passe</label>
            <input placeholder="Mot de passe" class="formsign" type="password" name="mdp" id="mdp">

            <div class="button"><input class="register" type="submit" id="valider" name="valider" value="Se Connecter"></div>

            <div class="a-center"><a class="login" href="inscription.php">Vous n'avez de compte?</a></div>
        </form>
    </div>
</body>

<?php
  include("footer.php");
?>

</html>