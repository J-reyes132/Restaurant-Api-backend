<?php

use Illuminate\Support\Facades\Route;
use App\Tools\ResponseCodes;

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

Route::get('/clear-cache', function() {
    Artisan::call('optimize:clear');
    echo Artisan::output();
});

Route::get('/', function () {
    if(env('APP_ENV') != 'local') {
        return response()->json(['status' => 'error', 'message' => 'No autorizado'], ResponseCodes::UNAUTHORIZED);
    } else {
        return redirect('api/documentation');
    }
});

Route::fallback(function () {
    return response()->json(['status' => 'error', 'message' => 'Ruta Incorrecta o no ha iniciado sesion'], ResponseCodes::NOT_FOUND);
});