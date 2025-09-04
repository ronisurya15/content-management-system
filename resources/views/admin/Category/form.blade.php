@extends('admin.layouts.master')

@section('content')
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        {{ $isEdit ? 'Edit Kategori' : 'Tambah Kategori' }}
                    </h4>

                    <div class="float-end">
                        <a href="{{ route('category.index') }}" class="btn btn-sm btn-warning">Kembali</a>
                    </div>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Terjadi kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ $isEdit ? route('category.update', $category->id) : route('category.store') }}"
                        method="POST"
                        data-parsley-validate>
                        @csrf
                        @if($isEdit)
                        @method('PUT')
                        @endif

                        {{-- Nama Kategori --}}
                        <div class="form-group mandatory">
                            <label for="name" class="form-label">Nama Kategori</label>
                            <input type="text" id="name" class="form-control" placeholder="Nama Kategori"
                                name="name" value="{{ old('name', $category->name) }}" data-parsley-required="true" />
                        </div>

                        <hr class="my-4">

                        {{-- Submit --}}
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">{{ $isEdit ? 'Update' : 'Simpan' }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>
@stop

@section('script')
<script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/extensions/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('assets/static/js/pages/parsley.js') }}"></script>
@stop