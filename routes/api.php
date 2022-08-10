<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\GuildController;
use App\Http\Controllers\Api\PhoneController;
use App\Http\Controllers\Api\SocialController;

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


// GUILD ROUTES
Route::post("/guilds",[GuildController::class,"store"])->middleware("auth:sanctum");
Route::get("/guilds",[GuildController::class,"index"]);
Route::get("/guilds/{guild}",[GuildController::class,"show"]);
Route::put("/guilds/{guild}",[GuildController::class,"update"])->middleware("auth:sanctum");
Route::delete("/guilds/{guild}",[GuildController::class,"destroy"])->middleware("auth:sanctum");

// SHOP ROUTES
Route::post("/shops",[ShopController::class,"store"])->middleware("auth:sanctum");
Route::get("/shops",[ShopController::class,"index"]);
Route::get("/shops/{shop}",[ShopController::class,"show"]);
Route::put("/shops/{shop}",[ShopController::class,"update"])->middleware("auth:sanctum");
Route::delete("/shops/{shop}",[ShopController::class,"destroy"])->middleware("auth:sanctum");

// SOCIAL ROUTES
Route::post("/socials",[SocialController::class,"store"])->middleware("auth:sanctum");
Route::get("/socials",[SocialController::class,"index"]);
Route::get("/socials/{social}",[SocialController::class,"show"]);
Route::put("/socials/{social}",[SocialController::class,"update"])->middleware("auth:sanctum");
Route::delete("/socials/{social}",[SocialController::class,"destroy"])->middleware("auth:sanctum");

// PHONE ROUTES
Route::post("/phones",[PhoneController::class,"store"])->middleware("auth:sanctum");
Route::get("/phones",[PhoneController::class,"index"]);
Route::get("/phones/{phone}",[PhoneController::class,"show"]);
Route::put("/phones/{phone}",[PhoneController::class,"update"])->middleware("auth:sanctum");
Route::delete("/phones/{phone}",[PhoneController::class,"destroy"])->middleware("auth:sanctum");

// AUTH ROUTES
Route::post("/register",[AuthController::class,"register"]);
Route::post("/login",[AuthController::class,"login"]);
Route::get("/logout",[AuthController::class,"logout"])->middleware("auth:sanctum");