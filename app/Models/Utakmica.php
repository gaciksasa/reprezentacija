<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utakmica extends Model
{
    use HasFactory;
    
    protected $table = 'utakmice';
    
    protected $fillable = [
        'datum', 
        'takmicenje_id', 
        'domacin_id', 
        'gost_id',
        'stadion', 
        'sudija',
        'rezultat_domacin', 
        'rezultat_gost',
        'publika'
    ];
    
    protected $casts = [
        'datum' => 'date',
        'rezultat_domacin' => 'integer',
        'rezultat_gost' => 'integer',
    ];
    
    // Relationships
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
    
    public function sastavi()
    {
        return $this->hasMany(Sastav::class);
    }

    public function protivnickiIgraci()
    {
        return $this->hasMany(ProtivnickiIgrac::class);
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
    
    // Attributes
    public function getRezultatAttribute()
    {
        return $this->rezultat_domacin . '-' . $this->rezultat_gost;
    }
    
    // Calculate halftime score based on goals before 45th minute
    public function getPoluvremenskiRezultatAttribute()
    {
        $domacin_poluvreme = 0;
        $gost_poluvreme = 0;
        
        foreach ($this->golovi as $gol) {
            if ($gol->minut <= 45) {
                if (($gol->tim_id == $this->domacin_id && !$gol->auto_gol) || 
                    ($gol->tim_id == $this->gost_id && $gol->auto_gol)) {
                    $domacin_poluvreme++;
                } else {
                    $gost_poluvreme++;
                }
            }
        }
        
        return '(' . $domacin_poluvreme . '-' . $gost_poluvreme . ')';
    }

    /**
     * Get the selector for our team in this match
     */
    public function nasSelector()
    {
        // Get main team ID and its variants
        $glavniTim = Tim::glavniTim()->first();
        $nasTimIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
        
        // Check if our team is home or away
        $nasTimId = null;
        if (in_array($this->domacin_id, $nasTimIds)) {
            $nasTimId = $this->domacin_id;
        } elseif (in_array($this->gost_id, $nasTimIds)) {
            $nasTimId = $this->gost_id;
        }
        
        if (!$nasTimId) {
            return null;
        }
        
        // Find selector mandate that covers the match date
        return SelektorMandat::where('tim_id', $nasTimId)
            ->where('pocetak_mandata', '<=', $this->datum)
            ->where(function($query) {
                $query->whereNull('kraj_mandata')
                    ->orWhere('kraj_mandata', '>=', $this->datum);
            })
            ->with('selektor')
            ->first();
    }
}