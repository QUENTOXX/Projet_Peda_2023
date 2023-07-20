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
<header>
    <nav> 
        <div class="container">
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
<style>
    header {
        font-family: Arial, sans-serif;
        background-color: #232f3e;
        color: #fff;
        padding: 10px;
        height: 60px;
    }

    #deconnexion{
      margin : 0px;
      padding : 0px;
    }

    .container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-right: 15px;
    max-width: 100%;
    margin: 0 auto;
    height: 100%;
    }

    #search_bar{
      margin : 0px;
      padding : 0px;
      align-items: center;
      height: 100%;
    }

    .logo {
        font-size: 24px;
        font-weight: bold;
        text-decoration: none;
        color: #fff;
        display: flex;
        align-items: center;
    }

    .search-bar {
        display: flex;
        align-items: center;
        margin-left: 20px;
        height: 100%;
    }
    
    .search-bar input[type="text"] {
        padding: 8px;
        border: none;
        border-radius: 4px;
        height: 100%;
    }
    
    .search-bar button {
        background-color: #febd69;
        color: #131921;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        border-radius: 4px;
        height: 100%;
    }
    
    #loupe {
      height: 20px;
      width:40px;
      vertical-align: middle;
      padding : 5px;
    }

    #loupe_loupe{
      margin : 0px;
      padding : 0px;
      align-items: center;
      height: 100%;
    }

    .navigation {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        height : 60px;
    }

    .navigation li {
        margin-left: 20px;
    }

    .navigation a {
        text-decoration: none;
        color: #fff;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .navigation a:hover {
        background-color: #febd69;
        color: #131921;
    }

    .nav-button {
        background-color: #febd69;
        color: #131921;
        border: none;
        padding: 8px 16px;
        cursor: pointer;
        border-radius: 4px;
        align-items:center;
    }

    .nav-button:hover {
        background-color: #e5ad2c;
        color: #131921;
    }
</style>
<?php /*

<?php
} else {
?>

<header>
    <nav>
        <div class="container">
            <a href="/projet_pedago/php/accueil.php" class="logo">New Amazony</a>
            <div class="search-bar">
            <form action="" method = "POST">
                <input type="text" name="recherche" placeholder="Recherche">
                <button type="submit" name="submit"><img id="loupe" src="/projet_pedago/img/loupe.png" alt="img.png"> </button>
                </form>
            </div>
            <ul class="navigation">
                <li><a href="/projet_pedago/php/AccountC.php">Compte</a></li>
                <li><a href="/projet_pedago/php/Panier.php">Panier</a></li>
                <li><a><form action="/projet_pedago/php/accueil.php" method="POST">
                    <button type="submit" name="deconnect" value="deconnect">Déconnexion</button></a></li>
            </ul>
        </div>
    </nav>
    <style>
  header {
    background-color: #232f3e;
    color: #fff;
  }
  .logo {
      padding-left: 10px;
      font-size: 24px;
      font-weight: bold;
      text-decoration: none;
      color: #fff;
    }
    
    .search-bar {
      display: flex;
    }
    
    .search-bar input[type="text"] {
      padding: 8px;
      border: none;
    }
    
    .search-bar button {
      background-color: #FF9900;
      color: #fff;
      border: none;
      padding: 8px 16px;
      cursor: pointer;
    }
    #loupe{
      height: 15px;
      width :25px;
    }
    .navigation a {
      list-style-type: none;
      text-decoration: none;
      color: #fff;
      margin: 0;
      padding: 0;
    }

    .navigation a:hover{
      color: #e47911;
    }
    
    .navigation li {
      display: inline;
      margin-left: 20px;
    }
    
    .navigation li:first-child {
      margin-left: 0;
    }
    </style>
</header>
<?php
}
*/
?>
