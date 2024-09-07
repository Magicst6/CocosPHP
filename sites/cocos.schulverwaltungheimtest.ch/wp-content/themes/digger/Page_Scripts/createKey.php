<?php

$URL=$_GET['url'];

$pkey=$_GET['pkey'];
$LehrerCode=$_GET['lehrer'];
if ($pkey and $LehrerCode and $URL ){

    if (substr($URL, -1)=="/"){
        $URL= rtrim($URL, "/");
    }

    include '../../../../wp-load.php';

if (is_numeric($pkey)){

    if (strlen($URL)>8){

        $current_user = wp_get_current_user();


        $roles = ( array ) $current_user->roles;
        $ID=$current_user->ID;
        $isjustified=false;
        foreach($roles as $role){
            if ($role == 'administrator' or $role == 'subscriber' ){
                $isjustified=true;
            }

        }if (!$isjustified){

            die("Authentifizierung fehlgeschlagen");
        }
        ?>
        <?php include $_SERVER['DOCUMENT_ROOT']."/wp-config.php";?>


        <?php

        $con = @mysqli_connect(DB_HOST, DB_USER_EKL, DB_PASSWORD_EKL);

        if (!$con) {
            echo "Error: " . mysqli_connect_error();
            exit();
        }
//echo 'Connected to MySQL';
        $verbunden=mysqli_select_db($con, DB_NAME_EKL);
        if($verbunden)
//echo('DB-Verbindung hergestellt! ');
            $dummy=1;
        else
            die('DB-Verbindung fehlgeschlagen! ');


        $isEntry = "Insert Into UserData (pupilkey,UserID,LehrerCode) VALUES ('$pkey','$ID','$LehrerCode')";
        $result = mysqli_query($con, $isEntry);


        $isEntry1 = "Insert Into AllowedWebsites (pupilkey,url,LehrerCode) VALUES ('$pkey','$URL','$LehrerCode')";
        $result1 = mysqli_query($con, $isEntry1);
        echo "Ein neuer Key wurde erstellt!";
    }else echo "Aktion abgebrochen! URL zu kurz (mindestens 9 Zeichen)!!";
    }else echo "Aktion abgebrochen! Bitte einen numerischen Wert als Key eingeben!";

}else echo "Aktion abgebrochen! Bitte alle Felder ausfüllen!";