<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnakController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JsonDataController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenimbanganController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\OrangtuaMiddleware;
use App\Http\Middleware\PosyanduMiddleware;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login-page', [LoginController::class, 'showLoginForm'])->name('show.login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['admin',AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
    Route::get('/admin/posyandu',[AdminController::class,'posyandu'])->name('admin.posyandu');
    Route::get('/admin/anak',[AdminController::class,'anak'])->name('admin.anak');
    Route::get('/admin/user',[AdminController::class,'user'])->name('admin.user');

    Route::resource('posyandu',PosyanduController::class);
    Route::resource('users',UserController::class);

    Route::resource('anaks',AnakController::class);
    Route::post('import-anaks', [AnakController::class, 'import'])->name('import.anaks');
});

Route::middleware(['posyandu',PosyanduMiddleware::class])->group(function () {
    Route::get('/admin-posyandu/dashboard',[DashboardController::class,'posyandu'])->name('posyandu.dashboard');
    Route::get('/admin-posyandu/anak',[AdminController::class,'anak'])->name('posyandu.anak');
    Route::resource('anaks',AnakController::class);
});

Route::middleware(['ortu',OrangtuaMiddleware::class])->group(function () {
    Route::get('/ortu/dashboard',[DashboardController::class,'ortu'])->name('orangtua.dashboard');
});

// Route::post('penimbagan/store',[PenimbanganController::class,'store'])->name('penimbangan.store');
Route::get('penimbangan/{id}',[PenimbanganController::class,'create'])->name('penimbangan.create');

// Endpoint untuk mengambil data sensor terbaru
Route::get('/latest-data', [PenimbanganController::class, 'latestData']);

// Endpoint untuk menerima nilai koreksi dari pengguna
Route::post('/correct-data', [PenimbanganController::class, 'correctData'])->name('timbang');

Route::patch('/update_timbang/{id}', [PenimbanganController::class,'update'])->name('up.timbang');
// // cek
// Route::get('/coba',[PenimbanganController::class,'index']);
Route::post('import-penimbangans', [PenimbanganController::class, 'import'])->name('import.penimbangans');
Route::get('/timbangan/export', [PenimbanganController::class, 'export'])->name('timbangan.export');

Route::get('/data/{filename}',[JsonDataController::class,'getData']);
Route::get('/',[DashboardController::class,'guest']);

Route::get('/pos/{name}',[PosyanduController::class,'guest'])->name('route.name');
