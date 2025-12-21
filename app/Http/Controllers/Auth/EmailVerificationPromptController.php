<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\EmailVerificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    public function __construct(
        private EmailVerificationService $emailVerificationService
    ) {}

    public function __invoke(Request $request): RedirectResponse|View
    {
        return $this->emailVerificationService->promptResponse($request->user());
    }
}
