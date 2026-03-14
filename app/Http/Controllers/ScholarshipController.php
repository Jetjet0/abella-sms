<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scholarship;

class ScholarshipController extends Controller
{
    // GET /api/scholarships
    public function index()
    {
        return response()->json(Scholarship::all());
    }

    // POST /api/scholarships
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric'
        ]);

        $scholarship = Scholarship::create($request->only('title','description','amount'));

        return response()->json($scholarship, 201);
    }

    // PUT /api/scholarships/{id}
    public function update(Request $request, $id)
    {
        $scholarship = Scholarship::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'amount' => 'sometimes|required|numeric'
        ]);

        $scholarship->update($request->only('title','description','amount'));

        return response()->json($scholarship);
    }

    // DELETE /api/scholarships/{id}
    public function destroy($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $scholarship->delete();

        return response()->json(['message' => 'Scholarship deleted']);
    }
}