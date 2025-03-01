<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izmena extends Model
{
    use HasFactory;
    
    protected $table = 'izmene';
    
    protected $fillable = [
        'utakmica_id', 'tim_id', 'igrac_out_id', 'igrac_in_id', 'minut'
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
    
    public function igracOut()
    {
        return $this->belongsTo(Igrac::class, 'igrac_out_id');
    }
    
    public function igracIn()
    {
        return $this->belongsTo(Igrac::class, 'igrac_in_id');
    }
}