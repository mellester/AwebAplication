const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
const { createProxyMiddleware } = require('http-proxy-middleware');


mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .sourceMaps()
    .webpackConfig(require('./webpack.config'));

const { URL } = require('url');
mix.browserSync({
    proxy: {
        target: 'http://localhost:80',
        proxyOptions: {
            xfwd: true // !important set headers to genrate correct linsk 
        },
        proxyRes: [
            function (proxyRes, req, res) {
                const ourProxyHost = 'localhost:3000';
                let headers = proxyRes.headers;
                let location = headers['location']
                if (location) {
                    let theUrl = new URL(location, 'http://' + ourProxyHost + '/');
                    theUrl.host = ourProxyHost;
                    proxyRes.headers['location'] = theUrl.href;
                }
            }
        ],
        //ws: true, // forward websockets does not work
    },
    // socket: { // the socket were broswer-syncs polls from 
    //     domain: 'localhost:3567',
    //     port: 3567,
    // },
    port: 3000, //The port to acces
    ui: {
        port: 8080, // port for the Ui intergace of browsersync
    },
    open: false, // do not open a browser winwdow
    files: ["public/js/*"],
});