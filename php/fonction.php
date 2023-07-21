<?php
// Variable globale pour stocker la connexion à la base de données
require_once "config.php";
require_once "connection_mysqli.php";
require_once "fonction_get.php";
require_once "fonction_update.php";

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

function deconnexion(){
    session_unset();
    session_destroy();
}

function distanceGeographique($lat1, $lon1, $lat2, $lon2){
    $earthRadius = 6371; // Rayon de la Terre en kilomètres

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = $earthRadius * $c;

    return $distance;
}

function calculerDistance($adresse1, $adresse2){
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

function dijkstra($graph, $start){
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

function CheminLePlusCourt($points){
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

function Permu($items, $perms = array()){
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

?>