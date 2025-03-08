<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Igrac extends Model
{
    use HasFactory;
    
    protected $table = 'igraci';
    
    protected $fillable = [
        'ime', 'prezime', 'pozicija', 
        'datum_rodjenja', 'mesto_rodjenja', 'datum_smrti', 'mesto_smrti',
        'biografija', 'fotografija_path', 'aktivan'
    ];
    
    protected $casts = [
        'datum_rodjenja' => 'date',
        'datum_smrti' => 'date',
        'aktivan' => 'boolean',
        'debitovao_za_tim' => 'date',
        'poslednja_utakmica' => 'date',
    ];
    
    // Relationships

    public function tim()
    {
        return Tim::glavniTim()->first();
    }

    public function bivsiKlubovi()
    {
        return $this->hasMany(BivsiKlub::class);
    }
    
    public function sastavi()
    {
        return $this->hasMany(Sastav::class);
    }
    
    public function golovi()
    {
        return $this->hasMany(Gol::class)->where(function($query) {
            $query->where('igrac_tip', 'regularni')
                  ->orWhereNull('igrac_tip');
        });
    }
    
    public function izmeneIzlazne()
    {
        return $this->hasMany(Izmena::class, 'igrac_out_id');
    }
    
    public function izmeneUlazne()
    {
        return $this->hasMany(Izmena::class, 'igrac_in_id');
    }
    
    public function kartoni()
    {
        return $this->hasMany(Karton::class);
    }
    
    // Attributes
    public function getImePrezimeAttribute()
    {
        return $this->ime . ' ' . $this->prezime;
    }
    
    public function getPrezimeImeAttribute()
    {
        return $this->prezime . ' ' . $this->ime;
    }
    
    // Dynamic statistics calculation methods
    public function getBrojNastupaAttribute()
    {
        if (isset($this->attributes['broj_nastupa'])) {
            return $this->attributes['broj_nastupa'];
        }
        return $this->sastavi()->count();
    }
    
    public function getBrojGolovaAttribute()
    {
        if (isset($this->attributes['broj_golova'])) {
            return $this->attributes['broj_golova'];
        }
        return $this->golovi()->where('auto_gol', false)->count();
    }
    
    public function getBrojZutihKartonaAttribute()
    {
        return $this->kartoni()->where('tip', 'zuti')->count();
    }
    
    public function getBrojCrvenihKartonaAttribute()
    {
        return $this->kartoni()->where('tip', 'crveni')->count();
    }
    
    // Get the player's debut date
    public function getDebitovaoDatumAttribute()
    {
        if (isset($this->attributes['debitovao_za_tim'])) {
            return $this->attributes['debitovao_za_tim'];
        }
        
        $utakmica = Utakmica::join('sastavi', 'utakmice.id', '=', 'sastavi.utakmica_id')
            ->where('sastavi.igrac_id', $this->id)
            ->orderBy('utakmice.datum', 'asc')
            ->select('utakmice.datum')
            ->first();
            
        return $utakmica ? $utakmica->datum : null;
    }
    
    // Get the player's last match date
    public function getPoslednjaUtakmicaDatumAttribute()
    {
        if (isset($this->attributes['poslednja_utakmica'])) {
            return $this->attributes['poslednja_utakmica'];
        }
        
        $utakmica = Utakmica::join('sastavi', 'utakmice.id', '=', 'sastavi.utakmica_id')
            ->where('sastavi.igrac_id', $this->id)
            ->orderBy('utakmice.datum', 'desc')
            ->select('utakmice.datum')
            ->first();
            
        return $utakmica ? $utakmica->datum : null;
    }
    
    // Get the player's playing period string
    public function getPeriodAttribute()
    {
        $debitovao = $this->debitovao_datum;
        $poslednja = $this->poslednja_utakmica_datum;
        
        if (!$debitovao) {
            return '';
        }
        
        $startYear = $debitovao->format('Y');
        $endYear = $poslednja ? $poslednja->format('Y') : date('Y');
        
        return $startYear . '/' . $endYear;
    }
}