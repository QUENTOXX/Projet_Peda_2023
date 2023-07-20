<?php

require_once "config.php";
require_once "connection_mysqli.php";
require_once "fonction.php";
require_once "fonction_update.php";

// Vérifier si la connexion à la base de données existe déjà
global $serveur, $nomBDD, $nomUtilisateurBDD, $motDePasseBDD, $connexion;

function connexion($email, $mdp){
    global $connexion;
    $mdp = md5($mdp);
        
        $requete = $connexion->prepare("SELECT * FROM client WHERE Mail = :mail");
        $requete->bindParam(':mail', $email);
        $requete->execute();
        $utilisateur = $requete->fetch();
        $requete->closeCursor();

        if ($utilisateur != null && $mdp == $utilisateur["Mot_de_Passe"]) {
            //SESSION START CLIENT
            if(isset($_SESSION)){
                session_unset();
                session_destroy();
            }
            session_start(['cookie_lifetime' => 3600,]);
            $_SESSION['Connexion'][0] = $utilisateur['ID'];
            $_SESSION['Connexion'][1] = "client";
            return true;
        }
        $requete = $connexion->prepare("SELECT * FROM livreur WHERE email = :mail");
        $requete->bindParam(':mail', $email);
        $requete->execute();
        $utilisateur = $requete->fetch();
        $requete->closeCursor();

        if ($utilisateur != null && $mdp == $utilisateur["mdp"]){
            //SESSION START LIVREUR
            if(isset($_SESSION)){
                session_unset();
                session_destroy();
            }
            session_start(['cookie_lifetime' => 3600,]);
            $_SESSION['Connexion'][0] = $utilisateur['ID'];
            $_SESSION['Connexion'][1] = "livreur";
            return true;
        }
        $requete = $connexion->prepare("SELECT * FROM vendeur WHERE email = :mail");
        $requete->bindParam(':mail', $email);
        $requete->execute();
        $utilisateur = $requete->fetch();
        $requete->closeCursor();

        if ($utilisateur != null && $mdp == $utilisateur["mdp"]){
            if($utilisateur['admin'] == 1){
                //SESSION START ADMIN
                if(isset($_SESSION)){
                    session_unset();
                    session_destroy();
                }
                session_start(['cookie_lifetime' => 3600,]);
                $_SESSION['Connexion'][0] = $utilisateur['ID'];
                $_SESSION['Connexion'][1] = "admin";
                return true;
            }
            //SESSION START VENDEUR
            if(isset($_SESSION)){
                session_unset();
                session_destroy();
            }
            session_start(['cookie_lifetime' => 3600,]);
            $_SESSION['Connexion'][0] = $utilisateur['ID'];
            $_SESSION['Connexion'][1] = "vendeur";
            return true;
        }
    // ECHEC
    if(isset($_SESSION)){
        session_unset();
        session_destroy();
    }
    return false;
}

function checkEmail($email){
    global $connexion;
    $res = $connexion->query("SELECT Mail FROM client WHERE Mail = '$email'");
    $res = $res->fetch();
    if($res){
        return false;
    }
    $res = $connexion->query("SELECT email FROM vendeur WHERE email = '$email'");
    $res = $res->fetch();
    if($res){
        return false;
    }
    return true;
}

// Attention au chargement des images
function getProduits(){
    global $connexion;
    $req = $connexion->query("SELECT * FROM produit");
    $res = $req->fetchAll();
    $req->closeCursor();
    return ($res);
}

