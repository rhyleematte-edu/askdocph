const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/auth.js', 'public/js')
   .js('resources/js/dashboard.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [])
   .postCss('resources/css/auth.css', 'public/css', [])
   .postCss('resources/css/dashboard.css', 'public/css', [])
   .postCss('resources/css/messenger.css', 'public/css', [])
   .postCss('resources/css/sdashboard.css', 'public/css', []);



