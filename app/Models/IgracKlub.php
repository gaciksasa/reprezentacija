<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IgracKlub extends Model
{
    use HasFactory;
    
    protected $table = 'igraci_klubovi';
    
    protected $fillable = [
        'igrac_id', 'klub', 'drzava_kluba', 'od_datuma', 'do_datuma'
    ];
    
    protected $casts = [
        'od_datuma' => 'date',
        'do_datuma' => 'date',
    ];
    
    public function igrac()
    {
        return $this->belongsTo(Igrac::class);
    }
}