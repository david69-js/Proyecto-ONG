<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        // Verificar autorización usando policy
        $this->authorize('viewAny', User::class);

        $query = User::with(['profile', 'roles']);

        // Filtrar según el rol del usuario autenticado
        $currentUser = auth()->user();
        
        // Si no es super-admin, filtrar usuarios que puede ver
        if (!$currentUser->hasRole('super-admin')) {
            // Admin no puede ver super-admins
            if ($currentUser->hasRole('admin')) {
                $query->whereDoesntHave('roles', function ($q) {
                    $q->where('slug', 'super-admin');
                });
            }
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('slug', $request->role);
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $users = $query->latest()->paginate(15);
        
        // Obtener roles disponibles (excluyendo super-admin si no es super-admin)
        $roles = Role::active()->ordered();
        if (!$currentUser->hasRole('super-admin')) {
            $roles->where('slug', '!=', 'super-admin');
        }
        $roles = $roles->get();

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $this->authorize('create', User::class);

        // Obtener roles disponibles
        $roles = $this->getAvailableRoles();
        
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:sys_users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:5|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:cfg_roles,id',
            'is_active' => 'boolean',
            'is_verified' => 'boolean',
            
            // Profile fields
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other,prefer_not_to_say',
            'bio' => 'nullable|string|max:500',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relationship' => 'nullable|string|max:100',
        ]);

        // Verificar que no intente crear super-admin si no lo es
        $selectedRoles = Role::whereIn('id', $request->roles)->get();
        if ($selectedRoles->contains('slug', 'super-admin') && !auth()->user()->hasRole('super-admin')) {
            return back()->with('error', 'No tienes permiso para crear usuarios con el rol de Super Admin.')
                        ->withInput();
        }

        DB::transaction(function () use ($request) {
            // Handle avatar upload
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('users/avatars', 'public');
            }

            // Create user
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'avatar' => $avatarPath,
                'is_active' => $request->boolean('is_active', true),
                'is_verified' => $request->boolean('is_verified', false),
            ]);

            // Create profile
            $user->profile()->create([
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'bio' => $request->bio,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'emergency_contact_relationship' => $request->emergency_contact_relationship,
            ]);

            // Assign roles
            $user->roles()->attach($request->roles, [
                'assigned_at' => now(),
                'assigned_by' => auth()->id(),
            ]);
        });

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        $user->load(['profile', 'roles.permissions']);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $user->load(['profile', 'roles']);
        $roles = $this->getAvailableRoles();
        
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validationRules = [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('sys_users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:cfg_roles,id',
            'is_active' => 'boolean',
            'is_verified' => 'boolean',
            
            // Profile fields
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other,prefer_not_to_say',
            'bio' => 'nullable|string|max:500',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relationship' => 'nullable|string|max:100',
        ];

        // Solo validar contraseña si se proporciona
        if ($request->filled('password')) {
            $validationRules['password'] = 'required|min:5|confirmed';
        }

        $request->validate($validationRules);

        // Verificar restricciones de rol
        if ($user->hasRole('super-admin') && !auth()->user()->hasRole('super-admin')) {
            return back()->with('error', 'No puedes modificar un usuario con el rol de Super Admin.')
                        ->withInput();
        }

        $selectedRoles = Role::whereIn('id', $request->roles)->get();
        if ($selectedRoles->contains('slug', 'super-admin') && !auth()->user()->hasRole('super-admin')) {
            return back()->with('error', 'No puedes asignar el rol de Super Admin.')
                        ->withInput();
        }

        DB::transaction(function () use ($request, $user) {
            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $avatarPath = $request->file('avatar')->store('users/avatars', 'public');
            }

            // Update user
            $userData = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'is_active' => $request->boolean('is_active'),
                'is_verified' => $request->boolean('is_verified'),
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            if (isset($avatarPath)) {
                $userData['avatar'] = $avatarPath;
            }

            $user->update($userData);

            // Update or create profile
            $profileData = [
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'bio' => $request->bio,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'emergency_contact_relationship' => $request->emergency_contact_relationship,
            ];

            if ($user->profile) {
                $user->profile->update($profileData);
            } else {
                $user->profile()->create($profileData);
            }

            // Update roles - remove old ones assigned by current user and add new ones
            $user->roles()->sync($request->roles, [
                'assigned_at' => now(),
                'assigned_by' => auth()->id(),
            ]);
        });

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        // No se puede eliminar a sí mismo
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        // Prevent deleting the last super-admin
        if ($user->hasRole('super-admin')) {
            $superAdminRole = Role::where('slug', 'super-admin')->first();
            if ($superAdminRole && $superAdminRole->users()->count() <= 1) {
                return redirect()->route('users.index')
                    ->with('error', 'No se puede eliminar el último Super Administrador del sistema.');
            }
        }

        // Delete avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }

    /**
     * Toggle user active status.
     */
    public function toggleStatus(User $user)
    {
        $this->authorize('update', $user);

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activado' : 'desactivado';
        return redirect()->route('users.index')
            ->with('success', "Usuario {$status} exitosamente.");
    }

    /**
     * Show user permissions management.
     */
    public function permissions(User $user)
    {
        $this->authorize('update', $user);

        $user->load(['roles.permissions', 'permissions']);
        $permissions = Permission::active()->ordered()->get()->groupBy('module');
        return view('users.permissions', compact('user', 'permissions'));
    }

    /**
     * Update user permissions.
     */
    public function updatePermissions(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:cfg_permissions,id',
        ]);

        $permissions = $request->permissions ?? [];
        
        // Sync permissions
        $user->permissions()->sync(
            collect($permissions)->mapWithKeys(function ($permissionId) {
                return [$permissionId => [
                    'is_granted' => true,
                    'granted_at' => now(),
                    'granted_by' => auth()->id(),
                ]];
            })
        );

        return redirect()->route('users.permissions', $user)
            ->with('success', 'Permisos del usuario actualizados exitosamente.');
    }

    /**
     * Delete user avatar.
     */
    public function deleteAvatar(User $user)
    {
        $this->authorize('update', $user);

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);

            return response()->json([
                'success' => true,
                'message' => 'Avatar eliminado correctamente'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No hay avatar para eliminar'
        ], 404);
    }

    /**
     * Get available roles based on current user permissions.
     */
    private function getAvailableRoles()
    {
        $roles = Role::active()->ordered();
        
        // Si no es super-admin, no puede ver/asignar el rol de super-admin
        if (!auth()->user()->hasRole('super-admin')) {
            $roles->where('slug', '!=', 'super-admin');
        }
        
        return $roles->get();
    }
}