<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function users(): View
    {
        Gate::authorize('admin');

        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('admin.users', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function updateUserRole(Request $request, int $userId): RedirectResponse
    {
        Gate::authorize('admin');

        $user = User::findOrFail($userId);
        $roleId = $request->input('role_id');

        $user->roles()->sync([$roleId]);

        return redirect()->route('admin.users')->with('success', 'Função do usuário atualizada com sucesso');
    }
}

