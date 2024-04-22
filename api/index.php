<?php

namespace Api;

require_once './services/CourseService.php';
require_once './services/CategoryService.php';
require_once './controllers/CourseController.php';
require_once './controllers/CategoryController.php';
require_once './classes/Router.php';

use Api\Controllers\CategoryController;
use Api\Services\CategoryService;
use Exception;
use PDO;
use Api\Classes\Router;
use Api\Controllers\CourseController;
use Api\Services\CourseService;

header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header("Access-Control-Allow-Origin: http://cc.localhost");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Credentials: true");
header("HTTP/1.1 200 OK");

try {
    $pdo = new PDO('mysql:host=db;dbname=course_catalog', 'test_user', 'test_password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $courseService = new CourseService($pdo);
    $categoryService = new CategoryService($pdo);
} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        'message' => 'Couldn\'t connect to the database',
        'code' => 500,
        'status' => 'Server Error'
    ]);

    return;
}

$courseController = new CourseController($courseService);
$categoryController = new CategoryController($categoryService);

$router = new Router();

$router->addRoute('GET', '/courses', [$courseController, 'index']);
$router->addRoute('GET', '/courses/:courseId', [$courseController, 'show']);
$router->addRoute('GET', '/categories', [$categoryController, 'index']);
$router->addRoute('GET', '/categories/:categoryId', [$categoryController, 'show']);

try {
    $response = $router->match($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    echo json_encode($response);
} catch (Exception $e) {
    http_response_code(500);

    echo json_encode(array(
        'message' => 'Something went wrong.',
        'code' => 500,
        'status' => 'Server Error'
    ));
}
