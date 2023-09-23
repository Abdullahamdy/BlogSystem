<?php

use App\Http\Controllers\BlogController;
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

Route::get('/', function () {
    return view('home');
});
Route::get('/',[BlogController::class,'index']);
Route::get('/blog/{slug}',[BlogController::class,'singleBlog']);
Route::get('/category/{categoryName}/{id}',[BlogController::class,'categoryIndex']);
Route::get('/tag/{tagName}/{id}',[BlogController::class,'tagIndex']);
Route::get('/allblogs',[BlogController::class,'allblogs']);
