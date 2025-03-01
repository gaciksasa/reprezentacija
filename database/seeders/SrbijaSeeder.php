<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tim;
use Carbon\Carbon;

class SrbijaSeeder extends Seeder
{
    /**
     * Set up Serbia as the main team with historical aliases.
     */
    public function run(): void
    {
        // Check if Serbia already exists
        $srbija = Tim::where('naziv', 'Srbija')->first();
        
        if (!$srbija) {
            // Create Serbia as the main team
            $srbija = Tim::create([
                'naziv' => 'Srbija',
                'skraceni_naziv' => 'SRB',
                'zemlja' => 'Srbija',
                'zastava_url' => 'srbija.png',
                'grb_url' => 'srbija.png',
                'glavni_tim' => true,
                'aktivan_od' => '2006-06-05',
            ]);
        } else {
            // Update existing Serbia record to be the main team
            $srbija->update([
                'glavni_tim' => true,
                'aktivan_od' => '2006-06-05',
            ]);
        }
        
        // Create or update historical aliases
        $varijante = [
            [
                'naziv' => 'Srbija i Crna Gora',
                'skraceni_naziv' => 'SCG',
                'zemlja' => 'Srbija i Crna Gora',
                'aktivan_od' => '2003-02-04',
                'aktivan_do' => '2006-06-04'
            ],
            [
                'naziv' => 'SR Jugoslavija',
                'skraceni_naziv' => 'SRJ',
                'zemlja' => 'SR Jugoslavija',
                'aktivan_od' => '1992-04-27',
                'aktivan_do' => '2003-02-03'
            ],
            [
                'naziv' => 'SFRJ',
                'skraceni_naziv' => 'YUG',
                'zemlja' => 'Jugoslavija',
                'aktivan_od' => '1945-11-29',
                'aktivan_do' => '1992-04-26'
            ],
            [
                'naziv' => 'Kraljevina Jugoslavija',
                'skraceni_naziv' => 'YUG',
                'zemlja' => 'Kraljevina Jugoslavija',
                'aktivan_od' => '1929-10-03',
                'aktivan_do' => '1945-11-28'
            ],
            [
                'naziv' => 'Kraljevina SHS',
                'skraceni_naziv' => 'SHS',
                'zemlja' => 'Kraljevina SHS',
                'aktivan_od' => '1918-12-01',
                'aktivan_do' => '1929-10-02'
            ],
            [
                'naziv' => 'Kraljevina Srbija',
                'skraceni_naziv' => 'SRB',
                'zemlja' => 'Kraljevina Srbija',
                'aktivan_od' => '1882-03-06',
                'aktivan_do' => '1918-11-30'
            ]
        ];
        
        foreach ($varijante as $varData) {
            $varijanta = Tim::firstOrCreate(
                ['naziv' => $varData['naziv']],
                [
                    'skraceni_naziv' => $varData['skraceni_naziv'],
                    'zemlja' => $varData['zemlja'],
                    'zastava_url' => strtolower($varData['skraceni_naziv']) . '.png',
                    'grb_url' => strtolower($varData['skraceni_naziv']) . '.png',
                ]
            );
            
            // Update with relationship to Serbia as main team and historical period
            $varijanta->update([
                'maticni_tim_id' => $srbija->id,
                'aktivan_od' => $varData['aktivan_od'],
                'aktivan_do' => $varData['aktivan_do']
            ]);
        }
    }
}