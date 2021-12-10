<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

/* Importar usuarios */
Route::get('/import-view', [ \App\Http\Controllers\Controller::class, 'indexImportView' ])->name('import.view');
Route::post('/import-excel', [ \App\Http\Controllers\Controller::class, 'setUserDB' ] )->name('import.excel');

Route::get('/get-table-bingo', [\App\Http\Controllers\Controller::class, 'getPathTableBingo']);
Route::post('/download', [\App\Http\Controllers\Controller::class, 'downloadTableBingo'])->name('download');

