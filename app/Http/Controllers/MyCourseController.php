<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\MyCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MyCourseController extends Controller
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
            'course_id' => 'required|exists:courses,id|integer',
            'user_id' => 'required|integer',
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if($validator->fails())
            return response()->json([
                'error' => 1,
                'message' => $validator->errors()
            ], 400);

        $course = Course::find($data['course_id']);
        if(!$course)
            return response()->json([
                'error' => 1,
                'message' => 'Course not found'
            ], 404);
        
        $user = getUser($data['user_id']);
        if($user['error'])
            return response()->json([
                'error' => 1,
                'message' => $user['message']
            ], $user['http_code']);
        
        
        $isMyCourseExist = MyCourse::where('course_id', $data['course_id'])
            ->where('user_id', $data['user_id'])
            ->exists();
        
        if($isMyCourseExist)
            return response()->json([
                'error' => 1,
                'message' => 'User already taken this course'
            ], 409);
        
        $myCourse = MyCourse::create($data);
        return response()->json([
            'error' => 0,
            'data' => $myCourse
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
