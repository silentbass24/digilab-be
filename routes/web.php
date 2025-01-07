<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/card', function () {
    return view('tessera', array('nome' => 'Mario', 'cognome' => 'Rossi', 'n_tessera' => '00001'));
});
