@extends('users.layouts.master')

@section('meta_seo')
@include('users.layouts.meta')
@endsection

@section('content')
<section class="bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <!-- Heading -->
        <h2 class="text-xl md:text-2xl font-semibold text-gray-800 mb-8 text-center">Daftar Artikel</h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach ($articles as $item)
            <!-- Blog Card -->
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
                            <p class="text-sm font-semibold text-gray-800">Admin Toton Gendut</p>
                            <p class="text-xs text-gray-500">Author</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Blog Card -->
            @endforeach
        </div>

        <div class="mt-8">
            {{-- $articles->links('vendor.pagination.tailwind') --}}
        </div>
    </div>
</section>
@stop