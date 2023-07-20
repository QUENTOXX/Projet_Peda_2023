<!DOCTYPE html>
<html>
<head>
  <title>Mes Informations</title>
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/AccountCcss.css" href="/projet_pedago/css/Main.css">
</head>
<?php
  include ("header.php");

  if (isset($_POST["account-mot_de_passe"])) {
    $mdp = $_POST["account-mot_de_passe"];
    check($mdp);
  }

  function check($mdp, $ID_client){
    global $connexion;
    $mdp = md5($mdp);
    
    $req = $connexion->prepare("SELECT * FROM client WHERE ID_client = :id_client AND Mot_de_Passe = :mot_de_passe");
    $req->bindValue(':mot_de_passe', $mdp);
    $req->bindValue(':id_client', $ID_client);
    $req->execute();
    $res->fetch();
    $req->closeCursor();
  
    if($res){
     update_Compte_Cli("account-surname", "account-name", "account-mail","account-tel","account-adresse" , "account-abonnement", "account-mot_de_passe", "account-numCB", "account-dateCB", "account-cryptoCB");
    }
    else{
     echo "Mot de passe incorrect";
    }
}

  
?>
<body>
  <div class="container">
    <h1>Mes Informations</h1>
    <form class="account-form" name="modifie" action="" method="POST">
      <h2>Modifier mes informations</h2>
      <label for="account-name">Nom :</label>
      <input type="text" id="account-name" name="account-name" required>

      <label for="account-surname">Prénom:</label>
      <input type="text" id="account-surname" name="account-surname" required>

      <label for="account-mail">Mail :</label>
      <input type="mail" id="account-mail" name="account-mail" required>

      <label for="account-tel">Tel :</label>
      <input type="text" id="account-tel" name="account-tel" required>

      <label for="account-adresse">Adresse :</label>
      <input type="text" id="account-adresse" name="account-adresse" required>

      <label for="account-abonnement"> abonnement</label>
      <input type="text" id="account-abonnement" name="account-abonnement" required>
  
      <label for="account-numCB"> Numéro CB</label>
      <input type="text" id="account-numCB" name="account-numCB" required>

      <label for="account-dateCB"> Date CB</label>
      <input type="text" id="account-dateCB" name="account-dateCB" required>

      <label for="account-cryptoCB"> Crypto CB</label>
      <input type="text" id="account-cryptoCB" name="account-cryptoCB" required>

      <label for="account-mot_de_passe">Mot de passe:</label>
      <input type='password' id='account-mot_de_passe' name='account-mot_de_passe' required>
     
      <button type="submit"  name="modifier">Modifier</button>
     </form>
  </div>
</body>
<?php
  include ("footer.php");
?>
</html>
