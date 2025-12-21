<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Services\Auth\PasswordResetService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function __construct(
        private PasswordResetService $passwordResetService
    ) {}

    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(PasswordResetRequest $request): RedirectResponse
    {
        $this->passwordResetService->sendResetLink($request->validated()['email']);

        return back()->with('status', 'Se o e-mail estiver cadastrado em nossa base, você receberá um link para redefinir sua senha.');
    }
}
