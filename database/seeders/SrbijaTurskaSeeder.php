<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tim;
use App\Models\Igrac;
use App\Models\Takmicenje;
use App\Models\Sudija;
use App\Models\Stadion;
use App\Models\Utakmica;
use App\Models\Sastav;
use App\Models\Izmena;
use App\Models\Karton;

class SrbijaTurskaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Kreiranje timova
        $srbija = Tim::firstOrCreate(
            ['naziv' => 'Srbija'],
            [
                'skraceni_naziv' => 'SRB',
                'zemlja' => 'Srbija',
                'grb_url' => 'srbija.png'
            ]
        );

        $turska = Tim::firstOrCreate(
            ['naziv' => 'Turska'],
            [
                'skraceni_naziv' => 'TUR',
                'zemlja' => 'Turska',
                'grb_url' => 'turska.png'
            ]
        );

        // 2. Kreiranje takmičenja
        $takmicenje = Takmicenje::firstOrCreate(
            ['naziv' => 'UEFA Liga nacija'],
            [
                'sezona' => '2020/21',
                'organizator' => 'UEFA'
            ]
        );

        // 3. Kreiranje stadiona
        $stadion = Stadion::firstOrCreate(
            ['naziv' => 'Stadion Rajko Mitić'],
            [
                'grad' => 'Beograd',
                'zemlja' => 'Srbija',
                'kapacitet' => 53000
            ]
        );

        // 4. Kreiranje sudije
        $sudija = Sudija::firstOrCreate(
            ['prezime' => 'Kulbakov'],
            [
                'ime' => 'Aleksey',
                'nacionalnost' => 'Belorusija'
            ]
        );

        // 5. Kreiranje utakmice
        $utakmica = Utakmica::firstOrCreate(
            [
                'datum' => '2020-09-06',
                'domacin_id' => $srbija->id,
                'gost_id' => $turska->id
            ],
            [
                'takmicenje_id' => $takmicenje->id,
                'stadion_id' => $stadion->id,
                'rezultat_domacin' => 0,
                'rezultat_gost' => 0,
                'poluvreme_rezultat_domacin' => 0,
                'poluvreme_rezultat_gost' => 0,
                'sudija_id' => $sudija->id,
                'publika' => 'Igrano bez publike',
                'sezona' => '2020'
            ]
        );

        // 6. Kreiranje igrača za Srbiju
        $igraciSrbija = [
            ['Predrag', 'Rajković', 14, 'GK', 'Rennes', 'Fra'],
            ['Nikola', 'Milenković', 20, 'DF', 'Fiorentina', 'Ita'],
            ['Aleksandar', 'Kolarov', 92, 'DF', 'Roma', 'Ita'],
            ['Strahinja', 'Pavlović', 2, 'DF', 'Monaco', 'Fra'],
            ['Nemanja', 'Maksimović', 21, 'MF', 'Getafe', 'Esp'],
            ['Nemanja', 'Gudelj', 27, 'MF', 'Sevilla', 'Esp'],
            ['Darko', 'Lazović', 11, 'MF', 'Verona', 'Ita'],
            ['Filip', 'Kostić', 34, 'MF', 'Eintracht Frankfurt', 'Ger'],
            ['Nemanja', 'Radonjić', 17, 'MF', 'Olympique Marseille', 'Fra'],
            ['Dušan', 'Tadić', 69, 'FW', 'Ajax', 'Ned'],
            ['Aleksandar', 'Mitrović', 57, 'FW', 'Fulham', 'Eng'],
            ['Mijat', 'Gaćinović', 19, 'MF', 'Hoffenheim', 'Ger'],
            ['Stefan', 'Mitrović', 16, 'DF', 'Strasbourg', 'Fra'],
            ['Filip', 'Đuričić', 27, 'MF', 'Sassuolo', 'Ita']
        ];

        $srbijaIgraci = [];
        foreach ($igraciSrbija as $igrac) {
            $noviIgrac = Igrac::firstOrCreate(
                [
                    'ime' => $igrac[0],
                    'prezime' => $igrac[1],
                    'tim_id' => $srbija->id
                ],
                [
                    'broj_dresa' => $igrac[2],
                    'pozicija' => $igrac[3],
                    'klub' => $igrac[4],
                    'drzava_kluba' => $igrac[5]
                ]
            );
            $srbijaIgraci[$igrac[1]] = $noviIgrac;
        }

        // 7. Kreiranje igrača za Tursku
        $igraciTurska = [
            ['Fehmi Mert', 'Günok', null, 'GK', null, null],
            ['Hasan Ali', 'Kaldırım', null, 'DF', null, null],
            ['Zeki', 'Çelik', null, 'DF', null, null],
            ['Çağlar', 'Söyüncü', null, 'DF', null, null],
            ['Ozan', 'Kabak', null, 'DF', null, null],
            ['Mahmut', 'Tekdemir', null, 'MF', null, null],
            ['Ozan', 'Tufan', null, 'MF', null, null],
            ['Yusuf', 'Yazıcı', null, 'MF', null, null],
            ['Orkun', 'Kökçü', null, 'MF', null, null],
            ['Kenan', 'Karaman', null, 'FW', null, null],
            ['Enes', 'Ünal', null, 'FW', null, null],
            ['Nazim', 'Sangaré', null, 'DF', null, null],
            ['Cengiz', 'Ünder', null, 'MF', null, null],
            ['Burak', 'Yılmaz', null, 'FW', null, null]
        ];

        $turskaIgraci = [];
        foreach ($igraciTurska as $igrac) {
            $noviIgrac = Igrac::firstOrCreate(
                [
                    'ime' => $igrac[0],
                    'prezime' => $igrac[1],
                    'tim_id' => $turska->id
                ],
                [
                    'broj_dresa' => $igrac[2],
                    'pozicija' => $igrac[3],
                    'klub' => $igrac[4],
                    'drzava_kluba' => $igrac[5]
                ]
            );
            $turskaIgraci[$igrac[1]] = $noviIgrac;
        }

        // 8. Kreiranje sastava (startnih 11)
        // Srbija startnih 11
        $srbijaStartnihIgraca = ['Rajković', 'Milenković', 'Kolarov', 'Pavlović', 'Maksimović', 'Gudelj', 'Lazović', 'Kostić', 'Radonjić', 'Tadić', 'Mitrović'];
        foreach ($srbijaStartnihIgraca as $prezime) {
            if (isset($srbijaIgraci[$prezime])) {
                Sastav::firstOrCreate([
                    'utakmica_id' => $utakmica->id,
                    'tim_id' => $srbija->id,
                    'igrac_id' => $srbijaIgraci[$prezime]->id
                ], [
                    'starter' => true,
                    'selektor' => 'Ljubiša Tumbaković'
                ]);
            }
        }

        // Turska startnih 11
        $turskaStartnihIgraca = ['Günok', 'Kaldırım', 'Çelik', 'Söyüncü', 'Kabak', 'Tekdemir', 'Tufan', 'Yazıcı', 'Kökçü', 'Karaman', 'Ünal'];
        foreach ($turskaStartnihIgraca as $prezime) {
            if (isset($turskaIgraci[$prezime])) {
                Sastav::firstOrCreate([
                    'utakmica_id' => $utakmica->id,
                    'tim_id' => $turska->id,
                    'igrac_id' => $turskaIgraci[$prezime]->id
                ], [
                    'starter' => true,
                    'selektor' => 'Şenol Güneş'
                ]);
            }
        }

        // 9. Kreiranje izmena
        if (isset($srbijaIgraci['Lazović']) && isset($srbijaIgraci['Gaćinović'])) {
            Izmena::firstOrCreate([
                'utakmica_id' => $utakmica->id,
                'igrac_out_id' => $srbijaIgraci['Lazović']->id,
                'igrac_in_id' => $srbijaIgraci['Gaćinović']->id,
            ], [
                'tim_id' => $srbija->id,
                'minut' => 27
            ]);
        }

        if (isset($srbijaIgraci['Maksimović']) && isset($srbijaIgraci['Mitrović']) && $srbijaIgraci['Mitrović']->ime == 'Stefan') {
            Izmena::firstOrCreate([
                'utakmica_id' => $utakmica->id,
                'igrac_out_id' => $srbijaIgraci['Maksimović']->id,
                'igrac_in_id' => $srbijaIgraci['Mitrović']->id,
            ], [
                'tim_id' => $srbija->id,
                'minut' => 61
            ]);
        }

        if (isset($srbijaIgraci['Radonjić']) && isset($srbijaIgraci['Đuričić'])) {
            Izmena::firstOrCreate([
                'utakmica_id' => $utakmica->id,
                'igrac_out_id' => $srbijaIgraci['Radonjić']->id,
                'igrac_in_id' => $srbijaIgraci['Đuričić']->id,
            ], [
                'tim_id' => $srbija->id,
                'minut' => 87
            ]);
        }

        if (isset($turskaIgraci['Çelik']) && isset($turskaIgraci['Sangaré'])) {
            Izmena::firstOrCreate([
                'utakmica_id' => $utakmica->id,
                'igrac_out_id' => $turskaIgraci['Çelik']->id,
                'igrac_in_id' => $turskaIgraci['Sangaré']->id,
            ], [
                'tim_id' => $turska->id,
                'minut' => 46
            ]);
        }

        if (isset($turskaIgraci['Kökçü']) && isset($turskaIgraci['Ünder'])) {
            Izmena::firstOrCreate([
                'utakmica_id' => $utakmica->id,
                'igrac_out_id' => $turskaIgraci['Kökçü']->id,
                'igrac_in_id' => $turskaIgraci['Ünder']->id,
            ], [
                'tim_id' => $turska->id,
                'minut' => 60
            ]);
        }

        if (isset($turskaIgraci['Ünal']) && isset($turskaIgraci['Yılmaz'])) {
            Izmena::firstOrCreate([
                'utakmica_id' => $utakmica->id,
                'igrac_out_id' => $turskaIgraci['Ünal']->id,
                'igrac_in_id' => $turskaIgraci['Yılmaz']->id,
            ], [
                'tim_id' => $turska->id,
                'minut' => 76
            ]);
        }

        // 10. Kreiranje žutih kartona
        if (isset($srbijaIgraci['Kolarov'])) {
            Karton::firstOrCreate([
                'utakmica_id' => $utakmica->id,
                'igrac_id' => $srbijaIgraci['Kolarov']->id,
                'tim_id' => $srbija->id,
                'tip' => 'zuti',
                'minut' => 45
            ]);
        }

        if (isset($srbijaIgraci['Kostić'])) {
            Karton::firstOrCreate([
                'utakmica_id' => $utakmica->id,
                'igrac_id' => $srbijaIgraci['Kostić']->id,
                'tim_id' => $srbija->id,
                'tip' => 'zuti',
                'minut' => 55
            ]);
        }

        if (isset($srbijaIgraci['Tadić'])) {
            Karton::firstOrCreate([
                'utakmica_id' => $utakmica->id,
                'igrac_id' => $srbijaIgraci['Tadić']->id,
                'tim_id' => $srbija->id,
                'tip' => 'zuti',
                'minut' => 60
            ]);
        }

        if (isset($turskaIgraci['Yazıcı'])) {
            Karton::firstOrCreate([
                'utakmica_id' => $utakmica->id,
                'igrac_id' => $turskaIgraci['Yazıcı']->id,
                'tim_id' => $turska->id,
                'tip' => 'zuti',
                'minut' => 50
            ]);
        }

        if (isset($turskaIgraci['Kabak'])) {
            Karton::firstOrCreate([
                'utakmica_id' => $utakmica->id,
                'igrac_id' => $turskaIgraci['Kabak']->id,
                'tim_id' => $turska->id,
                'tip' => 'zuti',
                'minut' => 65
            ]);
        }

        // 11. Kreiranje crvenog kartona
        if (isset($srbijaIgraci['Kolarov'])) {
            Karton::firstOrCreate([
                'utakmica_id' => $utakmica->id,
                'igrac_id' => $srbijaIgraci['Kolarov']->id,
                'tim_id' => $srbija->id,
                'tip' => 'crveni',
                'minut' => 49
            ]);
        }
    }
}