<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karton extends Model
{
    use HasFactory;
    
    protected $table = 'kartoni';
    
    protected $fillable = [
        'utakmica_id', 'igrac_id', 'tim_id', 'tip', 'minut', 'drugi_zuti'
    ];
    
    protected $casts = [
        'drugi_zuti' => 'boolean',
    ];
    
    // Relacije
    public function utakmica()
    {
        return $this->belongsTo(Utakmica::class);
    }
    
    public function igrac()
    {
        return $this->belongsTo(Igrac::class);
    }
    
    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }
}