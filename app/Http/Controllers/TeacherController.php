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

        // Check for overdue assignments
        foreach ($assignments as $assignment) {
            if ($assignment->status === 'pending' && $assignment->due_date < now()) {
                $assignment->status = 'overdue';
                $assignment->save();
            }
        }

        return response()->json($assignments);
    }

    public function createAssignment(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'name' => 'required|string',
            'due_date' => 'required|date',
            'score' => 'nullable|numeric|min:0|max:100',
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
            'score' => $request->score,
            'status' => $request->score ? 'submitted' : 'pending',
        ]);

        return response()->json($assignment);
    }

    public function updateAssignment(Request $request, $id)
    {
        $assignment = Assignment::where('teacher_id', Auth::user()->teacher->id)->findOrFail($id);

        $originalScore = $assignment->score;
        $assignment->update($request->all());

        // If score was null and now provided, set status to submitted
        if (is_null($originalScore) && !is_null($assignment->score)) {
            $assignment->status = 'submitted';
            $assignment->save();
        }

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
            'subjects' => 'required|array',
            'subjects.*.subject' => 'required|string',
            'subjects.*.class_score' => 'required|numeric|min:0|max:50',
            'subjects.*.exam_score' => 'required|numeric|min:0|max:50',
            'subjects.*.grade_meaning' => 'required|string',
            'subjects.*.subj_pos_class' => 'required|string',
            'subjects.*.subj_pos_form' => 'required|string',
            'subjects.*.teacher_mod_p' => 'required|string',
            'position_in_class' => 'required|string',
            'next_term_reopens' => 'required|date',
            'interest' => 'required|string',
            'conduct' => 'required|string',
            'attitude' => 'required|string',
            'class_teacher_remark' => 'required|string',
            'academic_remark' => 'required|string',
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

        // Update student with per-student fields
        $student->update([
            'position_in_class' => $request->position_in_class,
            'next_term_reopens' => $request->next_term_reopens,
            'interest' => $request->interest,
            'conduct' => $request->conduct,
            'attitude' => $request->attitude,
            'class_teacher_remark' => $request->class_teacher_remark,
            'academic_remark' => $request->academic_remark,
        ]);

        // Create grade records for each subject
        $grades = [];
        foreach ($request->subjects as $subjectData) {
            $totalScore = $subjectData['class_score'] + $subjectData['exam_score'];
            $grade = Grade::create([
                'student_id' => $request->student_id,
                'teacher_id' => $teacher->id,
                'subject' => $subjectData['subject'],
                'class_score' => $subjectData['class_score'],
                'exam_score' => $subjectData['exam_score'],
                'total_score' => $totalScore,
                'grade_meaning' => $subjectData['grade_meaning'],
                'subj_pos_class' => $subjectData['subj_pos_class'],
                'subj_pos_form' => $subjectData['subj_pos_form'],
                'teacher_mod_p' => $subjectData['teacher_mod_p'],
            ]);
            $grades[] = $grade;
        }

        // Generate formatted report
        $report = "POSITION IN CLASS: {$student->position_in_class}\n\n";
        $report .= "NEXT TERM RE-OPENS: " . \Carbon\Carbon::parse($student->next_term_reopens)->format('jS F, Y') . "\n\n";

        // Define column widths
        $colWidths = [
            'subject' => 20,
            'class_score' => 17,
            'exam_score' => 17,
            'total_score' => 19,
            'grade_meaning' => 13,
            'subj_pos_class' => 17,
            'subj_pos_form' => 15,
            'teacher_mod_p' => 14,
        ];

        // Header
        $report .= str_pad('SUBJECTS', $colWidths['subject']) .
                   str_pad('CLASS SCORE (50%)', $colWidths['class_score']) .
                   str_pad('EXAM SCORE (50%)', $colWidths['exam_score']) .
                   str_pad('TOTAL SCORE (100%)', $colWidths['total_score']) .
                   str_pad('GRADE MEANING', $colWidths['grade_meaning']) .
                   str_pad('SUBJ. POS. CLASS', $colWidths['subj_pos_class']) .
                   str_pad('SUBJ. POS. FORM', $colWidths['subj_pos_form']) .
                   "TEACHER MOD.P.\n";

        // Separator line
        $report .= str_repeat('-', array_sum($colWidths)) . "\n";

        // Grade rows
        foreach ($grades as $grade) {
            $report .= str_pad($grade->subject, $colWidths['subject']) .
                       str_pad($grade->class_score, $colWidths['class_score']) .
                       str_pad($grade->exam_score, $colWidths['exam_score']) .
                       str_pad($grade->total_score, $colWidths['total_score']) .
                       str_pad($grade->grade_meaning, $colWidths['grade_meaning']) .
                       str_pad($grade->subj_pos_class, $colWidths['subj_pos_class']) .
                       str_pad($grade->subj_pos_form, $colWidths['subj_pos_form']) .
                       $grade->teacher_mod_p . "\n";
        }

        $report .= "\nINTEREST: {$student->interest}\n";
        $report .= "CONDUCT: {$student->conduct}\n";
        $report .= "ATTITUDE: {$student->attitude}\n";
        $report .= "\nCLASS TEACHER'S REMARK: {$student->class_teacher_remark}\n\n";
        $report .= "ACADEMIC REMARK: {$student->academic_remark}\n";

        return response()->json(['report' => $report, 'grades' => $grades]);
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
            'remark' => 'nullable|string',
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
                'remark' => $request->remark,
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
