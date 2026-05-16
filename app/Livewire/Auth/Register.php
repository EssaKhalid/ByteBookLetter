<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        Auth::login($user);

        session()->flash('success', 'Account successfully created!');
        session()->flash('welcome', "Welcome to ByteBookLetter, {$user->name}!");

        return redirect()->intended('/home');
     }


    public function render()
    {
        return view('livewire.auth.register');
    }
}
