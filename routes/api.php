<?php

use App\Http\Controllers\AssociatiController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');

Route::get('/associati', [AssociatiController::class, 'getAllAssociati'] );
Route::post('/nuovo-associato', [AssociatiController::class, 'addNuovoAssociato'] );
Route::delete('/elimina-associato/{id}', [AssociatiController::class, 'eliminaAssociato'] );
Route::get('/associato/{id}', [AssociatiController::class, 'ottieniAssociato'] );
Route::put('/modifica-associato/{id}', [AssociatiController::class, 'modificaAssociato'] );

