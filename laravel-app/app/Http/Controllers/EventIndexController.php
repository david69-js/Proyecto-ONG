<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventIndexController extends Controller
{
    // Mostrar todos los eventos
    public function edit()
    {
        $events = Event::all();
        return view('sections.events.index', compact('events'));
    }

    // Publicar o despublicar en el index
    public function toggleIndex(Event $event)
    {
        $event->show_in_index = !$event->show_in_index;
        $event->save();

        return redirect()->back()->with('success', "El evento '{$event->title}' ha sido " . ($event->show_in_index ? 'publicado' : 'despublicado') . " en el index.");
    }

    // Destacar o quitar destacado
    public function toggleFeatured(Event $event)
    {
        $event->featured = !$event->featured;
        $event->save();

        return redirect()->back()->with('success', "El evento '{$event->title}' ha sido " . ($event->featured ? 'marcado como destacado' : 'quitado de destacado') . ".");
    }
}