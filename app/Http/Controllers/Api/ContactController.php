<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactSubmitted;
use App\Models\Contact;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'full_name'    => 'required|string|max:255',
                'company_name' => 'required|string|max:255',
                'category'     => 'required|string|max:255',
                'description'  => 'required|string',
                'email'        => 'required|email|max:255',
                'phone_number' => 'nullable|string|max:30',
            ]);

            $contact = Contact::create($validated);

            try {
                $notifyTo = config('mail.contact_notify_address');
                Mail::to($notifyTo)->send(new ContactSubmitted($contact));
            } catch (\Throwable $mailError) {
                Log::error('Contact mail failed: ' . $mailError->getMessage());
            }

            return response()->json([
                'status'  => true,
                'message' => 'Thank you! Your enquiry has been submitted.',
                'data'    => $contact,
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
                'message' => 'Failed to submit enquiry',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        try {

            $contacts = Contact::orderBy('created_at', 'desc')->get();

            return response()->json([
                'status'  => true,
                'message' => 'Contacts fetched successfully',
                'count'   => $contacts->count(),
                'data'    => $contacts,
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Failed to fetch contacts',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function updateReadStatus(Request $request, $id)
    {
        try {

            $request->validate([
                'is_read' => 'required|boolean',
            ]);

            $contact = Contact::findOrFail($id);
            $contact->is_read = $request->boolean('is_read');
            $contact->save();

            return response()->json([
                'status'  => true,
                'message' => 'Contact read status updated successfully',
                'data'    => $contact,
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
                'message' => 'Contact not found',
            ], 404);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Failed to update read status',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {

            $contact = Contact::findOrFail($id);

            return response()->json([
                'status'  => true,
                'message' => 'Contact fetched successfully',
                'data'    => $contact,
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Contact not found',
            ], 404);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Failed to fetch contact',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
