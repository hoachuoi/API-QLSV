<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\userController;
use App\Http\Controllers\Api\sudentController;
use App\Http\Controllers\Api\parentController;
use App\Http\Controllers\Api\teacherController;

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
//API user table
Route::get('user', [userController::class,'index']);
//Route::get('product', [ProductController::class, 'index']);
Route::post('user',[userController::class,'store']);
Route::get('user/{id}',[userController::class,'show']);
Route::post('user/update/{id}', [userController::class,'update']);
Route::delete('user/{id}',[userController::class,'destroy']);
Route::get('userSearch',[userController::class,'search']);

//API sutudent table
Route::get('student', [sudentController::class,'index']);
//Route::get('product', [ProductController::class, 'index']);
Route::post('student',[sudentController::class,'store']);
Route::get('student/{id}',[sudentController::class,'show']);
Route::post('student/update/{id}', [sudentController::class,'update']);
Route::delete('student/{id}',[sudentController::class,'destroy']);
Route::get('studentSearch',[sudentController::class,'search']);
Route::post('parent',[parentController::class,'store']);
//api teacher
Route::get('teacher', [teacherController::class,'index']);
//Route::get('product', [ProductController::class, 'index']);
Route::post('teacher',[teacherController::class,'store']);
Route::get('teacher/{id}',[teacherController::class,'show']);
Route::post('teacher/update/{id}', [teacherController::class,'update']);
Route::delete('teacher/{id}',[teacherController::class,'destroy']);
Route::get('teacherSearch',[teacherController::class,'search']);


