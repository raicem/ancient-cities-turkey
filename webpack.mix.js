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
//    .sass('resources/assets/sass/app.scss', 'public/css');

mix.options({
  uglify: {
    uglifyOptions: {
      compress: false,
    },
  },
});

mix.react('resources/assets/js/app.js', 'public/js');

if (mix.inProduction()) {
  mix.version();
}
