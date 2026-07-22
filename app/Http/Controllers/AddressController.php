<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Lista todas las direcciones del usuario autenticado.
     */
    public function index()
    {
        $addresses = auth()->user()->addresses()->get();

        return response()->json($addresses);
    }

    /**
     * Muestra el formulario de creación (si usas Blade).
     * En APIs normalmente no se usa.
     */
    public function create()
    {
        return response()->json([
            'message' => 'Formulario de creación de dirección.'
        ]);
    }

    /**
     * Guarda una nueva dirección para el usuario autenticado.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'street' => 'required|string|max:255',
            'city'   => 'required|string|max:255',
            'state'  => 'nullable|string|max:255',
            'zip'    => 'nullable|string|max:20',
        ]);

        $address = auth()->user()->addresses()->create($validated);

        return response()->json([
            'message' => 'Dirección creada correctamente.',
            'address' => $address,
        ], 201);
    }

    /**
     * Muestra el formulario de edición (si usas Blade).
     */
    public function edit(Address $address)
    {
        $this->authorize('update', $address);

        return response()->json($address);
    }

    /**
     * Actualiza una dirección existente del usuario autenticado.
     */
    public function update(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $validated = $request->validate([
            'street' => 'required|string|max:255',
            'city'   => 'required|string|max:255',
            'state'  => 'nullable|string|max:255',
            'zip'    => 'nullable|string|max:20',
        ]);

        $address->update($validated);

        return response()->json([
            'message' => 'Dirección actualizada correctamente.',
            'address' => $address,
        ]);
    }

    /**
     * Elimina una dirección del usuario autenticado.
     */
    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);

        $address->delete();

        return response()->json([
            'message' => 'Dirección eliminada correctamente.',
        ]);
    }
}
