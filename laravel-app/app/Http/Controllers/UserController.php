<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::with(['profile', 'roles']);

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
        $roles = Role::active()->ordered()->get();

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::active()->ordered()->get();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:sys_users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:5|confirmed',
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

        DB::transaction(function () use ($request) {
            // Create user
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
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
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load(['profile', 'roles.permissions']);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $user->load(['profile', 'roles']);
        $roles = Role::active()->ordered()->get();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('sys_users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:5|confirmed'
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

        DB::transaction(function () use ($request, $user) {
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

            // Update roles
            $user->roles()->sync($request->roles, [
                'assigned_at' => now(),
                'assigned_by' => auth()->id(),
            ]);
        });

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting the last admin
        if ($user->hasRole('super_admin') && Role::where('slug', 'super_admin')->first()->users()->count() <= 1) {
            return redirect()->route('users.index')
                ->with('error', 'Cannot delete the last super administrator.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle user active status.
     */
    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        return redirect()->route('users.index')
            ->with('success', "User {$status} successfully.");
    }

    /**
     * Show user permissions management.
     */
    public function permissions(User $user)
    {
        $user->load(['roles.permissions', 'permissions']);
        $permissions = Permission::active()->ordered()->get()->groupBy('module');
        return view('users.permissions', compact('user', 'permissions'));
    }

    /**
     * Update user permissions.
     */
    public function updatePermissions(Request $request, User $user)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:cfg_permissions,id',
        ]);

        $permissions = $request->permissions ?? [];
        
        // Sync permissions (this will remove all existing and add new ones)
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
            ->with('success', 'User permissions updated successfully.');
    }
}
