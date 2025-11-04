<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Redirect user setelah password di-reset.
     *
     * @var string
     */
    protected $redirectTo = '/user/home';

    /**
     * Override bawaan agar user langsung login setelah reset password.
     */
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        // langsung login setelah reset
        Auth::login($user);
    }
}
