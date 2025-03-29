<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     */
    public function index()
    {
        $posts = Post::orderBy('post_date', 'desc')->paginate(20);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_title' => 'required|string|max:255',
            'post_content' => 'required|string',
            'post_excerpt' => 'nullable|string',
            'post_status' => 'required|string|in:publish,draft,pending,private',
            'post_type' => 'required|string|in:post,page,attachment',
        ]);

        // Generate slug from title
        $slug = Str::slug($validated['post_title']);
        
        // Check if the slug already exists
        $count = Post::where('post_name', 'like', $slug . '%')->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }
        
        // Create the post
        $post = new Post();
        $post->post_title = $validated['post_title'];
        $post->post_content = $validated['post_content'];
        $post->post_excerpt = $validated['post_excerpt'] ?? '';
        $post->post_status = $validated['post_status'];
        $post->post_type = $validated['post_type'];
        $post->post_name = $slug;
        $post->post_author = Auth::id() ?? 1;
        $post->post_date = now();
        $post->post_modified = now();
        $post->save();

        return redirect()->route('posts.index')
            ->with('success', 'Post uspešno kreiran.');
    }

    /**
     * Display the specified post.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'post_title' => 'required|string|max:255',
            'post_content' => 'required|string',
            'post_excerpt' => 'nullable|string',
            'post_status' => 'required|string|in:publish,draft,pending,private',
            'post_type' => 'required|string|in:post,page,attachment',
        ]);

        // Update the post with validated data
        $post->post_title = $validated['post_title'];
        $post->post_content = $validated['post_content'];
        $post->post_excerpt = $validated['post_excerpt'] ?? '';
        $post->post_status = $validated['post_status'];
        $post->post_type = $validated['post_type'];
        $post->post_modified = now();
        $post->save();

        return redirect()->route('posts.index')
            ->with('success', 'Post uspešno ažuriran.');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')
            ->with('success', 'Post uspešno obrisan.');
    }
}