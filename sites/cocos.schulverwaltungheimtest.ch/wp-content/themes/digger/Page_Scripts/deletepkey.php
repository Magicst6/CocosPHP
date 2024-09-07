<?
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
    $url="/";
    header( "Location: $url" );
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


$pkey=$_GET['pkey'];


$isEntryL1= "Delete  From AllowedWebsites where pupilkey='$pkey' ";
$resultL1 = mysqli_query($con, $isEntryL1);

$isEntryL= "Delete From UserData where UserID='$ID' and pupilkey='$pkey' ";
$resultL = mysqli_query($con, $isEntryL);
echo "Key gelöscht";