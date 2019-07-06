const mix = require('laravel-mix');
require('laravel-mix-bundle-analyzer');

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

mix.options({
  terser: {
    terserOptions: {
      compress: false
    }
  }
});

mix.react('resources/assets/js/app.js', 'public/js');

mix.styles(
  ['resources/assets/css/mapbox-gl.css', 'resources/assets/css/app.css'],
  'public/css/app.css'
);

if (mix.inProduction()) {
  mix.version();
}

if (!mix.inProduction()) {
  mix.sourceMaps();
}

if (!mix.inProduction()) {
  mix.bundleAnalyzer();
}
