<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChapterController extends Controller
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
            'course_id' => 'required|integer',
        ];

        $data  = $request->all();
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 1,
                'message' => $validator->errors(),
            ], 400);
        }

        $course = Course::find($data['course_id']);
        if (!$course) {
            return response()->json([
                'status' => 1,
                'message' => 'Course not found',
            ], 404);
        }

        $chapter = Chapter::create($data);
        return response()->json([
            'status' => 0,
            'message' => 'Chapter successfully created',
            'data' => $chapter,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
