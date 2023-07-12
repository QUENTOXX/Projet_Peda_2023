<?php
// Variable globale pour stocker la connexion à la base de données
require_once "config.php";
require_once "connection_mysqli.php";

function obtenirConnexionBDD() {
    // Vérifier si la connexion à la base de données existe déjà
    global $serveur, $nomBDD, $nomUtilisateurBDD, $motDePasseBDD, $connexion;
    if ($connexion !== null) {
        return $connexion;
    }

    try {
        // Connexion à la base de données avec PDO
        $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD;charset=utf8", $nomUtilisateurBDD, $motDePasseBDD);

        // Définition des options PDO
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $connexion;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}

function connexion($email, $mdp) {
    // Obtenir la connexion à la base de données
    $connexion = obtenirConnexionBDD();
    $mdp = md5($mdp);

    try {
        // Préparation de la requête avec des paramètres
        $requete = $connexion->prepare("SELECT * FROM client WHERE Mail = :mail");
        $requete->bindParam(':mail', $email);
        $requete->execute();

        // Récupération du résultat
        $utilisateur = $requete->fetch();
        $requete->closeCursor();

        // Vérification du mot de passe
        if ($utilisateur != null && $mdp == $utilisateur["Mot_de_Passe"]) {
            // Authentification réussie
            return true;
        }
    } catch (PDOException $e) {
        die("Erreur de requête : " . $e->getMessage());
    }
    // Authentification échouée
    return false;
}

function inscription($nom, $prenom, $email, $mdp, $tel){
    
    $connexion = obtenirConnexionBDD();
    
    //on crypte le mot de passe entree par l'utilisateur
    $mdp = md5($mdp);
    //on crée une requête SQL qui 
    $sth = $connexion -> prepare("INSERT INTO client(Nom, Prénom, Mail, Mot_de_Passe, Tel) VALUES(:Nom, :Prenom, :Mail, :mdp, :tel)");
    $sth->bindValue(":Nom", $nom);
    $sth->bindValue(":Prenom", $prenom);
    $sth->bindValue(":Mail", $email);
    $sth->bindValue(":mdp", $mdp);
    $sth->bindValue(":tel", $tel);
    $sth->execute();
    $sth->closeCursor();

}
function updateAdresse($id_client, $adresse){
    $connexion = obtenirConnexionBDD();
    $request = $connexion->prepare("UPDATE client SET adresse = :adresse WHERE id = :id");
    $request->bindValue(":adresse", $adresse);
    $request->bindValue(":id", $id_client);
    $request->execute();
    $request->closeCursor();
}
function updateCB($id, $numero_CB, $date_CB, $crypto_CB){
    $connexion = obtenirConnexionBDD();
    $request = $connexion->prepare("UPDATE client SET numero_CB = :numero_CB, date_CB = :date_CB, crypto_CB = :crypto_CB WHERE id = :id");
    $request->bindValue(":numero_CB", $numero_CB);
    $request->bindValue(":date_CB", $date_CB);
    $request->bindValue(":crypto_CB", $crypto_CB);
    $request->bindValue(":id", $id_client);
    $request->execute();
    $request->closeCursor();
}

function distanceGeographique($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6371; // Rayon de la Terre en kilomètres

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = $earthRadius * $c;

    return $distance;
}

function calculerDistance($adresse1, $adresse2) {
    // Encodez les adresses pour les utiliser dans l'URL de recherche
    $adresse1Enc = urlencode($adresse1);
    $adresse2Enc = urlencode($adresse2);

    // Construisez l'URL de recherche inversée de l'API Nominatim de OpenCage Data pour géocoder les adresses
    //Avec la key generer sur mon compte ocd
    $urlAdresse1 = "https://api.opencagedata.com/geocode/v1/json?q=" . $adresse1Enc . "&key=f6961b0783dd4e6bb41fc44095e05c90";
    $urlAdresse2 = "https://api.opencagedata.com/geocode/v1/json?q=" . $adresse2Enc . "&key=f6961b0783dd4e6bb41fc44095e05c90";

    // Effectuez une requête HTTP pour géocoder les adresses
    $responseAdresse1 = file_get_contents($urlAdresse1);
    $responseAdresse2 = file_get_contents($urlAdresse2);

    // Vérifiez si la requête a réussi et s'il y a des résultats valides
    if ($responseAdresse1 && $responseAdresse2) {
        $dataAdresse1 = json_decode($responseAdresse1, true);
        $dataAdresse2 = json_decode($responseAdresse2, true);

        if (!empty($dataAdresse1['results']) && !empty($dataAdresse2['results'])) {
            $latitude1 = $dataAdresse1['results'][0]['geometry']['lat'];
            $longitude1 = $dataAdresse1['results'][0]['geometry']['lng'];

            $latitude2 = $dataAdresse2['results'][0]['geometry']['lat'];
            $longitude2 = $dataAdresse2['results'][0]['geometry']['lng'];

            // Calculer la distance en utilisant la formule de la distance entre deux points géographiques (formule de haversine)
            $distance = distanceGeographique($latitude1, $longitude1, $latitude2, $longitude2);

            return $distance;
        }
    }

    return false;
}

function assignation_cmd($id_cmd){   // entrer cmd a livrée

    $add_close = "";
    $add_last = "";
    $add_Client = "";
    $dist_close = 0;
    $dist_last = 0;
    $liv_close = "";

    global $link;

    $sql_cmd="SELECT * FROM commande WHERE ID = $id_cmd";
    $res_cmd=mysqli_query($link,$sql_cmd);

    if(mysqli_num_rows($res_cmd)==0){
        echo 'Commande invalide !';

        return NULL;
    }

    $obj_cmd = mysqli_fetch_object($res_cmd);

    if ($obj_cmd->Vendeur != NULL || $obj_cmd->Vendeur != "") {
        echo "commande deja assigner";

        return NULL;
    }

    $sql_liv="SELECT * FROM livreur WHERE Temps_Tournee < 7";
    $res_liv=mysqli_query($link,$sql_liv);

    if (mysqli_num_rows($res_liv)== 0) {
        // S'il n'y a aucun livreur dispo,
            echo 'aucun liveur dispo';

            return NULL;
    }

    $obj_liv = mysqli_fetch_object($res_liv);

    $sql_cli="SELECT * FROM client WHERE ID = $obj_cmd->ID_Client";
    $res_cli=mysqli_query($link,$sql_cli);

    if (mysqli_num_rows($res_cli)==0) {
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

    $maj_cmd = "UPDATE commande SET ID_Livreur = $liv_close WHERE ID = $id_cmd";

    // Exécution de la requête
    if (mysqli_query($link, $maj_cmd)) {
        echo "Livreur ajouté.";
    } else {
        echo "Erreur lors de l'exécution de la requête : " . $mysqli->error;
    }
}

function ajout_panier($id_client, $prix, $vendeur, $panier){
// crea commande + appel assi liv
// recup produit et qtt
// panier tableau  produit, qtt

    

}
?>

