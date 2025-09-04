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
                    Moderasi Komentar
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-lg table-bordered">
                            <thead class="bg-light">
                                <tr class="text-center align-middle">
                                    <th>No</th>
                                    <th>Artikel</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Komentar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($comments as $i => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('blog.show', $item->article->slug) }}" target="_blank">
                                            {{ $item->article->title }}
                                        </a>
                                    </td>

                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->content }}</td>

                                    <td>
                                        @if($item->status === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @elseif($item->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                        @else
                                        <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->status === 'pending')
                                        <form action="{{ route('comments.approve', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>

                                        <form action="{{ route('comments.reject', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-danger mt-2">Reject</button>
                                        </form>
                                        @endif

                                        <form action="{{ route('comments.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger mt-2">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada Komentar.</td>
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