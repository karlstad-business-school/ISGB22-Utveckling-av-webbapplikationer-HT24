<?php

/* Skapa DB med namn test, tabell med namn tbllkund, id, personnummer, epost och losen. */

    function dbConnect() {
        try {
            $dns = "mysql:dbname=test;host=localhost";
            $user = "root";
            $password = "";
            $options = array( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $db = new PDO($dns, $user, $password, $options);
            return $db;
        } catch( PDOException $e ) {
            throw $e;
        }
    }

?>  
<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <title>PHP F9 - Sessioner</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style> 
            * {
                box-sizing: border-box;
            }
            img {
                width: 15%;
                height: 15%;
                padding-right: 5px;
                padding-bottom: 10px;
            }
            main {
                width: 25%;
                min-width:400px;
                max-width:100%;
                border: solid 1px gray;
                padding: 15px;
                margin: 0 auto;

            }

            input {
                margin: 5px;
                width: 100%;
            }
        </style>
    </head>

    <body class="container p-2">
        <header class="jumbotron text-center">
            <h1>Skapa användare</h1>
        </header>

        <main>    

        <?php
            if( isset( $_POST["skicka"] ) ) {

                //Vettig validering... lämnas till workshop
                // 0.) Kontrollera dublett av epost i databas
                // 1.) Kontrollera epost
                // 2.) Kontrollera antal tecken + siffra + specialtecken i lösenord
                // 3.) Kontrollera samma i båda rutor
        
				//Validera personnummer
				//1. Hämta 
				//$first=substr($persnr,0,8);
				//$last=substr($email,-4)
				////if(is_numeric($afterA)) {	echo("tjo!"); }
		
                //Koppla upp och spara till databas
                try {
                    $dbh =  dbConnect();

                    $sql = "INSERT INTO `tblkund`(`epost`, `personnummer`, `losenord`) VALUES (:epost,:persnr,:losen);";

                    $hashat_losen = hash("SHA256", $_POST["losen1"]);

                    $nyckel = "valfristrang1234";
                    $metod = "AES-128-ECB";
                    $encryptedPnr = openssl_encrypt($_POST["persnr"], $metod, $nyckel);

                    $stmt = $dbh->prepare($sql);
                    $stmt->bindValue(":epost", $_POST["epost"]);
                    $stmt->bindValue(":persnr", $encryptedPnr);
                    $stmt->bindValue(":losen", $hashat_losen);

                    $stmt->execute();
                    $stmt = null;
                    $dbh = null;

                    session_start();
                    $_SESSION["inloggad"] = "mört";



                }
                catch(Exception $ex) {
                    //Gör något kul!
                }

        
            }
            
            //kontrollera om inloggad
            if(isset($_SESSION["inloggad"])) {
                //Är inloggad visa "hemlig sida"
                ?>
                    <h1>Grattis, du får visa hemliga sidan!</h1>

                <?php
            }
            else {
                //Inte inloggad visa registering
                ?>
                    <form action="<?php echo($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label for="epost">Ange epost</label><br>
                            <input type="email" id="epost" name="epost" required>
                        </div>
						<div class="form-group">
                            <label for="epost">Ange personnummer (YYYYMMDD-XXXX)</label><br>
                            <input type="text" id="persnr" name="persnr" required>
                        </div>
                        <div class="form-group">
                            <label for="losen1">Välj lösenord (upprepa två gånger)</label><br>
                            <input type="password" id="losen1" name="losen1" required><br>
                            <input type="password" id="losen2" name="losen2" required>
                        </div>
                        <input type="submit" name="skicka" value="Skicka" class="btn btn-danger" />                  
                    </form>

                <?php
            }
            


        ?>
            


        </main>

    </body>

</html>