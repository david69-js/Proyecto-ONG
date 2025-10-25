<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    /**
     * Mostrar todos los mensajes de contacto
     */
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.contact-messages.index', compact('messages'));
    }

    /**
     * Mostrar un mensaje específico
     */
    public function show(ContactMessage $message)
    {
        // Marcar como leído
        $message->update(['is_read' => true]);
        return view('admin.contact-messages.show', compact('message'));
    }

    /**
     * Marcar mensaje como leído
     */
    public function markAsRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    /**
     * Eliminar mensaje
     */
    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->back()->with('success', 'Mensaje eliminado correctamente');
    }
}
