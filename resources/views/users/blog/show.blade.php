@extends('users.layouts.master')


@section('content')
<section class="bg-gray-50 py-12">
    <div class="container rounded-xl mx-auto px-4 py-8 bg-white">
        <article class="max-w-5xl mx-auto">

            <!-- Judul -->
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-3">
                {{ $article->title }}
            </h1>

            <!-- Info penulis -->
            <div class="flex items-center text-sm text-gray-500 space-x-2 mb-6">
                <span>{{ $article->created_at->format('d F Y H:i') }}</span>
            </div>

            <!-- Gambar Artikel -->
            <div class="mb-8">
                @if ($article->thumbnail)
                @php
                $thumbnail = $article->thumbnail;
                $isAbsolute = str_starts_with($thumbnail, 'http://') || str_starts_with($thumbnail, 'https://');
                @endphp
                <img src="{{ $isAbsolute ? $thumbnail : asset('storage/'.$thumbnail) }}" alt="{{ $article->title }}" class="rounded-lg w-full h-auto max-h-[450px] object-cover shadow">
                @else
                <img src="{{ asset('storage/'.$article->thumbnail) }}" alt="{{ $article->title }}" class="rounded-lg w-full h-auto max-h-[450px] object-cover shadow">
                @endif
            </div>

            <!-- Konten Artikel -->
            <div class="prose prose-base md:prose-lg max-w-none text-gray-800">
                {!! $article->content !!}
            </div>

        </article>
    </div>
</section>

<section class="bg-gray-50 py-4">
    <div class="container rounded-xl mx-auto px-4 py-8 bg-white">
        <h3 class="text-2xl font-bold mb-6">Komentar</h3>

        <!-- Form Komentar -->
        <div class="bg-white shadow rounded-xl p-6 mb-10">
            <h4 class="text-lg font-semibold mb-4">Tinggalkan Komentar</h4>
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="article_id" value="{{ $article->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama <span class="text-red-700">*</span></label>
                        <input type="text" name="name"
                            class="w-full px-4 py-3 text-base border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-700">*</span></label>
                        <input type="email" name="email"
                            class="w-full px-4 py-3 text-base border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Komentar <span class="text-red-700">*</span></label>
                    <textarea name="content" rows="4"
                        class="w-full px-4 py-3 text-base border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required></textarea>
                </div>

                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Kirim Komentar
                </button>
            </form>
        </div>

        <!-- List Komentar -->
        <div>
            <h4 class="text-lg font-semibold mb-4">Komentar Pengunjung</h4>

            @forelse($article->comments()->where('status', 'approved')->latest()->get() as $comment)
            <div class="flex items-start mb-6">
                <!-- Avatar -->
                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                    <span class="text-gray-500 font-bold">{{ strtoupper(substr($comment->name, 0, 1)) }}</span>
                </div>

                <!-- Isi Komentar -->
                <div class="bg-white p-4 rounded-xl shadow w-full">
                    <div class="flex items-center justify-between mb-2">
                        <h5 class="font-semibold text-gray-800">{{ $comment->name }}</h5>
                        <span class="text-xs text-gray-500">{{ $comment->created_at->format('d F Y H:i') }}</span>
                    </div>
                    <p class="text-gray-700">{{ $comment->content }}</p>
                </div>
            </div>
            @empty
            <p class="text-gray-500">Belum ada komentar. Jadilah yang pertama!</p>
            @endforelse
        </div>
    </div>
</section>


<section class="bg-gray-50 py-5 mb-10">
    <div class="container mx-auto px-4 sm:px-6">
        <h3 class="text-xl font-bold mb-4">Artikel Terkait</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($relatedArticles as $item)
            <!-- Blog Card sama seperti punyamu -->
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
                <div class="relative">
                    @if ($item->thumbnail)
                    @php
                    $thumbnail = $item->thumbnail;
                    $isAbsolute = str_starts_with($thumbnail, 'http://') || str_starts_with($thumbnail, 'https://');
                    @endphp
                    <img src="{{ $isAbsolute ? $thumbnail : asset('storage/'.$thumbnail) }}" alt="{{ $item->title }}" class="w-full h-56 object-cover">
                    @else
                    <img src="{{ asset('storage/'.$item->thumbnail) }}" alt="{{ $item->title }}" class="w-full h-56 object-cover">
                    @endif
                </div>
                <div class="p-5">
                    <p class="text-gray-500 text-sm mb-1">
                        {{ $item->created_at->format('d F Y H:i') }}
                    </p>
                    <h3 class="text-lg font-bold text-gray-800 mb-2 hover:text-blue-600 transition">
                        <a href="{{ route('blog.show', $item->slug) }}">
                            {{ $item->title }}
                        </a>
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">
                        {{ $item->excerpt }}
                        <br>
                        <a href="{{ route('blog.show', $item->slug) }}"
                            class="inline-block mt-2 text-sm text-[#1c398e] font-semibold hover:underline">
                            Baca Selengkapnya →
                        </a>
                    </p>
                    <div class="flex items-center">
                        <svg class="w-10 h-10 text-gray-400 bg-gray-100 rounded-full mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Admin Putra Lancar Jaya Battery</p>
                            <p class="text-xs text-gray-500">Author</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection