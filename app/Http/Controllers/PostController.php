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
    /**
     * Display a listing of the posts.
     */
    public function index()
    {
        $posts = Post::with('kategorije')
            ->orderBy('post_date', 'desc')
            ->paginate(20);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        $kategorije = Kategorija::orderBy('name')->get();
        return view('posts.create', compact('kategorije'));
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
            'featured_image' => 'nullable|image|max:2048', // 2MB max
            'kategorije' => 'nullable|array',
            'kategorije.*' => 'exists:kategorije,id',
        ]);

        // Generate slug from title
        $slug = Str::slug($validated['post_title']);
        
        // Check if the slug already exists
        $count = Post::where('post_name', 'like', $slug . '%')->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }
        
        // Get current date/time for all datetime fields
        $now = now();
        $nowGmt = $now->copy()->setTimezone('GMT');
        
        // Create the post with all required fields
        $post = new Post();
        $post->post_title = $validated['post_title'];
        $post->post_content = $validated['post_content'];
        $post->post_excerpt = $validated['post_excerpt'] ?? '';
        $post->post_status = $validated['post_status'];
        $post->post_type = $validated['post_type'];
        $post->post_name = $slug;
        $post->post_author = Auth::id() ?? 1;
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = $slug . '-' . time() . '.' . $image->extension();
            $image->storeAs('uploads', $imageName, 'public');
            $post->featured_image = $imageName;
        }
        
        // Set all datetime fields
        $post->post_date = $now;
        $post->post_date_gmt = $nowGmt;
        $post->post_modified = $now;
        $post->post_modified_gmt = $nowGmt;
        
        // Add the other required fields with default values
        $post->to_ping = '';
        $post->pinged = '';
        $post->post_content_filtered = '';
        $post->post_parent = 0;
        $post->guid = '';
        $post->menu_order = 0;
        $post->comment_count = 0;
        
        $post->save();
        
        // Attach kategorije if any
        if (isset($validated['kategorije']) && is_array($validated['kategorije'])) {
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
        $post = Post::findOrFail($id);
        
        $validated = $request->validate([
            'post_title' => 'required|string|max:255',
            'post_content' => 'required|string',
            'post_excerpt' => 'nullable|string',
            'post_status' => 'required|string|in:publish,draft,pending,private',
            'post_type' => 'required|string|in:post,page,attachment',
            'featured_image' => 'nullable|image|max:2048', // 2MB max
            'kategorije' => 'nullable|array',
            'kategorije.*' => 'exists:kategorije,id',
        ]);

        // Current timestamp for modification dates
        $now = Carbon::now();

        // Update the post with validated data
        $post->post_title = $validated['post_title'];
        $post->post_content = $validated['post_content'];
        $post->post_excerpt = $validated['post_excerpt'] ?? '';
        $post->post_status = $validated['post_status'];
        $post->post_type = $validated['post_type'];
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($post->featured_image) {
                Storage::disk('public')->delete('uploads/' . $post->featured_image);
            }
            
            // Upload new image
            $image = $request->file('featured_image');
            $imageName = $post->post_name . '-' . time() . '.' . $image->extension();
            $image->storeAs('uploads', $imageName, 'public');
            $post->featured_image = $imageName;
        }
        
        // Handle image deletion request
        if ($request->has('delete_featured_image') && $post->featured_image) {
            Storage::disk('public')->delete('uploads/' . $post->featured_image);
            $post->featured_image = null;
        }
        
        // Update modification dates
        $post->post_modified = $now->format('Y-m-d H:i:s');
        $post->post_modified_gmt = $now->setTimezone('GMT')->format('Y-m-d H:i:s');
        
        $post->save();
        
        // Sync kategorije
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
        
        // kategorije will be automatically detached due to onDelete('cascade') in migration
        $post->delete();
        return redirect()->route('posts.index')
            ->with('success', 'Post uspešno obrisan.');
    }
}