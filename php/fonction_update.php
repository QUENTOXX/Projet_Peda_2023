<?php

require_once "config.php";
require_once "connection_mysqli.php";
require_once "fonction_get.php";
require_once "fonction.php";

// Vérifier si la connexion à la base de données existe déjà
global $serveur, $nomBDD, $nomUtilisateurBDD, $motDePasseBDD, $connexion;

function inscriptionClient($nom, $prenom, $email, $mdp, $tel){

    global $connexion;
    
    if(checkEmail($email)){
        //on crypte le mot de passe entree par l'utilisateur
        $mdp = md5($mdp);
        //on crée une requête SQL qui 
        $sth = $connexion->prepare("INSERT INTO client(Nom, Prénom, Mail, Mot_de_Passe, Tel) VALUES(:Nom, :Prenom, :Mail, :mdp, :tel)");
        $sth->bindValue(":Nom", $nom);
        $sth->bindValue(":Prenom", $prenom);
        $sth->bindValue(":Mail", $email);
        $sth->bindValue(":mdp", $mdp);
        $sth->bindValue(":tel", $tel);
        $sth->execute();
        $sth->closeCursor();
        return true;
    }
    return false;
    
}

function inscriptionVendeur($nom, $prenom, $email, $mdp, $tel){

    global $connexion;

    if(checkEmail($email)){
        //on crypte le mot de passe entree par l'utilisateur
        $mdp = md5($mdp);
        //on crée une requête SQL qui 
        $sth = $connexion->prepare("INSERT INTO vendeur(Nom, email, Prenom, mdp, tel) VALUES(:Nom, :Mail, :Prenom, :mdp, :tel)");
        $sth->bindValue(":Nom", $nom);
        $sth->bindValue(":Prenom", $prenom);
        $sth->bindValue(":Mail", $email);
        $sth->bindValue(":mdp", $mdp);
        $sth->bindValue(":tel", $tel);
        $sth->execute();
        $sth->closeCursor();
        return true;
    }
    return false;
}

function updateAdresse($id_client, $adresse){
    global $connexion;
    $request = $connexion->prepare("UPDATE client SET adresse = :adresse WHERE id = :id");
    $request->bindValue(":adresse", $adresse);
    $request->bindValue(":id", $id_client);
    $request->execute();
    $request->closeCursor();
}

function updateCB($id, $numero_CB, $date_CB, $crypto_CB){
    global $connexion;
    $request = $connexion->prepare("UPDATE client SET numero_CB = :numero_CB, date_CB = :date_CB, crypto_CB = :crypto_CB WHERE id = :id");
    $request->bindValue(":numero_CB", $numero_CB);
    $request->bindValue(":date_CB", $date_CB);
    $request->bindValue(":crypto_CB", $crypto_CB);
    $request->bindValue(":id", $id);
    $request->execute();
    $request->closeCursor();
}

function assignation_cmd($id_cmd){   
    // entrer cmd a livrée

    $add_close = "";
    $add_last = "";
    $add_Client = "";
    $dist_close = 0;
    $dist_last = 0;
    $liv_close = "";

    global $link;

    $sql_cmd = "SELECT * FROM commande WHERE ID = $id_cmd";
    $res_cmd = mysqli_query($link, $sql_cmd);

    if (mysqli_num_rows($res_cmd) == 0) {
        echo 'Commande invalide !';

        return NULL;
    }

    $obj_cmd = mysqli_fetch_object($res_cmd);

    if ($obj_cmd->Vendeur != NULL || $obj_cmd->Vendeur != "") {
        echo "Commande deja assigner";

        return NULL;
    }

    $sql_liv = "SELECT * FROM livreur WHERE Temps_Tournee < 7";
    $res_liv = mysqli_query($link, $sql_liv);

    if (mysqli_num_rows($res_liv) == 0) {
        // S'il n'y a aucun livreur dispo,
        echo 'aucun liveur dispo';

        return NULL;
    }

    $obj_liv = mysqli_fetch_object($res_liv);

    $sql_cli = "SELECT * FROM client WHERE ID = $obj_cmd->ID_Client";
    $res_cli = mysqli_query($link, $sql_cli);

    if (mysqli_num_rows($res_cli) == 0) {
        // S'il n'y a aucun livreur dispo,
        echo 'aucun client corespond a ce numero de commande !';

        return NULL;
    }

    $obj_cli = mysqli_fetch_object($res_cli);

    $add_Client = $obj_cli->Adresse;
    $add_close = $obj_liv->Adresse;
    $liv_close = $obj_liv->ID;
    $dist_close = round(calculerDistance($add_Client, $add_close), 2);

    while ($obj_liv = mysqli_fetch_object($res_liv)) {         //t'en quil y a des livreur dans la rech

        $add_last = $obj_liv->Adresse;
        $dist_last = round(calculerDistance($add_Client, $add_last), 2);
        if ($dist_last < $dist_close) {
            // on assigne la commande au livreur

            $liv_close = $obj_liv->ID;
            $add_close = $obj_liv->Adresse;
            $dist_close = $dist_last;
        }
    }

    $maj_cmd = "UPDATE commande SET ID_Livreur = $liv_close WHERE ID = $id_cmd"; //cmd pour mettre li du liv a la cmd
    $maj_liv = "UPDATE livreur SET Cmd_a_Livrer = Cmd_a_Livrer + 1 WHERE ID = $liv_close"; // cmd pour ajouter 1 a cmd a livrer du liv

    // Exécution de la requête
    if (mysqli_query($link, $maj_cmd) && mysqli_query($link, $maj_liv)) {
        echo "Livreur ajouté.";
    } else {
        echo "Erreur lors de l'exécution de la requête : ";
    }
}