function built_tab($ID_Liv){
    // entrée id liv
    // sorti 2 tab de dist entre les adresses type | adresse, A | A => array (B => 2, C=> 2) ...

    global $link;

    $Tab_add = [];
    $Tab_final = [];
    $Tab_dist = [];
    $Ordre = range('A', 'Z');
    $l = 1;

    $sql_cmd = "SELECT * FROM commande WHERE ID_Livreur = $ID_Liv";
    $res_cmd = mysqli_query($link, $sql_cmd);

    if (mysqli_num_rows($res_cmd) == 0) {
        echo 'Aucune commande pour ce livreur !';

        return NULL;
    }

    $sql_liv = "SELECT * FROM livreur WHERE ID = $ID_Liv";
    $res_liv = mysqli_query($link, $sql_liv);
    $obj_liv = mysqli_fetch_object($res_liv);
    $add_liv = $obj_liv->Adresse;

    $Tab_add[$Ordre[0]] = $add_liv;

    while ($obj_cmd = mysqli_fetch_object($res_cmd)) {   //toutes les cmd du livreur

        $id_client = $obj_cmd->ID_Client;
        $sql_cli = "SELECT * FROM client WHERE ID = $id_client";
        $res_cli = mysqli_query($link, $sql_cli);
        $obj_cli = mysqli_fetch_object($res_cli);
        $add_cli = $obj_cli->Adresse;

        $Tab_add[$Ordre[$l]] = $add_cli;
        //array_push($Tab_add, $add_cli);
        $l++;
    }       // tableau des adresses sous forme B => "13 rue de l'ivrogne, RicardLand";

    /*
    foreach ($Tab_add as $key => $add) {

        $dist = calculerDistance($add_liv, $add);

        $Tab_dist[$key] = $dist;

    }

    $Tab_final[$Ordre[0]] = $Tab_dist;
    */
    foreach ($Tab_add as $key1 => $add1) {

        foreach ($Tab_add as $key2 => $add2) {

            if ($key1 != $key2) {
                
                $dist = calculerDistance($add1, $add2);
    
                $Tab_dist[$key2] = round($dist, 2);
            }
        }
        $Tab_final[$key1] = $Tab_dist;
        $Tab_dist = [];

    }

    return $Tab_final;
    /*
    for ($i=0; $i < count($Tab_add); $i++) { 
    
    }
    */
}

function affiche_cmd($id_liv){
    global $link;

    $sql_cmd = "SELECT * FROM commande WHERE ID_Livreur = $id_liv";
    $res_cmd = mysqli_query($link, $sql_cmd);

    if (mysqli_num_rows($res_cmd) == 0) {
        echo 'Aucune commande pour ce livreur !';

        return NULL;
    }

    while ($obj_cmd = mysqli_fetch_object($res_cmd)) {
        echo "Commande n°$obj_cmd->ID :<br>";
        echo "Client n°$obj_cmd->ID_Client<br>";
        echo "Valide : $obj_cmd->Valide<br>";
        echo "<br>";
    }
}

function affiche_produit($nom){
    global $connexion;
    //caractère joker % pour la recherche plus facile
    $term = "%".$nom."%"; 
    $req = $connexion->prepare("SELECT * FROM produit WHERE Nom LIKE :nom");
    $req->bindParam(":nom", $term, PDO::PARAM_STR);
    $req->execute();
    $res=$req->fetchAll();
    $req->closeCursor();
    foreach($res as $produit){
        echo "<div id='resultats'>";
        echo "<div class='produit'>";
        echo ('<img src="data:image/jpeg;base64,' . base64_encode($produit['Image']) . '"/>');
        echo "<div class='description_produit'>";
        echo "<h3>".$produit['Nom']."</h3>";
        echo "<p>".$produit['Description']."</p>";
        echo "<p>".$produit['Prix']."€</p>";
        echo "<p>".$produit['Quantite']." en stock</p>";
        echo "<form action='' method='POST'>";
        echo "<button class='btn' type='submit' name='commander' value=" . $produit["ID"]. ">Ajouter au panier</button>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    return $res;
}

function filtre_Rech($type, $col, $filtre){

    global $link;

    $sql_filtre = "SELECT * FROM '$type' WHERE '$col' = $filtre";
    $res_filtre = mysqli_query($link, $sql_filtre);

    while ($row=mysqli_fetch_object($res_filtre)) {
        echo "<tr>";
        echo "<td>$row</td>";
        echo "</td>";
        echo "</tr>";
	}
}

function filtre_Produit($col, $filtre){

    global $link;

    $sql_filtre = "SELECT * FROM produit WHERE '$col' = $filtre";
    $res_filtre = mysqli_query($link, $sql_filtre);

    while ($row=mysqli_fetch_object($res_filtre)) {
        echo "<tr>";
        echo "<td>$row</td>";
        echo "</td>";
        echo "</tr>";
	}
}

?>