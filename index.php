<?php
// echo "OK";

require 'vendor/autoload.php';

header('Content-Type: application/json; charset=utf-8');

$config['db']['host']   = "localhost";
$config['db']['user']   = "root";
$config['db']['pass']   = "root";
$config['db']['dbname'] = "news_api";

$app = new \Slim\App(["settings" => $config]);

// CorsSlim for Cross domain request
$corsOptions = array(
    "origin" => "*",
    "exposeHeaders" => array("Content-Type", "X-Requested-With", "X-authentication", "X-client"),
    "allowMethods" => array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS')
);
$cors = new \CorsSlim\CorsSlim($corsOptions);
$app->add($cors);


// Get Container
$container = $app->getContainer();

// Define a DB Container
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};



$app->get('/', function($request, $response){

	$sql = 'SELECT * FROM news ORDER BY createdDate DESC';
	$result = array();
	foreach($this->db->query($sql) as $row) {
	   array_push($result, $row);
	}

	$newResponse = $response->withJson($result);
	return $newResponse;

});


$app->get('/{count}',function($request, $response){

	$limit = $request->getAttribute('count');
	$sql = 'SELECT * FROM news ORDER BY createdDate DESC LIMIT ' . $limit;

	$result = array();
	foreach($this->db->query($sql) as $row) {
	   array_push($result, $row);
	}

	$newResponse = $response->withJson($result);
	return $newResponse;

});

$app->post('/signin', function($request, $response){

	$username = $request->getParam('username');
    $password = $request->getParam('password');

    $result = array('result' => '1', 'user' => $username);

	$newResponse = $response->withJson($result);
	return $newResponse;

});



$app->run();
 ?>
