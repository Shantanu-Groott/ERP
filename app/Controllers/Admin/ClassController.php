<?php

namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Core\Validator;
use App\Models\ClassRoom;
use App\Services\AuditService;
use App\Core\Database;

class ClassController
{
    public function index(Request $request, Response $response): void
    {
        $classes = ClassRoom::all();
        $db = Database::getConnection();
        $departments = $db->query("SELECT * FROM departments ORDER BY name ASC")->fetchAll();
        $academicYears = $db->query("SELECT * FROM academic_years ORDER BY id DESC")->fetchAll();

        View::render('admin.classes', [
            'title' => 'Class Management',
            'classes' => $classes,
            'departments' => $departments,
            'academicYears' => $academicYears,
            'error' => Session::getFlash('error'),
            'success' => Session::getFlash('success'),
        ], 'admin');
    }

    public function create(Request $request, Response $response): void
    {
        $validator = Validator::make($request->all(), [
            'department_id' => 'required|numeric',
            'academic_year_id' => 'required|numeric',
            'name' => 'required',
            'division' => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash('error', 'Please fill all required class fields.');
            $response->redirect('/admin/classes');
            return;
        }

        $classId = ClassRoom::create([
            'department_id' => (int)$request->input('department_id'),
            'academic_year_id' => (int)$request->input('academic_year_id'),
            'name' => $request->input('name'),
            'division' => $request->input('division'),
        ]);

        AuditService::log(Session::get('user_id'), 'CLASS_CREATE', 'classes', $classId, [
            'name' => $request->input('name'),
            'division' => $request->input('division')
        ]);

        Session::flash('success', 'Classroom registered successfully.');
        $response->redirect('/admin/classes');
    }
}
