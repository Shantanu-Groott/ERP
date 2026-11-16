<?php

namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Core\Validator;
use App\Models\Fee;
use App\Models\Student;
use App\Services\AuditService;

class FeeController
{
    public function index(Request $request, Response $response): void
    {
        $fees = Fee::all();
        $students = Student::all();

        View::render('admin.fees', [
            'title' => 'Fee Management',
            'fees' => $fees,
            'students' => $students,
            'error' => Session::getFlash('error'),
            'success' => Session::getFlash('success'),
        ], 'admin');
    }

    public function create(Request $request, Response $response): void
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|numeric',
            'title' => 'required',
            'amount' => 'required|numeric',
            'due_date' => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash('error', 'All invoice fields are required.');
            $response->redirect('/admin/fees');
            return;
        }

        $feeId = Fee::create([
            'student_id' => (int)$request->input('student_id'),
            'title' => $request->input('title'),
            'amount' => (float)$request->input('amount'),
            'due_date' => $request->input('due_date'),
            'status' => 'unpaid',
        ]);

        AuditService::log(Session::get('user_id'), 'FEE_CREATE', 'fees', $feeId, [
            'amount' => $request->input('amount'),
            'student_id' => $request->input('student_id')
        ]);

        Session::flash('success', 'Fee invoice generated successfully.');
        $response->redirect('/admin/fees');
    }

    public function markPaid(Request $request, Response $response, string $id): void
    {
        $feeId = (int)$id;
        $txnRef = 'TXN-' . strtoupper(substr(md5(uniqid()), 0, 8));
        
        Fee::recordPayment($feeId, (float)($request->input('amount') ?: 1000.00), 'Counter/Online', $txnRef);
        AuditService::log(Session::get('user_id'), 'FEE_PAID', 'fees', $feeId, ['txn_ref' => $txnRef]);
        
        Session::flash('success', 'Payment recorded successfully.');
        $response->redirect('/admin/fees');
    }
}
