<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Register extends Component
{
    #[Validate('required|min:3|max:32')]
    public $name = '';
    #[Validate('required|email|unique:users')]
    public $email = '';
    #[Validate('required|min:8')]
    public $password = '';
    public int $secondsRemaining = 0;


    public function register()
    {
        $key = 'register.' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $this->secondsRemaining = $seconds;
            $this->addError('email', "Spam protection: Please wait $seconds seconds.");
            return;
        }

        $this->validate();

        RateLimiter::hit($key);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        Auth::login($user);

        session()->flash('success', 'Account successfully created!');
        session()->flash('welcome', "Welcome to ByteBookLetter, {$user->name}!");

        return redirect()->intended('/feed');

    }


    public function render()
    {
        return view('livewire.auth.register');
    }
}
