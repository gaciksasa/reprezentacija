<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sudija extends Model
{
    use HasFactory;
    
    protected $table = 'sudije';
    
    protected $fillable = [
        'ime', 'prezime', 'nacionalnost'
    ];
    
    // Relacije
    public function utakmice()
    {
        return $this->hasMany(Utakmica::class);
    }
    
    // Atributi
    public function getImePrezimeAttribute()
    {
        return $this->ime . ' ' . $this->prezime;
    }
}