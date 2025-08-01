<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function sendResetLink(AuthRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm($token)
    {
        return view('auth.reset-form', ['token' => $token]);
    }

    public function resetPassword(AuthRequest $request)
    {
            $user = User::getUserByEmail($request->email);
            $user->password = bcrypt($request->password);
            $user->save();

            if (!$user) {
                return back()->withErrors(['email' => 'User not found.']);
            }

            return redirect('/login')->with('message', 'Password has been reset!');
            
    }
}
