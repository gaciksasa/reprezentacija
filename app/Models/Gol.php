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
    
    // Ažurirana relacija za igrača koja razlikuje tipove igrača
    public function igrac()
    {
        if ($this->igrac_tip === 'protivnicki') {
            return $this->belongsTo(ProtivnickiIgrac::class, 'igrac_id');
        }
        return $this->belongsTo(Igrac::class, 'igrac_id');
    }
    
    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }
    
    // Atributi
    public function getOpisAttribute()
    {
        $opis = $this->minut . "' ";
        
        if ($this->igrac) {
            if ($this->igrac_tip === 'protivnicki') {
                $opis .= $this->igrac->ime . ' ' . $this->igrac->prezime;
            } else {
                $opis .= $this->igrac->ime_prezime;
            }
        } else {
            $opis .= "Nepoznat igrač";
        }
        
        if ($this->penal) {
            $opis .= ' (p)';
        }
        
        if ($this->auto_gol) {
            $opis .= ' (ag)';
        }
        
        return $opis;
    }
}