<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{

    #[Validate('required|email')]
    public $email = '';
    #[Validate('required|min:8')]
    public $password = '';
    public int $secondsRemaining = 0;
    public function login()
    {
        $this->validate();

        $key = 'login.' . $this->email . '|' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->secondsRemaining = $seconds; // This line assigns the time to your public property
            $this->addError('email', "Too many attempts. Please wait $seconds seconds.");
            return;
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            RateLimiter::clear($key);
            session()->regenerate();
            session()->flash('success', 'Successfully logged in! Welcome back.');
            return redirect()->intended('/feed');
        }

        RateLimiter::hit($key); // Record a "Strike" against this user/IP
        $this->addError('email', 'Invalid email or password.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
