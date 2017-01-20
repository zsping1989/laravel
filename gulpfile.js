var elixir = require('laravel-elixir');
elixir.config.sourcemaps = false;

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
    mix.sass('app.scss');
});

elixir(function(mix) {
    mix.less([
        'app.less'
    ]);
});

//合并js
elixir(function(mix) {
    mix.scriptsIn('public/bower_components/angular-fengtingxun/src','public/bower_components/angular-fengtingxun/dist/angular-fengtingxun.js');
});






