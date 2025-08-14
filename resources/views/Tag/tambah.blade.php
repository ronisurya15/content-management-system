@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Tambah Tag</h2>

    <form action="{{ route('tag.store') }}" method="POST" class="mt-3">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Tag</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('tag.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
