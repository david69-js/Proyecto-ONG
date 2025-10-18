<?php

namespace App\Policies;

use App\Models\Donation;
use App\Models\User;

class DonationPolicy
{
    /**
     * Determine whether the user can view any donations.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('donations.view') || $user->hasPermission('donations.view.own');
    }

    /**
     * Determine whether the user can view the donation.
     */
    public function view(User $user, Donation $donation)
    {
        // Si tiene permiso para ver todas las donaciones
        if ($user->hasPermission('donations.view')) {
            return true;
        }

        // Si solo puede ver sus propias donaciones
        if ($user->hasPermission('donations.view.own')) {
            return $donation->user_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can create donations.
     */
    public function create(User $user)
    {
        return $user->hasPermission('donations.create');
    }

    /**
     * Determine whether the user can update the donation.
     */
    public function update(User $user, Donation $donation)
    {
        // Si tiene permiso para editar todas las donaciones
        if ($user->hasPermission('donations.edit')) {
            return true;
        }

        // Si solo puede editar sus propias donaciones y la donación está pendiente
        if ($user->hasPermission('donations.view.own') && $donation->user_id === $user->id) {
            return $donation->status === 'pending';
        }

        return false;
    }

    /**
     * Determine whether the user can delete the donation.
     */
    public function delete(User $user, Donation $donation)
    {
        // Solo se pueden eliminar donaciones pendientes
        if ($donation->status !== 'pending') {
            return false;
        }

        // Si tiene permiso para eliminar todas las donaciones
        if ($user->hasPermission('donations.delete')) {
            return true;
        }

        // Si solo puede eliminar sus propias donaciones
        if ($user->hasPermission('donations.view.own') && $donation->user_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can confirm the donation.
     */
    public function confirm(User $user, Donation $donation)
    {
        return $user->hasPermission('donations.confirm') && $donation->status === 'pending';
    }

    /**
     * Determine whether the user can process the donation.
     */
    public function process(User $user, Donation $donation)
    {
        return $user->hasPermission('donations.process') && $donation->status === 'confirmed';
    }

    /**
     * Determine whether the user can reject the donation.
     */
    public function reject(User $user, Donation $donation)
    {
        return $user->hasPermission('donations.edit') && 
               in_array($donation->status, ['pending', 'confirmed']);
    }

    /**
     * Determine whether the user can cancel the donation.
     */
    public function cancel(User $user, Donation $donation)
    {
        // Solo el donante puede cancelar sus propias donaciones pendientes o confirmadas
        if ($donation->user_id === $user->id && 
            in_array($donation->status, ['pending', 'confirmed'])) {
            return true;
        }

        // Los administradores pueden cancelar cualquier donación pendiente o confirmada
        return $user->hasPermission('donations.edit') && 
               in_array($donation->status, ['pending', 'confirmed']);
    }

    /**
     * Determine whether the user can view donation reports.
     */
    public function reports(User $user)
    {
        return $user->hasPermission('donations.reports');
    }

    /**
     * Determine whether the user can export donations.
     */
    public function export(User $user)
    {
        return $user->hasPermission('donations.export');
    }
}
