<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stadion extends Model
{
    use HasFactory;
    
    protected $table = 'stadioni';
    
    protected $fillable = [
        'naziv', 'grad', 'zemlja', 'kapacitet'
    ];
    
    // Relacije
    public function utakmice()
    {
        return $this->hasMany(Utakmica::class);
    }
}