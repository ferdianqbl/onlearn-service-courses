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
    public function index(Request $req)
    {
        $lessons = Lesson::query();
        $chapterId = $req->query('chapter_id');

        if(!$chapterId){
            return response()->json([
                'error' => 1,
                'message' => "Chapter ID is required",
            ], 400);
        }

        $lessons->when($chapterId, function ($query) use ($chapterId) {
            return $query->where('chapter_id', '=', $chapterId);
        });

        return response()->json([
            'error' => 0,
            'message' => "All Lessons found",
            'data' => $lessons->get()
        ], 200);
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
        if ($validator->fails())
            return response()->json([
                'error' => 1,
                'message' => $validator->errors(),
            ], 400);

        $chapter = Chapter::find($data['chapter_id']);
        if (!$chapter)
            return response()->json([
                'error' => 1,
                'message' => "Chapter not found",
            ], 404);

        $lesson = Lesson::create($data);
        return response()->json([
            'error' => 0,
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
         $rules = [
            'name' => 'string',
            'video' => 'string',
            'chapter_id' => 'integer'
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if ($validator->fails())
            return response()->json([
                'error' => 1,
                'message' => $validator->errors(),
            ], 400);

        if ($request->input('chapter_id')) {
            $chapter = Chapter::find($data['chapter_id']);

            if (!$chapter)
                return response()->json([
                    'error' => 1,
                    'message' => "Chapter not found"
                ], 404);
        }

        $lesson = Lesson::find($id);
        if (!$lesson)
            return response()->json([
                'error' => 1,
                'message' => "Lesson not found",
            ], 404);

        $lesson->update($data);
        
        return response()->json([
            'error' => 0,
            'message' => "Lesson successfully updated",
            'data' => $lesson
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
