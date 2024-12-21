const mix = require('laravel-mix');

/*
 |----------------------------------------------------------------------
 | Mix Asset Management
 |----------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// Mengompilasi JavaScript dan SCSS Anda
mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')

// Menyalin jQuery, Bootstrap, dan Font Awesome dari node_modules ke public/vendor
   .copy('node_modules/jquery/dist/jquery.min.js', 'public/vendor/jquery/jquery.min.js')
   .copy('node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/vendor/bootstrap/css/bootstrap.min.css')
   .copy('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', 'public/vendor/bootstrap/js/bootstrap.bundle.min.js')
   .copy('node_modules/font-awesome/css/font-awesome.min.css', 'public/vendor/font-awesome/css/font-awesome.min.css');
