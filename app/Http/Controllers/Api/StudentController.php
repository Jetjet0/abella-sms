<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // 2.1.1 Get/Display all students
    public function index(): JsonResponse
    {
        $students = Student::latest()->get();

        return response()->json([
            'message'  => 'Students retrieved successfully.',
            'students' => $students,
        ]);
    }

    // 2.1.2 Add Student
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'course'     => 'required|string|max:100',
            'year_level' => 'required|integer|min:1|max:6',
        ]);

        $student = Student::create($validated);

        return response()->json([
            'message' => 'Student created successfully.',
            'student' => $student,
        ], 201);
    }

    // Get single student
    public function show(Student $student): JsonResponse
    {
        $student->load('applications.scholarship');

        return response()->json([
            'message' => 'Student retrieved successfully.',
            'student' => $student,
        ]);
    }

    // 2.1.3 Edit Student
    public function update(Request $request, Student $student): JsonResponse
    {
        $validated = $request->validate([
            'name'       => 'sometimes|string|max:100',
            'course'     => 'sometimes|string|max:100',
            'year_level' => 'sometimes|integer|min:1|max:6',
        ]);

        $student->update($validated);

        return response()->json([
            'message' => 'Student updated successfully.',
            'student' => $student->fresh(),
        ]);
    }

    // 2.1.4 Delete Student
    public function destroy(Student $student): JsonResponse
    {
        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully.',
        ]);
    }
}