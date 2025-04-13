<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sastav extends Model
{
    use HasFactory;
    
    protected $table = 'sastavi';
    
    protected $fillable = [
        'utakmica_id', 'tim_id', 'igrac_id', 'starter', 'kapiten', 'selektor', 'redosled'
    ];
    
    protected $casts = [
        'starter' => 'boolean',
        'kapiten' => 'boolean',
    ];
    
    // Relacije
    public function utakmica()
    {
        return $this->belongsTo(Utakmica::class);
    }
    
    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }
    
    public function igrac()
    {
        return $this->belongsTo(Igrac::class);
    }
}