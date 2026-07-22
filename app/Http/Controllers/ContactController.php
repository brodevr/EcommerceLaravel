<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;

class ContactController extends Controller
{
    /**
     * Muestra el formulario de contacto.
     * En una API normalmente no se usa, pero lo dejamos por compatibilidad.
     */
    public function create()
    {
        return response()->json([
            'message' => 'Formulario de contacto disponible.'
        ]);
    }

    /**
     * Guarda el mensaje enviado desde el formulario de contacto.
     */
    public function store(StoreContactRequest $request)
    {
        $contact = Contact::create([
            'name'    => $request->input('name'),
            'email'   => $request->input('email'),
            'message' => $request->input('message'),
        ]);

        return response()->json([
            'message' => 'Mensaje enviado correctamente.',
            'contact' => $contact,
        ], 201);
    }

    /**
     * Zona admin: listado de mensajes recibidos.
     * Protegido por middleware EnsureUserIsAdmin.
     */
    public function index()
    {
        $contacts = Contact::latest()->get();

        return response()->json($contacts);
    }

    /**
     * Zona admin: detalle de un mensaje.
     * Protegido por middleware EnsureUserIsAdmin.
     */
    public function show(Contact $contact)
    {
        return response()->json($contact);
    }

    /**
     * Zona admin: eliminar un mensaje.
     * Protegido por middleware EnsureUserIsAdmin.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->json([
            'message' => 'Mensaje eliminado correctamente.'
        ]);
    }
}
