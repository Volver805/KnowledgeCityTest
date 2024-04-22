<?php
namespace Api;

require_once './services/CourseService.php';
require_once './controllers/CourseController.php';
require_once './classes/Router.php';

use Exception;
use PDO;
use Api\Classes\Router;
use Api\Controllers\CourseController;
use Api\Services\CourseService;

try {
	$pdo = new PDO('mysql:host=db;dbname=course_catalog', 'test_user', 'test_password');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$courseService = new CourseService($pdo);
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

$router = new Router();

$router->addRoute('GET', '/courses', [$courseController, 'index']);

$router->addRoute('GET', '/courses/:courseId', [$courseController, 'show']);

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