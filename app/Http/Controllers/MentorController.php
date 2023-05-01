<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mentors = Mentor::all();

        if (count($mentors) <= 0)
            return response()->json([
                'status' => '1',
                'message' => 'No Mentors yet'
            ], 404);

        return response()->json([
            'status' => '0',
            'message' => "All mentors found",
            'data' => $mentors
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'profile' => 'required|url',
            'profession' => 'required|string',
            'email' => 'required|email|unique:mentors',
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules);

        if ($validator->fails())
            return response()->json([
                'status' => '1',
                'message' => $validator->errors()
            ], 400);

        $mentor = Mentor::create($data);

        return response()->json([
            'status' => '1',
            'message' => 'Mentor successfully created',
            'data' => $mentor
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Mentor $mentor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mentor $mentor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'string',
            'profile' => 'url',
            'profession' => 'string',
            'email' => 'email',
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules);

        if ($validator->fails())
            return response()->json([
                'status' => '1',
                'message' => $validator->errors()
            ], 400);

        $mentor = Mentor::find($id);
        $mentorWithSameEmail = Mentor::where('email', $data['email'])->first();

        if (!$mentor)
            return response()->json([
                'status' => '1',
                'message' => 'Mentor not found'
            ], 404);

        if ($mentorWithSameEmail && $mentorWithSameEmail->id !== $mentor->id)
            return response()->json([
                'status' => '1',
                'message' => 'The email has already been taken.'
            ], 400);

        $mentor->update($data);
        return response()->json([
            'status' => '0',
            'message' => "Mentor successfully updated",
            'data' => $mentor
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mentor $mentor)
    {
        //
    }
}
