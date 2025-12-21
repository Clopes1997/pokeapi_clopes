<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\Profile\DeleteAccountRequest;
use App\Services\Profile\AccountDeletionService;
use App\Services\Profile\ProfileUpdateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        private ProfileUpdateService $profileUpdateService,
        private AccountDeletionService $accountDeletionService
    ) {}

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $this->profileUpdateService->update(
            $request->user(),
            $request->validated()
        );

        return $this->profileUpdateService->updateResponse($request, $request->user());
    }

    public function destroy(DeleteAccountRequest $request): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $this->accountDeletionService->delete($request->user());

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->accountDeletionService->deleteResponse($request);
    }
}
