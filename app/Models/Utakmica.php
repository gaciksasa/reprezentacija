<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utakmica extends Model
{
    use HasFactory;
    
    protected $table = 'utakmice';
    
    protected $fillable = [
        'datum', 'vreme', 'takmicenje_id', 'domacin_id', 'gost_id',
        'stadion_id', 'rezultat_domacin', 'rezultat_gost',
        'poluvreme_rezultat_domacin', 'poluvreme_rezultat_gost',
        'sudija_id', 'publika', 'admin_id', 'sezona'
    ];
    
    protected $casts = [
        'datum' => 'date',
        'vreme' => 'datetime:H:i',
    ];
    
    // Relacije
    public function takmicenje()
    {
        return $this->belongsTo(Takmicenje::class);
    }
    
    public function domacin()
    {
        return $this->belongsTo(Tim::class, 'domacin_id');
    }
    
    public function gost()
    {
        return $this->belongsTo(Tim::class, 'gost_id');
    }
    
    public function stadion()
    {
        return $this->belongsTo(Stadion::class);
    }
    
    public function sudija()
    {
        return $this->belongsTo(Sudija::class);
    }
    
    public function sastavi()
    {
        return $this->hasMany(Sastav::class);
    }
    
    public function golovi()
    {
        return $this->hasMany(Gol::class)->orderBy('minut');
    }
    
    public function izmene()
    {
        return $this->hasMany(Izmena::class)->orderBy('minut');
    }
    
    public function kartoni()
    {
        return $this->hasMany(Karton::class)->orderBy('minut');
    }
    
    // Atributi
    public function getRezultatAttribute()
    {
        return $this->rezultat_domacin . '-' . $this->rezultat_gost;
    }
    
    public function getPoluvremenskiRezultatAttribute()
    {
        if ($this->poluvreme_rezultat_domacin !== null && $this->poluvreme_rezultat_gost !== null) {
            return '(' . $this->poluvreme_rezultat_domacin . '-' . $this->poluvreme_rezultat_gost . ')';
        }
        return '';
    }
}