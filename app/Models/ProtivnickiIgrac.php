<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtivnickiIgrac extends Model
{
    use HasFactory;
    
    protected $table = 'protivnicki_igraci';
    
    protected $fillable = [
        'ime', 'prezime', 'utakmica_id', 'tim_id', 'kapiten', 'u_sastavu', 'redosled'
    ];
    
    protected $casts = [
        'kapiten' => 'boolean',
        'u_sastavu' => 'boolean'
    ];
    
    /**
     * Relacija sa utakmicom
     */
    public function utakmica()
    {
        return $this->belongsTo(Utakmica::class);
    }
    
    /**
     * Relacija sa timom
     */
    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }
    
    /**
     * Ime i prezime atribut
     */
    public function getImePrezimeAttribute()
    {
        return $this->ime . ' ' . $this->prezime;
    }
}