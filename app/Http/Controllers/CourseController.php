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
    public function index(Request $request)
    {
        $courses = Course::query();

        $name = $request->query('name');
        $status = $request->query('status');
        $type = $request->query('type');
        $level = $request->query('level');

        $courses->when($name, function ($query) use ($name) {
            return $query->whereRaw("name LIKE '%" . $name . "%'");
        });

        $courses->when($status, function ($query) use ($status) {
            return $query->where('status', '=', $status);
        });

        $courses->when($type, function ($query) use ($type) {
            return $query->where('type', '=', $type);
        });

        $courses->when($level, function ($query) use ($level) {
            return $query->where('level', '=', $level);
        });

        return response()->json([
            'error' => 0,
            'message' => "All Courses found",
            'data' => $courses->with('reviews')->paginate(10)
        ], 200);
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
            'type' => 'required|in:free,premium',
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
                'error' => 1,
                'message' => $validator->errors()
            ], 400);

        $mentor = Mentor::find($data['mentor_id']);

        if (!$mentor)
            return response()->json([
                'error' => 1,
                'message' => "Mentor not found"
            ], 404);


        $course = Course::create($data);

        return response()->json([
            'error' => 0,
            'message' => 'Course successfully created',
            'data' => $course
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $course = Course::find($id);

        if (!$course)
            return response()->json([
                'error' => 1,
                'message' => 'Course not found'
            ], 404);

        return response()->json([
            'error' => 0,
            'message' => "Course found",
            'data' => $course
        ], 200);
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
                'error' => 1,
                'message' => $validator->errors()
            ], 400);

        if ($request->input('mentor_id')) {
            $mentor = Mentor::find($data['mentor_id']);

            if (!$mentor)
                return response()->json([
                    'error' => 1,
                    'message' => "Mentor not found"
                ], 404);
        }

        $course = Course::find($id);

        if (!$course)
            return response()->json([
                'error' => 1,
                'message' => "Course not found"
            ], 404);

        $course->update($data);

        return response()->json([
            'error' => 0,
            'message' => "Course successfully updated",
            'data' => $course
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $course = Course::find($id);

        if (!$course)
            return response()->json([
                'error' => 1,
                'message' => 'Course not found'
            ], 404);

        $course->delete();

        return response()->json([
            'error' => 0,
            'message' => "Course successfully deleted",
        ], 200);
    }
}
