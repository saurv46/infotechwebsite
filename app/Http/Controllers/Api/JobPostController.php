<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class JobPostController extends Controller
{
    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'job_title'       => 'required|string|max:255',
                'role'            => 'required|string|max:255',
                'location'        => ['required', Rule::in(['Onsite', 'Remote', 'Hybrid'])],
                'engagement'      => ['required', Rule::in(['Full time', 'Part-time', 'Contractual'])],
                'job_description' => 'required|string',
                'is_active'       => 'nullable|boolean',
            ]);

            $jobPost = JobPost::create($validated);

            return response()->json([
                'status'  => true,
                'message' => 'Job post created successfully',
                'data'    => $jobPost,
            ], 201);

        } catch (ValidationException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Failed to create job post',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        try {
            $jobPosts = JobPost::withTrashed()
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status'  => true,
                'message' => 'Job posts fetched successfully',
                'count'   => $jobPosts->count(),
                'data'    => $jobPosts, 
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Failed to fetch job posts',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function activeJobs()
    {
        try {
            $jobPosts = JobPost::where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status'  => true,
                'message' => 'Job posts fetched successfully',
                'count'   => $jobPosts->count(),
                'data'    => $jobPosts,
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Failed to fetch job posts',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $jobPost = JobPost::withTrashed()->findOrFail($id);

            return response()->json([
                'status'  => true,
                'message' => 'Job post fetched successfully',
                'data'    => $jobPost,
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Job post not found',
            ], 404);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Failed to fetch job post',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $jobPost = JobPost::withTrashed()->findOrFail($id);

            $validated = $request->validate([
                'job_title'       => 'sometimes|required|string|max:255',
                'role'            => 'sometimes|required|string|max:255',
                'location'        => ['sometimes', 'required', Rule::in(['Onsite', 'Remote', 'Hybrid'])],
                'engagement'      => ['sometimes', 'required', Rule::in(['Full time', 'Part-time', 'Contractual'])],
                'job_description' => 'sometimes|required|string',
                'is_active'       => 'sometimes|boolean',
                'is_restore'      => 'sometimes|boolean',
            ]);

            // Restore the soft-deleted job post when is_restore is true.
            if ($request->boolean('is_restore') && $jobPost->trashed()) {
                $jobPost->restore();
            }

            // is_restore is a control flag, not a column.
            unset($validated['is_restore']);

            if (! empty($validated)) {
                $jobPost->update($validated);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Job post updated successfully',
                'data'    => $jobPost,
            ], 200);

        } catch (ValidationException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Job post not found',
            ], 404);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Failed to update job post',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {

            $request->validate([
                'is_active' => 'required|boolean',
            ]);

            $jobPost = JobPost::findOrFail($id);
            $jobPost->is_active = $request->boolean('is_active');
            $jobPost->save();

            return response()->json([
                'status'  => true,
                'message' => 'Job post status updated successfully',
                'data'    => $jobPost,
            ], 200);

        } catch (ValidationException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Job post not found',
            ], 404);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Failed to update job post status',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {

            $jobPost = JobPost::findOrFail($id);
            $jobPost->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Job post deleted successfully',
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Job post not found',
            ], 404);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Failed to delete job post',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
