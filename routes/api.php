<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubjectController;
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

Route::get('books/pre-requisite', [BookController::class, 'preRequisite']);
Route::resource('books', BookController::class);
Route::resource('authors', AuthorController::class);
Route::resource('subjects', SubjectController::class);

//Route::get('report', function(){
//
//});

Route::post('report', [ReportController::class, 'report']);

Route::get('/health', function (Request $request) {
    return response()->json(['ok' => true]);
});
