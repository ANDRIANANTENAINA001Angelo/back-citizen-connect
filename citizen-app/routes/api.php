<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Models\DemandeService;
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

Route::resource("users",UserController::class)->except(["edit","create"]);
Route::resource("services",ServiceController::class)->except(["edit","create"]);
Route::resource("files",FileController::class)->except(["edit","create"]);
Route::resource("demandeServices",DemandeService::class)->except(["edit","create"])->middleware("auth:sanctum");

Route::post("login",[AuthController::class,"Login"]);
Route::post("loginCam",[AuthController::class,"LoginImage"]);
Route::post("logout",[AuthController::class,"Logout"])->middleware("auth:sanctum");


Route::post('uploads/{id}',[UserController::class,"uploads"]);
Route::post('uploads-cin/{id}',[UserController::class,"uploads_cin"]);
