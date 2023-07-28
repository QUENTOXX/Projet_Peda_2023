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

        if ($utilisateur != null && $mdp == $utilisateur["mdp"]) {
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
            if($utilisateur['ouiadmin'] == '1'){
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
    $res = $connexion->query("SELECT email FROM livreur WHERE email = '$email'");
    $res = $res->fetch();
    if($res){
        return false;
    }
    return true;
}

function getProduitsByID($ID){
    global $connexion;
    $req = $connexion->query("SELECT * FROM produit WHERE ID = $ID");
    $res = $req->fetch();
    $req->closeCursor();
    return ($res);
}

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

        $Tab_add[$id_client] = $add_cli;
        //$l++;


    }       // tableau des adresses sous forme id client => "13 rue de l'ivrogne, RicardLand";

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

    $tab_cli = [];
    $tab_cmd = [];

    $sql_cmd = "SELECT * FROM commande WHERE ID_Livreur = $id_liv";
    $res_cmd = mysqli_query($link, $sql_cmd);

    if (mysqli_num_rows($res_cmd) == 0) {
        echo 'Aucune commande pour ce livreur !';

        return NULL;
    }

    while ($obj_cmd = mysqli_fetch_object($res_cmd)) {
        
        if (isset($tab_cli[$obj_cmd->ID_Client])) {
            
            $tab_cmd = $tab_cli[$obj_cmd->ID_Client];
        }
        array_push($tab_cmd, $obj_cmd->ID);
        $tab_cli[$obj_cmd->ID_Client] = $tab_cmd;
        $tab_cmd = [];

    }

    foreach ($tab_cli as $key => $value) {

        $sql_cli = "SELECT * FROM client WHERE ID = $key";
        $res_cli = mysqli_query($link, $sql_cli);
        $obj_cli = mysqli_fetch_object($res_cli);
        $add_cli = $obj_cli->Adresse;

        echo "Client n°$key : $add_cli<br>";
        
        foreach ($value as $cmd) {
            echo "Commande n°$cmd <br>";
        }
        echo "<br>";
    }
    return $tab_cli;
}

function filtre_produit($nom, $prixMIN, $prixMAX, $prixOrder = null){
    global $connexion;

    $orderby = "";

    if (isset($prixOrder) && $prixOrder == "ASC"){
        $orderby = "ORDER BY Prix ASC";
    } elseif (isset($prixOrder) && $prixOrder == "DESC"){
        $orderby = "ORDER BY Prix DESC";
    }
    //caractère joker % pour la recherche plus facile
    $term = "%".$nom."%"; 
    $req = $connexion->prepare("SELECT * FROM produit WHERE Nom LIKE :nom AND Prix >= :prixMIN AND Prix <= :prixMAX " . $orderby );
    $req->bindParam(":nom", $term, PDO::PARAM_STR);
    $req->bindValue(":prixMIN", $prixMIN);
    $req->bindValue(":prixMAX", $prixMAX);
    $req->execute();
    $res=$req->fetchAll();
    $req->closeCursor();

    return $res;
}

function recup_Data_Vendeur($ID_Vend){

    global $link;

    $data = [];

    $sql_data = "SELECT * FROM vendeur WHERE ID = $ID_Vend";
    $res_data = mysqli_query($link, $sql_data);

    $sql = "DESCRIBE vendeur";
    $result = $link->query($sql);

    $obj = mysqli_fetch_object($res_data);

    while($row = $result->fetch_assoc()){

        $var = $row['Field'];

        $data[$var] = $obj->$var;
    }

    return $data;
}

function recup_Data_Client($ID_Cli){

    global $link;

    $data = [];

    $sql_data = "SELECT * FROM client WHERE ID = $ID_Cli";
    $res_data = mysqli_query($link, $sql_data);

    $sql = "DESCRIBE client";
    $result = $link->query($sql);

    $obj = mysqli_fetch_object($res_data);

    while($row = $result->fetch_assoc()){

        $var = $row['Field'];

        $data[$var] = $obj->$var;
    }

    return $data;
}

function recup_Data_Livreur($ID_Liv){

    global $link;

    $data = [];

    $sql_data = "SELECT * FROM livreur WHERE ID = $ID_Liv";
    $res_data = mysqli_query($link, $sql_data);

    $sql = "DESCRIBE livreur";
    $result = $link->query($sql);

    $obj = mysqli_fetch_object($res_data);

    while($row = $result->fetch_assoc()){

        $var = $row['Field'];

        $data[$var] = $obj->$var;
    }

    return $data;
}

