<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;

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
}
