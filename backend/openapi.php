<?php

function fitpulseOpenApiDocument()
{
    $error = [
        'type' => 'object',
        'required' => ['status', 'error'],
        'properties' => [
            'status' => ['type' => 'integer', 'example' => 400],
            'error' => ['type' => 'string', 'example' => 'Field is required.']
        ]
    ];

    $schemas = [
        'Error' => $error,
        'DeleteConfirmation' => [
            'type' => 'object',
            'required' => ['message'],
            'properties' => [
                'message' => ['type' => 'string', 'example' => 'User deleted successfully.']
            ]
        ],
        'User' => [
            'type' => 'object',
            'required' => ['id', 'name', 'email', 'role'],
            'properties' => [
                'id' => ['type' => 'integer', 'example' => 1],
                'name' => ['type' => 'string', 'maxLength' => 100],
                'email' => ['type' => 'string', 'format' => 'email'],
                'role' => ['type' => 'string', 'enum' => ['admin', 'user']],
                'created_at' => ['type' => 'string', 'format' => 'date-time']
            ]
        ],
        'UserInput' => [
            'type' => 'object',
            'required' => ['name', 'email', 'role'],
            'properties' => [
                'name' => ['type' => 'string', 'maxLength' => 100],
                'email' => ['type' => 'string', 'format' => 'email'],
                'role' => ['type' => 'string', 'enum' => ['admin', 'user'], 'default' => 'user']
            ]
        ],
        'UserCreateInput' => [
            'type' => 'object',
            'required' => ['name', 'email', 'password'],
            'properties' => [
                'name' => ['type' => 'string', 'maxLength' => 100],
                'email' => ['type' => 'string', 'format' => 'email'],
                'password' => ['type' => 'string', 'format' => 'password', 'example' => 'Password1'],
                'role' => ['type' => 'string', 'enum' => ['admin', 'user'], 'default' => 'user']
            ]
        ],
        'UserUpdateInput' => [
            'type' => 'object',
            'properties' => [
                'name' => ['type' => 'string', 'maxLength' => 100],
                'email' => ['type' => 'string', 'format' => 'email'],
                'role' => ['type' => 'string', 'enum' => ['admin', 'user']]
            ]
        ],
        'Workout' => [
            'type' => 'object',
            'required' => ['id', 'user_id', 'title', 'category'],
            'properties' => [
                'id' => ['type' => 'integer'],
                'user_id' => ['type' => 'integer'],
                'title' => ['type' => 'string', 'maxLength' => 150],
                'description' => ['type' => 'string', 'nullable' => true],
                'category' => ['type' => 'string', 'maxLength' => 80],
                'created_at' => ['type' => 'string', 'format' => 'date-time']
            ]
        ],
        'WorkoutInput' => [
            'type' => 'object',
            'required' => ['user_id', 'title', 'category'],
            'properties' => [
                'user_id' => ['type' => 'integer', 'minimum' => 1],
                'title' => ['type' => 'string', 'maxLength' => 150],
                'description' => ['type' => 'string', 'nullable' => true],
                'category' => ['type' => 'string', 'maxLength' => 80]
            ]
        ],
        'Exercise' => [
            'type' => 'object',
            'required' => ['id', 'workout_id', 'name', 'muscle_group', 'default_sets', 'default_reps'],
            'properties' => [
                'id' => ['type' => 'integer'],
                'workout_id' => ['type' => 'integer'],
                'name' => ['type' => 'string', 'maxLength' => 150],
                'muscle_group' => ['type' => 'string', 'maxLength' => 80],
                'default_sets' => ['type' => 'integer', 'minimum' => 1],
                'default_reps' => ['type' => 'integer', 'minimum' => 1]
            ]
        ],
        'ExerciseInput' => [
            'type' => 'object',
            'required' => ['workout_id', 'name', 'muscle_group', 'sets', 'reps'],
            'properties' => [
                'workout_id' => ['type' => 'integer', 'minimum' => 1],
                'name' => ['type' => 'string', 'maxLength' => 150],
                'muscle_group' => ['type' => 'string', 'maxLength' => 80],
                'sets' => ['type' => 'integer', 'minimum' => 1],
                'reps' => ['type' => 'integer', 'minimum' => 1]
            ]
        ],
        'NutritionLog' => [
            'type' => 'object',
            'required' => ['id', 'user_id', 'meal_type', 'calories', 'protein_grams', 'date'],
            'properties' => [
                'id' => ['type' => 'integer'],
                'user_id' => ['type' => 'integer'],
                'meal_type' => ['type' => 'string', 'maxLength' => 50],
                'calories' => ['type' => 'integer', 'minimum' => 0],
                'protein_grams' => ['type' => 'number', 'format' => 'float', 'minimum' => 0],
                'date' => ['type' => 'string', 'format' => 'date']
            ]
        ],
        'NutritionLogInput' => [
            'type' => 'object',
            'required' => ['user_id', 'meal_type', 'calories', 'protein_grams', 'date'],
            'properties' => [
                'user_id' => ['type' => 'integer', 'minimum' => 1],
                'meal_type' => ['type' => 'string', 'maxLength' => 50],
                'calories' => ['type' => 'integer', 'minimum' => 0],
                'protein_grams' => ['type' => 'number', 'format' => 'float', 'minimum' => 0],
                'date' => ['type' => 'string', 'format' => 'date']
            ]
        ],
        'Review' => [
            'type' => 'object',
            'required' => ['id', 'user_id', 'workout_id', 'rating'],
            'properties' => [
                'id' => ['type' => 'integer'],
                'user_id' => ['type' => 'integer'],
                'workout_id' => ['type' => 'integer'],
                'rating' => ['type' => 'integer', 'minimum' => 1, 'maximum' => 5],
                'comment' => ['type' => 'string', 'nullable' => true],
                'created_at' => ['type' => 'string', 'format' => 'date-time']
            ]
        ],
        'ReviewInput' => [
            'type' => 'object',
            'required' => ['user_id', 'workout_id', 'rating'],
            'properties' => [
                'user_id' => ['type' => 'integer', 'minimum' => 1],
                'workout_id' => ['type' => 'integer', 'minimum' => 1],
                'rating' => ['type' => 'integer', 'minimum' => 1, 'maximum' => 5],
                'comment' => ['type' => 'string', 'nullable' => true]
            ]
        ],
        'Recipe' => [
            'type' => 'object',
            'required' => ['id', 'name', 'category', 'area', 'instructions', 'image', 'source', 'youtube', 'ingredients'],
            'properties' => [
                'id' => ['type' => 'string'],
                'name' => ['type' => 'string'],
                'category' => ['type' => 'string'],
                'area' => ['type' => 'string'],
                'instructions' => ['type' => 'string'],
                'image' => ['type' => 'string', 'format' => 'uri'],
                'source' => ['type' => 'string', 'format' => 'uri'],
                'youtube' => ['type' => 'string', 'format' => 'uri'],
                'ingredients' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'properties' => [
                            'name' => ['type' => 'string'],
                            'measure' => ['type' => 'string']
                        ]
                    ]
                ]
            ]
        ]
    ];

    $jsonError = [
        'application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]
    ];
    $okArray = function ($schema) {
        return [
            '200' => [
                'description' => 'Successful response',
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'type' => 'array',
                            'items' => ['$ref' => '#/components/schemas/' . $schema]
                        ]
                    ]
                ]
            ]
        ];
    };
    $crud = function ($tag, $path, $idName, $schema, $createInputSchema, $updateInputSchema, $nested = [], $restrictedDelete = false) use ($jsonError) {
        $paths = [];
        $idParameter = [
            'name' => 'id',
            'in' => 'path',
            'required' => true,
            'schema' => ['type' => 'integer', 'minimum' => 1]
        ];
        $listResponses = [
            '200' => [
                'description' => 'Successful response',
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'type' => 'array',
                            'items' => ['$ref' => '#/components/schemas/' . $schema]
                        ]
                    ]
                ]
            ],
            '404' => ['description' => 'Related record not found', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]],
            '500' => ['description' => 'Unexpected server error', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]]
        ];
        $paths[$path] = [
            'get' => ['tags' => [$tag], 'summary' => 'List ' . strtolower($tag), 'parameters' => $nested, 'responses' => $listResponses],
            'post' => [
                'tags' => [$tag],
                'summary' => 'Create ' . strtolower($tag),
                'requestBody' => ['required' => true, 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/' . $createInputSchema]]]],
                'responses' => [
                    '201' => ['description' => 'Created', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/' . $schema]]]],
                    '400' => ['description' => 'Invalid input', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]],
                    '404' => ['description' => 'Related record not found', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]],
                    '500' => ['description' => 'Unexpected server error', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]]
                ]
            ]
        ];
        $itemPath = rtrim($path, '/') . '/{id}';
        $deleteResponses = [
            '200' => ['description' => 'Deleted', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/DeleteConfirmation']]]],
            '404' => ['description' => 'Record not found', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]],
            '500' => ['description' => 'Unexpected server error', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]]
        ];
        if ($restrictedDelete) {
            $deleteResponses['400'] = [
                'description' => 'Deletion restricted',
                'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]
            ];
        }
        $paths[$itemPath] = [
            'get' => [
                'tags' => [$tag],
                'summary' => 'Get one ' . strtolower($tag),
                'parameters' => [$idParameter],
                'responses' => [
                    '200' => ['description' => 'Successful response', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/' . $schema]]]],
                    '404' => ['description' => 'Record not found', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]],
                    '500' => ['description' => 'Unexpected server error', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]]
                ]
            ],
            'put' => [
                'tags' => [$tag],
                'summary' => 'Update ' . strtolower($tag),
                'parameters' => [$idParameter],
                'requestBody' => ['required' => true, 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/' . $updateInputSchema]]]],
                'responses' => [
                    '200' => ['description' => 'Updated', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/' . $schema]]]],
                    '400' => ['description' => 'Invalid input', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]],
                    '404' => ['description' => 'Record not found', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]],
                    '500' => ['description' => 'Unexpected server error', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]]
                ]
            ],
            'patch' => [
                'tags' => [$tag],
                'summary' => 'Partially update ' . strtolower($tag),
                'parameters' => [$idParameter],
                'requestBody' => ['required' => true, 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/' . $updateInputSchema]]]],
                'responses' => [
                    '200' => ['description' => 'Updated', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/' . $schema]]]],
                    '400' => ['description' => 'Invalid input', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]],
                    '404' => ['description' => 'Record not found', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]],
                    '500' => ['description' => 'Unexpected server error', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]]
                ]
            ],
            'delete' => [
                'tags' => [$tag],
                'summary' => 'Delete ' . strtolower($tag),
                'parameters' => [$idParameter],
                'responses' => $deleteResponses
            ]
        ];
        return $paths;
    };

    $paths = [];
    $paths += $crud('Users', '/users', 'id', 'User', 'UserCreateInput', 'UserUpdateInput', [], true);
    $paths += $crud('Workouts', '/workouts', 'id', 'Workout', 'WorkoutInput', 'WorkoutInput', [
        ['name' => 'user_id', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'integer', 'minimum' => 1]]
    ], true);
    $paths += $crud('Exercises', '/exercises', 'id', 'Exercise', 'ExerciseInput', 'ExerciseInput', [
        ['name' => 'workout_id', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'integer', 'minimum' => 1]]
    ]);
    $paths += $crud('Nutrition Logs', '/nutrition_logs', 'id', 'NutritionLog', 'NutritionLogInput', 'NutritionLogInput', [
        ['name' => 'user_id', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'integer', 'minimum' => 1]],
        ['name' => 'date', 'in' => 'query', 'required' => false, 'description' => 'YYYY-MM-DD; used with user_id', 'schema' => ['type' => 'string', 'format' => 'date']]
    ]);
    $paths += $crud('Reviews', '/reviews', 'id', 'Review', 'ReviewInput', 'ReviewInput', [
        ['name' => 'user_id', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'integer', 'minimum' => 1]],
        ['name' => 'workout_id', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'integer', 'minimum' => 1]]
    ]);

    $idParam = ['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer', 'minimum' => 1]];
    $paths['/users/{id}/workouts'] = [
        'get' => ['tags' => ['Workouts'], 'parameters' => [$idParam], 'responses' => $okArray('Workout')]
    ];
    $paths['/workouts/{id}/exercises'] = [
        'get' => ['tags' => ['Exercises'], 'parameters' => [$idParam], 'responses' => $okArray('Exercise')]
    ];
    $paths['/users/{id}/nutrition-logs'] = [
        'get' => [
            'tags' => ['Nutrition Logs'],
            'parameters' => [
                $idParam,
                ['name' => 'date', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'string', 'format' => 'date']]
            ],
            'responses' => $okArray('NutritionLog')
        ]
    ];
    $paths['/users/{id}/reviews'] = [
        'get' => ['tags' => ['Reviews'], 'parameters' => [$idParam], 'responses' => $okArray('Review')]
    ];
    $paths['/workouts/{id}/reviews'] = [
        'get' => ['tags' => ['Reviews'], 'parameters' => [$idParam], 'responses' => $okArray('Review')]
    ];
    $paths['/recipes/search'] = [
        'get' => [
            'tags' => ['Recipes'],
            'summary' => 'Search recipes',
            'parameters' => [
                ['name' => 'q', 'in' => 'query', 'required' => false, 'description' => 'Meal search term', 'schema' => ['type' => 'string', 'default' => 'chicken']],
                ['name' => 'limit', 'in' => 'query', 'required' => false, 'description' => 'Maximum results', 'schema' => ['type' => 'integer', 'minimum' => 1, 'maximum' => 20, 'default' => 10]]
            ],
            'responses' => [
                '200' => ['description' => 'Normalized recipes', 'content' => ['application/json' => ['schema' => ['type' => 'array', 'items' => ['$ref' => '#/components/schemas/Recipe']]]]],
                '400' => ['description' => 'Invalid limit', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]],
                '503' => ['description' => 'External recipe API unavailable', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]],
                '500' => ['description' => 'Unexpected server error', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]]
            ]
        ]
    ];

    return [
        'openapi' => '3.0.3',
        'info' => [
            'title' => 'FitPulse API',
            'version' => '1.0.0',
            'description' => 'REST API for workouts, exercises, nutrition logs, reviews, users, and recipes.'
        ],
        'servers' => [
            ['url' => '/backend', 'description' => 'FitPulse backend']
        ],
        'tags' => [
            ['name' => 'Users'],
            ['name' => 'Workouts'],
            ['name' => 'Exercises'],
            ['name' => 'Nutrition Logs'],
            ['name' => 'Reviews'],
            ['name' => 'Recipes']
        ],
        'paths' => $paths,
        'components' => [
            'schemas' => $schemas
        ]
    ];
}
