<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::with(['creator', 'project']);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'upcoming':
                    $query->upcoming();
                    break;
                case 'past':
                    $query->past();
                    break;
                case 'this_month':
                    $query->whereMonth('start_date', now()->month)
                          ->whereYear('start_date', now()->year);
                    break;
            }
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'start_date');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $events = $query->paginate(12);

        // Obtener datos para filtros
        $projects = Project::where('estado', '!=', 'finalizado')->get();
        $eventTypes = [
            'fundraising' => 'Recaudación de Fondos',
            'volunteer' => 'Voluntariado',
            'awareness' => 'Concientización',
            'community' => 'Comunitario',
            'training' => 'Capacitación',
            'other' => 'Otro',
        ];
        $eventStatuses = [
            'all' => 'Todos',
            'upcoming' => 'Próximos',
            'past' => 'Pasados',
            'draft' => 'Borrador',
            'published' => 'Publicado',
            'cancelled' => 'Cancelado',
            'completed' => 'Completado',
        ];

        return view('events.index', compact('events', 'projects', 'eventTypes', 'eventStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::where('estado', '!=', 'finalizado')->get();
        $eventTypes = [
            'fundraising' => 'Recaudación de Fondos',
            'volunteer' => 'Voluntariado',
            'awareness' => 'Concientización',
            'community' => 'Comunitario',
            'training' => 'Capacitación',
            'other' => 'Otro',
        ];
        $eventStatuses = [
            'draft' => 'Borrador',
            'published' => 'Publicado',
            'cancelled' => 'Cancelado',
            'completed' => 'Completado',
        ];
        return view('events.create', compact('projects', 'eventTypes', 'eventStatuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_type' => 'required|in:fundraising,volunteer,awareness,community,training,other',
            'start_date' => 'required|date|after:now',
            'end_date' => 'nullable|date|after:start_date',
            'location' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'max_participants' => 'nullable|integer|min:1',
            'registration_required' => 'boolean',
            'registration_deadline' => 'nullable|date|after:now|before:start_date',
            'cost' => 'nullable|numeric|min:0',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'requirements' => 'nullable|string',
            'project_id' => 'nullable|exists:ng_projects,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        // Manejar imagen
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = Str::slug($request->title) . '_' . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('events', $filename, 'public');
            $data['image_path'] = $path;
        }

        Event::create($data);

        return redirect()->route('events.index')
                         ->with('success', 'Evento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load(['creator', 'project', 'registrations']);
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $projects = Project::where('estado', '!=', 'finalizado')->get();
        $eventTypes = [
            'fundraising' => 'Recaudación de Fondos',
            'volunteer' => 'Voluntariado',
            'awareness' => 'Concientización',
            'community' => 'Comunitario',
            'training' => 'Capacitación',
            'other' => 'Otro',
        ];
        $eventStatuses = [
            'draft' => 'Borrador',
            'published' => 'Publicado',
            'cancelled' => 'Cancelado',
            'completed' => 'Completado',
        ];
        return view('events.edit', compact('event', 'projects', 'eventTypes', 'eventStatuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_type' => 'required|in:fundraising,volunteer,awareness,community,training,other',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'location' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'max_participants' => 'nullable|integer|min:1',
            'registration_required' => 'boolean',
            'registration_deadline' => 'nullable|date|before:start_date',
            'cost' => 'nullable|numeric|min:0',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'requirements' => 'nullable|string',
            'project_id' => 'nullable|exists:ng_projects,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Manejar imagen
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior
            if ($event->image_path) {
                Storage::disk('public')->delete($event->image_path);
            }
            
            $image = $request->file('image');
            $filename = Str::slug($request->title) . '_' . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('events', $filename, 'public');
            $data['image_path'] = $path;
        }

        $event->update($data);

        return redirect()->route('events.index')
                         ->with('success', 'Evento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Eliminar imagen si existe
        if ($event->image_path) {
            Storage::disk('public')->delete($event->image_path);
        }

        $event->delete();

        return redirect()->route('events.index')
                         ->with('success', 'Evento eliminado exitosamente.');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Event $event)
    {
        $event->update(['featured' => !$event->featured]);
        
        $status = $event->featured ? 'destacado' : 'removido de destacados';
        return redirect()->back()
                         ->with('success', "Evento {$status} exitosamente.");
    }

    /**
     * Change status
     */
    public function changeStatus(Request $request, Event $event)
    {
        $request->validate([
            'status' => 'required|in:draft,published,cancelled,completed'
        ]);

        $event->update(['status' => $request->status]);
        
        return redirect()->back()
                         ->with('success', 'Estado del evento actualizado exitosamente.');
    }

    /**
     * Register for event
     */
    public function register(Request $request, Event $event)
    {
        if (!$event->is_registration_open) {
            return redirect()->back()
                             ->with('error', 'El registro para este evento no está disponible.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        // Verificar si ya está registrado
        $existingRegistration = $event->registrations()
                                    ->where('email', $request->email)
                                    ->where('status', '!=', 'cancelled')
                                    ->first();

        if ($existingRegistration) {
            return redirect()->back()
                             ->with('error', 'Ya estás registrado en este evento.');
        }

        EventRegistration::create([
            'event_id' => $event->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'notes' => $request->notes,
        ]);

        // Actualizar contador de participantes
        $event->updateParticipantsCount();

        return redirect()->back()
                         ->with('success', 'Te has registrado exitosamente en el evento.');
    }

    /**
     * Update registration status
     */
    public function updateRegistrationStatus(Request $request, EventRegistration $registration)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        $registration->update(['status' => $request->status]);
        
        // Actualizar contador de participantes del evento
        $registration->event->updateParticipantsCount();

        return redirect()->back()
                         ->with('success', 'Estado del registro actualizado exitosamente.');
    }

    /**
     * Delete registration
     */
    public function deleteRegistration(EventRegistration $registration)
    {
        $registration->delete();
        
        // Actualizar contador de participantes del evento
        $registration->event->updateParticipantsCount();

        return redirect()->back()
                         ->with('success', 'Registro eliminado exitosamente.');
    }
}
