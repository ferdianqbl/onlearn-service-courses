<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\ImageCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $imageCourses = ImageCourse::get();
        return response()->json([
            'error' => 0,
            'message' => 'All image courses found',
            'data' => $imageCourses
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $rules = [
            'image' => 'required|url',
            'course_id' => 'required|integer'
        ];
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
            return response()->json([
                'error' => 1,
                'message' => $validator->errors()
            ], 400);
        }

        $course = Course::find($data['course_id']);
        if(!$course) {
            return response()->json([
                'error' => 1,
                'message' => 'Course not found'
            ], 404);
        }

        $imageCourse = ImageCourse::create($data);
        return response()->json([
            'error' => 0,
            'message' => 'Image course successfully created',
            'data' => $imageCourse
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $imageCourse = ImageCourse::find($id);
        if(!$imageCourse) {
            return response()->json([
                'error' => 1,
                'message' => 'Image course not found'
            ], 404);
        }

        return response()->json([
            'error' => 0,
            'message' => 'Image course found',
            'data' => $imageCourse
        ], 200);
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
        $image = ImageCourse::find($id);
        if(!$image) {
            return response()->json([
                'error' => 1,
                'message' => 'Image course not found'
            ], 404);
        }

        $image->delete();
        return response()->json([
            'error' => 0,
            'message' => 'Image course successfully deleted'
        ], 200);
    }
}
