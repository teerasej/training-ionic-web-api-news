<?php
// echo "OK";

require 'vendor/autoload.php';


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

    $result = array();

    $newResponse = $response->withJson($result);
    return $newResponse;

});


$app->get('/{count}',function($request, $response){



    $result = array();


    $newResponse = $response->withJson($result);
    return $newResponse;

});

$app->post('/login', function($request, $response){

	$username = $request->getParam('username');
  $password = $request->getParam('password');

  $result = array();

  $newResponse = $response->withJson($result);
  return $newResponse;

});











$app->run();
 ?>
