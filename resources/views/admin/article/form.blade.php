@extends('admin.layouts.master')

@section('content')
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        {{ $isEdit ? 'Edit Artikel' : 'Tambah Artikel' }}
                    </h4>

                    <div class="float-end">
                        <a href="{{ route('article.index') }}" class="btn btn-sm btn-warning">Kembali</a>
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

                    <form action="{{ $isEdit ? route('article.update', $article->id) : route('article.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        data-parsley-validate>
                        @csrf
                        @if($isEdit)
                        @method('PUT')
                        @endif

                        {{-- Judul --}}
                        <div class="form-group mandatory">
                            <label for="title" class="form-label">Judul Artikel</label>
                            <input type="text" id="title" class="form-control" placeholder="Judul Artikel"
                                name="title" value="{{ old('title', $article->title) }}" data-parsley-required="true" />
                        </div>

                        {{-- Ringkasan --}}
                        <div class="form-group mandatory mt-3">
                            <label for="excerpt" class="form-label">Ringkasan Artikel</label>
                            <input type="text" id="excerpt" class="form-control" placeholder="Ringkasan Artikel"
                                name="excerpt" value="{{ old('excerpt', $article->excerpt) }}" data-parsley-required="true" />
                        </div>

                        {{-- Isi Artikel --}}
                        <div class="form-group mt-3">
                            <label for="content" class="form-label">Konten Artikel (800 - 1500 untuk SEO)</label>
                            <textarea id="content" class="form-control" name="content" rows="6"
                                placeholder="Tulis konten artikel...">{{ old('content', $article->content) }}</textarea>
                        </div>

                        {{-- Gambar/Thumbnail --}}
                        <div class="form-group mt-3">
                            <label for="thumbnail" class="form-label">Thumbnail</label>
                            <input type="file" class="form-control" name="thumbnail" id="thumbnail" />
                            @if($isEdit && $article->thumbnail)
                            <div class="mt-3">
                                <img src="{{ asset('storage/' . $article->thumbnail) }}" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                            @endif
                        </div>

                        {{-- Status Publikasi --}}
                        <div class="form-group mt-3 mandatory">
                            <label for="is_published" class="form-label">Status Publikasi</label>
                            <select name="is_published" id="is_published" class="form-control" data-parsley-required="true">
                                <option value="0" {{ old('is_published', $article->is_published ?? 0) == 0 ? 'selected' : '' }}>Draft</option>
                                <option value="1" {{ old('is_published', $article->is_published ?? 0) == 1 ? 'selected' : '' }}>Publish</option>
                            </select>
                        </div>

                        {{-- SEO --}}
                        <hr class="my-4">
                        <h5>SEO</h5>

                        <div class="form-group mt-3 mandatory">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" id="meta_title" name="meta_title" class="form-control"
                                value="{{ old('meta_title', $article->meta_title) }}" placeholder="Meta Title"
                                data-parsley-required="true" data-parsley-trigger="change" />
                        </div>

                        <div class="form-group mt-3 mandatory">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea id="meta_description" name="meta_description" class="form-control" rows="3"
                                placeholder="Meta Description..." data-parsley-required="true"
                                data-parsley-trigger="change">{{ old('meta_description', $article->meta_description) }}</textarea>
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

<!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/9r22aawjna4i5xiq305h1avqyndi0pzuxu0aysqdgkijvnwh/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
    tinymce.init({
        selector: '#content',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount code', // tambahkan 'code'
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | code | removeformat', // tambahkan 'code'
        setup: function(editor) {
            editor.on('change', function() {
                editor.save(); // agar isi tinymce masuk ke form textarea
            });
        },
        // Opsional: izinkan semua tag & atribut (hati-hati!)
        valid_elements: '*[*]',
        extended_valid_elements: '*[*]',
        custom_elements: 'svg[*],path[*],style',
        allow_script_urls: false,
        protected_source: /(<script[\s\S]*?>[\s\S]*?<\/script>)/gi
    });
</script>
@stop