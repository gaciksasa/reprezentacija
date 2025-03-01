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
use App\Models\Gol;
use App\Models\Izmena;
use App\Models\Karton;

class RusijaSrbijaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Kreiranje timova
        $rusija = Tim::create([
            'naziv' => 'Rusija',
            'skraceni_naziv' => 'RUS',
            'zemlja' => 'Rusija',
            'zastava_url' => 'rusija.png',
            'grb_url' => 'rusija.png'
        ]);

        $srbija = Tim::create([
            'naziv' => 'Srbija',
            'skraceni_naziv' => 'SRB',
            'zemlja' => 'Srbija',
            'zastava_url' => 'srbija.png',
            'grb_url' => 'srbija.png'
        ]);

        // 2. Kreiranje takmičenja
        $takmicenje = Takmicenje::create([
            'naziv' => 'UEFA Liga nacija',
            'sezona' => '2020/21',
            'organizator' => 'UEFA'
        ]);

        // 3. Kreiranje stadiona
        $stadion = Stadion::create([
            'naziv' => 'VTB Arena',
            'grad' => 'Moskva',
            'zemlja' => 'Rusija',
            'kapacitet' => 30000
        ]);

        // 4. Kreiranje sudije
        $sudija = Sudija::create([
            'ime' => 'William',
            'prezime' => 'Collum',
            'nacionalnost' => 'Škotska'
        ]);

        // 5. Kreiranje utakmice
        $utakmica = Utakmica::create([
            'datum' => '2020-09-03',
            'vreme' => '20:45:00',
            'takmicenje_id' => $takmicenje->id,
            'domacin_id' => $rusija->id,
            'gost_id' => $srbija->id,
            'stadion_id' => $stadion->id,
            'rezultat_domacin' => 3,
            'rezultat_gost' => 1,
            'poluvreme_rezultat_domacin' => 0,
            'poluvreme_rezultat_gost' => 0,
            'sudija_id' => $sudija->id,
            'publika' => 'Igrano bez publike',
            'sezona' => '2020'
        ]);

        // 6. Kreiranje igrača za Rusiju
        $igraciRusija = [
            ['Anton', 'Shunin', null, null, 'Dinamo Moskva', 'Rus'],
            ['Mario', 'Fernandes', null, null, 'CSKA Moskva', 'Rus'],
            ['Vyacheslav', 'Karavaev', null, null, 'Zenit', 'Rus'],
            ['Georgi', 'Dzhikiya', null, null, 'Spartak Moskva', 'Rus'],
            ['Andrei', 'Semenov', null, null, 'Ahmat', 'Rus'],
            ['Aleksey', 'Ionov', null, null, 'Krasnodar', 'Rus'],
            ['Roman', 'Zobnin', null, null, 'Spartak Moskva', 'Rus'],
            ['Yuri', 'Zhirkov', null, null, 'Zenit', 'Rus'],
            ['Magomed', 'Ozdoev', null, null, 'Zenit', 'Rus'],
            ['Artem', 'Dzyuba', null, null, 'Zenit', 'Rus'],
            ['Zelimkhan', 'Bakaev', null, null, 'Spartak Moskva', 'Rus'],
            ['Anton', 'Miranchuk', null, null, 'Lokomotiv Moskva', 'Rus'],
            ['Roman', 'Neustädter', null, null, 'Dinamo Moskva', 'Rus'],
            ['Daler', 'Kuzyaev', null, null, 'Zenit', 'Rus']
        ];

        foreach ($igraciRusija as $igrac) {
            Igrac::create([
                'ime' => $igrac[0],
                'prezime' => $igrac[1],
                'tim_id' => $rusija->id,
                'broj_dresa' => $igrac[2],
                'pozicija' => $igrac[3],
                'klub' => $igrac[4],
                'drzava_kluba' => $igrac[5]
            ]);
        }

        // 7. Kreiranje igrača za Srbiju
        $igraciSrbija = [
            ['Marko', 'Dmitrović', 14, 'GK', 'Eibar', 'Esp'],
            ['Nikola', 'Milenković', 19, 'DF', 'Fiorentina', 'Ita'],
            ['Nikola', 'Maksimović', 24, 'DF', 'Napoli', 'Ita'],
            ['Strahinja', 'Pavlović', 1, 'DF', 'Monaco', 'Fra'],
            ['Nemanja', 'Maksimović', 20, 'MF', 'Getafe', 'Esp'],
            ['Nemanja', 'Gudelj', 26, 'MF', 'Sevilla', 'Esp'],
            ['Darko', 'Lazović', 10, 'MF', 'Verona', 'Ita'],
            ['Sergej', 'Milinković-Savić', 16, 'MF', 'Lazio', 'Ita'],
            ['Filip', 'Kostić', 33, 'MF', 'Eintracht Frankfurt', 'Ger'],
            ['Dušan', 'Tadić', 68, 'FW', 'Ajax', 'Ned'],
            ['Aleksandar', 'Mitrović', 56, 'FW', 'Fulham', 'Eng'],
            ['Aleksandar', 'Kolarov', 91, 'DF', 'Roma', 'Ita'],
            ['Filip', 'Đuričić', 26, 'MF', 'Sassuolo', 'Ita'],
            ['Adem', 'Ljajić', 46, 'MF', 'Besiktas', 'Tur']
        ];

        foreach ($igraciSrbija as $igrac) {
            Igrac::create([
                'ime' => $igrac[0],
                'prezime' => $igrac[1],
                'tim_id' => $srbija->id,
                'broj_dresa' => $igrac[2],
                'pozicija' => $igrac[3],
                'klub' => $igrac[4],
                'drzava_kluba' => $igrac[5]
            ]);
        }

        // 8. Kreiranje strelaca i golova
        $igracDzyuba = Igrac::where('prezime', 'Dzyuba')->first();
        $igracKaravaev = Igrac::where('prezime', 'Karavaev')->first();
        $igracMitrovic = Igrac::where('prezime', 'Mitrović')->first();

        // Golovi
        Gol::create(['utakmica_id' => $utakmica->id, 'igrac_id' => $igracDzyuba->id, 'tim_id' => $rusija->id, 'minut' => 48, 'penal' => true, 'auto_gol' => false]);
        Gol::create(['utakmica_id' => $utakmica->id, 'igrac_id' => $igracDzyuba->id, 'tim_id' => $rusija->id, 'minut' => 69, 'penal' => false, 'auto_gol' => false]);
        Gol::create(['utakmica_id' => $utakmica->id, 'igrac_id' => $igracKaravaev->id, 'tim_id' => $rusija->id, 'minut' => 81, 'penal' => false, 'auto_gol' => false]);
        Gol::create(['utakmica_id' => $utakmica->id, 'igrac_id' => $igracMitrovic->id, 'tim_id' => $srbija->id, 'minut' => 78, 'penal' => false, 'auto_gol' => false]);

        // 9. Kreiranje izmena
        $igracMiranchuk = Igrac::where('prezime', 'Miranchuk')->first();
        $igracBakaev = Igrac::where('prezime', 'Bakaev')->first();
        $igracNeustaedter = Igrac::where('prezime', 'Neustädter')->first(); 
        $igracSemyonov = Igrac::where('prezime', 'Semenov')->first();
        $igracKuzyaev = Igrac::where('prezime', 'Kuzyaev')->first();
        $igracZhirkov = Igrac::where('prezime', 'Zhirkov')->first();

        $igracKolarov = Igrac::where('prezime', 'Kolarov')->first();
        $igracPavlovic = Igrac::where('prezime', 'Pavlović')->first();
        $igracDjuricic = Igrac::where('prezime', 'Đuričić')->first();
        $igracMilinkovicSavic = Igrac::where('prezime', 'Milinković-Savić')->first();
        $igracLjajic = Igrac::where('prezime', 'Ljajić')->first();
        $igracNMaksimovic = Igrac::where('prezime', 'Maksimović')->where('ime', 'Nemanja')->first();

        // Izmene za Rusiju
        Izmena::create(['utakmica_id' => $utakmica->id, 'tim_id' => $rusija->id, 'igrac_out_id' => $igracBakaev->id, 'igrac_in_id' => $igracMiranchuk->id, 'minut' => 68]);
        Izmena::create(['utakmica_id' => $utakmica->id, 'tim_id' => $rusija->id, 'igrac_out_id' => $igracSemyonov->id, 'igrac_in_id' => $igracNeustaedter->id, 'minut' => 77]);
        Izmena::create(['utakmica_id' => $utakmica->id, 'tim_id' => $rusija->id, 'igrac_out_id' => $igracZhirkov->id, 'igrac_in_id' => $igracKuzyaev->id, 'minut' => 80]);

        // Izmene za Srbiju
        Izmena::create(['utakmica_id' => $utakmica->id, 'tim_id' => $srbija->id, 'igrac_out_id' => $igracPavlovic->id, 'igrac_in_id' => $igracKolarov->id, 'minut' => 64]);
        Izmena::create(['utakmica_id' => $utakmica->id, 'tim_id' => $srbija->id, 'igrac_out_id' => $igracMilinkovicSavic->id, 'igrac_in_id' => $igracDjuricic->id, 'minut' => 65]);
        Izmena::create(['utakmica_id' => $utakmica->id, 'tim_id' => $srbija->id, 'igrac_out_id' => $igracNMaksimovic->id, 'igrac_in_id' => $igracLjajic->id, 'minut' => 85]);

        // 10. Kreiranje žutih kartona
        $igracPavlovic = Igrac::where('prezime', 'Pavlović')->first();
        $igracNMaksimovic = Igrac::where('prezime', 'Maksimović')->where('ime', 'Nemanja')->first();

        Karton::create(['utakmica_id' => $utakmica->id, 'igrac_id' => $igracPavlovic->id, 'tim_id' => $srbija->id, 'tip' => 'zuti', 'minut' => 55]);
        Karton::create(['utakmica_id' => $utakmica->id, 'igrac_id' => $igracNMaksimovic->id, 'tim_id' => $srbija->id, 'tip' => 'zuti', 'minut' => 63]);

        // 11. Kreiranje sastava (startnih 11)
        // Rusija startnih 11
        $rusijaStartnihIgraca = ['Shunin', 'Fernandes', 'Karavaev', 'Dzhikiya', 'Semenov', 'Ionov', 'Zobnin', 'Zhirkov', 'Ozdoev', 'Dzyuba', 'Bakaev'];
        foreach ($rusijaStartnihIgraca as $prezime) {
            $igrac = Igrac::where('prezime', $prezime)->where('tim_id', $rusija->id)->first();
            Sastav::create([
                'utakmica_id' => $utakmica->id,
                'tim_id' => $rusija->id,
                'igrac_id' => $igrac->id,
                'starter' => true,
                'selektor' => 'Stanislav Cherchesov'
            ]);
        }

        // Srbija startnih 11
        $srbijaStartnihIgraca = ['Dmitrović', 'Milenković', 'Maksimović', 'Pavlović', 'Maksimović', 'Gudelj', 'Lazović', 'Milinković-Savić', 'Kostić', 'Tadić', 'Mitrović'];
        foreach ($srbijaStartnihIgraca as $prezime) {
            $igrac = Igrac::where('prezime', $prezime)->where('tim_id', $srbija->id)->first();
            if ($prezime == 'Maksimović' && $igrac->ime == 'Nikola') {
                continue; // Preskačemo jednog Maksimovića jer imamo dva u listi
            }
            Sastav::create([
                'utakmica_id' => $utakmica->id,
                'tim_id' => $srbija->id,
                'igrac_id' => $igrac->id,
                'starter' => true,
                'selektor' => 'Ljubiša Tumbaković'
            ]);
        }
    }
}