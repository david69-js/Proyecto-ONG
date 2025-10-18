@extends('layouts.tabler')

@section('title', 'User Details - ' . $user->full_name)
@section('page-title', 'Detalles del Usuario')
@section('page-description', 'Información completa del usuario: ' . $user->full_name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">User Details: {{ $user->full_name }}</h3>
                    <div>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary me-2">
                            <i class="fas fa-edit"></i> Edit User
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Users
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- User Avatar and Basic Info -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar }}" 
                                             alt="{{ $user->full_name }}" 
                                             class="rounded-circle mb-3" 
                                             width="120" height="120">
                                    @else
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                             style="width: 120px; height: 120px; font-size: 2rem;">
                                            {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                        </div>
                                    @endif
                                    
                                    <h4>{{ $user->full_name }}</h4>
                                    <p class="text-muted">{{ $user->email }}</p>
                                    
                                    <div class="mb-3">
                                        <span class="badge badge-{{ $user->is_active ? 'success' : 'danger' }} me-2">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        @if($user->is_verified)
                                            <span class="badge badge-info">
                                                <i class="fas fa-check-circle"></i> Verified
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                                            <i class="fas fa-edit"></i> Edit User
                                        </a>
                                        <a href="{{ route('users.permissions', $user) }}" class="btn btn-warning">
                                            <i class="fas fa-key"></i> Manage Permissions
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- User Details -->
                        <div class="col-md-8">
                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Basic Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>First Name:</strong>
                                                    <p>{{ $user->first_name }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Last Name:</strong>
                                                    <p>{{ $user->last_name }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Email:</strong>
                                                    <p>{{ $user->email }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Phone:</strong>
                                                    <p>{{ $user->phone ?? 'Not provided' }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Status:</strong>
                                                    <p>
                                                        <span class="badge badge-{{ $user->is_active ? 'success' : 'danger' }}">
                                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Verified:</strong>
                                                    <p>
                                                        @if($user->is_verified)
                                                            <span class="badge badge-success">
                                                                <i class="fas fa-check-circle"></i> Yes
                                                            </span>
                                                        @else
                                                            <span class="badge badge-warning">
                                                                <i class="fas fa-times-circle"></i> No
                                                            </span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Last Login:</strong>
                                                    <p>{{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Member Since:</strong>
                                                    <p>{{ $user->created_at->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Profile Information -->
                                @if($user->profile)
                                    <div class="col-12 mt-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Profile Information</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @if($user->profile->date_of_birth)
                                                        <div class="col-md-6">
                                                            <strong>Date of Birth:</strong>
                                                            <p>{{ $user->profile->date_of_birth->format('M d, Y') }} 
                                                               (Age: {{ $user->profile->age }})
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if($user->profile->gender)
                                                        <div class="col-md-6">
                                                            <strong>Gender:</strong>
                                                            <p>{{ ucfirst(str_replace('_', ' ', $user->profile->gender)) }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                @if($user->profile->bio)
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <strong>Bio:</strong>
                                                            <p>{{ $user->profile->bio }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                @if($user->profile->address || $user->profile->city || $user->profile->state)
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <strong>Address:</strong>
                                                            <p>{{ $user->profile->full_address ?: 'Not provided' }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                @if($user->profile->emergency_contact_name)
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <strong>Emergency Contact:</strong>
                                                            <p>{{ $user->profile->emergency_contact_name }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <strong>Contact Phone:</strong>
                                                            <p>{{ $user->profile->emergency_contact_phone }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <strong>Relationship:</strong>
                                                            <p>{{ $user->profile->emergency_contact_relationship }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Roles and Permissions -->
                                <div class="col-12 mt-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Roles & Permissions</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Assigned Roles:</strong>
                                                    <div class="mt-2">
                                                        @forelse($user->roles as $role)
                                                            <span class="badge badge-{{ $role->slug === 'super_admin' ? 'danger' : ($role->slug === 'admin' ? 'warning' : ($role->slug === 'coordinator' ? 'info' : 'secondary')) }} me-1 mb-1">
                                                                {{ $role->name }}
                                                            </span>
                                                        @empty
                                                            <span class="text-muted">No roles assigned</span>
                                                        @endforelse
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Total Permissions:</strong>
                                                    <p>{{ $user->getAllPermissions()->count() }} permissions</p>
                                                </div>
                                            </div>
                                            
                                            @if($user->getAllPermissions()->count() > 0)
                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <strong>Permissions by Module:</strong>
                                                        <div class="mt-2">
                                                            @foreach($user->getAllPermissions()->groupBy('module') as $module => $permissions)
                                                                <div class="mb-2">
                                                                    <strong class="text-capitalize">{{ $module }}:</strong>
                                                                    <div class="mt-1">
                                                                        @foreach($permissions as $permission)
                                                                            <span class="badge badge-light me-1 mb-1">{{ $permission->name }}</span>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge {
        font-size: 0.85em; /* Slightly larger for better readability */
        padding: 0.4em 0.6em;
    }
    .card {
        margin-bottom: 1.5rem; /* Increased spacing for better layout */
        border-radius: 0.5rem; /* Softer corners */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    }
    .card-header {
        background-color: #f8f9fa; /* Light gray background for headers */
        font-weight: bold;
    }
    .card-body p {
        margin-bottom: 0.75rem; /* Increased spacing for better readability */
    }
    .btn {
        border-radius: 0.3rem; /* Consistent button styling */
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
</style>
@endpush
