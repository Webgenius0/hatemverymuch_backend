<?php

namespace App\Http\Controllers\Api\Contact;

use App\ApiResponse;
use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ApiContactController extends Controller
{
    use ApiResponse;

    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'subject'    => 'required|string|max:500',
            'message'    => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // Store contact in DB
            $contact = Contact::create([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'subject'    => $request->subject,
                'message'    => $request->message,
            ]);

            // Send email to admin(s)
            $adminEmails = User::where('role', 'admin')->pluck('email');
            Mail::to($adminEmails)->send(new ContactMail($contact));

            DB::commit();

            return $this->successResponse($contact, 'Contact form submitted successfully.', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to submit contact form: ' . $e->getMessage(), 500);
        }
    }
}
