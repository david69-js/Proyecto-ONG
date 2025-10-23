<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determine if the user can view any ng_projects.
     */
    public function viewAny(User $user): bool
    {
        // Super admin y admin pueden ver todos
        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            return true;
        }

        // Project coordinator, beneficiary coordinator, consultant y donor necesitan permiso
        if ($user->hasAnyRole(['project-coordinator', 'beneficiary-coordinator', 'consultant', 'donor'])) {
            return $user->hasPermission('ng_projects.view');
        }

        // Volunteer solo ve proyectos asignados
        if ($user->hasRole('volunteer')) {
            return $user->hasPermission('ng_projects.view.own');
        }

        // Beneficiarios solo pueden ver proyectos asignados
        if ($user->hasRole('beneficiary')) {
            return $user->hasPermission('ng_projects.view.own');
        }

        return false;
    }

    /**
     * Determine if the user can view the project.
     */
    public function view(User $user, Project $project): bool
    {
        // Super admin y admin pueden ver todos
        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            return true;
        }

        // El responsable del proyecto puede verlo
        if ($project->responsable_id === $user->id) {
            return true;
        }

        // Project coordinator - solo ve proyectos asignados o donde es responsable
        if ($user->hasRole('project-coordinator')) {
            return $user->assignedng_Projects()->where('ng_projects.id', $project->id)->exists();
        }

        // Beneficiary coordinator - puede ver todos
        if ($user->hasRole('beneficiary-coordinator')) {
            return $user->hasPermission('ng_projects.view');
        }

        // Consultant - puede ver todos
        if ($user->hasRole('consultant')) {
            return $user->hasPermission('ng_projects.view');
        }

        // Donor - puede ver proyectos donde tiene donaciones
        if ($user->hasRole('donor')) {
            // Aquí puedes agregar lógica para verificar si el donante tiene donaciones en este proyecto
            // Por ahora, permitimos que vea todos si tiene el permiso
            return $user->hasPermission('ng_projects.view');
        }

        // Volunteer - solo ve proyectos asignados
        if ($user->hasRole('volunteer')) {
            return $user->assignedng_Projects()->where('ng_projects.id', $project->id)->exists();
        }

        // Beneficiarios solo pueden ver si están asignados al proyecto
        if ($user->hasRole('beneficiary')) {
            $beneficiary = $user->beneficiary;
            return $beneficiary && $beneficiary->project_id === $project->id;
        }

        return false;
    }

    /**
     * Determine if the user can create ng_projects.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('ng_projects.create');
    }

    /**
     * Determine if the user can update the project.
     */
    public function update(User $user, Project $project): bool
    {
        // Super admin puede editar todos
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Admin puede editar si tiene el permiso
        if ($user->hasRole('admin')) {
            return $user->hasPermission('ng_projects.edit');
        }

        // El responsable del proyecto puede editarlo si tiene el permiso
        if ($project->responsable_id === $user->id && $user->hasPermission('ng_projects.edit')) {
            return true;
        }

        // Project coordinator - solo edita sus proyectos asignados
        if ($user->hasRole('project-coordinator')) {
            return $user->assignedng_Projects()->where('ng_projects.id', $project->id)->exists() 
                   && $user->hasPermission('ng_projects.edit');
        }

        // Otros roles no pueden editar
        return false;
    }

    /**
     * Determine if the user can delete the project.
     */
    public function delete(User $user, Project $project): bool
    {
        // Super admin puede eliminar
        if ($user->hasRole('super-admin')) {
            return $user->hasPermission('ng_projects.delete');
        }

        // Admin puede eliminar si tiene el permiso
        if ($user->hasRole('admin')) {
            return $user->hasPermission('ng_projects.delete');
        }

        // Otros roles no pueden eliminar
        return false;
    }

    /**
     * Scope query to filter ng_projects based on user role.
     */
    public static function scopeForUser(User $user, $query)
    {
        // Super admin y admin ven todos
        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            return $query;
        }

        // Project coordinator - solo ve proyectos asignados o donde es responsable
        if ($user->hasRole('project-coordinator')) {
            return $query->where(function($q) use ($user) {
                $q->where('responsable_id', $user->id)
                  ->orWhereIn('id', $user->assignedng_Projects()->pluck('ng_projects.id'));
            });
        }

        // Beneficiary coordinator, consultant y donor - ven todos
        if ($user->hasAnyRole(['beneficiary-coordinator', 'consultant', 'donor'])) {
            return $query;
        }

        // Volunteer - solo ve proyectos asignados
        if ($user->hasRole('volunteer')) {
            return $query->whereIn('id', $user->assignedng_Projects()->pluck('ng_projects.id'));
        }

        // Beneficiarios solo ven su proyecto
        if ($user->hasRole('beneficiary')) {
            $beneficiary = $user->beneficiary;
            if ($beneficiary) {
                return $query->where('id', $beneficiary->project_id);
            }
            return $query->whereRaw('1 = 0');
        }

        // Por defecto, no retorna nada
        return $query->whereRaw('1 = 0');
    }
}