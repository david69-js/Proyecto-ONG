@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Beneficiary Details</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $beneficiary->name }}</p>
            <p><strong>Type:</strong> {{ $beneficiary->beneficiary_type }}</p>
            <p><strong>Status:</strong> {{ $beneficiary->status }}</p>
            <p><strong>Project:</strong> {{ $beneficiary->project?->name ?? '-' }}</p>
            <p><strong>Notes:</strong> {{ $beneficiary->notes }}</p>
        </div>
    </div>

    <a href="{{ route('beneficiaries.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
