<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::with('article')
            ->latest()
            ->paginate(10);

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'name'       => 'required|string|max:100',
            'email'      => 'required|email|max:150',
            'content'    => 'required|string|max:2000',
        ], [
            'article_id.required' => 'Artikel tidak ditemukan.',
            'article_id.exists'   => 'Artikel tidak valid.',
            'name.required'       => 'Nama wajib diisi.',
            'name.max'            => 'Nama tidak boleh lebih dari 100 karakter.',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Email tidak valid.',
            'email.max'           => 'Email tidak boleh lebih dari 150 karakter.',
            'content.required'    => 'Komentar wajib diisi.',
            'content.max'         => 'Komentar tidak boleh lebih dari 2000 karakter.',
        ]);

        Comment::create([
            'article_id' => $validated['article_id'],
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'content'    => $validated['content'],
            'status'     => 'pending',
        ]);

        return redirect()->back()->with('success', 'Komentar Anda telah terkirim dan menunggu moderasi admin.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('comments.index')
            ->with('success', 'Komentar berhasil dihapus.');
    }

    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);

        return back()->with('success', 'Komentar berhasil disetujui.');
    }

    public function reject(Comment $comment)
    {
        $comment->update(['status' => 'rejected']);

        return back()->with('success', 'Komentar berhasil ditolak.');
    }
}
