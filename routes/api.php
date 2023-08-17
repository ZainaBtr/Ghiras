<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/auth/register',[App\Http\Controllers\AuthController::class,'createAccount']);
Route::post('/auth/login',[App\Http\Controllers\AuthController::class,'login']);
Route::post('/auth/clientregister',[App\Http\Controllers\AuthController::class,'createClientAccount']);
Route::post('/auth/clientlogin',[App\Http\Controllers\AuthController::class,'clientLogin']);
Route::put('/auth/updateCLientAccount',[App\Http\Controllers\AuthController::class,'updateClientAccount']);
//Route::get('/auth/show_client_profile',[App\Http\Controllers\AuthController::class,'show_client_profile']);
//Route::get('/auth/logout',[App\Http\Controllers\AuthController::class,'logout']);
//Route::middleware(['auth:api'])->group(function() {
    Route::prefix("categories")->group( function () {
        Route::get('/',[\App\Http\Controllers\CategoryController::class,'index']);
        Route::get('/{category}',[\App\Http\Controllers\CategoryController::class,'get_meals_in']);
        Route::post('/',[\App\Http\Controllers\CategoryController::class,'store']);
        Route::delete('/{category}', [\App\Http\Controllers\CategoryController::class,'destroy']);
    });
        Route::prefix("meals")->group(function () {
            Route::get('/', [\App\Http\Controllers\MealController::class, 'index']);
            Route::get('/show/{meal}', [\App\Http\Controllers\MealController::class, 'showComponents']);
            Route::get('/menu', [\App\Http\Controllers\MealController::class, 'menu']);
            Route::post('/', [\App\Http\Controllers\MealController::class, 'store']);
            Route::put('/{meal}', [\App\Http\Controllers\MealController::class, 'update']);
            Route::get('/search/', [\App\Http\Controllers\MealController::class, 'findMeal']);
            Route::delete('/{meal}/', [\App\Http\Controllers\MealController::class, 'destroy']);
    });
    Route::prefix("components")->group( function () {
        Route::get('/',[\App\Http\Controllers\ComponentController::class, 'index']);
        Route::get('/search/', [\App\Http\Controllers\ComponentController::class, 'findComponent']);
        Route::post('/',[\App\Http\Controllers\ComponentController::class, 'store']);
        Route::get('/{id}',[\App\Http\Controllers\ComponentController::class, 'show']);
        Route::get('/filter/{component_address}',[\App\Http\Controllers\ComponentController::class, 'filterByAddress']);
        Route::put('/{id}',[\App\Http\Controllers\ComponentController::class, 'update']);
        Route::delete('/{compoent}',[\App\Http\Controllers\ComponentController::class, 'destroy']);
    });

    Route::prefix("components_in_meals")->group( function () {
        Route::get('/',[\App\Http\Controllers\Component_In_MealController::class, 'index']);
      //  Route::post('/meals/{meal_id}/components', 'MealComponentController@store');
        Route::post('/{meal}',[\App\Http\Controllers\Component_In_MealController::class, 'store']);
        // Route::get('/{id}',[\App\Http\Controllers\Component_In_MealController::class, 'show']);
        Route::put('/{meal}/{component_in_meal}',[\App\Http\Controllers\Component_In_MealController::class, 'update']);
        Route::delete('/{meal}/{component_in_meal}',[\App\Http\Controllers\Component_In_MealController::class, 'destroy']);
    });

    Route::prefix("percentage")->group( function (){
        Route::get('/',[\App\Http\Controllers\PercentageController::class, 'index']);
        Route::post('/',[\App\Http\Controllers\PercentageController::class, 'store']);
    } );

//});



Route::middleware(['auth:api'])->group(function() {
    Route::get('/auth/show_client_profile',[App\Http\Controllers\AuthController::class,'show_client_profile']);
    Route::put('/auth/updateCLientAccount',[App\Http\Controllers\AuthController::class,'updateClientAccount']);

});

