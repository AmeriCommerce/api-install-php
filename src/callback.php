<?php
require 'api.php';
$api = new ApiClient();

$r = $_GET['r'];
$host = $_SERVER['HTTP_HOST'];
$index = urlencode("http://$host/index.php");
$originalReturnUri = "http://$host/callback.php?r=$index";

$token = $api->getToken($_GET, $originalReturnUri);
$api->setApiUser($token);

header("Location: $r");
die();
?>