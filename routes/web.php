<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParentController;
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
Route::get('/sign-in', [LoginController::class, "index"])->name("sign_in")->middleware('guest');
Route::post('/sign-in', [LoginController::class, "login"])->name("login");
Route::get("/sign-out", [LoginController::class, "logout"])->name("logout");

Route::middleware(['auth'])->group( function () {
    Route::get('/', [DashboardController::class, "index"])->name("dashboard");

    Route::get("/balita", [BalitaController::class, "index"])->name("balita");
    Route::post("/balita", [BalitaController::class, "store"])->name("balita_store");
    Route::put("/balita/{participant}", [BalitaController::class, "update"])->name("balita_update");
    Route::delete("/balita/{participant}", [BalitaController::class, "destroy"])->name("balita_destroy");

    Route::get("/parent", [ParentController::class, "get_parent"])->name("parent");
} );


