<?
include '../../../../wp-load.php';





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






?>
 <h4>Bitte den Schülerkey der Klasse wählen...</h4>
   
    <h5>Schülerkey:
    <select id="pupilkey" name="pupilkey" required="required"  onchange="OnlineStatusShow(this.value);timer(this.value);" style="font-size: large">
          <?php






          $isEntryL= "Select * From UserData where UserID='$ID' ";
          $resultL = mysqli_query($con, $isEntryL);

          //echo '<form action="/wp-content/themes/digger/Page_Scripts/DBFuellungCocosUrls.php" method="POST">';


          echo "<option>--Bitte wählen--</option>";


          while ($row = mysqli_fetch_array($resultL))

          {


            $value = $row[ 'pupilkey' ];

            if ( $value <> "" )echo "<option>" . $value . "</option>";


          }

          ?>
        </select></h5>
<div id="StatusTabelle"></div>


<script>
function timer(str) {


    setInterval(() => OnlineStatusShowTimer(str), 60000);


}

    function OnlineStatusShow(str) {






        if (window.XMLHttpRequest) {

            // code for IE7+, Firefox, Chrome, Opera, Safari

            xmlhttp = new XMLHttpRequest();

        } else {

            // code for IE6, IE5

            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

        }

        xmlhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("StatusTabelle").innerHTML = this.responseText;

            }

        };

        xmlhttp.open("GET","/wp-content/themes/digger/Page_Scripts/showStatusTable.php?pupilkey="+str, true);

        xmlhttp.send();

    }

    function OnlineStatusShowTimer(str) {

       




        if (window.XMLHttpRequest) {

            // code for IE7+, Firefox, Chrome, Opera, Safari

            xmlhttp = new XMLHttpRequest();

        } else {

            // code for IE6, IE5

            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

        }

        xmlhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("StatusTabelle").innerHTML = this.responseText;

            }

        };

        xmlhttp.open("GET","/wp-content/themes/digger/Page_Scripts/showStatusTable.php?pupilkey="+str, true);

        xmlhttp.send();

    }



</script>
