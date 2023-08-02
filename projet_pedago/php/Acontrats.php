<!DOCTYPE html>
<html>
<?php
include ("header.php");

if(isset($_SESSION['Connexion']) && $_SESSION['Connexion'][1] != 'admin'){
   {
        header('Location: /projet_pedago/php/accueil.php');
        die();
    }
}

if (isset($_POST["modifier"])) {
    if($_POST['type'] == 'client'){

        $prenom = $_POST["account-surname"];
        $nom = $_POST["account-name"];
        $mail = $_POST["account-mail"];
        $tel = $_POST["account-tel"];
        $adresse = $_POST["account-adresse"];
        $numCB = $_POST["account-numCB"];
        $dateCB = $_POST["account-dateCB"];
        $cryptoCB = $_POST["account-cryptoCB"];
        $id = $_POST["ID"];

        update_Compte_Cli($prenom, $nom, $mail, $tel, $adresse,$numCB, $dateCB, $cryptoCB, $id);

    } elseif($_POST['type'] == 'vendeur'){
        
            $prenom = $_POST["account-surname"];
            $nom = $_POST["account-name"];
            $mail = $_POST["account-mail"];
            $tel = $_POST["account-tel"];
            $id = $_POST["ID"];
            $admin = $_POST["liste_statut"];
            
            update_Compte_Vend($nom, $mail, $admin, $tel, $prenom, $id);
            
    } elseif($_POST['type'] == 'livreur'){

        $Prénom = $_POST["account-surname"];
        $Nom = $_POST["account-name"];
        $Mail = $_POST["account-mail"];
        $Adresse = $_POST["account-adresse"];
        $Permis = $_POST["account-permis"];
        $Type_Véhicule = $_POST["account-type_vehicule"];
        $id = $_POST["ID"];

        update_Compte_Liv($Prénom, $Nom, $Mail, $Adresse, $Permis, $Type_Véhicule, $id);
    }
}

if (isset($_POST["supprimer"])) {
    if($_POST['type'] == 'client'){

        $ID = $_POST["ID"];
        $type = $_POST["type"];

        suppr_Compte($ID, $type);

    } elseif($_POST['type'] == 'vendeur'){
        
            $ID = $_POST["ID"];
            $type = $_POST["type"];
            
            suppr_Compte($ID, $type);
            
    } elseif($_POST['type'] == 'livreur'){

        $ID = $_POST["ID"];
        $type = $_POST["type"];

        suppr_Compte($ID, $type);
    }
}

//vendeur

if(isset($_POST['view'])){
    
    $id= $_POST['ID'];
    $type= $_POST['type'];

    affiche_Contrat($id, "$type");
}
if(isset($_POST['supprimer-contrat'])){
    
    $id= $_POST['ID'];
    $type= $_POST['type'];

    res_Contrat($id, "$type");
}


