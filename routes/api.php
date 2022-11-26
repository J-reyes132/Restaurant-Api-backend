<?php

use App\Http\Controllers\AcademicDegreeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Tools\ResponseCodes;

#USER SCAFFOLD
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TableController;
use App\Models\Customer;

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

    //CUSTOMERS
    Route::get('/customer', [CustomerController::class, 'index']);
    Route::get('/customer/{customer}/show', [CustomerController::class, 'show']);
    Route::post('/customer', [CustomerController::class, 'store']);
    Route::post('/customer/{customer}/update', [CustomerController::class, 'update']);
    Route::delete('/customer/{customer}/delete', [CustomerController::class, 'destroy']);

    //EMPLOYEES
    Route::get('/employee', [EmployeeController::class, 'index']);
    Route::get('/employee/{employee}/show', [EmployeeController::class, 'show']);
    Route::post('employee', [EmployeeController::class, 'store']);
    Route::post('/employee/{employee}/update', [EmployeeController::class, 'update']);
    Route::delete('/employee/{employee}/delete', [EmployeeController::class, 'destroy']);

    //PRODUCTS
    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/product/{product}/show', [ProductController::class, 'show']);
    Route::post('/product', [ProductController::class, 'store']);
    Route::post('/product/{product}/update', [ProductController::class, 'update']);
    Route::delete('/product/{product}/delete', [ProductController::class, 'destroy']);

    //TABLES
    Route::get('/table', [TableController::class, 'index']);
    Route::get('/table/{table}/show', [TableController::class, 'show']);
    Route::post('/table', [TableController::class, 'store']);
    Route::post('/table/{table}/update', [TableController::class, 'update']);
    Route::delete('/table/{table}/delete', [TableController::class, 'destroy']);

    //MENUS
    Route::get('/menu', [MenuController::class, 'index']);
    Route::get('/menu/{menu}/show', [MenuController::class, 'show']);
    Route::post('/menu', [MenuController::class, 'store']);
    Route::post('/menu/{menu}/update', [MenuController::class, 'update']);
    Route::delete('/menu/{menu}/delete', [MenuController::class, 'destroy']);
});



// FRONTEND ROUTES
//routes without auth

//FALL BACK ROUTE FOR NO URL FOUND
Route::fallback(function () {
    return response()->json([
        'status' => 'error', 'message' => 'Ruta incorrecta o usuario no autenticado'
    ], ResponseCodes::NOT_FOUND);
});
