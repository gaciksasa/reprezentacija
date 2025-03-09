<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtivnickiSelektor extends Model
{
    use HasFactory;
    
    protected $table = 'protivnicki_selektori';
    
    protected $fillable = [
        'utakmica_id', 'tim_id', 'ime_prezime', 'napomena'
    ];
    
    public function utakmica()
    {
        return $this->belongsTo(Utakmica::class);
    }
    
    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }
}