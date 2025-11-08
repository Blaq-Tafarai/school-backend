<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\Assignment;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $student = Auth::user()->student;
        $stats = [
            'total_assignments' => Assignment::where('classroom_id', $student->classroom_id)->count(),
            'total_resources' => Resource::where('classroom_id', $student->classroom_id)->count(),
            'attendance_percentage' => $this->calculateAttendancePercentage($student->id),
        ];

        return response()->json($stats);
    }

    private function calculateAttendancePercentage($studentId)
    {
        $totalDays = Attendance::where('student_id', $studentId)->count();
        if ($totalDays == 0) return 0;

        $presentDays = Attendance::where('student_id', $studentId)->where('status', 'present')->count();
        return round(($presentDays / $totalDays) * 100, 2);
    }

    // Profile
    public function getProfile()
    {
        $student = Auth::user()->student->load('user', 'classroom');
        return response()->json($student);
    }

    // Attendance
    public function getAttendance()
    {
        $student = Auth::user()->student;
        $attendance = Attendance::where('student_id', $student->id)->orderBy('date', 'desc')->get();
        return response()->json($attendance);
    }

    // Grades
    public function getGrades()
    {
        $student = Auth::user()->student;
        $grades = Grade::where('student_id', $student->id)->get();
        return response()->json($grades);
    }

    // Assignments
    public function getAssignments()
    {
        $student = Auth::user()->student;
        $assignments = Assignment::where('classroom_id', $student->classroom_id)->with('teacher.user')->get();
        return response()->json($assignments);
    }

    // Resources
    public function getResources()
    {
        $student = Auth::user()->student;
        $resources = Resource::where('classroom_id', $student->classroom_id)->with('teacher.user')->get();
        return response()->json($resources);
    }
}
