<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Kategorija;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('post_date', 'desc')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $kategorije = Kategorija::orderBy('name')->get();
        return view('posts.create', compact('kategorije'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_title' => 'required|string|max:255',
            'post_content' => 'required',
            'post_excerpt' => 'nullable|string',
            'post_status' => 'required|in:publish,draft',
            'kategorije' => 'nullable|array',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $post = new Post();
        $post->post_title = $validated['post_title'];
        $post->post_content = $validated['post_content'];
        $post->post_excerpt = $validated['post_excerpt'] ?? '';
        $post->post_status = $validated['post_status'];
        $post->post_author = Auth::id();
        $post->post_name = Str::slug($validated['post_title']);
        $post->post_type = 'post';
        
        // Set additional required fields with default values
        $post->to_ping = '';
        $post->pinged = '';
        $post->post_content_filtered = '';
        $post->guid = Str::uuid();
        $post->menu_order = 0;
        $post->post_mime_type = '';
        $post->comment_count = 0;
        
        // Set dates
        $now = now();
        $post->post_date = $now;
        $post->post_date_gmt = $now->toDateTimeString();
        $post->post_modified = $now;
        $post->post_modified_gmt = $now->toDateTimeString();
        
        // Handle featured image - keep original filename and store in uploads folder
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = $file->getClientOriginalName();
            
            // Store file in uploads folder
            $file->storeAs('uploads', $filename, 'public');
            
            // Save only the filename to the database
            $post->featured_image = $filename;
        } else {
            $post->featured_image = '';
        }
        
        $post->save();
        
        // Attach categories if any
        if (!empty($validated['kategorije'])) {
            $post->kategorije()->attach($validated['kategorije']);
        }
        
        return redirect()->route('posts.index')
            ->with('success', 'Post uspešno kreiran.');
    }

    /**
     * Display the specified post.
     */
    public function show($id)
    {
        $post = Post::with('kategorije')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit($id)
    {
        $post = Post::with('kategorije')->findOrFail($id);
        $kategorije = Kategorija::orderBy('name')->get();
        $selectedkategorije = $post->kategorije->pluck('id')->toArray();
        
        return view('posts.edit', compact('post', 'kategorije', 'selectedkategorije'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'post_title' => 'required|string|max:255',
            'post_content' => 'required',
            'post_excerpt' => 'nullable|string',
            'post_status' => 'required|in:publish,draft',
            'kategorije' => 'nullable|array',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $post = Post::findOrFail($id);
        $post->post_title = $validated['post_title'];
        $post->post_content = $validated['post_content'];
        $post->post_excerpt = $validated['post_excerpt'] ?? '';
        $post->post_status = $validated['post_status'];
        $post->post_name = Str::slug($validated['post_title']);
        
        // Set dates with proper Carbon import
        $now = Carbon::now();
        $post->post_modified = $now;
        $post->post_modified_gmt = $now->toDateTimeString();
        
        // Handle featured image
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = $file->getClientOriginalName();
            
            // Store file in uploads folder
            $file->storeAs('uploads', $filename, 'public');
            
            // Save only the filename to the database
            $post->featured_image = $filename;
        }
        
        $post->save();
        
        // Sync categories
        if (isset($validated['kategorije'])) {
            $post->kategorije()->sync($validated['kategorije']);
        } else {
            $post->kategorije()->detach();
        }
        
        return redirect()->route('posts.index')
            ->with('success', 'Post uspešno ažuriran.');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        
        // Delete featured image if exists
        if ($post->featured_image) {
            Storage::disk('public')->delete('uploads/' . $post->featured_image);
        }
        
        // Delete the post
        $post->delete();
        
        return redirect()->route('posts.index')
            ->with('success', 'Post uspešno obrisan.');
    }
}