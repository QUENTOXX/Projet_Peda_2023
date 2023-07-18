<?php

include_once 'function.php';
session_start();


if (!isset($_SESSION['Connected'])) {

?>

<header>
    <nav>
        <div class="container">
            <a href="/projet_pedago/php/accueil.php" class="logo">New Amazony</a>
            <div class="search-bar">
                <input type="text" placeholder="Recherche">
                <button type="submit"><img id="loupe" src="/projet_pedago/img/loupe.png" alt="img.png"> </button>
            </div>
            <ul class="navigation">
                <li><a href="/projet_pedago/php/connexion.php">S'identifier</a></li>
                <li><a href="/projet_pedago/php/Panier.php">Panier</a></li>
            </ul>
        </div>
    </nav>
</header>

<?php
} else {
?>

<header>
    <nav>
        <div class="container">
            <a href="/projet_pedago/php/accueil.php" class="logo">New Amazony</a>
            <div class="search-bar">
                <input type="text" placeholder="Recherche">
                <button type="submit"><img id="loupe" src="/projet_pedago/img/loupe.png" alt="img.png"> </button>
            </div>
            <ul class="navigation">
                <li><a href="/projet_pedago/php/AccountC.php">Compte</a></li>
                <li><a href="/projet_pedago/php/Panier.php">Panier</a></li>
            </ul>
        </div>
    </nav>
</header>
<?php
}
?>