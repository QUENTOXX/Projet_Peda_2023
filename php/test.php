<?php

//http://localhost/projet_pedago/php/test.php

require_once "fonction.php";

//$dist = calculer_distance("estiam lyon", "53 rue du treyve andrezieux bouthéon");
//inscription("Cary", "Jean","jean@gmail.com","54321");
//$isConnected = connexion("toto@gmail.com","1234");
/*
$teb = built_tab(1);

$result = CheminLePlusCourt($teb);

array_shift($result);
array_push($result, "Point de départ");

echo "Le trajet le plus court de livraison est : Point de départ -> " . implode(' -> ', $result);

var_dump($teb);

$data = recup_Data_Vendeur(6);

var_dump($data);

echo $data["Prenom"];

//var_dump($isConnected);
//var_dump($dist);

//assignation_cmd(1);

$all_Product = recu_Produit_By_Vendeur(6);

var_dump($all_Product);
*/

$tab_Cli_Cmd = affiche_cmd(2);


foreach ($tab_Cli_Cmd as $key => $value) {

    echo "Client n°$key :<br>";

    foreach ($value as $cmd) {
        echo "Commande n°$cmd <br>";

        $tab = recu_Produit_By_Cmd($cmd);

        foreach ($tab as $id => $desc){

            echo "Produit n°$id :" . $desc[0] ." x " . $desc[1] . "<br>";

        }

    }
    echo "<br>";
}

?>