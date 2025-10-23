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
     * Listado + panel admin en una sola vista
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

        $events = $query->paginate(12)->withQueryString();

        // Datos para filtros (nota: tu tabla de proyectos es ng_projects)
        $projects = Project::where('estado', '!=', 'completado')->get();

        $eventTypes = [
            'fundraising' => 'Recaudación de Fondos',
            'volunteer'   => 'Voluntariado',
            'awareness'   => 'Concientización',
            'community'   => 'Comunitario',
            'training'    => 'Capacitación',
            'other'       => 'Otro',
        ];

        $eventStatuses = [
            'all'       => 'Todos',
            'upcoming'  => 'Próximos',
            'past'      => 'Pasados',
            'draft'     => 'Borrador',
            'published' => 'Publicado',
            'cancelled' => 'Cancelado',
            'completed' => 'Completado',
        ];

        // Detectar si es ruta events-admin
        $isEventsAdminRoute = request()->routeIs('admin.events-admin.*');
        $viewName = $isEventsAdminRoute ? 'events-admin.index' : 'sections.events.index';
        
        return view($viewName, compact('events', 'projects', 'eventTypes', 'eventStatuses'));
    }

    /**
     * Crear (desde la misma vista index)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'                  => 'required|string|max:255',
            'description'            => 'nullable|string',
            'event_type'             => 'required|in:fundraising,volunteer,awareness,community,training,other',
            'start_date'             => 'required|date|after:now',
            'end_date'               => 'nullable|date|after:start_date',
            'location'               => 'nullable|string|max:255',
            'address'                => 'nullable|string',
            'max_participants'       => 'nullable|integer|min:1',
            'registration_required'  => 'boolean',
            'registration_deadline'  => 'nullable|date|after:now|before:start_date',
            'cost'                   => 'nullable|numeric|min:0',
            'contact_email'          => 'nullable|email',
            'contact_phone'          => 'nullable|string|max:20',
            'requirements'           => 'nullable|string',
            'project_id'             => 'nullable|exists:ng_projects,id', // <--
            'image'                  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status'                 => 'nullable|in:draft,published,cancelled,completed',
            'featured'               => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();
        $data['featured'] = (bool)($data['featured'] ?? false);
        $data['registration_required'] = (bool)($data['registration_required'] ?? false);

        if ($request->hasFile('image')) {
            $filename = Str::slug($request->title) . '_' . time() . '.' . $request->file('image')->extension();
            $data['image_path'] = $request->file('image')->storeAs('events', $filename, 'public');
        }

        Event::create($data);

        cache()->forget('home:events');

        return back()->with('success', 'Evento creado exitosamente.');
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $projects = Project::where('estado', '!=', 'completado')->get();
        
        $eventTypes = [
            'fundraising' => 'Recaudación de Fondos',
            'volunteer'   => 'Voluntariado',
            'awareness'   => 'Concientización',
            'community'   => 'Comunitario',
            'training'    => 'Capacitación',
            'other'       => 'Otro',
        ];

        $eventStatuses = [
            'draft'     => 'Borrador',
            'published' => 'Publicado',
            'cancelled' => 'Cancelado',
            'completed' => 'Completado',
        ];

        // Detectar si es ruta events-admin
        $isEventsAdminRoute = request()->routeIs('admin.events-admin.*');
        $viewName = $isEventsAdminRoute ? 'events-admin.create' : 'events.create';
        
        return view($viewName, compact('projects', 'eventTypes', 'eventStatuses'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Event $event)
    {
        $event->load(['creator', 'project']);
        
        $projects = Project::where('estado', '!=', 'completado')->get();
        
        $eventTypes = [
            'fundraising' => 'Recaudación de Fondos',
            'volunteer'   => 'Voluntariado',
            'awareness'   => 'Concientización',
            'community'   => 'Comunitario',
            'training'    => 'Capacitación',
            'other'       => 'Otro',
        ];

        $eventStatuses = [
            'draft'     => 'Borrador',
            'published' => 'Publicado',
            'cancelled' => 'Cancelado',
            'completed' => 'Completado',
        ];

        // Detectar si es ruta events-admin
        $isEventsAdminRoute = request()->routeIs('admin.events-admin.*');
        $viewName = $isEventsAdminRoute ? 'events-admin.edit' : 'events.edit';
        
        return view($viewName, compact('event', 'projects', 'eventTypes', 'eventStatuses'));
    }

    /**
     * Mostrar detalle público (si lo usas)
     */
    public function show(Event $event)
    {
        $event->load(['creator', 'project', 'registrations']);
        
        // Detectar si es ruta events-admin
        $isEventsAdminRoute = request()->routeIs('admin.events-admin.*');
        $viewName = $isEventsAdminRoute ? 'events-admin.show' : 'events.show';
        
        return view($viewName, compact('event'));
    }

    /**
     * Actualizar (desde modal/inline en la misma vista)
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title'                  => 'required|string|max:255',
            'description'            => 'nullable|string',
            'event_type'             => 'required|in:fundraising,volunteer,awareness,community,training,other',
            'start_date'             => 'required|date',
            'end_date'               => 'nullable|date|after:start_date',
            'location'               => 'nullable|string|max:255',
            'address'                => 'nullable|string',
            'max_participants'       => 'nullable|integer|min:1',
            'registration_required'  => 'boolean',
            'registration_deadline'  => 'nullable|date|before:start_date',
            'cost'                   => 'nullable|numeric|min:0',
            'contact_email'          => 'nullable|email',
            'contact_phone'          => 'nullable|string|max:20',
            'requirements'           => 'nullable|string',
            'project_id'             => 'nullable|exists:ng_projects,id', // <--
            'image'                  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status'                 => 'nullable|in:draft,published,cancelled,completed',
            'featured'               => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['featured'] = (bool)($data['featured'] ?? false);
        $data['registration_required'] = (bool)($data['registration_required'] ?? false);

        if ($request->hasFile('image')) {
            if ($event->image_path) {
                Storage::disk('public')->delete($event->image_path);
            }
            $filename = Str::slug($request->title) . '_' . time() . '.' . $request->file('image')->extension();
            $data['image_path'] = $request->file('image')->storeAs('events', $filename, 'public');
        }

        $event->update($data);

        cache()->forget('home:events');

        return back()->with('success', 'Evento actualizado exitosamente.');
    }

    /**
     * Eliminar
     */
    public function destroy(Event $event)
    {
        if ($event->image_path) {
            Storage::disk('public')->delete($event->image_path);
        }

        $event->delete();

        cache()->forget('home:events');

        return back()->with('success', 'Evento eliminado exitosamente.');
    }

    /**
     * Toggle destacado
     */
    public function toggleFeatured(Event $event)
    {
        $event->update(['featured' => !$event->featured]);

        cache()->forget('home:events');

        $status = $event->featured ? 'destacado' : 'removido de destacados';
        return back()->with('success', "Evento {$status} exitosamente.");
    }

    /**
     * Cambiar estado (publicar / despublicar / cancelar / completar)
     */
    public function changeStatus(Request $request, Event $event)
    {
        $request->validate([
            'status' => 'required|in:draft,published,cancelled,completed'
        ]);

        $event->update(['status' => $request->status]);

        cache()->forget('home:events');

        return back()->with('success', 'Estado del evento actualizado exitosamente.');
    }

    /**
     * Registro a evento (público)
     */
    public function register(Request $request, Event $event)
    {
        if (!$event->is_registration_open) {
            return back()->with('error', 'El registro para este evento no está disponible.');
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $exists = $event->registrations()
            ->where('email', $request->email)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($exists) {
            return back()->with('error', 'Ya estás registrado en este evento.');
        }

        EventRegistration::create([
            'event_id' => $event->id,
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'notes'    => $request->notes,
        ]);

        $event->updateParticipantsCount();

        return back()->with('success', 'Te has registrado exitosamente en el evento.');
    }

    /**
     * Actualizar estado de un registro
     */
    public function updateRegistrationStatus(Request $request, EventRegistration $registration)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        $registration->update(['status' => $request->status]);
        $registration->event->updateParticipantsCount();

        return back()->with('success', 'Estado del registro actualizado exitosamente.');
    }

    /**
     * Eliminar registro
     */
    public function deleteRegistration(EventRegistration $registration)
    {
        $registration->delete();
        $registration->event->updateParticipantsCount();

        return back()->with('success', 'Registro eliminado exitosamente.');
    }
    public function showPublic(Event $event)
{
    // Solo mostrar eventos publicados
    if ($event->status !== 'published') {
        abort(404);
    }

    $event->load(['creator', 'project']); // Relaciones útiles
    return view('events.public_show', compact('event'));
}

    /**
     * Mostrar reportes de eventos
     */
    public function reports(Request $request)
    {
        $query = Event::with(['creator', 'project', 'registrations']);

        // Filtros para reportes
        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('start_date', '<=', $request->date_to);
        }

        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $events = $query->orderBy('start_date', 'desc')->get();

        // Estadísticas
        $totalEvents = $events->count();
        $publishedEvents = $events->where('status', 'published')->count();
        $draftEvents = $events->where('status', 'draft')->count();
        $cancelledEvents = $events->where('status', 'cancelled')->count();
        $completedEvents = $events->where('status', 'completed')->count();

        // Eventos por tipo
        $eventsByType = $events->groupBy('event_type')->map->count();

        // Eventos por mes
        $eventsByMonth = $events->groupBy(function($event) {
            return $event->start_date->format('Y-m');
        })->map->count();

        // Total de registros
        $totalRegistrations = $events->sum(function($event) {
            return $event->registrations->count();
        });

        $eventTypes = [
            'fundraising' => 'Recaudación de Fondos',
            'volunteer'   => 'Voluntariado',
            'awareness'   => 'Concientización',
            'community'   => 'Comunitario',
            'training'    => 'Capacitación',
            'other'       => 'Otro',
        ];

        $eventStatuses = [
            'all'       => 'Todos',
            'draft'     => 'Borrador',
            'published' => 'Publicado',
            'cancelled' => 'Cancelado',
            'completed' => 'Completado',
        ];

        // Detectar si es ruta events-admin
        $isEventsAdminRoute = request()->routeIs('admin.events-admin.*');
        $viewName = $isEventsAdminRoute ? 'events-admin.reports' : 'events.reports';
        
        return view($viewName, compact(
            'events', 
            'totalEvents', 
            'publishedEvents', 
            'draftEvents', 
            'cancelledEvents', 
            'completedEvents',
            'eventsByType',
            'eventsByMonth',
            'totalRegistrations',
            'eventTypes',
            'eventStatuses'
        ));
    }
    public function publicShow(Event $event)
{
    return view('events.public-show', compact('event'));
}

}
