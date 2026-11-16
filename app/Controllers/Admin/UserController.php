<?php

namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Core\Validator;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassRoom;
use App\Services\AuditService;
use App\Core\Database;

class UserController
{
    public function index(Request $request, Response $response): void
    {
        $users = User::all();
        $classes = ClassRoom::all();
        
        $db = Database::getConnection();
        $departments = $db->query("SELECT * FROM departments ORDER BY name ASC")->fetchAll();

        View::render('admin.users', [
            'title' => 'User Management',
            'users' => $users,
            'classes' => $classes,
            'departments' => $departments,
            'error' => Session::getFlash('error'),
            'success' => Session::getFlash('success'),
        ], 'admin');
    }

    public function create(Request $request, Response $response): void
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|min:2',
            'username' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,teacher,student',
        ]);

        if ($validator->fails()) {
            Session::flash('error', $validator->first('full_name') ?: $validator->first('email') ?: $validator->first('username') ?: $validator->first('password'));
            $response->redirect('/admin/users');
            return;
        }

        if (User::findByEmailOrUsername($request->input('email')) || User::findByEmailOrUsername($request->input('username'))) {
            Session::flash('error', 'A user with this email or username already exists.');
            $response->redirect('/admin/users');
            return;
        }

        $userId = User::create([
            'full_name' => $request->input('full_name'),
            'username' => strtolower(trim($request->input('username'))),
            'email' => strtolower(trim($request->input('email'))),
            'password' => $request->input('password'),
            'role' => $request->input('role'),
            'phone' => $request->input('phone'),
            'status' => 'active',
        ]);

        $role = $request->input('role');
        if ($role === 'student') {
            $classId = (int)$request->input('class_id') ?: 1;
            Student::create([
                'user_id' => $userId,
                'roll_no' => 'ROLL-' . date('y') . '-' . str_pad((string)$userId, 4, '0', STR_PAD_LEFT),
                'class_id' => $classId,
            ]);
        } elseif ($role === 'teacher') {
            $deptId = (int)$request->input('department_id') ?: 1;
            Teacher::create([
                'user_id' => $userId,
                'employee_code' => 'EMP-' . str_pad((string)$userId, 4, '0', STR_PAD_LEFT),
                'department_id' => $deptId,
                'designation' => $request->input('designation') ?: 'Faculty',
            ]);
        }

        AuditService::log(Session::get('user_id'), 'USER_CREATE', 'users', $userId, ['role' => $role]);
        Session::flash('success', "User account for {$request->input('full_name')} created successfully.");
        $response->redirect('/admin/users');
    }

    public function delete(Request $request, Response $response, string $id): void
    {
        $userId = (int)$id;
        if ($userId === (int)Session::get('user_id')) {
            Session::flash('error', 'You cannot delete your own admin account.');
            $response->redirect('/admin/users');
            return;
        }

        User::delete($userId);
        AuditService::log(Session::get('user_id'), 'USER_DELETE', 'users', $userId);
        Session::flash('success', 'User removed successfully.');
        $response->redirect('/admin/users');
    }
}
