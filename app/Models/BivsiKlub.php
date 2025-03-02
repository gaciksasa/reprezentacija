<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BivsiKlub extends Model
{
    use HasFactory;
    
    protected $table = 'bivsi_klubovi';
    
    protected $fillable = [
        'igrac_id', 'naziv', 'drzava', 'sezona', 
        'stepen_takmicenja', 'broj_nastupa', 'broj_golova'
    ];
    
    protected $casts = [
        'broj_nastupa' => 'integer',
        'broj_golova' => 'integer',
    ];
    
    // Relacija sa igračem
    public function igrac()
    {
        return $this->belongsTo(Igrac::class);
    }
}