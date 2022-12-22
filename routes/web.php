<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\RecipeController;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () {
    return response()->json([
        'title' => 'Unofficial Cookpad API',
        'status' => 'Under Development',
        'documentation' => 'https://github.com/reivky/unofficial-cookpad-api'
    ], 200);
});
$router->get('/api', function () {
    return response()->json([
        'endpoint' => [
            [
                'url' => env('APP_URL') . '/api/recipes',
                'usage' => 'Get all the latest recipes'
            ],
            [
                'url' => env('APP_URL') . '/api/recipe/{slug}',
                'usage' => 'get detail of one recipe'
            ],
            [
                'url' => env('APP_URL') . '/api/recipes/categories',
                'usage' => 'Get all recipe categories'
            ],
            [
                'url' => env('APP_URL') . '/api/recipes/category/{slug}',
                'usage' => 'Get all the latest recipes from specific category'
            ],
        ],
    ], 200);
});
$router->get('/api/recipes', 'RecipeController@recipes');
$router->get('/api/recipe/{slug}', 'RecipeController@recipe');
$router->get('/api/recipes/categories', 'CategoryController@categories');
$router->get('/api/recipes/category/{slug}', 'CategoryController@category');
