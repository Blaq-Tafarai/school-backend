<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Event;
use App\Models\Blog;
use App\Models\Gallery;
use App\Models\Contact;
use App\Models\Admission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $stats = [
            'total_students' => Student::count(),
            'total_teachers' => Teacher::count(),
            'total_classrooms' => Classroom::count(),
            'total_events' => Event::count(),
            'total_blogs' => Blog::count(),
            'total_gallery_items' => Gallery::count(),
            'total_contacts' => Contact::count(),
            'total_admissions' => Admission::count(),
        ];

        return response()->json($stats);
    }

    // Students Management
    public function getStudents()
    {
        $students = Student::with('user', 'classroom')->get();
        return response()->json($students);
    }

    public function createStudent(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'dob' => 'required|date',
            'parents_email' => 'required|email',
            'parents_phone' => 'required|string',
            'parents_name' => 'required|string',
            'gender' => 'required|in:male,female',
            'classroom_id' => 'required|exists:classrooms,id',
            'address' => 'required|string',
        ]);

        $studentId = 'STU' . strtoupper(Str::random(6));

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $studentId . '@school.com',
            'password' => Hash::make($request->dob),
            'user_type' => 'student',
            'user_id' => $studentId,
        ]);

        $user->assignRole('student');

        $student = Student::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'dob' => $request->dob,
            'parents_email' => $request->parents_email,
            'parents_phone' => $request->parents_phone,
            'parents_name' => $request->parents_name,
            'gender' => $request->gender,
            'classroom_id' => $request->classroom_id,
            'address' => $request->address,
            'student_id' => $studentId,
        ]);

        return response()->json(['student' => $student->load('user', 'classroom'), 'credentials' => ['user_id' => $studentId, 'password' => $request->dob]]);
    }

    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->all());
        return response()->json($student->load('user', 'classroom'));
    }

    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $student->user->delete();
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully']);
    }

    // Teachers Management
    public function getTeachers()
    {
        $teachers = Teacher::with('user', 'classroom')->get();
        return response()->json($teachers);
    }

    public function createTeacher(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'dob' => 'required|date',
            'address' => 'required|string',
            'phone' => 'required|string',
            'qualifications' => 'required|string',
            'skills' => 'required|string',
            'classroom_id' => 'required|exists:classrooms,id',
            'email' => 'required|email|unique:teachers,email',
            'gender' => 'required|in:male,female',
        ]);

        $teacherId = 'TEA' . strtoupper(Str::random(6));

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->dob),
            'user_type' => 'teacher',
            'user_id' => $teacherId,
        ]);

        $user->assignRole('teacher');

        $teacher = Teacher::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'dob' => $request->dob,
            'address' => $request->address,
            'phone' => $request->phone,
            'qualifications' => $request->qualifications,
            'skills' => $request->skills,
            'classroom_id' => $request->classroom_id,
            'email' => $request->email,
            'gender' => $request->gender,
            'teacher_id' => $teacherId,
        ]);

        return response()->json(['teacher' => $teacher->load('user', 'classroom'), 'credentials' => ['user_id' => $teacherId, 'password' => $request->dob]]);
    }

    public function updateTeacher(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->update($request->all());
        return response()->json($teacher->load('user', 'classroom'));
    }

    public function deleteTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->user->delete();
        $teacher->delete();
        return response()->json(['message' => 'Teacher deleted successfully']);
    }

    // Classrooms Management
    public function getClassrooms()
    {
        $classrooms = Classroom::with('students', 'teachers')->get();
        return response()->json($classrooms);
    }

    public function createClassroom(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:classrooms,name',
            'floor' => 'required|string',
        ]);

        $classroom = Classroom::create($request->all());
        return response()->json($classroom);
    }

    public function updateClassroom(Request $request, $id)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->update($request->all());
        return response()->json($classroom);
    }

    public function deleteClassroom($id)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();
        return response()->json(['message' => 'Classroom deleted successfully']);
    }

    // Events Management
    public function getEvents()
    {
        $events = Event::paginate(10);
        return response()->json($events);
    }

    public function createEvent(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'venue' => 'required|string',
            'description' => 'required|string',
        ]);

        try {
            $event = Event::create($request->all());
            return response()->json($event, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create event', 'message' => $e->getMessage()], 500);
        }
    }

    public function updateEvent(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return response()->json($event);
    }

    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully']);
    }

    // Blogs Management
    public function getBlogs()
    {
        $blogs = Blog::all();
        return response()->json($blogs);
    }

    public function createBlog(Request $request)
    {
        $request->validate([
            'author' => 'required|string',
            'topic' => 'required|string',
            'body' => 'required|string',
            'date' => 'required|date',
            'category' => 'required|string',
        ]);

        $blog = Blog::create($request->all());
        return response()->json($blog);
    }

    public function updateBlog(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->update($request->all());
        return response()->json($blog);
    }

    public function deleteBlog($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return response()->json(['message' => 'Blog deleted successfully']);
    }

    // Gallery Management
    public function getGallery()
    {
        $gallery = Gallery::all();
        return response()->json($gallery);
    }

    public function createGallery(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'image_path' => 'required|string',
            'category' => 'nullable|string',
        ]);

        $gallery = Gallery::create($request->all());
        return response()->json($gallery);
    }

    public function updateGallery(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->update($request->all());
        return response()->json($gallery);
    }

    public function deleteGallery($id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();
        return response()->json(['message' => 'Gallery item deleted successfully']);
    }

    // Contacts
    public function getContacts()
    {
        $contacts = Contact::all();
        return response()->json($contacts);
    }

    public function createContact(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($request->all());
        return response()->json($contact, 201);
    }

    // Admissions
    public function getAdmissions()
    {
        $admissions = Admission::all();
        return response()->json($admissions);
    }

    public function createAdmission(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'place_of_birth' => 'required|string',
            'nationality' => 'required|string',
            'religion' => 'required|string',
            'blood_group' => 'required|string',
            'home_address' => 'required|string',
            'current_grade_class' => 'required|string',
            'desired_grade_class' => 'required|string',
            'previous_school' => 'required|string',
            'reason_leaving_previous_school' => 'required|string',
            'father_name' => 'required|string',
            'mother_name' => 'required|string',
            'guardian_name' => 'nullable|string',
            'relationship_to_student' => 'nullable|string',
            'occupation' => 'required|string',
            'employer' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|email',
            'home_address_guardian' => 'nullable|string',
            'emergency_contact_person' => 'required|string',
            'emergency_contact_number' => 'required|string',
            'allergies' => 'nullable|string',
            'chronic_illnesses' => 'nullable|string',
        ]);

        $admission = Admission::create($request->all());
        return response()->json($admission, 201);
    }
}
