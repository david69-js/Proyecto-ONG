@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Beneficiary</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('beneficiaries.update', $beneficiary) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $beneficiary->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="beneficiary_type" class="form-label">Type</label>
            <select name="beneficiary_type" class="form-select">
                <option value="Person" {{ $beneficiary->beneficiary_type == 'Person' ? 'selected' : '' }}>Person</option>
                <option value="Family" {{ $beneficiary->beneficiary_type == 'Family' ? 'selected' : '' }}>Family</option>
                <option value="Community" {{ $beneficiary->beneficiary_type == 'Community' ? 'selected' : '' }}>Community</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="Active" {{ $beneficiary->status == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ $beneficiary->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="project_id" class="form-label">Project</label>
            <input type="number" name="project_id" class="form-control" value="{{ old('project_id', $beneficiary->project_id) }}">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('beneficiaries.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