function attribue_cmd($id_client){
    global $connexion;

    $req = $connexion->prepare("SELECT ID, Valide FROM commande WHERE ID_Client = :id_client");
    $req->bindValue(":id_client", $id_client);
    $req->execute();
    $res=$req->fetch();
    $req->closeCursor();
    if($res){
        return $res["ID"];
    }
    $req = $connexion->prepare("INSERT INTO commande (ID_Client) VALUES  ID_Client = :id_client");
    $req->bindValue(":id_client", $id_client);
    $req->execute();
    $req->closeCursor();
    attribue_cmd($id_client);
}

function ajout_panier($id_produit,$id_client,int $quantite = 1){
    global $connexion;
    $cmd = attribue_cmd($id_client);
    $res = $connexion->query("SELECT * FROM achats WHERE ID_produit = '$id_produit' AND ID_commande = '$cmd'");
    $res = $res->fetch();
        if($res){
            $quantite += $res["quantite"];
            $req = $connexion->prepare("UPDATE achats SET quantite = :quantite WHERE ID_produit = :id_produit AND ID_commande = :id");
            $req->bindValue(":quantite", $quantite);
            $req->bindValue(":id_produit", $id_produit);
            $req->bindValue(":id", $cmd);
            $req->execute();
            $req->closeCursor();
            return;
        }
    $req = $connexion-> prepare("INSERT INTO achats (ID_produit,ID_commande, quantite) VALUES (:ID_produit, :ID_commande,:quantite)");
    $req->bindValue(":ID_produit", $id_produit);
    $req->bindValue(":ID_commande", $cmd);
    $req->bindValue(":quantite", $quantite);
    $req->execute();
    $req->closeCursor();
}

function confirm_panier($id_cmd){
    global $link;


    // Vérifier que la commande est valide (Vendeur, Prix)
    $sql_cmd = "SELECT * FROM commande WHERE ID = $id_cmd";
    $res_cmd = mysqli_query($link, $sql_cmd);
    $obj_cmd = mysqli_fetch_object($res_cmd);
    $cmd_Valid = $obj_cmd->Valide;

    if ($cmd_Valid == 1) {
        echo "Commande déja validée !!";

        return null;
    }

    //verif si produit existe encore en nombre 

    $sql_achat = "SELECT * FROM commande WHERE ID = $id_cmd";
    $res_achat = mysqli_query($link, $sql_achat);
    $obj_achat = mysqli_fetch_object($res_achat);
    $achat_Vend = $obj_achat->ID_vendeur;
    $achat_Prix = $obj_achat->Prix;

    if ($achat_Prix == null || $achat_Prix == "" || $achat_Vend == null || $achat_Vend == "") {
        echo"Prix ou vendeur manquant !!";

        return null;
    }
    
    // changer valid 0-> 1 dans commande
    $maj_cmd = "UPDATE commande SET Valide = 1 WHERE ID = $id_cmd";

    // Exécution de la requête
    if (mysqli_query($link, $maj_cmd)) {
        echo "Commande validée !";
    } else {
        echo "Erreur lors de l'exécution de la requête" . $link->error;
    }

    // lancer assignation !
    assignation_cmd($id_cmd);

    // ajt prix au chiffre d'affaire mrk (pas encore)
} //bien fair ene page livreur ou il peut visualiser toute sa commande !!

function ajout_Produit($H, $L, $l, $P, $Nom, $Vendeur, $Prix, $Desc, $Image, $Quantite){

    var_dump($Image);
    //On n'a que le nom de l'image

    global $link;

    $ajt_prod = "INSERT INTO produit (Prix, Img, Descript, Quantite, Nom, Hauteur, Largeur, Longueur, Poids) VALUES ('$Prix', '$Image', '$Desc', '$Quantite', '$Nom', '$H', '$l', '$L', '$P')";

    // Exécution de la requête
    if (mysqli_query($link, $ajt_prod)) {
        echo "Produit ajouté !";
    } else {
        echo "Erreur lors de l'exécution de la requête " . $link->error;
    }

}

