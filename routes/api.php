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
//Route::get('/auth/logout',[App\Http\Controllers\AuthController::class,'logout']);

Route::middleware(['auth:api'])->group(function() {
    Route::prefix("categories")->group( function () {
        Route::get('/',[\App\Http\Controllers\CategoryController::class,'index']);
        Route::post('/',[\App\Http\Controllers\CategoryController::class,'store']);
        Route::delete('/{id}/',[\App\Http\Controllers\CategoryController::class,'destroy']);
       // Route::delete('/',[\App\Http\Controllers\CategoryController::class,'deleteCategory']);
    });
        Route::prefix("meals")->group(function () {
            Route::get('/', [\App\Http\Controllers\MealController::class, 'index']);
            Route::post('/', [\App\Http\Controllers\MealController::class, 'store']);
            Route::get('/{meal_name}', [\App\Http\Controllers\MealController::class, 'show']);
            Route::put('/{id}', [\App\Http\Controllers\MealController::class, 'update']);

            Route::delete('/{meal_name}', [\App\Http\Controllers\MealController::class, 'destroy']);
    });
    Route::prefix("components")->group( function () {
        Route::get('/',[\App\Http\Controllers\ComponentController::class, 'index']);
        Route::post('/',[\App\Http\Controllers\ComponentController::class, 'store']);
        Route::get('/{id}',[\App\Http\Controllers\ComponentController::class, 'show']);
        Route::post('/{id}',[\App\Http\Controllers\ComponentController::class, 'update']);
        Route::delete('/{id}',[\App\Http\Controllers\ComponentController::class, 'destroy']);
    });

    Route::prefix("components_in_meals")->group( function () {
        Route::get('/',[\App\Http\Controllers\Component_In_MealController::class, 'index']);
        Route::post('/',[\App\Http\Controllers\Component_In_MealController::class, 'store']);
        Route::get('/{id}',[\App\Http\Controllers\Component_In_MealController::class, 'show']);
        Route::put('/{id}',[\App\Http\Controllers\Component_In_MealController::class, 'update']);
        Route::delete('/{id}',[\App\Http\Controllers\Component_In_MealController::class, 'destroy']);
    });

});







