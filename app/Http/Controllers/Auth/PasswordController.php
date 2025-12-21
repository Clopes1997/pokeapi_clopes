<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Services\Auth\PasswordUpdateService;
use Illuminate\Http\RedirectResponse;

class PasswordController extends Controller
{
    public function __construct(
        private PasswordUpdateService $passwordUpdateService
    ) {}

    public function update(UpdatePasswordRequest $request): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        $this->passwordUpdateService->updatePassword(
            $request->user(),
            $validated['password']
        );

        return $this->passwordUpdateService->updatePasswordResponse($request);
    }
}
