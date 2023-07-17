<?php
// Variable globale pour stocker la connexion à la base de données
require_once "config.php";
require_once "connection_mysqli.php";

// Vérifier si la connexion à la base de données existe déjà
global $serveur, $nomBDD, $nomUtilisateurBDD, $motDePasseBDD, $connexion;

try {
    // Connexion à la base de données avec PDO
    $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD;charset=utf8", $nomUtilisateurBDD, $motDePasseBDD);

    // Définition des options PDO
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

$produits = getProduits();

function connexion($email, $mdp)
{
    // Obtenir la connexion à la base de données
    global $connexion;
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
            if ($utilisateur['admin']) {
                return 2;
            }
            return 1;
        }
    } catch (PDOException $e) {
        die("Erreur de requête : " . $e->getMessage());
    }
    // Authentification échouée
    return 0;
}

function inscription($nom, $prenom, $email, $mdp, $tel)
{

    global $connexion;

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
}
function updateAdresse($id_client, $adresse)
{
    global $connexion;
    $request = $connexion->prepare("UPDATE client SET adresse = :adresse WHERE id = :id");
    $request->bindValue(":adresse", $adresse);
    $request->bindValue(":id", $id_client);
    $request->execute();
    $request->closeCursor();
}
function updateCB($id, $numero_CB, $date_CB, $crypto_CB)
{
    global $connexion;
    $request = $connexion->prepare("UPDATE client SET numero_CB = :numero_CB, date_CB = :date_CB, crypto_CB = :crypto_CB WHERE id = :id");
    $request->bindValue(":numero_CB", $numero_CB);
    $request->bindValue(":date_CB", $date_CB);
    $request->bindValue(":crypto_CB", $crypto_CB);
    $request->bindValue(":id", $id);
    $request->execute();
    $request->closeCursor();
}

// Attention au chargement des images
function getProduits()
{
    global $connexion;
    $req = $connexion->query("SELECT * FROM produit");
    $res = $req->fetchAll();
    $req->closeCursor();
    return ($res);
}


function distanceGeographique($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371; // Rayon de la Terre en kilomètres

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = $earthRadius * $c;

    return $distance;
}

function calculerDistance($adresse1, $adresse2)
{
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

function assignation_cmd($id_cmd)
{   // entrer cmd a livrée

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

function built_tab($ID_Liv)
{

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

function dijkstra($graph, $start)
{
    $distances = array();
    $visited = array();
    $previous = array();
    $nodes = array();

    foreach ($graph as $point => $value) {
        $distances[$point] = INF;
        $previous[$point] = null;
        $nodes[$point] = $value;
    }

    $distances[$start] = 0;

    while (!empty($nodes)) {
        $minDistanceNode = null;

        foreach ($nodes as $point => $value) {
            if ($minDistanceNode === null || $distances[$point] < $distances[$minDistanceNode]) {
                $minDistanceNode = $point;
            }
        }

        foreach ($graph[$minDistanceNode] as $neighbor => $value) {
            $newDistance = $distances[$minDistanceNode] + $value;

            if ($newDistance < $distances[$neighbor]) {
                $distances[$neighbor] = $newDistance;
                $previous[$neighbor] = $minDistanceNode;
            }
        }

        unset($nodes[$minDistanceNode]);
    }

    return $previous;
}

function CheminLePlusCourt($points)
{
    $graph = array();
    $allPoints = array();

    foreach ($points as $point => $distances) {
        $allPoints[] = $point;

        foreach ($distances as $neighbor => $distance) {
            $graph[$point][$neighbor] = $distance;
        }
    }

    $shortPath = null;
    $shortDistance = INF;

    $permutations = Permu($allPoints);

    foreach ($permutations as $permutation) {
        $distance = 0;
        $Complet = true;

        $start = $permutation[0];
        $previous = dijkstra($graph, $start);

        foreach ($permutation as $index => $point) {
            if ($index < count($permutation) - 1) {
                $end = $permutation[$index + 1];

                if (!isset($previous[$end])) {
                    $Complet = false;
                    break;
                }

                $distance += $graph[$previous[$end]][$end];
            }
        }

        if ($Complet && $distance < $shortDistance) {
            $distance += $graph[$permutation[count($permutation) - 1]][$start]; // Ajoute la distance de retour au point de départ
            $shortDistance = $distance;
            $shortPath = $permutation;
        }
    }

    return $shortPath;
}

function Permu($items, $perms = array())
{
    if (empty($items)) {
        return array($perms);
    }

    $permutations = array();

    for ($i = count($items) - 1; $i >= 0; --$i) {
        $newItems = $items;
        $newPerms = $perms;

        list($foo) = array_splice($newItems, $i, 1);
        array_unshift($newPerms, $foo);

        $permutations = array_merge($permutations, Permu($newItems, $newPerms));
    }

    return $permutations;
}

function attribue_cmd($id_client){
    global $connexion;

    $req = $connexion->prepare("SELECT ID, Valide FROM commande WHERE ID_Client = :id_client");
    $req->bindValue(":id_client", $id_client);
    $req->execute();
    $res=$req->fetch();
    $req->closeCursor();
    if($res["Valide"]==0){
        return $res["ID"];
    }
    $req = $connexion->prepare("INSERT INTO commande (ID_Client) VALUES  ID_Client = :id_client");
    $req->bindValue(":id_client", $id_client);
    $req->execute();
    $req->closeCursor();
    attribue_cmd($id_client);
}



function ajout_panier($id_produit,$id_client,$quantite = 1){
    global $connexion;
    $cmd = attribue_cmd($id_client);
    $req = $connexion-> prepare("INSERT INTO achats (ID_produit,ID_commande, quantite) VALUES (:ID_produit, :ID_commande,:quantite)");
    $req->bindValue(":ID_produit", $id_produit);
    $req->bindValue(":ID_commande", $cmd);
    $req->bindValue(":quantite", $quantite);
    $req->execute();
    $req->closeCursor();
}

function confirm_panier($id_cmd)
{
    // Vérifier que la commande est valide (Vendeur, Prix)
    
    // changer valid 0-> 1 dans commande
    // lancer assignation !
    // ajt prix au chiffre d'affaire mrk (pas encore)

    

}

//bien fair ene page livreur ou il peut visualiser toute sa commande !!
