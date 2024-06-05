<?php

namespace App\Livewire;

use App\Models\Pengguna;
use Livewire\Component;
use Illuminate\Support\Facades\Auth as authenticate;
use Illuminate\Support\Facades\RateLimiter;

class Auth extends Component
{
    public $email;
    public $password;

    public function login()
    {
        // Get the client's IP address
        $clientIp = request()->ip();

        // Rate limiting
        $key = 'login-attempt:' . $clientIp; // Using IP for rate limiting
        RateLimiter::for('login-attempt', function () {
            return Limit::perMinute(5); // Allow 5 attempts per minute
        });

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('attempts', 'Too many login attempts. Please try again in ' . $seconds . ' seconds.');
            return;
        }

        $this->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        // Retrieve the user based on the email
        $pengguna = Pengguna::where('email', $this->email)->first();

        // Check if the user exists and the password is correct
        if (!$pengguna || $this->password !== $pengguna->password) {
            // Increment the rate limiter
            RateLimiter::hit($key);
            $this->addError('email', 'Invalid credentials. Please try again.');
            return;
        }

        // Clear the rate limiter on successful login
        RateLimiter::clear($key);

        // Store user details in session
        session([
            'user_id' => $pengguna->user_id,
            'user_name' => $pengguna->nama_lengkap,
            'departemen' => $pengguna->departemen,
            'lok' => $pengguna->lokasi_kerja,
            'jabatan' => $pengguna->jabatan,
        ]);

        // Login the user using their email
        auth()->login($pengguna);

        // Redirect the user to the intended route after successful login
        return redirect()->intended(route('dashboard'));
    }

    public function render()
    {
        return view('livewire.auth');
    }
}
