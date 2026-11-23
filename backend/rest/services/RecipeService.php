<?php
require_once __DIR__ . '/../../utils/exceptions.php';
require_once __DIR__ . '/../../utils/validator.php';
require_once __DIR__ . '/../../config/config.php';

class RecipeService
{
    protected $base_url;
    protected $api_key;
    protected $timeout;

    public function __construct($base_url = null, $api_key = null, $timeout = 8)
    {
        $this->base_url = rtrim((string) ($base_url ?: Config::EXTERNAL_RECIPE_API_BASE_URL()), '/');
        $this->api_key = (string) ($api_key ?? Config::EXTERNAL_RECIPE_API_KEY());
        $this->timeout = (int) $timeout;
    }

    public function search($term = 'chicken', $limit = 10)
    {
        $term = trim((string) $term);
        if ($term === '') {
            $term = 'chicken';
        }

        Validator::integer($limit, 'limit', 1, 20);
        $limit = (int) $limit;

        $url = $this->base_url . '/search.php?s=' . rawurlencode($term);
        $headers = [
            'Accept: application/json'
        ];
        if ($this->api_key !== '') {
            $headers[] = 'X-API-Key: ' . $this->api_key;
        }

        if (!function_exists('curl_init')) {
            error_log('RecipeService: cURL is unavailable.');
            throw new ExternalServiceException(
                'The recipe service is temporarily unavailable. Please try again later.'
            );
        }

        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_FOLLOWLOCATION => false
        ]);

        $body = curl_exec($curl);
        $curl_error = curl_error($curl);
        $http_status = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($body === false || $curl_error !== '') {
            error_log('RecipeService: external request failed: ' . $curl_error);
            throw new ExternalServiceException(
                'The recipe service is temporarily unavailable. Please try again later.'
            );
        }

        if ($http_status < 200 || $http_status >= 300) {
            error_log('RecipeService: external API returned HTTP ' . $http_status);
            throw new ExternalServiceException(
                'The recipe service is temporarily unavailable. Please try again later.'
            );
        }

        $payload = json_decode((string) $body, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($payload) || !array_key_exists('meals', $payload)) {
            error_log('RecipeService: external API returned invalid JSON.');
            throw new ExternalServiceException(
                'The recipe service is temporarily unavailable. Please try again later.'
            );
        }

        if ($payload['meals'] === null) {
            return [];
        }

        if (!is_array($payload['meals'])) {
            error_log('RecipeService: external API returned an invalid meals payload.');
            throw new ExternalServiceException(
                'The recipe service is temporarily unavailable. Please try again later.'
            );
        }

        $recipes = [];
        foreach (array_slice($payload['meals'], 0, $limit) as $meal) {
            if (!is_array($meal)) {
                continue;
            }
            $recipes[] = $this->normalizeMeal($meal);
        }
        return $recipes;
    }

    protected function normalizeMeal($meal)
    {
        $ingredients = [];
        for ($i = 1; $i <= 20; $i++) {
            $ingredient = trim((string) ($meal['strIngredient' . $i] ?? ''));
            $measure = trim((string) ($meal['strMeasure' . $i] ?? ''));
            if ($ingredient !== '') {
                $ingredients[] = [
                    'name' => $ingredient,
                    'measure' => $measure
                ];
            }
        }

        return [
            'id' => (string) ($meal['idMeal'] ?? ''),
            'name' => (string) ($meal['strMeal'] ?? ''),
            'category' => (string) ($meal['strCategory'] ?? ''),
            'area' => (string) ($meal['strArea'] ?? ''),
            'instructions' => (string) ($meal['strInstructions'] ?? ''),
            'image' => (string) ($meal['strMealThumb'] ?? ''),
            'source' => (string) ($meal['strSource'] ?? ''),
            'youtube' => (string) ($meal['strYoutube'] ?? ''),
            'ingredients' => $ingredients
        ];
    }
}
