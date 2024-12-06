<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Course;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $reviews = Review::query();
        $courseId = $request->query('course_id');
        $userId = $request->query('user_id');

        if (!$courseId && !$userId) {
            return response()->json([
                'error' => 1,
                'message' => 'Course ID or User ID is required',
                'data' => null
            ], 400);
        }

        if ($courseId) {
            $reviews->where('course_id', $courseId);
        }

        if ($userId) {
            $reviews->where('user_id', $userId);
        }

        return response()->json([
            'error' => 0,
            'message' => 'Reviews found',
            'data' => $reviews->get()
        ], 200);
    }

    public function create(Request $request)
    {
        $rules = [
            'course_id' => 'required|exists:courses,id|integer',
            'user_id' => 'required|integer',
            'rating' => 'required|numeric|min:1|max:5',
            'note' => 'required|string'
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if ($validator->fails())
            return response()->json([
                'error' => 1,
                'message' => $validator->errors()
            ], 400);

        $course = Course::find($data['course_id']);
        if (!$course)
            return response()->json([
                'error' => 1,
                'message' => 'Course not found'
            ], 404);

        $user = getUser($data['user_id']);
        if ($user['error'])
            return response()->json([
                'error' => 1,
                'message' => $user['message']
            ], $user['http_code']);

        $isExistReview = Review::where('course_id', $data['course_id'])
            ->where('user_id', $data['user_id'])
            ->exists();

        if ($isExistReview) {
            return response()->json([
                'error' => 1,
                'message' => 'Review already exists'
            ], 409);
        }

        $review = Review::create($data);
        return response()->json([
            'error' => 0,
            'message' => 'Review created',
            'data' => $review
        ], 201);
    }

    public function show(string $id)
    {
        $review = Review::find($id);
        if (!$review)
            return response()->json([
                'error' => 1,
                'message' => 'Review not found'
            ], 404);

        return response()->json([
            'error' => 0,
            'message' => 'Review found',
            'data' => $review
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $rules = [
            'rating' => 'required|numeric|min:1|max:5',
            'note' => 'required|string'
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if ($validator->fails())
            return response()->json([
                'error' => 1,
                'message' => $validator->errors()
            ], 400);

        $review = Review::find($id);
        if (!$review)
            return response()->json([
                'error' => 1,
                'message' => 'Review not found'
            ], 404);

        $review->update($data);
        return response()->json([
            'error' => 0,
            'message' => 'Review updated',
            'data' => $review
        ], 200);
    }

    public function destroy(string $id)
    {
        $review = Review::find($id);
        if (!$review)
            return response()->json([
                'error' => 1,
                'message' => 'Review not found'
            ], 404);

        $review->delete();
        return response()->json([
            'error' => 0,
            'message' => 'Review deleted'
        ], 200);
    }
}
