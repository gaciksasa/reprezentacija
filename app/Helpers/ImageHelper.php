<?php

if (!function_exists('image_url')) {
    function image_url($path, $default = 'img/no-image.png') {
        if (empty($path)) {
            return asset($default);
        }
        
        if (preg_match('/^https?:\/\//', $path)) {
            return $path;
        }
        
        if (strpos($path, 'storage/') === 0) {
            return asset($path);
        }
        
        return asset('storage/' . $path);
    }
}

if (!function_exists('zastava_url')) {
    function zastava_url($path, $default = 'img/no-image.png') {
        if (empty($path)) {
            return asset($default);
        }
        
        if (preg_match('/^https?:\/\//', $path)) {
            return $path;
        }
        
        if (strpos($path, 'storage/zastave/') === 0) {
            return asset($path);
        }
        
        return asset('storage/zastave/' . $path);
    }
}

if (!function_exists('grb_url')) {
    function grb_url($path, $default = 'img/no-image.png') {
        if (empty($path)) {
            return asset($default);
        }
        
        if (preg_match('/^https?:\/\//', $path)) {
            return $path;
        }
        
        if (strpos($path, 'storage/grbovi/') === 0) {
            return asset($path);
        }
        
        return asset('storage/grbovi/' . $path);
    }
}