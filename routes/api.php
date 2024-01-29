<?php

use App\Http\Controllers\api\UserController;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/change-pass', [AuthController::class, 'changePassWord']);
});

//route user
Route::prefix('user')->middleware(["auth:api"])->group(function () {
    Route::get("/all", [UserController::class, 'index']);
    Route::post("/edit/{user_id}", [UserController::class, 'edit']);
    Route::delete("/delete/{user_id}", [UserController::class, 'delete']);
    Route::get("/all/{page}/{page_size}", [UserController::class, 'getUserWithPaginate']);
});



// Route::get("hello-world", [UserController::class, 'index']);
