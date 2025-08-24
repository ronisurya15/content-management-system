@extends('admin.layouts.master')

@section('content')
<div class="page-heading">
    <h3>Dashboard</h3>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    Daftar Kategori

                    <div class="float-end">
                        <a href="{{ route('category.create') }}" class="btn btn-sm btn-primary">Tambah</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-lg table-bordered">
                            <thead class="bg-light">
                                <tr class="text-center align-middle">
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Slug</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $i => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->slug }}</td>
                                    <td>{{ \Str::limit(strip_tags($item->description), 100) }}</td>
                                    <td>
                                        <a href="{{ route('category.edit', $item->id) }}" class="btn btn-sm btn-warning mb-1" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('category.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada kategori.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer">
                        {{-- Pagination --}}
                        <div class="mt-3">
                            <nav aria-label="Page navigation example">
                                {{-- $categories->onEachSide(1)->links('vendor.pagination.custom') --}}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@stop

@section('script')
<script>
    // Hapus dengan SweetAlert
    document.querySelectorAll('.btn-delete').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            let form = this.closest('.form-delete');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@stop