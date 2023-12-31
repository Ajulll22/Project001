<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LansiaController;
use App\Http\Controllers\laporan\BalitaReportController;
use App\Http\Controllers\laporan\LansiaReportController;
use App\Http\Controllers\laporan\RemajaReportController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\RemajaController;
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
    Route::post("/balita/present", [BalitaController::class, "present"])->name("balita_present");
    Route::put("/balita/present/{detail}", [BalitaController::class, "present_update"])->name("balita_present_update");

    Route::get("/remaja", [RemajaController::class, "index"])->name("remaja");
    Route::post("/remaja", [RemajaController::class, "store"])->name("remaja_store");
    Route::put("/remaja/{participant}", [RemajaController::class, "update"])->name("remaja_update");
    Route::delete("/remaja/{participant}", [RemajaController::class, "destroy"])->name("remaja_destroy");
    Route::post("/remaja/present", [RemajaController::class, "present"])->name("remaja_present");
    Route::put("/remaja/present/{detail}", [RemajaController::class, "present_update"])->name("remaja_present_update");

    Route::get("/lansia", [LansiaController::class, "index"])->name("lansia");
    Route::post("/lansia", [LansiaController::class, "store"])->name("lansia_store");
    Route::put("/lansia/{participant}", [LansiaController::class, "update"])->name("lansia_update");
    Route::delete("/lansia/{participant}", [LansiaController::class, "destroy"])->name("lansia_destroy");
    Route::post("/lansia/present", [LansiaController::class, "present"])->name("lansia_present");
    Route::put("/lansia/present/{detail}", [LansiaController::class, "present_update"])->name("lansia_present_update");

    Route::get("/laporan/balita", [BalitaReportController::class, "index"])->name("laporan_balita");
    Route::get("/laporan/remaja", [RemajaReportController::class, "index"])->name("laporan_remaja");
    Route::get("/laporan/lansia", [LansiaReportController::class, "index"])->name("laporan_lansia");

    Route::get("/parent", [ParentController::class, "get_parent"])->name("parent");
} );


