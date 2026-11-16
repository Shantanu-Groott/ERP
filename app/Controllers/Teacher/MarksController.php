<?php

namespace App\Controllers\Teacher;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Core\Validator;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Mark;
use App\Services\AuditService;

class MarksController
{
    public function index(Request $request, Response $response): void
    {
        $subjects = Subject::all();
        $students = Student::all();
        $exams = Mark::getExams();

        $selectedSubject = (int)$request->input('subject_id', ($subjects[0]['id'] ?? 0));
        $selectedExam = (int)$request->input('exam_id', ($exams[0]['id'] ?? 0));
        
        $marksList = [];
        if ($selectedSubject > 0 && $selectedExam > 0) {
            $marksList = Mark::getByExamAndSubject($selectedExam, $selectedSubject);
        }

        View::render('teacher.marks', [
            'title' => 'Gradebook & Marks Entry',
            'subjects' => $subjects,
            'students' => $students,
            'exams' => $exams,
            'selectedSubject' => $selectedSubject,
            'selectedExam' => $selectedExam,
            'marksList' => $marksList,
            'error' => Session::getFlash('error'),
            'success' => Session::getFlash('success'),
        ], 'teacher');
    }

    public function save(Request $request, Response $response): void
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|numeric',
            'subject_id' => 'required|numeric',
            'exam_id' => 'required|numeric',
            'marks_obtained' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            Session::flash('error', 'Please fill in all required gradebook fields.');
            $response->redirect('/teacher/marks');
            return;
        }

        $teacherUserId = (int)Session::get('user_id');

        Mark::save([
            'exam_id' => (int)$request->input('exam_id'),
            'student_id' => (int)$request->input('student_id'),
            'subject_id' => (int)$request->input('subject_id'),
            'marks_obtained' => (float)$request->input('marks_obtained'),
            'max_marks' => (float)($request->input('max_marks') ?: 100),
        ]);

        AuditService::log($teacherUserId, 'MARK_RECORD', 'marks', (int)$request->input('student_id'), [
            'subject_id' => $request->input('subject_id'),
            'marks' => $request->input('marks_obtained')
        ]);

        Session::flash('success', 'Student marks submitted successfully.');
        $response->redirect('/teacher/marks?subject_id=' . $request->input('subject_id') . '&exam_id=' . $request->input('exam_id'));
    }
}
