<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => ['required', 'string'], // Change the 'email' field to 'login'
            'password' => ['required', 'string'],
        ];
    }

    // public function authenticate(): void
    // {
    //     $this->ensureIsNotRateLimited();

    //     // Modify the authentication logic to check both email and username
    //     $loginField = filter_var($this->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    //     if (! Auth::attempt([$loginField => $this->input('login'), 'password' => $this->input('password')], $this->boolean('remember'))) {
    //         RateLimiter::hit($this->throttleKey());

    //         throw ValidationException::withMessages([
    //             'login' => trans('auth.failed'),
    //         ]);
    //     }

    //     RateLimiter::clear($this->throttleKey());
    // }
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Modify the authentication logic to check both email and username
        $loginField = filter_var($this->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Find the user based on login field and status
        $user = User::where([$loginField => $this->input('login')])
                    ->first();

        if ($user && $user->activeStatus == 0) {
            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
            ]);
        }

        if ($user && !Auth::attempt([$loginField => $this->input('login'), 'password' => $this->input('password')], $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('login')).'|'.$this->ip());
    }
}
