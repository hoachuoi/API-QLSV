<?php

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
//    $st = \App\Models\student::find(3);
//    dd($st->courses->toArray());

    $courser = \App\Models\course::query()->find(4);
    dd($courser->students->toArray());
    return view('welcome');
});
