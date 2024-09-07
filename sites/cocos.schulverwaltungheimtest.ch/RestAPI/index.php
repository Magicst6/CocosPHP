<?php

declare(strict_types=1);
/*include '../wp-load.php';

*/
spl_autoload_register(function ($class) {
    require __DIR__ . "/src/$class.php";
});

$providedExpires = (int) $_GET['expires'];

$providedToken =  $_GET['token'];



$verificationToken = buildVerificationToken($providedExpires, 'sdfghjk88'); // Build token the same way
$verificationToken= str_replace(' ','',$verificationToken);
$providedToken= str_replace(' ','',$providedToken);

if (!hash_equals($verificationToken, $providedToken)) { // hash_equals instead of string comparison to prevent timing attacks
    // User provided forged token, token for another content, or another IP
    die('Bad token'); // However you want to handle this
}

if (time() > $providedExpires) { // Check expiry time. We can trust the user did not modify it as we checked the HMAC hash
   die('Token expired'); // However you want to handle this
}

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

$parts = explode("$", $_SERVER["REQUEST_URI"]);
$Datakind = $parts[1];

if ($Datakind != "urlallowed" && $Datakind != "userdata" && $Datakind != "onlinestatus" && $Datakind != "onlinestatusdel") {
    http_response_code(404);
    exit;
}
if ($Datakind == "urlallowed" || $Datakind == "userdata") {
    $id = $parts[2] ?? null;
    $lkey = $parts[3] ?? null;

    $urlcoded = $parts[4] ?? null;

    $lname = $parts[5] ?? null;

    $lmail = $parts[6] ?? null;

    $database = new Database('9b1qp.myd.infomaniak.com', '9b1qp_cocos', '9b1qp_heimmarst', 'St1180REL');

    $gateway = new ProductGateway($database);

    $controller = new ProductController($gateway);


    $controller->processRequest($Datakind, $_SERVER["REQUEST_METHOD"], $id, $lkey, $urlcoded, $lname, $lmail);

}if ($Datakind=="onlinestatus"||  $Datakind=="onlinestatusdel" ){
    $id = $parts[2] ?? null;
    $sname= $parts[3] ?? null;

    $onlinestatus = $parts[4] ?? null;

    $date = $parts[5] ?? null;

    $date =date("Y-m-d H:i:s");

    $database = new Database('9b1qp.myd.infomaniak.com', '9b1qp_cocos', '9b1qp_heimmarst', 'St1180REL');

    $gateway = new ProductGateway($database);

    $controller = new ProductController($gateway);


    $controller->processRequestOS($Datakind, $_SERVER["REQUEST_METHOD"], $id, $sname, $onlinestatus,$date);

}



function buildVerificationToken($expires, $content)
{
    // Same function on both domains
    $APP_SECRET_KEY = '12345';  // Maybe move that out of source code

   /* $tokenData = [
        'expires' => $expires, // Include it in signatur generation to prevent user from changing it in URL
        'content' => $content, // Create different token for different content
       // 'ip' => $_SERVER['REMOTE_ADDR'], // Identify the browser to make it not shareable. Best approach I could think of for this part.
    ];*/

    $tokenData =$expires.$content;


    return hash_hmac('sha256', $tokenData, $APP_SECRET_KEY);
}











