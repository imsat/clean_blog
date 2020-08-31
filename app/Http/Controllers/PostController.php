<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $categories = Category::all(); //belongTo(post)
//            $posts = Post::with('category','user')->orderBy('id', 'desc')->get();
//        $posts = Post::with(['category'=> function($query){
//          $query->select('id','name');
//        }])->orderBy('id', 'desc')->get();
//        $posts = Post::with('category:id,name','user:id,name')->orderBy('id', 'desc')->get();

        // $posts = Post::orderBy('id', 'desc')->get();
//        dd($posts);

        //hasMany user to post
//        $user = auth()->user();
//        $user = User::find(Auth::id());
//        $posts = auth()->user()->posts; //n+1 problem
////        $posts = auth()->user()->load('posts'); //n+1 problem

//        $user = auth()->user();
//        $user->load('posts');
//        $posts = $user->posts;

        $categories = Category::select('id', 'name')->latest()->get();
        // $users = User::all();
        $tags = Tag::all();

        $posts = Post::with('category:id,name', 'tags')->where('user_id', Auth::id())
            ->latest()
            ->get();

//        return view('admin.post.index',compact('posts','categories'));
        return view('admin.post.index', compact('posts', 'categories', 'tags'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        // $users = User::all();
        $tags = Tag::all();
        return view('admin.post.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'body' => 'required',
            'category_id' => 'required',
//            'image'=>'required|mimes:png|max:12321323343'
            'image' => 'required|max:1000'
        ]);
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension(); //getting the extension
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }
        //$post = Post::all();
//        dd($post);
        //validate

//        Post::create($data);

        $post = Post::create($data);

        if (!empty($request->tag_id)) {
            $post->tags()->sync($request->tag_id);
        }

        return redirect('/posts')->with('status', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request, ['title' => 'required', 'body' => 'required']);
        $data = $request->all();


        if ($request->has('image')) {

            $file_path = public_path('/images/' . $post->image);
            unlink($file_path);

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); //getting file extension
            $filename = time() . '.' . $extension;
            $file->move('images/', $filename);
            $data['image'] = $filename;
        }


        $post->update($data);

        if (!empty($request->tag_id)) {
            $post->tags()->sync($request->tag_id);
        }

        return redirect('/posts')->with('status', "Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('/posts')->with('status', 'Deleted Successfully');
    }

    public function statusUpdate(Post $post)
    {
        $post->update([
            'status' => !$post->status
        ]);
        return redirect('/posts')->with('status', 'Updated Successful');
    }


}
