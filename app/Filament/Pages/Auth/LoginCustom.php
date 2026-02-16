<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginCustom extends Login
{
  public function form(Schema $schema): Schema
  {
    return $schema
      ->statePath('data')
      ->components([
        TextInput::make('username')
          ->label('Username')
          ->required()
          ->validationMessages([
            'required' => 'Username wajib diisi.',
          ])
          ->autocomplete('off')
          ->autofocus(),

        TextInput::make('password')
          ->label('Password')
          ->password()
          ->revealable()
          ->required()
          ->validationMessages([
            'required' => 'Password wajib diisi.',
          ]),
      ]);
  }

  public function authenticate(): ?LoginResponse
  {
    $data = $this->form->getState();

    $user = User::where('username', $data['username'])->first();

    if (! $user) {
      throw ValidationException::withMessages([
        'data.username' => 'Username tidak ditemukan.',
      ]);
    }

    if (! Hash::check($data['password'], $user->password)) {
      throw ValidationException::withMessages([
        'data.password' => 'Password salah.',
      ]);
    }

    Filament::auth()->login($user);
    session()->regenerate();

    return app(LoginResponse::class);
  }

  public function getHeading(): string
  {
    return 'Selamat Datang';
  }

  public function getSubheading(): ?string
  {
    return 'Silahkan login dengan akun anda';
  }
}
