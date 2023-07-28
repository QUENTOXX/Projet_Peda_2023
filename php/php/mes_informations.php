<!DOCTYPE html>
<html>
<head>
  <title>Mes Informations</title>
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/mes_informations.css" href="/projet_pedago/css/Main.css">

</head>
<?php
  include ("header.php");
  
  if (!isset($_SESSION['Connexion'][0])) {
        header('Location: /projet_pedago/php/accueil.php');
        die();
    }

  $id = $_SESSION['Connexion'][0];

  if (isset($_POST["modifier"]) && isset($_POST["account-mdp"])) {
    if($_SESSION['Connexion'][1] == 'client'){
      
      $mdp = $_POST["account-mdp"];
      if(check($mdp)){

        $prenom = $_POST["account-surname"];
        $nom = $_POST["account-name"];
        $mail = $_POST["account-mail"];
        $tel = $_POST["account-tel"];
        $adresse = $_POST["account-adresse"];
        $numCB = $_POST["account-numCB"];
        $dateCB = $_POST["account-dateCB"];
        $cryptoCB = $_POST["account-cryptoCB"];

        update_Compte_Cli($prenom, $nom, $mail, $tel, $adresse,$numCB, $dateCB, $cryptoCB, $id);
      }
    } elseif($_SESSION['Connexion'][1] == 'vendeur' || $_SESSION['Connexion'][1] == 'admin'){
        
        $mdp = $_POST["account-mdp"];
        if(check($mdp)){

          $prenom = $_POST["account-surname"];
          $nom = $_POST["account-name"];
          $mail = $_POST["account-mail"];
          $tel = $_POST["account-tel"];
          if($_SESSION['Connexion'][1] == 'admin'){
            $admin = 1;
          }else{
            $admin = 0; 
          }
          
          update_Compte_Vend($nom, $mail, $admin, $tel, $prenom, $id);
          
        }
      } elseif($_SESSION['Connexion'][1]== 'livreur'){
        $mdp = $_POST["account-mdp"];

        if(check($mdp)){

          $Prénom = $_POST["account-surname"];
          $Nom = $_POST["account-name"];
          $Mail = $_POST["account-mail"];
          $Adresse = $_POST["account-adresse"];
          $Permis = $_POST["account-permis"];
          $Type_Véhicule = $_POST["account-type_vehicule"];

          update_Compte_Liv($Prénom, $Nom, $Mail, $Adresse, $Permis, $Type_Véhicule, $id);
        }
      }
    }
  
  
  
  if($_SESSION['Connexion'][1] == 'client'){
    $data = recup_Data_Client($id);
  }elseif($_SESSION['Connexion'][1] == 'vendeur' || $_SESSION['Connexion'][1] == 'admin'){
    $data = recup_Data_Vendeur($id);
  }elseif($_SESSION['Connexion'][1] == 'livreur'){
    $data = recup_Data_Livreur($id);
  } 

  if(isset($_POST['view'])){
    
    $type = $_SESSION['Connexion'][1];
    if ($type == "admin"){
      $type = "vendeur";
    }
    affiche_Contrat($id, "$type");
  }
