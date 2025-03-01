<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Igrac extends Model
{
    use HasFactory;
    
    protected $table = 'igraci';
    
    protected $fillable = [
        'ime', 'prezime', 'tim_id', 'pozicija', 
        'datum_rodjenja', 'mesto_rodjenja', 'datum_smrti', 'mesto_smrti',
        'biografija', 'fotografija_path'
    ];
    
    protected $casts = [
        'datum_rodjenja' => 'date',
        'detum_smrti' => 'date',
    ];
    
    // Relacije
    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }
    
    public function klubovi()
    {
        return $this->hasMany(IgracKlub::class);
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
        return $this->hasMany(Gol::class);
    }
    
    public function izmeneLazne()
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
    
    // Atributi
    public function getImePrezimeAttribute()
    {
        return $this->ime . ' ' . $this->prezime;
    }
    
    // Metode za statistiku koja se računa dinamički
    public function getBrojNastupaAttribute()
    {
        return $this->sastavi()->where('starter', true)->count();
    }
    
    public function getBrojGolovaAttribute()
    {
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
    
    public function getTrenutniKlubAttribute()
    {
        return $this->klubovi()->whereNull('do_datuma')->first();
    }
    
    // Pronalazi klub u kojem je igrač bio u određenom trenutku
    public function getKlubNaDatum($datum)
    {
        return $this->klubovi()
            ->where(function($query) use ($datum) {
                $query->where('od_datuma', '<=', $datum)
                      ->where(function($q) use ($datum) {
                          $q->where('do_datuma', '>=', $datum)
                            ->orWhereNull('do_datuma');
                      });
            })
            ->first();
    }
}