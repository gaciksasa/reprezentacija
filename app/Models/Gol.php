<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gol extends Model
{
    use HasFactory;
    
    protected $table = 'golovi';
    
    protected $fillable = [
        'utakmica_id', 'igrac_id', 'igrac_tip', 'minut', 'tim_id', 'penal', 'auto_gol'
    ];
    
    protected $casts = [
        'penal' => 'boolean',
        'auto_gol' => 'boolean',
    ];
    
    // Relacije
    public function utakmica()
    {
        return $this->belongsTo(Utakmica::class);
    }
    
    // app/Models/Gol.php
    public function igrac()
    {
        if ($this->igrac_tip === 'protivnicki') {
            return $this->belongsTo(ProtivnickiIgrac::class, 'igrac_id');
        }
        return $this->belongsTo(Igrac::class);
    }
    
    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }
    
    // Atributi
    public function getOpisAttribute()
    {
        $opis = $this->minut . "' " . $this->igrac->ime_prezime;
        
        if ($this->penal) {
            $opis .= ' (p)';
        }
        
        if ($this->auto_gol) {
            $opis .= ' (ag)';
        }
        
        return $opis;
    }
}