?>
    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Administrateur Comptes </title>
        <link rel="stylesheet" href="/projet_pedago/css/Acontratcss.css" href="/projet_pedago/css/Main.css">

    </head>

    <body>
        <main>
        <div class="bar_container">
                <form action="" method="post" name="rech_id">
                    <div class="bar_search">
                        <input type="text" name="rech_id" placeholder="Recherche ID " id="rech_id">
                        <button type="submit"><img id="loupe" src="/projet_pedago/img/loupe.png" alt="img.png"> </button>
                    </div>
                </form>
        </div>
        <section>
            <h2>Informations Vendeurs</h2>

            <?php

                global $link;
                $tab_ids = [];

                $sql_vend = "SELECT * FROM vendeur";
                $res_vend = mysqli_query($link, $sql_vend);

                while($obj_vend = mysqli_fetch_object($res_vend)){

                    array_push($tab_ids, $obj_vend->ID);
                }
                
                foreach ($tab_ids as $id_vend) {
                    
                    
                    $data = recup_Data_Vendeur($id_vend);

            ?>

            <div class="data-container" class="vend">
                <form class="account-form" id="modifie" name="modifie" action="" method="POST">

                    <label for="account-tel">ID : <?php echo(htmlspecialchars($data["ID"]));?> </label>
                    <input class="modifier-input" type="hidden" name="ID" value="<?php echo(htmlspecialchars($data["ID"])); ?>">
                    <input class="modifier-input"type="hidden" name="type" value="vendeur">

                    <label for="account-name">Nom :</label>
                    <input class="modifier-input"  type="text" id="account-name" name="account-name" value="<?php echo(htmlspecialchars($data["Nom"])); ?>" required>

                    <label for="account-surname">Prénom:</label>
                    <input class="modifier-input" value="<?php echo(htmlspecialchars($data["Prenom"]));?>" type="text" id="account-surname" name="account-surname" required>

                    <label for="account-mail">Mail :</label>
                    <input class="modifier-input" value="<?php echo(htmlspecialchars($data["email"]));?>" type="email" id="account-mail" name="account-mail" required>

                    <label for="account-tel">Tel :</label>
                    <input class="modifier-input" value="<?php echo(htmlspecialchars($data["tel"]));?>" type="number" min="0" id="account-tel" step ="1" name="account-tel" required>

                    <?php
                    
                    $opt1_select = '';
                    $opt2_select = '';
                    $bddstatut = $data["ouiadmin"];

                    if ($bddstatut == 1) {
                        $opt1_select = 'selected';
                    } elseif ($bddstatut == 0) {
                        $opt2_select = 'selected';
                    }

                    echo '<select name="liste_statut">';
                        echo '<option value="1" '.$opt1_select.' >Admin</option>';
                        echo '<option value="0" '.$opt2_select.' >Non Admin</option>';
                    echo '</select>';
                    ?>
                    <br/>
                    <button class="ed" type="submit" name="modifier" class="account-button">Modifier</button>
                    <button class="ban" type="submit" name="supprimer" class="account-button">Suprimer</button>
                </form>
                <form class="account-form" id="modifie" name="modifie" action="" method="POST">

                    <label for="account-tel">Contrat :</label>
                    <input type="hidden" name="ID" value="<?php echo(htmlspecialchars($data["ID"])); ?>">
                    <input type="hidden" name="type" value="vendeur">
                    <br/>
                    <button class="ed" type="submit" name="view" class="account-button">Voir le contrat</button>
                    <button class="ban" type="submit" name="supprimer-contrat" class="account-button">Résilier contrat</button>
                </form>
            </div>
            <?php } ?>
        </section>

        <section>
            <h2>Informations Livreurs</h2>
            <?php

                global $link;
                $tab_ids = [];

                $sql_liv = "SELECT * FROM livreur";
                $res_liv = mysqli_query($link, $sql_liv);

                while($obj_liv = mysqli_fetch_object($res_liv)){

                    array_push($tab_ids, $obj_liv->ID);
                }
                
                foreach ($tab_ids as $id_liv) {
                    
                    
                    $data = recup_Data_Livreur($id_liv);

            ?>

            <div class="data-container" class="vend">
                <form class="account-form" id="modifie" name="modifie" action="" method="POST">

                    <label for="account-tel">ID : <?php echo(htmlspecialchars($data["ID"]));?> </label>
                    <input type="hidden" name="ID" value="<?php echo(htmlspecialchars($data["ID"])); ?>">
                    <input type="hidden" name="type" value="livreur">

                    <label for="account-name">Nom :</label>
                    <input class="modifier-input"  type="text" id="account-name" name="account-name" value="<?php echo(htmlspecialchars($data["Nom"])); ?>" required>

                    <label for="account-surname">Prénom:</label>
                    <input class="modifier-input" value="<?php echo(htmlspecialchars($data["Prénom"]));?>" type="text" id="account-surname" name="account-surname" required>

                    <label for="account-mail">Mail :</label>
                    <input class="modifier-input" value="<?php echo(htmlspecialchars($data["email"]));?>" type="email" id="account-mail" name="account-mail" required>

                    <label for="account-tel">Adresse :</label>
                    <input class="modifier-input" value="<?php echo(htmlspecialchars($data["Adresse"]));?>" type="text" id="account-adresse" name="account-adresse" required>

                    <label for="account-tel">Permis :</label>
                    <input class="modifier-input" value="<?php echo(htmlspecialchars($data["Permis"]));?>" type="text" id="account-permis" name="account-permis" required>

                    <label for="account-tel">Type de Véhicule :</label>
                    <input class="modifier-input" value="<?php echo(htmlspecialchars($data["Type_Véhicule"]));?>" type="text" id="account-type_vehicule" name="account-type_vehicule" required>
                    <br/>
                    <button class="ed" type="submit" name="modifier" class="account-button">Modifier</button>
                    <button class="ban" type="submit" name="supprimer" class="account-button">Suprimer</button>
                </form>
                <form class="account-form" id="modifie" name="modifie" action="" method="POST">

                    <label for="account-tel">Contrat :</label>
                    <input type="hidden" name="ID" value="<?php echo(htmlspecialchars($data["ID"])); ?>">
                    <input type="hidden" name="type" value="livreur">
                    <br/>
                    <button class="ed" type="submit" name="view" class="account-button">Voir le contrat</button>
                    <button class="ban" type="submit" name="supprimer-contrat" class="account-button">Résilier contrat</button>
                </form>
            </div>
            <?php } ?>
        </section>

        <section>
            <h2>Informations Clients</h2>
            <?php

                global $link;
                $tab_ids = [];

                $sql_cli = "SELECT * FROM client";
                $res_cli = mysqli_query($link, $sql_cli);

                while($obj_cli = mysqli_fetch_object($res_cli)){

                    array_push($tab_ids, $obj_cli->ID);
                }
                
                foreach ($tab_ids as $id_cli) {
                    
                    
                    $data = recup_Data_Client($id_cli);

            ?>

            <div class="data-container" class="vend">
                <form class="account-form" id="modifie" name="modifie" action="" method="POST">

                    <label for="account-tel">ID : <?php echo(htmlspecialchars($data["ID"]));?> </label>
                    <input type="hidden" name="ID" value="<?php echo(htmlspecialchars($data["ID"])); ?>">
                    <input type="hidden" name="type" value="client">

                    <label for="account-name">Nom :</label>
                    <input class="modifier-input"  type="text" id="account-name" name="account-name" value="<?php echo(htmlspecialchars($data["Nom"])); ?>" required>

                    <label for="account-surname">Prénom:</label>
                    <input class="modifier-input" value="<?php echo(htmlspecialchars($data["Prénom"]));?>" type="text" id="account-surname" name="account-surname" required>

                    <label for="account-mail">Mail :</label>
                    <input class="modifier-input" value="<?php echo(htmlspecialchars($data["Mail"]));?>" type="email" id="account-mail" name="account-mail" required>

                    <label for="account-tel">Adresse :</label>
                    <input class="modifier-input" value="<?php echo(htmlspecialchars($data["Adresse"]));?>" type="text" id="account-adresse" name="account-adresse" required>

                    <label for="account-tel">Tel :</label>
                    <input class="modifier-input" value="<?php echo(htmlspecialchars($data["Tel"]));?>" type="number" min="0" id="account-tel" step ="1" name="account-tel" required>

                    <label for="account-tel">Date de fin de contrat : <?php echo(htmlspecialchars($data["Date_contrat"])); ?></label>

                    <input type="hidden" name="account-numCB" value="<?php echo(htmlspecialchars($data["numero_CB"])); ?>">
                    <input type="hidden" name="account-dateCB" value="<?php echo(htmlspecialchars($data["date_CB"])); ?>">
                    <input type="hidden" name="account-cryptoCB" value="<?php echo(htmlspecialchars($data["crypto_CB"])); ?>">
                    <br/>
                    <button class="ed" type="submit" name="modifier" class="account-button">Modifier</button>
                    <button class="ban" type="submit" name="supprimer" class="account-button">Suprimer</button>
                </form>
            </div>
            <?php } ?>
        </section>
        <div>
        <?php 
        
        ?>
        </div>
        </main>
    </body>
</html>
<?php
include ("footer.php");
?>