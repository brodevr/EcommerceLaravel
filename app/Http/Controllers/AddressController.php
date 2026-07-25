<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = auth()->user()->addresses()->get();

        return view('direcciones.index', compact('addresses'));
    }

    public function create()
    {
        return view('direcciones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient'   => ['required', 'string', 'max:255'],
            'label'       => ['nullable', 'string', 'max:100'],
            'street'      => ['required', 'string', 'max:255'],
            'city'        => ['required', 'string', 'max:255'],
            'state'       => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'phone'       => ['nullable', 'string', 'max:30'],
            'is_default'  => ['boolean'],
        ]);

        $validated['is_default'] = $request->boolean('is_default');

        if ($validated['is_default']) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        auth()->user()->addresses()->create($validated);

        return redirect()->route('direcciones.index')
                         ->with('success', 'Dirección agregada correctamente.');
    }

    public function edit(Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        return view('direcciones.edit', compact('address'));
    }

    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'recipient'   => ['required', 'string', 'max:255'],
            'label'       => ['nullable', 'string', 'max:100'],
            'street'      => ['required', 'string', 'max:255'],
            'city'        => ['required', 'string', 'max:255'],
            'state'       => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'phone'       => ['nullable', 'string', 'max:30'],
            'is_default'  => ['boolean'],
        ]);

        $validated['is_default'] = $request->boolean('is_default');

        if ($validated['is_default']) {
            auth()->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('direcciones.index')
                         ->with('success', 'Dirección actualizada correctamente.');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $address->delete();

        return redirect()->route('direcciones.index')
                         ->with('success', 'Dirección eliminada.');
    }
}
