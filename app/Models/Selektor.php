<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selektor extends Model
{
    use HasFactory;
    
    protected $table = 'selektori';
    
    protected $fillable = [
        'ime', 'prezime', 'datum_rodjenja', 'mesto_rodjenja',
        'datum_smrti', 'mesto_smrti', 'drzavljanstvo',
        'biografija', 'fotografija_path'
    ];
    
    protected $casts = [
        'datum_rodjenja' => 'date',
        'datum_smrti' => 'date',
    ];
    
    /**
     * Relacija sa mandatima
     */
    public function mandati()
    {
        return $this->hasMany(SelektorMandat::class);
    }
    
    /**
     * Ime i prezime atribut
     */
    public function getImePrezimeAttribute()
    {
        return $this->ime . ' ' . $this->prezime;
    }
    
    /**
     * Metoda za dohvatanje ukupnog broja utakmica
     */
    public function getBrojUtakmicaAttribute()
    {
        $brojUtakmica = 0;
        
        foreach ($this->mandati as $mandat) {
            $brojUtakmica += $mandat->utakmice()->count();
        }
        
        return $brojUtakmica;
    }
    
    /**
     * Metoda za dohvatanje statistike (pobede, remiji, porazi)
     */
    public function getStatistikaAttribute()
    {
        $pobede = 0;
        $remiji = 0;
        $porazi = 0;
        $datiGolovi = 0;
        $primljeniGolovi = 0;
        $utakmice = 0;
        
        foreach ($this->mandati as $mandat) {
            foreach ($mandat->utakmice() as $utakmica) {
                $utakmice++;
                
                $result = $mandat->getUtakmicaResult($utakmica);
                if ($result == 'pobeda') {
                    $pobede++;
                } elseif ($result == 'remi') {
                    $remiji++;
                } elseif ($result == 'poraz') {
                    $porazi++;
                }
                
                // Računanje golova
                if ($utakmica->domacin_id == $mandat->tim_id) {
                    $datiGolovi += $utakmica->rezultat_domacin;
                    $primljeniGolovi += $utakmica->rezultat_gost;
                } else {
                    $datiGolovi += $utakmica->rezultat_gost;
                    $primljeniGolovi += $utakmica->rezultat_domacin;
                }
            }
        }
        
        return [
            'utakmice' => $utakmice,
            'pobede' => $pobede,
            'remiji' => $remiji,
            'porazi' => $porazi,
            'datiGolovi' => $datiGolovi,
            'primljeniGolovi' => $primljeniGolovi,
            'procenatPobeda' => $utakmice > 0 ? round($pobede / $utakmice * 100, 2) : 0
        ];
    }
    
    /**
     * Prvi mandat selektora
     */
    public function getPrviMandatAttribute()
    {
        return $this->mandati()->orderBy('pocetak_mandata', 'asc')->first();
    }
    
    /**
     * Poslednji mandat selektora
     */
    public function getPoslednjiMandatAttribute()
    {
        return $this->mandati()->orderBy('pocetak_mandata', 'desc')->first();
    }
    
    /**
     * Da li je selektor trenutno aktivan
     */
    public function getAktivanAttribute()
    {
        return $this->mandati()->whereNull('kraj_mandata')->exists();
    }
    
    /**
     * Prvi tim koji je vodio
     */
    public function getPrviTimAttribute()
    {
        $prviMandat = $this->getPrviMandatAttribute();
        return $prviMandat ? $prviMandat->tim : null;
    }
}