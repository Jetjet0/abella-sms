<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // Admin: Get all applications
    public function index(): JsonResponse
    {
        $applications = Application::with(['student', 'scholarship'])->latest()->get();

        return response()->json([
            'message'      => 'Applications retrieved successfully.',
            'applications' => $applications,
        ]);
    }

    // 4.1.1 Student: Submit Application
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id'     => 'required|exists:students,id',
            'scholarship_id' => 'required|exists:scholarships,id',
        ]);

        // Prevent duplicate applications
        $existing = Application::where('student_id', $validated['student_id'])
            ->where('scholarship_id', $validated['scholarship_id'])
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'This student has already applied for this scholarship.',
            ], 422);
        }

        $application = Application::create([
            'student_id'     => $validated['student_id'],
            'scholarship_id' => $validated['scholarship_id'],
            'status'         => 'pending',
        ]);

        $application->load('student', 'scholarship');

        return response()->json([
            'message'     => 'Application submitted successfully.',
            'application' => $application,
        ], 201);
    }

    // 4.1.2 Get single application / view status
    public function show(Application $application): JsonResponse
    {
        $application->load('student', 'scholarship');

        return response()->json([
            'message'     => 'Application retrieved successfully.',
            'application' => $application,
        ]);
    }

    // 4.2.1 Admin: Approve Application
    public function approve(Request $request, Application $application): JsonResponse
    {
        if ($application->status !== 'pending') {
            return response()->json([
                'message' => 'Only pending applications can be approved.',
            ], 422);
        }

        $request->validate([
            'remarks' => 'nullable|string|max:500',
        ]);

        $application->update([
            'status'  => 'approved',
            'remarks' => $request->remarks,
        ]);

        return response()->json([
            'message'     => 'Application approved successfully.',
            'application' => $application->fresh()->load('student', 'scholarship'),
        ]);
    }

    // 4.2.2 Admin: Reject Application
    public function reject(Request $request, Application $application): JsonResponse
    {
        if ($application->status !== 'pending') {
            return response()->json([
                'message' => 'Only pending applications can be rejected.',
            ], 422);
        }

        $request->validate([
            'remarks' => 'nullable|string|max:500',
        ]);

        $application->update([
            'status'  => 'rejected',
            'remarks' => $request->remarks,
        ]);

        return response()->json([
            'message'     => 'Application rejected.',
            'application' => $application->fresh()->load('student', 'scholarship'),
        ]);
    }
}