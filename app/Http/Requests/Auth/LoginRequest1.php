<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest1 extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        Log::info($this->boolean('remember'));

        $user = $this->checkUserAvailability($this->only('username'));

        if (!$user || !$user->is_active) {
            throw ValidationException::withMessages([
                'username' => $user ? 'Your account is inactive. Please contact your administrator.' : 'The username you provided could not be found.',
            ]);
        }

        $this->loggedUserObj = $user;

        $this->ensureIsNotRateLimited();

        if ($user->password == $this->customEncrypt($this->only('password'))) {
            Auth::login($user);
            $this->intialSyncData();

            $this->checkRememberMe($user);
        } else {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'username' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    private function intialSyncData()
    {
        getMenu();
    }

    private function checkRememberMe($user)
    {
        if ($this->boolean('remember')) {

            $rememberToken = Str::random(60);

            $user->remember_token = Crypt::encryptString($rememberToken);
            $user->save();

            Cookie::queue('remember_token', $rememberToken, 60 * 24 * 5); // 5 days

            session(['user_id' => $user->id]);
        }
    }

    private function checkUserAvailability($request)
    {
        $user = User::where('username', $request['username'])
            ->with('roles')
            ->first();
        // dd($user);
        return  $user ? $user : false;
    }

    private function customEncrypt($pass)
    {
        $str = $pass['password'];
        $key = '4QcTlzuaNUcX289Z9D0ovPCzb';
        $iv = "1234567812345678";
        $encryption_key = base64_encode($key);
        $encrypted = openssl_encrypt($str, 'aes-256-cbc', $encryption_key, true, $iv);
        $encrypted_data = base64_encode($encrypted);
        return ($encrypted_data);
    }

    public function authenticateOld(): void
    {
        $this->ensureIsNotRateLimited();

        if (!Auth::attempt($this->only('username', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'username' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
    }
}
