
let mix = require('laravel-mix');



mix
    .js(['resources/js/app.js'], 'public/js')
// .js('resources/js/admin.js', 'public/js/admin.js')
mix.scripts('resources/js/admin.js', 'public/js/admin.js')
mix.sass('resources/sass/app.scss', 'public/css')


//
// let mix = require('laravel-mix');
//
//
//
// mix.scripts(['resources/js/app.js'], '/public/js/app.js')
//     .babel(['resources/js/admin.js'], '/public/js/admin.js')  /* Lecture 4 */
//     .sass('resources/sass/app.scss', '/public/css')
//     .options({
//         processCssUrls: false /* Lecture 4 */
//     });





//
// let mix = require('laravel-mix');
//
//
//
// mix.js(['resources/js/app.js'], 'public/js')
//
//
// mix.babel('resources/js/admin.js', 'public/js/admin.js')  /* Lecture 4 */
// mix.scripts('resources/js/admin.js', 'public/js/admin.js')  /* Lecture 4 */
//
//
//
// mix.sass('resources/sass/app.scss', 'public/css')
