<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class PopulateIgraciSlugs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Get all igraci without slugs
        $igraci = DB::table('igraci')->whereNull('slug')->orWhere('slug', '')->get();
        
        foreach ($igraci as $igrac) {
            $slug = $this->generateSlug($igrac->prezime, $igrac->ime, $igrac->id);
            
            DB::table('igraci')
                ->where('id', $igrac->id)
                ->update(['slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Set all slugs to null
        DB::table('igraci')->update(['slug' => null]);
    }
    
    /**
     * Generate SEO friendly slug from prezime and ime
     */
    private function generateSlug($prezime, $ime, $currentId = null)
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
        
        while (DB::table('igraci')->where('slug', $text)->where('id', '!=', $currentId ?? 0)->exists()) {
            $text = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $text;
    }
}