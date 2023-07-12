<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../css/Paniercss.css">
</head>
<body>
  <header>
    <nav>
    <div class="container">
        <a href="../php/accueil.php" class="logo">New Amazony</a>
        <div class="search-bar">
        <input type="text" placeholder="Recherche">
        <button type="submit"><img id="loupe" src="../img/loupe.png" alt="img.png"> </button>
        </div>
        <ul class="navigation">
        <li><a href="#">Mon Compte</a></li>
        </ul> 
    </div>
    </nav>
    </header>
  <h1>Panier</h1>
  <div id="cart">
    <div id="cart-items">
    </div>
    <div id="cart-total">
      Total: $0
    </div>
  </div>
  <script src="panierjs.js"></script>
  <footer class="footer">
    <div class="footer-container">
      <div class="contact-info">
        <h3>Contact</h3>
        <p>Email : bruce.wayne@notbatman.us</p>
        <p>Téléphone : +123456789</p>
        <p>Adresse : Gotham City, États-Unis</p>
      </div>
      <div class="social-links">
        <h3>Suivez-nous</h3>
        <ul>
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Twitter</a></li>
          <li><a href="#">Instagram</a></li>
        </ul>
      </div>
    </div>
  </footer>
</body>
</html>