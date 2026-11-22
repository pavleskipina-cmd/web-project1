<?php

Flight::route('GET /exercises', function () {
    $query = Flight::request()->query->getData();
    if (isset($query['workout_id'])) {
        Flight::json(Flight::exerciseService()->get_by_workout_id((int) $query['workout_id']));
        return;
    }
    Flight::json(Flight::exerciseService()->get_all());
});

Flight::route('GET /workouts/@id:[0-9]+/exercises', function ($id) {
    Flight::json(Flight::exerciseService()->get_by_workout_id((int) $id));
});

Flight::route('GET /exercises/@id:[0-9]+', function ($id) {
    Flight::json(Flight::exerciseService()->get_by_id((int) $id));
});

Flight::route('POST /exercises', function () {
    $exercise = fitpulse_request_data();
    Flight::json(Flight::exerciseService()->add($exercise), 201);
});

Flight::route('PUT /exercises/@id:[0-9]+', function ($id) {
    $exercise = fitpulse_request_data();
    Flight::json(Flight::exerciseService()->update($exercise, (int) $id));
});

Flight::route('PATCH /exercises/@id:[0-9]+', function ($id) {
    $exercise = fitpulse_request_data();
    Flight::json(Flight::exerciseService()->update($exercise, (int) $id));
});

Flight::route('DELETE /exercises/@id:[0-9]+', function ($id) {
    Flight::exerciseService()->delete((int) $id);
    Flight::json([
        'message' => 'Exercise deleted successfully.'
    ], 200);
});
