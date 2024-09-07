

<head></head>



<script>
    /*$(document).ready(function() {


    });*/
    (function() {
        // your page initialization code here
        // the DOM will be available here


        getURLS();
    })();

    function getURLS() {



            if ( window.XMLHttpRequest ) {

                // code for IE7+, Firefox, Chrome, Opera, Safari

                xmlhttp = new XMLHttpRequest();

            } else {

                // code for IE6, IE5

                xmlhttp = new ActiveXObject( "Microsoft.XMLHTTP" );

            }

            xmlhttp.onreadystatechange = function () {

                if ( this.readyState == 4 && this.status == 200 ) {

                        document.getElementById("URLDIV").innerHTML = this.responseText;
                    }


            };

            xmlhttp.open( "GET", "/wp-content/themes/digger/Page_Scripts/showUrls.php",true);

            xmlhttp.send();

        }


    function createKey(x,y) {


        if ( window.XMLHttpRequest ) {

            // code for IE7+, Firefox, Chrome, Opera, Safari

            xmlhttp = new XMLHttpRequest();

        } else {

            // code for IE6, IE5

            xmlhttp = new ActiveXObject( "Microsoft.XMLHTTP" );

        }

        xmlhttp.onreadystatechange = function () {

            if ( this.readyState == 4 && this.status == 200 ) {
                alert(this.responseText);
                getURLS();
            }


        };

        xmlhttp.open( "GET", "/wp-content/themes/digger/Page_Scripts/createKey.php?pkey="+document.getElementById('pupilkey'+x).value + "&url="+document.getElementById(y+'url'+x).value +"&lehrer="+document.getElementById('LehrerCode'+x).value ,true);

        xmlhttp.send();

    }


    function saveURL(x,y,pkey,lehrer) {

    

        if ( window.XMLHttpRequest ) {

            // code for IE7+, Firefox, Chrome, Opera, Safari

            xmlhttp = new XMLHttpRequest();

        } else {

            // code for IE6, IE5

            xmlhttp = new ActiveXObject( "Microsoft.XMLHTTP" );

        }

        xmlhttp.onreadystatechange = function () {

            if ( this.readyState == 4 && this.status == 200 ) {
                alert(this.responseText);
                getURLS();
            }


        };

        xmlhttp.open( "GET", "/wp-content/themes/digger/Page_Scripts/saveURLS.php?url="+document.getElementById(y+'url'+x).value+"&pkey="+pkey +"&lehrer="+lehrer ,true);

        xmlhttp.send();

    }


    function deleteURL(x,y,pkey,lehrer) {



        if ( window.XMLHttpRequest ) {

            // code for IE7+, Firefox, Chrome, Opera, Safari

            xmlhttp = new XMLHttpRequest();

        } else {

            // code for IE6, IE5

            xmlhttp = new ActiveXObject( "Microsoft.XMLHTTP" );

        }

        xmlhttp.onreadystatechange = function () {

            if ( this.readyState == 4 && this.status == 200 ) {
                alert(this.responseText);
                getURLS();
            }


        };

        xmlhttp.open( "GET", "/wp-content/themes/digger/Page_Scripts/deleteURLS.php?url="+document.getElementById(y+'url'+x).value+"&pkey="+pkey +"&lehrer="+lehrer,true);

        xmlhttp.send();

    }

    function updateURL(x,y,pkey,lehrer) {



        if ( window.XMLHttpRequest ) {

            // code for IE7+, Firefox, Chrome, Opera, Safari

            xmlhttp = new XMLHttpRequest();

        } else {

            // code for IE6, IE5

            xmlhttp = new ActiveXObject( "Microsoft.XMLHTTP" );

        }

        xmlhttp.onreadystatechange = function () {

            if ( this.readyState == 4 && this.status == 200 ) {
                alert(this.responseText);
                getURLS();
            }


        };

        xmlhttp.open( "GET", "/wp-content/themes/digger/Page_Scripts/updateURLS.php?url="+document.getElementById(y+'url'+x).value+"&pkey="+pkey +"&lehrer="+lehrer + "&id="+document.getElementById(y+'id'+x).value,true);

        xmlhttp.send();

    }

    function del(str) {

        var strconfirm = confirm("Sind Sie sicher, dass Sie den Key und alle zugewiesenen URLs löschen wollen?");
        if (strconfirm == true) {

            if (window.XMLHttpRequest) {

                // code for IE7+, Firefox, Chrome, Opera, Safari

                xmlhttp = new XMLHttpRequest();

            } else {

                // code for IE6, IE5

                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

            }

            xmlhttp.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {

                    // document.getElementById( "URLDIV" ).innerHTML = this.responseText;
                    alert(this.responseText);
                    location.reload();
                }

            };

            xmlhttp.open("GET", "/wp-content/themes/digger/Page_Scripts/deletepkey.php?pkey=" + str, true);

            xmlhttp.send();
        }
    }


</script>
<html>
<body>

<div id="URLDIV"></div>


</body>
</html>
<style>
.rahmen {
   /* min-width: 550px;*/
border:  solid black;
    border-width: 2px;
    border-color: darkviolet;
    padding: 10px;
    border-radius: 10px;
}
</style>
