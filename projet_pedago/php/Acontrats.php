<!DOCTYPE html>
<html>
    <?php
    include ("header.php");
    ?>
    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Administrateur Contrats </title>
        <link rel="stylesheet" href="css/Acontratcss.css">

    </head>

    <body>
        <div class="contract_container">

            <div class="contract_search">
                <input type="text" placeholder="Recherche ID contracts">
                <button type="submit"><img id="loupe" src="/projet_pedago/img/loupe.png" alt="img.png"> </button>
            </div>

        </div>

        <div class="contract_list">

            <ul class="contracts">

                <li>
                    First Contractor
                </li>
                <li>
                    Second Contractor
                </li>
            </ul>
        </div>
        <?php
        include ("footer.php");
        ?>
    </body>
</html>