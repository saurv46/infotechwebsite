<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\JobResponseSubmitted;
use App\Models\JobPost;
use App\Models\JobResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class JobResponseController extends Controller
{
    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'job_post_id'  => 'required|integer',
                'full_name'    => 'required|string|max:255',
                'email'        => 'required|email|max:255',
                'phone_number' => 'required|string|max:30',
                'cv'           => 'required|file|mimes:pdf,doc,docx|max:10240', // max 10MB
                'is_active'    => 'nullable|boolean',
            ]);
            $cv = $request->file('cv');
            $fileName = time() . '_' . Str::random(10) . '.' . $cv->getClientOriginalExtension();
            $cv->move(public_path('uploads/cvs'), $fileName);
            $validated['cv'] = 'uploads/cvs/' . $fileName;
            $validated['is_active'] = false;

            $jobResponse = JobResponse::create($validated);

            try {
                $jobTitle = JobPost::withTrashed()
                    ->whereKey($jobResponse->job_post_id)
                    ->value('job_title');

                $notifyTo = config('mail.careers_notify_address');
                Mail::to($notifyTo)->send(new JobResponseSubmitted($jobResponse, $jobTitle));
            } catch (\Throwable $mailError) {
                Log::error('Job response mail failed: ' . $mailError->getMessage());
            }

            return response()->json([
                'status'  => true,
                'message' => 'Job response submitted successfully',
                'data'    => $jobResponse,
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
                'message' => 'Failed to submit job response',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $query = JobResponse::withTrashed()
                ->with('jobPost:id,job_title')
                ->orderBy('created_at', 'desc');

        
            if ($request->filled('is_active')) {
                $query->where('is_active', $request->boolean('is_active'));
            }

            $jobResponses = $query->get()->map(function ($response) {
                $response->job_title = $response->jobPost?->job_title;
                unset($response->jobPost);
                return $response;
            });

            return response()->json([
                'status'  => true,
                'message' => 'Job responses fetched successfully',
                'count'   => $jobResponses->count(),
                'data'    => $jobResponses,
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Failed to fetch job responses',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {

            $jobResponse = JobResponse::withTrashed()
                ->with('jobPost:id,job_title')
                ->findOrFail($id);

            $jobResponse->job_title = $jobResponse->jobPost?->job_title;
            unset($jobResponse->jobPost);

            return response()->json([
                'status'  => true,
                'message' => 'Job response fetched successfully',
                'data'    => $jobResponse,
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Job response not found',
            ], 404);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Failed to fetch job response',
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

            $jobResponse = JobResponse::withTrashed()->findOrFail($id);
            $jobResponse->is_active = $request->boolean('is_active');
            $jobResponse->save();

            return response()->json([
                'status'  => true,
                'message' => 'Job response status updated successfully',
                'data'    => $jobResponse,
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
                'message' => 'Job response not found',
            ], 404);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Failed to update job response status',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function downloadCv($id)
    {
        try {

            $jobResponse = JobResponse::withTrashed()->findOrFail($id);

            $path = public_path($jobResponse->cv);

            if (! $jobResponse->cv || ! File::exists($path)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'CV file not found',
                ], 404);
            }

            $downloadName = Str::slug($jobResponse->full_name) . '.' . pathinfo($path, PATHINFO_EXTENSION);

            return response()->download($path, $downloadName);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Job response not found',
            ], 404);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Failed to download CV',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
