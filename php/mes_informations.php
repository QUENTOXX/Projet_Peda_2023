<!DOCTYPE html>
<html>
<head>
  <title>Mes Informations</title>
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/mes_informations.css">
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/Main.css">
</head>
<?php
  include ("header.php");

  if (!isset($_SESSION['Connexion'][0]) || $_SESSION['Connexion'][1] != 'client') {
        header('Location: /projet_pedago/php/accueil.php');
        die();
    }

  $id_client = $_SESSION['Connexion'][0];

  if (isset($_POST["modifier"]) && isset($_POST["account-mdp"])) {

      $mdp = $_POST["account-mdp"];
      if(check($mdp, $id_client)){

        $prenom= $_POST["account-surname"];
        $nom= $_POST["account-name"];
        $mail= $_POST["account-mail"];
        $tel= $_POST["account-tel"];
        $adresse= $_POST["account-adresse"];
        $numCB= $_POST["account-numCB"];
        $dateCB= $_POST["account-dateCB"];
        $cryptoCB= $_POST["account-cryptoCB"];

        update_Compte_Cli($prenom, $nom, $mail, $tel, $adresse,$numCB, $dateCB, $cryptoCB, $id_client);
    }
  }
    
  $data = recup_Data_Client($id_client);


  
?>
<body>
  <div class="info-container">
    <h1>Mes Informations</h1>
    <form class="account-form" id="modifie" name="modifie" action="mes_informations.php" method="POST">
      <h2>Modifier mes informations</h2>
      <label for="account-name">Nom :</label>
      <input type="text" id="account-name" name="account-name" value="<?php echo(htmlspecialchars($data["Nom"])); ?>" required>

      <label for="account-surname">Prénom:</label>
      <input value="<?php echo(htmlspecialchars($data["Prénom"]));?>" type="text" id="account-surname" name="account-surname" required>

      <label for="account-mail">Mail :</label>
      <input value="<?php echo(htmlspecialchars($data["Mail"]));?>" type="mail" id="account-mail" name="account-mail" required>

      <label for="account-tel">Tel :</label>
      <input value="<?php echo(htmlspecialchars($data["Tel"]));?>" type="number" min="0" id="account-tel" step ="1" name="account-tel" required>

      <label for="account-adresse">Adresse :</label>
      <input value="<?php echo(htmlspecialchars($data["Adresse"]));?>" type="text" id="account-adresse" name="account-adresse" required>
<!--
      <label for="account-abonnement"> abonnement</label>
      <label for="account-abonnement" value="<?php echo(htmlspecialchars($data["Date_contrat"]));?>"> </label>
--> 
      <label for="account-numCB"> Numéro CB</label>
      <input value="<?php echo(htmlspecialchars($data["numero_CB"]));?>" type="number" min="0" step ="1" id="account-numCB" name="account-numCB" >

      <label for="account-dateCB"> Date CB</label>
      <input value="<?php echo(htmlspecialchars($data["date_CB"]));?>" type="date" id="account-dateCB" name="account-dateCB" >

      <label for="account-cryptoCB"> Crypto CB</label>
      <input value="<?php echo(htmlspecialchars($data["crypto_CB"]));?>" type="number" min="0" step ="1" id="account-cryptoCB" name="account-cryptoCB" >

      <label for="account-mot_de_passe">Mot de passe:</label>
      <input  type='password' id='account-mot_de_passe' name='account-mdp' required>
     
      <button type="submit" name="modifier" class="account-button">Modifier</button>
     </form>
  </div>
</body>
<?php
  include ("footer.php");
?>
</html>
