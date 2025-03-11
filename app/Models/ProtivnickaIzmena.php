<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtivnickaIzmena extends Model
{
    use HasFactory;
    
    protected $table = 'protivnicke_izmene';
    
    protected $fillable = [
        'utakmica_id', 'tim_id', 'igrac_out_id', 'igrac_in_id', 'minut', 'napomena'
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
        return $this->belongsTo(ProtivnickiIgrac::class, 'igrac_out_id');
    }
    
    public function igracIn()
    {
        return $this->belongsTo(ProtivnickiIgrac::class, 'igrac_in_id');
    }
}