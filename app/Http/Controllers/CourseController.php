<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'certificate' => 'required|boolean',
            'thumbnail' => 'string|url',
            'type' => 'required|in:free, premium',
            'status' => 'required|in:draft,published',
            'price' => 'integer',
            'level' => 'required|in:all,beginner,intermediate,advanced',
            'description' => 'string',
            'mentor_id' => 'required|integer'
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules);

        if ($validator->fails())
            return response()->json([
                'status' => 1,
                'message' => $validator->errors()
            ], 400);

        $mentor = Mentor::find($data['mentor_id']);

        if (!$mentor)
            return response()->json([
                'status' => 1,
                'message' => "Mentor not found"
            ], 404);


        $course = Course::create($data);

        return response()->json([
            'status' => 0,
            'message' => 'Course successfully created',
            'data' => $course
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
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
            'certificate' => 'boolean',
            'thumbnail' => 'string|url',
            'type' => 'in:free, premium',
            'status' => 'in:draft,published',
            'price' => 'integer',
            'level' => 'in:all,beginner,intermediate,advanced',
            'description' => 'string',
            'mentor_id' => 'integer'
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules);

        if ($validator->fails())
            return response()->json([
                'status' => 1,
                'message' => $validator->errors()
            ], 400);

        if ($request->input('mentor_id')) {
            $mentor = Mentor::find($data['mentor_id']);

            if (!$mentor)
                return response()->json([
                    'status' => 1,
                    'message' => "Mentor not found"
                ], 404);
        }

        $course = Course::find($id);

        if (!$course)
            return response()->json([
                'status' => 1,
                'message' => "Course not found"
            ], 404);

        $course->update($data);

        return response()->json([
            'status' => 0,
            'message' => "Course successfully updated",
            'data' => $course
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
