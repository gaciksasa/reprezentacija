<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    use HasFactory;
    
    protected $table = 'timovi';
    
    protected $fillable = [
        'naziv', 'skraceni_naziv', 'zastava_url', 'grb_url', 'zemlja'
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
        return '/assets/images/grbovi/' . $filename;
    }
    
    // Relacije
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