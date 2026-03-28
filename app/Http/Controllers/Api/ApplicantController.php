<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Applicant; // make sure this model exists
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    // Get all applicants
    public function index()
    {
        $applicants = Applicant::all();
        return response()->json($applicants);
    }

    // Get single applicant
    public function show($id)
    {
        $applicant = Applicant::find($id);

        if (!$applicant) {
            return response()->json(['message' => 'Applicant not found'], 404);
        }

        return response()->json($applicant);
    }
    public function store(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:applicants,email',
        // Add other validation rules for applicant data
    ]);

    // Create a new applicant using the validated data
    $applicant = Applicant::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        // Add other fields as needed
    ]);

    // Return the created applicant as a JSON response
    return response()->json($applicant, 201);
}

    // Add more methods as needed (store, update, delete)
}