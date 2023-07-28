<?php
include("header.php"); 

if(!isset($_SESSION['Connexion'][0]) || $_SESSION['Connexion'][1] != 'client'){
  header('Location: /projet_pedago/php/accueil.php');
  die();
}

$id_client = $_SESSION['Connexion'][0];
$value = recup_Data_Client($id_client);

if(isset($_POST['abonner'])){
  $cardNumber = isset($_POST['cardNumber']) ? $_POST['cardNumber'] : "";
  $expirationDate = isset($_POST['expirationDate']) ? $_POST['expirationDate'] : "";
  $cvv = isset($_POST['cvv']) ? $_POST['cvv'] : "";
  $plan = isset($_POST['plan']) ? $_POST['plan'] : "";

  maj_CB_Add($id_client, $cardNumber, $expirationDate, $cvv, $value['Adresse']);
  if($value['Date_contrat'] > date('Y-m-d')){
    Abonnement($id_client, $plan, $value['Date_contrat']);
  }else{
    Abonnement($id_client, $plan);
  }
  header('Location: /projet_pedago/php/accueil.php');
  die();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Abonnement</title>
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/abonnement.css">
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/Main.css">
</head>
<body>
<div class="container">
    <h1>Abonnez-vous à New Amazony</h1> 
    <?php 
      if($value['Date_contrat'] > date('Y-m-d')){
        print("<h3>Vous êtes déjà Abonné jusqu'au " . $value['Date_contrat'] . "! </h3>");
      }
    ?>
    <div class="card">
      <h2>Choisissez un plan</h2>
      <div class="plan">
      <form action="/projet_pedago/php/abonnement.php" method="POST">
        <input type="radio" id="monthly" name="plan" value="monthly" checked>
        <label for="monthly">Plan Mensuel - 9,99 € / mois</label>
        <input type="radio" id="yearly" name="plan" value="yearly">
        <label for="yearly">Plan Annuel - 99,99 € / an</label>
      </div>
      <h3>Avantages d'être abonné à New Amazony :</h3>
      <ul id ="more">
        <li>Livraison gratuite en 1 jour ouvré</li>
        <li>Accès à New Amazony Prime Video</li>
        <li>Accès à New Amazony Music</li>
        <li>Accès à New Amazony Books</li>
        <li>Accès à New Amazony Gaming</li>
        <li>Offres exclusives pour les membres</li>
      </ul>
      <br>
        <div class="form-group">
          <label for="cardNumber">Numéro de carte de crédit :</label>
          <input type="number" min="0" step="1" id="cardNumber" name="cardNumber" value="<?php echo(htmlspecialchars($value["numero_CB"]));?>" required>
        </div>
        <div class="form-group">
          <label for="expirationDate">Date d'expiration :</label>
          <input type="date" id="expirationDate" name="expirationDate" value="<?php echo(htmlspecialchars($value["date_CB"]));?>" required>
        </div>
        <div class="form-group">
          <label for="cvv">CVV :</label>
          <input type="number" min="0" step="1" id="cvv" name="cvv" value="<?php echo(htmlspecialchars($value["crypto_CB"]));?>" required>
        </div>
        <button type="submit" id="subscribe-btn" name="abonner">S'abonner</button>
      </form>
    </div>
  </div>
</body>
</html>
<?php
include("footer.php");
?>

