
// generated using lava-tabler

const mix = require('laravel-mix');

mix
    .js('resources/assets/js/tabler.js', 'public/js')

    .sass('resources/assets/scss/tabler.scss', 'public/css')

    .copyDirectory('resources/assets/img', 'public/img')

    .copyDirectory('resources/assets/svg', 'public/svg')

    .copyDirectory('resources/assets/static', 'public/static')

    .setPublicPath('public')
    
    .version();
