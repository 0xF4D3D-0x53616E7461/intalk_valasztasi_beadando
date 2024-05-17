<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\PartokController;
use App\Http\Controllers\MegyeController;
use App\Http\Controllers\ValasztasikeruletController;
use App\Http\Controllers\EgyeniController;
use App\Http\Controllers\OrszagoslistakController;
use App\Http\Controllers\ValasztasiadatokController;
use App\Http\Controllers\ReszvetelController;

Route::apiResource('partok', PartokController::class);
Route::apiResource('megye', MegyeController::class);
Route::apiResource('valasztasikerulet', ValasztasikeruletController::class);
Route::apiResource('egyeni', EgyeniController::class);
Route::apiResource('orszagoslistak', OrszagoslistakController::class);
Route::apiResource('valasztasiadatok', ValasztasiadatokController::class);
Route::apiResource('reszvetel', ReszvetelController::class);
Route::get('/getIndulo/{nev}', [ApiController::class, 'getIndulo']);
Route::get('/getMegye/{nev}', [ApiController::class, 'getMegye']);
Route::get('/getPart/{nev}', [ApiController::class, 'getPart']);