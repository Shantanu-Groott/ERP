<?php

use App\Controllers\AuthController;
use App\Controllers\Admin\DashboardController as AdminDashboard;
use App\Controllers\Admin\UserController as AdminUser;
use App\Controllers\Admin\ClassController as AdminClass;
use App\Controllers\Admin\FeeController as AdminFee;

use App\Controllers\Teacher\DashboardController as TeacherDashboard;
use App\Controllers\Teacher\AttendanceController as TeacherAttendance;
use App\Controllers\Teacher\MarksController as TeacherMarks;

use App\Controllers\Student\DashboardController as StudentDashboard;
use App\Controllers\Student\AttendanceController as StudentAttendance;
use App\Controllers\Student\ResultController as StudentResult;

use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;
use App\Middleware\CsrfMiddleware;

// Public / Guest Routes
$router->get('/', function($req, $res) {
    $res->redirect('/login');
});

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->post('/logout', [AuthController::class, 'logout']);
$router->get('/forgot-password', [AuthController::class, 'forgotPassword']);
$router->post('/forgot-password', [AuthController::class, 'forgotPassword']);
$router->get('/reset-password', [AuthController::class, 'showReset']);
$router->post('/reset-password', [AuthController::class, 'reset']);

// ----------------------------------------------------
// Admin Routes (Role: admin)
// ----------------------------------------------------
$router->get('/admin/dashboard', [AdminDashboard::class, 'index'], [
    AuthMiddleware::class,
    new RoleMiddleware(['admin'])
]);

$router->get('/admin/users', [AdminUser::class, 'index'], [
    AuthMiddleware::class,
    new RoleMiddleware(['admin'])
]);
$router->post('/admin/users', [AdminUser::class, 'create'], [
    AuthMiddleware::class,
    new RoleMiddleware(['admin']),
    CsrfMiddleware::class
]);
$router->get('/admin/users/delete/{id}', [AdminUser::class, 'delete'], [
    AuthMiddleware::class,
    new RoleMiddleware(['admin'])
]);

$router->get('/admin/classes', [AdminClass::class, 'index'], [
    AuthMiddleware::class,
    new RoleMiddleware(['admin'])
]);
$router->post('/admin/classes', [AdminClass::class, 'create'], [
    AuthMiddleware::class,
    new RoleMiddleware(['admin']),
    CsrfMiddleware::class
]);

$router->get('/admin/fees', [AdminFee::class, 'index'], [
    AuthMiddleware::class,
    new RoleMiddleware(['admin'])
]);
$router->post('/admin/fees', [AdminFee::class, 'create'], [
    AuthMiddleware::class,
    new RoleMiddleware(['admin']),
    CsrfMiddleware::class
]);
$router->get('/admin/fees/pay/{id}', [AdminFee::class, 'markPaid'], [
    AuthMiddleware::class,
    new RoleMiddleware(['admin'])
]);

// ----------------------------------------------------
// Teacher Routes (Role: teacher)
// ----------------------------------------------------
$router->get('/teacher/dashboard', [TeacherDashboard::class, 'index'], [
    AuthMiddleware::class,
    new RoleMiddleware(['teacher'])
]);

$router->get('/teacher/attendance', [TeacherAttendance::class, 'index'], [
    AuthMiddleware::class,
    new RoleMiddleware(['teacher'])
]);
$router->post('/teacher/attendance', [TeacherAttendance::class, 'save'], [
    AuthMiddleware::class,
    new RoleMiddleware(['teacher']),
    CsrfMiddleware::class
]);

$router->get('/teacher/marks', [TeacherMarks::class, 'index'], [
    AuthMiddleware::class,
    new RoleMiddleware(['teacher'])
]);
$router->post('/teacher/marks', [TeacherMarks::class, 'save'], [
    AuthMiddleware::class,
    new RoleMiddleware(['teacher']),
    CsrfMiddleware::class
]);

// ----------------------------------------------------
// Student Routes (Role: student)
// ----------------------------------------------------
$router->get('/student/dashboard', [StudentDashboard::class, 'index'], [
    AuthMiddleware::class,
    new RoleMiddleware(['student'])
]);

$router->get('/student/attendance', [StudentAttendance::class, 'index'], [
    AuthMiddleware::class,
    new RoleMiddleware(['student'])
]);

$router->get('/student/results', [StudentResult::class, 'index'], [
    AuthMiddleware::class,
    new RoleMiddleware(['student'])
]);

$router->get('/student/curriculum', [\App\Controllers\Student\CourseController::class, 'index'], [
    AuthMiddleware::class,
    new RoleMiddleware(['student'])
]);

$router->get('/student/courses', [\App\Controllers\Student\CourseController::class, 'index'], [
    AuthMiddleware::class,
    new RoleMiddleware(['student'])
]);

$router->get('/student/notices', [\App\Controllers\Student\NoticeController::class, 'index'], [
    AuthMiddleware::class,
    new RoleMiddleware(['student'])
]);

$router->get('/student/certificate', [\App\Controllers\Student\CertificateController::class, 'index'], [
    AuthMiddleware::class,
    new RoleMiddleware(['student'])
]);

$router->get('/student/openings', [\App\Controllers\Student\CareerController::class, 'openings'], [
    AuthMiddleware::class,
    new RoleMiddleware(['student'])
]);

$router->get('/student/projects', [\App\Controllers\Student\CareerController::class, 'projects'], [
    AuthMiddleware::class,
    new RoleMiddleware(['student'])
]);

$router->get('/student/live-class', [\App\Controllers\Student\LiveClassController::class, 'index'], [
    AuthMiddleware::class,
    new RoleMiddleware(['student'])
]);
