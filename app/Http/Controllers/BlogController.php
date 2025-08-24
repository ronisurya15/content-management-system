<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Str;

class BlogController extends Controller
{
    public function index()
    {
        $articles = Article::where('is_published', 1)->orderBy('published_at', 'DESC')->paginate(9);

        return view('users.blog.index', compact('articles'));
    }

    public function show($slug)
    {
        $article = Article::where('is_published', 1)
            ->where('slug', $slug)
            ->firstOrFail();

        // Ambil 3 keyword dari judul
        $titleWords = collect(explode(' ', Str::lower($article->title)))
            ->filter(fn($word) => strlen($word) > 3)
            ->take(3);

        // Cari artikel terkait berdasarkan judul
        $relatedArticles = Article::where('is_published', 1)
            ->where('id', '!=', $article->id)
            ->where(function ($query) use ($titleWords) {
                foreach ($titleWords as $word) {
                    $query->orWhere('meta_keywords', 'like', "%$word%");
                }
            })
            ->latest()
            ->limit(4)
            ->get();

        return view('users.blog.show', compact('article', 'relatedArticles'));
    }
}
