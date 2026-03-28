<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    // GET /api/applicants
    public function index(): JsonResponse
    {
        return response()->json(Applicant::all());
    }

    // GET /api/applicants/{id}
    public function show($id): JsonResponse
    {
        $applicant = Applicant::find($id);

        if (!$applicant) {
            return response()->json(['message' => 'Applicant not found.'], 404);
        }

        return response()->json($applicant);
    }

    // POST /api/applicants
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:applicants,email',
            'phone'  => 'nullable|string|max:20',
            'course' => 'required|string|max:255',
        ]);

        $applicant = Applicant::create($validated);

        return response()->json($applicant, 201);
    }

    // PUT/PATCH /api/applicants/{id}
    public function update(Request $request, $id): JsonResponse
    {
        $applicant = Applicant::find($id);

        if (!$applicant) {
            return response()->json(['message' => 'Applicant not found.'], 404);
        }

        $validated = $request->validate([
            'name'   => 'sometimes|string|max:255',
            'email'  => 'sometimes|email|unique:applicants,email,' . $id,
            'phone'  => 'nullable|string|max:20',
            'course' => 'sometimes|string|max:255',
        ]);

        $applicant->update($validated);

        return response()->json($applicant->fresh());
    }

    // DELETE /api/applicants/{id}
    public function destroy($id): JsonResponse
    {
        $applicant = Applicant::find($id);

        if (!$applicant) {
            return response()->json(['message' => 'Applicant not found.'], 404);
        }

        $applicant->delete();

        return response()->json(['message' => 'Applicant deleted successfully.']);
    }
}