?>
<body>
    <div class="info-container">
      <h1>Mes Informations</h1>
      <?php
       if ($_SESSION['Connexion'][1] == 'client'){
      ?>
      <form class="account-form" id="modifie" name="modifie" action="mes_informations.php" method="POST">
        <h2>Modifier mes informations</h2>
        <label for="account-name">Nom :</label>
        <input class="modifier-input"  type="text" id="account-name" name="account-name" value="<?php echo(htmlspecialchars($data["Nom"])); ?>" required>

        <label for="account-surname">Prénom:</label>
        <input class="modifier-input" value="<?php echo(htmlspecialchars($data["Prénom"]));?>" type="text" id="account-surname" name="account-surname" required>

        <label for="account-mail">Mail :</label>
        <input class="modifier-input" value="<?php echo(htmlspecialchars($data["Mail"]));?>" type="email" id="account-mail" name="account-mail" required>

        <label for="account-tel">Tel :</label>
        <input class="modifier-input" value="<?php echo(htmlspecialchars($data["Tel"]));?>" type="number" min="0" id="account-tel" step ="1" name="account-tel" required>

        <label for="account-adresse">Adresse :</label>
        <input class="modifier-input" value="<?php echo(htmlspecialchars($data["Adresse"]));?>" type="text" id="account-adresse" name="account-adresse" required>
        <br>
        <br>
        <?php
        if($data['Date_contrat'] > date('Y-m-d')){
          print('<label for="account-abonnement"> Vous êtes abonné jusqu\'au : ' . $data["Date_contrat"] . '<br><a href = "/projet_pedago/php/abonnement.php"> Prolonger l\'abonnement </a></label>
          <br>');
        } else{
          print('<label for="account-abonnement"> Vous n\'êtes pas abonné <br><a href = "/projet_pedago/php/abonnement.php"> S\'abonner </a></label>
          <br>');
        }
        
        ?>
        <label for="account-numCB"> Numéro CB</label>
        <input class="modifier-input" value="<?php echo(htmlspecialchars($data["numero_CB"]));?>" type="number" min="0" step ="1" id="account-numCB" name="account-numCB" >
        
        <label for="account-dateCB"> Date CB</label>
        <input class="modifier-input" value="<?php echo(htmlspecialchars($data["date_CB"]));?>" type="date" id="account-dateCB" name="account-dateCB" >

        <label for="account-cryptoCB"> Crypto CB</label>
        <input class="modifier-input" value="<?php echo(htmlspecialchars($data["crypto_CB"]));?>" type="number" min="0" step ="1" id="account-cryptoCB" name="account-cryptoCB" >

        <label for="account-mot_de_passe">Mot de passe:</label>
        <input class="modifier-input"  type='password' id='account-mot_de_passe' name='account-mdp' required>
     
        <button type="submit" name="modifier" class="account-button">Modifier</button>
      </form>
    </div>
  <?php
      }elseif($_SESSION['Connexion'][1] == 'vendeur' || $_SESSION['Connexion'][1] == 'admin'){
        ?>
        
    <div class="info-container">
      <form class="account-form" id="modifie" name="modifie" action="mes_informations.php" method="POST">
        <h1>Modifier mes informations</h1>

        <label for="account-name">Nom :</label>
        <input class="modifier-input" type="text" id="account-name" name="account-name" value="<?php echo(htmlspecialchars($data["Nom"])); ?>" required>

        <label for="account-surname">Prénom:</label>
        <input class="modifier-input"  type="text" id="account-surname" name="account-surname" value="<?php echo(htmlspecialchars($data["Prenom"]));?>" required>

        <label for="account-mail">Mail:</label>
        <input class="modifier-input" value="<?php echo(htmlspecialchars($data["email"]));?>" type="email" id="account-mail" name="account-mail" required>

        <label for="account-tel">Tel :</label>
        <input class="modifier-input" value="<?php echo(htmlspecialchars($data["tel"]));?>" type="number" min="0" id="account-tel" step ="1" name="account-tel" required>
        
        <label for="account-mot_de_passe">Mot de passe:</label>
        <input class="modifier-input"  type='password' id='account-mot_de_passe' name='account-mdp' required>

        <button type="submit" name="modifier" class="account-button">Modifier</button>
      </form>

      <form class="account-form" id="modifie" name="modifie" action="" method="POST">
        <label for="account-tel">Contrat :</label>
          <button type="submit" name="view" class="account-button">Voir le contrat</button>
      </form>
    </div>
  <?php
      }elseif($_SESSION['Connexion'][1] == 'livreur'){
  ?>
          <label for="account-cmd_a_livrer">Commande à livrer: <?php echo(htmlspecialchars($data["Cmd_a_Livrer"]));?></label>

          <label for="account-temps_tournee">Temps de tournée: <?php echo(htmlspecialchars($data["Temps_Tournee"]));?> h</label>
    <div class="info-container">
      <form class="account-form" id="modifie" name="modifie" action="mes_informations.php" method="POST">
        <h1>Modifier mes informations</h1>

        <label for="account-name">Nom :</label>
        <input class="modifier-input" type="text" id="account-name" name="account-name" value="<?php echo(htmlspecialchars($data["Nom"])); ?>" required>

        <label for="account-surname">Prénom:</label>
        <input class="modifier-input"  type="text" id="account-surname" name="account-surname" value="<?php echo(htmlspecialchars($data["Prénom"]));?>" required>

        <label for="account-mail">Mail:</label>
        <input class="modifier-input" value="<?php echo(htmlspecialchars($data["email"]));?>" type="email" id="account-mail" name="account-mail" required>

        <label for="account-adresse">Adresse:</label>
        <input class="modifier-input"  type="text" id="account-adresse" name="account-adresse" value="<?php echo(htmlspecialchars($data["Adresse"]));?>" required>

        <label for="account-permis">Permis:</label>
        <input class="modifier-input"  type="text" id="account-permis" name="account-permis" value="<?php echo(htmlspecialchars($data["Permis"]));?>" required>

        <label for="account-type_vehicule">Type de véhicule:</label>
        <input class="modifier-input"  type="text" id="account-type_vehicule" name="account-type_vehicule" value="<?php echo(htmlspecialchars($data["Type_Véhicule"]));?>" required>
        
        <label for="account-mot_de_passe">Mot de passe:</label>
        <input class="modifier-input"  type='password' id='account-mot_de_passe' name='account-mdp' required>

        <button type="submit" name="modifier" class="account-button">Modifier</button>
      </form>
      <form class="account-form" id="modifie" name="modifie" action="" method="POST">
        <label for="account-tel">Contrat :</label>
          <button type="submit" name="view" class="account-button">Voir le contrat</button>
      </form>
    </div>
  <?php
      }
  ?> 
  </div> 
    </div>
</body>
</html>
<?php
  include ("footer.php");
?>