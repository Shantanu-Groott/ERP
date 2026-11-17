<?php

use App\Controllers\AuthController;
use App\Controllers\Student\DashboardController as StudentDashboard;
use App\Controllers\Student\AttendanceController as StudentAttendance;
use App\Controllers\Student\ResultController as StudentResult;
use App\Controllers\Student\CourseController as StudentCourse;
use App\Controllers\Student\NoticeController as StudentNotice;
use App\Controllers\Student\CertificateController as StudentCertificate;
use App\Controllers\Student\CareerController as StudentCareer;
use App\Controllers\Student\LiveClassController as StudentLiveClass;

use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;

// ----------------------------------------------------
// Public / Authentication Routes
// ----------------------------------------------------
$router->get('/', function($req, $res) {
    if (\App\Core\Session::has('user_id')) {
        $res->redirect('/student/dashboard');
    } else {
        $res->redirect('/login');
    }
});

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);
$router->get('/forgot-password', [AuthController::class, 'forgotPassword']);
$router->post('/forgot-password', [AuthController::class, 'forgotPassword']);
$router->get('/reset-password', [AuthController::class, 'showReset']);
$router->post('/reset-password', [AuthController::class, 'reset']);

// ----------------------------------------------------
// Student ERP Routes (Authentication required)
// ----------------------------------------------------
$router->get('/student/dashboard', [StudentDashboard::class, 'index'], [
    AuthMiddleware::class
]);

$router->get('/student/attendance', [StudentAttendance::class, 'index'], [
    AuthMiddleware::class
]);

$router->get('/student/results', [StudentResult::class, 'index'], [
    AuthMiddleware::class
]);

$router->get('/student/curriculum', [StudentCourse::class, 'index'], [
    AuthMiddleware::class
]);

$router->get('/student/courses', [StudentCourse::class, 'index'], [
    AuthMiddleware::class
]);

$router->get('/student/notices', [StudentNotice::class, 'index'], [
    AuthMiddleware::class
]);

$router->get('/student/certificate', [StudentCertificate::class, 'index'], [
    AuthMiddleware::class
]);

$router->get('/student/openings', [StudentCareer::class, 'openings'], [
    AuthMiddleware::class
]);

$router->get('/student/projects', [StudentCareer::class, 'projects'], [
    AuthMiddleware::class
]);

$router->get('/student/live-class', [StudentLiveClass::class, 'index'], [
    AuthMiddleware::class
]);
