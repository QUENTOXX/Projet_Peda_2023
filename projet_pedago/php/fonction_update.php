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
        $sth = $connexion->prepare("INSERT INTO client(Nom, Prénom, Mail, mdp, Tel) VALUES(:Nom, :Prenom, :Mail, :mdp, :tel)");
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

function inscriptionLivreur($nom, $prenom, $email, $mdp, $adresse,$temps,$permis, $vehicule){

    global $connexion;
    
    if(checkEmail($email)){
        //on crypte le mot de passe entree par l'utilisateur
        $mdp = md5($mdp);
        //on crée une requête SQL qui 
        $sth = $connexion->prepare("INSERT INTO livreur(Nom, email, Prénom, mdp, Adresse,Temps_Tournee,Permis,Type_Véhicule) VALUES(:Nom, :Mail, :Prenom, :mdp, :adresse,:temps ,:permis, :type_vehicule)");
        $sth->bindValue(":Nom", $nom);
        $sth->bindValue(":Prenom", $prenom);
        $sth->bindValue(":Mail", $email);
        $sth->bindValue(":mdp", $mdp);
        $sth->bindValue(":adresse", $adresse);
        $sth->bindValue(":temps", $temps);
        $sth->bindValue(":permis", $permis);
        $sth->bindValue(":type_vehicule", $vehicule);
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
        echo '<p id="erreur">Commande invalide !</p>';

        return NULL;
    }

    $obj_cmd = mysqli_fetch_object($res_cmd);

    if ($obj_cmd->ID_Livreur != NULL && $obj_cmd->ID_Livreur != "") {
        echo "<p id='erreur'>Commande deja assigner</p>";

        return NULL;
    }

    $sql_liv = "SELECT * FROM livreur WHERE Temps_Tournee < 7";
    $res_liv = mysqli_query($link, $sql_liv);

    if (mysqli_num_rows($res_liv) == 0) {
        // S'il n'y a aucun livreur dispo,
        echo '<p id="erreur">aucun liveur dispo</p>';

        return NULL;
    }

    $obj_liv = mysqli_fetch_object($res_liv);

    $sql_cli = "SELECT * FROM client WHERE ID = $obj_cmd->ID_Client";
    $res_cli = mysqli_query($link, $sql_cli);

    if (mysqli_num_rows($res_cli) == 0) {
        // S'il n'y a aucun livreur dispo,
        echo '<p id="erreur">aucun client corespond a ce numero de commande !</p>';

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
        echo "<p id='erreur'>Livreur ajouté.</p>";
    } else {
        echo "<p id='erreur'>Erreur lors de l'exécution de la requête : </p>";
    }
}

