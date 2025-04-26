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

    


    public function show($slug)
    {
        $post = Post::where('post_name', $slug)->firstOrFail();
        return view('posts.show', compact('post'));
    }

    public function edit($slug)
    {
        $post = Post::where('post_name', $slug)->with('kategorije')->firstOrFail();
        $kategorije = Kategorija::orderBy('name')->get();
        
        // Get the IDs of categories that are already attached to this post
        $selectedkategorije = $post->kategorije->pluck('id')->toArray();
        
        return view('posts.edit', compact('post', 'kategorije', 'selectedkategorije'));
    }

    public function update(Request $request, $slug)
    {
        $post = Post::where('post_name', $slug)->firstOrFail();
        
        $validated = $request->validate([
            'post_title' => 'required|string|max:255',
            'post_content' => 'required',
            'post_excerpt' => 'nullable|string',
            'post_status' => 'required|in:publish,draft',
            'kategorije' => 'nullable|array',
            'featured_image' => 'nullable|image|max:2048',
            'post_date' => 'nullable|date',
        ]);

        // Generate new slug from title
        $newSlug = Str::slug($validated['post_title']);
        
        // Check if the slug already exists (excluding current post)
        $slugExists = Post::where('post_name', $newSlug)
                         ->where('id', '!=', $post->id)
                         ->exists();
                         
        // If slug exists, append a unique identifier
        if ($slugExists) {
            $newSlug = $newSlug . '-' . uniqid();
        }

        $post->post_title = $validated['post_title'];
        $post->post_content = $validated['post_content'];
        $post->post_excerpt = $validated['post_excerpt'] ?? '';
        $post->post_status = $validated['post_status'];
        $post->post_name = $newSlug;
        
        // Handle post_date if provided
        if (!empty($validated['post_date'])) {
            $postDate = Carbon::parse($validated['post_date']);
            $post->post_date = $postDate;
            $post->post_date_gmt = $postDate->copy()->timezone('UTC');
        }
        
        // Set modification dates
        $now = Carbon::now();
        $post->post_modified = $now;
        $post->post_modified_gmt = $now->toDateTimeString();
        
        // Handle featured image
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($post->featured_image) {
                Storage::disk('public')->delete('uploads/' . $post->featured_image);
            }
            
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
        
        return redirect()->route('posts.show', $post->post_name)
            ->with('success', 'Post uspešno ažuriran.');
    }

    public function destroy($slug)
    {
        $post = Post::where('post_name', $slug)->firstOrFail();
        
        // Delete featured image if exists
        if ($post->featured_image) {
            Storage::disk('public')->delete('uploads/' . $post->featured_image);
        }
        
        // Delete the post
        $post->delete();
        
        return redirect()->route('posts.index')
            ->with('success', 'Post uspešno obrisan.');
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
            'post_date' => 'nullable|date',
        ]);

        // Generate slug from title
        $slug = Str::slug($validated['post_title']);
        
        // Check if the slug already exists
        $slugExists = Post::where('post_name', $slug)->exists();
        
        // If slug exists, append a unique identifier
        if ($slugExists) {
            $slug = $slug . '-' . uniqid();
        }

        $post = new Post();
        $post->post_title = $validated['post_title'];
        $post->post_content = $validated['post_content'];
        $post->post_excerpt = $validated['post_excerpt'] ?? '';
        $post->post_status = $validated['post_status'];
        $post->post_author = Auth::id();
        $post->post_name = $slug;
        $post->post_type = 'post';
        
        // Set additional required fields with default values
        $post->to_ping = '';
        $post->pinged = '';
        $post->post_content_filtered = '';
        $post->guid = Str::uuid();
        $post->menu_order = 0;
        $post->post_mime_type = '';
        $post->comment_count = 0;
        
        // Handle post_date if provided
        if (!empty($validated['post_date'])) {
            $postDate = Carbon::parse($validated['post_date']);
            $post->post_date = $postDate;
            $post->post_date_gmt = $postDate->copy()->timezone('UTC');
        } else {
            // Set dates to current time
            $now = Carbon::now();
            $post->post_date = $now;
            $post->post_date_gmt = $now->toDateTimeString();
        }
        
        // Set modification dates
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
        } else {
            $post->featured_image = '';
        }
        
        $post->save();
        
        // Attach categories if any
        if (!empty($validated['kategorije'])) {
            $post->kategorije()->attach($validated['kategorije']);
        }
        
        return redirect()->route('posts.show', $post->post_name)
            ->with('success', 'Post uspešno kreiran.');
    }
}