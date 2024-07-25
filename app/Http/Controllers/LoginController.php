<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            // Validasi form data
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ], [
                'email.required' => 'Email harus diisi.',
                'email.email' => 'Format email tidak valid.',
                'password.required' => 'Password harus diisi.',
            ]);

            // Attempt to authenticate the user
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Authentication successful, determine user role
                $user = Auth::user();
                Log::info('User authenticated successfully', ['user' => $user]);

                if ($user->kode_roles == 1) {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->kode_roles == 2) {
                    Log::info('Redirecting to posyandu dashboard');
                    return redirect()->route('posyandu.dashboard');
                } elseif ($user->kode_roles == 3) {
                    return redirect()->route('orangtua.dashboard');
                } else {
                    return redirect('/'); // Ganti dengan nama rute default jika diperlukan
                }
            }
            // Redirect back with error if authentication fails
            return back()->withErrors(['error' => 'Email atau password salah.']);
        } catch (\Exception $e) {
            // dd($e);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat melakukan login.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        return redirect('/');
    }
}
