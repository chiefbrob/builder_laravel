const mix = require('laravel-mix');
let url = require('url');

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
const appUrl = url.parse(process.env.APP_URL || '');

if (process.env.MIX_HOT_HTTPS) {
  require('laravel-mix-valet');
  mix.valet(appUrl.host || appUrl.path);
}

mix
  .js('resources/js/app.js', 'public/js')
  .vue()
  .js('resources/js/main.js', 'public/js')
  .vue()
  .sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/main.scss', 'public/css')
  .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts');

mix.version();
