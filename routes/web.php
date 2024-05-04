<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Notification;
use App\Http\Controllers\ExcelController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/updateNotife', [Notification::class, 'UpdateNotife']);



Route::get('/paper/{id}', function($id){
    $paper = App\Paper::find($id);
    return  view('paper',compact('paper'));
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/updateNotife', [Notification::class, 'UpdateNotife']);
    Route::post('/updateRead', [Notification::class, 'updateRead']);
});

require __DIR__.'/auth.php';


Route::group(['prefix' => 'admin'], function () {
    Route::get('/total/statment/{id}', [ExcelController::class, 'index']);
    Route::get('/export', [ExcelController::class, 'index'])->lazy();
    Route::get('/import-excel', [ExcelController::class,'importView']);
    Route::get('/notif', [Notification::class,'notifView']);
    Route::post('/importexcel', [ExcelController::class,'import'])->name('importExcel');
    Voyager::routes();
});
