<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Igrac extends Model
{
    use HasFactory;
    
    protected $table = 'igraci';
    
    protected $fillable = [
        'ime', 'prezime', 'slug', 'pozicija', 'visina',
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
    
    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    /**
     * Boot method to auto-generate slug on create/update
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($igrac) {
            if (empty($igrac->slug)) {
                $igrac->slug = $igrac->generateSlug($igrac->prezime, $igrac->ime);
            }
        });
        
        static::updating(function ($igrac) {
            if ($igrac->isDirty('ime') || $igrac->isDirty('prezime')) {
                $igrac->slug = $igrac->generateSlug($igrac->prezime, $igrac->ime);
            }
        });
    }
    
    /**
     * Generate SEO friendly slug from prezime and ime
     */
    public function generateSlug($prezime, $ime)
    {
        // Convert to lowercase
        $text = strtolower($prezime . '-' . $ime);
        
        // Replace Serbian special characters with Latin equivalents
        $replacements = [
            'ž' => 'z', 'Ž' => 'z',
            'đ' => 'dj', 'Đ' => 'dj', 
            'š' => 's', 'Š' => 's',
            'č' => 'c', 'Č' => 'c',
            'ć' => 'c', 'Ć' => 'c',
            'á' => 'a', 'à' => 'a', 'â' => 'a', 'ä' => 'a', 'ã' => 'a',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
            'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'ö' => 'o', 'õ' => 'o',
            'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
            'ý' => 'y', 'ÿ' => 'y',
            'ñ' => 'n'
        ];
        
        $text = str_replace(array_keys($replacements), array_values($replacements), $text);
        
        // Remove any remaining non-alphanumeric characters except hyphens
        $text = preg_replace('/[^a-z0-9\-]/', '', $text);
        
        // Remove multiple consecutive hyphens
        $text = preg_replace('/-+/', '-', $text);
        
        // Remove leading/trailing hyphens
        $text = trim($text, '-');
        
        // Handle duplicates by adding number suffix
        $originalSlug = $text;
        $counter = 1;
        
        while (static::where('slug', $text)->where('id', '!=', $this->id ?? 0)->exists()) {
            $text = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $text;
    }
    
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
    
    /**
     * Get the broj_nastupa attribute by counting sastavi
     */
    public function getBrojNastupaAttribute()
    {
        return $this->sastavi()->count();
    }
    
    /**
     * Get the broj_golova attribute by counting golovi
     */
    public function getBrojGolovaAttribute()
    {
        return $this->golovi()->count();
    }
}