<?php
require 'api.php';
$api = new ApiClient();

parse_str($_SERVER['QUERY_STRING'], $qs);

$r = $qs['r'];
$host = $_SERVER['HTTP_HOST'];
$index = urlencode("http://$host/index.php");
$originalReturnUri = "http://$host/callback.php?r=$index";

$token = $api->getToken($qs, $originalReturnUri);
$api->setApiUser($token);

header("Location: $r");
die();
?>