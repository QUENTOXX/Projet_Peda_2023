<?php

    $link = mysqli_connect($serveur,$nomUtilisateurBDD,$motDePasseBDD) or die("Impossible de se connecter");
    //mysqli_set_charset($link,"utf8_general_ci");

    mysqli_set_charset($link, "utf8");


    mysqli_select_db($link,$nomBDD) or die("Pas de base");

?>