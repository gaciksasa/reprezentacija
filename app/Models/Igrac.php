<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Igrac extends Model
{
    use HasFactory;

    protected $table = 'igraci';
    
    protected $fillable = [
        'ime',
        'prezime', 
        'tim_id',
        'pozicija',
        'visina',
        'fotografija_path',
        'biografija',
        'datum_rodjenja',
        'mesto_rodjenja',
        'aktivan',
        'datum_smrti',
        'mesto_smrti',
        'slug'
    ];

    protected $casts = [
        'datum_rodjenja' => 'date',
        'datum_smrti' => 'date',
        'aktivan' => 'boolean',
    ];

    // Relacija sa timom
    public function tim()
    {
        return $this->belongsTo(Tim::class, 'tim_id');
    }

    // Relacija sa utakmicama kroz sastavi tabelu
    public function utakmice()
    {
        return $this->belongsToMany(Utakmica::class, 'sastavi', 'igrac_id', 'utakmica_id')
                    ->withPivot(['starter', 'kapiten', 'selektor', 'redosled'])
                    ->withTimestamps();
    }

    // Relacija sa sastavima
    public function sastavi()
    {
        return $this->hasMany(Sastav::class, 'igrac_id');
    }

    // Relacija sa golovima
    public function golovi()
    {
        return $this->hasMany(Gol::class, 'igrac_id');
    }

    // Relacija sa kartonima
    public function kartoni()
    {
        return $this->hasMany(Karton::class, 'igrac_id');
    }

    // Relacija sa izmenama (ulazio)
    public function izmeneIn()
    {
        return $this->hasMany(Izmena::class, 'igrac_in_id');
    }

    // Relacija sa izmenama (izlazio)
    public function izmeneOut()
    {
        return $this->hasMany(Izmena::class, 'igrac_out_id');
    }

    // Relacija sa bivšim klubovima
    public function bivsiKlubovi()
    {
        return $this->hasMany(BivsiKlub::class, 'igrac_id');
    }

    // Relacija sa klubovima
    public function klubovi()
    {
        return $this->hasMany(IgracKlub::class, 'igrac_id');
    }

    /**
     * Vraća broj nastupa igrača do određenog datuma (uključujući taj datum)
     *
     * @param string|Carbon $datum
     * @return int
     */
    public function getBrojNastupaDoDatuma($datum)
    {
        // Konvertuj datum u Carbon instancu ako nije već
        if (!$datum instanceof Carbon) {
            $datum = Carbon::parse($datum);
        }

        return $this->sastavi()
                    ->whereHas('utakmica', function ($query) use ($datum) {
                        $query->where('datum', '<=', $datum->format('Y-m-d'));
                    })
                    ->count();
    }

    /**
     * Vraća ukupan broj nastupa igrača
     *
     * @return int
     */
    public function getUkupanBrojNastupa()
    {
        return $this->sastavi()->count();
    }

    /**
     * Vraća broj nastupa kao starter
     *
     * @return int
     */
    public function getBrojNastupaKaoStarter()
    {
        return $this->sastavi()->where('starter', true)->count();
    }

    /**
     * Vraća broj nastupa kao kapiten
     *
     * @return int
     */
    public function getBrojNastupaKaoKapiten()
    {
        return $this->sastavi()->where('kapiten', true)->count();
    }

    /**
     * Vraća broj nastupa igrača u određenoj godini
     *
     * @param int $godina
     * @return int
     */
    public function getBrojNastupaUGodini($godina)
    {
        return $this->sastavi()
                    ->whereHas('utakmica', function ($query) use ($godina) {
                        $query->whereYear('datum', $godina);
                    })
                    ->count();
    }

    /**
     * Vraća nastupe u određenom periodu
     *
     * @param string|Carbon $odDatuma
     * @param string|Carbon $doDatuma
     * @return int
     */
    public function getBrojNastupaUPeriodu($odDatuma, $doDatuma)
    {
        if (!$odDatuma instanceof Carbon) {
            $odDatuma = Carbon::parse($odDatuma);
        }
        
        if (!$doDatuma instanceof Carbon) {
            $doDatuma = Carbon::parse($doDatuma);
        }

        return $this->sastavi()
                    ->whereHas('utakmica', function ($query) use ($odDatuma, $doDatuma) {
                        $query->whereBetween('datum', [
                            $odDatuma->format('Y-m-d'), 
                            $doDatuma->format('Y-m-d')
                        ]);
                    })
                    ->count();
    }

    /**
     * Vraća poslednju utakmicu u kojoj je igrac nastupao
     *
     * @return Utakmica|null
     */
    public function getPoslednjaUtakmica()
    {
        return $this->utakmice()
                    ->orderByDesc('datum')
                    ->first();
    }

    /**
     * Vraća prvu utakmicu u kojoj je igrac nastupao
     *
     * @return Utakmica|null
     */
    public function getPrvaUtakmica()
    {
        return $this->utakmice()
                    ->orderBy('datum')
                    ->first();
    }

    /**
     * Vraća ukupan broj golova igrača
     *
     * @return int
     */
    public function getUkupanBrojGolova()
    {
        return $this->golovi()->count();
    }

    /**
     * Vraća broj golova do određenog datuma
     *
     * @param string|Carbon $datum
     * @return int
     */
    public function getBrojGolovaDoDatuma($datum)
    {
        if (!$datum instanceof Carbon) {
            $datum = Carbon::parse($datum);
        }

        return $this->golovi()
                    ->whereHas('utakmica', function ($query) use ($datum) {
                        $query->where('datum', '<=', $datum->format('Y-m-d'));
                    })
                    ->count();
    }

    /**
     * Vraća ukupan broj žutih kartona
     *
     * @return int
     */
    public function getUkupanBrojZutihKartona()
    {
        return $this->kartoni()->where('tip', 'zuti')->count();
    }

    /**
     * Vraća ukupan broj crvenih kartona
     *
     * @return int
     */
    public function getUkupanBrojCrvenihKartona()
    {
        return $this->kartoni()->where('tip', 'crveni')->count();
    }

    /**
     * Vraća godine u kojima je igrac nastupao
     *
     * @return array
     */
    public function getGodineNastupa()
    {
        return $this->sastavi()
                    ->join('utakmice', 'sastavi.utakmica_id', '=', 'utakmice.id')
                    ->selectRaw('YEAR(utakmice.datum) as godina')
                    ->distinct()
                    ->orderBy('godina')
                    ->pluck('godina')
                    ->toArray();
    }

    /**
     * Vraća puno ime igrača
     *
     * @return string
     */
    public function getPunoIme()
    {
        return $this->ime . ' ' . $this->prezime;
    }

    /**
     * Vraća da li je igrac bio kapiten u određenoj utakmici
     *
     * @param int $utakmicaId
     * @return bool
     */
    public function jeKapitenUUtakmici($utakmicaId)
    {
        return $this->sastavi()
                    ->where('utakmica_id', $utakmicaId)
                    ->where('kapiten', true)
                    ->exists();
    }

    /**
     * Vraća da li je igrac bio starter u određenoj utakmici
     *
     * @param int $utakmicaId
     * @return bool
     */
    public function jeStarterUUtakmici($utakmicaId)
    {
        return $this->sastavi()
                    ->where('utakmica_id', $utakmicaId)
                    ->where('starter', true)
                    ->exists();
    }

    /**
     * Scope za aktivne igrače
     */
    public function scopeAktivni($query)
    {
        return $query->where('aktivan', true);
    }

    /**
     * Scope za igrače koji su nastupali (imaju bar jedan nastup)
     */
    public function scopeSaNastupima($query)
    {
        return $query->has('sastavi');
    }

    /**
     * Scope za igrače sa golovima
     */
    public function scopeSaGolovima($query)
    {
        return $query->has('golovi');
    }

    /**
     * Scope za kapitene (oni koji su bar jednom bili kapiteni)
     */
    public function scopeKapiteni($query)
    {
        return $query->whereHas('sastavi', function ($q) {
            $q->where('kapiten', true);
        });
    }
}