<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    /**
     * Front home page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::latest()->paginate(8);
        return view('welcome', compact('posts'));
    }

    /**
     * Get public single post with comments
     *
     * @param Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSinglePost(Post $post)
    {
//        $post->load('comments', 'comments.user');
        $post->load('comments');
//        dd($post);
        return view('single-post', compact('post'));
    }

}
