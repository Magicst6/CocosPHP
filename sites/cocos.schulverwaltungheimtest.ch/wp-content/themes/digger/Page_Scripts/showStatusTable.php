<?php
include '../../../../wp-load.php';



$Pupilkey = $_GET[ 'pupilkey' ];

$current_user = wp_get_current_user();


$roles = ( array ) $current_user->roles;
$ID=$current_user->ID;


$roles = ( array ) $current_user->roles;
$ID=$current_user->ID;
if (!$ID){
    die("Sie müssen sich erst einloggen!");
}
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






echo ' <h3>OnlineStatus:</h3>';



echo '<table class="fixed_header"  style="font-size: large">';

//Schreibe Spaltennamen

echo "<thead>";

echo "<tr>";


echo "<th width=150px>" . 'Name' . "</th>";

echo "<th width= 150px>" . 'Onlinestatus' . "</th>";

echo "<th width= 200px>" . 'Datum' . "</th>";

echo "</tr>";

echo "</thead>";

echo "<tbody>";



$isEntry = "Select * From OnlineStatus where pupilkey='$Pupilkey' ";

$result = mysqli_query( $con, $isEntry );


while ( $value1 = mysqli_fetch_array( $result ) )

{
   $Name=$value1['Name'];
   $Name=str_replace('%20',' ',$Name);
   $status=$value1['OnlineStatus'];
   if ($status==1){
       $online="online";
   }else {
       $online="offline";
   }


    echo "<tr>";
    echo '<td>' . $Name . '</td>';
   if ($status==1){
       echo '<td style="color: red">' . $online. '</td>';
   }else {
       echo '<td style="color: #0F9E5E">' . $online . '</td>';
   }
    echo '<td>' . $value1['Date']. '</td>';
    echo "</tr>";
}











echo "</tbody>";

echo "</table>";