<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class ArticleController extends Controller
{
    public function index()
    {
        // Initialize
        $article = Article::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.article.index', compact('article'));
    }

    public function create()
    {
        $article = new Article();
        $categories = Category::get();
        $tags = Tag::get();
        $isEdit = false;

        return view('admin.article.form', compact('article', 'isEdit', 'categories', 'tags'));
    }

    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'excerpt'           => 'required|string|max:500',
            'content'           => 'required|string',
            'meta_title'        => 'required|string|max:255',
            'meta_description'  => 'required|string|max:500',
            'thumbnail'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'is_published'      => 'required|in:0,1',

            // tambahan
            'categories'        => 'required|array|min:1',
            'categories.*'      => 'exists:categories,id',

            'tags'              => 'nullable|array',
            'tags.*'            => 'exists:tags,id',
        ], [
            'title.required'            => 'Judul artikel wajib diisi.',
            'title.max'                 => 'Judul artikel tidak boleh lebih dari 255 karakter.',

            'excerpt.required'          => 'Ringkasan artikel wajib diisi.',
            'excerpt.max'               => 'Ringkasan artikel tidak boleh lebih dari 500 karakter.',

            'content.required'          => 'Konten artikel wajib diisi.',

            'meta_title.required'       => 'Meta title wajib diisi.',
            'meta_title.max'            => 'Meta title tidak boleh lebih dari 255 karakter.',

            'meta_description.required' => 'Meta description wajib diisi.',
            'meta_description.max'      => 'Meta description tidak boleh lebih dari 500 karakter.',

            'thumbnail.required'        => 'Thumbnail artikel wajib diunggah.',
            'thumbnail.image'           => 'Thumbnail harus berupa file gambar.',
            'thumbnail.mimes'           => 'Thumbnail harus bertipe jpeg, png, jpg, atau webp.',
            'thumbnail.max'             => 'Ukuran thumbnail tidak boleh lebih dari 10MB.',

            // kategori & tag
            'categories.required'       => 'Minimal pilih 1 kategori.',
            'categories.array'          => 'Kategori harus dalam format array.',
            'categories.*.exists'       => 'Kategori yang dipilih tidak valid.',

            'tags.array'                => 'Tag harus dalam format array.',
            'tags.*.exists'             => 'Tag yang dipilih tidak valid.',
        ]);

        // Initialize
        $thumbnailPath = null;

        if ($request->file('thumbnail')) {
            // Upload thumbnail
            $thumbnailPath = $request->file('thumbnail')->store('uploads/articles', 'public');
        }

        $article = Article::create([
            'title'             => $validated['title'],
            'slug'              => Str::slug($validated['title']) . '-' . date('YMDis'),
            'excerpt'           => $validated['excerpt'],
            'content'           => $validated['content'],
            'meta_title'        => $validated['meta_title'],
            'meta_description'  => $validated['meta_description'],
            'thumbnail'         => $thumbnailPath,
            'user_id'           => auth()->user()->id,
            'is_published'      => $validated['is_published'],
            'published_at'      => $validated['is_published'] ? now() : null,
        ]);

        // Sinkronisasi kategori & tags
        $article->categories()->sync($validated['categories']);
        $article->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('article.index')->with('success', 'Artikel berhasil disimpan.');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::get();
        $tags = Tag::get();

        return view('admin.article.form', [
            'article' => $article,
            'isEdit' => true,
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'excerpt'           => 'required|string|max:500',
            'content'           => 'required|string',
            'meta_title'        => 'required|string|max:255',
            'meta_description'  => 'required|string|max:500',
            'thumbnail'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'is_published'      => 'required|in:0,1',

            // tambahan
            'categories'        => 'required|array|min:1',
            'categories.*'      => 'exists:categories,id',

            'tags'              => 'nullable|array',
            'tags.*'            => 'exists:tags,id',
        ], [
            'title.required'            => 'Judul artikel wajib diisi.',
            'title.max'                 => 'Judul artikel tidak boleh lebih dari 255 karakter.',

            'excerpt.required'          => 'Ringkasan artikel wajib diisi.',
            'excerpt.max'               => 'Ringkasan artikel tidak boleh lebih dari 500 karakter.',

            'content.required'          => 'Konten artikel wajib diisi.',

            'meta_title.required'       => 'Meta title wajib diisi.',
            'meta_title.max'            => 'Meta title tidak boleh lebih dari 255 karakter.',

            'meta_description.required' => 'Meta description wajib diisi.',
            'meta_description.max'      => 'Meta description tidak boleh lebih dari 500 karakter.',

            'thumbnail.image'           => 'Thumbnail harus berupa file gambar.',
            'thumbnail.mimes'           => 'Thumbnail harus bertipe jpeg, png, jpg, atau webp.',
            'thumbnail.max'             => 'Ukuran thumbnail tidak boleh lebih dari 10MB.',

            // kategori & tag
            'categories.required'       => 'Minimal pilih 1 kategori.',
            'categories.array'          => 'Kategori harus dalam format array.',
            'categories.*.exists'       => 'Kategori yang dipilih tidak valid.',

            'tags.array'                => 'Tag harus dalam format array.',
            'tags.*.exists'             => 'Tag yang dipilih tidak valid.',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
                Storage::disk('public')->delete($article->thumbnail);
            }

            $thumbnailPath = $request->file('thumbnail')->store('uploads/articles', 'public');
        } else {
            $thumbnailPath = $article->thumbnail;
        }

        // Update data artikel
        $article->update([
            'title'             => $validated['title'],
            'slug'              => Str::slug($validated['title']),
            'excerpt'           => $validated['excerpt'],
            'content'           => $validated['content'],
            'meta_title'        => $validated['meta_title'],
            'meta_description'  => $validated['meta_description'],
            'thumbnail'         => $thumbnailPath,
            'is_published'      => $validated['is_published'],
            'published_at'      => $validated['is_published'] ? now() : null
        ]);

        // Sinkronisasi kategori & tags
        $article->categories()->sync($validated['categories']);
        $article->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('article.index')->with('success', 'Artikel berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $article->delete();

        return redirect()->route('article.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
