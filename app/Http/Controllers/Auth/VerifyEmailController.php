<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\EmailVerificationService;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    public function __construct(
        private EmailVerificationService $emailVerificationService
    ) {}

    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        return $this->emailVerificationService->verify($request);
    }
}
