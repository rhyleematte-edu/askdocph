<?php

if (!function_exists('secure_asset')) {
    /**
     * Generate a secure HTTPS asset URL.
     *
     * @param string $path
     * @return string
     */
    function secure_asset($path)
    {
        // Build full asset path
        $assetPath = 'assets/' . ltrim($path, '/');
        
        // Use Laravel's asset helper with proper URL generation
        $url = asset($assetPath);
        
        // Force HTTPS
        return preg_replace('/^http:/', 'https:', $url);
    }
}
