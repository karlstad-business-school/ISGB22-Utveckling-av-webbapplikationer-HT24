<?php
    include("databaseFunctions.php");
?>
<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <title>PHP F7</title>
    </head>
    <body>
        <main>
        
        <?php

            //Steg 1 -> Struktur för undantagshantering

            if(isset($_POST["btnDelete"])) {
            }

            if(isset($_POST["btnSave"])) {
            }

            if(isset($_POST["btnEdit"])) {
                selectCar($dbh, $_POST["hidId"]);
            } else {
                createForm();
            }

        ?>

        </main>
    </body>
</html>
