const {mix} = require('laravel-mix');

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


mix.js('resources/assets/js/app.js', 'public/assets/js')
    .sass('resources/assets/sass/app.scss', 'public/assets/css')
    .extract(['vue', 'axios', 'vue-numeric', 'chart.js', 'vuelidate'])
    .sourceMaps()
    .options({
        processCssUrls: false
    });

// mix.copyDirectory('resources/vendor/unity/html/assets/figures', 'public/assets/figures')
