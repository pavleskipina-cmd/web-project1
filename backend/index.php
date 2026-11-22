<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/utils/exceptions.php';
require_once __DIR__ . '/utils/validator.php';

require_once __DIR__ . '/rest/services/UserService.php';
require_once __DIR__ . '/rest/services/WorkoutService.php';
require_once __DIR__ . '/rest/services/ExerciseService.php';
require_once __DIR__ . '/rest/services/NutritionLogService.php';
require_once __DIR__ . '/rest/services/ReviewService.php';

$recipeServicePath = __DIR__ . '/rest/services/RecipeService.php';
if (is_file($recipeServicePath)) {
    require_once $recipeServicePath;
}

header('Content-Type: application/json');

function fitpulse_request_data()
{
    $request = Flight::request();
    $data = $request->data->getData();
    $raw = $request->getBody();
    if (empty($data)) {
        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) {
            $decoded = json_decode(file_get_contents('php://input'), true);
        }
        if (is_array($decoded)) {
            $data = $decoded;
        }
    }
    return $data;
}

Flight::register('userService', 'UserService');
Flight::register('workoutService', 'WorkoutService');
Flight::register('exerciseService', 'ExerciseService');
Flight::register('nutritionLogService', 'NutritionLogService');
Flight::register('reviewService', 'ReviewService');
Flight::register('recipeService', 'RecipeService');

Flight::map('error', function ($e) {
    if ($e instanceof HttpException) {
        $status = $e->get_status();
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $status,
            'error' => $e->getMessage()
        ]);
        return;
    }

    error_log($e);
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 500,
        'error' => 'Something went wrong on the server. Please try again later.'
    ]);
});

Flight::map('notFound', function () {
    $request = Flight::request();
    $url = strtok($request->url, '?');

    Flight::json([
        'status' => 404,
        'error' => 'Endpoint ' . $request->method . ' ' . $url . ' does not exist.'
    ], 404);
});

set_exception_handler(function ($e) {
    Flight::error($e);
});

require_once __DIR__ . '/rest/routes/users.php';
require_once __DIR__ . '/rest/routes/workouts.php';
require_once __DIR__ . '/rest/routes/exercises.php';
require_once __DIR__ . '/rest/routes/nutrition_logs.php';
require_once __DIR__ . '/rest/routes/reviews.php';
require_once __DIR__ . '/rest/routes/recipes.php';
require_once __DIR__ . '/rest/routes/documentation.php';

Flight::start();