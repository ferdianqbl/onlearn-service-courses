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
    public function index(Request $request)
    {
        $chapters = Chapter::query();

        $courseId = $request->query('course_id');

        $chapters->when($courseId, function ($query) use ($courseId) {
            return $query->where('course_id', '=', $courseId);
        });

        return response()->json([
            'status' => 0,
            'message' => "All Chapters found",
            'data' => $chapters->paginate(10)
        ], 200);
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
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'string',
            'course_id' => 'integer',
        ];

        $data  = $request->all();
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 1,
                'message' => $validator->errors(),
            ], 400);
        }

        if ($request->input('course_id')) {
            $course = Course::find($data['course_id']);
            if (!$course) {
                return response()->json([
                    'status' => 1,
                    'message' => 'Course not found',
                ], 404);
            }
        }

        $chapter = Chapter::find($id);
        if (!$chapter) {
            return response()->json([
                'status' => 1,
                'message' => 'Chapter not found',
            ], 404);
        }

        $chapter->update($data);
        return response()->json([
            'status' => 0,
            'message' => 'Chapter successfully updated',
            'data' => $chapter,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}