<?php

use App\Models\Product;
use App\Http\Controllers\Crawler;
use App\Class\helpers\SearchOnline;
use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return view('welcome');
});


route::get('test',function (){
  
        });

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
Route::group(['prefix' => 'crawler'], function () {
    Route::get('/',[Crawler::class,'crawlerView'])->name('crawlerView');
});