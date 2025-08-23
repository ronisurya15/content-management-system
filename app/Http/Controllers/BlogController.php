<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $articles = [];

        return view('users.blog.index', compact('articles'));
    }
}
