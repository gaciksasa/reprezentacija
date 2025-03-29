<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    protected $table = 'posts';
    
    // Turn off Laravel's automatic timestamps
    public $timestamps = false;
    
    protected $fillable = [
        'post_author',
        'post_date',
        'post_date_gmt',
        'post_content',
        'post_title',
        'post_excerpt',
        'post_status',
        'post_name',
        'post_modified',
        'post_modified_gmt',
        'post_parent',
        'guid',
        'menu_order',
        'post_type',
        'post_mime_type',
        'comment_count',
        'to_ping',
        'pinged',
        'post_content_filtered'
    ];
    
    protected $casts = [
        'post_date' => 'datetime',
        'post_modified' => 'datetime',
    ];
    
    // Define relationship with User (assuming post_author is a user ID)
    public function author()
    {
        return $this->belongsTo(User::class, 'post_author');
    }
    
    // Filter posts by status
    public function scopePublished($query)
    {
        return $query->where('post_status', 'publish');
    }
    
    // Filter posts by type
    public function scopeOfType($query, $type)
    {
        return $query->where('post_type', $type);
    }
}