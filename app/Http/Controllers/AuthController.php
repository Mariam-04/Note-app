<?php
namespace App\Http\Controllers;
use App\Models\User; 
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\AuthRequest;

class AuthController extends Controller
{

    
    public function showLoginForm()
    {
        return view('login');
    }
    public function showSignup()
    {
        return view('signup');
    }


    public function login(AuthRequest $request)
    {
        $user = User::getUserByEmail($request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login' => 'Invalid credentials.',
            ])->withInput();
        }

        Auth::login($user);
        return redirect()->route('notes.index')->with('message', 'Login successful!');
    }

    public function signup(AuthRequest $request)
    {
        $user = User::createFromSignup($request->only(['name', 'email', 'password']));

        event(new \App\Events\UserRegistered($user));
        return redirect('/login')->with('message', 'Signup successful! Please login.');
    }

    public function sendResetLink(AuthRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return back()->with('status', __($status));
    }

}