function attribue_cmd($id_client){
    global $connexion;

    $ID = getIDcmd($id_client);

    if($ID){
        return $ID;
    }

    $req = $connexion->prepare("INSERT INTO commande (ID_Client) VALUES  (:id_client)");
    $req->bindValue(":id_client", $id_client);
    $req->execute();
    $req->closeCursor();
    
    return getIDcmd($id_client);
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

function confirm_panier($id_client){
    global $link;

    $id_cmd = getIDcmd($id_client);

    $sql_cmd = "SELECT * FROM commande WHERE ID = $id_cmd";
    $res_cmd = mysqli_query($link, $sql_cmd);
    $obj_cmd = mysqli_fetch_object($res_cmd);
    $cmd_Valid = $obj_cmd->Valide;

    if ($cmd_Valid == 1) {
        echo "<p id='erreur'>Commande déja validée !!</p>";

        return null;
    }

    //verif si produit existe encore en nombre et elever la qtt 

    $produits_achats = getCart($id_client);
    //boucle
    //$produits_achats[$i]['ID_produit'];

    foreach ($produits_achats as $value) {

        $id = $value['ID_produit'];
        $sql_prod = "SELECT * FROM produit WHERE ID = $id";
        $res_prod = mysqli_query($link, $sql_prod);
        $obj_prod = mysqli_fetch_object($res_prod);
        $qtt_prod = $obj_prod->Quantite;

        if ($value['quantite'] > $qtt_prod) {
            
            echo("<p id='erreur'>Produit $obj_prod->Nom non disponible !</p>");
            return NULL;
        }

        $qtt = $qtt_prod - $value['quantite'];
        $maj_prod = "UPDATE produit SET Quantite = $qtt WHERE ID = $id";

            // Exécution de la requête
        if (mysqli_query($link, $maj_prod)) {
            echo "<p id='erreur'>Produit OK !</p>";
        } else {
            echo "<p id='erreur'>Erreur lors de l'exécution de la requête</p>" . $link->error;
        }
    }
    
    // changer valid 0-> 1 dans commande
    $maj_cmd = "UPDATE commande SET Valide = 1 WHERE ID = $id_cmd";

    // Exécution de la requête
    if (mysqli_query($link, $maj_cmd)) {
        echo "<p id='erreur'>Commande validée !</p>";
    } else {
        echo "<p id='erreur'>Erreur lors de l'exécution de la requête</p>" . $link->error;
    }

    // lancer assignation !
    assignation_cmd($id_cmd);

    // ajt prix au chiffre d'affaire mrk (pas encore)
} //bien fair ene page livreur ou il peut visualiser toute sa commande !!

function ajout_Produit($H, $L, $l, $P, $Nom, $Prix, $Desc, $Image, $Quantite, $ID_Vendeur){

    global $link;

    $path = 'C:/wamp64/www/projet_pedago/img/produits/';
    $pathprod = 'C:/wamp64/www/projet_pedago/img/produits/' . $Image;

    $infoImage = getimagesize($pathprod);

    $imgL = $infoImage[0];
    $imgH = $infoImage[1];

    $newH = 300;

    //$ratio = ($newH * $imgH)/100;
    $ratio = ($newH / $imgH);

    $newL = $imgL * $ratio;

    if ($infoImage !== false) {
        // $infoImage[2] contient le type de l'image
        // 1 pour les images GIF, 2 pour les images JPEG, et 3 pour les images PNG
        if ($infoImage[2] === IMAGETYPE_PNG) {

            $imageSource = imagecreatefrompng($pathprod);

            // Obtenir la taille actuelle de l'image
            $largeurOriginale = imagesx($imageSource);
            $hauteurOriginale = imagesy($imageSource);

            // Créer une nouvelle image vide avec la taille souhaitée
            $nouvelleImage = imagecreatetruecolor($newL, $newH);

            // Redimensionner l'image d'origine vers la nouvelle image avec la fonction imagecopyresampled
            imagecopyresampled(
                $nouvelleImage, // Image de destination (nouvelle image)
                $imageSource,   // Image source (image d'origine)
                0, 0,           // Coordonnées x et y de la destination
                0, 0,           // Coordonnées x et y de la source (commence à partir du coin supérieur gauche)
                $newL, // Nouvelle largeur de la destination
                $newH, // Nouvelle hauteur de la destination
                $largeurOriginale, // Largeur de la source (image d'origine)
                $hauteurOriginale  // Hauteur de la source (image d'origine)
            );

            // Enregistrer la nouvelle image dans un fichier ou afficher directement sur la page
            $Image = "rd".$Image;
            $newpath = $path.$Image;
            imagepng($nouvelleImage, $newpath);

            // Libérer la mémoire en supprimant les images de la mémoire
            imagedestroy($imageSource);
            imagedestroy($nouvelleImage);

            // Supprimer la première image
            if (file_exists($pathprod)) {
                unlink($pathprod);
            }

        } elseif ($infoImage[2] === IMAGETYPE_JPEG) {

            $imageSource = imagecreatefromjpeg($pathprod);

            // Obtenir la taille actuelle de l'image
            $largeurOriginale = imagesx($imageSource);
            $hauteurOriginale = imagesy($imageSource);

            // Créer une nouvelle image vide avec la taille souhaitée
            $nouvelleImage = imagecreatetruecolor($newL, $newH);

            // Redimensionner l'image d'origine vers la nouvelle image avec la fonction imagecopyresampled
            imagecopyresampled(
                $nouvelleImage, // Image de destination (nouvelle image)
                $imageSource,   // Image source (image d'origine)
                0, 0,           // Coordonnées x et y de la destination
                0, 0,           // Coordonnées x et y de la source (commence à partir du coin supérieur gauche)
                $newL, // Nouvelle largeur de la destination
                $newH, // Nouvelle hauteur de la destination
                $largeurOriginale, // Largeur de la source (image d'origine)
                $hauteurOriginale  // Hauteur de la source (image d'origine)
            );

            // Enregistrer la nouvelle image dans un fichier ou afficher directement sur la page
            $Image = "rd".$Image;
            $newpath = $path.$Image;
            imagejpeg($nouvelleImage, $newpath);

            // Libérer la mémoire en supprimant les images de la mémoire
            imagedestroy($imageSource);
            imagedestroy($nouvelleImage);

            // Supprimer la première image
            if (file_exists($pathprod)) {
                unlink($pathprod);
            }

        } else {
            echo '<p id="erreur">L\'image n\'est ni de type PNG ni de type JPEG.</p>';
        }
    } else {
        echo '<p id="erreur">Impossible de lire les informations de l\'image.</p>';
    }

    $ajt_prod = "INSERT INTO produit (Prix, Img, Descript, Quantite, Nom, Hauteur, Largeur, Longueur, Poids, ID_Vendeur) VALUES ('$Prix', '$Image', '$Desc', '$Quantite', '$Nom', '$H', '$l', '$L', '$P', $ID_Vendeur)";

    // Exécution de la requête
    if (mysqli_query($link, $ajt_prod)) {
        echo "<p id='erreur'>Produit ajouté !</p>";
    } else {
        echo "<p id='erreur'>Erreur lors de l'exécution de la requête </p>" . $link->error;
    }

}

function update_Produit($H, $L, $l, $P, $Nom, $Prix, $Desc, $Image, $Quantite, $ID, $ID_Vendeur){

    global $link;

    $path = 'C:/wamp64/www/projet_pedago/img/produits/';
    $pathprod = 'C:/wamp64/www/projet_pedago/img/produits/' . $Image;

    $infoImage = getimagesize($pathprod);

    $imgL = $infoImage[0];
    $imgH = $infoImage[1];

    $newH = 300;

    //$ratio = ($newH * $imgH)/100;
    $ratio = ($newH / $imgH);

    $newL = $imgL * $ratio;

    if ($infoImage !== false) {
        // $infoImage[2] contient le type de l'image
        // 1 pour les images GIF, 2 pour les images JPEG, et 3 pour les images PNG
        if ($infoImage[2] === IMAGETYPE_PNG) {

            $imageSource = imagecreatefrompng($pathprod);

            // Obtenir la taille actuelle de l'image
            $largeurOriginale = imagesx($imageSource);
            $hauteurOriginale = imagesy($imageSource);

            // Créer une nouvelle image vide avec la taille souhaitée
            $nouvelleImage = imagecreatetruecolor($newL, $newH);

            // Redimensionner l'image d'origine vers la nouvelle image avec la fonction imagecopyresampled
            imagecopyresampled(
                $nouvelleImage, // Image de destination (nouvelle image)
                $imageSource,   // Image source (image d'origine)
                0, 0,           // Coordonnées x et y de la destination
                0, 0,           // Coordonnées x et y de la source (commence à partir du coin supérieur gauche)
                $newL, // Nouvelle largeur de la destination
                $newH, // Nouvelle hauteur de la destination
                $largeurOriginale, // Largeur de la source (image d'origine)
                $hauteurOriginale  // Hauteur de la source (image d'origine)
            );

            // Enregistrer la nouvelle image dans un fichier ou afficher directement sur la page
            $Image = "rd".$Image;
            $newpath = $path.$Image;
            imagepng($nouvelleImage, $newpath);

            // Libérer la mémoire en supprimant les images de la mémoire
            imagedestroy($imageSource);
            imagedestroy($nouvelleImage);

            // Supprimer la première image
            if (file_exists($pathprod)) {
                unlink($pathprod);
            }

        } elseif ($infoImage[2] === IMAGETYPE_JPEG) {

            $imageSource = imagecreatefromjpeg($pathprod);

            // Obtenir la taille actuelle de l'image
            $largeurOriginale = imagesx($imageSource);
            $hauteurOriginale = imagesy($imageSource);

            // Créer une nouvelle image vide avec la taille souhaitée
            $nouvelleImage = imagecreatetruecolor($newL, $newH);

            // Redimensionner l'image d'origine vers la nouvelle image avec la fonction imagecopyresampled
            imagecopyresampled(
                $nouvelleImage, // Image de destination (nouvelle image)
                $imageSource,   // Image source (image d'origine)
                0, 0,           // Coordonnées x et y de la destination
                0, 0,           // Coordonnées x et y de la source (commence à partir du coin supérieur gauche)
                $newL, // Nouvelle largeur de la destination
                $newH, // Nouvelle hauteur de la destination
                $largeurOriginale, // Largeur de la source (image d'origine)
                $hauteurOriginale  // Hauteur de la source (image d'origine)
            );

            // Enregistrer la nouvelle image dans un fichier ou afficher directement sur la page
            $Image = "rd".$Image;
            $newpath = $path.$Image;
            imagejpeg($nouvelleImage, $newpath);

            // Libérer la mémoire en supprimant les images de la mémoire
            imagedestroy($imageSource);
            imagedestroy($nouvelleImage);

            // Supprimer la première image
            if (file_exists($pathprod)) {
                unlink($pathprod);
            }

        } else {
            echo '<p id="erreur">L\'image n\'est ni de type PNG ni de type JPEG.</p>';
        }
    } else {
        echo '<p id="erreur">Impossible de lire les informations de l\'image.</p>';
    }

    $upd_prod = "UPDATE produit SET Prix = $Prix, Img = '$Image', Descript = '$Desc', Quantite = $Quantite, Nom = '$Nom', Hauteur = $H, Largeur = $l, Longueur = $L, Poids = $P, ID_Vendeur = $ID_Vendeur WHERE ID = $ID";

    // Exécution de la requête
    if (mysqli_query($link, $upd_prod)) {
        echo "<p id='erreur'>Produit modifier !</p>";
    } else {
        echo "<p id='erreur'>Erreur lors de l'exécution de la requête</p>" . $link->error;
    }
}

function suppr_Produit($ID){

    global $link;

    $del_prod = "DELETE FROM produit WHERE ID = $ID";
    $del_achat = "DELETE FROM achat WHERE ID_produit = $ID";

    // Exécution de la requête
    if (mysqli_query($link, $del_prod)) {
        mysqli_query($link, $del_achat);
        echo "<p id='erreur'>Produit supprimer !</p>";
    } else {
        echo "<p id='erreur'>Erreur lors de l'exécution de la requête</p>" . $link->error;
    }
}

function ajout_Compte_Cli($Prénom, $Nom, $Mail, $Tel, $Adresse, $Date_contrat, $mdp, $numero_CB, $date_CB, $crypto_CB){

    global $link;

    $ajt_cli = "INSERT INTO client (Prénom, Nom, Mail, Tel, Adresse, Date_contrat, mdp, numero_CB, date_CB, crypto_CB) VALUES ('$Prénom', '$Nom', '$Mail', '$Tel', '$Adresse', $Date_contrat, '$mdp', $numero_CB, $date_CB, $crypto_CB)";

    // Exécution de la requête
    if (mysqli_query($link, $ajt_cli)) {
        echo "<p id='erreur'>Client ajouté !</p>";
    } else {
        echo "<p id='erreur'>Erreur lors de l'exécution de la requête</p>" . $link->error;
    }
}

function ajout_Compte_Liv($Prénom, $Nom, $Mail, $Adresse, $Permis, $mdp, $Type_Véhicule, $Cmd_a_Livrer, $Temps_Tournee){

    global $link;

    $ajt_li = "INSERT INTO livreur (Prénom, Nom, Cmd_a_Livrer, Adresse, Permis, Type_Véhicule, Temps_Tournee, email, mdp) VALUES ('$Prénom', '$Nom', $Cmd_a_Livrer, '$Adresse', '$Permis', '$Type_Véhicule', $Temps_Tournee, '$Mail', $mdp)";

    // Exécution de la requête
    if (mysqli_query($link, $ajt_cliv)) {
        echo "<p id='erreur'>Livreur ajouté !</p>";
    } else {
        echo "<p id='erreur'>Erreur lors de l'exécution de la requête</p>" . $link->error;
    }
}

function update_Compte_Cli($Prénom, $Nom, $Mail, $Tel, $Adresse, $numero_CB, $date_CB, $crypto_CB, $ID){

    global $link;

    $upd_cli = "UPDATE client SET Prénom = '$Prénom', Nom = '$Nom', Mail = '$Mail', Tel = $Tel, Adresse = '$Adresse', numero_CB = $numero_CB, date_CB = '$date_CB', crypto_CB = '$crypto_CB' WHERE ID = $ID";

    // Exécution de la requête
    if (mysqli_query($link, $upd_cli)) {
        echo "<p id='erreur'>Client modifier !</p>";
    } else {
        echo "<p id='erreur'>Erreur lors de l'exécution de la requête</p>" . $link->error;
    }
}

function update_Compte_Vend($Nom, $Mail, $admin, $tel, $Prenom, $ID){

    global $link;

    $upd_vend = "UPDATE vendeur SET Prenom = '$Prenom', Nom = '$Nom', ouiadmin = $admin, email = '$Mail', tel = $tel WHERE ID = $ID";

    // Exécution de la requête
    if (mysqli_query($link, $upd_vend)) {
        echo "<p id='erreur'>Vendeur modifier !</p>";
    } else {
        echo "<p id='erreur'>Erreur lors de l'exécution de la requête</p>" . $link->error;
    }
}

function update_Compte_Liv($Prénom, $Nom, $Mail, $Adresse, $Permis, $Type_Véhicule, $ID){

    global $link;

    $upd_liv = "UPDATE livreur SET Prénom = '$Prénom', Nom = '$Nom', email = '$Mail', Adresse = '$Adresse', Permis = '$Permis', Type_Véhicule = '$Type_Véhicule' WHERE ID = $ID";

    // Exécution de la requête
    if (mysqli_query($link, $upd_liv)) {
        echo "<p id='erreur'>Livreur modifier !</p>";
    } else {
        echo "<p id='erreur'>Erreur lors de l'exécution de la requête</p>" . $link->error;
    }
}

function suppr_Compte($ID, $type){      // attention bien ecrire le type like bdd sinon bruh

    global $link;

    $del_adm = "DELETE FROM $type WHERE ID = $ID";

    // Exécution de la requête
    if (mysqli_query($link, $del_adm)) {
        echo "<p id='erreur'>Compte supprimer !</p>";
    } else {
        echo "<p id='erreur'>Erreur lors de l'exécution de la requête</p>" . $link->error;
    }
}

function change_quantite($id_client, $id_produit, $quantite){
    global $connexion;

    $id_commande = getIDcmd($id_client);
    $req = $connexion->query("UPDATE achats SET quantite = $quantite WHERE ID_commande = $id_commande AND ID_produit = $id_produit");
}

function supprimerPanier($id_cmd, $id_produit){
    global $link;

    $del_achat = "DELETE FROM achats WHERE ID_commande = $id_cmd AND ID_produit = $id_produit";

    // Exécution de la requête
    if (mysqli_query($link, $del_achat)) {
        echo "<p id='erreur'>Produit supprimer du panier !</p>";
    } else {
        echo "<p id='erreur'>Erreur lors de l'exécution de la requête</p>" . $link->error;
    }
}

function maj_CB_Add($ID, $num_CB, $date_CB, $crypto_CB, $Adresse){

    global $link;

    $upd_cli = "UPDATE client SET Adresse = '$Adresse', numero_CB = $num_CB, date_CB = '$date_CB', crypto_CB = '$crypto_CB' WHERE ID = $ID";

    // Exécution de la requête
    if (mysqli_query($link, $upd_cli)) {
        echo "<p id='erreur'>Client à jour !</p>";
    } else {
        echo "<p id='erreur'>Erreur lors de l'exécution de la requête</p>" . $link->error;
    }

}

function upd_Statuts($statuts, $ID_Cmd, $ID_Produit){

    global $link;

    $upd_cli = "UPDATE achats SET statut = $statuts WHERE ID_commande = $ID_Cmd AND ID_produit = $ID_Produit";

    // Exécution de la requête
    if (mysqli_query($link, $upd_cli)) {
        echo "";
    } else {
        echo "<p id='erreur'>Erreur lors de l'exécution de la requête</p>" . $link->error;
    }
}

function Abonnement($id_client, $plan, $date_contrat = null){
    global $connexion;

    if (!isset($date_contrat)){
        $date_contrat = date('Y-m-d');
    }
    $date_contrat = date_create($date_contrat);
    if ($plan == 'monthly'){
        date_add($date_contrat,date_interval_create_from_date_string("1 month"));
    } else{
        date_add($date_contrat,date_interval_create_from_date_string("1 year"));
    }
    $date = $date_contrat->format('Y-m-d  H:i:s');
    $req = $connexion->query("UPDATE client SET Date_contrat = '$date' WHERE ID = $id_client");
}

function res_Contrat($ID, $type){      // attention bien ecrire le type like bdd sinon bruh

    global $link;

    $del_adm = "UPDATE $type SET contrat = NULL WHERE ID = $ID";

    // Exécution de la requête
    if (mysqli_query($link, $del_adm)) {
        echo "<p id='erreur'>Contrat résilié !</p>";
    } else {
        echo "<p id='erreur'>Erreur lors de l'exécution de la requête</p>" . $link->error;
    }
}
?>