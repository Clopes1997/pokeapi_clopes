<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\PasswordConfirmationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    public function __construct(
        private PasswordConfirmationService $passwordConfirmationService
    ) {}

    public function show(): View
    {
        return view('auth.confirm-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->passwordConfirmationService->confirm(
            $request->user(),
            $request->password
        );

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
