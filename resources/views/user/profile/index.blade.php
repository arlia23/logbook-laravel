@extends('template.index')

@section('main')
<div class="container">
    <h1>Profil Saya</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <ul class="list-group">
        <li class="list-group-item"><strong>Nama:</strong> {{ $user->name }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
        <li class="list-group-item"><strong>Role:</strong> {{ ucfirst($user->role) }}</li>
        <li class="list-group-item"><strong>Tipe User:</strong> {{ $user->tipe_user ?? '-' }}</li>
    </ul>

    <a href="{{ route('user.profile.edit') }}" class="btn btn-primary mt-3">Edit Profil</a>
</div>
@endsection
