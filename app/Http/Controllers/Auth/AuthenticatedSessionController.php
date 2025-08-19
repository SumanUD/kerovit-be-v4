<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }
    
    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
    
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function store_otp(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::validate($credentials)) {
            // Generate OTP
            $otp = rand(100000, 999999);

            // Store in session
            session([
                'auth_email' => $request->email,
                'auth_password' => $request->password,
                'auth_otp' => $otp,
            ]);

            // Send OTP via Laravel's mail system
            Mail::raw("Your OTP is: $otp", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Your OTP for Login')
                        ->from('dev.ud.fortesting@gmail.com', 'Kerovit Auth');
            });

            return redirect()->route('otp.verify');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function showOtpForm(): View|RedirectResponse
    {
        if (!session()->has('auth_email') || !session()->has('auth_password') || !session()->has('auth_otp')) {
            return redirect()->route('login')->withErrors(['email' => 'Session expired. Please log in again.']);
        }
    
        return view('auth.otp');
    }


    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        if ($request->otp == session('auth_otp')) {
            if (Auth::attempt([
                'email' => session('auth_email'),
                'password' => session('auth_password')
            ])) {
                $request->session()->regenerate();

                session()->forget(['auth_email', 'auth_password', 'auth_otp']);

                return redirect()->intended(route('dashboard'));
            }
        }

        return back()->withErrors(['otp' => 'Invalid OTP']);
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
