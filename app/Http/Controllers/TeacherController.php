<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Assignment;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\Resource;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $teacher = Auth::user()->teacher;
        $stats = [
            'total_students' => Student::where('classroom_id', $teacher->classroom_id)->count(),
            'total_assignments' => Assignment::where('teacher_id', $teacher->id)->count(),
            'total_resources' => Resource::where('teacher_id', $teacher->id)->count(),
        ];

        return response()->json($stats);
    }

    // Students in teacher's classroom
    public function getStudents()
    {
        $teacher = Auth::user()->teacher;
        $students = Student::where('classroom_id', $teacher->classroom_id)->with('user')->get();
        return response()->json($students);
    }

    // Assignments Management
    public function getAssignments()
    {
        $teacher = Auth::user()->teacher;
        $assignments = Assignment::where('teacher_id', $teacher->id)->with('classroom')->get();
        return response()->json($assignments);
    }

    public function createAssignment(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'name' => 'required|string',
            'due_date' => 'required|date',
        ]);

        $teacher = Teacher::where('teacher_id', Auth::user()->user_id)->first();

        if (!$teacher) {
            return response()->json(['error' => 'Teacher record not found'], 400);
        }

        if (!$teacher->classroom_id) {
            return response()->json(['error' => 'Teacher not assigned to a classroom'], 400);
        }

        $assignment = Assignment::create([
            'subject' => $request->subject,
            'name' => $request->name,
            'due_date' => $request->due_date,
            'classroom_id' => $teacher->classroom_id,
            'teacher_id' => $teacher->id,
        ]);

        return response()->json($assignment);
    }

    public function updateAssignment(Request $request, $id)
    {
        $assignment = Assignment::where('teacher_id', Auth::user()->teacher->id)->findOrFail($id);
        $assignment->update($request->all());
        return response()->json($assignment);
    }

    public function deleteAssignment($id)
    {
        $assignment = Assignment::where('teacher_id', Auth::user()->teacher->id)->findOrFail($id);
        $assignment->delete();
        return response()->json(['message' => 'Assignment deleted successfully']);
    }

    // Grades Management
    public function getGrades()
    {
        $teacher = Auth::user()->teacher;
        $grades = Grade::where('teacher_id', $teacher->id)->with('student.user')->get();
        return response()->json($grades);
    }

    public function createGrade(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject' => 'required|string',
            'first_test' => 'required|numeric|min:0|max:100',
            'second_test' => 'required|numeric|min:0|max:100',
            'ca' => 'required|numeric|min:0|max:100',
            'grade' => 'required|string',
            'position' => 'required|string',
            'remark' => 'required|string',
        ]);

        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return response()->json(['error' => 'Teacher record not found'], 400);
        }

        if (!$teacher->classroom_id) {
            return response()->json(['error' => 'Teacher not assigned to a classroom'], 400);
        }

        // Check if student is in teacher's classroom
        $student = Student::findOrFail($request->student_id);
        if ($student->classroom_id !== $teacher->classroom_id) {
            return response()->json(['error' => 'Student not in your classroom'], 403);
        }

        $grade = Grade::create([
            'student_id' => $request->student_id,
            'teacher_id' => $teacher->id,
            'subject' => $request->subject,
            'first_test' => $request->first_test,
            'second_test' => $request->second_test,
            'ca' => $request->ca,
            'grade' => $request->grade,
            'position' => $request->position,
            'remark' => $request->remark,
        ]);

        return response()->json($grade);
    }

    public function updateGrade(Request $request, $id)
    {
        $grade = Grade::where('teacher_id', Auth::user()->teacher->id)->findOrFail($id);
        $grade->update($request->all());
        return response()->json($grade);
    }

    public function deleteGrade($id)
    {
        $grade = Grade::where('teacher_id', Auth::user()->teacher->id)->findOrFail($id);
        $grade->delete();
        return response()->json(['message' => 'Grade deleted successfully']);
    }

    // Attendance Management
    public function getAttendance()
    {
        $teacher = Auth::user()->teacher;
        $attendance = Attendance::where('teacher_id', $teacher->id)->with('student.user')->get();
        return response()->json($attendance);
    }

    public function markAttendance(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late',
        ]);

        $teacher = Auth::user()->teacher;

        // Check if student is in teacher's classroom
        $student = Student::findOrFail($request->student_id);
        if ($student->classroom_id !== $teacher->classroom_id) {
            return response()->json(['error' => 'Student not in your classroom'], 403);
        }

        $attendance = Attendance::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'date' => $request->date,
            ],
            [
                'status' => $request->status,
                'teacher_id' => $teacher->id,
            ]
        );

        return response()->json($attendance);
    }

    // Resources Management
    public function getResources()
    {
        $teacher = Auth::user()->teacher;
        $resources = Resource::where('teacher_id', $teacher->id)->with('classroom')->get();
        return response()->json($resources);
    }

    public function createResource(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:pdf,doc,docx,ppt,pptx',
            'file_path' => 'required|string',
        ]);

        $teacher = Auth::user()->teacher;

        $resource = Resource::create([
            'name' => $request->name,
            'type' => $request->type,
            'file_path' => $request->file_path,
            'classroom_id' => $teacher->classroom_id,
            'teacher_id' => $teacher->id,
        ]);

        return response()->json($resource);
    }

    public function updateResource(Request $request, $id)
    {
        $resource = Resource::where('teacher_id', Auth::user()->teacher->id)->findOrFail($id);
        $resource->update($request->all());
        return response()->json($resource);
    }

    public function deleteResource($id)
    {
        $resource = Resource::where('teacher_id', Auth::user()->teacher->id)->findOrFail($id);
        $resource->delete();
        return response()->json(['message' => 'Resource deleted successfully']);
    }
}
