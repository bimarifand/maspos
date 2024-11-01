<?php

namespace App\Filament\Pages\Auth;
use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;

class Login extends BaseLogin
{

    public function form(Form $form): Form
    {
    return $form
            ->schema([
                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->autocomplete()
                    ->placeholder('Enter your email')
                    ->extraAttributes(['class' => 'custom-input']),
                    
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->placeholder('Enter your password')
                    ->extraAttributes(['class' => 'custom-input']),
            ])
            ->statePath('data');
    }

    protected function hasFullWidthFormContainer(): bool
    {
        return true;
    }

    public function getView(): string 
    {
        return 'vendor.filament-panels.pages.auth.login';
    }
}