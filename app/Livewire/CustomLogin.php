<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class CustomLogin extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;
    
    protected $rules = [
        'email' => ['required', 'email'],
        'password' => ['required'],
    ];
    public function mount()
    {
        // If the user is already authenticated, redirect to home page
        if (Auth::check()) {
            return redirect('/');
        }
    }
    
    public function authenticate()
    {
        $this->validate();

        if (! Filament::auth()->attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remember)) {
            $this->addError('email', __('filament::login.messages.failed'));
            
            return;
        }

        // Redirect to Filament dashboard after successful login
        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.custom-login')
            ->layout('layouts.guest');
    }
}