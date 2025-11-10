<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;

// Authentication Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::post('/update-password', [AuthController::class, 'updatePassword'])->middleware('auth:sanctum');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Admin Routes
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

    // Students Management
    Route::get('/admin/students', [AdminController::class, 'getStudents']);
    Route::post('/admin/students', [AdminController::class, 'createStudent']);
    Route::put('/admin/students/{id}', [AdminController::class, 'updateStudent']);
    Route::delete('/admin/students/{id}', [AdminController::class, 'deleteStudent']);

    // Teachers Management
    Route::get('/admin/teachers', [AdminController::class, 'getTeachers']);
    Route::post('/admin/teachers', [AdminController::class, 'createTeacher']);
    Route::put('/admin/teachers/{id}', [AdminController::class, 'updateTeacher']);
    Route::delete('/admin/teachers/{id}', [AdminController::class, 'deleteTeacher']);

    // Classrooms Management
    Route::get('/admin/classrooms', [AdminController::class, 'getClassrooms']);
    Route::post('/admin/classrooms', [AdminController::class, 'createClassroom']);
    Route::put('/admin/classrooms/{id}', [AdminController::class, 'updateClassroom']);
    Route::delete('/admin/classrooms/{id}', [AdminController::class, 'deleteClassroom']);

    // Events Management
    Route::get('/admin/events', [AdminController::class, 'getEvents']);
    Route::post('/admin/events', [AdminController::class, 'createEvent']);
    Route::put('/admin/events/{id}', [AdminController::class, 'updateEvent']);
    Route::delete('/admin/events/{id}', [AdminController::class, 'deleteEvent']);

    // Blogs Management
    Route::get('/admin/blogs', [AdminController::class, 'getBlogs']);
    Route::post('/admin/blogs', [AdminController::class, 'createBlog']);
    Route::put('/admin/blogs/{id}', [AdminController::class, 'updateBlog']);
    Route::delete('/admin/blogs/{id}', [AdminController::class, 'deleteBlog']);

    // Resources Management
    Route::get('/admin/resources', [AdminController::class, 'getResources']);
    Route::post('/admin/resources', [AdminController::class, 'createResource']);
    Route::put('/admin/resources/{id}', [AdminController::class, 'updateResource']);
    Route::delete('/admin/resources/{id}', [AdminController::class, 'deleteResource']);

    // Announcements Management
    Route::get('/admin/announcements', [AdminController::class, 'getAnnouncements']);
    Route::post('/admin/announcements', [AdminController::class, 'createAnnouncement']);
    Route::put('/admin/announcements/{id}', [AdminController::class, 'updateAnnouncement']);
    Route::delete('/admin/announcements/{id}', [AdminController::class, 'deleteAnnouncement']);

    // Schedules Management
    Route::get('/admin/schedules', [AdminController::class, 'getSchedules']);
    Route::post('/admin/schedules', [AdminController::class, 'createSchedule']);
    Route::get('/admin/schedules/classroom/{classroom_id}', [AdminController::class, 'getSchedulesByClassroom']);

    // Gallery Management
    Route::get('/admin/gallery', [AdminController::class, 'getGallery']);
    Route::post('/admin/gallery', [AdminController::class, 'createGallery']);
    Route::put('/admin/gallery/{id}', [AdminController::class, 'updateGallery']);
    Route::delete('/admin/gallery/{id}', [AdminController::class, 'deleteGallery']);

    // Contacts & Admissions
    Route::get('/admin/contacts', [AdminController::class, 'getContacts']);
    Route::get('/admin/admissions', [AdminController::class, 'getAdmissions']);
});

// Teacher Routes
Route::middleware(['auth:sanctum', 'role:teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard']);

    // Students in classroom
    Route::get('/teacher/students', [TeacherController::class, 'getStudents']);

    // Assignments Management
    Route::get('/teacher/assignments', [TeacherController::class, 'getAssignments']);
    Route::post('/teacher/assignments', [TeacherController::class, 'createAssignment']);
    Route::put('/teacher/assignments/{id}', [TeacherController::class, 'updateAssignment']);
    Route::delete('/teacher/assignments/{id}', [TeacherController::class, 'deleteAssignment']);

    // Grades Management
    Route::get('/teacher/grades', [TeacherController::class, 'getGrades']);
    Route::post('/teacher/grades', [TeacherController::class, 'createGrade']);
    Route::put('/teacher/grades/{id}', [TeacherController::class, 'updateGrade']);
    Route::delete('/teacher/grades/{id}', [TeacherController::class, 'deleteGrade']);

    // Attendance Management
    Route::get('/teacher/attendance', [TeacherController::class, 'getAttendance']);
    Route::post('/teacher/attendance', [TeacherController::class, 'markAttendance']);

    // Resources Management
    Route::get('/teacher/resources', [TeacherController::class, 'getResources']);
    Route::post('/teacher/resources', [TeacherController::class, 'createResource']);
    Route::put('/teacher/resources/{id}', [TeacherController::class, 'updateResource']);
    Route::delete('/teacher/resources/{id}', [TeacherController::class, 'deleteResource']);
});

// Student Routes
Route::middleware(['auth:sanctum', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard']);
    Route::get('/student/profile', [StudentController::class, 'getProfile']);
    Route::get('/student/attendance', [StudentController::class, 'getAttendance']);
    Route::get('/student/grades', [StudentController::class, 'getGrades']);
    Route::get('/student/assignments', [StudentController::class, 'getAssignments']);
    Route::get('/student/resources', [StudentController::class, 'getResources']);
});

// Public Routes
Route::post('/contact', [AdminController::class, 'createContact']);
Route::post('/admission', [AdminController::class, 'createAdmission']);
Route::get('/events', [AdminController::class, 'getEvents']);
Route::get('/blogs', [AdminController::class, 'getBlogs']);
Route::get('/gallery', [AdminController::class, 'getGallery']);
Route::get('/resources', [AdminController::class, 'getResources']);
Route::get('/announcements', [AdminController::class, 'getAnnouncements']);
