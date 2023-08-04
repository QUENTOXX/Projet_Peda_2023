<?php

include("header.php");

$erreur = "";
$answer = "";

if (isset($_POST['valider'])) {
  $mdp = isset($_POST['mdp']) ? $_POST['mdp'] : "";
  $mdp2 = isset($_POST['mdp2']) ? $_POST['mdp2'] : "";
  $nom = isset($_POST['nom']) ? $_POST['nom'] : "";
  $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : "";
  $tel = isset($_POST['tel']) ? $_POST['tel'] : "";
  $email = isset($_POST['email']) ? $_POST['email'] : "";
  $type = isset($_POST['type']) ? $_POST['type'] : "";

  if (empty($mdp)) {
    $erreur .= "Le mot de passe doit être renseigné <br>";
  }
  if (empty($mdp2)) {
    $erreur .= "Veuillez comfirmer votre mot de passe <br>";
  }
  if ($mdp != $mdp2) {
    $erreur .= "Les mots de passe ne sont pas les même <br>";
  }
  if (empty($email)) {
    $erreur .= "L'email' doit être renseigné <br>";
  }
  if (empty($nom) || !ctype_alpha($nom)) {
    $erreur .= "Le nom doit être renseigné et ne contenir que des lettres <br>";
  }
  if (empty($prenom) || !ctype_alpha($prenom)) {
    $erreur .= "Le prénom doit être renseigné et ne contenir que des lettres <br>";
  }
  if (empty($tel) || !is_numeric($tel)) {
    $erreur .= "Le téléphone doit être renseigné et ne contenir que des nombres <br>";
  }
  if (empty($type) || ($type != 'Client' && $type != 'Vendeur')) {
    $erreur .= "Choisissez correctement votre type ! <br>";
  }
  if (empty($erreur)) {
    if ($type == 'Client'){
      if(inscriptionClient($nom, $prenom, $email, $mdp, $tel)){
        connexion($email,$mdp);
        $erreur = "Compte bien créé !";
      }
      else{
        $erreur = 'Mail déjà utilisé'; 
      }
    }
    else {
      if(inscriptionVendeur($nom, $prenom, $email, $mdp, $tel)){
        connexion($email,$mdp);
        $erreur = "Compte bien créé !";
      }
      else{
        $erreur = 'Mail déjà utilisé'; 
        
      }
    }
    
    
  }
}

?>

<!DOCTYPE html>
<html>

<head lang="fr">
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="/projet_pedago/css/inscriptioncss.css" href="/projet_pedago/css/Main.css">

</head>

<body>
    <h2>Rejoignez nous</h2>

    <div id="err">
      <div id="erreurs">
              <?= $erreur; ?>
      </div>

    </div>

    <div class="container_form">

      
      
        <form action="inscription.php" method="POST">

            <label for="firstname">Votre nom</label>
            <input placeholder="Prénom" class="formsign" type="text" name="nom" id="nom">

            <label for="firstname">Votre prénom</label>
            <input placeholder="Nom" class="formsign" type="text" name="prenom" id="prenom">

            <label for="mail">Adresse mail</label>
            <input placeholder="Adresse mail" class="formsign" type="email" name="email" id="email">

            <label for="phone">n° Telephone</label>
            <input class="formsign" type="tel" name="tel" id="tel">

            <label for="password">Mot de passe</label>
            <input placeholder="Mot de passe" class="formsign" type="password" name="mdp" id="mdp">

            <label for="passwordconfirm">Confirmez votre mot de passe</label>
            <input placeholder="Mot de passe" class="formsign" type="password" name="mdp2" id="mdp2">


            <label for="passwordconfirm">Type de compte</label>
            <select id="type" name="type">
              <option value="Client">Client</option>
              <option value="Vendeur">Vendeur</option>
            </select>

            <div class="button"><input class="register" type="submit" id="valider" name="valider" value="S'inscrire">
            </div>

            <!-- 
        <div class="button"> <button class="register">S'inscrire</button> </div>
-->
            <div class="a-center"><a class="login" href="connexion.php">Vous avez déjà un compte?</a></div>
        </form>     
        

    </div>

    
    
   
</body>

</html>
<?php
  include("footer.php");
  ?>
