@extends('layouts.app')

@section('title', 'Edit User - ' . $user->full_name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Edit User: {{ $user->full_name }}</h3>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Users
                    </a>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Basic Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="first_name" class="required">First Name</label>
                                                    <input type="text" 
                                                           class="form-control @error('first_name') is-invalid @enderror" 
                                                           id="first_name" 
                                                           name="first_name" 
                                                           value="{{ old('first_name', $user->first_name) }}" 
                                                           required>
                                                    @error('first_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="last_name" class="required">Last Name</label>
                                                    <input type="text" 
                                                           class="form-control @error('last_name') is-invalid @enderror" 
                                                           id="last_name" 
                                                           name="last_name" 
                                                           value="{{ old('last_name', $user->last_name) }}" 
                                                           required>
                                                    @error('last_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="email" class="required">Email Address</label>
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email', $user->email) }}" 
                                                   required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="phone">Phone Number</label>
                                            <input type="text" 
                                                   class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" 
                                                   name="phone" 
                                                   value="{{ old('phone', $user->phone) }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password">New Password</label>
                                                    <input type="password" 
                                                           class="form-control @error('password') is-invalid @enderror" 
                                                           id="password" 
                                                           name="password">
                                                    <small class="form-text text-muted">Leave blank to keep current password</small>
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password_confirmation">Confirm New Password</label>
                                                    <input type="password" 
                                                           class="form-control" 
                                                           id="password_confirmation" 
                                                           name="password_confirmation">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input type="checkbox" 
                                                           class="form-check-input" 
                                                           id="is_active" 
                                                           name="is_active" 
                                                           value="1" 
                                                           {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_active">
                                                        Active User
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input type="checkbox" 
                                                           class="form-check-input" 
                                                           id="is_verified" 
                                                           name="is_verified" 
                                                           value="1" 
                                                           {{ old('is_verified', $user->is_verified) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_verified">
                                                        Verified User
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Profile Information -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Profile Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="date_of_birth">Date of Birth</label>
                                                    <input type="date" 
                                                           class="form-control @error('date_of_birth') is-invalid @enderror" 
                                                           id="date_of_birth" 
                                                           name="date_of_birth" 
                                                           value="{{ old('date_of_birth', $user->profile?->date_of_birth?->format('Y-m-d')) }}">
                                                    @error('date_of_birth')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="gender">Gender</label>
                                                    <select class="form-control @error('gender') is-invalid @enderror" 
                                                            id="gender" 
                                                            name="gender">
                                                        <option value="">Select Gender</option>
                                                        <option value="male" {{ old('gender', $user->profile?->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                                        <option value="female" {{ old('gender', $user->profile?->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                                        <option value="other" {{ old('gender', $user->profile?->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                                        <option value="prefer_not_to_say" {{ old('gender', $user->profile?->gender) == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                                    </select>
                                                    @error('gender')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="bio">Bio</label>
                                            <textarea class="form-control @error('bio') is-invalid @enderror" 
                                                      id="bio" 
                                                      name="bio" 
                                                      rows="3" 
                                                      placeholder="Tell us about yourself...">{{ old('bio', $user->profile?->bio) }}</textarea>
                                            @error('bio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" 
                                                   class="form-control @error('address') is-invalid @enderror" 
                                                   id="address" 
                                                   name="address" 
                                                   value="{{ old('address', $user->profile?->address) }}" 
                                                   placeholder="Street address">
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="city">City</label>
                                                    <input type="text" 
                                                           class="form-control @error('city') is-invalid @enderror" 
                                                           id="city" 
                                                           name="city" 
                                                           value="{{ old('city', $user->profile?->city) }}">
                                                    @error('city')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="state">State</label>
                                                    <input type="text" 
                                                           class="form-control @error('state') is-invalid @enderror" 
                                                           id="state" 
                                                           name="state" 
                                                           value="{{ old('state', $user->profile?->state) }}">
                                                    @error('state')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="postal_code">Postal Code</label>
                                                    <input type="text" 
                                                           class="form-control @error('postal_code') is-invalid @enderror" 
                                                           id="postal_code" 
                                                           name="postal_code" 
                                                           value="{{ old('postal_code', $user->profile?->postal_code) }}">
                                                    @error('postal_code')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <input type="text" 
                                                   class="form-control @error('country') is-invalid @enderror" 
                                                   id="country" 
                                                   name="country" 
                                                   value="{{ old('country', $user->profile?->country) }}">
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Emergency Contact -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Emergency Contact</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="emergency_contact_name">Contact Name</label>
                                                    <input type="text" 
                                                           class="form-control @error('emergency_contact_name') is-invalid @enderror" 
                                                           id="emergency_contact_name" 
                                                           name="emergency_contact_name" 
                                                           value="{{ old('emergency_contact_name', $user->profile?->emergency_contact_name) }}">
                                                    @error('emergency_contact_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="emergency_contact_phone">Contact Phone</label>
                                                    <input type="text" 
                                                           class="form-control @error('emergency_contact_phone') is-invalid @enderror" 
                                                           id="emergency_contact_phone" 
                                                           name="emergency_contact_phone" 
                                                           value="{{ old('emergency_contact_phone', $user->profile?->emergency_contact_phone) }}">
                                                    @error('emergency_contact_phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="emergency_contact_relationship">Relationship</label>
                                                    <input type="text" 
                                                           class="form-control @error('emergency_contact_relationship') is-invalid @enderror" 
                                                           id="emergency_contact_relationship" 
                                                           name="emergency_contact_relationship" 
                                                           value="{{ old('emergency_contact_relationship', $user->profile?->emergency_contact_relationship) }}">
                                                    @error('emergency_contact_relationship')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Roles -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">User Roles</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="required">Assign Roles</label>
                                            <div class="row">
                                                @foreach($roles as $role)
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input type="checkbox" 
                                                                   class="form-check-input @error('roles') is-invalid @enderror" 
                                                                   id="role_{{ $role->id }}" 
                                                                   name="roles[]" 
                                                                   value="{{ $role->id }}"
                                                                   {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="role_{{ $role->id }}">
                                                                <strong>{{ $role->name }}</strong>
                                                                @if($role->description)
                                                                    <br><small class="text-muted">{{ $role->description }}</small>
                                                                @endif
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('roles')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Buttons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update User
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .required::after {
        content: " *";
        color: red;
    }
    .card {
        margin-bottom: 1rem;
    }
    .form-check {
        margin-bottom: 0.5rem;
    }
</style>
@endpush
