const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
   .js('node_modules/bootstrap-select/js/bootstrap-select.js','public/js')
   //.js('node_modules/bootstrap-select/js/umd-intro.js','public/js')
   //.js('node_modules/bootstrap-select/js/umd-outro.js','public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .sass('node_modules/bootstrap-select/sass/bootstrap-select.scss','public/css')
   .copy('node_modules/bootstrap-select/sass/bootstrap-select.scss','public/css/bootstrap-select.scss')
   .copy('node_modules/bootstrap-select/js/bootstrap-select.js','public/js/bootstrap-select.js')
   .sass('node_modules/bootstrap-select/sass/variables.scss','public/css');
   
