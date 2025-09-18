@extends('template.index') {{-- ini layout utama sneat kamu --}}

@section('main')
<div class="container">
    <h1 class="mb-4">Selamat Datang, {{ Auth::user()->name }}</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Dashboard User</h5>
            <p class="card-text">Anda berhasil login sebagai <strong>User</strong>.</p>
        </div>
    </div>
</div>
@endsection
