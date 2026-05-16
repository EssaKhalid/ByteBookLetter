<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{

    #[Validate('required|email')]
    public $email = '';
    #[Validate('required|min:8')]
    public $password = '';

    public function login()
    {
        $this->validate();
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password]))
        {
            session()->regenerate();
            session()->flash('success', 'Successfully logged in! Welcome back.');
            return redirect()->intended('/home');
        }

        $this->addError('email', 'Invalid email or password.');
    }
    public function render()
    {
        return view('livewire.auth.login');
    }
}
