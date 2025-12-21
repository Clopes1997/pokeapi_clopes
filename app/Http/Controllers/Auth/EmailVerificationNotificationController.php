<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\EmailVerificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    public function __construct(
        private EmailVerificationService $emailVerificationService
    ) {}

    public function store(Request $request): RedirectResponse
    {
        return $this->emailVerificationService->sendNotification($request->user());
    }
}
