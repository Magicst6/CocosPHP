<?
include '../../../../wp-load.php';





$current_user = wp_get_current_user();


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


$x=0;
$isEntryL= "Select * From UserData where UserID='$ID' ";
$resultL = mysqli_query($con, $isEntryL);

 //echo '<form action="/wp-content/themes/digger/Page_Scripts/DBFuellungCocosUrls.php" method="POST">';





while ($row = mysqli_fetch_array($resultL)) {
    $x++;
    $pkey=$row['pupilkey'];
    $LehrerCode=$row['LehrerCode'];
    echo '<div class = "rahmen" ><br>';
    echo '<h3 style="color: darkviolet">Key '.$x.'</h3>';
    echo 'Key:<input name="pupilkey'.$x.'" value="'.$pkey.'" type="text" readonly/><br><br>';
    echo 'LehrerCode<input name="LehrerCode'.$x.'" value="'.$LehrerCode.'" type="text"/><br><br>';
    echo '<input name="UserID'.$x.'" value="'.$ID.'" type="hidden"/><br>';

    $y=0;
    $isEntryURL= "Select * From AllowedWebsites where pupilkey='$pkey' ";
    $resultURL = mysqli_query($con, $isEntryURL);
    
    $URLarr[]=$_GET['arr'];
    while ($rowURL = mysqli_fetch_array($resultURL) ) {
        $y++;
        $IDAW=$rowURL['id'];
        echo '<input id="'.$y.'id'.$x.'" value="'.$IDAW.'" type="hidden" />';
        $URL=$rowURL['url'];
        echo 'URL'.$y.':<input name="'.$y.'url'.$x.'" id="'.$y.'url'.$x.'" value="'.$URL.'" type="text" style="width: 95%;"/><input name="update'.$x.'" value="Update" type="button" onclick="updateURL('.$x.','.$y.','.$pkey.',\''.$LehrerCode.'\')" /><input name="del'.$x.'" value="Löschen" type="button" onclick="deleteURL('.$x.','.$y.','.$pkey.',\''.$LehrerCode.'\')" /><br>';
        $URLarr[]=$rowURL['url'];

    }
    $y++;
    echo 'URL'.$y.':<input name="'.$y.'url'.$x.'" id="'.$y.'url'.$x.'" value="" type="text" style="width: 95%;"/><input name="add'.$x.'" value="Speichern" type="button" onclick="saveURL('.$x.','.$y.','.$pkey.',\''.$LehrerCode.'\')" /><br>';

    //echo '<input name="allurls'.$x.'" value="'.$y.'" type="hidden" />';


    echo '<br><input name="delete'.$x.'" value="Key löschen" type="button" onclick="del('.$pkey.')" /><br></div><br><br>';
}
$x++;
echo '<div class = "rahmen" ><br>';
echo '<h3 style="color: darkviolet">Key erstellen</h3>';
echo 'Key:<input name="pupilkey'.$x.'" id="pupilkey'.$x.'" value="" type="text"/><br><br>';
echo 'LehrerCode:<input name="LehrerCode'.$x.'" id="LehrerCode'.$x.'" value="" type="text"/><br>';
echo '<input name="UserID'.$x.'" id="UserID'.$x.'" value="'.$ID.'" type="hidden"/><br>';
$y=1;
echo 'URL1: <input name="'.$y.'url'.$x.'" id="'.$y.'url'.$x.'" value="" type="text" style="width: 95%;"/><br><br><br>';

echo '<input name="add'.$x.'" value="Neuen Key erstellen" type="button" onclick="createKey('.$x.','.$y.')" />';

echo '<input name="number" value="'.$x.'" type="hidden"/><br> ';
echo '</div><br><br>';


//echo '<input name="Senden" type="submit" value="Änderungen speichern" "/></form>';
    ?>