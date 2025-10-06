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

mix.sass('resources/sass/style.scss', 'public/assets/css')
    .combine('public/assets/css/style.css', 'public/assets/css/style.css')
    .copyDirectory('resources/sass/icons/', 'public/assets/css/icons/')
    .copyDirectory('resources/fonts/', 'public/assets/fonts/');