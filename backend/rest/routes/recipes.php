<?php

Flight::route('GET /recipes/search', function () {
    $query = Flight::request()->query->getData();
    $term = $query['q'] ?? 'chicken';
    $limit = $query['limit'] ?? 10;

    Flight::json(Flight::recipeService()->search($term, $limit));
});
