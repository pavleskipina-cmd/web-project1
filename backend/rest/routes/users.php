<?php

Flight::route('GET /users', function () {
    Flight::json(Flight::userService()->get_all());
});

Flight::route('GET /users/@id:[0-9]+', function ($id) {
    Flight::json(Flight::userService()->get_by_id((int) $id));
});

Flight::route('POST /users', function () {
    $user = fitpulse_request_data();
    Flight::json(Flight::userService()->add($user), 201);
});

Flight::route('PUT /users/@id:[0-9]+', function ($id) {
    $user = fitpulse_request_data();
    Flight::json(Flight::userService()->update($user, (int) $id));
});

Flight::route('PATCH /users/@id:[0-9]+', function ($id) {
    $user = fitpulse_request_data();
    Flight::json(Flight::userService()->update($user, (int) $id));
});

Flight::route('DELETE /users/@id:[0-9]+', function ($id) {
    Flight::userService()->delete((int) $id);
    Flight::json([
        'message' => 'User deleted successfully.'
    ], 200);
});
