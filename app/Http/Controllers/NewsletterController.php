<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        try {
            // 1. Validate email
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:subscribers,email'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first()
                ], 422);
            }

            // 2. Store the email
            $subscriber = Subscriber::create(['email' => strtolower(trim($request->email))]);

            // 3. Optional: Send welcome email here
            // Mail::to($subscriber->email)->send(new WelcomeSubscriber());

            return response()->json([
                'status' => 'success',
                'message' => 'Thank you for subscribing!'
            ], 200);

        } catch (\Illuminate\Database\QueryException $e) {
            // Database error (e.g., table doesn't exist)
            Log::error('Newsletter DB Error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Database error. Please contact support.'
            ], 500);
            
        } catch (\Illuminate\Database\Eloquent\MassAssignmentException $e) {
            // Model $fillable issue
            Log::error('Newsletter Mass Assignment Error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Configuration error. Please contact support.'
            ], 500);
            
        } catch (\Exception $e) {
            // Any other error
            Log::error('Newsletter Subscribe Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'email' => $request->email ?? 'unknown'
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }
}