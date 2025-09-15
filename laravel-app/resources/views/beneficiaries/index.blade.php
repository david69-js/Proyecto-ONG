@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Beneficiaries</h1>
    <a href="{{ route('beneficiaries.create') }}" class="btn btn-primary mb-3">Add New Beneficiary</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Status</th>
                <th>Project</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($beneficiaries as $beneficiary)
                <tr>
                    <td>{{ $beneficiary->name }}</td>
                    <td>{{ $beneficiary->beneficiary_type }}</td>
                    <td>{{ $beneficiary->status }}</td>
                    <td>{{ $beneficiary->project?->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('beneficiaries.show', $beneficiary) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('beneficiaries.edit', $beneficiary) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('beneficiaries.destroy', $beneficiary) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
