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
        // Use Laravel's asset() function but force HTTPS
        $fullPath = 'assets/' . ltrim($path, '/');
        $assetUrl = asset($fullPath);
        return str_replace('http://', 'https://', $assetUrl);
    }
}
