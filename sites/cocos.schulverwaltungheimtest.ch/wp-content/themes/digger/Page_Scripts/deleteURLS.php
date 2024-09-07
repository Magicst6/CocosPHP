<?php

$URL=$_GET['url'];
$pkey=$_GET['pkey'];
$LehrerCode=$_GET['lehrer'];


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

$isEntry21 = "Select * From AllowedWebsites where pupilkey='$pkey' and LehrerCode='$LehrerCode'";

$result21 =  mysqli_query( $con, $isEntry21 );
$x=0;
while ( $line31 = mysqli_fetch_array( $result21 ) )

{
    $x++;
}
if ($x>1) {
    $isEntry = "Delete From AllowedWebsites where url='$URL' and pupilkey='$pkey' and LehrerCode='$LehrerCode'";
    $result = mysqli_query($con, $isEntry);
    echo "URL gelöscht!";
}else echo "Es muss mindestens eine URL zugewiesen sein!!";