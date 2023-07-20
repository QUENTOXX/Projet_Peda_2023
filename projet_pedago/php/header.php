<?php

include_once ('fonction.php');
session_start();

if(isset($_POST['deconnect'])){
    deconnexion();
    header('Location: /projet_pedago/php/accueil.php');
}

if(isset($_POST['submit'])){
  $search= isset($_POST['search']) ? $_POST['search'] : "";  
  //$_GET['search']
    header('Location: /projet_pedago/php/searchpageN.php?search='.$search);
}

if (!isset($_SESSION['Connexion'][0])) {
  $button = "<a href='/projet_pedago/php/connexion.php'>Connexion</a>";
}
else{
  $button = "<a href='/projet_pedago/php/AccountC.php'>Compte</a>";
}

?>
<head>
<link rel="stylesheet" type= "text/css" href="/projet_pedago/css/Main.css">
</head>
<header>
    <nav> 
        <div class="hcontainer">
            <a href="/projet_pedago/php/accueil.php" class="logo">New Amazony</a>
            <div class="search-bar">
                <form id="search_bar" action="" method="POST">
                    <input type="text" name="search" placeholder="Recherche">
                    <button id ="loupe_loupe"type="submit" name="submit"><img id="loupe" src="/projet_pedago/img/loupe.png" alt="img.png"></button>
                </form>
            </div>
            <ul class="navigation">
                <li><?php print($button) ?></li>
                <li><a href="/projet_pedago/php/Panier.php">Panier</a></li>
                <?php 
                if(isset($_SESSION['Connexion'][0])){
                    print('<li><form id="deconnexion" action="/projet_pedago/php/accueil.php" method="POST">
                        <button class="nav-button" type="submit" name="deconnect" value="deconnect">Déconnexion</button></form></li>');
                }
                ?>
            </ul>
        </div>
    </nav>
</header>
