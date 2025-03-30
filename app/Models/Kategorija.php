<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategorija extends Model
{
    use HasFactory;

    protected $table = 'kategorije';
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id'
    ];
    
    /**
     * Get the parent Kategorija
     */
    public function parent()
    {
        return $this->belongsTo(Kategorija::class, 'parent_id');
    }
    
    /**
     * Get the children kategorije
     */
    public function children()
    {
        return $this->hasMany(Kategorija::class, 'parent_id');
    }
    
    /**
     * Get the posts in this Kategorija
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'kategorija_post');
    }
}