function check($mdp){
    global $connexion;
    $type = $_SESSION['Connexion'][1];
    $id = $_SESSION['Connexion'][0];
    $mdp = md5($mdp);
    if ($type == 'admin'){$type = 'vendeur';}
    $req = $connexion->query("SELECT * FROM $type WHERE ID = '$id'");
    $req->execute();
    $res=$req->fetch();
    $req->closeCursor();
    if($mdp == $res['mdp']){
        return true;
    }
    return false;
}

function recu_Produit_By_Vendeur($ID_Vend){

    global $link;

    $data = [];
    $desc = [];
    $all_Data = [];

    $sql_data = "SELECT * FROM produit WHERE ID_Vendeur = $ID_Vend";
    $res_data = mysqli_query($link, $sql_data);

    $sql = "DESCRIBE produit";
    $result = $link->query($sql);

    while($row = $result->fetch_assoc()){

        array_push($desc, $row['Field']);
    }

    while($obj = mysqli_fetch_object($res_data)){

        foreach ($desc as $value) {
            
            $data[$value] = $obj->$value;
        }
        array_push($all_Data, $data);
    }


    return $all_Data;
}

function getCart($id_client){
    global $connexion;
    
    $ID = getIDcmd($id_client);
    if($ID){
        $req = $connexion->query("SELECT * from achats WHERE ID_commande = $ID");
        $req->execute();
        $res = $req->fetchAll();
        $req->closeCursor();
        return $res;
    }else{
        return false;
    }
    
}

function getIDcmd($id_client){
    global $connexion;

    $req = $connexion->query("SELECT ID from commande WHERE ID_Client = '$id_client' AND Valide = '0'");
    $req->execute();
    $res = $req->fetch();
    $req->closeCursor();
    if (!isset($res) || !$res){
        return false;
    } else{
        return $res['ID'];
    }
}

function recu_Produit_By_Cmd($ID_Cmd){

    global $link;

    $data = [];
    $desc = [];

    $sql_data = "SELECT * FROM achats WHERE ID_commande = $ID_Cmd";
    $res_data = mysqli_query($link, $sql_data);

    while($obj = mysqli_fetch_object($res_data)){

        $data[$obj->ID_produit] = $obj->quantite;
    }

    foreach ($data as $key => $value) {

        $sql_prod = "SELECT * FROM produit WHERE ID = $key";
        $res_prod = mysqli_query($link, $sql_prod);
        $obj_prod = mysqli_fetch_object($res_prod);

        array_push($desc, $obj_prod->Nom);
        array_push($desc, $value);

        $data[$key] = $desc;
        $desc = [];
    }

    return $data; // tab sous form $data[id_cmd] = [nom_prod, qtt]
}

function recup_Statut($ID_Cmd, $ID_Produit){

    global $link;

    $sql_data = "SELECT * FROM achats WHERE ID_commande = $ID_Cmd AND ID_produit = $ID_Produit";
    $res_data = mysqli_query($link, $sql_data);
    $obj = mysqli_fetch_object($res_data);

    return $obj->statut;

}

function recup_Cmd_By_Cli($id_client){

    global $link;

    $data = [];

    $sql_data = "SELECT * from commande WHERE ID_Client = $id_client";
    $res_data = mysqli_query($link, $sql_data);

    while($obj = mysqli_fetch_object($res_data)){

        array_push($data, $obj->ID);
    }

    return $data;
}

function get_contrats_vendeur(){
    global $connexion;
    $req = $connexion->query("SELECT * FROM vendeur WHERE ID_Vendeur IS NOT NULL");
    $req->execute();
    $res = $req->fetchAll();
    $req->closeCursor();
    return $res;
}

function get_contrats_livreur(){
    global $connexion;
    $req = $connexion->query("SELECT * FROM livreur WHERE ID_Livreur IS NOT NULL");
    $req->execute();
    $res = $req->fetchAll();
    $req->closeCursor();
    return $res;
}

function affiche_Contrat($id, $type){

    global $link;

    $sql_data = "SELECT * from $type WHERE ID = $id";
    $res_data = mysqli_query($link, $sql_data);

    if($res_data){
        $obj = mysqli_fetch_object($res_data);
        $blob = $obj->contrat;
        header("Content-Type: application/pdf");
        header("Content-Disposition: inline;");
        echo $blob;
    }else echo "Pas de contrat pour cette personne";


    //echo '<img src="data:application/pdf;base64,'.base64_encode($blob).'"/>';
    //print('<iframe src=" ' . base64_encode($blob) .' " type="application/pdf" width="100%" height="100%" style="overflow: auto;"></iframe>');
}
?>