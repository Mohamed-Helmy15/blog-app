<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\EmployerController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\api\v1\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/signup", [AuthController::class, "signup"]);
Route::post("/forgot-password", [AuthController::class, "forgotPassword"]);
Route::post("/reset-password/{token}", [AuthController::class, "resetPassword"]);
Route::post("/login", [AuthController::class, "login"]);
Route::post("/logout", [AuthController::class, "logout"])->middleware("auth:sanctum");

Route::post("/blogs/{blog}/sections/{section}/update", [SectionController::class, "updateSec"])->middleware("auth:sanctum");
Route::apiResource('blogs', BlogController::class)->middleware("auth:sanctum");
Route::apiResource('employers', EmployerController::class); // done
Route::apiResource('blogs.sections', SectionController::class)->middleware("auth:sanctum");