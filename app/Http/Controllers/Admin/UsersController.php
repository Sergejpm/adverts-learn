<?php

namespace App\Http\Controllers\Admin;

use App\Entity\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::orderByDesc('id');

        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }

        if (!empty($value = $request->get('name'))) {
            $query->where('name', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('email'))) {
            $query->where('email', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }

        if (!empty($value = $request->get('role'))) {
            $query->where('role', $value);
        }

        $users = $query->paginate(20);

        $roles = [
            User::ROLE_USER => 'User',
            User::ROLE_ADMIN => 'Admin',
        ];

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $data['password'] = bcrypt(Str::random());

        $user = User::create($data);

        return redirect()->route('admin.users.show', $user);
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = [
            User::ROLE_USER => 'User',
            User::ROLE_ADMIN => 'Admin',
        ];

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,id,' . $user->id,
            'role' => ['required', 'string', Rule::in([
                User::ROLE_USER,
                User::ROLE_ADMIN,
            ])]
        ]);

        if ($request['role'] !== $user->role) {
            $user->changeRole($request['role']);
        }

        $user->update($data);

        return redirect()->route('admin.users.show', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index');
    }
}