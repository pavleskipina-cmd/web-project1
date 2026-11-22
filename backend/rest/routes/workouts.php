<?php

Flight::route('GET /workouts', function () {
    $query = Flight::request()->query->getData();
    if (isset($query['user_id'])) {
        Flight::json(Flight::workoutService()->get_by_user_id((int) $query['user_id']));
        return;
    }
    Flight::json(Flight::workoutService()->get_all());
});

Flight::route('GET /users/@id:[0-9]+/workouts', function ($id) {
    Flight::json(Flight::workoutService()->get_by_user_id((int) $id));
});

Flight::route('GET /workouts/@id:[0-9]+', function ($id) {
    Flight::json(Flight::workoutService()->get_by_id((int) $id));
});

Flight::route('POST /workouts', function () {
    $workout = fitpulse_request_data();
    Flight::json(Flight::workoutService()->add($workout), 201);
});

Flight::route('PUT /workouts/@id:[0-9]+', function ($id) {
    $workout = fitpulse_request_data();
    Flight::json(Flight::workoutService()->update($workout, (int) $id));
});

Flight::route('PATCH /workouts/@id:[0-9]+', function ($id) {
    $workout = fitpulse_request_data();
    Flight::json(Flight::workoutService()->update($workout, (int) $id));
});

Flight::route('DELETE /workouts/@id:[0-9]+', function ($id) {
    Flight::workoutService()->delete((int) $id);
    Flight::json([
        'message' => 'Workout deleted successfully.'
    ], 200);
});
