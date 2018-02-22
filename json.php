<?php header('Access-Control-Allow-Origin: *'); ?>

<?php
$token = "YOUR_TOKEN_HERE";
$opts = [
    "http" => [
        "header" => "auth:" . $token
    ]
];

$context = stream_context_create($opts);

// Add your clan URL
$test = file_get_contents("http://api.cr-api.com/clan/22CRJCRC", true, $context);

$test = preg_replace('/\\\\\"/', "\"", $test);

$test = str_replace("'", "", $test);

// All data save on top-ricarditos.json
$json_data = urldecode(stripslashes($test));
file_put_contents('clan.json', $json_data);

?>