function update_Produit($H, $L, $l, $P, $Nom, $Vendeur, $Prix, $Desc, $Image, $Quantite, $ID){

    global $link;

    $upd_prod = "UPDATE produit SET Prix = $Prix, Img = $Image, Descript = $Desc, Quantite = $Quantite, Nom = $Nom, Hauteur = $H, Largeur = $l, Longueur = $L, Poids = $P WHERE ID = $ID";

    // Exécution de la requête
    if (mysqli_query($link, $upd_prod)) {
        echo "Produit modifier !";
    } else {
        echo "Erreur lors de l'exécution de la requête" . $link->error;
    }
}

function suppr_Produit($ID){

    global $link;

    $del_prod = "DELETE FROM produit WHERE ID = $ID";

    // Exécution de la requête
    if (mysqli_query($link, $del_prod)) {
        echo "Produit supprimer !";
    } else {
        echo "Erreur lors de l'exécution de la requête" . $link->error;
    }
}

function ajout_Compte_Cli($Prénom, $Nom, $Mail, $Tel, $Adresse, $Date_contrat, $Mot_de_Passe, $numero_CB, $date_CB, $crypto_CB){

    global $link;

    $ajt_cli = "INSERT INTO client (Prénom, Nom, Mail, Tel, Adresse, Date_contrat, Mot_de_Passe, numero_CB, date_CB, crypto_CB) VALUES ($Prénom, $Nom, $Mail, $Tel, $Adresse, $Date_contrat, $Mot_de_Passe, $numero_CB, $date_CB, $crypto_CB)";

    // Exécution de la requête
    if (mysqli_query($link, $ajt_cli)) {
        echo "Client ajouté !";
    } else {
        echo "Erreur lors de l'exécution de la requête" . $link->error;
    }
}

function ajout_Compte_Liv($Prénom, $Nom, $Mail, $Adresse, $Permis, $Mot_de_Passe, $Type_Véhicule, $Cmd_a_Livrer, $Temps_Tournee){

    global $link;

    $ajt_li = "INSERT INTO client (Prénom, Nom, Cmd_a_Livrer, Adresse, Permis, Type_Véhicule, Temps_Tournee, email, mdp) VALUES ($Prénom, $Nom, $Cmd_a_Livrer, $Adresse, $Permis, $Type_Véhicule, $Temps_Tournee, $Mail, $Mot_de_Passe)";

    // Exécution de la requête
    if (mysqli_query($link, $ajt_cliv)) {
        echo "Livreur ajouté !";
    } else {
        echo "Erreur lors de l'exécution de la requête" . $link->error;
    }
}

function update_Compte_Cli($Prénom, $Nom, $Mail, $Tel, $Adresse, $numero_CB, $date_CB, $crypto_CB, $ID){

    global $link;

    $upd_cli = "UPDATE client SET Prénom = '$Prénom', Nom = '$Nom', Mail = '$Mail', Tel = $Tel, Adresse = '$Adresse', numero_CB = $numero_CB, date_CB = '$date_CB', crypto_CB = '$crypto_CB' WHERE ID = $ID";

    // Exécution de la requête
    if (mysqli_query($link, $upd_cli)) {
        echo "Client modifier !";
    } else {
        echo "Erreur lors de l'exécution de la requête" . $link->error;
    }
}

function update_Compte_Vend($Nom, $Mail, $Adresse, $ID_Produit_Vendu, $admin, $tel, $Prenom, $ID){

    global $link;

    $upd_vend = "UPDATE client SET Prenom = $Prenom, Nom = $Nom, ID_Produit_Vendu = $ID_Produit_Vendu, admin = $admin, email = $Mail, tel = $tel WHERE ID = $ID";

    // Exécution de la requête
    if (mysqli_query($link, $upd_vend)) {
        echo "Vendeur modifier !";
    } else {
        echo "Erreur lors de l'exécution de la requête" . $link->error;
    }
}

function update_Compte_Liv($Prénom, $Nom, $Mail, $Adresse, $Permis, $Type_Véhicule, $Cmd_a_Livrer, $Temps_Tournee){

    global $link;

    $upd_liv = "UPDATE client SET Prénom = $Prénom, Nom = $Nom, email = $Mail, Adresse = $Adresse, Permis = $Permis, Type_Véhicule = $Type_Véhicule, Cmd_a_Livrer = $Cmd_a_Livrer, Temps_Tournee = $Temps_Tournee WHERE ID = $ID";

    // Exécution de la requête
    if (mysqli_query($link, $upd_liv)) {
        echo "Livreur modifier !";
    } else {
        echo "Erreur lors de l'exécution de la requête" . $link->error;
    }
}

function suppr_Compte($ID, $type){      // attention bien ecrire le type like bdd sinon bruh

    global $link;

    $del_adm = "DELETE FROM $type WHERE ID = $ID";

    // Exécution de la requête
    if (mysqli_query($link, $del_adm)) {
        echo "Compte supprimer !";
    } else {
        echo "Erreur lors de l'exécution de la requête" . $link->error;
    }
}

?>