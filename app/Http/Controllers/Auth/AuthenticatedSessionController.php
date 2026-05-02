<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Hapus baris ini:
        // $request->authenticate();

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }

        $passwordInput = $request->password;
        $passwordValid = false;

        // Cek Bcrypt (menggunakan password_verify untuk mendukung prefix $2b$ dari OS lain)
        if ($user->password && password_verify($passwordInput, $user->password)) {
            $passwordValid = true;
        } else {
            // Cek hash lama (MD5, SHA-1, SHA-256)
            $oldHashes = [
                'md5'    => fn($p) => md5($p),
                'sha1'   => fn($p) => sha1($p),
                'sha256' => fn($p) => hash('sha256', $p),
            ];

            foreach ($oldHashes as $type => $callback) {
                if ($user->password && $callback($passwordInput) === $user->password) {
                    // Migrasi ke Bcrypt
                    $user->password = Hash::make($passwordInput);
                    $user->save();
                    $passwordValid = true;
                    break;
                }
            }
        }

        if (!$passwordValid) {
            return back()->withErrors(['password' => 'Password salah']);
        }

        Auth::login($user);
        $request->session()->regenerate();

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->role === 'owner') {
            return redirect()->intended('/owner/dashboard');
        } else {
            return redirect()->intended('/user/dashboard');
        }
    }

    /**
     * Logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}