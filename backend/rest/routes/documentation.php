<?php

Flight::route('GET /openapi.json', function () {
    require_once __DIR__ . '/../../openapi.php';
    Flight::json(fitpulseOpenApiDocument(), 200);
});

Flight::route('GET /docs', function () {
    header('Content-Type: text/html; charset=utf-8');
    echo '<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FitPulse API Documentation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swagger-ui-dist@5/swagger-ui.css">
</head>
<body>
    <div id="swagger-ui"></div>
    <script src="https://cdn.jsdelivr.net/npm/swagger-ui-dist@5/swagger-ui-bundle.js"></script>
    <script>
        window.ui = SwaggerUIBundle({
            url: "./openapi.json",
            dom_id: "#swagger-ui",
            deepLinking: true,
            persistAuthorization: true
        });
    </script>
</body>
</html>';
});
