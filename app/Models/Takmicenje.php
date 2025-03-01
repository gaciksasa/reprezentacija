<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Takmicenje extends Model
{
    use HasFactory;
    
    protected $table = 'takmicenja';
    
    protected $fillable = [
        'naziv', 'sezona', 'organizator'
    ];
    
    // Relacije
    public function utakmice()
    {
        return $this->hasMany(Utakmica::class);
    }
}