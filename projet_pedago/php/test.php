<?php

//http://localhost/projet_pedago/php/test.php

require_once "fonction.php";

//$dist = calculer_distance("estiam lyon", "53 rue du treyve andrezieux bouthéon");
//inscription("Cary", "Jean","jean@gmail.com","54321");
//$isConnected = connexion("toto@gmail.com","1234");

$teb = built_tab(2);

$result = CheminLePlusCourt($teb);

array_pop($result);
array_push($result, "Point de départ");

echo "Le trajet le plus court de livraison est : Point de départ -> " . implode(' -> ', $result);

var_dump($teb);

//var_dump($isConnected);
//var_dump($dist);

//assignation_cmd(1);