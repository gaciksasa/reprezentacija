<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelektorMandat extends Model
{
    use HasFactory;
    
    protected $table = 'selektor_mandati';
    
    protected $fillable = [
        'selektor_id', 'tim_id', 'pocetak_mandata', 
        'kraj_mandata', 'v_d_status', 'komisija', 'redosled_u_komisiji', 'glavni_selektor', 'napomena'
    ];
    
    protected $casts = [
        'pocetak_mandata' => 'date',
        'kraj_mandata' => 'date',
        'v_d_status' => 'boolean',
        'komisija' => 'boolean',
        'glavni_selektor' => 'boolean',
    ];
    
    /**
     * Relacija sa selektorom
     */
    public function selektor()
    {
        return $this->belongsTo(Selektor::class);
    }
    
    /**
     * Relacija sa timom
     */
    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }
    
    /**
     * Dohvatanje utakmica za ovaj mandat
     */
    public function utakmice()
    {
        $query = Utakmica::where(function($q) {
            $q->where('domacin_id', $this->tim_id)
              ->orWhere('gost_id', $this->tim_id);
        })->where('datum', '>=', $this->pocetak_mandata);
        
        if ($this->kraj_mandata) {
            $query->where('datum', '<=', $this->kraj_mandata);
        }
        
        return $query->get();
    }
    
    /**
     * Određivanje rezultata utakmice za ovaj tim (pobeda/remi/poraz)
     */
    public function getUtakmicaResult(Utakmica $utakmica)
    {
        if ($utakmica->domacin_id == $this->tim_id) {
            // Naš tim je domaćin
            if ($utakmica->rezultat_domacin > $utakmica->rezultat_gost) {
                return 'pobeda';
            } elseif ($utakmica->rezultat_domacin < $utakmica->rezultat_gost) {
                return 'poraz';
            } else {
                return 'remi';
            }
        } else {
            // Naš tim je gost
            if ($utakmica->rezultat_domacin < $utakmica->rezultat_gost) {
                return 'pobeda';
            } elseif ($utakmica->rezultat_domacin > $utakmica->rezultat_gost) {
                return 'poraz';
            } else {
                return 'remi';
            }
        }
    }
    
    /**
     * Trajanje mandata u godinama
     */
    public function getTrajanjeAttribute()
    {
        $pocetak = $this->pocetak_mandata;
        $kraj = $this->kraj_mandata ?? now();
        
        $diff = $pocetak->diff($kraj);
        
        if ($diff->y > 0) {
            return $diff->y . ' ' . ($diff->y == 1 ? 'godina' : 'godine') . 
                   ($diff->m > 0 ? ' i ' . $diff->m . ' ' . ($diff->m == 1 ? 'mesec' : 'meseci') : '');
        } elseif ($diff->m > 0) {
            return $diff->m . ' ' . ($diff->m == 1 ? 'mesec' : 'meseci');
        } else {
            return $diff->d . ' ' . ($diff->d == 1 ? 'dan' : 'dana');
        }
    }
    
    /**
     * Format za prikaz perioda mandata
     */
    public function getPeriodAttribute()
    {
        $pocetak = $this->pocetak_mandata->format('d.m.Y');
        $kraj = $this->kraj_mandata ? $this->kraj_mandata->format('d.m.Y') : 'danas';
        
        return $pocetak . ' - ' . $kraj;
    }
    
    /**
     * Računanje statistike
     */
    public function getStatistikaAttribute()
    {
        $utakmice = $this->utakmice();
        $pobede = 0;
        $remiji = 0;
        $porazi = 0;
        $datiGolovi = 0;
        $primljeniGolovi = 0;
        
        foreach ($utakmice as $utakmica) {
            $result = $this->getUtakmicaResult($utakmica);
            
            if ($result == 'pobeda') {
                $pobede++;
            } elseif ($result == 'remi') {
                $remiji++;
            } elseif ($result == 'poraz') {
                $porazi++;
            }
            
            // Računanje golova
            if ($utakmica->domacin_id == $this->tim_id) {
                $datiGolovi += $utakmica->rezultat_domacin;
                $primljeniGolovi += $utakmica->rezultat_gost;
            } else {
                $datiGolovi += $utakmica->rezultat_gost;
                $primljeniGolovi += $utakmica->rezultat_domacin;
            }
        }
        
        return [
            'utakmice' => count($utakmice),
            'pobede' => $pobede,
            'remiji' => $remiji,
            'porazi' => $porazi,
            'datiGolovi' => $datiGolovi,
            'primljeniGolovi' => $primljeniGolovi,
            'procenatPobeda' => count($utakmice) > 0 ? round($pobede / count($utakmice) * 100, 2) : 0
        ];
    }

    /**
     * Get the match number for a specific match during this mandate
     * 
     * @param \DateTime $datumUtakmice
     * @return int
     */
    public function getBrojUtakmiceZaDatum($datumUtakmice)
    {
        // Prvo dobavljamo sve prethodne mandate ovog selektora
        $prethodniMandati = SelektorMandat::where('selektor_id', $this->selektor_id)
            ->where('pocetak_mandata', '<', $this->pocetak_mandata)
            ->get();
        
        // Brojimo utakmice iz svih prethodnih mandata
        $brojPrethodnihUtakmica = 0;
        foreach ($prethodniMandati as $mandat) {
            $brojPrethodnihUtakmica += Utakmica::where(function($q) use ($mandat) {
                    $q->where('domacin_id', $mandat->tim_id)
                    ->orWhere('gost_id', $mandat->tim_id);
                })
                ->where('datum', '>=', $mandat->pocetak_mandata)
                ->where('datum', '<=', $mandat->kraj_mandata ?? now())
                ->count();
        }
        
        // Zatim brojimo utakmice u trenutnom mandatu do datog datuma
        $brojUtakmicaTrenutnogMandata = Utakmica::where(function($q) {
                $q->where('domacin_id', $this->tim_id)
                ->orWhere('gost_id', $this->tim_id);
            })
            ->where('datum', '>=', $this->pocetak_mandata)
            ->where('datum', '<=', $datumUtakmice)
            ->count();
        
        // Ako postoji kraj mandata i taj datum je pre datuma utakmice, ograničavamo do kraja mandata
        if ($this->kraj_mandata && $this->kraj_mandata < $datumUtakmice) {
            $brojUtakmicaTrenutnogMandata = Utakmica::where(function($q) {
                    $q->where('domacin_id', $this->tim_id)
                    ->orWhere('gost_id', $this->tim_id);
                })
                ->where('datum', '>=', $this->pocetak_mandata)
                ->where('datum', '<=', $this->kraj_mandata)
                ->count();
        }
        
        // Ukupan broj utakmica je zbir prethodnih i trenutnih
        return $brojPrethodnihUtakmica + $brojUtakmicaTrenutnogMandata;
    }

    // Metoda za pronalaženje svih članova iste selektorske komisije
    public function clanoviKomisije()
    {
        if (!$this->komisija) {
            return collect([$this]);
        }
        
        return SelektorMandat::where('tim_id', $this->tim_id)
            ->where('komisija', true)
            ->where('pocetak_mandata', $this->pocetak_mandata)
            ->where(function($query) {
                $query->where('kraj_mandata', $this->kraj_mandata)
                    ->orWhereNull('kraj_mandata');
            })
            ->orderBy('redosled_u_komisiji')
            ->orderBy('glavni_selektor', 'desc')
            ->get();
    }
}