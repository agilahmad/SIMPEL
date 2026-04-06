<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $this->authorize('viewAny', User::class);
        $users = User::latest()->paginate(10);
        $admin_count      = User::where('role', Role::Admin->value)->count();
        $programmer_count = User::where('role', Role::Programmer->value)->count();
        $user_count       = User::where('role', Role::User->value)->count();

        return view('user.index', compact(
            'users',
            'admin_count',
            'programmer_count',
            'user_count'
        ));
    }
    public function create(){
        $this->authorize('create', User::class);
        $roles = Role::cases();
        return view('user.create', compact('roles'));
    }
    public function store(StoreUserRequest $request){
        User::create($request->validated());
        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }
    public function edit(User $user){
        $this->authorize('update', $user);
        $roles = Role::cases();
        return view('user.edit', compact('user', 'roles'));
    }
    public function update(UpdateUserRequest $request, User $user){
        $user->update($request->validated());
        return redirect()->route('user.index')->with('success', 'User berhasil diupdate');
    }
    public function destroy(User $user){
        $this->authorize('delete', $user);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}
