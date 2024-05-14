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


// Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => 'auth:sanctum'], function() {
//     Route::apiResource('notes',NoteController::class);
// });

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function() {
    Route::apiResource('notes',NoteController::class);
});

// Route::get('/notes', [NoteController::class, 'index']);  //Read
// Route::get('/save', [NoteController::class, 'store']);  //Create
// Route::get('/update{id}', [NoteController::class, 'update']);  //Update
// Route::get('/delete/{id}', [NoteController::class, 'destroy']);  //Delete
