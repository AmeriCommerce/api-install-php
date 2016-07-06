<?php
require 'api.php';
$api = new ApiClient();

if($_POST['domain'] != null) {
	$host = $_SERVER['HTTP_HOST'];
	$curr = urlencode("http://$host/index.php");
	$api->startOAuth($_POST['domain'], "http://$host/callback.php?r=$curr");
}
$user = $api->getApiUser();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>App Installation Demo</title>
		<link rel='stylesheet' href='/css/bootstrap.min.css'>
		<link rel='stylesheet' href='/css/bootstrap-theme.min.css'>
	</head>
	<body>
		<div class='container'>
			<?php if($user != null): ?>
				<?php include 'products.php'; ?>
			<?php else: ?>
				<form method='POST' action='index.php'>
					<h1>Enter your store domain</h1>
					<div>
						Domain: <input type='text' name='domain'><br>
						<input type='submit'>
					</div>
				</form>
			<?php endif; ?>
		</div>
		<script src='/js/jquery.min.js'></script>
		<script src='/js/bootstrap.min.js'></script>
	</body>
</html>