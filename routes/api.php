<?php

use App\Http\Controllers\API\attendaceController;
use App\Http\Controllers\API\courseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\userController;
use App\Http\Controllers\Api\sudentController;
use App\Http\Controllers\Api\parentController;
use App\Http\Controllers\Api\teacherController;
use App\Http\Controllers\Api\FaceDemo;

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
Route::post('userSearch',[userController::class,'search']);
Route::post('userSearchHead',[userController::class,'searchhead']);

//API sutudent table
Route::get('student', [sudentController::class,'index']);
//Route::get('product', [ProductController::class, 'index']);
Route::post('student',[sudentController::class,'store']);
Route::get('student/{id}',[sudentController::class,'show']);
Route::post('student/update/{id}', [sudentController::class,'update']);
Route::delete('student/{id}',[sudentController::class,'destroy']);
Route::post('studentSearch',[sudentController::class,'search']);
Route::post('parent',[parentController::class,'store']);
//api teacher
Route::get('teacher', [teacherController::class,'index']);
//Route::get('product', [ProductController::class, 'index']);
Route::post('teacher',[teacherController::class,'store']);
Route::get('teacher/{id}',[teacherController::class,'show']);
Route::post('teacher/update/{id}', [teacherController::class,'update']);
Route::post('teacher/updatePass/{id}', [teacherController::class,'updatepass']);
Route::delete('teacher/{id}',[teacherController::class,'destroy']);
Route::post('teacherSearch',[teacherController::class,'search']);

//API course
Route::get('course', [courseController::class,'index']);
//Route::get('product', [ProductController::class, 'index']);
Route::post('course',[courseController::class,'store']);
Route::get('course/{id}',[courseController::class,'show']);
Route::get('course-semester/{semesterId}',[courseController::class,'course']);
Route::post('course/update/{id}', [courseController::class,'update']);
Route::delete('course/{id}',[courseController::class,'destroy']);
Route::post('courseSearch',[courseController::class,'search']);
Route::get('course-student/{id}', [courseController::class,'studentofcourse']);//xem tat ca thanh vien trong lop
Route::post('course-teacher', [courseController::class,'courseofteacher']);//xem lop hoc cua giang vien
Route::get('course-of-student/{id}/{SemesterId}', [courseController::class,'courseOfStudent']);//xem cac lop cua hoc sinh
Route::post('/course/{course_id}/students', [courseController::class, 'addStudentsToCourse']);
//api lấy thôgn tin
Route::get('listFaculty', [courseController::class,'listFaculty']);
Route::get('listClassRoom', [courseController::class,'listClassRoom']);
Route::get('listSemester', [courseController::class,'listSemester']);
Route::get('listSemester', [courseController::class,'listSemester']);
Route::get('listSubject', [courseController::class,'listSubject']);



//atendance
Route::get('/course/{id}/attendance', [attendaceController::class, 'getClassAttendance']);
Route::post('/attendance/mark', [attendaceController::class, 'markAttendance']);
Route::get('/course-check/{teacher_id}/{semester_id}', [attendaceController::class, 'checkCourseAttendance']);//Kiểmtra xem thời diểm hiện tại giáo viên có lớp học phần nào không


Route::post('detectFaces', [FaceDemo::class,'detectFaces']);
