const mix = require('laravel-mix');

mix.copy('resources/icons', 'public/css/icons');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.sourceMaps();
mix.browserSync('127.0.0.1:8000');
