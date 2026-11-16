<?php

namespace App\Controllers\Teacher;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Attendance;
use App\Services\AuditService;

class AttendanceController
{
    public function index(Request $request, Response $response): void
    {
        $userId = (int)Session::get('user_id');
        $teacher = Teacher::findByUserId($userId);
        
        $assignments = $teacher ? Teacher::getAssignments($teacher['id']) : [];
        $selectedAssignment = (int)$request->input('assignment_id', ($assignments[0]['assignment_id'] ?? 0));
        $date = $request->input('date', date('Y-m-d'));

        $students = [];
        $existingRecords = [];

        if ($selectedAssignment > 0) {
            // Find class associated with this assignment
            $currentAssn = null;
            foreach ($assignments as $a) {
                if ($a['assignment_id'] === $selectedAssignment) {
                    $currentAssn = $a;
                    break;
                }
            }

            if ($currentAssn) {
                $students = Student::findByClass($currentAssn['class_id']);
                $attendances = Attendance::getByAssignmentAndDate($selectedAssignment, $date);
                foreach ($attendances as $row) {
                    $existingRecords[$row['student_id']] = $row['status'];
                }
            }
        }

        View::render('teacher.attendance', [
            'title' => 'Mark Daily Attendance',
            'assignments' => $assignments,
            'selectedAssignment' => $selectedAssignment,
            'selectedDate' => $date,
            'students' => $students,
            'existingRecords' => $existingRecords,
            'error' => Session::getFlash('error'),
            'success' => Session::getFlash('success'),
        ], 'teacher');
    }

    public function save(Request $request, Response $response): void
    {
        $assignmentId = (int)$request->input('assignment_id');
        $date = $request->input('date');
        $statuses = $request->input('status', []); // Array of [student_id => status]
        $teacherUserId = (int)Session::get('user_id');

        if (empty($statuses) || !is_array($statuses)) {
            Session::flash('error', 'No attendance records submitted.');
            $response->redirect("/teacher/attendance?assignment_id={$assignmentId}&date={$date}");
            return;
        }

        foreach ($statuses as $studentId => $status) {
            Attendance::mark([
                'student_id' => (int)$studentId,
                'assignment_id' => $assignmentId,
                'date' => $date,
                'status' => in_array($status, ['present', 'absent', 'late', 'excused']) ? $status : 'present',
                'marked_by' => $teacherUserId,
            ]);
        }

        AuditService::log($teacherUserId, 'ATTENDANCE_RECORD', 'attendance', $assignmentId, ['date' => $date]);
        Session::flash('success', 'Attendance records successfully recorded.');
        $response->redirect("/teacher/attendance?assignment_id={$assignmentId}&date={$date}");
    }
}
