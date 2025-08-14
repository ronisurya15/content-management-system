@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Tag</h2>
        <a href="{{ route('tag.create') }}" class="btn btn-primary">+ Tambah Tag</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Tag</th>
                <th>Slug</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tags as $tag)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $tag->name }}</td>
                <td>{{ $tag->slug }}</td>
                <td>
                    <a href="{{ route('tag.edit', $tag->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('tag.destroy', $tag->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus tag ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Belum ada data tag</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $tags->links() }}
</div>
@endsection
