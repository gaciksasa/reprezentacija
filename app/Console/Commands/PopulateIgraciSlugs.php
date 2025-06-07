<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Igrac;

class PopulateIgraciSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'igraci:populate-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate slugs for existing igraci';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting to populate slugs for igraci...');
        
        $igraci = Igrac::whereNull('slug')->orWhere('slug', '')->get();
        
        if ($igraci->isEmpty()) {
            $this->info('All igraci already have slugs.');
            return 0;
        }
        
        $bar = $this->output->createProgressBar($igraci->count());
        $bar->start();
        
        foreach ($igraci as $igrac) {
            $slug = $this->generateSlug($igrac->prezime, $igrac->ime, $igrac->id);
            $igrac->update(['slug' => $slug]);
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info("Successfully populated slugs for {$igraci->count()} igraci.");
        
        return 0;
    }
    
    /**
     * Generate SEO friendly slug from prezime and ime
     */
    private function generateSlug($prezime, $ime, $igracId = null)
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
        
        while (Igrac::where('slug', $text)->where('id', '!=', $igracId ?? 0)->exists()) {
            $text = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $text;
    }
}