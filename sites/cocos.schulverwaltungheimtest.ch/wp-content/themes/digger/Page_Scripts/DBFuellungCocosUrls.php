<?php
include '../../../../wp-load.php';



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




if ( $_POST[ 'Senden' ] )

{

$isError=0;

    $AnzahlK = $_POST[ 'number' ];


    for ( $x = 1; $x <= $AnzahlK; $x++ ) {

        $pkey = $_POST['pupilkey' . $x];
        $LehrerCode = $_POST['LehrerCode' . $x];
        $ypos= $_POST['allurls' . $x];

        if (!is_numeric($pkey)) {
            echo "Der Key:'$pkey' ist keine Zahl. Aktion abgebrochen!!";
            $isError=1;
        }else{
            if ($AnzahlK == $x) {

                $isEntry = "Insert Into UserData (pupilkey,UserID,LehrerCode) VALUES ('$pkey','$ID','$LehrerCode')";
                $result = mysqli_query($con, $isEntry);

                for ($y = 1; $y <= $ypos; $y++) {
                    $URL = $_POST[$y . 'url' . $x];
                    if ($URL) {
                        $isEntry = "Insert Into AllowedWebsites (pupilkey,url,LehrerCode) VALUES ('$pkey','$URL','$LehrerCode')";
                        $result = mysqli_query($con, $isEntry);
                    }
                }
            } else {
                $isEntry = "Update UserData SET ,LehrerCode='$LehrerCode' Where UserID='$ID' and pupilkey='$pkey'";
                $result = mysqli_query($con, $isEntry);
                $isEntry = "Delete From AllowedWebsites where pupilkey='$pkey'";
                $result = mysqli_query($con, $isEntry);
                for ($y = 1; $y <= $ypos; $y++) {

                    $URL = $_POST[$y . 'url' . $x];
                    If ($URL) {
                        $isEntry = "Insert Into AllowedWebsites (pupilkey,url,LehrerCode) VALUES ('$pkey','$URL','$LehrerCode')";
                        $result = mysqli_query($con, $isEntry);
                    }
                }

            }


        }

    }


}if (!$isError){
    header( 'Location:' . $_SERVER[ 'HTTP_REFERER' ] );
}
