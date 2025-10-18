<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'sys_users';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'avatar',
        'is_active',
        'is_verified',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
    ];

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's profile.
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get the user's beneficiary record.
     */
    public function beneficiary()
    {
        return $this->hasOne(Beneficiary::class);
    }

    /**
     * Get the projects assigned to this user.
     */
    public function assignedProjects()
    {
        return $this->belongsToMany(Project::class, 'rel_project_assignments')
                    ->withPivot('role_in_project', 'assigned_at', 'assigned_by')
                    ->withTimestamps();
    }

    /**
     * Get the user's roles.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'rel_user_roles')
                    ->withPivot('assigned_at', 'assigned_by')
                    ->withTimestamps();
    }

    /**
     * Get the user's permissions.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'rel_user_permissions')
                    ->withPivot('is_granted', 'granted_at', 'granted_by')
                    ->withTimestamps();
    }

    /**
     * Get all permissions for the user (through roles and direct assignments).
     */
    public function getAllPermissions()
    {
        $rolePermissions = $this->roles()
            ->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->unique('id');

        $directPermissions = $this->permissions()
            ->wherePivot('is_granted', true)
            ->get();

        return $rolePermissions->merge($directPermissions)->unique('id');
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return $this->roles()->where('slug', $role)->exists();
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->roles()->whereIn('slug', $roles)->exists();
    }

    /**
     * Check if user has a specific permission.
     */
    public function hasPermission(string $permission): bool
    {
        // Check direct permissions
        $hasDirectPermission = $this->permissions()
            ->where('slug', $permission)
            ->wherePivot('is_granted', true)
            ->exists();

        if ($hasDirectPermission) {
            return true;
        }

        // Check role permissions
        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permission) {
                $query->where('slug', $permission);
            })
            ->exists();
    }

    /**
     * Check if user has any of the given permissions.
     */
    public function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Assign a role to the user.
     */
    public function assignRole(string $roleSlug, ?int $assignedBy = null): void
    {
        $role = Role::where('slug', $roleSlug)->first();
        if ($role && !$this->hasRole($roleSlug)) {
            $this->roles()->attach($role->id, [
                'assigned_by' => $assignedBy,
                'assigned_at' => now(),
            ]);
        }
    }

    /**
     * Remove a role from the user.
     */
    public function removeRole(string $roleSlug): void
    {
        $role = Role::where('slug', $roleSlug)->first();
        if ($role) {
            $this->roles()->detach($role->id);
        }
    }

    /**
     * Scope to get only active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get only verified users.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
}