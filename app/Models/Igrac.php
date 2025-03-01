<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Igrac extends Model
{
    use HasFactory;
    
    protected $table = 'igraci';
    
    protected $fillable = [
        'ime', 'prezime', 'tim_id', 'broj_dresa', 'pozicija', 
        'klub', 'drzava_kluba', 'datum_rodjenja', 'nacionalnost'
    ];
    
    protected $casts = [
        'datum_rodjenja' => 'date',
    ];
    
    // Relacije
    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }
    
    public function sastavi()
    {
        return $this->hasMany(Sastav::class);
    }
    
    public function golovi()
    {
        return $this->hasMany(Gol::class);
    }
    
    public function izmeneLazne()
    {
        return $this->hasMany(Izmena::class, 'igrac_out_id');
    }
    
    public function izmeneUlazne()
    {
        return $this->hasMany(Izmena::class, 'igrac_in_id');
    }
    
    public function kartoni()
    {
        return $this->hasMany(Karton::class);
    }
    
    // Atributi
    public function getImePrezimeAttribute()
    {
        return $this->ime . ' ' . $this->prezime;
    }
}