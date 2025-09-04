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
                    Daftar Artikel

                    <div class="float-end">
                        <a href="{{ route('article.create') }}" class="btn btn-sm btn-primary">Tambah</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-lg table-bordered">
                            <thead class="bg-light">
                                <tr class="text-center align-middle">
                                    <th>No</th>
                                    <th>Thumbnail</th>
                                    <th>Judul</th>
                                    <th>Tag</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($article as $i => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="max-width: 100px;">
                                        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}"
                                            class="img-thumbnail w-100">
                                    </td>
                                    <td>{{ $item->title }}</td>
                                    {{-- Categories --}}
                                    <td>
                                        @forelse ($item->categories as $category)
                                        <span class="badge bg-primary">{{ $category->name }}</span>
                                        @empty
                                        <span class="text-muted">-</span>
                                        @endforelse
                                    </td>

                                    {{-- Tags --}}
                                    <td>
                                        @forelse ($item->tags as $tag)
                                        <span class="badge bg-info text-dark">{{ $tag->name }}</span>
                                        @empty
                                        <span class="text-muted">-</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        @if($item->is_published)
                                        <span class="badge bg-success">Publish</span>
                                        @else
                                        <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('blog.show', $item->slug) }}" class="btn btn-sm btn-info mb-1" title="Lihat" target="_blank">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('article.edit', $item->id) }}" class="btn btn-sm btn-warning mb-1" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('article.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
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
                                    <td colspan="5" class="text-center">Belum ada artikel.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer">
                        {{-- Pagination --}}
                        <div class="mt-3">
                            <nav aria-label="Page navigation example">
                                {{-- $article->onEachSide(1)->links('vendor.pagination.custom') --}}
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