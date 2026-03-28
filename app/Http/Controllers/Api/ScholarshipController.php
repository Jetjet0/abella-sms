<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    // 3.1.1 Get/Display all scholarships
    public function index(): JsonResponse
    {
        $scholarships = Scholarship::latest()->get();

        return response()->json([
            'message'      => 'Scholarships retrieved successfully.',
            'scholarships' => $scholarships,
        ]);
    }

    // 3.1.2 Add Scholarship
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'amount'      => 'required|numeric|min:0',
        ]);

        $scholarship = Scholarship::create($validated);

        return response()->json([
            'message'     => 'Scholarship created successfully.',
            'scholarship' => $scholarship,
        ], 201);
    }

    // Get single scholarship
    public function show(Scholarship $scholarship): JsonResponse
    {
        return response()->json([
            'message'     => 'Scholarship retrieved successfully.',
            'scholarship' => $scholarship,
        ]);
    }

    // 3.1.3 Edit Scholarship
    public function update(Request $request, Scholarship $scholarship): JsonResponse
    {
        $validated = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'amount'      => 'sometimes|numeric|min:0',
        ]);

        $scholarship->update($validated);

        return response()->json([
            'message'     => 'Scholarship updated successfully.',
            'scholarship' => $scholarship->fresh(),
        ]);
    }

    // 3.1.4 Delete Scholarship
    public function destroy(Scholarship $scholarship): JsonResponse
    {
        $scholarship->delete();

        return response()->json([
            'message' => 'Scholarship deleted successfully.',
        ]);
    }
}