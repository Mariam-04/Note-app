<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

    use App\Http\Requests\LoginRequest;
    use App\Http\Requests\SignupRequest;
    use App\Http\Requests\SendResetLinkRequest;
    use App\Http\Requests\ResetPasswordRequest;
class AuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function login(LoginRequest $request){}

    public function signup(SignupRequest $request){}

    public function sendResetLink(SendResetLinkRequest $request){}

    public function resetPassword(ResetPasswordRequest $request){}
}
