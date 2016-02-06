var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.styles([
        'bootstrap.css',
        'sb-admin.css',
        'plugins/morris.css',
        'plugins/font-awesome.css'
    ], 'public/assets/css/style.css');

    mix.scripts([
        'jquery.js',
        'bootstrap.js',
        'plugins/morris/raphael.min.js',
        'plugins/morris/morris.min.js',
        'plugins/morris/morris-data.js'
    ], 'public/assets/js/javascript.js');
});
