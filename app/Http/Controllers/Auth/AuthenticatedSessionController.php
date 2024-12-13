<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Events\UserLoginEvent;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;
use App\Models\Administration\UserLoginActivityLog;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        if ($this->isMultiDeviceLoginAttempt($user)) {
            $this->handleMultiDeviceLogin();
            return $this->redirectToLoginWithError('You have been logged out because your account was accessed from another devices.');
        }

        event(new UserLoginEvent(Auth::user()));
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function resetLoginSession(Request $request)
    {
        $user = User::whereUsername($request->username)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'username' => 'The username you provided could not be found.',
                'validType' => 'not found',
            ]);
        }

        $logedDevice = UserLoginActivityLog::where('session_id', $user->session_id)->first();

        return view('auth.reset-user-session', ['user' => $user, 'logedDevice' => $logedDevice]);
    }

    public function resetLoginSessionSubmit(Request $request)
    {
        $user = User::whereUsername($request->username)->update(['session_id' => null]);
        return redirect()->route('login');
    }

    private function isMultiDeviceLoginAttempt($user): bool
    {
        return $user && $user->session_id && $user->session_id !== session()->getId();
    }

    private function handleMultiDeviceLogin(): void
    {
        Auth::logout();
        Log::info('Prevented multi-device login');
    }

    private function redirectToLoginWithError(string $message)
    {
        return redirect('/login')->withErrors([
            'username' => $message,
        ]);
    }

    public function username()
    {
        return 'username';
    }

    public function destroy(Request $request): RedirectResponse
    {
        Log::info('from destroy');

        event(new UserLoginEvent(Auth::user()));

        $sessionUserId = session('user_id');
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $this->clearRememberToken($sessionUserId);

        return redirect('/');
    }

    public function clearRememberToken($sessionUserId)
    {
        $user = User::find($sessionUserId);

        if ($user) {
            $user->remember_token = null;
            $user->save();

            // Clear the remember token cookie
            Cookie::queue(Cookie::forget('remember_token'));

            // Log out the user
            session()->forget('user_id');
        }
    }
}
