<?php

use App\Http\Controllers\AcademicDegreeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Tools\ResponseCodes;

#USER SCAFFOLD
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\PermisoController;

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

Route::post('/profile/login', [AuthController::class, 'login'])->name('login');

// Route::get('/posts', 'App\Http\Controllers\api\frontend\PostController');
// Route::get('/posts', 'PostController')->name('posts');
// Route::get('/posts/{post}', 'App\Http\Controllers\api\frontend\PostController', 'show');

Route::group(['middleware' => ['auth:api', 'verified']], function () {
    // Route::get('/posts', [PostController::class, 'index']);
    // Route::get('/posts/{post}/show', [PostController::class, 'show']);

    Route::get('/profile/getProfile', [ProfileController::class, 'getProfile']);
    Route::post('/profile/logout', [AuthController::class, 'logout']);
    Route::post('/profile/update', [ProfileController::class, 'update']);
    Route::post('/profile/changepassword', [ProfileController::class, 'changePassword']);

    //Bitacoras
    Route::get('/bitacoras', [BitacoraController::class, 'index']);
    Route::get('/bitacoras/{bitacora}/show', [BitacoraController::class, 'show']);

    //TERRITORIAL
    Route::get('/paises', [CountryController::class, 'index']);
    Route::get('/paises/{pais}/show', [CountryController::class, 'show']);
    Route::get('/provincias/{provincia}/show', [ProvinciaController::class, 'show']);

    Route::get('/municipios/{municipio}/show', [MunicipioController::class, 'show']);

    Route::get('/distritos/{distrito}/show', [DistritoController::class, 'show']);

    //USERS
    Route::get('/usuarios', [UserController::class, 'index']);
    Route::get('/usuarios/{usuario}/show', [UserController::class, 'show']);
    Route::post('/usuarios/store', [UserController::class, 'store']);
    Route::post('/usuarios/{usuario}/update', [UserController::class, 'update']);
    Route::delete('/usuarios/{usuario}/delete', [UserController::class, 'destroy']);
    Route::post('/usuarios/{usuario}/resetpassword', [UserController::class, 'resetPassword']);
    Route::post('/usuarios/{usuario}/toggle', [UserController::class, 'toggle']);

    //ROLES
    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/roles/permisos', [PermisoController::class, 'index']);
    Route::get('/roles/modulos', [ModuloController::class, 'index']);
    Route::get('/roles/{role}/show', [RoleController::class, 'show']);
    Route::post('/roles/store', [RoleController::class, 'store']);
    Route::post('/roles/{role}/update', [RoleController::class, 'update']);
    Route::post('/roles/{role}/attachModule', [RoleController::class, 'attachModule']);
    Route::post('/roles/{role}/attachPermission', [RoleController::class, 'attachPermission']);
    Route::delete('/roles/{role}/detachModule', [RoleController::class, 'detachModule']);
    Route::delete('/roles/{role}/detachPermission', [RoleController::class, 'detachPermission']);
    Route::delete('/roles/{role}/delete', [RoleController::class, 'destroy']);

});



// FRONTEND ROUTES
//routes without auth

//FALL BACK ROUTE FOR NO URL FOUND
Route::fallback(function () {
    return response()->json([
        'status' => 'error', 'message' => 'Ruta incorrecta o usuario no autenticado'
    ], ResponseCodes::NOT_FOUND);
});