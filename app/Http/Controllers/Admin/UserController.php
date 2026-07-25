<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::latest();

        if ($buscar = $request->get('buscar')) {
            $query->where(function ($q) use ($buscar) {
                $q->where('name', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%");
            });
        }

        if ($rol = $request->get('rol')) {
            $query->where('role', $rol);
        }

        $usuarios = $query->paginate(20)->withQueryString();

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function edit(User $user)
    {
        return view('admin.usuarios.edit', ['usuario' => $user]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        if (auth()->id() === $user->id && $request->role !== Role::Admin->value) {
            return back()->with('error', 'No podés quitarte el rol de administrador a vos mismo.');
        }

        $user->update($request->validated());

        return redirect()->route('admin.usuarios.index')
                         ->with('success', "Usuario {$user->name} actualizado correctamente.");
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'No podés eliminar tu propia cuenta desde el panel.');
        }

        $nombre = $user->name;
        $user->delete();

        return redirect()->route('admin.usuarios.index')
                         ->with('success', "Usuario {$nombre} eliminado.");
    }
}
