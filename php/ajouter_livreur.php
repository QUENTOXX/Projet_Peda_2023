<?php
  include ("header.php");
  
  if(isset($_SESSION['Connexion']) && !$_SESSION['Connexion'][1] == 'admin'){
    header("Location: /projet_pedago/php/accueil.php");
    die(); 
  }else{
    $erreur = "";

  if (isset($_POST['valider'])) {
    $mdp = isset($_POST['mdp']) ? $_POST['mdp'] : "";
    $mdp2 = isset($_POST['mdp2']) ? $_POST['mdp2'] : "";
    $nom = isset($_POST['nom']) ? $_POST['nom'] : "";
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : "";
    $adresse = isset($_POST['adresse']) ? $_POST['adresse'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $temps= isset($_POST['temps']) ? $_POST['temps'] : "";
    $permis = isset($_POST['permis']) ? $_POST['permis'] : "";
    $vehicule = isset($_POST['vehicule']) ? $_POST['vehicule'] : "";
  
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
    if (empty($adresse) || !ctype_alpha($adresse)) {
      $erreur .= "L'adresse doit être renseignée <br>";
    }
    
    inscriptionLivreur($nom, $prenom, $email, $mdp, $adresse, $temps ,$permis, $vehicule);
  }   
}  
?>

<!DOCTYPE html>
<html>
<head>
  <title>Nouveau Livreur</title>
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/inscriptioncss.css" href="/projet_pedago/css/Main.css">
</head>

<body>
<div id="err">
      <div id="erreurs">
              <?= $erreur; ?>
      </div>

    </div>

<h1>Ajouter un livreur</h1>
<div class="container_form">
<form action="ajouter_livreur.php" method="POST">

    <label for="firstname">Votre nom</label>
    <input placeholder="Prénom" class="formsign" type="text" name="nom" id="nom">

    <label for="firstname">Votre prénom</label>
    <input placeholder="Nom" class="formsign" type="text" name="prenom" id="prenom">

    <label for="Adresse">Adresse </label>
    <input placeholder="Adresse " class="formsign" type="text" name="adresse" id="adresse">

    <label for="email">email </label>
    <input placeholder="toto@gmail.com" class="formsign" type="email" name="email" id="email">

    <label for="permis">Permis</label>
    <input class="formsign" type="text" name="permis" id="permis">

    <label for="Type_de_vehicule">Type de véhicule</label>
    <input class="formsign" type="text" name="vehicule" id="vehicule">

    <label for="Temps_de_tournée">Temps de tournée</label>
    <input class="formsign" type="number" name="temps" id="temps">

    <label for="password">Mot de passe</label>
    <input placeholder="Mot de passe" class="formsign" type="password" name="mdp" id="mdp">

    <label for="passwordconfirm">Confirmez votre mot de passe</label>
    <input placeholder="Mot de passe" class="formsign" type="password" name="mdp2" id="mdp2">


    <div class="button"><input class="register" type="submit" id="valider" name="valider" value="S'inscrire">
    </div>
</form>     


</div>
</body>

</html>
<?php
  include ("footer.php");
?>