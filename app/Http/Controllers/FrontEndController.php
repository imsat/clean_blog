<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->paginate(8);
        return view('welcome', compact('posts'));
    }
    public function getSinglePost(Post $post)
    {
//        $post->load('comments', 'comments.user');
        $post->load('comments');
//        dd($post);
        return view('single-post', compact('post'));
    }

}
