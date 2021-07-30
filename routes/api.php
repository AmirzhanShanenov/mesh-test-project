<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::post('rows/import',[FileController::class, 'importToRow']);
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
