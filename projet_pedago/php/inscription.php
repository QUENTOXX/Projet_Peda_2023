<?php
include("header.php");
include_once("fonction.php");

$erreur = "";
$answer = "";

if (isset($_POST['valider'])) {
  $mdp = isset($_POST['mdp']) ? $_POST['mdp'] : "";
  $mdp2 = isset($_POST['mdp2']) ? $_POST['mdp2'] : "";
  $nom = isset($_POST['nom']) ? $_POST['nom'] : "";
  $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : "";
  $tel = isset($_POST['tel']) ? $_POST['tel'] : "";
  $email = isset($_POST['email']) ? $_POST['email'] : "";


if(empty($mdp)){
  $erreur .= "Le mot de passe doit être renseigné <br>";
}
if(empty($mdp2)){
  $erreur .= "Veuillez comfirmer votre mot de passe <br>";
}
if($mdp != $mdp2){
  $erreur .= "Les mots de passe ne sont pas les même <br>";
}
if(empty($email)){
  $erreur .= "L'email' doit être renseigné <br>";
}
if(empty($nom) || !ctype_alpha($nom)){
  $erreur .= "Le nom doit être renseigné et ne contenir que des lettres <br>";
}
if(empty($prenom) || !ctype_alpha($prenom)){
  $erreur .= "Le prénom doit être renseigné et ne contenir que des lettres <br>";
}
if(empty($tel) || !is_numeric($tel)){
  $erreur .= "Le téléphone doit être renseigné et ne contenir que des nombres <br>";
}
if (empty($erreur)) {
  inscription($nom, $prenom, $email, $mdp, $tel);
  $erreur = "Compte bien créé !";
}
}
?>

<!DOCTYPE html>
<html>
<head lang="fr">
  <title>Inscription</title>
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/inscriptioncss.css">
  
</head>

<body>

  <div class="container_form">

    <form aaction="Inscription.php" method="POST">

        <label for="firstname">Votre nom</label>
        <input placeholder="Prénom et nom" class="formsign"type="text" name="firstname" id="prenom">

        <label for="mail">Adresse mail</label>
        <input placeholder="Adresse mail" class="formsign" type="email" name="mail" id="email">

        <label for="phone">n° Telephone</label>
        <input class="formsign" type="tel" name="telephone" id="tel">

        <label for="password">Mot de passe</label>
        <input placeholder="Mot de passe" class="formsign" type="password" name="password" id="mdp">
        
        <label for="passwordconfirm">Confirmez votre mot de passe</label>
        <input placeholder="Mot de passe" class="formsign" type="password" name="passwordconfirm" id="mdp2">

        <div class="button"><input class="register" type="submit" id="valider" name="valider" value="S'inscrire"></div>

        <!-- 
        <div class="button"> <button class="register">S'inscrire</button> </div>
-->
        <div class="a-center"><a class="login" href="#">Vous avez déjà un compte?</a></div>
    </form>
    <?php
    if (!empty($erreur)) {
    ?>
        <div id="erreurs">
            <?= $erreur; ?>
        </div>
    <?php
    }
    ?>
</div>

<?php
include("footer.php");
?>
</body>

</html>