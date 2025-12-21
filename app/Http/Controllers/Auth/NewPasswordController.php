<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\NewPasswordRequest;
use App\Services\Auth\PasswordUpdateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    public function __construct(
        private PasswordUpdateService $passwordUpdateService
    ) {}

    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    public function store(NewPasswordRequest $request): RedirectResponse
    {
        return $this->passwordUpdateService->resetPassword(
            $request->validated()['email'],
            $request->validated()['password'],
            $request->input('password_confirmation'),
            $request->validated()['token']
        );
    }
}
