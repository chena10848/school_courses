<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Instructor\InstructorController;

//課程列表
Route::get('/courseList', [CourseController::class, 'courseList']);

//建立新課程
Route::post('/course', [CourseController::class, 'createCourse']);

//更新課程
Route::put('/course', [CourseController::class, 'updateCourse']);

//刪除課程
Route::delete('/course/{courseId}', [CourseController::class, 'deleteCourse']);

//授課講師列表
Route::get('/instructorList', [InstructorController::class, 'instructorList']);

//授課講師所開課程列表
Route::get('instructor/{instructorId}/courses', [InstructorController::class, 'instructorCourseList']);

//建立新講師
Route::post('instructor', [InstructorController::class, 'createInstructor']);


