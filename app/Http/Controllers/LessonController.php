<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
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
            'video' => 'required|string',
            'chapter_id' => 'required|integer'
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if (!$validator->fails())
            return response()->json([
                'status' => 1,
                'message' => $validator->errors(),
            ], 400);

        $chapter = Chapter::find($data['chapter_id']);
        if (!$chapter)
            return response()->json([
                'status' => 0,
                'message' => "Chapter not found",
            ], 404);

        $lesson = Lesson::create($data);
        return response()->json([
            'status' => 1,
            'message' => "Lesson created",
            'data' => $lesson
        ], 201);
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
