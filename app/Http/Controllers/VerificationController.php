<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class VerificationController extends Controller
{
    public function verify($user_id, Request $request) 
    {
        if (!$request->hasValidSignature()) 
        {
            return response()->json(["msg" => "Invalid/Expired url provided."], 401);
        }
    
        $user = User::findOrFail($user_id);
        
        if (!$user->hasVerifiedEmail()) 
        {
            $user->markEmailAsVerified();
        }
    
        return Redirect::to('https://stackoverflow.com/questions/29303783/route-login-not-defined');
    }
    
    public function resend() 
    {
        if (auth()->user()->hasVerifiedEmail()) 
        {
            return response()->json(["msg" => "Email already verified."], 400);
        }
    
        auth()->user()->sendEmailVerificationNotification();
    
        return response()->json(["msg" => "Email verification link sent on your email id"]);
    }
}
