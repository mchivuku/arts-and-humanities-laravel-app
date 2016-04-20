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
    mix.scripts([
            '../bower_components/datatables.net/js/jquery.dataTables.js',
            '../bower_components/datatables.net-zf/js/dataTables.foundation.js'],
        "public/js/table.min.js"
    );

    mix.scripts([
            '../bower_components/foundation/js/foundation/foundation.reveal.js',
            '../js/artsbl.js'

         ],
        "public/js/app.min.js"
    );
});



elixir(function(mix) {

    mix.styles([
        '../bower_components/datatables.net-zf/css/dataTables.foundation.min.css',
        '../sass/app.css',
     ], 'public/css/app.min.css')
});



elixir(function(mix) {
    mix.copy([
        'resources/assets/bower_components/foundation/css/foundation.min.css'], 'public/css/foundation.min.css')

    mix.copy([
        'resources/assets/bower_components/foundation-datepicker/css/foundation-datepicker.min.css'], 'public/css/foundation-datepicker.min.css')
    mix.copy([
        'resources/assets/bower_components/foundation-datepicker/js/foundation-datepicker.min.js'], 'public/js/foundation-datepicker.min.js')
});
