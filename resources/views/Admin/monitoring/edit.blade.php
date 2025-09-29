@extends('template.index')

@section('main')
<div class="container-xxl flex-grow-1 container-p-y">
    <h2>Edit Catatan Supervisor</h2>

    <form action="{{ route('monitoring.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="catatan_supervisor" class="form-label">Catatan Supervisor</label>
            <textarea name="catatan_supervisor" id="catatan_supervisor" class="form-control" rows="4">{{ old('catatan_supervisor', $item->catatan_supervisor) }}</textarea>
            @error('catatan_supervisor') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.monitoring.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
