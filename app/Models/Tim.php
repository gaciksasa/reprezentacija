<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Tim extends Model
{
    use HasFactory;
    
    protected $table = 'timovi';
    
    protected $fillable = [
        'naziv', 'skraceni_naziv', 'zastava_url', 'grb_url', 'zemlja',
        'glavni_tim', 'maticni_tim_id', 'aktivan_od', 'aktivan_do'
    ];

    protected $casts = [
        'glavni_tim' => 'boolean',
        'aktivan_od' => 'datetime',
        'aktivan_do' => 'datetime',
    ];

    public function getGrbUrlAttribute($value)
    {
        if (!$value) {
            return null;
        }
        
        // Ako je puna putanja, vrati je
        if (strpos($value, 'http') === 0) {
            return $value;
        }
        
        // Ako je relativna putanja, dodaj standardni prefiks
        $filename = basename($value);
        return '/reprezentacija/public/assets/images/grbovi/' . $filename;
    }
    
    // Relationships for team aliases
    public function varijante()
    {
        return $this->hasMany(Tim::class, 'maticni_tim_id');
    }
    
    public function maticniTim()
    {
        return $this->belongsTo(Tim::class, 'maticni_tim_id');
    }
    
    // Main team scope
    public function scopeGlavniTim(Builder $query)
    {
        return $query->where('glavni_tim', true);
    }
    
    // Active aliases scope
    public function scopeAktivneVarijante(Builder $query, $date = null)
    {
        $date = $date ?: now();
        
        return $query->where(function($q) use ($date) {
            $q->whereNull('aktivan_od')->orWhere('aktivan_od', '<=', $date);
        })->where(function($q) use ($date) {
            $q->whereNull('aktivan_do')->orWhere('aktivan_do', '>=', $date);
        });
    }
    
    // Get the proper team name for a specific date
    public static function getNazivZaDatum($maticniTimId, $date)
    {
        $alias = self::where('maticni_tim_id', $maticniTimId)
            ->aktivneVarijante($date)
            ->first();
            
        if ($alias) {
            return $alias->naziv;
        }
        
        // If no alias found for the date, return the main team name
        $maticniTim = self::find($maticniTimId);
        return $maticniTim ? $maticniTim->naziv : null;
    }
    
    // Get all team IDs (main + aliases)
    public function getSviIdTimova()
    {
        if (!$this->glavni_tim && $this->maticni_tim_id) {
            // If this is an alias, get IDs from the parent
            $maticniTim = $this->maticniTim;
            return $maticniTim ? $maticniTim->getSviIdTimova() : [$this->id];
        }
        
        // If this is the main team, get all alias IDs plus this one
        $ids = $this->varijante()->pluck('id')->toArray();
        $ids[] = $this->id;
        return $ids;
    }
    
    // Get all matches for this team and its aliases
    public function sveUtakmice()
    {
        $teamIds = $this->getSviIdTimova();
        
        return Utakmica::where(function($query) use ($teamIds) {
            $query->whereIn('domacin_id', $teamIds)
                  ->orWhereIn('gost_id', $teamIds);
        });
    }
    
    // Original relationships
    public function igraci()
    {
        return $this->hasMany(Igrac::class);
    }
    
    public function domaceUtakmice()
    {
        return $this->hasMany(Utakmica::class, 'domacin_id');
    }
    
    public function gostujuceUtakmice()
    {
        return $this->hasMany(Utakmica::class, 'gost_id');
    }
    
    public function sastavi()
    {
        return $this->hasMany(Sastav::class);
    }
    
    public function golovi()
    {
        return $this->hasMany(Gol::class);
    }
    
    public function izmene()
    {
        return $this->hasMany(Izmena::class);
    }
    
    public function kartoni()
    {
        return $this->hasMany(Karton::class);
    }
}