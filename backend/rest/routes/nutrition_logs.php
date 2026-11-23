<?php

Flight::route('GET /nutrition_logs', function () {
    $query = Flight::request()->query->getData();
    if (isset($query['user_id'])) {
        if (isset($query['date'])) {
            Flight::json(Flight::nutritionLogService()->get_by_user_and_date(
                (int) $query['user_id'],
                $query['date']
            ));
            return;
        }
        Flight::json(Flight::nutritionLogService()->get_by_user_id((int) $query['user_id']));
        return;
    }
    Flight::json(Flight::nutritionLogService()->get_all());
});

Flight::route('GET /users/@id:[0-9]+/nutrition-logs', function ($id) {
    $query = Flight::request()->query->getData();
    if (isset($query['date'])) {
        Flight::json(Flight::nutritionLogService()->get_by_user_and_date(
            (int) $id,
            $query['date']
        ));
        return;
    }
    Flight::json(Flight::nutritionLogService()->get_by_user_id((int) $id));
});

Flight::route('GET /nutrition_logs/@id:[0-9]+', function ($id) {
    Flight::json(Flight::nutritionLogService()->get_by_id((int) $id));
});

Flight::route('POST /nutrition_logs', function () {
    $log = fitpulse_request_data();
    Flight::json(Flight::nutritionLogService()->add($log), 201);
});

Flight::route('PUT /nutrition_logs/@id:[0-9]+', function ($id) {
    $log = fitpulse_request_data();
    Flight::json(Flight::nutritionLogService()->update($log, (int) $id));
});

Flight::route('PATCH /nutrition_logs/@id:[0-9]+', function ($id) {
    $log = fitpulse_request_data();
    Flight::json(Flight::nutritionLogService()->update($log, (int) $id));
});

Flight::route('DELETE /nutrition_logs/@id:[0-9]+', function ($id) {
    Flight::nutritionLogService()->delete((int) $id);
    Flight::json([
        'message' => 'Nutrition log deleted successfully.'
    ], 200);
});
