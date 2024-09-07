<?php

$URL=$_GET['url'];
if (strlen($URL)>8){
$pkey=$_GET['pkey'];
$LehrerCode=$_GET['lehrer'];


   if (substr($URL, -1)=="/"){
    $URL= rtrim($URL, "/");
   }

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



$isEntry = "Insert Into AllowedWebsites (pupilkey,url,LehrerCode) VALUES ('$pkey','$URL','$LehrerCode')";
$result = mysqli_query($con, $isEntry);
echo "URL erstellt!!";
}else echo "Aktion abgebrochen! URL zu kurz (mindestens 9 Zeichen)!!";