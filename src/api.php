<?php
require 'vendor/autoload.php';
require 'config.php';

session_start();

class ApiClient 
{
	private $httpClient;

	function __construct()
	{
		$this->httpClient = new \GuzzleHttp\Client();
	}

	public function getApiUser()
	{
		if(array_key_exists('API_USER', $_SESSION) && !empty($_SESSION['API_USER'])) {
			return $_SESSION['API_USER'];
		}
		return null;
	}

	public function setApiUser($token)
	{
		$_SESSION['API_USER'] = $token;
	}

	public function startOAuth($storeDomain, $returnUri) 
	{
		$_SESSION['STORE_DOMAIN'] = $storeDomain;
		$location = "https://$storeDomain/api/oauth?client_id=".INSTALL_ID."&scope=".SCOPE."&redirect_uri=$returnUri";
		header("Location: $location");
		die();
	}

	public function getToken($qs, $returnUri)
	{
		$sig = $this->createSignature($qs['secret'], $qs['code'], $qs['client_id'], SCOPE, strtolower($returnUri));
		$arr = [
			'client_id' => $qs['client_id'],
			'auth_id' => $qs['auth_id'],
			'signature' => $sig
		];
		$content = json_encode($arr);

		$storeDomain = $_SESSION['STORE_DOMAIN'];
		$request = new \GuzzleHttp\Psr7\Request('POST', "https://$storeDomain/api/oauth/access_token");
		$response = $this->httpClient->send($request, [
			'headers' => [
				'Content-Type' => 'application/json'
			],
			'body' => $content
		]);

		$statusCode = $response->getStatusCode();
		$body = $response->getBody()->getContents();

		if($statusCode != 200) {
			die("Error: call to getToken failed with status $statusCode and response content: $body");
		}
		return json_decode($body);
	}

	public function getProductList($page = 1)
	{
		$storeDomain = $_SESSION['STORE_DOMAIN'];
		$token = $_SESSION['API_USER'];

		if($token == null) {
			die('Error: no token');
		}

		$request = new \GuzzleHttp\Psr7\Request('GET', "https://$storeDomain/api/v1/products?page=$page");
		$response = $this->httpClient->send($request, [
			'headers' => [
				'X-AC-Auth-Token' => $token->access_token
			]
		]);

		$statusCode = $response->getStatusCode();
		$body = $response->getBody()->getContents();

		if($statusCode != 200) {
			die("Error: call to getProductList failed with status $statusCode and response content: $body");
		}
		return json_decode($body);
	}

	private function createSignature()
	{
		$combined = implode('', func_get_args());
		return hash('sha256', $combined);
	}
}
?>