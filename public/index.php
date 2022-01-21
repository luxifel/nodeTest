<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use \GuzzleHttp\Client;
use \ScalapayTask\model\DbResource;
use \ScalapayTask\model\OrderApiManager as OrderApi;
use \ScalapayTask\model\OrderRepository;
use \ScalapayTask\router\Main as Router;
use \ScalapayTask\controller\Order as OrderController;
use \ScalapayTask\utils\OrderHelper as OrderHelper;
use \ScalapayTask\utils\DbHelper;


// resources
$db = new DbResource();
$httpClient = new Client();
$dbHelper = new DbHelper($db);
$orderHelper = new OrderHelper($dbHelper);


// order managers
$orderRepository = new OrderRepository($db);
$orderApi = new OrderApi($httpClient, $dbHelper, $orderRepository);
$orderController = new OrderController($orderHelper, $orderApi);

// views
$loader = new \Twig\Loader\FilesystemLoader('./view/template/');
$twig = new \Twig\Environment($loader);

// routes
$router = new Router();

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$router->resolveUri($requestUri, $requestMethod);

$router->get('/', function () use ($twig) {
    try {
        echo $twig->render('index.html');
    } catch (Exception $e) {
        http_response_code(500);
        error_log($e->getMessage());
    }
    exit();
});


$router->post('/save-order', function ($body) use ($orderController) {
    $response = $orderController->execCreateOrder($body);

    header('Location: '. $response['redirectUrl']);
    exit();
});