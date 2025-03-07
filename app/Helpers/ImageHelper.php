<?php
/**
 * Funkcija za ispravno generisanje URL-a za slike
 * Smestiti u app/Helpers/ImageHelper.php
 */

namespace App\Helpers;

class ImageHelper
{
    /**
     * Generiše ispravnu putanju za sliku
     *
     * @param string|null $imagePath Putanja do slike
     * @param string $defaultImage Podrazumevana slika ako je original null
     * @return string Ispravna URL putanja do slike
     */
    public static function imageUrl($imagePath, $defaultImage = 'images/no-image.png')
    {
        if (empty($imagePath)) {
            return asset($defaultImage);
        }
        
        // Ako putanja počinje sa http:// ili https://, to je već puni URL
        if (preg_match('/^https?:\/\//', $imagePath)) {
            return $imagePath;
        }
        
        // Ako putanja počinje sa 'storage/', to je relativna putanja iz storage foldera 
        if (strpos($imagePath, 'storage/') === 0) {
            return asset($imagePath);
        }
        
        // Za sve ostale slučajeve, pretpostavljamo da je to putanja unutar public/storage
        return asset('storage/' . $imagePath);
    }
}