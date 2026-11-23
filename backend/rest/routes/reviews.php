<?php

Flight::route('GET /reviews', function () {
    $query = Flight::request()->query->getData();
    if (isset($query['user_id'])) {
        Flight::json(Flight::reviewService()->get_by_user_id((int) $query['user_id']));
        return;
    }
    if (isset($query['workout_id'])) {
        Flight::json(Flight::reviewService()->get_by_workout_id((int) $query['workout_id']));
        return;
    }
    Flight::json(Flight::reviewService()->get_all());
});

Flight::route('GET /users/@id:[0-9]+/reviews', function ($id) {
    Flight::json(Flight::reviewService()->get_by_user_id((int) $id));
});

Flight::route('GET /workouts/@id:[0-9]+/reviews', function ($id) {
    Flight::json(Flight::reviewService()->get_by_workout_id((int) $id));
});

Flight::route('GET /reviews/@id:[0-9]+', function ($id) {
    Flight::json(Flight::reviewService()->get_by_id((int) $id));
});

Flight::route('POST /reviews', function () {
    $review = fitpulse_request_data();
    Flight::json(Flight::reviewService()->add($review), 201);
});

Flight::route('PUT /reviews/@id:[0-9]+', function ($id) {
    $review = fitpulse_request_data();
    Flight::json(Flight::reviewService()->update($review, (int) $id));
});

Flight::route('PATCH /reviews/@id:[0-9]+', function ($id) {
    $review = fitpulse_request_data();
    Flight::json(Flight::reviewService()->update($review, (int) $id));
});

Flight::route('DELETE /reviews/@id:[0-9]+', function ($id) {
    Flight::reviewService()->delete((int) $id);
    Flight::json([
        'message' => 'Review deleted successfully.'
    ], 200);
});
