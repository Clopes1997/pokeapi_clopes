<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PasswordConfirmationService
{
    public function confirm(User $user, string $password): void
    {
        if (! Auth::guard('web')->validate([
            'username' => $user->username,
            'password' => $password,
        ])) {
            throw ValidationException::withMessages([
                'password' => 'Credenciais inválidas.',
            ]);
        }
    }
}

