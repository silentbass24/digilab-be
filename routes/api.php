<?php

use App\Http\Controllers\AssociatiController;
use App\Http\Controllers\IscrizioniController;
use App\Http\Controllers\CorsiController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/cache-config', function(){
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    return response()->json(['message' => 'Config cache cleared']);
});

Route::get('/cache-route', function () {
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    return response()->json(['message' => 'Route cache cleared']);
});

Route::get('/cache-event', function () {
    Artisan::call('event:clear');
    Artisan::call('event:cache');
    return response()->json(['message' => 'Event cache cleared']);
});

Route::get('/cache-config', function () {
    Artisan::call('config:cache');
    return response()->json(['message' => 'Config cache cleared']);
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::post('/nuovo-associato', [AssociatiController::class, 'addNuovoAssociato'] );
Route::get('/lista-corsi', [CorsiController::class, 'recuperaListaCorsi'] );

Route::middleware('auth:sanctum')->group(function(){
    //autenticazione amministratore
    Route::post('/logout', [AuthController::class,'logout']);

    //gestione associati
    Route::get('/associati', [AssociatiController::class, 'getAllAssociati'] );
    Route::delete('/elimina-associato/{id}', [AssociatiController::class, 'eliminaAssociato'] );
    Route::get('/associato/{id}', [AssociatiController::class, 'ottieniAssociato'] );
    Route::put('/modifica-associato/{id}', [AssociatiController::class, 'modificaAssociato'] );
    Route::put('/conferma-associato/{id}', [AssociatiController::class, 'confermaAssociato'] );

    //gestione corsi
    Route::post('/nuovo-corso', [CorsiController::class, 'addNuovoCorso'] );
    Route::delete('/elimina-corso/{id}', [CorsiController::class, 'eliminaCorso'] );
    Route::put('/modifica-corso/{id}', [CorsiController::class, 'modificaCorso'] );
    Route::get('/corso/{id}', [CorsiController::class, 'ottieniCorso'] );

    //gestione iscrizioni
    Route::delete('/elimina-iscrizione/{id}', [IscrizioniController::class, 'eliminaIscrizione'] );
    Route::get('/iscrizioni-per-corso/{id?}', [IscrizioniController::class, 'listaIscrizioniPerCorso'] );
    Route::get('/iscrizioni-per-associato/{id?}', [IscrizioniController::class, 'listaIscrizionePerAssociato'] );

});
Route::post('/nuova-iscrizione', [IscrizioniController::class, 'creaIscrizione'] );


