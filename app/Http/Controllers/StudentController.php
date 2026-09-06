<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassesResource;
use App\Models\Student;
use App\Models\Classes;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\UpdateStudentRequest;


class StudentController extends Controller
{
    public function index()
    {
        // 1. Eager load 'class' and 'section' to avoid N+1 performance issues
        // 2. Use paginate() instead of all() so pagination links work in Vue
        // $students = Student::with(['class', 'section'])->paginate(10);

        // Optional: If you want to use your StudentResource with pagination:
        $students = StudentResource::collection(Student::with(['class', 'section'])->paginate(10));
// dd($students);
        return inertia('Students/index', [
            'students' => $students
        ]);
    }

    public function create()
    {   
        $classes = ClassesResource::collection(Classes::all());
        return inertia('Students/create', [
            'classes' => $classes,
        ]);
    }

    public function store(StudentStoreRequest $request)
    {

        Student::create($request->validated());

        return redirect()->route('students.index');
    }

     public function edit(Student $student)
    {   
        $classes = ClassesResource::collection(Classes::all());
        // dd($student);
        return inertia('Students/edit', [
            'classes' => $classes,
            'student' => StudentResource::make($student),
        ]);
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {

        $student->update($request->validated());

        return redirect()->route('students.index');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index');
    }
}
