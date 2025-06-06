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
        'vreme',
        'takmicenje_id', 
        'domacin_id', 
        'gost_id',
        'stadion_id', 
        'sudija_id',
        'stadion', 
        'sudija',
        'rezultat_domacin', 
        'rezultat_gost',
        'poluvreme_rezultat_domacin',
        'poluvreme_rezultat_gost',
        'imao_jedanaesterce',
        'jedanaesterci_domacin',
        'jedanaesterci_gost',
        'publika',
        'sezona',
        'protivnik_alijas',
        'featured_img',
        'tickets_url'
    ];
    
    protected $casts = [
        'datum' => 'date',
        'rezultat_domacin' => 'integer',
        'rezultat_gost' => 'integer',
        'imao_jedanaesterce' => 'boolean',
        'jedanaesterci_domacin' => 'integer',
        'jedanaesterci_gost' => 'integer',
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
        return $this->hasMany(Sastav::class)->orderBy('redosled')->orderByDesc('starter');
    }

    public function protivnickiIgraci()
    {
        return $this->hasMany(ProtivnickiIgrac::class)->orderBy('redosled');
    }
    
    public function protivnickeIzmene()
    {
        return $this->hasMany(ProtivnickaIzmena::class)->orderBy('minut');
    }

    public function protivnickiKartoni()
    {
        return $this->hasMany(ProtivnickiKarton::class)->orderBy('minut');
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

    // Protivnicki selektori
    public function protivnickiSelektori()
    {
        return $this->hasMany(ProtivnickiSelektor::class);
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
        
        return '( ' . $domacin_poluvreme . ' - ' . $gost_poluvreme . ' )';
    }

    // Atribut za formatiranje kompletnog rezultata
    public function getKompletanRezultatAttribute()
    {
        if (!$this->imao_jedanaesterce) {
            return $this->rezultat_domacin . '-' . $this->rezultat_gost;
        }
        
        return $this->rezultat_domacin . '-' . $this->rezultat_gost . 
            ' (' . $this->jedanaesterci_domacin . '-' . $this->jedanaesterci_gost . ' pen)';
    }

    /**
     * Dobija prikazno ime protivnika (bilo domaćin ili gost)
     */
    public function getProtivnikPrikaznoImeAttribute()
    {
        // Dobija glavne timove i njihove alijase
        $glavniTim = Tim::glavniTim()->first();
        $nasTimIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
        
        // Provera da li je naš tim domaćin ili gost
        $nasTimJeDomacin = in_array($this->domacin_id, $nasTimIds);
        
        if ($nasTimJeDomacin) {
            // Protivnik je gost
            return $this->protivnik_alijas ?: ($this->gost ? $this->gost->naziv : 'Nepoznat tim');
        } else {
            // Protivnik je domaćin
            return $this->protivnik_alijas ?: ($this->domacin ? $this->domacin->naziv : 'Nepoznat tim');
        }
    }

    /**
     * Get the selector(s) for our team in this match
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
        $mandat = SelektorMandat::where('tim_id', $nasTimId)
            ->where('pocetak_mandata', '<=', $this->datum)
            ->where(function($query) {
                $query->whereNull('kraj_mandata')
                    ->orWhere('kraj_mandata', '>=', $this->datum);
            })
            ->with('selektor')
            ->first();
            
        return $mandat;
    }
}